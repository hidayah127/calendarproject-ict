<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Carbon\Carbon;

class ProgramController extends Controller
{

    public function index(Request $request)
    {
        /* ── Selected Filters ── */

        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', '');


        /* ── Build Query ── */

        $query = Program::with(['staffInCharge'])
            ->where('created_by', Auth::id())
            ->whereYear('start_date', $selectedYear);


        if ($selectedMonth) {

            $query->whereMonth(
                'start_date',
                $selectedMonth
            );

        }


        $programs = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();


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


        return view(
            'Head.Program',
            compact(
                'programs',
                'yearOptions',
                'monthOptions',
                'selectedYear',
                'selectedMonth'
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
        $staffList = Staff::orderBy('name')->get();

        return view('Head.Program-Create', compact('staffList'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store — save new program
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
{
    $user = Auth::user();

    $rules = [
        'title'              => 'required|string|max:255',
        'description'        => 'nullable|string',
        'venue'              => 'required|string|max:255',
        'start_date'         => 'required|date',
        'end_date'           => 'required|date|after_or_equal:start_date',
        'staff_in_charge_id' => 'nullable|exists:staff,id',
        'category'           => 'nullable|in:mind,fitness,spiritual,social,Marketing,Meeting,Event',
    ];

    $validated = $request->validate($rules);

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

        'category'      => $request->category,
        'created_by'    => $user->id,
        'department_id' => $user->staff->department_id ?? null,
        'status'        => $status,
    ]);

    NotificationService::programCreated(Auth::id(), $program->title, $program->id);

    return redirect()
        ->route('head.programs.index')
        ->with('success', 'Program created successfully.');
}
    // public function store(Request $request)
    // {
        

    //     $user = Auth::user();

    //     $rules = [
    //         'title'              => 'required|string|max:255',
    //         'description'        => 'nullable|string',
    //         'venue'              => 'required|string|max:255',
    //         'start_date'         => 'required|date',
    //         'end_date'           => 'required|date|after_or_equal:start_date',
    //         'staff_in_charge_id' => 'nullable|exists:staff,id',
    //         'category'           => 'nullable|in:mind,fitness,spiritual,social,Marketing,Meeting,Event',
    //     ];

       

    //     $validated = $request->validate($rules);

        
    //     $program = Program::create([
    //         ...$validated,

           
    //         'category' => $request->category,

    //         'created_by'    => $user->id,
    //         'department_id' => $user->staff->department_id ?? null,
    //         'status'        => 'upcoming',
    //     ]);

    //     NotificationService::programCreated(Auth::id(), $program->title, $program->id);

    //     return redirect()
    //         ->route('head.programs.index')
    //         ->with('success', 'Program created successfully.');
    // }

    /*
    |--------------------------------------------------------------------------
    | Edit — show edit form
    |--------------------------------------------------------------------------
    */
    public function edit(Program $program)
    {
        $this->authorise($program);

        $staffList = Staff::orderBy('name')->get();

        return view('Head.programs.edit', compact('program', 'staffList'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update — save edited program details
    |--------------------------------------------------------------------------
    */
    // public function update(Request $request, Program $program)
    // {
    //     $this->authorise($program);

    //     $validated = $request->validate([
    //         'title'              => 'required|string|max:255',
    //         'description'        => 'nullable|string',
    //         'venue'              => 'required|string|max:255',
    //         'start_date'         => 'required|date',
    //         'end_date'           => 'required|date|after_or_equal:start_date',
    //         'staff_in_charge_id' => 'nullable|exists:staff,id',
    //     ]);

    //     $program->update($validated);

    //     return redirect()
    //         ->route('head.programs.index')
    //         ->with('success', 'Program updated successfully.');
    // }

    // public function update(Request $request, Program $program)
    // {
    //     $this->authorise($program);

    //     $user = Auth::user();

    //     /* ── Validation Rules ── */

    //     $rules = [
    //         'title'              => 'required|string|max:255',
    //         'description'        => 'nullable|string',
    //         'venue'              => 'required|string|max:255',
    //         'start_date'         => 'required|date',
    //         'end_date'           => 'required|date|after_or_equal:start_date',
    //         'staff_in_charge_id' => 'nullable|exists:staff,id',
    //     ];

    //     /* Only AZ role needs category */
    //     // if ($user->role === 'az') {
    //     //     $rules['category'] = 'required|in:mind,fitness,spiritual,social';
    //     // }

    //     /* Category required for ALL roles */
    //     $rules['category'] = 'required|in:mind,fitness,spiritual,social,Marketing,Meeting,Event';

    //     $validated = $request->validate($rules);

    //     /* ── Update Program ── */

    //     $program->update([
    //         ...$validated,

    //         // Save category only for AZ
    //         // 'category' => $user->role === 'az'
    //         //                 ? $request->category
    //         //                 : null,

    //         'category' => $request->category,
    //     ]);

    //     return redirect()
    //         ->route('head.programs.index')
    //         ->with('success', 'Program updated successfully.');
    // }

    public function update(Request $request, Program $program)
{
    $this->authorise($program);

    $user = Auth::user();

    $rules = [
        'title'              => 'required|string|max:255',
        'description'        => 'nullable|string',
        'venue'              => 'required|string|max:255',
        'start_date'         => 'required|date',
        'end_date'           => 'required|date|after_or_equal:start_date',
        'staff_in_charge_id' => 'nullable|exists:staff,id',
        'category'           => 'required|in:mind,fitness,spiritual,social,Marketing,Meeting,Event',
    ];

    $validated = $request->validate($rules);

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
        'status'   => $status,
    ]);

    return redirect()
        ->route('head.programs.index')
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

        NotificationService::programRescheduled(Auth::id(), $program->title, $program->id);


        return redirect()
            ->route('head.programs.index')
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

        NotificationService::programCancelled(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('head.programs.index')
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
            ->route('head.programs.index')
            ->with('success', 'Program deleted successfully.');
    }

    public function committee()
    {
        $programs = Program::where('created_by', Auth::id())
            ->with(['department', 'staffInCharge', 'committee'])
            ->orderBy('start_date', 'desc')
            ->get();

        return view('Head.programs-committee', compact('programs'));
    }

 
    /*
    |--------------------------------------------------------------------------
    | Helper — ensure head owns the program
    |--------------------------------------------------------------------------
    */
    private function authorise(Program $program): void
    {
        if ($program->created_by !== Auth::id()) {
            abort(403, 'Unauthorised action.');
        }
    }
}
