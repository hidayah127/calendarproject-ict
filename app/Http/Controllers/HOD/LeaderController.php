<?php

namespace App\Http\Controllers\HOD;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\ProgramStaff;
use App\Models\Staff;
use App\Models\User;
use App\Models\MeritClaim;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Handles everything the "ld" (Leader) role can do:
 *  - Manage programs that belong to the department(s) they were granted access to
 *    (department_access table -> one leader can hold many departments)
 *  - Generate a monthly report per department / across all their departments
 *  - View which staff are scheduled to work on weekends
 *  - Browse a staff directory scoped to their departments
 *  - View a calendar of their programs
 *  - See a "My Departments" overview
 *  - Read / manage their notifications
 *
 * Program create/edit note (mirrors Admin\ProgramController's pattern):
 *  A leader no longer picks a Department directly, and there are two
 *  separate people-fields on the form, both plain server-rendered
 *  <select> elements (no AJAX/select2-remote) populated from $users /
 *  $staffList passed down by dashboard():
 *   - "Assign User" (name="created_by", required) — scoped to users
 *     whose linked staff record (users.staff_id -> staff.id) sits in the
 *     leader's own assigned department(s). Each <option> carries a
 *     data-department-name attribute (from eager-loaded staff.department)
 *     so a plain JS change handler can fill the read-only Department
 *     display field with zero extra requests. Department is always
 *     re-derived server-side from this same chain in the controller —
 *     never trusted from the client.
 *   - "Staff In Charge" (optional) — a purely informational field,
 *     pointing directly at staff.id, NOT scoped to the leader's
 *     department, and has no effect on `created_by` or `department_id`.
 *  The leader's own name is appended into the description, so there's
 *  still a record of who actually raised the program even though
 *  `created_by` points at the assigned user.
 */
class LeaderController extends Controller
{
    /**
     * Department IDs the currently logged in leader has access to, via the
     * department_access pivot table. Memoized so we don't re-query it on
     * every call within the same request.
     */
    private ?\Illuminate\Support\Collection $departmentIdsCache = null;

    private function myDepartmentIds()
    {
        if ($this->departmentIdsCache === null) {
            $this->departmentIdsCache = DB::table('department_access')
                ->where('user_id', auth()->id())
                ->pluck('department_id');
        }

        return $this->departmentIdsCache;
    }

    public function dashboard(Request $request)
    {
        $departmentIds = $this->myDepartmentIds();
        $departments   = Department::whereIn('id', $departmentIds)->orderBy('name')->get();

        // ── Programs table (filterable) ──
        $programsQuery = Program::with(['department', 'staffInCharge'])
            ->whereIn('department_id', $departmentIds);

        if ($request->filled('department_id')) {
            $programsQuery->where('department_id', $request->department_id);
        }
        if ($request->filled('status')) {
            $programsQuery->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $programsQuery->where('category', $request->category);
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $programsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('venue', 'like', "%{$search}%");
            });
        }

        $programs = $programsQuery->orderByDesc('start_date')->paginate(10);

        // ── Stat cards ──
        $stats = [
            'departments'          => $departments->count(),
            'programs'             => Program::whereIn('department_id', $departmentIds)->count(),
            'upcoming_this_month'  => Program::whereIn('department_id', $departmentIds)
                ->whereMonth('start_date', now()->month)
                ->whereYear('start_date', now()->year)
                ->whereIn('status', ['upcoming', 'ongoing'])
                ->count(),
            'weekend_staff'        => $this->weekendStaffQuery($departmentIds)->distinct('staff_id')->count('staff_id'),
        ];

        // ── Weekend staff tab ──
        $weekendMonth = $request->input('weekend_month', now()->format('Y-m'));
        $weekendDept  = $request->input('weekend_department_id');

        $weekendStaff = $this->weekendStaffQuery($departmentIds, $weekendMonth, $weekendDept)
            ->with(['staff', 'program.department'])
            ->get();

        // ── Report summary (default: current month, all my departments) ──
        $reportMonth = $request->input('month', now()->format('Y-m'));
        [$reportSummary, $departmentBreakdown] = $this->buildReportData($departmentIds, $reportMonth);

        // ── "Assign To (User)" / "Staff In Charge" dropdown data ──
        // Same concept as Admin\ProgramController: eager-load users with
        // their staff+department so the Blade can read
        // $u->staff->department->name straight off each <option> via
        // data-department-name, no AJAX round-trip needed.
        //
        // Unlike Admin (which lists ALL users), this is scoped to users
        // whose linked staff record sits in one of the leader's own
        // assigned departments — a leader can only ever assign ownership
        // within their own department(s).
        $users = User::with('staff.department')
            ->whereHas('staff', function ($q) use ($departmentIds) {
                $q->whereIn('department_id', $departmentIds);
            })
            ->orderBy('name')
            ->get();

        // "Staff In Charge" stays purely informational and unscoped, same
        // as Admin — any staff member can be listed here.
        $staffList = Staff::orderBy('name')->get();

        return view('HOD.dashboard', compact(
            'departments',
            'programs',
            'stats',
            'weekendStaff',
            'reportSummary',
            'departmentBreakdown',
            'users',
            'staffList'
        ));
    }

    /**
     * GET /leader/overview
     * An alternate "analytics widget" layout for the same data the tab-based
     * dashboard() shows — single scroll, KPI row + two breakdown bar charts +
     * an agenda-style upcoming list, instead of tabs. Kept as its own route
     * so it can be compared against dashboard() before deciding which one
     * becomes the real landing page.
     */
    public function dashboardAnalytics()
    {
        $departmentIds = $this->myDepartmentIds();
        $departments   = Department::whereIn('id', $departmentIds)->orderBy('name')->get();

        $thisMonth = now()->format('Y-m');
        $lastMonth = now()->subMonthNoOverflow()->format('Y-m');

        [$reportSummary, $departmentBreakdown] = $this->buildReportData($departmentIds, $thisMonth);
        [$lastMonthSummary]                     = $this->buildReportData($departmentIds, $lastMonth);

        $stats = [
            'departments'         => $departments->count(),
            'programs'            => Program::whereIn('department_id', $departmentIds)->count(),
            'upcoming_this_month' => $reportSummary['total'],
            'weekend_staff'       => $this->weekendStaffQuery($departmentIds)->distinct('staff_id')->count('staff_id'),
        ];

        // Month-over-month delta for the hero figure's trend indicator.
        $momDelta = $reportSummary['total'] - $lastMonthSummary['total'];

        // ── Programs by status this month (status-palette bar chart) ──
        $statusCounts = collect(['upcoming', 'ongoing', 'completed', 'rescheduled', 'cancelled'])
            ->mapWithKeys(fn ($status) => [
                $status => Program::whereIn('department_id', $departmentIds)
                    ->whereYear('start_date', now()->year)
                    ->whereMonth('start_date', now()->month)
                    ->where('status', $status)
                    ->count(),
            ]);

        // ── Programs by department this month (single-hue magnitude bar chart) ──
        $departmentCounts = collect($departmentBreakdown)
            ->sortByDesc('total')
            ->take(8)
            ->values();

        // ── Upcoming agenda (next 5 programs, soonest first) ──
        $upcomingPrograms = Program::with('department')
            ->whereIn('department_id', $departmentIds)
            ->where('start_date', '>=', now())
            ->whereIn('status', ['upcoming', 'ongoing'])
            ->orderBy('start_date')
            ->limit(5)
            ->get();

        // ── Next weekend duty roster (soonest weekend programs, capped) ──
        $nextWeekendStaff = $this->weekendStaffQuery($departmentIds)
            ->whereHas('program', fn ($q) => $q->where('start_date', '>=', now()))
            ->with(['staff', 'program.department'])
            ->get()
            ->sortBy(fn ($row) => $row->program->start_date)
            ->take(6)
            ->values();

        // ── Recent notifications mini-feed ──
        $recentNotifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->limit(5)
            ->get();

        return view('HOD.dashboard-analytics', compact(
            'departments',
            'stats',
            'momDelta',
            'statusCounts',
            'departmentCounts',
            'upcomingPrograms',
            'nextWeekendStaff',
            'recentNotifications',
            'reportSummary'
        ));
    }

    /**
     * Base query for program_staff rows whose program falls on a Saturday or Sunday
     * within the leader's departments.
     */
    private function weekendStaffQuery($departmentIds, ?string $yearMonth = null, $departmentId = null)
    {
        $query = ProgramStaff::whereHas('program', function ($q) use ($departmentIds, $yearMonth, $departmentId) {
            $q->whereIn('department_id', $departmentId ? [$departmentId] : $departmentIds)
              ->whereRaw('(DAYOFWEEK(start_date) IN (1,7) OR DAYOFWEEK(end_date) IN (1,7))');

            if ($yearMonth) {
                $date = Carbon::createFromFormat('Y-m', $yearMonth);
                $q->whereYear('start_date', $date->year)
                  ->whereMonth('start_date', $date->month);
            }
        });

        return $query;
    }

    /**
     * Build the aggregated numbers used in the Monthly Report tab.
     */
    private function buildReportData($departmentIds, string $yearMonth)
    {
        $date = Carbon::createFromFormat('Y-m', $yearMonth);

        $base = Program::whereIn('department_id', $departmentIds)
            ->whereYear('start_date', $date->year)
            ->whereMonth('start_date', $date->month);

        $summary = [
            'total'          => (clone $base)->count(),
            'completed'      => (clone $base)->where('status', 'completed')->count(),
            'cancelled'      => (clone $base)->where('status', 'cancelled')->count(),
            'rescheduled'    => (clone $base)->where('status', 'rescheduled')->count(),
            'staff_involved' => ProgramStaff::whereHas('program', function ($q) use ($departmentIds, $date) {
                $q->whereIn('department_id', $departmentIds)
                  ->whereYear('start_date', $date->year)
                  ->whereMonth('start_date', $date->month);
            })->distinct('staff_id')->count('staff_id'),
            'merit_points'   => MeritClaim::where('status', 'approved')
                ->whereHas('program', function ($q) use ($departmentIds, $date) {
                    $q->whereIn('department_id', $departmentIds)
                      ->whereYear('start_date', $date->year)
                      ->whereMonth('start_date', $date->month);
                })->sum('merit_points'),
        ];

        $breakdown = Department::whereIn('id', $departmentIds)->get()->map(function ($dept) use ($date) {
            $deptPrograms = Program::where('department_id', $dept->id)
                ->whereYear('start_date', $date->year)
                ->whereMonth('start_date', $date->month);

            return [
                'name'        => $dept->name,
                'total'       => (clone $deptPrograms)->count(),
                'completed'   => (clone $deptPrograms)->where('status', 'completed')->count(),
                'active'      => (clone $deptPrograms)->whereIn('status', ['upcoming', 'ongoing'])->count(),
                'rescheduled' => (clone $deptPrograms)->where('status', 'rescheduled')->count(),
                'cancelled'   => (clone $deptPrograms)->where('status', 'cancelled')->count(),
            ];
        })->toArray();

        return [$summary, $breakdown];
    }

    /**
     * GET /leader/reports/generate?month=2026-07&department_ids[]=39&format=pdf|excel|preview
     */
    public function generateReport(Request $request)
    {
        $departmentIds = $this->myDepartmentIds();

        // Leaders can only ever export data for departments they were granted.
        $requested = collect($request->input('department_ids', []))->map(fn ($id) => (int) $id);
        $scopedIds = $requested->isEmpty() ? $departmentIds : $departmentIds->intersect($requested);

        $month = $request->input('month', now()->format('Y-m'));
        [$summary, $breakdown] = $this->buildReportData($scopedIds, $month);

        $programs = Program::with('department')
            ->whereIn('department_id', $scopedIds)
            ->whereYear('start_date', Carbon::createFromFormat('Y-m', $month)->year)
            ->whereMonth('start_date', Carbon::createFromFormat('Y-m', $month)->month)
            ->orderBy('start_date')
            ->get();

        $data = [
            'summary'         => $summary,
            'breakdown'       => $breakdown,
            'programs'        => $programs,
            'month'           => $month,
            'monthLabel'      => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
            'departmentNames' => Department::whereIn('id', $scopedIds)->orderBy('name')->pluck('name'),
            'leaderName'      => auth()->user()->name,
            'generatedAt'     => now(),
        ];

        switch ($request->input('format', 'preview')) {
            case 'pdf':
                // Zero-dependency alternative to barryvdh/laravel-dompdf (which
                // isn't installed, hence the "Class not found" error). Instead
                // of generating the PDF server-side, render the report as a
                // normal print-optimized HTML page. HOD/reports/pdf.blade.php
                // has a "Print / Save as PDF" button that calls window.print() —
                // every modern browser's print dialog has a "Save as PDF"
                // destination, so the user gets a PDF with zero PHP libraries.
                //
                // If you'd rather generate the file server-side later (e.g. to
                // email it, or force an automatic download with no click),
                // run `composer require barryvdh/laravel-dompdf`, add
                // `use Barryvdh\DomPDF\Facade\Pdf;` back up top, and swap this
                // return for:
                //   return Pdf::loadView('HOD.reports.pdf', $data)->setPaper('a4', 'portrait')->download("leader-report-{$month}.pdf");
                return view('HOD.reports.pdf', $data);

            case 'excel':
                // requires maatwebsite/excel
                // return Excel::download(new \App\Exports\LeaderMonthlyReportExport($data), "leader-report-{$month}.xlsx");
                return response()->json($data);

            default:
                return redirect()->route('leader.dashboard', ['month' => $month] + $request->only('department_ids'))
                    ->withFragment('tab-reports');
        }
    }

    // ── Program CRUD (scoped to the leader's own departments) ──

    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'venue'               => 'required|string|max:255',
            'start_date'          => 'required|date|after_or_equal:now',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'category'            => 'nullable|string',
            'created_by'          => 'required|exists:users,id',
            'staff_in_charge_id'  => 'nullable|exists:staff,id', // optional, informational only
        ]);

        // Department is never trusted from the client — it's always
        // derived from the ASSIGNED USER's (created_by) own staff/department
        // record (NOT from staff_in_charge_id, which is a separate, optional,
        // unscoped field with no bearing on ownership or department).
        //
        // FK direction: users.staff_id -> staff.id -> staff.department_id.
        // Same derivation pattern as Admin\ProgramController::store().
        $assignedUser = User::with('staff')->find($validated['created_by']);
        $departmentId = optional($assignedUser->staff ?? null)->department_id;

        if (! $departmentId) {
            return back()->withInput()->withErrors([
                'created_by' => 'Selected user has no staff record or department assigned.',
            ]);
        }

        // The assigned user must belong to a department this leader holds.
        $this->authorizeDepartment($departmentId);

        $validated['department_id'] = $departmentId;
        $validated['status']        = 'upcoming';

        // The program is filed under the assigned user (created_by), so we
        // record which leader actually raised it inside the description
        // instead, to keep that trail visible.
        $validated['description'] = trim($validated['description'])
            . "\n\n(Created by: " . auth()->user()->name . ")";

        $program = Program::create($validated);

        NotificationService::programCreated(auth()->id(), $program->title, $program->id);

        return back()->with('success', 'Program created successfully.');
    }

    public function updateProgram(Request $request, Program $program)
    {
        // Leader must already have access to the program's current department.
        $this->authorizeDepartment($program->department_id);

        $validated = $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'required|string',
            'venue'               => 'required|string|max:255',
            'start_date'          => 'required|date',
            'end_date'            => 'required|date|after_or_equal:start_date',
            'category'            => 'nullable|string',
            'created_by'          => 'required|exists:users,id',
            'staff_in_charge_id'  => 'nullable|exists:staff,id', // optional, informational only
            'status'              => 'required|in:upcoming,ongoing,completed,cancelled,rescheduled',
        ]);

        $assignedUser = User::with('staff')->find($validated['created_by']);
        $departmentId = optional($assignedUser->staff ?? null)->department_id;

        if (! $departmentId) {
            return back()->withInput()->withErrors([
                'created_by' => 'Selected user has no staff record or department assigned.',
            ]);
        }

        // Leader must also have access to the newly assigned user's department.
        $this->authorizeDepartment($departmentId);

        $validated['department_id'] = $departmentId;

        $program->update($validated);

        return back()->with('success', 'Program updated successfully.');
    }

    public function reschedule(Request $request, Program $program)
    {
        $this->authorizeDepartment($program->department_id);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:now',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'nullable|string',
        ]);

        $program->update([
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'status'     => 'rescheduled',
        ]);

        NotificationService::programRescheduled(auth()->id(), $program->title, $program->id);

        return back()->with('success', 'Program rescheduled successfully.');
    }

    public function cancel(Request $request, Program $program)
    {
        $this->authorizeDepartment($program->department_id);

        $request->validate(['reason' => 'required|string']);

        $program->update(['status' => 'cancelled']);

        NotificationService::programCancelled(auth()->id(), $program->title, $program->id);

        return back()->with('success', 'Program cancelled.');
    }

    /**
     * GET /leader/programs/{program}
     * Renders the read-only details partial shown inside #viewProgramModal.
     */
    public function show(Program $program)
    {
        $this->authorizeDepartment($program->department_id);

        // Program::committee() is a belongsToMany(Staff::class, 'program_staff')
        // with role/responsibility/is_lead as pivot columns.
        $program->load(['department', 'staffInCharge', 'committee']);

        return view('HOD.show', compact('program'));
    }

    /**
     * GET /leader/programs/{program}/report
     * A single-program printable report — same zero-dependency "print /
     * save as PDF" approach as generateReport()'s pdf case (see the comment
     * there for why there's no PHP PDF library involved): a normal HTML page
     * with a print button, not a server-rendered PDF file.
     */
    public function programReport(Program $program)
    {
        $this->authorizeDepartment($program->department_id);

        $program->load(['department', 'staffInCharge', 'committee']);

        // Assumes MeritClaim::staff() is a belongsTo(Staff::class) — I haven't
        // seen that model, so if this errors with RelationNotFoundException,
        // rename 'staff' below to whatever that relation is actually called.
        $meritClaims = MeritClaim::where('program_id', $program->id)
            ->with('staff')
            ->orderBy('created_at')
            ->get();

        return view('HOD.program-pdf', [
            'program'     => $program,
            'meritClaims' => $meritClaims,
            'leaderName'  => auth()->user()->name,
            'generatedAt' => now(),
        ]);
    }

    /**
     * GET /leader/programs/{program}/edit
     * Returns the program's raw field values as JSON so the "Edit Program"
     * modal can pre-fill the form (editProgram() in the dashboard's JS).
     *
     * Both "Assign To (User)" and "Staff In Charge" are now plain
     * server-rendered <select> elements (populated from $users / $staffList
     * on the dashboard() view, same as Admin.Program-Create) — so the JS
     * just needs the raw ids to set .val() against options that already
     * exist in the DOM. No name/position lookups needed here anymore.
     */
    public function editData(Program $program)
    {
        $this->authorizeDepartment($program->department_id);
        $program->load(['staffInCharge', 'department']);

        return response()->json([
            'id'                  => $program->id,
            'title'               => $program->title,
            'description'         => $program->description,
            'venue'               => $program->venue,
            'department_id'       => $program->department_id,
            'department_name'     => optional($program->department)->name,
            'category'            => $program->category,
            'created_by'          => $program->created_by,
            'staff_in_charge_id'  => $program->staff_in_charge_id,
            'status'              => $program->status,
            'start_date'          => $program->start_date ? Carbon::parse($program->start_date)->format('Y-m-d\TH:i') : null,
            'end_date'            => $program->end_date ? Carbon::parse($program->end_date)->format('Y-m-d\TH:i') : null,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // Staff Directory
    // ─────────────────────────────────────────────────────────────────

    /**
     * GET /leader/staff
     * Browsable / searchable staff list, scoped to the leader's departments.
     */
    public function staffDirectory(Request $request)
    {
        $departmentIds = $this->myDepartmentIds();
        $departments   = Department::whereIn('id', $departmentIds)->orderBy('name')->get();

        $query = Staff::with('department')->whereIn('department_id', $departmentIds);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('staff_id', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $staff = $query->orderBy('name')->paginate(15)->appends($request->query());

        return view('HOD.staff-directory', compact('staff', 'departments'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Calendar
    // ─────────────────────────────────────────────────────────────────

    /**
     * GET /leader/calendar
     * Shell page — the grid itself is populated client-side via calendarEvents().
     */
    public function calendarView()
    {
        $departments = Department::whereIn('id', $this->myDepartmentIds())->orderBy('name')->get();

        return view('HOD.calendar', compact('departments'));

        
    }

    /**
     * GET /leader/calendar/events?start=...&end=...&department_id=...
     * FullCalendar-compatible JSON feed, scoped to the leader's departments
     * and (when FullCalendar supplies them) the visible date range.
     */
    // public function calendarEvents(Request $request)
    // {
    //     $departmentIds = $this->myDepartmentIds();

    //     $query = Program::whereIn('department_id', $departmentIds);

    //     if ($request->filled('department_id')) {
    //         $query->where('department_id', $request->department_id);
    //     }
    //     if ($request->filled('start') && $request->filled('end')) {
    //         $query->where('start_date', '<', $request->end)
    //               ->where('end_date', '>=', $request->start);
    //     }

    //     $colors = [
    //         'upcoming'    => '#1d4ed8',
    //         'ongoing'     => '#15803d',
    //         'completed'   => '#64748b',
    //         'cancelled'   => '#b91c1c',
    //         'rescheduled' => '#b45309',
    //     ];

    //     $events = $query->with('department')->get()->map(function ($program) use ($colors) {
    //         return [
    //             'id'    => $program->id,
    //             'title' => $program->title,
    //             'start' => Carbon::parse($program->start_date)->toIso8601String(),
    //             'end'   => Carbon::parse($program->end_date)->toIso8601String(),
    //             'color' => $colors[$program->status] ?? '#1a56db',
    //             'extendedProps' => [
    //                 'status'     => $program->status,
    //                 'venue'      => $program->venue,
    //                 'department' => optional($program->department)->code,
    //             ],
    //         ];
    //     });

    //     return response()->json($events);
    // }

    public function calendarEvents(Request $request)
    {
        // Base scope: only programs in departments this leader has access to,
        // via the department_access table (department_access.user_id -> auth()->id()).
        $departmentIds = $this->myDepartmentIds();

        $query = Program::whereIn('department_id', $departmentIds);

        // Optional further narrowing: the "Department" dropdown on the calendar
        // page filters down to a single department within what the leader
        // already has access to. Note this doesn't need re-validating against
        // $departmentIds here, because it's just an AND on top of the
        // whereIn(...) above — picking a department outside the leader's access
        // would just return zero rows, not leak other departments' data.
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('start') && $request->filled('end')) {
            // FullCalendar sends `start`/`end` as full ISO 8601 strings with a
            // UTC offset (e.g. "2026-06-28T00:00:00+08:00"), which MySQL can't
            // reliably parse as a raw string in a WHERE clause — the query
            // would silently match zero rows. Parse with Carbon in PHP first.
            $start = Carbon::parse($request->start);
            $end   = Carbon::parse($request->end);

            $query->where('start_date', '<', $end)
                ->where('end_date', '>=', $start);
        }

        $colors = [
            'upcoming'    => '#1d4ed8',
            'ongoing'     => '#15803d',
            'completed'   => '#64748b',
            'cancelled'   => '#b91c1c',
            'rescheduled' => '#b45309',
        ];

        $events = $query->with('department')->get()->map(function ($program) use ($colors) {
            return [
                'id'    => $program->id,
                'title' => $program->title,
                'start' => Carbon::parse($program->start_date)->toIso8601String(),
                'end'   => Carbon::parse($program->end_date)->toIso8601String(),
                'color' => $colors[$program->status] ?? '#1a56db',
                'extendedProps' => [
                    'status'     => $program->status,
                    'venue'      => $program->venue,
                    'department' => optional($program->department)->code,
                ],
            ];
        });

        return response()->json($events);
    }

    // ─────────────────────────────────────────────────────────────────
    // My Departments
    // ─────────────────────────────────────────────────────────────────

    /**
     * GET /leader/departments
     * One card per department the leader holds, each with its own mini stats.
     */
    public function departmentsOverview()
    {
        $departmentIds = $this->myDepartmentIds();

        $departments = Department::whereIn('id', $departmentIds)
            ->orderBy('name')
            ->get()
            ->map(function ($dept) {
                $programs = Program::where('department_id', $dept->id);

                $dept->staff_count         = Staff::where('department_id', $dept->id)->count();
                $dept->program_count       = (clone $programs)->count();
                $dept->this_month_count    = (clone $programs)
                    ->whereMonth('start_date', now()->month)
                    ->whereYear('start_date', now()->year)
                    ->count();
                $dept->weekend_staff_count = $this->weekendStaffQuery(collect([$dept->id]))
                    ->distinct('staff_id')->count('staff_id');

                return $dept;
            });

        return view('HOD.department', compact('departments'));
    }

    // ─────────────────────────────────────────────────────────────────
    // Notifications
    // ─────────────────────────────────────────────────────────────────

    /**
     * GET /leader/notifications?filter=all|unread
     */
    public function notifications(Request $request)
    {
        $query = Notification::where('user_id', auth()->id())->latest();

        if ($request->input('filter') === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query->paginate(15)->appends($request->query());
        $unreadCount   = Notification::where('user_id', auth()->id())->whereNull('read_at')->count();

        return view('HOD.notification', compact('notifications', 'unreadCount'));
    }

    public function markNotificationRead(Notification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        if (! $notification->read_at) {
            $notification->update(['read_at' => now()]);
        }

        return $notification->url
            ? redirect()->away($notification->url)
            : back();
    }

    public function markAllNotificationsRead()
    {
        Notification::where('user_id', auth()->id())->whereNull('read_at')->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read.');
    }

    private function authorizeDepartment($departmentId): void
    {
        abort_unless($this->myDepartmentIds()->contains((int) $departmentId), 403, 'You do not have access to this department.');
    }
}
