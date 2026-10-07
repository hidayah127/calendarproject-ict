<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;
use Carbon\Carbon;

class ProgramController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Helper — amt_scc can see and manage programs from ALL departments
    |--------------------------------------------------------------------------
    */
    private function isScc(): bool
    {
        return Auth::user()?->username === 'amt_scc';
    }

    /* Users amt_scc can assign a program to (department comes from their staff record) */
    private function assignableUsers()
    {
        return $this->isScc()
            ? User::with('staff.department')->orderBy('name')->get()
            : collect();
    }

    /*
    |--------------------------------------------------------------------------
    | Index — list programs
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /* ── Selected Filters ── */
        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', '');

        /* ── Base query (filters + scope), shared by the list and the counts ── */
        $base = Program::query()
            ->whereYear('start_date', $selectedYear);

        // Normal users only see their own programs; amt_scc sees everything
        if (!$this->isScc()) {
            $base->where('created_by', Auth::id());
        }

        if ($selectedMonth) {
            $base->whereMonth('start_date', $selectedMonth);
        }

        /* ── Summary counts across ALL matching programs (not just this page) ── */
        // withStatus() is the Program scope that mirrors getStatusAttribute() in SQL
        $counts = [
            'total'       => (clone $base)->count(),
            'upcoming'    => (clone $base)->withStatus('upcoming')->count(),
            'ongoing'     => (clone $base)->withStatus('ongoing')->count(),
            'completed'   => (clone $base)->withStatus('completed')->count(),
            'rescheduled' => (clone $base)->withStatus('rescheduled')->count(),
            'cancelled'   => (clone $base)->withStatus('cancelled')->count(),
        ];

        $programs = (clone $base)
            ->with(['staffInCharge', 'department'])
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
                'label' => date('F', mktime(0, 0, 0, $m, 1)),
            ];
        }

        $isScc = $this->isScc();
        $users = $this->assignableUsers();

        return view(
            'Head.Program',
            compact(
                'programs',
                'yearOptions',
                'monthOptions',
                'selectedYear',
                'selectedMonth',
                'isScc',
                'users',
                'counts'
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
        $isScc     = $this->isScc();
        $users     = $this->assignableUsers();

        return view('Head.Program-Create', compact('staffList', 'isScc', 'users'));
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
            'category'           => 'nullable|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event,Workshop',
        ];

        // amt_scc must pick the user the program is assigned to
        if ($this->isScc()) {
            $rules['created_by'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        // Owner = assigned user (amt_scc) or the logged-in user (everyone else)
        $owner = $this->isScc()
            ? User::with('staff')->findOrFail($validated['created_by'])
            : $user;

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
            ...Arr::except($validated, ['created_by']),

            'category'      => $request->category,
            'created_by'    => $owner->id,
            'department_id' => $owner->staff->department_id ?? null,
            'status'        => $status,
        ]);

        NotificationService::programCreated($owner->id, $program->title, $program->id);

        return redirect()
            ->route('head.programs.index')
            ->with('success', 'Program created successfully.');
    }

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
    public function update(Request $request, Program $program)
    {
        $this->authorise($program);

        $rules = [
            'title'              => 'required|string|max:255',
            'description'        => 'nullable|string',
            'venue'              => 'required|string|max:255',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after_or_equal:start_date',
            'staff_in_charge_id' => 'nullable|exists:staff,id',
            'category'           => 'required|in:mind,fitness,spiritual,social,Marketing,inmeeting,exmeeting,Event,Workshop',
        ];

        if ($this->isScc()) {
            $rules['created_by'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

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

        $data = [
            ...Arr::except($validated, ['created_by']),
            'category' => $request->category,
            'status'   => $status,
        ];

        // amt_scc can re-assign the program; department follows the new user
        if ($this->isScc()) {
            $owner = User::with('staff')->findOrFail($validated['created_by']);

            $data['created_by']    = $owner->id;
            $data['department_id'] = $owner->staff->department_id ?? null;
        }

        $program->update($data);

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

    /*
    |--------------------------------------------------------------------------
    | Committee overview
    |--------------------------------------------------------------------------
    */
    public function committee()
    {
        $programs = Program::with(['department', 'staffInCharge', 'committee'])
            ->when(!$this->isScc(), fn ($q) => $q->where('created_by', Auth::id()))
            ->orderBy('start_date', 'desc')
            ->get();

        return view('Head.programs-committee', compact('programs'));
    }

    /*
    |--------------------------------------------------------------------------
    | Helper — ensure head owns the program (amt_scc bypasses)
    |--------------------------------------------------------------------------
    */
    private function authorise(Program $program): void
    {
        if ($this->isScc()) {
            return;
        }

        if ($program->created_by !== Auth::id()) {
            abort(403, 'Unauthorised action.');
        }
    }
}