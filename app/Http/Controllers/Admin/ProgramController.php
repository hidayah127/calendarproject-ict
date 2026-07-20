<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Staff;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
// use App\Services\NotificationService;
use Carbon\Carbon;

class ProgramController extends Controller
{

    public function index(Request $request)
    {
        /* ── Selected Filters ── */

        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', '');
        $selectedCategory = $request->input('category', '');
        $selectedDepartment = $request->input('department', '');


        /* ── Build Query ── */

        $query = Program::with(['staffInCharge', 'department'])
            // ->where('created_by', Auth::id())
            ->whereYear('start_date', $selectedYear);


        if ($selectedMonth) {

            $query->whereMonth(
                'start_date',
                $selectedMonth
            );

        }

      

        if ($selectedDepartment) {

            $query->where('department_id', $selectedDepartment);

        }

        $departments = Department::orderBy('name')->get();

        if ($selectedCategory) {

            $query->where('category', $selectedCategory);

        }


        $programs = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $departments = Department::orderBy('name')->get();
        $users = User::with('staff.department')->orderBy('name')->get(); // NEW


        /* ── Year Options ── */

        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {

            $yearOptions[] = $y;

        }


        /* ── Month Options ── */

        $monthOptions = [];

        for ($m = 1; $m <= 12; $m++) {

            $monthOptions[] = [
                'value' => $m,
                'label' => date(
                    'F',
                    mktime(0,0,0,$m,1)
                )
            ];

        }

        $categoryOptions = [
            'mind',
            'fitness',
            'spiritual',
            'social',
            'Marketing',
            'Meeting',
            'Event',
        ];




        return view(
            'Admin.Program',
            compact(
                'programs',
                'departments',
                'users',
                'yearOptions',
                'monthOptions',
                'selectedYear',
                'selectedMonth',
                'selectedDepartment',
                'selectedCategory',
                'categoryOptions'
            )
        );
    }
  
    /*
    |--------------------------------------------------------------------------
    | Create — show create form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        $staffList = Staff::orderBy('name')->get();

         // eager load staff -> department so we can read department per user
        $users = User::with('staff.department')->orderBy('name')->get(); // NEW


        return view('Admin.Program-Create', compact( 'departments','staffList', 'users'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store — save new program
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $admin = Auth::user();

        $rules = [
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'created_by'            => 'required|exists:users,id',
         //   'department_id'      => 'required|exists:departments,id',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
            'category'           => 'nullable|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event',
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

        // Determine status
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

      //  NotificationService::programCreated(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Edit — show edit form
    |--------------------------------------------------------------------------
    */
    public function edit(Program $program)
    {
        $this->authorise($program);
        
        $users       = User::with('staff.department')->orderBy('name')->get(); // NEW
        $departments = Department::orderBy('name')->get();
        $staffList = Staff::orderBy('name')->get();

        return view('Admin.programs.edit', compact('program','departments','users', 'staffList'));
    }

 

    public function update(Request $request, Program $program)
{
    $this->authorise($program);

   // $user = Auth::user();

    $rules = [
        'title'              => 'required|string|max:255',
        'description'        => 'nullable|string',
        'venue'              => 'required|string|max:255',
        'start_date'         => 'required|date',
        'end_date'           => 'required|date|after_or_equal:start_date',
        'created_by'            => 'required|exists:users,id', // replaces department_id in rules,
        'staff_in_charge_id' => 'nullable|exists:staff,id',
        'category'           => 'required|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event',
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
    
    $now = Carbon::now();
    $startDate = Carbon::parse($validated['start_date']);
    $endDate = Carbon::parse($validated['end_date']);

    if ($now->between($startDate, $endDate)) {
        $status = 'ongoing';
    } elseif ($now->lt($startDate)) {
        $status = 'upcoming';
    } else {
        $status = 'completed';
    }

    $program->update([
        ...$validated,
        'category' => $request->category,
        'department_id' => $departmentId, //auto derived from created_by
        'status'   => $status,
    ]);

    return redirect()
        ->route('admin.programs.index')
        ->with('success', 'Program updated successfully.');
}

    /*
    |--------------------------------------------------------------------------
    | Reschedule — update dates only
    |--------------------------------------------------------------------------
    */
    public function reschedule(Request $request, Program $program)
    {
        $this->authorise($program);

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
            ->route('admin.programs.index')
            ->with('success', 'Program rescheduled successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel — mark as cancelled
    |--------------------------------------------------------------------------
    */
    public function cancel(Program $program)
    {
        $this->authorise($program);

        if ($program->status === 'cancelled') {
            return back()->with('error', 'Program is already cancelled.');
        }

        $program->update(['status' => 'cancelled']);

      //  NotificationService::programCancelled(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program has been cancelled.');

        
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy — permanently delete
    |--------------------------------------------------------------------------
    */
    public function destroy(Program $program)
    {
        $this->authorise($program);

        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    public function committee()
    {
        $programs = Program::where('created_by', Auth::id())
            ->with(['department', 'staffInCharge', 'committee'])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('Admin.programs-committee', compact('programs'));
    }

 
    /*
    |--------------------------------------------------------------------------
    | Helper — ensure admin owns the program
    |--------------------------------------------------------------------------
    */
    private function authorise(Program $program): void
    {
        // if ($program->admin_id !== Auth::id()) {
        //     abort(403, 'Unauthorised action.');
        // }
    }

    // private function authorise(Program $program): void
    // {
    //     dd([
    //         'logged_in_id' => Auth::id(),
    //         'program_created_by' => $program->created_by,
    //         'program_admin_id' => $program->admin_id,
    //     ]);
    // }
}
