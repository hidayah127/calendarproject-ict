<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeekendStaffController extends Controller
{
    public function index(Request $request)
    {
        /* ── Selected Year & Month ── */
        $selectedYear = $request->input('year', now()->year);

        $selectedMonth = $request->input(
            'month',
            Carbon::createFromDate(
                $selectedYear,
                now()->month,
                1
            )->format('Y-m')
        );

        $monthDate  = Carbon::parse($selectedMonth . '-01');
        $monthStart = $monthDate->copy()->startOfMonth();
        $monthEnd   = $monthDate->copy()->endOfMonth();
        
        $departments = Department::orderBy('name')->get();

        /* ── Year Options ── */
        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        /* ── Month Options ── */
        $monthOptions = [];

        if ($selectedYear == $currentYear) {

            $lastMonth = now()->month;

        } else {

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

        // Get all programs that have at least one day falling on a weekend
        // $programs = Program::with(['department', 'committee', 'staffInCharge'])
        //     ->get()  
        //     ->filter(function ($p) {
        //         return $this->programTouchesWeekend($p);
        //     });

        $programs = Program::with(['department', 'committee', 'staffInCharge'])

        ->where(function ($q) use ($monthStart, $monthEnd) {

            $q->whereBetween('start_date', [$monthStart, $monthEnd])

            ->orWhereBetween('end_date', [$monthStart, $monthEnd])

            ->orWhere(function ($q2) use ($monthStart, $monthEnd) {

                $q2->where('start_date', '<=', $monthStart)
                    ->where('end_date', '>=', $monthEnd);

            });

        })

        ->get()

        ->filter(function ($p) {
            return $this->programTouchesWeekend($p);
        });

        // Build weekend staff data grouped by staff
        $weekendStaff = [];

        foreach ($programs as $program) {
            $weekendDays = $this->getWeekendDays($program);

            foreach ($program->committee as $member) {
                $staffId = $member->id;

                if (!isset($weekendStaff[$staffId])) {
                    $weekendStaff[$staffId] = [
                        'id'          => $member->id,
                        'name'        => $member->name,
                        'staff_id'    => $member->staff_id,
                        'position'    => $member->position ?? '—',
                        'department'  => $member->department->name ?? '—',
                        'dept_id'     => $member->department_id,
                        'programs'    => [],
                        'total_days'  => 0,
                        'saturdays'   => 0,
                        'sundays'     => 0,
                    ];
                }

                $satCount = collect($weekendDays)->where('day', 'Saturday')->count();
                $sunCount = collect($weekendDays)->where('day', 'Sunday')->count();

                $weekendStaff[$staffId]['programs'][] = [
                    'id'           => $program->id,
                    'title'        => $program->title,
                    'venue'        => $program->venue,
                    'status'       => $program->status,
                    'role'         => $member->pivot->role,
                    'role_label'   => $this->roleLabel($member->pivot->role),
                    'is_lead'      => (bool) $member->pivot->is_lead,
                    'responsibility'=> $member->pivot->responsibility ?? '',
                    'start_date'   => $program->start_date->format('d M Y'),
                    'end_date'     => $program->end_date->format('d M Y'),
                    'weekend_days' => $weekendDays,
                    'dept'         => $program->department->name ?? '—',
                ];

                $weekendStaff[$staffId]['total_days'] += count($weekendDays);
                $weekendStaff[$staffId]['saturdays']  += $satCount;
                $weekendStaff[$staffId]['sundays']    += $sunCount;
            }
        }

        // Sort by most weekend days
        usort($weekendStaff, fn($a, $b) => $b['total_days'] - $a['total_days']);

        // Summary stats
        $totalWeekendStaff    = count($weekendStaff);
        $totalWeekendPrograms = $programs->count();
        $totalWeekendDays     = array_sum(array_column($weekendStaff, 'total_days'));
        $mostWeekendStaff     = $totalWeekendStaff > 0 ? $weekendStaff[0] : null;

        return view('vc.weekend-staff', compact(
            'weekendStaff',
            'departments',
            'totalWeekendStaff',
            'totalWeekendPrograms',
            'totalWeekendDays',
            'mostWeekendStaff',
            'yearOptions',
            'monthOptions',
            'selectedYear',
            'selectedMonth',
            'monthDate'
        ));
    }

    /**
     * Check if a program has any day (start to end) falling on Sat or Sun.
     */
    private function programTouchesWeekend(Program $program): bool
    {
        $current = $program->start_date->copy()->startOfDay();
        $end     = $program->end_date->copy()->startOfDay();

        while ($current->lte($end)) {
            if ($current->isWeekend()) return true;
            $current->addDay();
        }

        return false;
    }

    /**
     * Return all weekend days (Sat/Sun) within a program's date range.
     */
    private function getWeekendDays(Program $program): array
    {
        $days    = [];
        $current = $program->start_date->copy()->startOfDay();
        $end     = $program->end_date->copy()->startOfDay();

        while ($current->lte($end)) {
            if ($current->isWeekend()) {
                $days[] = [
                    'date'  => $current->format('d M Y'),
                    'day'   => $current->format('l'), // Saturday / Sunday
                    'short' => $current->format('D, d M'),
                ];
            }
            $current->addDay();
        }

        return $days;
    }

    private function roleLabel(string $role): string
    {
        return match($role) {
            'committee_head'   => 'Committee Head',
            'coordinator'      => 'Coordinator',
            'secretary'        => 'Secretary',
            'treasurer'        => 'Treasurer',
            'facilitator'      => 'Facilitator',
            'committee_member' => 'Committee Member',
            default            => ucfirst($role),
        };
    }
}
