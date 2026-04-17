<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $programs = Program::with(['department', 'staffInCharge'])
            ->orderBy('start_date', 'desc')
            ->get();

        $departments = Department::withCount('programs')
            ->orderBy('name')
            ->get();

        // ── Weekend staff alert data ──
        $weekendAlert = $this->getWeekendAlert();

        return view('vc.dashboard', compact('programs', 'departments', 'weekendAlert'));

        // return view('VC.Dashboard', compact('programs', 'departments'));
    }

     // ─────────────────────────────────────────────────────
    // Get programs in the next 14 days that touch a weekend
    // ─────────────────────────────────────────────────────
    private function getWeekendAlert(): array
    {
        $now  = Carbon::now();
        $soon = $now->copy()->addDays(14);

        $weekendPrograms = Program::with(['department', 'committee'])
            ->whereIn('status', ['upcoming', 'ongoing', 'rescheduled'])
            ->where('start_date', '<=', $soon)
            ->get()
            ->filter(fn($p) => $this->touchesWeekend($p))
            ->values();

        // Collect unique staff across all those programs
        $staffSet = collect();
        foreach ($weekendPrograms as $p) {
            foreach ($p->committee as $m) {
                $staffSet->put($m->id, [
                    'name'     => $m->name,
                    'initials' => strtoupper(substr($m->name, 0, 2)),
                    'dept'     => $m->department->name ?? '—',
                    'program'  => $p->title,
                    'is_lead'  => (bool) $m->pivot->is_lead,
                    'role'     => $m->pivot->role,
                ]);
            }
        }

        // Nearest weekend program
        $nearest     = $weekendPrograms->sortBy('start_date')->first();
        $nearestDays = $nearest ? $this->getWeekendDays($nearest) : [];

        return [
            'program_count' => $weekendPrograms->count(),
            'staff_count'   => $staffSet->count(),
            'staff'         => $staffSet->take(6)->values()->toArray(),
            'nearest'       => $nearest ? [
                'title'        => $nearest->title,
                'dept'         => $nearest->department->name ?? '—',
                'start'        => $nearest->start_date->format('d M Y'),
                'status'       => $nearest->status,
                'weekend_days' => collect($nearestDays)->pluck('short')->implode(', '),
                'member_count' => $nearest->committee->count(),
            ] : null,
        ];
    }

    private function touchesWeekend(Program $program): bool
    {
        $current = $program->start_date->copy()->startOfDay();
        $end     = $program->end_date->copy()->startOfDay();
        while ($current->lte($end)) {
            if ($current->isWeekend()) return true;
            $current->addDay();
        }
        return false;
    }

    private function getWeekendDays(Program $program): array
    {
        $days    = [];
        $current = $program->start_date->copy()->startOfDay();
        $end     = $program->end_date->copy()->startOfDay();
        while ($current->lte($end)) {
            if ($current->isWeekend()) {
                $days[] = ['short' => $current->format('D, d M')];
            }
            $current->addDay();
        }
        return $days;
    }
}
