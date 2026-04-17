@extends('layouts.app')

@section('page-title', 'Department Overview — ' . $department->name)

@push('styles')
<style>

/* ── Animations ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fillBar {
    from { width:0; }
    to   { width:var(--w); }
}
@keyframes shimmer {
    0%   { background-position:-200% center; }
    100% { background-position:200% center; }
}

.fu { animation:fadeUp .44s ease both; }
.d1{animation-delay:.06s;}.d2{animation-delay:.12s;}
.d3{animation-delay:.18s;}.d4{animation-delay:.24s;}
.d5{animation-delay:.30s;}.d6{animation-delay:.36s;}

/* ── Hero ── */
.hod-hero {
    background:linear-gradient(132deg,#0c1445 0%,#1a237e 40%,#283593 70%,#3949ab 100%);
    border-radius:22px;
    padding:0;
    margin-bottom:26px;
    position:relative;
    overflow:hidden;
    box-shadow:0 16px 48px rgba(26,35,126,.30);
}
.hod-hero::before {
    content:'';position:absolute;inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,.03) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.03) 1px,transparent 1px);
    background-size:36px 36px;pointer-events:none;
}
.hod-hero::after {
    content:'';position:absolute;
    width:420px;height:420px;border-radius:50%;
    background:radial-gradient(circle,rgba(255,235,59,.14) 0%,transparent 70%);
    top:-120px;right:-80px;pointer-events:none;
}

.hero-inner {
    position:relative;z-index:1;
    padding:32px 36px;
    display:flex;align-items:flex-start;
    justify-content:space-between;gap:20px;flex-wrap:wrap;
}

.hero-dept-code {
    font-size:11px;font-weight:800;letter-spacing:3px;
    color:rgba(255,255,255,.45);text-transform:uppercase;
    margin-bottom:6px;display:flex;align-items:center;gap:8px;
}
.hero-dept-code::before {
    content:'';width:20px;height:2px;background:rgba(255,235,59,.6);border-radius:2px;
}

.hero-inner h1 {
    font-size:1.8rem;font-weight:900;color:#fff;
    margin:0 0 6px;line-height:1.15;letter-spacing:-.3px;
}
.hero-inner p { font-size:14px;color:rgba(255,255,255,.55);margin:0; }

