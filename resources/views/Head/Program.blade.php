@extends('layouts.app')

@section('page-title','My Programs')

@push('styles')
<style>
/* ── Status badges ── */
.badge-upcoming    { background:#dbeafe; color:#1d4ed8; }
.badge-ongoing     { background:#dcfce7; color:#15803d; }
.badge-completed   { background:#e0e7ff; color:#3730a3; }
.badge-cancelled   { background:#fee2e2; color:#b91c1c; }
.badge-rescheduled { background:#fef9c3; color:#b45309; }

.status-badge {
    font-size: 11.5px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: .3px;
}
  
/* ── Program card ── */
.program-card {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 14px !important;
    transition: all .25s ease;
    overflow: hidden;
}

.program-card:hover {
    border-color: #bfdbfe !important;
    box-shadow: 0 8px 28px rgba(15,45,110,0.10) !important;
    transform: translateY(-3px);
}

.program-card .card-top           { height:5px; background: linear-gradient(90deg,#1a56db,#3b82f6); }
.program-card.ongoing .card-top   { background: linear-gradient(90deg,#16a34a,#4ade80); }
.program-card.completed .card-top { background: linear-gradient(90deg,#6366f1,#818cf8); }
.program-card.cancelled .card-top { background: linear-gradient(90deg,#ef4444,#f87171); }
.program-card.rescheduled .card-top { background: linear-gradient(90deg,#f59e0b,#fbbf24); }

/* ── Date chip ── */
.date-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: #64748b;
    background: #f1f5f9;
    border-radius: 8px;
    padding: 5px 10px;
}

/* ── Action buttons ── */
.action-btn {
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    padding: 7px 14px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .2s ease;
    font-family: inherit;
}

.btn-edit       { background:#eff6ff; color:#1d4ed8; }
.btn-reschedule { background:#fefce8; color:#b45309; }
.btn-cancel-p   { background:#fff7ed; color:#c2410c; }
.btn-delete     { background:#fef2f2; color:#b91c1c; }

.btn-edit:hover       { background:#dbeafe; }
.btn-reschedule:hover { background:#fef08a; }
.btn-cancel-p:hover   { background:#fed7aa; }
.btn-delete:hover     { background:#fecaca; }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 64px 24px;
    color: #94a3b8;
}
.empty-state i {
    font-size: 48px;
    margin-bottom: 16px;
    display: block;
    color: #cbd5e1;
}

.empty-state svg.svg-inline--fa {
    width: 48px !important;
    height: 48px !important;
}

/* Constrain all FA SVG icons */
svg.svg-inline--fa {
    width: 1em !important;
    height: 1em !important;
    display: inline-block !important;
    vertical-align: -0.125em;
}

/* ── Modal tweaks ── */
.modal-content {
    border-radius: 16px !important;
    border: none !important;
    box-shadow: 0 24px 64px rgba(10,20,60,0.20) !important;
}
.modal-header {
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 20px 24px !important;
}
.modal-body  { padding: 24px !important; }
.modal-footer {
    border-top: 1px solid #e2e8f0 !important;
    padding: 16px 24px !important;
}

.modal-title { font-weight: 700; font-size: 1rem; }

.form-label { font-size: 13.5px; font-weight: 600; color: #374151; }

.form-control, .form-select {
    border-radius: 10px !important;
    border: 1.5px solid #e2e8f0 !important;
    font-size: 14px !important;
    padding: 10px 14px !important;
    background: #f8faff !important;
    font-family: inherit;
    transition: border-color .2s, box-shadow .2s;
}
.form-control:focus, .form-select:focus {
    border-color: #1a56db !important;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10) !important;
    background: #fff !important;
    outline: none;
}

.btn-primary-custom {
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(26,86,219,0.28);
    transition: all .2s;
}
.btn-primary-custom:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(26,86,219,0.36); }

.btn-secondary-custom {
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    transition: background .2s;
}
.btn-secondary-custom:hover { background: #e2e8f0; }

.btn-danger-custom {
    background: linear-gradient(135deg,#b91c1c,#ef4444);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-weight: 600;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(185,28,28,0.25);
    transition: all .2s;
}
.btn-danger-custom:hover { transform: translateY(-1px); }

/* ── Search / Filter bar ── */
.filter-bar {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 20px;
}

.filter-input {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px 10px 36px;
    font-size: 14px;
    font-family: inherit;
    background: #f8faff;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.filter-input:focus {
    border-color: #1a56db;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10);
    background: #fff;
}

.filter-select {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14px;
    font-family: inherit;
    background: #f8faff;
    color: #1e293b;
    transition: border-color .2s;
    outline: none;
    cursor: pointer;
}
.filter-select:focus {
    border-color: #1a56db;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10);
}

.filter-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 5px;
    display: block;
    letter-spacing: .3px;
}

.btn-reset {
    width: 100%;
    background: #f1f5f9;
    color: #475569;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-reset:hover { background: #e2e8f0; border-color: #cbd5e1; }

.filter-tag {
    background: #dbeafe;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.filter-tag button {
    background: none;
    border: none;
    color: #1d4ed8;
    cursor: pointer;
    padding: 0;
    font-size: 11px;
    line-height: 1;
}

.results-count {
    font-size: 13px;
    color: #64748b;
    margin-bottom: 14px;
}

/* ── Pagination ── */
nav[role="navigation"] {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 8px;
}

nav[role="navigation"] .flex.justify-between {
    display: none !important; /* hide mobile prev/next text */
}

nav[role="navigation"] span.relative,
nav[role="navigation"] > div:last-child {
    display: flex;
    align-items: center;
    justify-content: center;
}

nav[role="navigation"] a,
nav[role="navigation"] span > span {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 36px;
    height: 36px;
    border-radius: 8px !important;
    border: 1.5px solid #e2e8f0 !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #475569 !important;
    background: #fff !important;
    margin: 0 2px !important;
    text-decoration: none !important;
    transition: all .2s;
}

nav[role="navigation"] a:hover {
    background: #eff6ff !important;
    border-color: #bfdbfe !important;
    color: #1d4ed8 !important;
}

/* Active page */
nav[role="navigation"] span[aria-current="page"] span {
    background: linear-gradient(135deg, #0f2d6e, #1a56db) !important;
    border-color: #1a56db !important;
    color: #fff !important;
}

/* Disabled arrows */
nav[role="navigation"] span[aria-disabled="true"] span {
    opacity: 0.4;
    cursor: not-allowed;
}

/* Hide the text "Showing X to Y of Z results" from pagination */
nav[role="navigation"] p {
    display: none;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h2><i class="text-primary"></i>My Programs</h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}"
                    class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">My Programs</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('head.programs.create') }}"
       style="background:linear-gradient(135deg,#0f2d6e,#1a56db);color:#fff;border:none;border-radius:10px;padding:11px 22px;font-size:14px;font-weight:600;font-family:inherit;cursor:pointer;box-shadow:0 4px 14px rgba(26,86,219,0.28);transition:all .2s;display:inline-flex;align-items:center;gap:8px;text-decoration:none;">
        <i class="fa fa-circle-plus"></i> New Program
    </a>
</div>

{{-- Flash Messages --}}
{{-- @if(session('success'))
    <div class="alert d-flex align-items-center gap-2 mb-4"
         style="background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:12px;color:#15803d;font-size:14px;padding:12px 16px;">
        <i class="fa fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert d-flex align-items-center gap-2 mb-4"
         style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;color:#b91c1c;font-size:14px;padding:12px 16px;">
        <i class="fa fa-circle-exclamation"></i> {{ session('error') }}
    </div>
@endif --}}

{{-- Summary strip --}}
<div class="row g-3 mb-4">
    @php
        $all         = $programs->total();
        $upcoming    = $programs->getCollection()->where('status','upcoming')->count();
        $ongoing     = $programs->getCollection()->where('status','ongoing')->count();
        $cancelled   = $programs->getCollection()->where('status','cancelled')->count();
        $rescheduled = $programs->getCollection()->where('status','rescheduled')->count();
        $completed   = $programs->getCollection()->where('status','completed')->count();
    @endphp

    @foreach([
        ['label'=>'Total',       'val'=>$all,         'icon'=>'fa-layer-group',      'bg'=>'#eff6ff','ic'=>'#1d4ed8'],
        ['label'=>'Upcoming',    'val'=>$upcoming,    'icon'=>'fa-clock',             'bg'=>'#dbeafe','ic'=>'#1d4ed8'],
        ['label'=>'Ongoing',     'val'=>$ongoing,     'icon'=>'fa-circle-check',      'bg'=>'#f0fdf4','ic'=>'#15803d'],
        ['label'=>'Completed',   'val'=>$completed,   'icon'=>'fa-check-double','bg'=>'#e0e7ff','ic'=>'#3730a3'],
        ['label'=>'Rescheduled', 'val'=>$rescheduled, 'icon'=>'fa-clock-rotate-left', 'bg'=>'#fefce8','ic'=>'#b45309'],
        ['label'=>'Cancelled',   'val'=>$cancelled,   'icon'=>'fa-ban',               'bg'=>'#fef2f2','ic'=>'#b91c1c'],
    ] as $s)
    <div class="col-6 col-md-2">
        <div class="card card-hover" style="border-radius:14px !important;border:1.5px solid #e2e8f0 !important;">
            <div class="card-body d-flex align-items-center gap-3 py-3 px-3">
                <div style="width:40px;height:40px;border-radius:10px;background:{{ $s['bg'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa {{ $s['icon'] }}" style="color:{{ $s['ic'] }};font-size:16px;"></i>
                </div>
                <div>
                    <div style="font-size:20px;font-weight:700;line-height:1;color:#0f172a;">{{ $s['val'] }}</div>
                    <div style="font-size:11.5px;color:#64748b;margin-top:2px;">{{ $s['label'] }}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- ══ Search / Sort / Filter Bar ══ --}}
@if(!$programs->isEmpty())
<form method="GET" action="{{ route('head.programs.index') }}">
<div class="filter-bar">
    <div class="row g-3 align-items-end">

        {{-- Search --}}
        <div class="col-12 col-md-4">
            <label class="filter-label"><i class="fa fa-magnifying-glass me-1"></i> Search</label>
            <div style="position:relative;">
                <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;">
                    <i class="fa fa-magnifying-glass"></i>
                </span>
                <input type="text"
                       id="searchInput"
                       class="filter-input"
                       placeholder="Search title, venue, staff...">
            </div>
        </div>

        {{-- Year --}}
        <div class="col-6 col-md-2">
            <label class="filter-label">
                <i class="fa fa-calendar me-1"></i> Year
            </label>

            <select name="year"
                    class="filter-select"
                    onchange="this.form.submit()">

                @foreach($yearOptions as $year)
                <option value="{{ $year }}"
                    {{ $selectedYear == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
                @endforeach

            </select>
        </div>


        {{-- Month --}}
        <div class="col-6 col-md-2">
            <label class="filter-label">
                <i class="fa fa-calendar-days me-1"></i> Month
            </label>

            <select name="month"
                    class="filter-select"
                    onchange="this.form.submit()">

                <option value="">All Months</option>

                @foreach($monthOptions as $m)
                <option value="{{ $m['value'] }}"
                    {{ $selectedMonth == $m['value'] ? 'selected' : '' }}>
                    {{ $m['label'] }}
                </option>
                @endforeach

            </select>
        </div>

        {{-- Filter by status --}}
        <div class="col-6 col-md-3">
            <label class="filter-label"><i class="fa fa-filter me-1"></i> Status</label>
            <select id="filterStatus" class="filter-select">
                <option value="">All Statuses</option>
                <option value="upcoming">Upcoming</option>
                <option value="ongoing">Ongoing</option>
                <option value="rescheduled">Rescheduled</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        {{-- Sort --}}
        <div class="col-6 col-md-3">
            <label class="filter-label"><i class="fa fa-arrow-up-wide-short me-1"></i> Sort By</label>
            <select id="sortBy" class="filter-select">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="title_asc">Title A → Z</option>
                <option value="title_desc">Title Z → A</option>
                <option value="start_asc">Start Date ↑</option>
                <option value="start_desc">Start Date ↓</option>
            </select>
        </div>

        {{-- Reset --}}
        <div class="col-12 col-md-2">
            <button id="resetFilters" class="btn-reset">
                <i class="fa fa-rotate-left"></i> Reset
            </button>
        </div>

    </div>

    {{-- Active filter tags --}}
    <div id="activeFilters" style="display:none;margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9;align-items:center;gap:8px;flex-wrap:wrap;">
        <span style="font-size:12px;color:#94a3b8;font-weight:600;">Active:</span>
        <span id="filterTags" style="display:flex;gap:6px;flex-wrap:wrap;"></span>
    </div>
</div>
</form>

{{-- Results count --}}
<div id="resultsCount" class="results-count" style="display:none;">
    Showing <strong id="visibleCount">0</strong> of <strong>{{ $programs->total() }}</strong> programs
</div>
@endif

{{-- Programs Grid --}}
@if($programs->isEmpty())
    <div class="card" style="border-radius:16px !important;border:1.5px solid #e2e8f0 !important;">
        <div class="empty-state">
            <i class="fa fa-calendar-xmark"></i>
            <h5 style="color:#475569;font-weight:600;">No programs yet</h5>
            <p style="font-size:14px;max-width:340px;margin:8px auto 0;">Programs you create will appear here.</p>
        </div>
    </div>
@else

    {{-- No results state (JS controlled) --}}
    <div id="noResults" style="display:none;">
        <div class="card" style="border-radius:16px !important;border:1.5px solid #e2e8f0 !important;">
            <div class="empty-state">
                <i class="fa fa-magnifying-glass"></i>
                <h5 style="color:#475569;font-weight:600;">No programs found</h5>
                <p style="font-size:14px;max-width:340px;margin:8px auto 0;">Try adjusting your search or filters.</p>
            </div>
        </div>
    </div>

    <div id="programsGrid" class="row g-3">
        @foreach($programs as $program)
        <div class="col-12 col-md-6 col-xl-4 program-item"
             data-title="{{ strtolower($program->title) }}"
             data-venue="{{ strtolower($program->venue) }}"
             data-staff="{{ strtolower($program->staffInCharge->name ?? '') }}"
             data-status="{{ $program->status }}"
             data-start="{{ $program->start_date->timestamp }}"
             data-created="{{ $program->created_at->timestamp }}">

            <div class="card program-card {{ $program->status }}">
                <div class="card-top"></div>
                <div class="card-body p-3">

                    {{-- Title + status --}}
                    <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                        <h6 style="font-weight:700;font-size:15px;color:#0f172a;margin:0;line-height:1.4;">
                            {{ $program->title }}
                        </h6>
                        <span class="status-badge badge-{{ $program->status }} flex-shrink-0">
                            {{ ucfirst($program->status) }}
                        </span>
                    </div>

                    {{-- Description --}}
                    @if($program->description)
                    <p style="font-size:13px;color:#64748b;margin-bottom:12px;line-height:1.55;">
                        {{ Str::limit($program->description, 90) }}
                    </p>
                    @endif

                    {{-- Meta chips --}}
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="date-chip">
                            <i class="fa fa-location-dot" style="color:#1a56db;"></i>
                            {{ $program->venue }}
                        </span>
                        <span class="date-chip">
                            <i class="fa fa-calendar" style="color:#1a56db;"></i>
                            {{ $program->start_date->format('d M Y, h:i A') }}
                        </span>
                        <span class="date-chip">
                            <i class="fa fa-calendar-check" style="color:#1a56db;"></i>
                            {{ $program->end_date->format('d M Y, h:i A') }}
                        </span>
                        @if($program->staffInCharge)
                        <span class="date-chip">
                            <i class="fa fa-user-tie" style="color:#1a56db;"></i>
                            {{ $program->staffInCharge->name }}
                        </span>
                        @endif
                    </div>

                    <hr style="margin:0 0 12px;border-color:#f1f5f9;">

                    {{-- Actions --}}
                    <div class="d-flex flex-wrap gap-2">

                        {{-- Edit --}}
                        <button class="action-btn btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-id="{{ $program->id }}"
                                data-title="{{ $program->title }}"
                                data-description="{{ $program->description }}"
                                data-venue="{{ $program->venue }}"
                                data-start="{{ $program->start_date->format('Y-m-d\TH:i') }}"
                                data-end="{{ $program->end_date->format('Y-m-d\TH:i') }}"
                                data-staff="{{ $program->staff_in_charge_id }}">
                            <i class="fa fa-pen"></i> Edit
                        </button>

                        {{-- Reschedule --}}
                        @if(!in_array($program->status, ['cancelled','completed']))
                        <button class="action-btn btn-reschedule"
                                data-bs-toggle="modal"
                                data-bs-target="#rescheduleModal"
                                data-id="{{ $program->id }}"
                                data-title="{{ $program->title }}"
                                data-start="{{ $program->start_date->format('Y-m-d\TH:i') }}"
                                data-end="{{ $program->end_date->format('Y-m-d\TH:i') }}">
                            <i class="fa fa-clock-rotate-left"></i> Reschedule
                        </button>
                        @endif

                        {{-- Cancel --}}
                        @if(!in_array($program->status, ['cancelled','completed']))
                        <button class="action-btn btn-cancel-p"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelModal"
                                data-id="{{ $program->id }}"
                                data-title="{{ $program->title }}">
                            <i class="fa fa-ban"></i> Cancel
                        </button>
                        @endif

                        {{-- Delete --}}
                        <button class="action-btn btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $program->id }}"
                                data-title="{{ $program->title }}">
                            <i class="fa fa-trash"></i> Delete
                        </button>

                        {{-- Committee --}}
                        <a href="{{ route('head.committee.index', $program->id) }}"
                        class="action-btn"
                        style="background:#e0e7ff;color:#3730a3;text-decoration:none;">
                            <i class="fa fa-users"></i> Committee
                        </a>



                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $programs->links() }}
    </div>

@endif


{{-- ══════════════════════════════════════════
     MODAL: Edit Program
══════════════════════════════════════════ --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-pen me-2 text-primary"></i>Edit Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Program Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Venue</label>
                            <input type="text" name="venue" id="edit_venue" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date & Time</label>
                            <input type="datetime-local" name="start_date" id="edit_start" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date & Time</label>
                            <input type="datetime-local" name="end_date" id="edit_end" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Staff in Charge</label>
                            <select name="staff_in_charge_id" id="edit_staff" class="form-select">
                                <option value="">— None —</option>
                                @foreach(\App\Models\Staff::orderBy('name')->get() as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom">
                        <i class="fa fa-floppy-disk me-1"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL: Reschedule
══════════════════════════════════════════ --}}
<div class="modal fade" id="rescheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-clock-rotate-left me-2" style="color:#b45309;"></i>Reschedule Program
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rescheduleForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p style="font-size:14px;color:#64748b;margin-bottom:20px;">
                        Update the dates for <strong id="reschedule_title" style="color:#0f172a;"></strong>.
                    </p>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">New Start Date & Time</label>
                            <input type="datetime-local" name="start_date" id="reschedule_start" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">New End Date & Time</label>
                            <input type="datetime-local" name="end_date" id="reschedule_end" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-custom" style="background:linear-gradient(135deg,#92400e,#f59e0b);">
                        <i class="fa fa-clock-rotate-left me-1"></i>Reschedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL: Cancel
══════════════════════════════════════════ --}}
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-ban me-2" style="color:#c2410c;"></i>Cancel Program
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="background:#fff7ed;border:1.5px solid #fed7aa;border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;">
                    <i class="fa fa-triangle-exclamation" style="color:#c2410c;font-size:20px;flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <p style="font-size:14px;color:#7c2d12;margin:0;font-weight:600;">Are you sure?</p>
                        <p style="font-size:13.5px;color:#9a3412;margin:4px 0 0;">
                            You are about to cancel <strong id="cancel_title"></strong>. This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Go Back</button>
                <form id="cancelForm" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-danger-custom" style="background:linear-gradient(135deg,#9a3412,#f97316);">
                        <i class="fa fa-ban me-1"></i>Yes, Cancel It
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL: Delete
══════════════════════════════════════════ --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-trash me-2" style="color:#b91c1c;"></i>Delete Program
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div style="background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;padding:16px;display:flex;gap:12px;align-items:flex-start;">
                    <i class="fa fa-circle-exclamation" style="color:#b91c1c;font-size:20px;flex-shrink:0;margin-top:2px;"></i>
                    <div>
                        <p style="font-size:14px;color:#7f1d1d;margin:0;font-weight:600;">Permanently delete?</p>
                        <p style="font-size:13.5px;color:#991b1b;margin:4px 0 0;">
                            <strong id="delete_title"></strong> will be permanently removed and cannot be recovered.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer gap-2">
                <button type="button" class="btn-secondary-custom" data-bs-dismiss="modal">Go Back</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger-custom">
                        <i class="fa fa-trash me-1"></i>Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ══════════════════════════════════════════
       Modal wiring
    ══════════════════════════════════════════ */

    document.getElementById('editModal').addEventListener('show.bs.modal', e => {
        const btn  = e.relatedTarget;
        const form = document.getElementById('editForm');
        form.action = `/head/programs/${btn.dataset.id}`;
        document.getElementById('edit_title').value       = btn.dataset.title;
        document.getElementById('edit_description').value = btn.dataset.description;
        document.getElementById('edit_venue').value       = btn.dataset.venue;
        document.getElementById('edit_start').value       = btn.dataset.start;
        document.getElementById('edit_end').value         = btn.dataset.end;
        document.getElementById('edit_staff').value       = btn.dataset.staff;
    });

    document.getElementById('rescheduleModal').addEventListener('show.bs.modal', e => {
        const btn = e.relatedTarget;
        document.getElementById('rescheduleForm').action           = `/head/programs/${btn.dataset.id}/reschedule`;
        document.getElementById('reschedule_title').textContent    = btn.dataset.title;
        document.getElementById('reschedule_start').value          = btn.dataset.start;
        document.getElementById('reschedule_end').value            = btn.dataset.end;
    });

    document.getElementById('cancelModal').addEventListener('show.bs.modal', e => {
        const btn = e.relatedTarget;
        document.getElementById('cancelForm').action            = `/head/programs/${btn.dataset.id}/cancel`;
        document.getElementById('cancel_title').textContent     = btn.dataset.title;
    });

    document.getElementById('deleteModal').addEventListener('show.bs.modal', e => {
        const btn = e.relatedTarget;
        document.getElementById('deleteForm').action            = `/head/programs/${btn.dataset.id}`;
        document.getElementById('delete_title').textContent     = btn.dataset.title;
    });

    // Auto-open edit modal if ?edit=ID is in the URL
    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit');
    if (editId) {
        const btn = document.querySelector(`.btn-edit[data-id="${editId}"]`);
        if (btn) btn.click();
    }

    /* ══════════════════════════════════════════
       Search / Sort / Filter
    ══════════════════════════════════════════ */

    const searchInput   = document.getElementById('searchInput');
    const filterStatus  = document.getElementById('filterStatus');
    const sortBy        = document.getElementById('sortBy');
    const resetBtn      = document.getElementById('resetFilters');
    const grid          = document.getElementById('programsGrid');
    const noResults     = document.getElementById('noResults');
    const resultsCount  = document.getElementById('resultsCount');
    const visibleCount  = document.getElementById('visibleCount');
    const activeFilters = document.getElementById('activeFilters');
    const filterTags    = document.getElementById('filterTags');

    if (!grid) return; // no programs on page

    function applyFilters() {
        const search = searchInput.value.toLowerCase().trim();
        const status = filterStatus.value;
        const sort   = sortBy.value;

        const items = Array.from(grid.querySelectorAll('.program-item'));

        // ── Filter ──
        items.forEach(item => {
            const matchSearch = !search ||
                item.dataset.title.includes(search) ||
                item.dataset.venue.includes(search) ||
                item.dataset.staff.includes(search);

            const matchStatus = !status || item.dataset.status === status;

            item.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });

        // ── Sort visible items ──
        const visible = items.filter(i => i.style.display !== 'none');

        visible.sort((a, b) => {
            switch (sort) {
                case 'oldest':     return a.dataset.created - b.dataset.created;
                case 'title_asc':  return a.dataset.title.localeCompare(b.dataset.title);
                case 'title_desc': return b.dataset.title.localeCompare(a.dataset.title);
                case 'start_asc':  return a.dataset.start - b.dataset.start;
                case 'start_desc': return b.dataset.start - a.dataset.start;
                default:           return b.dataset.created - a.dataset.created; // newest
            }
        });

        visible.forEach(item => grid.appendChild(item));

        // ── UI feedback ──
        const count       = visible.length;
        const isFiltering = search || status;

        visibleCount.textContent          = count;
        resultsCount.style.display        = isFiltering ? 'block' : 'none';
        noResults.style.display           = count === 0 ? 'block' : 'none';

        // Active filter tags
        const tags = [];
        if (search) tags.push({ label: `"${search}"`, key: 'search' });
        if (status) tags.push({ label: ucfirst(status), key: 'status' });

        filterTags.innerHTML = tags.map(t => `
            <span class="filter-tag">
                ${t.label}
                <button onclick="clearFilter('${t.key}')" title="Remove filter">
                    <i class="fa fa-xmark"></i>
                </button>
            </span>
        `).join('');

        activeFilters.style.display = tags.length ? 'flex' : 'none';
    }

    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    window.clearFilter = function(key) {
        if (key === 'search') searchInput.value  = '';
        if (key === 'status') filterStatus.value = '';
        applyFilters();
    };

    resetBtn.addEventListener('click', () => {
        searchInput.value  = '';
        filterStatus.value = '';
        sortBy.value       = 'newest';
        applyFilters();
    });

    searchInput.addEventListener('input',   applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    sortBy.addEventListener('change',       applyFilters);

    applyFilters(); // run once on load

});
</script>
@endpush
