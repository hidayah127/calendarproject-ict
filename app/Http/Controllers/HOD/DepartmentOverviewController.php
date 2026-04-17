<?php

namespace App\Http\Controllers\HOD;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MeritClaim;
use App\Models\Program;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DepartmentOverviewController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     // HOD's department — derived from their staff record
    //     $hodStaff  = Staff::where('user_id', $user->id)->first();
    //     $deptId    = $hodStaff?->department_id;
    //     $department= Department::findOrFail($deptId);

    //     // All staff in this department
    //     $staffList = Staff::with(['department'])
    //         ->where('department_id', $deptId)
    //         ->orderBy('name')
    //         ->get();

    //     $staffIds = $staffList->pluck('id');

    //     // Programs this department's staff are committee members in
    //     $programsRaw = Program::with(['department', 'staffInCharge', 'committee'])
    //         ->whereHas('committee', fn($q) => $q->whereIn('staff_id', $staffIds))
    //         ->orWhere('department_id', $deptId)
    //         ->with(['committee' => fn($q) => $q->whereIn('staff_id', $staffIds)])
    //         ->orderBy('start_date', 'desc')
    //         ->get()
    //         ->unique('id');

    //     // Approved merit claims for dept staff
    //     $meritClaims = MeritClaim::with('program')
    //         ->whereIn('staff_id', $staffIds)
    //         ->where('status', 'approved')
    //         ->get();

    //     // Build per-staff data
    //     $staffData = $staffList->map(function ($staff) use ($programsRaw, $meritClaims) {

    //         // Programs this staff is in (via committee)
    //         $staffPrograms = $programsRaw->filter(function ($p) use ($staff) {
    //             return $p->committee->contains('id', $staff->id);
    //         })->values();

    //         // Weekend programs
    //         $weekendPrograms = $staffPrograms->filter(fn($p) => $this->touchesWeekend($p))->values();

    //         // Merit
    //         $staffMerits = $meritClaims->where('staff_id', $staff->id);
    //         $totalMerits = $staffMerits->sum('merit_points');

    //         return [
    //             'id'               => $staff->id,
    //             'name'             => $staff->name,
    //             'staff_id'         => $staff->staff_id,
    //             'position'         => $staff->position ?? '—',
    //             'initials'         => strtoupper(substr($staff->name, 0, 2)),
    //             'programs'         => $staffPrograms->map(fn($p) => $this->formatProgram($p, $staff->id))->values(),
    //             'weekend_programs' => $weekendPrograms->map(fn($p) => $this->formatProgram($p, $staff->id))->values(),
    //             'total_merits'     => $totalMerits,
    //             'merit_claims'     => $staffMerits->values(),
    //             'program_count'    => $staffPrograms->count(),
    //             'weekend_count'    => $weekendPrograms->count(),
    //         ];
    //     })->sortByDesc('total_merits')->values();

    //     // Department-level stats
    //     $totalStaff           = $staffList->count();
    //     $totalPrograms        = $programsRaw->count();
    //     $totalMeritsAwarded   = $meritClaims->sum('merit_points');
    //     $staffOnWeekend       = $staffData->filter(fn($s) => $s['weekend_count'] > 0)->count();
    //     $maxMerits            = max($staffData->max('total_merits') ?? 1, 1);

    //     $roleLabels = MeritClaim::$claimLabels;
    //     $roleIcons  = MeritClaim::$claimIcons;

    //     return view('HOD.department-overview', compact(
    //         'department',
    //         'staffData',
    //         'totalStaff',
    //         'totalPrograms',
    //         'totalMeritsAwarded',
    //         'staffOnWeekend',
    //         'maxMerits',
    //         'roleLabels',
    //         'roleIcons',
    //     ));
    // }

    public function index()
    {
        // ✅ Get logged in user's department
        $departmentId = Auth::user()->staff->department_id;

        // Get department info
        $department = Department::findOrFail($departmentId);

        // ✅ Get staff under department
        $staffList = Staff::with([
                'department',
                'user'
            ])
            ->where('department_id', $departmentId)
            // ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $staffIds = $staffList->pluck('id');

        // ✅ Programs involving department staff
        $programsRaw = Program::with([
                'department',
                'staffInCharge',
                'committee'
            ])
            ->where(function ($query) use ($staffIds, $departmentId) {

                $query->whereHas('committee', function ($q) use ($staffIds) {

                    // FIX ambiguous column error
                    $q->whereIn(
                        'program_staff.staff_id',
                        $staffIds
                    );

                })
                ->orWhere('department_id', $departmentId);

            })
            ->with([
                'committee' => function ($q) use ($staffIds) {

                    $q->whereIn(
                        'program_staff.staff_id',
                        $staffIds
                    );

                }
            ])
            ->orderBy('start_date', 'desc')
            ->get()
            ->unique('id');

        // ✅ Approved merit claims
        $meritClaims = MeritClaim::with('program')
            ->whereIn('staff_id', $staffIds)
            ->where('status', 'approved')
            ->get();

        // ✅ Build per-staff data
        $staffData = $staffList->map(function ($staff) use ($programsRaw, $meritClaims) {

            // Programs staff joined
            $staffPrograms = $programsRaw
                ->filter(function ($p) use ($staff) {

                    return $p->committee
                        ->contains('id', $staff->id);

                })
                ->values();

            // Weekend programs
            $weekendPrograms = $staffPrograms
                ->filter(fn($p) => $this->touchesWeekend($p))
                ->values();

            // Merit calculation
            $staffMerits = $meritClaims
                ->where('staff_id', $staff->id);

            $totalMerits = $staffMerits
                ->sum('merit_points');

            return [

                'id'               => $staff->id,
                'name'             => $staff->name,
                'staff_id'         => $staff->staff_id,
                'position'         => $staff->position ?? '—',
                'user_role'        => $staff->user->role ?? null,
                'initials'         => strtoupper(substr($staff->name, 0, 2)),

                'programs'         => $staffPrograms
                    ->map(fn($p) =>
                        $this->formatProgram($p, $staff->id)
                    )
                    ->values(),

                'weekend_programs' => $weekendPrograms
                    ->map(fn($p) =>
                        $this->formatProgram($p, $staff->id)
                    )
                    ->values(),

                'total_merits'     => $totalMerits,
                'merit_claims'     => $staffMerits->values(),
                'program_count'    => $staffPrograms->count(),
                'weekend_count'    => $weekendPrograms->count(),

            ];

        })->sortByDesc('total_merits')->values();


        // ✅ Department stats
        $totalStaff         = $staffList->count();
        $totalPrograms      = $programsRaw->count();
        $totalMeritsAwarded = $meritClaims->sum('merit_points');

        $staffOnWeekend = $staffData
            ->filter(fn($s) =>
                $s['weekend_count'] > 0
            )->count();

        $maxMerits = max(
            $staffData->max('total_merits') ?? 1,
            1
        );

        $roleLabels = MeritClaim::$claimLabels;
        $roleIcons  = MeritClaim::$claimIcons;

        return view('HOD.department-overview', compact(
            'department',
            'staffData',
            'totalStaff',
            'totalPrograms',
            'totalMeritsAwarded',
            'staffOnWeekend',
            'maxMerits',
            'roleLabels',
            'roleIcons',
        ));
    }

    private function formatProgram(Program $program, int $staffId): array
    {
        $member      = $program->committee->firstWhere('id', $staffId);
        $weekendDays = $this->getWeekendDays($program);

        return [
            'id'           => $program->id,
            'title'        => $program->title,
            'venue'        => $program->venue,
            'status'       => $program->status,
            'department'   => $program->department->name ?? '—',
            'start_date'   => $program->start_date->format('d M Y'),
            'end_date'     => $program->end_date->format('d M Y'),
            'start_time'   => $program->start_date->format('h:i A'),
            'end_time'     => $program->end_date->format('h:i A'),
            'start_full'   => $program->start_date->format('D, d M Y · h:i A'),
            'end_full'     => $program->end_date->format('D, d M Y · h:i A'),
            'role'         => $member?->pivot->role ?? '—',
            'is_lead'      => (bool) ($member?->pivot->is_lead ?? false),
            'responsibility'=> $member?->pivot->responsibility ?? '',
            'weekend_days' => $weekendDays,
            'is_weekend'   => count($weekendDays) > 0,
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
                $days[] = [
                    'date'  => $current->format('d M Y'),
                    'day'   => $current->format('l'),
                    'short' => $current->format('D, d M'),
                ];
            }
            $current->addDay();
        }
        return $days;
    }
}
