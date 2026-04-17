<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
</div>
@extends('layouts.app')

@section('page-title','All Programs — Vice Chancellor')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu  { animation:fadeUp .45s ease both; }
.d1  { animation-delay:.06s; }
.d2  { animation-delay:.12s; }
.d3  { animation-delay:.18s; }
.d4  { animation-delay:.24s; }
.d5  { animation-delay:.30s; }
.d6  { animation-delay:.36s; }

/* ── Hero ── */
.vc-hero {
    background:linear-gradient(128deg,#0a1f52 0%,#0f2d6e 50%,#1e40af 100%);
    border-radius:20px;padding:28px 32px;margin-bottom:24px;
    position:relative;overflow:hidden;
    box-shadow:0 12px 40px rgba(15,45,110,.22);
}
.vc-hero::before {
    content:'';position:absolute;width:300px;height:300px;border-radius:50%;
    background:rgba(245,158,11,.10);top:-90px;right:-60px;pointer-events:none;
}
.vc-hero::after {
    content:'';position:absolute;width:180px;height:180px;border-radius:50%;
    background:rgba(96,165,250,.08);bottom:-60px;left:35%;pointer-events:none;
}
.vc-hero h1   { font-size:1.55rem;font-weight:800;color:#fff;margin:0 0 5px; }
.vc-hero p    { font-size:13.5px;color:rgba(255,255,255,.62);margin:0; }
.hero-bottom  { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-top:20px; }
.hero-chips   { display:flex;gap:8px;flex-wrap:wrap; }
.hero-chip {
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
    border-radius:10px;padding:6px 13px;font-size:12px;font-weight:600;
    color:rgba(255,255,255,.88);display:inline-flex;align-items:center;gap:7px;
}
.hero-chip i { color:#f59e0b; }
.view-switcher { display:flex;gap:8px; }
.vs-btn {
    background:rgba(255,255,255,.13);border:1.5px solid rgba(255,255,255,.22);
    border-radius:11px;padding:9px 18px;color:rgba(255,255,255,.85);
    font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:8px;
    text-decoration:none;transition:all .22s;
}
.vs-btn:hover  { background:rgba(255,255,255,.22);color:#fff;text-decoration:none;transform:translateY(-1px); }
.vs-btn.active { background:#f59e0b;border-color:#f59e0b;color:#fff;box-shadow:0 4px 16px rgba(245,158,11,.38); }

/* ── Stat strip ── */
.stat-strip {
    display:grid;grid-template-columns:repeat(6,1fr);gap:13px;margin-bottom:22px;
}
@media(max-width:1200px){ .stat-strip{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:600px) { .stat-strip{ grid-template-columns:repeat(2,1fr); } }

.s-chip {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;
    padding:14px 16px;box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;cursor:default;
}
.s-chip:hover { transform:translateY(-3px);box-shadow:0 8px 22px rgba(15,45,110,.10); }
.s-chip-icon  { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;margin-bottom:10px; }
.s-chip-val   { font-size:1.65rem;font-weight:900;color:#0f172a;line-height:1; }
.s-chip-label { font-size:11.5px;color:#64748b;font-weight:600;margin-top:3px; }

/* ── Main card ── */
.prog-card {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;
    overflow:hidden;box-shadow:0 4px 24px rgba(15,45,110,.07);
}
.prog-stripe { height:5px;background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6); }

/* ── Toolbar ── */
.toolbar {
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:12px;padding:16px 22px;border-bottom:1px solid #f1f5f9;
}
.toolbar-left  { display:flex;align-items:center;gap:10px;flex-wrap:wrap; }
.toolbar-title { font-size:14px;font-weight:800;color:#0f172a; }
.count-pill    { background:#eff6ff;color:#1d4ed8;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px; }

.filter-pill {
    background:#f8faff;border:1.5px solid #e2e8f0;border-radius:20px;
    padding:5px 13px;font-size:12px;font-weight:700;color:#475569;
    cursor:pointer;transition:all .18s;white-space:nowrap;font-family:inherit;
}
.filter-pill:hover,.filter-pill.on { background:#eff6ff;border-color:#bfdbfe;color:#1d4ed8; }

.toolbar-right { display:flex;gap:8px;flex-wrap:wrap;align-items:center; }

.dept-sel {
    border:1.5px solid #e2e8f0;border-radius:10px;
    padding:8px 30px 8px 12px;font-size:13px;font-family:inherit;
    background:#f8faff;color:#475569;outline:none;cursor:pointer;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;transition:border-color .2s;
}
.dept-sel:focus { border-color:#1a56db; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0;border-radius:10px;
    padding:9px 14px 9px 35px;font-size:13.5px;font-family:inherit;
    background:#f8faff;color:#1e293b;width:210px;outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.10);background:#fff; }

/* ── Table ── */
.prog-table { width:100%;border-collapse:separate;border-spacing:0;font-size:13.5px; }
.prog-table thead th {
    background:#f8faff;color:#64748b;font-size:11px;font-weight:700;
    letter-spacing:.9px;text-transform:uppercase;padding:12px 16px;
    border-bottom:2px solid #e8effe;white-space:nowrap;
}
.prog-table tbody tr { transition:background .15s; }
.prog-table tbody tr:hover { background:#f8faff; }
.prog-table tbody td { padding:13px 16px;vertical-align:middle;border-bottom:1px solid #f1f5f9;color:#334155; }
.prog-table tbody tr:last-child td { border-bottom:none; }

.prog-dot  { width:10px;height:10px;border-radius:50%;flex-shrink:0; }
.p-title   { font-weight:700;color:#0f172a;font-size:14px; }
.p-venue   { font-size:12px;color:#94a3b8;margin-top:2px; }
.dept-tag  { background:#f1f5f9;color:#475569;font-size:12px;font-weight:600;padding:4px 10px;border-radius:7px;display:inline-flex;align-items:center;gap:5px; }
.date-cell { font-size:12.5px;color:#475569;font-weight:600;white-space:nowrap; }
.date-cell small { display:block;font-size:11px;color:#94a3b8;font-weight:500; }
.sic-av    { width:28px;height:28px;border-radius:8px;background:linear-gradient(135deg,#0f2d6e,#1a56db);display:flex;align-items:center;justify-content:center;color:#fff;font-size:10px;font-weight:800;flex-shrink:0; }

.sb { font-size:11.5px;font-weight:700;padding:4px 11px;border-radius:20px;display:inline-flex;align-items:center;gap:5px; }
.sb-upcoming    { background:#dbeafe;color:#1d4ed8; }
.sb-ongoing     { background:#dcfce7;color:#15803d; }
.sb-completed   { background:#e0e7ff;color:#3730a3; }
.sb-cancelled   { background:#fee2e2;color:#b91c1c; }
.sb-rescheduled { background:#fef9c3;color:#b45309; }

/* ── Committee toggle btn in table ── */
.cm-toggle-btn {
    display:inline-flex;align-items:center;gap:5px;
    background:#e0e7ff;color:#3730a3;border:none;border-radius:7px;
    padding:4px 10px;font-size:11.5px;font-weight:700;
    cursor:pointer;font-family:inherit;transition:all .18s;
}
.cm-toggle-btn:hover { background:#c7d2fe; }
.cm-toggle-btn .cm-chev { font-size:9px;transition:transform .25s ease; }
.cm-toggle-btn.open .cm-chev { transform:rotate(180deg); }

.view-btn {
    width:32px;height:32px;border-radius:8px;border:none;
    background:#eff6ff;color:#1d4ed8;font-size:13px;
    cursor:pointer;display:inline-flex;align-items:center;justify-content:center;
    transition:all .18s;
}
.view-btn:hover { background:#dbeafe;transform:scale(1.08); }

/* ── Committee expand row ── */
.cm-expand-row td {
    padding:0 !important;
    border-bottom:2px solid #e0e7ff !important;
    background:transparent !important;
}

.cm-expand-panel {
    background:linear-gradient(135deg,#f8faff,#eef2ff);
    border-top:1.5px solid #e0e7ff;
    padding:16px 22px 18px;
    animation:expandDown .22s ease;
}
@keyframes expandDown {
    from{opacity:0;transform:translateY(-6px);}
    to{opacity:1;transform:translateY(0);}
}

.cm-expand-header {
    display:flex;align-items:center;gap:8px;
    font-size:13px;font-weight:800;color:#1e293b;
    margin-bottom:14px;flex-wrap:wrap;
}
.cm-expand-header i {
    width:26px;height:26px;border-radius:7px;
    background:#e0e7ff;color:#4338ca;
    display:inline-flex;align-items:center;justify-content:center;font-size:12px;
}
.cm-member-count {
    background:#e0e7ff;color:#3730a3;
    font-size:11px;font-weight:700;
    padding:2px 8px;border-radius:20px;
}

/* ── Member cards grid ── */
.cm-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(210px,1fr));
    gap:10px;
}

.cm-card {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:13px;
    padding:12px 14px;display:flex;align-items:flex-start;gap:10px;
    position:relative;transition:all .2s;
    box-shadow:0 1px 6px rgba(15,45,110,.04);
}
.cm-card:hover { border-color:#bfdbfe;box-shadow:0 4px 14px rgba(15,45,110,.09);transform:translateY(-2px); }
.cm-card.is-lead { background:linear-gradient(135deg,#fffbeb,#fef9c3);border-color:#fde68a; }
.cm-card.is-lead:hover { border-color:#f59e0b; }

.cm-lead-crown {
    position:absolute;top:-8px;right:10px;
    background:#f59e0b;color:#fff;
    font-size:9.5px;font-weight:800;
    padding:2px 8px;border-radius:20px;
    display:flex;align-items:center;gap:3px;
    box-shadow:0 2px 8px rgba(245,158,11,.35);
}

.cm-av {
    width:38px;height:38px;border-radius:11px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:12px;font-weight:800;flex-shrink:0;
}
.cm-card.is-lead .cm-av { background:linear-gradient(135deg,#b45309,#f59e0b); }

.cm-name { font-size:13px;font-weight:700;color:#0f172a; }
.cm-pos  { font-size:11.5px;color:#94a3b8;margin-top:1px; }
.cm-resp { font-size:11.5px;color:#64748b;font-style:italic;margin-top:5px;line-height:1.4; }

.role-tag { font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;display:inline-flex;align-items:center;gap:3px;margin-top:5px; }
.role-committee_head   { background:#fef9c3;color:#b45309; }
.role-coordinator      { background:#e0e7ff;color:#3730a3; }
.role-secretary        { background:#dbeafe;color:#1d4ed8; }
.role-treasurer        { background:#dcfce7;color:#15803d; }
.role-facilitator      { background:#fce7f3;color:#9d174d; }
.role-committee_member { background:#f1f5f9;color:#475569; }

.cm-empty {
    text-align:center;padding:24px;color:#94a3b8;font-size:13px;
}
.cm-empty i { font-size:28px;display:block;margin-bottom:8px;color:#cbd5e1; }

/* ── Footer ── */
.prog-footer {
    display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;
    padding:14px 22px;border-top:1px solid #f1f5f9;font-size:13px;color:#64748b;
}

/* DT */
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_length { display:none; }
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius:8px!important;font-size:12.5px!important;font-weight:600!important;
    padding:4px 11px!important;border:none!important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background:linear-gradient(135deg,#0f2d6e,#1a56db)!important;color:#fff!important;border:none!important;
}

/* ── Detail modal ── */
.modal-content  { border:none!important;border-radius:18px!important;overflow:hidden;box-shadow:0 24px 60px rgba(15,45,110,.18)!important; }
.m-stripe       { height:5px; }
.modal-header   { border-bottom:1px solid #f1f5f9!important;padding:20px 24px 16px!important;background:#fff!important; }
.modal-title    { font-size:16px!important;font-weight:800!important;color:#0f172a!important; }
.modal-body     { padding:20px 24px!important; }
.modal-footer   { padding:14px 24px 20px!important;border-top:1px solid #f1f5f9!important;background:#fff!important; }
.d-row          { display:flex;gap:12px;padding:11px 0;border-bottom:1px solid #f8faff;font-size:13.5px; }
.d-row:last-child { border-bottom:none; }
.d-key          { width:130px;font-size:11.5px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;flex-shrink:0;padding-top:1px; }
.d-val          { color:#1e293b;font-weight:600;flex:1; }
.btn-dismiss    { background:#f1f5f9;color:#64748b;border:none;border-radius:10px;padding:10px 20px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .2s; }
.btn-dismiss:hover { background:#e2e8f0; }

/* modal committee section */
.modal-cm-section {
    margin-top:16px;
    border-top:1.5px solid #f1f5f9;
    padding-top:16px;
}
.modal-cm-title {
    font-size:12px;font-weight:700;color:#94a3b8;
    text-transform:uppercase;letter-spacing:.5px;
    margin-bottom:12px;display:flex;align-items:center;gap:7px;
}
.modal-cm-title i {
    width:22px;height:22px;border-radius:6px;
    background:#e0e7ff;color:#4338ca;
    display:inline-flex;align-items:center;justify-content:center;font-size:10px;
}
.modal-cm-grid {
    display:flex;flex-direction:column;gap:8px;
    max-height:260px;overflow-y:auto;
    padding-right:4px;
}
.modal-cm-grid::-webkit-scrollbar { width:4px; }
.modal-cm-grid::-webkit-scrollbar-thumb { background:#e2e8f0;border-radius:10px; }

.modal-cm-item {
    display:flex;align-items:center;gap:10px;
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:11px;padding:10px 12px;
    transition:all .18s;
}
.modal-cm-item:hover { border-color:#bfdbfe;background:#f0f6ff; }
.modal-cm-item.modal-lead { background:linear-gradient(135deg,#fffbeb,#fef9c3);border-color:#fde68a; }

.modal-cm-av {
    width:34px;height:34px;border-radius:9px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:11px;font-weight:800;flex-shrink:0;
}
.modal-lead .modal-cm-av { background:linear-gradient(135deg,#b45309,#f59e0b); }

.modal-cm-name { font-size:13px;font-weight:700;color:#0f172a; }
.modal-cm-role { font-size:11px;color:#64748b;margin-top:1px; }
.modal-cm-resp { font-size:11px;color:#94a3b8;font-style:italic;margin-top:2px; }
.modal-lead-crown {
    margin-left:auto;flex-shrink:0;
    background:#f59e0b;color:#fff;
    font-size:9px;font-weight:800;
    padding:2px 7px;border-radius:20px;
}
.modal-cm-empty {
    text-align:center;padding:20px;color:#94a3b8;font-size:13px;
}
</style>
@endpush

@section('content')

@php
    $programs    = $programs    ?? collect();
    $departments = $departments ?? collect();

    $counts = [
        'total'       => $programs->count(),
        'upcoming'    => $programs->where('status','upcoming')->count(),
        'ongoing'     => $programs->where('status','ongoing')->count(),
        'completed'   => $programs->where('status','completed')->count(),
        'cancelled'   => $programs->where('status','cancelled')->count(),
        'rescheduled' => $programs->where('status','rescheduled')->count(),
    ];

    $dotColor = ['upcoming'=>'#3b82f6','ongoing'=>'#16a34a','completed'=>'#6366f1','rescheduled'=>'#f59e0b','cancelled'=>'#ef4444'];
    $sbClass  = ['upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing','completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled'];
    $sbIcon   = ['upcoming'=>'fa-clock','ongoing'=>'fa-circle-play','completed'=>'fa-circle-check','cancelled'=>'fa-ban','rescheduled'=>'fa-clock-rotate-left'];

    $roleLabels = [
        'committee_head'   => 'Committee Head',
        'coordinator'      => 'Coordinator',
        'secretary'        => 'Secretary',
        'treasurer'        => 'Treasurer',
        'facilitator'      => 'Facilitator',
        'committee_member' => 'Committee Member',
    ];
    $roleIcons = [
        'committee_head'=>'fa-crown','coordinator'=>'fa-star',
        'secretary'=>'fa-pen-clip','treasurer'=>'fa-coins',
        'facilitator'=>'fa-chalkboard-user','committee_member'=>'fa-user',
    ];
@endphp

{{-- Hero --}}
<div class="vc-hero fu">
    <h1><i class="fa fa-layer-group me-2" style="color:#f59e0b;"></i>Programs Overview</h1>
    <p>Read-only view of all programs across every department.</p>
    <div class="hero-bottom">
        <div class="hero-chips">
            <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('d F Y') }}</span>
            <span class="hero-chip"><i class="fa fa-layer-group"></i>{{ $counts['total'] }} programs</span>
            <span class="hero-chip"><i class="fa fa-building"></i>{{ $departments->count() }} departments</span>
        </div>
        <div class="view-switcher">
            <a href="{{ route('vc.programs') }}" class="vs-btn active">
                <i class="fa fa-list"></i> List
            </a>
            <a href="{{ route('vc.calendar') }}" class="vs-btn">
                <i class="fa fa-calendar-days"></i> Calendar
            </a>
        </div>
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    @foreach([
        ['Total',       $counts['total'],       'fa-layer-group',       '#eff6ff','#1d4ed8'],
        ['Upcoming',    $counts['upcoming'],    'fa-clock',             '#dbeafe','#1d4ed8'],
        ['Ongoing',     $counts['ongoing'],     'fa-circle-play',       '#dcfce7','#15803d'],
        ['Completed',   $counts['completed'],   'fa-circle-check',      '#e0e7ff','#4338ca'],
        ['Rescheduled', $counts['rescheduled'], 'fa-clock-rotate-left', '#fef9c3','#b45309'],
        ['Cancelled',   $counts['cancelled'],   'fa-ban',               '#fee2e2','#b91c1c'],
    ] as $i => [$lbl,$val,$ico,$bg,$col])
    <div class="s-chip fu d{{ $i + 1 }}">
        <div class="s-chip-icon" style="background:{{ $bg }};"><i class="fa {{ $ico }}" style="color:{{ $col }};"></i></div>
        <div class="s-chip-val">{{ $val }}</div>
        <div class="s-chip-label">{{ $lbl }}</div>
    </div>
    @endforeach
</div>

{{-- Table card --}}
<div class="prog-card fu d2">
    <div class="prog-stripe"></div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="toolbar-left">
            <span class="toolbar-title">All Programs</span>
            <span class="count-pill">{{ $counts['total'] }}</span>
            <button class="filter-pill on" data-f="all">All</button>
            <button class="filter-pill" data-f="upcoming">Upcoming</button>
            <button class="filter-pill" data-f="ongoing">Ongoing</button>
            <button class="filter-pill" data-f="completed">Completed</button>
        </div>
        <div class="toolbar-right">
            <select id="deptSel" class="dept-sel">
                <option value="">All Departments</option>
                @foreach($departments as $d)
                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                @endforeach
            </select>
            <div class="search-wrap">
                <i class="fa fa-magnifying-glass"></i>
                <input id="progSearch" type="text" class="search-inp" placeholder="Search...">
            </div>
        </div>
    </div>

    {{-- Table — NO cm-expand-row rows inside here at all --}}
    <div class="table-responsive">
        <table id="progTable" class="prog-table">
            <thead>
                <tr>
                    <th width="44">#</th>
                    <th>Program</th>
                    <th>Department</th>
                    <th>Staff in Charge</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th width="100">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programs as $i => $p)
                @php $memberCount = $p->committee ? $p->committee->count() : 0; @endphp

                <tr data-status="{{ $p->status }}" data-dept="{{ $p->department_id }}">

                    <td style="color:#94a3b8;font-weight:600;font-size:13px;">{{ $i + 1 }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="prog-dot" style="background:{{ $dotColor[$p->status] ?? '#94a3b8' }};"></div>
                            <div>
                                <div class="p-title">{{ $p->title }}</div>
                                <div class="p-venue">
                                    <i class="fa fa-location-dot me-1"></i>{{ $p->venue }}
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="dept-tag">
                            <i class="fa fa-building" style="font-size:10px;"></i>
                            {{ $p->department->name ?? '—' }}
                        </span>
                    </td>

                    <td>
                        @if($p->staffInCharge)
                            <div class="d-flex align-items-center gap-2">
                                <div class="sic-av">{{ strtoupper(substr($p->staffInCharge->name,0,2)) }}</div>
                                <span style="font-size:13px;font-weight:600;color:#334155;">{{ $p->staffInCharge->name }}</span>
                            </div>
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>

                    <td class="date-cell">
                        {{ $p->start_date->format('d M Y') }}
                        <small>{{ $p->start_date->format('h:i A') }}</small>
                    </td>

                    <td class="date-cell">
                        {{ $p->end_date->format('d M Y') }}
                        <small>{{ $p->end_date->format('h:i A') }}</small>
                    </td>

                    <td>
                        <span class="sb {{ $sbClass[$p->status] ?? 'sb-upcoming' }}">
                            <i class="fa {{ $sbIcon[$p->status] ?? 'fa-clock' }}" style="font-size:10px;"></i>
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex align-items-center" style="gap:6px;">
                            <button class="cm-toggle-btn"
                                    id="cm-btn-{{ $p->id }}"
                                    onclick="toggleCmRow({{ $p->id }})">
                                <i class="fa fa-users" style="font-size:10px;"></i>
                                {{ $memberCount }}
                                <i class="fa fa-chevron-down cm-chev"></i>
                            </button>
                            <button class="view-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-id="{{ $p->id }}"
                                    data-title="{{ $p->title }}"
                                    data-dept="{{ $p->department->name ?? '—' }}"
                                    data-venue="{{ $p->venue }}"
                                    data-start="{{ $p->start_date->format('d M Y, h:i A') }}"
                                    data-end="{{ $p->end_date->format('d M Y, h:i A') }}"
                                    data-status="{{ $p->status }}"
                                    data-sic="{{ $p->staffInCharge->name ?? '—' }}"
                                    data-desc="{{ $p->description ?? '' }}">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:52px 20px;color:#94a3b8;">
                        <i class="fa fa-calendar-xmark" style="font-size:38px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                        No programs found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="prog-footer">
        <div id="dtInfo"></div>
        <div id="dtPaginate"></div>
    </div>
</div>


{{-- ── Committee expand panels — stored OUTSIDE the DataTable ── --}}
{{-- These are detached from here and injected after each row by JS --}}
<div id="cm-panels-store" style="display:none;">
    @foreach($programs as $p)
    @php $memberCount = $p->committee ? $p->committee->count() : 0; @endphp
    <table style="width:100%;"><tbody>
        <tr class="cm-expand-row" id="cm-row-{{ $p->id }}">
            <td colspan="8">
                <div class="cm-expand-panel">
                    <div class="cm-expand-header">
                        <i class="fa fa-users-gear"></i>
                        Committee — <strong>{{ $p->title }}</strong>
                        <span class="cm-member-count">{{ $memberCount }} {{ Str::plural('member', $memberCount) }}</span>
                    </div>

                    @if($memberCount > 0)
                    <div class="cm-grid">
                        @foreach($p->committee->sortByDesc('pivot.is_lead') as $member)
                        @php
                            $isLead = $member->pivot->is_lead;
                            $role   = $member->pivot->role;
                        @endphp
                        <div class="cm-card {{ $isLead ? 'is-lead' : '' }}">
                            @if($isLead)
                            <div class="cm-lead-crown">
                                <i class="fa fa-crown" style="font-size:8px;"></i> Lead
                            </div>
                            @endif
                            <div class="cm-av">{{ strtoupper(substr($member->name,0,2)) }}</div>
                            <div style="flex:1;min-width:0;">
                                <div class="cm-name">{{ $member->name }}</div>
                                <div class="cm-pos">{{ $member->position ?? $member->staff_id }}</div>
                                <span class="role-tag role-{{ $role }}">
                                    <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}" style="font-size:9px;"></i>
                                    {{ $roleLabels[$role] ?? ucfirst($role) }}
                                </span>
                                @if($member->pivot->responsibility)
                                <div class="cm-resp">
                                    <i class="fa fa-note-sticky me-1" style="font-size:10px;"></i>
                                    {{ $member->pivot->responsibility }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="cm-empty">
                        <i class="fa fa-user-slash"></i>
                        No committee members assigned to this program.
                    </div>
                    @endif
                </div>
            </td>
        </tr>
    </tbody></table>
    @endforeach
</div>


{{-- ── Detail Modal ── --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="m-stripe" id="mStripe"></div>
            <div class="modal-header">
                <h5 class="modal-title" id="mTitle"></h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-row"><div class="d-key">Department</div><div class="d-val" id="mDept"></div></div>
                <div class="d-row"><div class="d-key">Venue</div><div class="d-val" id="mVenue"></div></div>
                <div class="d-row"><div class="d-key">Start</div><div class="d-val" id="mStart"></div></div>
                <div class="d-row"><div class="d-key">End</div><div class="d-val" id="mEnd"></div></div>
                <div class="d-row"><div class="d-key">Status</div><div class="d-val" id="mStatus"></div></div>
                <div class="d-row"><div class="d-key">Staff in Charge</div><div class="d-val" id="mSic"></div></div>
                <div class="d-row" id="mDescRow"><div class="d-key">Description</div><div class="d-val" id="mDesc" style="white-space:pre-line;"></div></div>

                <div class="modal-cm-section">
                    <div class="modal-cm-title">
                        <i class="fa fa-users-gear"></i>
                        Committee Members
                        <span id="mCmCount" style="background:#e0e7ff;color:#3730a3;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;margin-left:4px;"></span>
                    </div>
                    <div class="modal-cm-grid" id="mCmGrid">
                        <div class="modal-cm-empty">Loading...</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-dismiss" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // ── Step 1: Pull expand rows out of the hidden store and index them ──
    var _cmRows = {};
    $('#cm-panels-store tr.cm-expand-row').each(function () {
        var id = this.id.replace('cm-row-', '');
        _cmRows[id] = $(this).clone(true); // clone so we keep the original in store
    });

    // ── Step 2: Init DataTable — tbody is clean, no colspan rows ──
    var table = $('#progTable').DataTable({
        responsive: true,
        pageLength: 15,
        dom: 'tip',
        language: {
            info: 'Showing _START_–_END_ of _TOTAL_ programs',
            infoEmpty: 'No programs found',
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next: '<i class="fa fa-chevron-right"></i>'
            }
        },
        initComplete: function () {
            $('#progTable_info').appendTo('#dtInfo');
            $('#progTable_paginate').appendTo('#dtPaginate');

            // ── Step 3: Inject expand rows after each data row ──
            $('#progTable tbody tr').each(function () {
                var btn = $(this).find('[id^="cm-btn-"]');
                if (btn.length) {
                    var id = btn.attr('id').replace('cm-btn-', '');
                    if (_cmRows[id]) {
                        $(this).after(
                            $('<tr class="cm-expand-row" id="cm-row-' + id + '" style="display:none;"><td colspan="8" style="padding:0!important;border-bottom:2px solid #e0e7ff!important;background:transparent!important;"></td></tr>')
                        );
                        // Move the panel content into the injected row
                        $('#cm-row-' + id + ' td').append(
                            _cmRows[id].find('td > div.cm-expand-panel').clone(true)
                        );
                    }
                }
            });
        }
    });

    // ── Search ──
    $('#progSearch').on('input', function () {
        table.search(this.value).draw();
    });

    // ── Status / dept filter ──
    var curStatus = 'all', curDept = '';

    function applyFilter() {
        $('#progTable tbody tr').each(function () {
            if ($(this).hasClass('cm-expand-row')) return;
            var s = $(this).data('status');
            var d = String($(this).data('dept'));
            if (s === undefined) return;
            var ok = (curStatus === 'all' || s === curStatus) && (curDept === '' || d === curDept);
            $(this).toggle(ok);
            // hide expand row when parent is hidden
            var btn = $(this).find('[id^="cm-btn-"]');
            if (btn.length) {
                var pid = btn.attr('id').replace('cm-btn-', '');
                if (!ok) {
                    $('#cm-row-' + pid).hide();
                    $('#cm-btn-' + pid).removeClass('open');
                }
            }
        });
    }

    $('.filter-pill').on('click', function () {
        $('.filter-pill').removeClass('on');
        $(this).addClass('on');
        curStatus = $(this).data('f');
        applyFilter();
    });

    $('#deptSel').on('change', function () {
        curDept = $(this).val();
        applyFilter();
    });

});

// ── Toggle committee expand row ──
function toggleCmRow(id) {
    var row    = document.getElementById('cm-row-' + id);
    var btn    = document.getElementById('cm-btn-' + id);
    if (!row) return;
    var isOpen = row.style.display !== 'none';
    row.style.display = isOpen ? 'none' : 'table-row';
    btn.classList.toggle('open', !isOpen);
}

// ── Programs JSON for modal committee list ──
var programsData = @json($programsJson ?? []);

var stripes = {
    upcoming:    'linear-gradient(90deg,#1d4ed8,#60a5fa)',
    ongoing:     'linear-gradient(90deg,#15803d,#4ade80)',
    completed:   'linear-gradient(90deg,#4338ca,#818cf8)',
    rescheduled: 'linear-gradient(90deg,#b45309,#fbbf24)',
    cancelled:   'linear-gradient(90deg,#b91c1c,#f87171)',
};
var sbHtml = {
    upcoming:    '<span class="sb sb-upcoming"><i class="fa fa-clock" style="font-size:10px"></i> Upcoming</span>',
    ongoing:     '<span class="sb sb-ongoing"><i class="fa fa-circle-play" style="font-size:10px"></i> Ongoing</span>',
    completed:   '<span class="sb sb-completed"><i class="fa fa-circle-check" style="font-size:10px"></i> Completed</span>',
    rescheduled: '<span class="sb sb-rescheduled"><i class="fa fa-clock-rotate-left" style="font-size:10px"></i> Rescheduled</span>',
    cancelled:   '<span class="sb sb-cancelled"><i class="fa fa-ban" style="font-size:10px"></i> Cancelled</span>',
};

document.getElementById('detailModal').addEventListener('show.bs.modal', function (e) {
    var b   = e.relatedTarget;
    var s   = b.dataset.status;
    var pid = b.dataset.id;

    document.getElementById('mTitle').textContent        = b.dataset.title;
    document.getElementById('mStripe').style.background  = stripes[s] || '#1a56db';
    document.getElementById('mDept').textContent         = b.dataset.dept;
    document.getElementById('mVenue').textContent        = b.dataset.venue;
    document.getElementById('mStart').textContent        = b.dataset.start;
    document.getElementById('mEnd').textContent          = b.dataset.end;
    document.getElementById('mStatus').innerHTML         = sbHtml[s] || s;
    document.getElementById('mSic').textContent          = b.dataset.sic;

    var desc = b.dataset.desc;
    document.getElementById('mDescRow').style.display = desc ? 'flex' : 'none';
    document.getElementById('mDesc').textContent      = desc;

    // Committee list
    var grid    = document.getElementById('mCmGrid');
    var count   = document.getElementById('mCmCount');
    var prog    = programsData[pid];
    var members = (prog && prog.committee) ? prog.committee : [];

    count.textContent = members.length + ' ' + (members.length === 1 ? 'member' : 'members');

    if (members.length === 0) {
        grid.innerHTML = '<div class="modal-cm-empty"><i class="fa fa-user-slash" style="font-size:24px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>No committee members assigned.</div>';
        return;
    }

    var html = '';
    members.forEach(function (m) {
        var avBg = m.is_lead
            ? 'linear-gradient(135deg,#b45309,#f59e0b)'
            : 'linear-gradient(135deg,#0f2d6e,#1a56db)';

        html += '<div class="modal-cm-item ' + (m.is_lead ? 'modal-lead' : '') + '">';
        html += '<div class="modal-cm-av" style="background:' + avBg + ';">' + m.initials + '</div>';
        html += '<div style="flex:1;min-width:0;">';
        html += '<div class="modal-cm-name">' + m.name + '</div>';
        html += '<div class="modal-cm-role">' + m.role_label;
        if (m.position) html += ' · ' + m.position;
        html += '</div>';
        if (m.responsibility) {
            html += '<div class="modal-cm-resp"><i class="fa fa-note-sticky" style="font-size:10px;margin-right:4px;"></i>' + m.responsibility + '</div>';
        }
        html += '</div>';
        if (m.is_lead) {
            html += '<span class="modal-lead-crown"><i class="fa fa-crown" style="font-size:8px;"></i> Lead</span>';
        }
        html += '</div>';
    });

    grid.innerHTML = html;
});
</script>
@endpush
