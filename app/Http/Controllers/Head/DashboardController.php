<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $programs = Program::where('created_by', $user->id);

        $totalPrograms = $programs->count();
        $upcoming      = (clone $programs)->where('status', 'upcoming')->count();
        $ongoing       = (clone $programs)->where('status', 'ongoing')->count();
        $completed     = (clone $programs)->where('status', 'completed')->count();
        $rescheduled   = (clone $programs)->where('status', 'rescheduled')->count();
        $cancelled     = (clone $programs)->where('status', 'cancelled')->count();

        $recentPrograms = Program::where('created_by', $user->id)
            ->with('staffInCharge')
            ->latest()
            ->take(5)
            ->get();

        return view('Head.Dashboard', compact(
            'totalPrograms',
            'upcoming',
            'ongoing',
            'completed',
            'rescheduled',
            'cancelled',
            'recentPrograms',
        ));
    }
}
