<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NonWeekendStaffController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input(
            'month', 
            Carbon::createFromDate(
                $selectedYear, 
                now()->month, 1
                )->format('Y-m')
        );

        $selectedDept  = $request->input('dept', '');

        $monthDate  = Carbon::parse($selectedMonth . '-01');
        $monthStart = $monthDate->copy()->startOfMonth();
        $monthEnd   = $monthDate->copy()->endOfMonth();

        $departments = Department::orderBy('name')->get();

        // All staff (optionally filtered by dept)
        $staffQuery = Staff::with('department');
        if ($selectedDept) {
            $staffQuery->where('department_id', $selectedDept);
        }
        $allStaff = $staffQuery->orderBy('name')->get();

        // Programs that run during the selected month AND touch a weekend
        $weekendPrograms = Program::with(['committee', 'department'])
            ->where(function ($q) use ($monthStart, $monthEnd) {
                $q->whereBetween('start_date', [$monthStart, $monthEnd])
                  ->orWhereBetween('end_date',   [$monthStart, $monthEnd])
                  ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                      $q2->where('start_date', '<=', $monthStart)
                         ->where('end_date',   '>=', $monthEnd);
                  });
            })
            ->get()
            ->filter(fn($p) => $this->touchesWeekendInMonth($p, $monthStart, $monthEnd));

        // Staff IDs who ARE working weekends this month
        $weekendStaffIds = collect();
        foreach ($weekendPrograms as $prog) {
            foreach ($prog->committee as $member) {
                $weekendStaffIds->push($member->id);
            }
        }
        $weekendStaffIds = $weekendStaffIds->unique()->values();

        // Staff NOT working weekends = all staff minus weekend staff
        $nonWeekendStaff = $allStaff->filter(
            fn($s) => !$weekendStaffIds->contains($s->id)
        )->values();

        // Group non-weekend staff by department
        $byDepartment = $nonWeekendStaff->groupBy('department_id')->map(function ($staffGroup, $deptId) use ($departments) {
            $dept = $departments->firstWhere('id', $deptId);
            return [
                'dept_id'   => $deptId,
                'dept_name' => $dept?->name ?? 'Unknown',
                'dept_code' => $dept?->code ?? '—',
                'staff'     => $staffGroup->map(fn($s) => [
                    'id'       => $s->id,
                    'name'     => $s->name,
                    'staff_id' => $s->staff_id,
                    'position' => $s->position ?? '—',
                    'initials' => strtoupper(substr($s->name, 0, 2)),
                ])->values(),
                'count'     => $staffGroup->count(),
            ];
        })->sortByDesc('count')->values();

        // Stats
        $totalAllStaff       = $allStaff->count();
        $totalWeekendStaff   = $weekendStaffIds->count();
        $totalNonWeekend     = $nonWeekendStaff->count();
        $weekendPct          = $totalAllStaff > 0 ? round(($totalWeekendStaff / $totalAllStaff) * 100) : 0;
        $nonWeekendPct       = $totalAllStaff > 0 ? round(($totalNonWeekend / $totalAllStaff) * 100) : 0;

        // Build month options (current year ± 1 year)
        // $monthOptions = [];
        // $start = now()->subYear()->startOfMonth();
        // $end   = now()->addYear()->endOfMonth();
        // $cur   = $start->copy();
        // while ($cur->lte($end)) {
        //     $monthOptions[] = [
        //         'value' => $cur->format('Y-m'),
        //         'label' => $cur->format('F Y'),
        //     ];
        //     $cur->addMonth();
        // }

        /* ── Year Options ── */
        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }


        /* ── Month Options based on selected year ── */

        $monthOptions = [];

        if ($selectedYear == $currentYear) {

            // Current year → Jan until current month
            $lastMonth = now()->month;

        } else {

            // Other year → Full Jan to Dec
            $lastMonth = 12;

        }

        for ($m = 1; $m <= $lastMonth; $m++) {

            $date = Carbon::createFromDate(
                $selectedYear,
                $m,
                1
            );

            $monthOptions[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y'),
            ];
        }


        // Weekend days in selected month (for context)
        $weekendDaysInMonth = $this->getWeekendDaysInMonth($monthStart, $monthEnd);

        return view('vc.non-weekend-staff', compact(
            'nonWeekendStaff',
            'byDepartment',
            'departments',
            'selectedMonth',
            'selectedDept',
            'monthDate',
            'totalAllStaff',
            'totalWeekendStaff',
            'totalNonWeekend',
            'weekendPct',
            'nonWeekendPct',
            'weekendPrograms',
            'weekendDaysInMonth',
            'monthOptions',
            'yearOptions',
            'selectedYear'
        ));
    }

    private function touchesWeekendInMonth(Program $program, Carbon $monthStart, Carbon $monthEnd): bool
    {
        $current = $program->start_date->copy()->startOfDay()->max($monthStart);
        $end     = $program->end_date->copy()->startOfDay()->min($monthEnd);

        while ($current->lte($end)) {
            if ($current->isWeekend()) return true;
            $current->addDay();
        }
        return false;
    }

    private function getWeekendDaysInMonth(Carbon $monthStart, Carbon $monthEnd): array
    {
        $days    = [];
        $current = $monthStart->copy();
        while ($current->lte($monthEnd)) {
            if ($current->isWeekend()) {
                $days[] = [
                    'date'  => $current->format('d M'),
                    'day'   => $current->format('l'),
                    'full'  => $current->format('D, d M Y'),
                ];
            }
            $current->addDay();
        }
        return $days;
    }
}
 