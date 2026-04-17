<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;

class ProgramController extends Controller
{
    // public function index()
    // {
    //     $programs = Program::with([
    //             'department',
    //             'staffInCharge',
    //             'committee',    // ← eager load committee + pivot data
    //         ])
    //         ->orderBy('start_date', 'desc')
    //         ->get();

    //     $departments = Department::orderBy('name')->get();

    //     return view('vc.programs', compact('programs', 'departments'));
    // }

    // public function index()
    // {
    //     $programs = Program::with(['department', 'staffInCharge', 'committee'])
    //         ->orderBy('start_date', 'desc')
    //         ->get();

    //     $departments = Department::orderBy('name')->get();

    //     $roleLabels = [
    //         'committee_head'   => 'Committee Head',
    //         'coordinator'      => 'Coordinator',
    //         'secretary'        => 'Secretary',
    //         'treasurer'        => 'Treasurer',
    //         'facilitator'      => 'Facilitator',
    //         'committee_member' => 'Committee Member',
    //     ];

    //     // ✅ Build clean array — no closures in Blade
    //     $programsJson = [];
    //     foreach ($programs as $p) {
    //         $members = [];
    //         if ($p->committee) {
    //             foreach ($p->committee->sortByDesc('pivot.is_lead') as $m) {
    //                 $members[] = [
    //                     'name'           => $m->name,
    //                     'initials'       => strtoupper(substr($m->name, 0, 2)),
    //                     'position'       => $m->position ?? $m->staff_id,
    //                     'role'           => $m->pivot->role,
    //                     'role_label'     => $roleLabels[$m->pivot->role] ?? ucfirst($m->pivot->role),
    //                     'responsibility' => $m->pivot->responsibility ?? '',
    //                     'is_lead'        => (bool) $m->pivot->is_lead,
    //                 ];
    //             }
    //         }
    //         $programsJson[$p->id] = [
    //             'id'        => $p->id,
    //             'committee' => $members,
    //         ];
    //     }

    //     return view('vc.programs', compact('programs', 'departments', 'programsJson'));
    // }

    public function index()
    {
        $roleLabels = [
            'committee_head'   => 'Committee Head',
            'coordinator'      => 'Coordinator',
            'secretary'        => 'Secretary',
            'treasurer'        => 'Treasurer',
            'facilitator'      => 'Facilitator',
            'committee_member' => 'Committee Member',
        ];

        $programs = Program::with(['department', 'staffInCharge', 'committee'])
            ->orderBy('start_date', 'desc')
            ->get();

        $departments = Department::orderBy('name')->get();

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

        return view('vc.programs', compact('programs', 'departments', 'programsJson'));
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
