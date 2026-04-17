<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class ProgramController extends Controller
{
/*
    |--------------------------------------------------------------------------
    | Index — list all programs created by this head
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $programs = Program::with(['staffInCharge', 'department'])
            ->where('created_by', Auth::id())
            ->latest()
            ->paginate(10);

        return view('head.Program', compact('programs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create — show create form
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $staffList = Staff::orderBy('name')->get();

        return view('head.Program-Create', compact('staffList'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store — save new program
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
        ]);

        $user = Auth::user();

        $program = Program::create([
            ...$validated,
            'created_by'    => $user->id,
            'department_id' => $user->staff->department_id ?? null,
            'status'        => 'upcoming',
        ]);

        NotificationService::programCreated(Auth::id(), $program->title, $program->id);

        return redirect()
            ->route('head.programs.index')
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

        $staffList = Staff::orderBy('name')->get();

        return view('head.programs.edit', compact('program', 'staffList'));
    }

    /*
    |--------------------------------------------------------------------------
    | Update — save edited program details
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Program $program)
    {
        $this->authorise($program);

        $validated = $request->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
        ]);

        $program->update($validated);

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

        return view('head.Programs-Committee', compact('programs'));
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
