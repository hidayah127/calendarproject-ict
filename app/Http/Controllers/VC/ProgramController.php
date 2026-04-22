<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;

class ProgramController extends Controller
{


    public function index(Request $request)
    {
        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', '');

        $roleLabels = [
            'committee_head'   => 'Committee Head',
            'coordinator'      => 'Coordinator',
            'secretary'        => 'Secretary',
            'treasurer'        => 'Treasurer',
            'facilitator'      => 'Facilitator',
            'committee_member' => 'Committee Member',
        ];

        // $programs = Program::with(['department', 'staffInCharge', 'committee'])
        //     ->orderBy('start_date', 'desc')
        //     ->get();

        $query = Program::with(['department', 'staffInCharge', 'committee'])
            ->whereYear('start_date', $selectedYear);

        if ($selectedMonth) {
            $query->whereMonth('start_date', $selectedMonth);
        }

        $programs = $query
            ->orderBy('start_date', 'desc')
            ->get();

        $departments = Department::orderBy('name')->get();

        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        $monthOptions = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthOptions[] = [
                'value' => $m,
                'label' => date('F', mktime(0,0,0,$m,1))
            ];
        }

        // Build plain array — no closures in Blade
        $programsJson = [];
        foreach ($programs as $p) {
            $members = [];
            if ($p->committee) {
                foreach ($p->committee->sortByDesc('pivot.is_lead') as $m) {
                    $members[] = [
                        'name'           => $m->name,
                        'initials'       => strtoupper(substr($m->name, 0, 2)),
                        'position'       => $m->position ?? $m->staff_id ?? '',
                        'role'           => $m->pivot->role,
                        'role_label'     => $roleLabels[$m->pivot->role] ?? ucfirst($m->pivot->role),
                        'responsibility' => $m->pivot->responsibility ?? '',
                        'is_lead'        => (bool) $m->pivot->is_lead,
                    ];
                }
            }
            $programsJson[$p->id] = [
                'id'        => $p->id,
                'committee' => $members,
            ];
        }

        return view('vc.programs', compact(
            'programs', 
            'departments', 
            'programsJson', 
            'yearOptions', 
            'monthOptions',
            'selectedYear',
            'selectedMonth'

            ));
    }

    public function calendar()
    {
        $programs = Program::with(['department', 'staffInCharge'])
            ->orderBy('start_date')
            ->get();

        $departments = Department::orderBy('name')->get();

        return view('VC.calendar', compact('programs', 'departments'));
    }
}
