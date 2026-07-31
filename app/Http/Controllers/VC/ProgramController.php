<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        $query = Program::with(['department', 'staffInCharge', 'committee'])
            ->whereYear('start_date', $selectedYear);

        if ($selectedMonth) {
            $query->whereMonth('start_date', $selectedMonth);
        }

        $programs = $query
            ->orderBy('start_date', 'desc')
            ->get();

        $departments = Department::orderBy('name')->get();

        // Needed for the Edit modal's user / staff-in-charge dropdowns
        $users = User::with('staff.department')
            ->whereHas('staff.department')
            ->orderBy('name')
            ->get();

        $staffList = Staff::orderBy('name')->get();

        // id -> department name, so the Edit modal can auto-derive department client-side
        $usersJson = [];
        foreach ($users as $u) {
            $usersJson[$u->id] = [
                'name'       => $u->name,
                'department' => $u->staff->department->name ?? null,
            ];
        }

        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        $monthOptions = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthOptions[] = [
                'value' => $m,
                'label' => date('F', mktime(0, 0, 0, $m, 1))
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
                'id'                 => $p->id,
                'title'              => $p->title,
                'description'        => $p->description,
                'venue'              => $p->venue,
                'start_date'         => $p->start_date->format('Y-m-d\TH:i'),
                'end_date'           => $p->end_date->format('Y-m-d\TH:i'),
                'created_by'         => $p->created_by,
                'staff_in_charge_id' => $p->staff_in_charge_id,
                'category'           => $p->category,
                'committee'          => $members,
            ];
        }

        $weeklyPrograms = [
            'Week 1' => [],
            'Week 2' => [],
            'Week 3' => [],
            'Week 4' => [],
        ];

        foreach ($programs as $p) {

            if ($selectedMonth && $p->start_date->month != $selectedMonth) {
                continue;
            }

            $week = ceil($p->start_date->day / 7);
            $label = 'Week ' . $week;

            $weeklyPrograms[$label][] = $p;
        }

        $monthlyPrograms = $programs->sortBy('start_date');

        return view('VC.programs', compact(
            'programs',
            'departments',
            'users',
            'staffList',
            'usersJson',
            'programsJson',
            'yearOptions',
            'monthOptions',
            'selectedYear',
            'selectedMonth',
            'weeklyPrograms',
            'monthlyPrograms'
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

    public function create()
    {
        $departments = Department::orderBy('name')->get();

        $users = User::with('staff.department')
            ->whereHas('staff.department')
            ->orderBy('name')
            ->get();

        $staffList = Staff::orderBy('name')->get();

        return view('VC.program-create', compact(
            'departments',
            'users',
            'staffList'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'created_by'         => 'required|exists:users,id',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
            'category'           => 'nullable|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event,Workshop',
        ];

        $validated = $request->validate($rules);

        // Derive department server-side — never trust a posted department_id
        $assignedUser = User::with('staff.department')->findOrFail($validated['created_by']);
        $departmentId = $assignedUser->staff->department_id ?? null;

        if (!$departmentId) {
            return back()->withInput()->withErrors([
                'created_by' => 'Selected user has no staff record or department assigned.',
            ]);
        }

        $now = Carbon::now();

        if ($now->between(
            Carbon::parse($validated['start_date']),
            Carbon::parse($validated['end_date'])
        )) {
            $status = 'ongoing';
        } elseif ($now->lt(Carbon::parse($validated['start_date']))) {
            $status = 'upcoming';
        } else {
            $status = 'completed';
        }

        $program = Program::create([
            ...$validated,
            'department_id' => $departmentId,
            'status'        => $status,
        ]);

        // NotificationService::programCreated(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('vc.programs')
            ->with('success', 'Program created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Edit — show edit form
    |--------------------------------------------------------------------------
    | NOTE: swapped to a VC-namespaced view + redirect so this lines up with
    | the VC.programs list page. If you already have a dedicated
    | Admin.programs.edit view/route you want reused instead, revert the
    | view() call below and the redirect targets in update()/reschedule()/
    | cancel()/destroy() back to their admin.* equivalents.
    |--------------------------------------------------------------------------
    */
    public function edit(Program $program)
    {
       // $this->authorise($program);

        $users       = User::with('staff.department')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $staffList   = Staff::orderBy('name')->get();

        return view('VC.program-edit', compact('program', 'departments', 'users', 'staffList'));
    }

    public function update(Request $request, Program $program)
    {
       // $this->authorise($program);

        $rules = [
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'created_by'         => 'required|exists:users,id',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
            'category'           => 'required|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event,Workshop',
        ];

        $validated = $request->validate($rules);

        // Derive department server-side from the selected user — never trust posted department_id
        $assignedUser = User::with('staff.department')->findOrFail($validated['created_by']);
        $departmentId = $assignedUser->staff->department_id ?? null;

        if (!$departmentId) {
            return back()->withInput()->withErrors([
                'created_by' => 'Selected user has no staff record or department assigned.',
            ]);
        }

        $now       = Carbon::now();
        $startDate = Carbon::parse($validated['start_date']);
        $endDate   = Carbon::parse($validated['end_date']);

        if ($now->between($startDate, $endDate)) {
            $status = 'ongoing';
        } elseif ($now->lt($startDate)) {
            $status = 'upcoming';
        } else {
            $status = 'completed';
        }

        $program->update([
            ...$validated,
            'category'      => $request->category,
            'department_id' => $departmentId,
            'status'        => $status,
        ]);

        return redirect()
            ->route('vc.programs')
            ->with('success', 'Program updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule — update dates only, flips status to "rescheduled"
    |--------------------------------------------------------------------------
    */
    public function reschedule(Request $request, Program $program)
    {
        //$this->authorise($program);

        if (in_array($program->status, ['cancelled', 'completed'])) {
            return back()->with('error', 'This program cannot be rescheduled.');
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $program->update([
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'status'     => 'rescheduled',
        ]);

        // NotificationService::programRescheduled(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('vc.programs')
            ->with('success', 'Program rescheduled successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel — mark as cancelled
    |--------------------------------------------------------------------------
    */
    public function cancel(Program $program)
    {
    //    $this->authorise($program);

        if ($program->status === 'cancelled') {
            return back()->with('error', 'Program is already cancelled.');
        }

        $program->update(['status' => 'cancelled']);

        // NotificationService::programCancelled(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('vc.programs')
            ->with('success', 'Program has been cancelled.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy — permanently delete
    |--------------------------------------------------------------------------
    */
    public function destroy(Program $program)
    {
      //  $this->authorise($program);

        $program->delete();

        return redirect()
            ->route('vc.programs')
            ->with('success', 'Program deleted successfully.');
    }
}
