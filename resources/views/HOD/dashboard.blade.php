@extends('layouts.app')

@section('title', 'Leader Dashboard - AmazingTrack')

@push('styles')
<style>
    /* ── Leader page extras (built on top of the AmazingTrack theme) ── */
    .dept-chip {
        background: var(--accent-light);
        color: #92400e;
        font-weight: 600;
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 30px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .dept-chip i { font-size: 10px; }

    .stat-card .stat-icon.icon-blue   { background:#eef2ff; color:#1a56db; }
    .stat-card .stat-icon.icon-green  { background:#dcfce7; color:#15803d; }
    .stat-card .stat-icon.icon-amber  { background:#fef3c7; color:#b45309; }
    .stat-card .stat-icon.icon-red    { background:#fee2e2; color:#b91c1c; }

    .status-badge-upcoming    { background:#dbeafe; color:#1d4ed8; }
    .status-badge-ongoing     { background:#dcfce7; color:#15803d; }
    .status-badge-completed   { background:#e2e8f0; color:#334155; }
    .status-badge-cancelled   { background:#fee2e2; color:#b91c1c; }
    .status-badge-rescheduled { background:#fef9c3; color:#b45309; }

    .category-badge { background:#eef2ff; color:#1a56db; }

    .weekend-badge-sat { background:#fef3c7; color:#92400e; }
    .weekend-badge-sun { background:#fee2e2; color:#b91c1c; }

    /* Tabs styled to match card system */
    .leader-tabs {
        border-bottom: none;
        gap: 6px;
        margin-bottom: 20px;
    }
    .leader-tabs .nav-link {
        border: none;
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 14px;
        padding: 10px 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .leader-tabs .nav-link i { font-size: 13px; }
    .leader-tabs .nav-link.active {
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        color: #fff;
        box-shadow: 0 4px 14px rgba(26,86,219,0.28);
    }
    .leader-tabs .nav-link:not(.active):hover {
        background: #eef2ff;
        color: var(--sidebar-to);
    }

    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: var(--shadow-sm);
    }

    .avatar-sm {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }

    .report-summary-card {
        border-radius: var(--radius-lg);
        border: 1px solid var(--border);
        padding: 18px;
        text-align: center;
        background: var(--surface);
    }
    .report-summary-card .num { font-size: 1.7rem; font-weight: 800; color: var(--sidebar-to); }
    .report-summary-card .lbl { font-size: 12.5px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .4px; }

    .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 42px; color: #c7d5f8; margin-bottom: 14px; display:block; }
</style>
@endpush

@section('content')

{{-- ═══════════════ PAGE HEADER ═══════════════ --}}
<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-user-tie me-2" style="color:var(--sidebar-to)"></i>Leader Dashboard</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex align-items-center flex-wrap gap-2">
        <span class="text-muted small fw-semibold me-1">Managing:</span>
        @forelse($departments as $dept)
            <span class="dept-chip"><i class="fa-solid fa-circle"></i>{{ $dept->code ?? $dept->name }}</span>
        @empty
            <span class="badge status-badge-cancelled">No department assigned — contact admin</span>
        @endforelse
    </div>
</div>

{{-- ═══════════════ STAT CARDS ═══════════════ --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card stat-card card-hover p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon icon-blue"><i class="fa-solid fa-building"></i></div>
                <div>
                    <div class="text-muted small">Departments</div>
                    <div class="fs-4 fw-bold">{{ $stats['departments'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card card-hover p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon icon-green"><i class="fa-solid fa-calendar-days"></i></div>
                <div>
                    <div class="text-muted small">Total Programs</div>
                    <div class="fs-4 fw-bold">{{ $stats['programs'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card card-hover p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon icon-amber"><i class="fa-solid fa-hourglass-half"></i></div>
                <div>
                    <div class="text-muted small">This Month</div>
                    <div class="fs-4 fw-bold">{{ $stats['upcoming_this_month'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card stat-card card-hover p-3 h-100">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon icon-red"><i class="fa-solid fa-calendar-week"></i></div>
                <div>
                    <div class="text-muted small">Weekend Duty Staff</div>
                    <div class="fs-4 fw-bold">{{ $stats['weekend_staff'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ TABS ═══════════════ --}}
<ul class="nav leader-tabs" id="leaderTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-programs-btn" data-bs-toggle="tab" data-bs-target="#tab-programs" type="button" role="tab">
            <i class="fa-solid fa-list-check"></i> Programs
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-reports-btn" data-bs-toggle="tab" data-bs-target="#tab-reports" type="button" role="tab">
            <i class="fa-solid fa-chart-column"></i> Monthly Report
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-weekend-btn" data-bs-toggle="tab" data-bs-target="#tab-weekend" type="button" role="tab">
            <i class="fa-solid fa-people-roof"></i> Weekend Staff
        </button>
    </li>
</ul>

<div class="tab-content">

    {{-- ═══════════════ TAB 1: PROGRAMS ═══════════════ --}}
    <div class="tab-pane fade show active" id="tab-programs" role="tabpanel">

        <div class="filter-bar">
            <form method="GET" action="{{ route('leader.dashboard') }}" class="row g-2 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Department</label>
                    <select name="department_id" class="form-select form-select-sm select2-leader">
                        <option value="">All my departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold mb-1">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All status</option>
                        @foreach(['upcoming','ongoing','completed','cancelled','rescheduled'] as $st)
                            <option value="{{ $st }}" @selected(request('status') == $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-semibold mb-1">Category</label>
                    <select name="category" class="form-select">
                        @php
                            $categories = [
                                'fitness'    => 'Be An Amazing You - (Fitness)',
                                'social'     => 'Be An Amazing You - (Social)',
                                'mind'       => 'Be An Amazing You - (Mind)',
                                'spiritual'  => 'Be An Amazing You - (Spiritual)',
                                'Marketing'  => 'Marketing',
                                'inmeeting'  => 'Meeting - Internal',
                                'exmeeting'  => 'Meeting - External',
                            ];
                        @endphp

                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}" @selected(old('category', $program->category ?? '') == $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                                    </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Search title / venue">
                </div>
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill"><i class="fa-solid fa-filter me-1"></i>Filter</button>
                    <button type="button" class="btn btn-warning btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#programModal" onclick="openCreateProgram()">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-table-list me-2"></i>Programs Under My Departments</span>
                <span class="text-muted small">{{ $programs->total() ?? count($programs) }} total</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="programsTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Venue</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Staff In Charge</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td class="fw-semibold">{{ $program->title }}</td>
                            <td>{{ $program->department->code ?? $program->department->name }}</td>
                            <td><span class="badge category-badge">{{ ucfirst($program->category ?? '—') }}</span></td>
                            <td>{{ $program->venue }}</td>
                            <td>{{ \Carbon\Carbon::parse($program->start_date)->format('d M Y, h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($program->end_date)->format('d M Y, h:i A') }}</td>
                            <td>{{ optional($program->staffInCharge)->name ?? '—' }}</td>
                            <td><span class="badge status-badge-{{ $program->status }}">{{ ucfirst($program->status) }}</span></td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" onclick="viewProgram({{ $program->id }})"><i class="fa-solid fa-eye me-2"></i>View</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="editProgram({{ $program->id }})"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="rescheduleProgram({{ $program->id }})"><i class="fa-solid fa-clock-rotate-left me-2"></i>Reschedule</a></li>
                                        <li><a class="dropdown-item" href="{{ route('leader.programs.report', $program->id) }}" target="_blank"><i class="fa-solid fa-file-pdf me-2"></i>Print Report</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="cancelProgram({{ $program->id }})"><i class="fa-solid fa-ban me-2"></i>Cancel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                    No programs found for your department(s) yet.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($programs, 'links'))
            <div class="card-footer bg-transparent">
                {{ $programs->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════ TAB 2: MONTHLY REPORT ═══════════════ --}}
    <div class="tab-pane fade" id="tab-reports" role="tabpanel">

        <div class="card mb-4">
            <div class="card-header"><i class="fa-solid fa-calendar-check me-2"></i>Generate Monthly Report</div>
            <div class="card-body">
                <form method="GET" action="{{ route('leader.reports.generate') }}" target="_blank" class="row g-3 align-items-end">
                    <div class="col-6 col-md-3">
                        <label class="form-label small fw-semibold mb-1">Month</label>
                        <input type="month" name="month" class="form-control form-control-sm" value="{{ request('month', now()->format('Y-m')) }}" required>
                    </div>
                    <div class="col-12 col-md-5">
                        <label class="form-label small fw-semibold mb-1">Department(s)</label>
                        <select name="department_ids[]" class="form-select form-select-sm select2-leader" multiple>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" selected>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 d-flex gap-2">
                        <button type="submit" name="format" value="preview" class="btn btn-primary btn-sm flex-fill">
                            <i class="fa-solid fa-eye me-1"></i>Preview
                        </button>
                        <button type="submit" name="format" value="pdf" class="btn btn-outline-secondary btn-sm flex-fill">
                            <i class="fa-solid fa-file-pdf me-1"></i>PDF
                        </button>
                        <button type="submit" name="format" value="excel" class="btn btn-outline-secondary btn-sm flex-fill">
                            <i class="fa-solid fa-file-excel me-1"></i>Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Summary of the currently selected / most recent month --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num">{{ $reportSummary['total'] ?? 0 }}</div>
                    <div class="lbl">Total Programs</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num" style="color:#15803d">{{ $reportSummary['completed'] ?? 0 }}</div>
                    <div class="lbl">Completed</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num" style="color:#b45309">{{ $reportSummary['rescheduled'] ?? 0 }}</div>
                    <div class="lbl">Rescheduled</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num" style="color:#b91c1c">{{ $reportSummary['cancelled'] ?? 0 }}</div>
                    <div class="lbl">Cancelled</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num">{{ $reportSummary['staff_involved'] ?? 0 }}</div>
                    <div class="lbl">Staff Involved</div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <div class="report-summary-card">
                    <div class="num">{{ $reportSummary['merit_points'] ?? 0 }}</div>
                    <div class="lbl">Merit Points Awarded</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fa-solid fa-building-columns me-2"></i>Breakdown By Department</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Total</th>
                            <th>Completed</th>
                            <th>Ongoing / Upcoming</th>
                            <th>Rescheduled</th>
                            <th>Cancelled</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departmentBreakdown ?? [] as $row)
                        <tr>
                            <td class="fw-semibold">{{ $row['name'] }}</td>
                            <td>{{ $row['total'] }}</td>
                            <td>{{ $row['completed'] }}</td>
                            <td>{{ $row['active'] }}</td>
                            <td>{{ $row['rescheduled'] }}</td>
                            <td>{{ $row['cancelled'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6"><div class="empty-state"><i class="fa-solid fa-chart-simple"></i>Pick a month above and hit Preview to see the breakdown.</div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ═══════════════ TAB 3: WEEKEND STAFF ═══════════════ --}}
    <div class="tab-pane fade" id="tab-weekend" role="tabpanel">

        <div class="filter-bar">
            <form method="GET" action="{{ route('leader.dashboard') }}#tab-weekend" class="row g-2 align-items-end">
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Month</label>
                    <input type="month" name="weekend_month" class="form-control form-control-sm" value="{{ request('weekend_month', now()->format('Y-m')) }}">
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-semibold mb-1">Department</label>
                    <select name="weekend_department_id" class="form-select form-select-sm select2-leader">
                        <option value="">All my departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fa-solid fa-filter me-1"></i>Filter</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-people-roof me-2"></i>Staff Scheduled on Weekends</span>
                <span class="text-muted small">{{ count($weekendStaff) }} record(s)</span>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0" id="weekendTable">
                    <thead>
                        <tr>
                            <th>Staff</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Program</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Role in Program</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($weekendStaff as $row)
                        @php
                            $date = \Carbon\Carbon::parse($row->weekend_date ?? $row->program->start_date);
                            $isSat = $date->isSaturday();
                        @endphp
                        <tr>
                            <td class="d-flex align-items-center gap-2">
                                <div class="avatar-sm">{{ strtoupper(substr($row->staff->name ?? '?', 0, 1)) }}</div>
                                {{ $row->staff->name ?? '—' }}
                            </td>
                            <td>{{ $row->staff->position ?? '—' }}</td>
                            <td>{{ optional($row->program->department)->code ?? '—' }}</td>
                            <td>{{ $row->program->title ?? '—' }}</td>
                            <td>{{ $date->format('d M Y') }}</td>
                            <td><span class="badge {{ $isSat ? 'weekend-badge-sat' : 'weekend-badge-sun' }}">{{ $date->format('l') }}</span></td>
                            <td><span class="badge category-badge">{{ str_replace('_',' ', ucfirst($row->role)) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-mug-hot"></i>
                                    No staff are scheduled to work this weekend. 🎉
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ═══════════════ MODAL: CREATE / EDIT PROGRAM ═══════════════ --}}
<div class="modal fade" id="programModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius-lg);">
            <form id="programForm" method="POST" action="{{ route('leader.programs.store') }}">
                @csrf
                <input type="hidden" name="_method" id="programFormMethod" value="POST">
                <input type="hidden" name="program_id" id="programFormId">

                {{-- Department is no longer picked directly. It's derived
                     server-side from whichever user is chosen in "Assign To
                     (User)" below — same pattern as Admin.ProgramController.
                     The visible "Department" input is just a display; the
                     hidden field is never actually submitted/trusted, the
                     server re-derives it independently on save. --}}
                <div class="modal-header">
                    <h5 class="modal-title" id="programModalTitle"><i class="fa-solid fa-calendar-plus me-2"></i>Add Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Assign User</label>
                            <select id="assignedUserSelect" name="created_by" class="form-select select2-leader" required>
                                <option value="">— Select user —</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}"
                                        data-department-name="{{ optional(optional($u->staff)->department)->name ?? '—' }}">
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Only users in your assigned department(s) show up here.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Department (auto-filled)</label>
                            <input type="text" id="departmentDisplay" class="form-control" disabled placeholder="Select a user first">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Staff In Charge <span class="text-muted fw-normal">(optional)</span></label>
                            <select id="staffInChargeSelect" name="staff_in_charge_id" class="form-select select2-leader">
                                <option value="">— Select staff member (optional) —</option>
                                @foreach($staffList as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Any staff member — not limited to your department(s).</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Category</label>
                            <select name="category" class="form-select">
                                @php
                                    $categories = [
                                        'fitness'    => 'Be An Amazing You - (Fitness)',
                                        'social'     => 'Be An Amazing You - (Social)',
                                        'mind'       => 'Be An Amazing You - (Mind)',
                                        'spiritual'  => 'Be An Amazing You - (Spiritual)',
                                        'Marketing'  => 'Marketing',
                                        'inmeeting'  => 'Meeting - Internal',
                                        'exmeeting'  => 'Meeting - External',
                                    ];
                                @endphp

                                @foreach($categories as $value => $label)
                                    <option value="{{ $value }}" @selected(old('category', $program->category ?? '') == $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-semibold">Venue</label>
                            <input type="text" name="venue" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">Start Date &amp; Time</label>
                            <input type="datetime-local" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">End Date &amp; Time</label>
                            <input type="datetime-local" name="end_date" class="form-control" required>
                        </div>
                        <div class="col-md-6" id="statusFieldWrap" style="display:none;">
                            <label class="form-label small fw-semibold">Status</label>
                            <select name="status" class="form-select">
                                @foreach(['upcoming','ongoing','completed','cancelled','rescheduled'] as $st)
                                    <option value="{{ $st }}">{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Save Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL: VIEW PROGRAM ═══════════════ --}}
<div class="modal fade" id="viewProgramModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius-lg);">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-circle-info me-2"></i>Program Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewProgramBody">
                <div class="text-center text-muted py-4"><i class="fa-solid fa-spinner fa-spin me-2"></i>Loading...</div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL: RESCHEDULE PROGRAM ═══════════════ --}}
<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius-lg);">
            <form id="rescheduleForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-clock-rotate-left me-2"></i>Reschedule Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">New Start Date &amp; Time</label>
                        <input type="datetime-local" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">New End Date &amp; Time</label>
                        <input type="datetime-local" name="end_date" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small fw-semibold">Reason</label>
                        <textarea name="reason" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning"><i class="fa-solid fa-clock-rotate-left me-1"></i>Confirm Reschedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ MODAL: CANCEL PROGRAM ═══════════════ --}}
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius-lg);">
            <form id="cancelForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fa-solid fa-ban me-2"></i>Cancel Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small mb-2">Please state the reason for cancelling this program. This action will notify the assigned staff.</p>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Back</button>
                    <button type="submit" class="btn" style="background:#dc2626;color:#fff;"><i class="fa-solid fa-ban me-1"></i>Cancel Program</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2-leader').select2({ theme: 'bootstrap-5', width: '100%' });

    // Both are now plain server-rendered <select> elements (like
    // Admin.Program-Create), so select2 is just cosmetic here — no ajax
    // config needed since all options are already in the DOM.

    // #tab-programs is the tab that's visible by default, so it's safe to
    // initialize its DataTable immediately.
    if (! $.fn.DataTable.isDataTable('#programsTable')) {
        $('#programsTable').DataTable({ paging: false, info: false, searching: false, ordering: true });
    }

    // #tab-weekend starts hidden (display:none) because it's an inactive
    // Bootstrap tab pane. Calling .DataTable() on a hidden table makes
    // DataTables mis-measure the header/body cells while cloning them for
    // width calculation, which is what throws the "Incorrect column count"
    // warning even though the underlying <thead>/<tbody> markup lines up.
    // Deferring init (or re-adjusting columns) until the tab is actually
    // shown avoids it.
    $('#tab-weekend-btn').on('shown.bs.tab', function () {
        if (! $.fn.DataTable.isDataTable('#weekendTable')) {
            $('#weekendTable').DataTable({ paging: true, pageLength: 10, info: false, searching: true, ordering: true });
        } else {
            $('#weekendTable').DataTable().columns.adjust().draw(false);
        }
    });

    // The sidebar's "My Programs" / "Monthly Report" / "Weekend Staff" links
    // all point back to this same page with a ?tab=programs|reports|weekend
    // query param (since they're Bootstrap tabs, not separate routes).
    // Open the right tab on load so the link actually lands where it says it does.
    const urlParams = new URLSearchParams(window.location.search);
    const requestedTab = urlParams.get('tab');
    if (requestedTab) {
        const trigger = document.getElementById('tab-' + requestedTab + '-btn');
        if (trigger) {
            new bootstrap.Tab(trigger).show();
        }
    }

    // The Overview page's "Add a Program" quick action links here with
    // ?tab=programs&action=create — once the Programs tab is open, also pop
    // the create-program modal so the link does what it promised in one click.
    if (urlParams.get('action') === 'create') {
        openCreateProgram();
        new bootstrap.Modal(document.getElementById('programModal')).show();
    }
});

// "Assign To (User)" — same concept as Admin.Program-Create's #created_by
// handler: read the department name straight off the selected <option>'s
// data-department-name attribute (no AJAX call needed since every user
// this leader is allowed to assign was already rendered server-side into
// the <select>).
$('#assignedUserSelect').on('change', function () {
    const selected = $(this).find('option:selected');
    $('#departmentDisplay').val(selected.data('department-name') || '');
});

/**
 * Formats a JS Date as a value the <input type="datetime-local"> min/value
 * attributes understand (YYYY-MM-DDTHH:MM), in the browser's local time.
 */
function toDateTimeLocalValue(date) {
    const pad = n => String(n).padStart(2, '0');
    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
}

/**
 * Blocks past dates on a start/end datetime-local pair:
 *  - Sets `min` on both inputs to `floor` (defaults to right now).
 *  - Whenever start changes, pushes end's min up to match it, and nudges
 *    end forward if it would otherwise fall before the new start.
 * Re-usable for the Create/Edit modal and the Reschedule modal.
 */
function blockPastDates(startInput, endInput, floor = null) {
    const minValue = toDateTimeLocalValue(floor ?? new Date());
    startInput.setAttribute('min', minValue);
    endInput.setAttribute('min', endInput.value && endInput.value > minValue ? endInput.value : minValue);

    startInput.onchange = function () {
        if (startInput.value) {
            endInput.setAttribute('min', startInput.value);
            if (endInput.value && endInput.value < startInput.value) {
                endInput.value = startInput.value;
            }
        }
    };
}

function resetAssignedUserField() {
    $('#assignedUserSelect').val('').trigger('change');
}

function resetStaffInChargeField() {
    $('#staffInChargeSelect').val('').trigger('change');
}

function openCreateProgram() {
    $('#programModalTitle').html('<i class="fa-solid fa-calendar-plus me-2"></i>Add Program');
    $('#programForm').attr('action', '{{ route("leader.programs.store") }}');
    $('#programFormMethod').val('POST');
    $('#statusFieldWrap').hide();
    $('#programForm')[0].reset();
    resetAssignedUserField();
    resetStaffInChargeField();

    // New program: can never start (or end) in the past.
    const f = document.getElementById('programForm');
    blockPastDates(f.start_date, f.end_date);
}

function editProgram(id) {
    $('#programModalTitle').html('<i class="fa-solid fa-pen me-2"></i>Edit Program');
    $('#programForm').attr('action', `/leader/programs/${id}`);
    $('#programFormMethod').val('PUT');
    $('#statusFieldWrap').show();

    // Populate the form via AJAX (GET /leader/programs/{id}/edit) and open the modal.
    fetch(`/leader/programs/${id}/edit`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            const f = document.getElementById('programForm');
            f.title.value = data.title;
            f.description.value = data.description;
            f.venue.value = data.venue;
            f.category.value = data.category;
            f.start_date.value = data.start_date;
            f.end_date.value = data.end_date;
            f.status.value = data.status;

            // Both selects already contain every valid option server-side
            // (rendered from $users / $staffList), so setting .val() and
            // triggering select2's change event is enough — no need to
            // inject a fabricated <option> like an AJAX-backed select2 would.
            $('#assignedUserSelect').val(data.created_by ?? '').trigger('change');
            $('#staffInChargeSelect').val(data.staff_in_charge_id ?? '').trigger('change');

            // Editing: don't let the date be pushed further into the past
            // than it already is, but don't block saving an unchanged date
            // on a program that's already ongoing/completed either — the
            // floor is whichever is earlier, "now" or the program's own
            // existing start date.
            const now = new Date();
            const existingStart = data.start_date ? new Date(data.start_date) : now;
            const floor = existingStart < now ? existingStart : now;
            blockPastDates(f.start_date, f.end_date, floor);

            new bootstrap.Modal(document.getElementById('programModal')).show();
        });
}

function viewProgram(id) {
    new bootstrap.Modal(document.getElementById('viewProgramModal')).show();
    fetch(`/leader/programs/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => { document.getElementById('viewProgramBody').innerHTML = html; });
}

function rescheduleProgram(id) {
    $('#rescheduleForm').attr('action', `/leader/programs/${id}/reschedule`);

    // Rescheduling always means picking a new date going forward — never
    // let it land in the past, regardless of the program's current dates.
    const rf = document.getElementById('rescheduleForm');
    blockPastDates(rf.start_date, rf.end_date);

    new bootstrap.Modal(document.getElementById('rescheduleModal')).show();
}

function cancelProgram(id) {
    $('#cancelForm').attr('action', `/leader/programs/${id}/cancel`);
    new bootstrap.Modal(document.getElementById('cancelModal')).show();
}
</script>
@endpush
