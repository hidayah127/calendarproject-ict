<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        // Pass programs as JSON for FullCalendar
        $programs = Program::where('created_by', Auth::id())
            ->get()
            ->map(function ($p) {
                return [
                    'id'              => $p->id,
                    'title'           => $p->title,
                    'start'           => $p->start_date->toIso8601String(),
                    'end'             => $p->end_date->toIso8601String(),
                    'status'          => $p->status,
                    'venue'           => $p->venue,
                    'description'     => $p->description,
                    // 'edit_url'        => route('head.programs.index', $p->id),
                    // Redirect to index with a query param, then auto-open the edit modal via JS
                    'edit_url' => route('head.programs.index') . '?edit=' . $p->id,
                    'backgroundColor' => match($p->status) {
                        'upcoming'    => '#3b82f6',
                        'ongoing'     => '#16a34a',
                        'completed'   => '#6366f1',
                        'rescheduled' => '#f59e0b',
                        'cancelled'   => '#ef4444',
                        default       => '#3b82f6',
                    },
                    'borderColor'     => match($p->status) {
                        'upcoming'    => '#1d4ed8',
                        'ongoing'     => '#15803d',
                        'completed'   => '#4338ca',
                        'rescheduled' => '#b45309',
                        'cancelled'   => '#b91c1c',
                        default       => '#1d4ed8',
                    },
                    'textColor'       => '#ffffff',
                ];
            });

        return view('Head.calendar', compact('programs'));
    }
}