.hero-chips { display:flex;gap:9px;flex-wrap:wrap;margin-top:20px; }
.hero-chip {
    background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);
    border-radius:10px;padding:7px 14px;font-size:12.5px;font-weight:600;
    color:rgba(255,255,255,.88);display:inline-flex;align-items:center;gap:7px;
    backdrop-filter:blur(6px);
}
.hero-chip i { color:#ffeb3b; }
.hero-chip.warn { border-color:rgba(239,68,68,.4); }
.hero-chip.warn i { color:#f87171; }

.hero-emblem {
    width:76px;height:76px;border-radius:20px;
    background:rgba(255,255,255,.10);border:1.5px solid rgba(255,255,255,.20);
    display:flex;align-items:center;justify-content:center;
    font-size:34px;color:#ffeb3b;
    backdrop-filter:blur(8px);box-shadow:0 8px 28px rgba(0,0,0,.20);
    position:relative;z-index:1;
}

/* hero bottom bar */
.hero-bar {
    position:relative;z-index:1;
    display:flex;border-top:1px solid rgba(255,255,255,.10);
}
.hb-item {
    flex:1;padding:15px 22px;border-right:1px solid rgba(255,255,255,.08);
    text-align:center;transition:background .2s;
}
.hb-item:last-child{border-right:none;}
.hb-item:hover{background:rgba(255,255,255,.05);}
.hb-val   {font-size:1.7rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-1px;}
.hb-label {font-size:11px;font-weight:600;color:rgba(255,255,255,.45);margin-top:4px;text-transform:uppercase;letter-spacing:.8px;}

/* ── Section title ── */
.section-title {
    font-size:1.05rem;font-weight:800;color:#0f172a;
    display:flex;align-items:center;gap:10px;margin-bottom:16px;
}
.section-title-icon {
    width:32px;height:32px;border-radius:9px;
    display:inline-flex;align-items:center;justify-content:center;
    font-size:14px;flex-shrink:0;
}

/* ── Weekend alert strip ── */
.weekend-strip {
    background:linear-gradient(135deg,#fff7ed,#ffedd5);
    border:1.5px solid #fed7aa;border-radius:16px;
    padding:16px 22px;margin-bottom:22px;
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:12px;
}
.ws-left { display:flex;align-items:center;gap:12px; }
.ws-icon { width:40px;height:40px;border-radius:11px;background:#fff7ed;border:1.5px solid #fed7aa;display:flex;align-items:center;justify-content:center;font-size:18px;color:#c2410c; }
.ws-title { font-size:14px;font-weight:800;color:#7c2d12; }
.ws-sub   { font-size:12.5px;color:#92400e;margin-top:2px; }
.ws-avatars { display:flex;gap:4px;flex-wrap:wrap; }
.ws-av {
    width:34px;height:34px;border-radius:9px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:11px;font-weight:800;
    border:2px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,.12);
    cursor:default;
}

/* ── Staff cards grid ── */
.staff-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(420px,1fr));
    gap:18px;
}
@media(max-width:900px){ .staff-grid{ grid-template-columns:1fr; } }

/* ── Staff card ── */
.staff-card {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:20px;
    overflow:hidden;box-shadow:0 3px 18px rgba(15,45,110,.07);
    transition:box-shadow .22s,transform .22s;
}
.staff-card:hover {
    box-shadow:0 10px 32px rgba(15,45,110,.13);
    transform:translateY(-2px);
}

/* card accent stripe — changes based on merit level */
.card-stripe { height:4px; }
.stripe-high   { background:linear-gradient(90deg,#f59e0b,#fbbf24); }
.stripe-medium { background:linear-gradient(90deg,#0f2d6e,#1a56db); }
.stripe-low    { background:linear-gradient(90deg,#64748b,#94a3b8); }
.stripe-none   { background:#e2e8f0; }

/* card header */
.card-hdr {
    display:flex;align-items:flex-start;gap:14px;
    padding:18px 20px 14px;border-bottom:1px solid #f1f5f9;
}

.card-av {
    width:48px;height:48px;border-radius:14px;
    background:linear-gradient(135deg,#1a237e,#3949ab);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:15px;font-weight:800;flex-shrink:0;
    box-shadow:0 4px 12px rgba(26,35,126,.22);
}

.card-name  { font-size:15px;font-weight:800;color:#0f172a; }
.card-id    { font-size:12px;color:#94a3b8;margin-top:2px; }
.card-pos   { font-size:12px;font-weight:600;color:#475569;margin-top:3px; }

/* merit badge */
.merit-badge {
    margin-left:auto;flex-shrink:0;text-align:right;
}
.mb-val {
    font-size:1.8rem;font-weight:900;line-height:1;
    background:linear-gradient(135deg,#1a237e,#3949ab);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.mb-label { font-size:10.5px;color:#94a3b8;font-weight:600;margin-top:2px; }

/* merit bar in card */
.merit-bar-wrap { padding:0 20px 12px; }
.merit-bar-track { height:5px;background:#f1f5f9;border-radius:20px;overflow:hidden; }
.merit-bar-fill  { height:100%;border-radius:20px;animation:fillBar .9s cubic-bezier(.4,0,.2,1) both;animation-delay:.4s; }

/* ── Card tabs ── */
.card-tabs {
    display:flex;border-bottom:1px solid #f1f5f9;
    padding:0 20px;gap:0;
}
.card-tab {
    font-size:12.5px;font-weight:700;color:#94a3b8;
    padding:10px 14px;border-bottom:2px solid transparent;
    cursor:pointer;transition:all .2s;white-space:nowrap;
    display:flex;align-items:center;gap:5px;
    font-family:inherit;background:none;border-left:none;border-right:none;border-top:none;
}
.card-tab:hover { color:#475569; }
.card-tab.active { color:#1a237e;border-bottom-color:#1a237e; }
.card-tab .tab-count {
    background:#f1f5f9;color:#64748b;
    font-size:10px;font-weight:800;
    padding:1px 6px;border-radius:20px;
}
.card-tab.active .tab-count { background:#e8eaf6;color:#1a237e; }

/* ── Tab content ── */
.tab-pane { display:none;padding:12px 20px 16px; }
.tab-pane.active { display:block; }

/* program item */
.prog-item {
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:13px;padding:12px 14px;margin-bottom:8px;
    transition:all .18s;
}
.prog-item:hover { border-color:#bfdbfe;background:#f0f6ff; }
.prog-item:last-child { margin-bottom:0; }

.prog-item-top {
    display:flex;align-items:flex-start;
    justify-content:space-between;gap:10px;margin-bottom:8px;
}
.prog-title { font-size:13.5px;font-weight:700;color:#0f172a; }
.prog-dept  { font-size:12px;color:#94a3b8;margin-top:2px; }

/* status badges */
.sb{font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;flex-shrink:0;}
.sb-upcoming{background:#dbeafe;color:#1d4ed8;}
.sb-ongoing {background:#dcfce7;color:#15803d;}
.sb-completed{background:#e0e7ff;color:#3730a3;}
.sb-rescheduled{background:#fef9c3;color:#b45309;}
.sb-cancelled{background:#fee2e2;color:#b91c1c;}

/* role badge */
.role-tag{font-size:10.5px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;}
.role-committee_head   {background:#fef9c3;color:#b45309;}
.role-coordinator      {background:#e0e7ff;color:#3730a3;}
.role-secretary        {background:#dbeafe;color:#1d4ed8;}
.role-treasurer        {background:#dcfce7;color:#15803d;}
.role-facilitator      {background:#fce7f3;color:#9d174d;}
.role-committee_member {background:#f1f5f9;color:#475569;}
.role-attendee         {background:#eff6ff;color:#1d4ed8;}

/* date/time row */
.prog-datetime {
    display:flex;align-items:center;gap:12px;flex-wrap:wrap;
    font-size:12px;color:#475569;margin-top:6px;
}
.prog-datetime i { color:#94a3b8;font-size:11px; }
.prog-datetime .divider { color:#e2e8f0; }

/* weekend pills */
.wd-pills { display:flex;gap:5px;flex-wrap:wrap;margin-top:6px; }
.wd-pill  { font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;display:inline-flex;align-items:center;gap:4px; }
.wd-sat   { background:#fff7ed;color:#c2410c;border:1px solid #fed7aa; }
.wd-sun   { background:#fef2f2;color:#b91c1c;border:1px solid #fecaca; }

/* lead tag */
.lead-tag { background:#f59e0b;color:#fff;font-size:9.5px;font-weight:800;padding:2px 7px;border-radius:20px;display:inline-flex;align-items:center;gap:3px; }

/* responsibility */
.resp-note { font-size:11.5px;color:#64748b;font-style:italic;margin-top:5px; }

/* merit claim item */
.merit-item {
    display:flex;align-items:center;gap:10px;
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:11px;padding:10px 12px;margin-bottom:6px;
}
.merit-item:last-child { margin-bottom:0; }
.merit-icon { width:34px;height:34px;border-radius:9px;background:#e8eaf6;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0; }
.merit-title { font-size:13px;font-weight:700;color:#0f172a; }
.merit-prog  { font-size:11.5px;color:#94a3b8;margin-top:1px; }
.merit-pts   {
    margin-left:auto;font-size:1.2rem;font-weight:900;
    background:linear-gradient(135deg,#1a237e,#3949ab);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    flex-shrink:0;
}

/* empty state in tab */
.tab-empty { text-align:center;padding:28px 16px;color:#94a3b8; }
.tab-empty i { font-size:32px;display:block;margin-bottom:10px;color:#e2e8f0; }
.tab-empty p { font-size:13px;margin:0; }

/* no staff */
.no-staff {
    text-align:center;padding:60px 20px;color:#94a3b8;
    background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;
}
.no-staff i { font-size:48px;display:block;margin-bottom:16px;color:#cbd5e1; }

/* search bar */
.search-bar { position:relative;margin-bottom:18px; }
.search-bar i { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;pointer-events:none; }
.search-bar input {
    width:100%;border:1.5px solid #e2e8f0;border-radius:12px;
    padding:11px 14px 11px 42px;font-size:14px;font-family:inherit;
    background:#fff;color:#1e293b;outline:none;
    box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:border-color .2s,box-shadow .2s;
}
.search-bar input:focus {
    border-color:#3949ab;
    box-shadow:0 0 0 3px rgba(57,73,171,.12);
}

</style>
@endpush

@section('content')

@php
    $user              = Auth::user();
    $hour              = now()->hour;
    $greeting          = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');

    $staffOnWeekend    = $staffOnWeekend   ?? 0;
    $totalStaff        = $totalStaff       ?? 0;
    $totalPrograms     = $totalPrograms    ?? 0;
    $totalMeritsAwarded= $totalMeritsAwarded ?? 0;
    $maxMerits         = max($maxMerits ?? 1, 1);
    $roleLabels        = $roleLabels       ?? [];
    $roleIcons         = $roleIcons        ?? [];
    $staffData         = $staffData        ?? collect();

    $weekendStaff = $staffData->filter(fn($s) => $s['weekend_count'] > 0)->values();

    $sbClass = [
        'upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing',
        'completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled',
    ];
    $sbIcon = [
        'upcoming'=>'fa-clock','ongoing'=>'fa-circle-play',
        'completed'=>'fa-circle-check','cancelled'=>'fa-ban','rescheduled'=>'fa-clock-rotate-left',
    ];

    // stripe by merit level
    $stripeClass = fn($pts) => $pts >= 10 ? 'stripe-high' : ($pts >= 4 ? 'stripe-medium' : ($pts > 0 ? 'stripe-low' : 'stripe-none'));
@endphp

@php

    $staffPositionLabels = [
        'hd'    => 'Programme Secretariat',
        'ld'    => 'Head of Department',
        'staff' => 'Staff',
    ];

    $userRoleLabels = [
        'hd' => 'Programme Secretariat',
        'ld' => 'Head of Department',
        'vc' => 'Vice Chancellor',
    ];

@endphp

{{-- ══ HERO ══ --}}
<div class="hod-hero fu">
    <div class="hero-inner">
        <div>
            <div class="hero-dept-code">{{ $department->code }} · Department Overview</div>
            <h1>{{ $greeting }}, {{ $user->name }}</h1>
            <p>{{ $department->name }} — staff activities, programs & merit overview</p>
            <div class="hero-chips">
                <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('l, d F Y') }}</span>
                <span class="hero-chip"><i class="fa fa-users"></i>{{ $totalStaff }} staff members</span>
                <span class="hero-chip"><i class="fa fa-layer-group"></i>{{ $totalPrograms }} programs</span>
                <span class="hero-chip"><i class="fa fa-star"></i>{{ $totalMeritsAwarded }} merits awarded</span>
                @if($staffOnWeekend > 0)
                <span class="hero-chip warn">
                    <i class="fa fa-triangle-exclamation"></i>
                    {{ $staffOnWeekend }} staff on weekend duty
                </span>
                @endif
            </div>
        </div>
        {{-- <div class="hero-emblem"><i class="fa fa-building-columns"></i></div> --}}
    </div>

    {{-- Stats bar --}}
    <div class="hero-bar">
        <div class="hb-item">
            <div class="hb-val">{{ $totalStaff }}</div>
            <div class="hb-label">Total Staff</div>
        </div>
        <div class="hb-item">
            <div class="hb-val">{{ $totalPrograms }}</div>
            <div class="hb-label">Programs</div>
        </div>
        <div class="hb-item">
            <div class="hb-val" style="color:#ffeb3b;">{{ $totalMeritsAwarded }}</div>
            <div class="hb-label">Merits Awarded</div>
        </div>
        <div class="hb-item">
            <div class="hb-val" style="color:{{ $staffOnWeekend > 0 ? '#f87171' : '#4ade80' }};">{{ $staffOnWeekend }}</div>
            <div class="hb-label">Weekend Duty</div>
        </div>
    </div>
</div>

{{-- ══ WEEKEND ALERT ══ --}}
@if($weekendStaff->count() > 0)
<div class="weekend-strip fu d2">
    <div class="ws-left">
        <div class="ws-icon"><i class="fa fa-calendar-week"></i></div>
        <div>
            <div class="ws-title">
                <i class="fa fa-triangle-exclamation me-1"></i>
                Weekend Duty Alert
            </div>
            <div class="ws-sub">
                {{ $weekendStaff->count() }} staff in your department are working on weekends
            </div>
        </div>
    </div>
    <div class="ws-avatars">
        @foreach($weekendStaff->take(6) as $ws)
        <div class="ws-av" title="{{ $ws['name'] }}">{{ $ws['initials'] }}</div>
        @endforeach
        @if($weekendStaff->count() > 6)
        <div class="ws-av" style="background:#f1f5f9;color:#64748b;font-size:10px;">
            +{{ $weekendStaff->count() - 6 }}
        </div>
        @endif
    </div>
</div>
@endif

{{-- ══ STAFF GRID ══ --}}
<div class="section-title fu d2">
    <span class="section-title-icon" style="background:#e8eaf6;color:#1a237e;">
        <i class="fa fa-users"></i>
    </span>
    Staff Overview
    <span style="font-size:13px;font-weight:600;color:#64748b;margin-left:4px;">
        — {{ $totalStaff }} members
    </span>
</div>

{{-- Search --}}
<div class="search-bar fu d2">
    <i class="fa fa-magnifying-glass"></i>
    <input type="text" id="staffSearch" placeholder="Search staff by name or ID…">
</div>

@if($staffData->isEmpty())
<div class="no-staff fu d3">
    <i class="fa fa-users-slash"></i>
    <h5 style="font-weight:800;color:#475569;margin-bottom:8px;">No staff found</h5>
    <p style="font-size:13.5px;max-width:300px;margin:0 auto;">
        No staff members are currently assigned to {{ $department->name }}.
    </p>
</div>
@else

<div class="staff-grid" id="staffGrid">

    @foreach($staffData as $staff)
    @php
        $sc         = $stripeClass($staff['total_merits']);
        $barPct     = round(($staff['total_merits'] / $maxMerits) * 100);
        $progCount  = count($staff['programs']);
        $wkndCount  = count($staff['weekend_programs']);
        $meritCount = $staff['merit_claims']->count();
    @endphp

    <div class="staff-card"
         data-name="{{ strtolower($staff['name']) }}"
         data-sid="{{ strtolower($staff['staff_id']) }}">

        {{-- Accent stripe --}}
        <div class="card-stripe {{ $sc }}"></div>

        {{-- Card header --}}
        <div class="card-hdr">
            <div class="card-av">{{ $staff['initials'] }}</div>
            <div style="flex:1;min-width:0;">
                <div class="card-name">{{ $staff['name'] }}</div>
                <div class="card-id">
                    <i class="fa fa-id-badge me-1" style="font-size:10px;"></i>{{ $staff['staff_id'] }}
                </div>
                {{-- <div class="card-pos">{{ $staff['position'] }}</div> --}}

                <div class="card-pos">

                    {{-- Staff Position --}}
                    <span class="badge bg-primary">

                        {{ $staffPositionLabels[
                            $staff['position']
                        ] ?? $staff['position'] }}

                    </span>

                    {{-- User Role --}}
                    @if(!empty($staff['user_role']))

                        <span class="badge bg-warning text-dark">

                            {{ $userRoleLabels[
                                $staff['user_role']
                            ] ?? $staff['user_role'] }}

                        </span>

                    @endif

                </div>

                @if($wkndCount > 0)
                <span style="background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;margin-top:4px;">
                    <i class="fa fa-calendar-week" style="font-size:9px;"></i>
                    {{ $wkndCount }} weekend {{ Str::plural('program',$wkndCount) }}
                </span>
                @endif
            </div>
            <div class="merit-badge">
                <div class="mb-val">{{ $staff['total_merits'] }}</div>
                <div class="mb-label">merit pts</div>
            </div>
        </div>

        {{-- Merit bar --}}
        <div class="merit-bar-wrap">
            <div class="merit-bar-track">
                <div class="merit-bar-fill"
                     style="--w:{{ $barPct }}%;width:{{ $barPct }}%;
                            background:{{ $staff['total_merits'] >= 10 ? 'linear-gradient(90deg,#b45309,#f59e0b)' : ($staff['total_merits'] >= 4 ? 'linear-gradient(90deg,#1a237e,#3949ab)' : 'linear-gradient(90deg,#64748b,#94a3b8)') }};">
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="card-tabs">
            <button class="card-tab active"
                    onclick="switchTab({{ $staff['id'] }}, 'programs', this)">
                <i class="fa fa-layer-group" style="font-size:11px;"></i>
                Programs
                <span class="tab-count">{{ $progCount }}</span>
            </button>
            <button class="card-tab"
                    onclick="switchTab({{ $staff['id'] }}, 'weekend', this)">
                <i class="fa fa-calendar-week" style="font-size:11px;"></i>
                Weekend
                <span class="tab-count">{{ $wkndCount }}</span>
            </button>
            <button class="card-tab"
                    onclick="switchTab({{ $staff['id'] }}, 'merits', this)">
                <i class="fa fa-star" style="font-size:11px;"></i>
                Merits
                <span class="tab-count">{{ $meritCount }}</span>
            </button>
        </div>

        {{-- Tab: Programs ── --}}
        <div class="tab-pane active" id="tab-programs-{{ $staff['id'] }}">
            @forelse($staff['programs'] as $prog)
            <div class="prog-item">
                <div class="prog-item-top">
                    <div style="flex:1;min-width:0;">
                        <div class="prog-title">{{ $prog['title'] }}</div>
                        <div class="prog-dept">
                            <i class="fa fa-building me-1" style="font-size:10px;"></i>{{ $prog['department'] }}
                            &nbsp;·&nbsp;
                            <i class="fa fa-location-dot me-1" style="font-size:10px;"></i>{{ $prog['venue'] }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1" style="flex-shrink:0;">
                        <span class="sb {{ $sbClass[$prog['status']] ?? 'sb-upcoming' }}">
                            <i class="fa {{ $sbIcon[$prog['status']] ?? 'fa-clock' }}" style="font-size:9px;"></i>
                            {{ ucfirst($prog['status']) }}
                        </span>
                        @if($prog['role'] !== '—')
                        <span class="role-tag role-{{ $prog['role'] }}">
                            <i class="fa {{ $roleIcons[$prog['role']] ?? 'fa-user' }}" style="font-size:9px;"></i>
                            {{ $roleLabels[$prog['role']] ?? ucfirst($prog['role']) }}
                        </span>
                        @endif
                        @if($prog['is_lead'])
                        <span class="lead-tag"><i class="fa fa-crown" style="font-size:8px;"></i> Lead</span>
                        @endif
                    </div>
                </div>

                {{-- Date & time details ── --}}
                <div class="prog-datetime">
                    <span><i class="fa fa-calendar-days"></i> {{ $prog['start_date'] }}</span>
                    <span class="divider">—</span>
                    <span>{{ $prog['end_date'] }}</span>
                    <span><i class="fa fa-clock"></i> {{ $prog['start_time'] }} – {{ $prog['end_time'] }}</span>
                </div>

                @if($prog['is_weekend'] && count($prog['weekend_days']) > 0)
                <div class="wd-pills">
                    <span style="font-size:11px;color:#94a3b8;font-weight:600;">
                        <i class="fa fa-calendar-week me-1"></i>Weekend:
                    </span>
                    @foreach($prog['weekend_days'] as $wd)
                    <span class="wd-pill {{ $wd['day'] === 'Saturday' ? 'wd-sat' : 'wd-sun' }}">
                        <i class="fa fa-sun" style="font-size:9px;"></i>{{ $wd['short'] }}
                    </span>
                    @endforeach
                </div>
                @endif

                @if($prog['responsibility'])
                <div class="resp-note">
                    <i class="fa fa-note-sticky me-1" style="font-size:10px;"></i>{{ $prog['responsibility'] }}
                </div>
                @endif
            </div>
            @empty
            <div class="tab-empty">
                <i class="fa fa-calendar-xmark"></i>
                <p>Not in any program committees yet.</p>
            </div>
            @endforelse
        </div>

        {{-- Tab: Weekend ── --}}
        <div class="tab-pane" id="tab-weekend-{{ $staff['id'] }}">
            @forelse($staff['weekend_programs'] as $prog)
            <div class="prog-item" style="border-color:#fed7aa;background:#fff7ed;">
                <div class="prog-item-top">
                    <div style="flex:1;min-width:0;">
                        <div class="prog-title">{{ $prog['title'] }}</div>
                        <div class="prog-dept">
                            <i class="fa fa-building me-1" style="font-size:10px;"></i>{{ $prog['department'] }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1" style="flex-shrink:0;">
                        <span class="sb {{ $sbClass[$prog['status']] ?? 'sb-upcoming' }}">
                            {{ ucfirst($prog['status']) }}
                        </span>
                        @if($prog['role'] !== '—')
                        <span class="role-tag role-{{ $prog['role'] }}">
                            {{ $roleLabels[$prog['role']] ?? ucfirst($prog['role']) }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="prog-datetime">
                    <span><i class="fa fa-calendar-days"></i> {{ $prog['start_full'] }}</span>
                </div>
                <div class="wd-pills">
                    @foreach($prog['weekend_days'] as $wd)
                    <span class="wd-pill {{ $wd['day'] === 'Saturday' ? 'wd-sat' : 'wd-sun' }}">
                        <i class="fa fa-sun" style="font-size:9px;"></i>{{ $wd['short'] }}
                    </span>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="tab-empty">
                <i class="fa fa-umbrella-beach"></i>
                <p>No weekend commitments. Weekends free! 🎉</p>
            </div>
            @endforelse
        </div>

        {{-- Tab: Merits ── --}}
        <div class="tab-pane" id="tab-merits-{{ $staff['id'] }}">
            @forelse($staff['merit_claims'] as $claim)
            <div class="merit-item">
                <div class="merit-icon">
                    <i class="fa {{ $roleIcons[$claim->claim_type] ?? 'fa-star' }}" style="color:#3949ab;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="merit-title">{{ $roleLabels[$claim->claim_type] ?? ucfirst($claim->claim_type) }}</div>
                    <div class="merit-prog">{{ Str::limit($claim->program->title ?? '—', 36) }}</div>
                </div>
                <div class="merit-pts">+{{ $claim->merit_points }}</div>
            </div>
            @empty
            <div class="tab-empty">
                <i class="fa fa-star"></i>
                <p>No approved merits yet.</p>
            </div>
            @endforelse

            @if($staff['total_merits'] > 0)
            <div style="text-align:right;padding-top:10px;border-top:1px solid #f1f5f9;margin-top:8px;">
                <span style="font-size:11px;color:#94a3b8;font-weight:600;">Total: </span>
                <span style="font-size:1.2rem;font-weight:900;background:linear-gradient(135deg,#1a237e,#3949ab);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                    {{ $staff['total_merits'] }} pts
                </span>
            </div>
            @endif
        </div>

    </div>
    @endforeach

</div>
@endif

@endsection

@push('scripts')
<script>

/* ── Tab switching ── */
function switchTab(staffId, tabName, btn) {
    var card = btn.closest('.staff-card');

    // Deactivate all tabs and panes in this card
    card.querySelectorAll('.card-tab').forEach(function(t){ t.classList.remove('active'); });
    card.querySelectorAll('.tab-pane').forEach(function(p){ p.classList.remove('active'); });

    // Activate selected
    btn.classList.add('active');
    var pane = document.getElementById('tab-' + tabName + '-' + staffId);
    if (pane) pane.classList.add('active');
}

/* ── Search ── */
document.getElementById('staffSearch').addEventListener('input', function(){
    var q = this.value.toLowerCase();
    document.querySelectorAll('.staff-card').forEach(function(card){
        var name = card.dataset.name || '';
        var sid  = card.dataset.sid  || '';
        card.style.display = (name.includes(q) || sid.includes(q)) ? '' : 'none';
    });
});

</script>
@endpush
