@extends('layouts.app')

@section('page-title', 'Weekend Staff Monitor — Vice Chancellor')

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fillBar {
    from { width: 0%; }
    to   { width: var(--bar-width); }
}
.fu { animation:fadeUp .42s ease both; }
.d1 { animation-delay:.06s; }
.d2 { animation-delay:.12s; }
.d3 { animation-delay:.18s; }
.d4 { animation-delay:.24s; }
.d5 { animation-delay:.30s; }

/* ── Hero ── */
.ws-hero {
    background:linear-gradient(128deg,#1a1a2e 0%,#16213e 45%,#0f3460 100%);
    border-radius:20px; padding:28px 32px; margin-bottom:24px;
    position:relative; overflow:hidden;
    box-shadow:0 12px 40px rgba(0,0,0,.28);
}
.ws-hero::before {
    content:''; position:absolute; width:320px; height:320px; border-radius:50%;
    background:rgba(249,115,22,.08); top:-100px; right:-60px; pointer-events:none;
}
.ws-hero::after {
    content:''; position:absolute; width:200px; height:200px; border-radius:50%;
    background:rgba(239,68,68,.06); bottom:-70px; left:30%; pointer-events:none;
}
.ws-hero h1 { font-size:1.5rem; font-weight:800; color:#fff; margin:0 0 5px; }
.ws-hero p  { font-size:13.5px; color:rgba(255,255,255,.55); margin:0; }
.hero-meta  { display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; }
.hero-chip  {
    background:rgba(255,255,255,.10); border:1px solid rgba(255,255,255,.18);
    border-radius:10px; padding:6px 13px; font-size:12px; font-weight:600;
    color:rgba(255,255,255,.85); display:inline-flex; align-items:center; gap:7px;
}
.hero-chip i { color:#fb923c; }
.hero-chip.warn { border-color:rgba(239,68,68,.4); }
.hero-chip.warn i { color:#f87171; }

/* ── Stat strip ── */
.stat-strip {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:14px; margin-bottom:24px;
}
@media(max-width:900px) { .stat-strip { grid-template-columns:repeat(2,1fr); } }

.s-chip {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:14px;
    padding:16px 18px; display:flex; align-items:center; gap:13px;
    box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;
}
.s-chip:hover { transform:translateY(-3px); box-shadow:0 8px 22px rgba(15,45,110,.10); }
.s-chip-icon  { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:19px; flex-shrink:0; }
.s-chip-val   { font-size:1.7rem; font-weight:900; color:#0f172a; line-height:1; }
.s-chip-label { font-size:12px; color:#64748b; font-weight:600; margin-top:2px; }

/* ── Frequency leaderboard ── */
.freq-panel {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:18px;
    overflow:hidden; box-shadow:0 3px 18px rgba(15,45,110,.07);
    margin-bottom:22px;
}
.freq-stripe { height:5px; background:linear-gradient(90deg,#ea580c,#f97316,#fb923c); }
.freq-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px 14px; border-bottom:1px solid #f1f5f9;
}
.freq-title {
    font-size:14px; font-weight:800; color:#0f172a;
    display:flex; align-items:center; gap:8px;
}
.freq-title i {
    width:28px; height:28px; border-radius:8px;
    background:#fff7ed; color:#c2410c;
    display:inline-flex; align-items:center; justify-content:center; font-size:13px;
}

.freq-list { padding:10px 16px 14px; }

.freq-row {
    display:flex; align-items:center; gap:12px;
    padding:9px 6px;
    border-bottom:1px solid #f8faff;
    transition:background .15s;
    border-radius:10px;
}
.freq-row:last-child { border-bottom:none; }
.freq-row:hover { background:#f8faff; }

.freq-rank {
    width:26px; height:26px; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    font-size:12px; font-weight:800; flex-shrink:0;
}
.rank-1 { background:linear-gradient(135deg,#fbbf24,#f59e0b); color:#fff; box-shadow:0 2px 8px rgba(245,158,11,.35); }
.rank-2 { background:linear-gradient(135deg,#94a3b8,#64748b); color:#fff; }
.rank-3 { background:linear-gradient(135deg,#f97316,#ea580c); color:#fff; }
.rank-n { background:#f1f5f9; color:#64748b; }

.freq-av {
    width:34px; height:34px; border-radius:10px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:11px; font-weight:800; flex-shrink:0;
}

.freq-info { flex:1; min-width:0; }
.freq-name { font-size:13px; font-weight:700; color:#0f172a; }
.freq-dept { font-size:11.5px; color:#94a3b8; margin-top:1px; }

.freq-bar-wrap { flex:1; min-width:100px; max-width:200px; }
.freq-bar-track {
    height:8px; background:#f1f5f9; border-radius:20px; overflow:hidden;
}
.freq-bar-fill {
    height:100%; border-radius:20px;
    animation:fillBar .9s cubic-bezier(.4,0,.2,1) both;
    animation-delay:.3s;
}
.freq-bar-sat  { background:linear-gradient(90deg,#f97316,#fb923c); }
.freq-bar-sun  { background:linear-gradient(90deg,#ef4444,#f87171); }
.freq-bar-both { background:linear-gradient(90deg,#ea580c,#f97316); }

.freq-days {
    font-size:1.3rem; font-weight:900; line-height:1;
    color:#c2410c; flex-shrink:0; min-width:36px; text-align:right;
}
.freq-days-label { font-size:10px; color:#94a3b8; font-weight:600; }

.freq-badges { display:flex; gap:4px; flex-shrink:0; }
.freq-sat-badge {
    background:#fff7ed; color:#c2410c;
    border:1px solid #fed7aa; border-radius:20px;
    font-size:10px; font-weight:700;
    padding:2px 7px;
}
.freq-sun-badge {
    background:#fef2f2; color:#b91c1c;
    border:1px solid #fecaca; border-radius:20px;
    font-size:10px; font-weight:700;
    padding:2px 7px;
}

/* ── Filter bar ── */
.filter-bar {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; margin-bottom:20px;
}
.filter-left  { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.filter-right { display:flex; gap:8px; flex-wrap:wrap; }

.f-pill {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:20px;
    padding:6px 14px; font-size:12.5px; font-weight:700; color:#475569;
    cursor:pointer; transition:all .18s; font-family:inherit;
}
.f-pill:hover,.f-pill.on { background:#fff7ed; border-color:#fed7aa; color:#c2410c; }

.dept-sel {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:8px 30px 8px 12px; font-size:13px; font-family:inherit;
    background:#f8faff; color:#475569; outline:none; cursor:pointer; appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
}
.dept-sel:focus { border-color:#f97316; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:9px 14px 9px 36px; font-size:13.5px; font-family:inherit;
    background:#f8faff; color:#1e293b; width:220px; outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#f97316; box-shadow:0 0 0 3px rgba(249,115,22,.10); background:#fff; }

/* ── Frequency badge on card ── */
.freq-level {
    display:inline-flex; align-items:center; gap:5px;
    font-size:11px; font-weight:800; padding:3px 9px;
    border-radius:20px; flex-shrink:0;
}
.freq-high   { background:#fee2e2; color:#b91c1c; border:1px solid #fecaca; }
.freq-medium { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.freq-low    { background:#fef9c3; color:#b45309; border:1px solid #fde68a; }

/* ── Staff cards ── */
.staff-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(380px,1fr));
    gap:16px;
}
@media(max-width:800px) { .staff-grid { grid-template-columns:1fr; } }

.staff-card {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:18px;
    overflow:hidden; box-shadow:0 2px 14px rgba(15,45,110,.06);
    transition:box-shadow .22s,transform .22s;
}
.staff-card:hover { box-shadow:0 8px 28px rgba(15,45,110,.12); transform:translateY(-2px); }

/* card top stripe by frequency */
.card-freq-stripe { height:4px; }
.stripe-high   { background:linear-gradient(90deg,#b91c1c,#ef4444); }
.stripe-medium { background:linear-gradient(90deg,#c2410c,#f97316); }
.stripe-low    { background:linear-gradient(90deg,#b45309,#f59e0b); }

.staff-card-top {
    padding:16px 18px 14px; border-bottom:1px solid #f1f5f9;
    display:flex; align-items:flex-start; gap:13px;
}

.staff-av {
    width:46px; height:46px; border-radius:13px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:15px; font-weight:800; flex-shrink:0;
    box-shadow:0 3px 10px rgba(15,45,110,.20);
}

.staff-name { font-size:14.5px; font-weight:800; color:#0f172a; }
.staff-meta { font-size:12px; color:#94a3b8; margin-top:2px; }
.staff-dept {
    font-size:12px; font-weight:600; color:#475569; background:#f1f5f9;
    padding:3px 9px; border-radius:7px; display:inline-flex;
    align-items:center; gap:4px; margin-top:5px;
}

/* ── Frequency mini bar in card ── */
.card-freq-section {
    padding:10px 18px 12px;
    background:#fafafa;
    border-bottom:1px solid #f1f5f9;
}
.card-freq-row {
    display:flex; align-items:center; gap:10px; margin-bottom:6px;
}
.card-freq-row:last-child { margin-bottom:0; }
.cfl { font-size:11px; font-weight:700; color:#64748b; width:70px; flex-shrink:0; }
.cfb-track { flex:1; height:7px; background:#f1f5f9; border-radius:20px; overflow:hidden; }
.cfb-fill  { height:100%; border-radius:20px; animation:fillBar .8s cubic-bezier(.4,0,.2,1) both; animation-delay:.4s; }
.cfb-sat   { background:linear-gradient(90deg,#f97316,#fb923c); }
.cfb-sun   { background:linear-gradient(90deg,#ef4444,#f87171); }
.cfb-total { background:linear-gradient(90deg,#ea580c,#f97316); }
.cfv { font-size:11.5px; font-weight:800; color:#475569; width:28px; text-align:right; flex-shrink:0; }

.weekend-counter { margin-left:auto; flex-shrink:0; text-align:right; }
.wc-days {
    font-size:1.6rem; font-weight:900; line-height:1;
    background:linear-gradient(135deg,#ea580c,#f97316);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.wc-label  { font-size:10.5px; color:#94a3b8; font-weight:600; margin-top:2px; }
.wc-breakdown { font-size:11px; color:#64748b; margin-top:3px; }
.wc-sat { color:#f97316; font-weight:700; }
.wc-sun { color:#ef4444; font-weight:700; }

/* ── Programs list ── */
.prog-list { padding:12px 14px 14px; display:flex; flex-direction:column; gap:8px; }

.prog-item {
    background:#f8faff; border:1.5px solid #e8effe;
    border-radius:12px; padding:11px 13px;
    position:relative; transition:all .18s;
}
.prog-item:hover { border-color:#bfdbfe; background:#f0f6ff; }

.prog-item-top {
    display:flex; align-items:flex-start;
    justify-content:space-between; gap:8px; margin-bottom:8px;
}
.prog-item-title { font-size:13px; font-weight:700; color:#0f172a; }
.prog-item-dept  { font-size:11.5px; color:#94a3b8; margin-top:2px; }

.role-tag { font-size:10.5px; font-weight:700; padding:2px 8px; border-radius:20px; display:inline-flex; align-items:center; gap:3px; flex-shrink:0; }
.role-committee_head   { background:#fef9c3; color:#b45309; }
.role-coordinator      { background:#e0e7ff; color:#3730a3; }
.role-secretary        { background:#dbeafe; color:#1d4ed8; }
.role-treasurer        { background:#dcfce7; color:#15803d; }
.role-facilitator      { background:#fce7f3; color:#9d174d; }
.role-committee_member { background:#f1f5f9; color:#475569; }

.sb { font-size:10.5px; font-weight:700; padding:3px 8px; border-radius:20px; display:inline-flex; align-items:center; gap:4px; flex-shrink:0; }
.sb-upcoming    { background:#dbeafe; color:#1d4ed8; }
.sb-ongoing     { background:#dcfce7; color:#15803d; }
.sb-completed   { background:#e0e7ff; color:#3730a3; }
.sb-cancelled   { background:#fee2e2; color:#b91c1c; }
.sb-rescheduled { background:#fef9c3; color:#b45309; }

.weekend-days { display:flex; flex-wrap:wrap; gap:5px; margin-top:6px; }
.wd-pill {
    font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px;
    display:inline-flex; align-items:center; gap:4px;
}
.wd-saturday { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.wd-sunday   { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }

.lead-tag {
    background:#f59e0b; color:#fff; font-size:9.5px; font-weight:800;
    padding:2px 7px; border-radius:20px; display:inline-flex; align-items:center; gap:3px;
}

.empty-state {
    text-align:center; padding:60px 20px;
    background:#fff; border:1.5px solid #e2e8f0;
    border-radius:18px; color:#94a3b8;
}
.empty-state i { font-size:48px; display:block; margin-bottom:16px; color:#cbd5e1; }

.no-results { text-align:center; padding:40px 20px; color:#94a3b8; font-size:14px; display:none; }
</style>
@endpush

@section('content')

@php
    $weekendStaff         = $weekendStaff         ?? [];
    $departments          = $departments          ?? collect();
    $totalWeekendStaff    = $totalWeekendStaff    ?? 0;
    $totalWeekendPrograms = $totalWeekendPrograms ?? 0;
    $totalWeekendDays     = $totalWeekendDays     ?? 0;
    $mostWeekendStaff     = $mostWeekendStaff     ?? null;

    // Max days for bar scaling
    $maxDays = !empty($weekendStaff) ? max(array_column($weekendStaff, 'total_days')) : 1;

    $sbClass = [
        'upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing',
        'completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled',
    ];
    $sbIcon = [
        'upcoming'=>'fa-clock','ongoing'=>'fa-circle-play',
        'completed'=>'fa-circle-check','cancelled'=>'fa-ban','rescheduled'=>'fa-clock-rotate-left',
    ];

    // Frequency level: high ≥ 4 days, medium 2–3 days, low = 1 day
    $freqLevel = function($days) {
        if ($days >= 4) return ['label'=>'High Frequency',   'class'=>'freq-high',   'stripe'=>'stripe-high'];
        if ($days >= 2) return ['label'=>'Medium Frequency', 'class'=>'freq-medium', 'stripe'=>'stripe-medium'];
        return               ['label'=>'Low Frequency',    'class'=>'freq-low',    'stripe'=>'stripe-low'];
    };
@endphp

{{-- Hero --}}
<div class="ws-hero fu">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fa fa-calendar-week me-2" style="color:#fb923c;"></i>Weekend Staff Monitor</h1>
            <p>Staff members committed to programs running on Saturdays or Sundays — sorted by frequency.</p>
            <div class="hero-meta">
                <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('d F Y') }}</span>
                <span class="hero-chip"><i class="fa fa-users"></i>{{ $totalWeekendStaff }} staff on weekends</span>
                <span class="hero-chip"><i class="fa fa-layer-group"></i>{{ $totalWeekendPrograms }} programs</span>
                @if($mostWeekendStaff)
                <span class="hero-chip warn">
                    <i class="fa fa-triangle-exclamation"></i>
                    Most: {{ $mostWeekendStaff['name'] }} ({{ $mostWeekendStaff['total_days'] }} days)
                </span>
                @endif
            </div>
        </div>
        <div style="position:relative;z-index:1;">
            <div style="width:70px;height:70px;border-radius:18px;background:rgba(255,255,255,.10);border:1.5px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:30px;color:#fb923c;">
                <i class="fa fa-calendar-week"></i>
            </div>
        </div>
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    <div class="s-chip fu d1">
        <div class="s-chip-icon" style="background:#fff7ed;"><i class="fa fa-users" style="color:#c2410c;"></i></div>
        <div><div class="s-chip-val">{{ $totalWeekendStaff }}</div><div class="s-chip-label">Weekend Staff</div></div>
    </div>
    <div class="s-chip fu d2">
        <div class="s-chip-icon" style="background:#fef2f2;"><i class="fa fa-calendar-week" style="color:#b91c1c;"></i></div>
        <div><div class="s-chip-val">{{ $totalWeekendDays }}</div><div class="s-chip-label">Total Weekend Days</div></div>
    </div>
    <div class="s-chip fu d3">
        <div class="s-chip-icon" style="background:#eff6ff;"><i class="fa fa-layer-group" style="color:#1d4ed8;"></i></div>
        <div><div class="s-chip-val">{{ $totalWeekendPrograms }}</div><div class="s-chip-label">Weekend Programs</div></div>
    </div>
    <div class="s-chip fu d4">
        <div class="s-chip-icon" style="background:#fef9c3;"><i class="fa fa-building" style="color:#b45309;"></i></div>
        <div>
            @php
                $highFreqCount = count(array_filter($weekendStaff, fn($s) => $s['total_days'] >= 4));
            @endphp
            <div class="s-chip-val">{{ $highFreqCount }}</div>
            <div class="s-chip-label">High Frequency (4+ days)</div>
        </div>
    </div>
</div>

{{-- ═══ FREQUENCY LEADERBOARD ═══ --}}
@if(!empty($weekendStaff))
<div class="freq-panel fu d2">
    <div class="freq-stripe"></div>
    <div class="freq-header">
        <div class="freq-title">
            <i class="fa fa-ranking-star"></i>
            Weekend Frequency Leaderboard
        </div>
        <span style="font-size:12px;color:#94a3b8;font-weight:600;">Sorted by most weekend days</span>
    </div>
    <div class="freq-list">
        @foreach(array_slice($weekendStaff, 0, 10) as $idx => $staff)
        @php
            $rank     = $idx + 1;
            $rankClass = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-n'));
            $barPct   = $maxDays > 0 ? round(($staff['total_days'] / $maxDays) * 100) : 0;
            $satPct   = $maxDays > 0 ? round(($staff['saturdays']  / $maxDays) * 100) : 0;
            $sunPct   = $maxDays > 0 ? round(($staff['sundays']    / $maxDays) * 100) : 0;
        @endphp
        <div class="freq-row">

            {{-- Rank --}}
            <div class="freq-rank {{ $rankClass }}">{{ $rank }}</div>

            {{-- Avatar --}}
            <div class="freq-av">{{ strtoupper(substr($staff['name'], 0, 2)) }}</div>

            {{-- Name + dept --}}
            <div class="freq-info">
                <div class="freq-name">{{ $staff['name'] }}</div>
                <div class="freq-dept">{{ $staff['department'] }} </div>
                {{-- <div class="freq-dept">{{ $staff['department'] }} · {{ $staff['position'] }}</div> --}}

            </div>

            {{-- Progress bar --}}
            <div class="freq-bar-wrap">
                <div class="freq-bar-track">
                    <div class="freq-bar-fill freq-bar-both"
                         style="--bar-width:{{ $barPct }}%;width:{{ $barPct }}%;"></div>
                </div>
                <div style="display:flex;gap:6px;margin-top:4px;">
                    @if($staff['saturdays'] > 0)
                    <div style="flex:{{ $satPct }};height:4px;border-radius:20px;background:linear-gradient(90deg,#f97316,#fb923c);"></div>
                    @endif
                    @if($staff['sundays'] > 0)
                    <div style="flex:{{ $sunPct }};height:4px;border-radius:20px;background:linear-gradient(90deg,#ef4444,#f87171);"></div>
                    @endif
                </div>
            </div>

            {{-- Sat/Sun badges --}}
            <div class="freq-badges">
                @if($staff['saturdays'] > 0)
                <span class="freq-sat-badge">{{ $staff['saturdays'] }} Sat</span>
                @endif
                @if($staff['sundays'] > 0)
                <span class="freq-sun-badge">{{ $staff['sundays'] }} Sun</span>
                @endif
            </div>

            {{-- Total --}}
            <div style="text-align:right;flex-shrink:0;">
                <div class="freq-days">{{ $staff['total_days'] }}</div>
                <div class="freq-days-label">days</div>
            </div>

        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Filter bar --}}
<div class="filter-bar fu d3">

    {{-- LEFT SIDE (keep existing style) --}}
    <div class="filter-left">
        <span style="font-size:13.5px;font-weight:700;color:#0f172a;">
            Staff Details
        </span>

        <button class="f-pill on" data-f="all">All</button>

        <button class="f-pill" data-f="high">
            <i class="fa fa-fire" style="font-size:11px;"></i>
            High (4+ days)
        </button>

        <button class="f-pill" data-f="medium">
            Medium (2–3)
        </button>

        <button class="f-pill" data-f="low">
            Low (1)
        </button>

        <button class="f-pill" data-f="saturday">
            Saturday
        </button>

        <button class="f-pill" data-f="sunday">
            Sunday
        </button>
    </div>


    {{-- RIGHT SIDE (NEW + EXISTING FILTERS) --}}
    <form method="GET" action="{{ route('vc.weekend-staff') }}">
    <div class="filter-right">

        {{-- Year --}}
        <select name="year"
                class="dept-sel"
                onchange="this.form.submit()">

            @foreach($yearOptions as $year)
            <option value="{{ $year }}"
                {{ $selectedYear == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
            @endforeach

        </select>


        {{-- Month --}}
        <select name="month"
                class="dept-sel"
                onchange="this.form.submit()">

            @foreach($monthOptions as $opt)
            <option value="{{ $opt['value'] }}"
                {{ $selectedMonth == $opt['value'] ? 'selected' : '' }}>
                {{ $opt['label'] }}
            </option>
            @endforeach

        </select>


        {{-- Department (KEEP EXISTING) --}}
        <select id="deptFilter"
                name="dept"
                class="dept-sel">

            <option value="">All Departments</option>

            @foreach($departments as $dept)
                <option value="{{ $dept->id }}">
                    {{ $dept->name }}
                </option>
            @endforeach

        </select>


        {{-- Search (KEEP EXISTING) --}}
        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>

            <input type="text"
                   id="staffSearch"
                   class="search-inp"
                   placeholder="Search staff or program…">
        </div>

    </div>
    </form>

</div>


{{-- Staff grid --}}
@if(empty($weekendStaff))
<div class="empty-state fu d4">
    <i class="fa fa-umbrella-beach"></i>
    <h5 style="font-weight:800;color:#475569;margin-bottom:8px;">No weekend commitments</h5>
    <p style="font-size:13.5px;max-width:300px;margin:0 auto;">No staff are assigned to programs running on weekends.</p>
</div>
@else

<div class="no-results" id="noResults">
    <i class="fa fa-magnifying-glass" style="font-size:32px;display:block;margin-bottom:10px;color:#cbd5e1;"></i>
    No staff found matching your filters.
</div>

<div class="staff-grid fu d4" id="staffGrid">

    @foreach($weekendStaff as $staff)
    @php
        $fl     = $freqLevel($staff['total_days']);
        $barPct = $maxDays > 0 ? round(($staff['total_days'] / $maxDays) * 100) : 0;
        $satPct = $maxDays > 0 ? round(($staff['saturdays']  / $maxDays) * 100) : 0;
        $sunPct = $maxDays > 0 ? round(($staff['sundays']    / $maxDays) * 100) : 0;
    @endphp

    <div class="staff-card"
         data-name="{{ strtolower($staff['name']) }}"
         data-dept="{{ $staff['dept_id'] }}"
         data-saturdays="{{ $staff['saturdays'] }}"
         data-sundays="{{ $staff['sundays'] }}"
         data-total="{{ $staff['total_days'] }}">

        {{-- Frequency colour stripe --}}
        <div class="card-freq-stripe {{ $fl['stripe'] }}"></div>

        {{-- Staff header --}}
        <div class="staff-card-top">
            <div class="staff-av">{{ strtoupper(substr($staff['name'], 0, 2)) }}</div>

            <div style="flex:1;min-width:0;">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="staff-name">{{ $staff['name'] }}</div>
                    <span class="freq-level {{ $fl['class'] }}">
                        <i class="fa fa-fire" style="font-size:9px;"></i>
                        {{ $fl['label'] }}
                    </span>
                </div>
                {{-- <div class="staff-meta">
                    <i class="fa fa-id-badge me-1"></i>{{ $staff['staff_id'] }}
                    @if($staff['position'] !== '—')
                        &nbsp;·&nbsp; {{ $staff['position'] }}
                    @endif
                </div> --}}
                <span class="staff-dept">
                    <i class="fa fa-building" style="font-size:10px;"></i>
                    {{ $staff['department'] }}
                </span>
            </div>

            <div class="weekend-counter">
                <div class="wc-days">{{ $staff['total_days'] }}</div>
                <div class="wc-label">weekend days</div>
                <div class="wc-breakdown">
                    @if($staff['saturdays'] > 0)
                        <span class="wc-sat">{{ $staff['saturdays'] }} Sat</span>
                    @endif
                    @if($staff['saturdays'] > 0 && $staff['sundays'] > 0) &nbsp;·&nbsp; @endif
                    @if($staff['sundays'] > 0)
                        <span class="wc-sun">{{ $staff['sundays'] }} Sun</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Frequency bar section --}}
        <div class="card-freq-section">
            <div class="card-freq-row">
                <div class="cfl">Total</div>
                <div class="cfb-track">
                    <div class="cfb-fill cfb-total" style="--bar-width:{{ $barPct }}%;width:{{ $barPct }}%;"></div>
                </div>
                <div class="cfv">{{ $staff['total_days'] }}</div>
            </div>
            @if($staff['saturdays'] > 0)
            <div class="card-freq-row">
                <div class="cfl" style="color:#c2410c;">Saturdays</div>
                <div class="cfb-track">
                    <div class="cfb-fill cfb-sat" style="--bar-width:{{ $satPct }}%;width:{{ $satPct }}%;"></div>
                </div>
                <div class="cfv" style="color:#c2410c;">{{ $staff['saturdays'] }}</div>
            </div>
            @endif
            @if($staff['sundays'] > 0)
            <div class="card-freq-row">
                <div class="cfl" style="color:#b91c1c;">Sundays</div>
                <div class="cfb-track">
                    <div class="cfb-fill cfb-sun" style="--bar-width:{{ $sunPct }}%;width:{{ $sunPct }}%;"></div>
                </div>
                <div class="cfv" style="color:#b91c1c;">{{ $staff['sundays'] }}</div>
            </div>
            @endif
            <div style="margin-top:8px;display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                <span style="font-size:11px;color:#94a3b8;font-weight:600;">
                    {{ count($staff['programs']) }} {{ Str::plural('program', count($staff['programs'])) }} ·
                </span>
                @if($staff['saturdays'] > 0)
                <span style="font-size:11px;background:#fff7ed;color:#c2410c;border:1px solid #fed7aa;padding:1px 8px;border-radius:20px;font-weight:700;">
                    {{ $staff['saturdays'] }} Sat
                </span>
                @endif
                @if($staff['sundays'] > 0)
                <span style="font-size:11px;background:#fef2f2;color:#b91c1c;border:1px solid #fecaca;padding:1px 8px;border-radius:20px;font-weight:700;">
                    {{ $staff['sundays'] }} Sun
                </span>
                @endif
            </div>
        </div>

        {{-- Programs list --}}
        <div class="prog-list">
            @foreach($staff['programs'] as $prog)
            <div class="prog-item" data-search="{{ strtolower($prog['title']) }}">
                <div class="prog-item-top">
                    <div>
                        <div class="prog-item-title">{{ $prog['title'] }}</div>
                        <div class="prog-item-dept">
                            <i class="fa fa-building me-1" style="font-size:10px;"></i>{{ $prog['dept'] }}
                            &nbsp;·&nbsp;
                            <i class="fa fa-location-dot me-1" style="font-size:10px;"></i>{{ $prog['venue'] }}
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1" style="flex-shrink:0;">
                        <span class="sb {{ $sbClass[$prog['status']] ?? 'sb-upcoming' }}">
                            <i class="fa {{ $sbIcon[$prog['status']] ?? 'fa-clock' }}" style="font-size:9px;"></i>
                            {{ ucfirst($prog['status']) }}
                        </span>
                        <span class="role-tag role-{{ $prog['role'] }}">{{ $prog['role_label'] }}</span>
                        @if($prog['is_lead'])
                        <span class="lead-tag"><i class="fa fa-crown" style="font-size:8px;"></i> Lead</span>
                        @endif
                    </div>
                </div>

                {{-- Weekend day pills --}}
                <div class="weekend-days">
                    <span style="font-size:11px;color:#94a3b8;font-weight:600;margin-right:2px;">
                        <i class="fa fa-calendar-week me-1"></i>Weekend:
                    </span>
                    @foreach($prog['weekend_days'] as $wd)
                    <span class="wd-pill {{ $wd['day'] === 'Saturday' ? 'wd-saturday' : 'wd-sunday' }}">
                        <i class="fa fa-sun" style="font-size:9px;"></i>
                        {{ $wd['short'] }}
                    </span>
                    @endforeach
                </div>

                @if($prog['responsibility'])
                <div style="margin-top:7px;font-size:11.5px;color:#64748b;font-style:italic;">
                    <i class="fa fa-note-sticky me-1" style="font-size:10px;"></i>
                    {{ $prog['responsibility'] }}
                </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>
    @endforeach

</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var currentFilter = 'all';
    var currentDept   = '';
    var searchQuery   = '';

    function applyFilters() {
        var cards   = document.querySelectorAll('.staff-card');
        var visible = 0;

        cards.forEach(function (card) {
            var name      = card.dataset.name  || '';
            var deptId    = card.dataset.dept  || '';
            var saturdays = parseInt(card.dataset.saturdays) || 0;
            var sundays   = parseInt(card.dataset.sundays)   || 0;
            var total     = parseInt(card.dataset.total)     || 0;

            var progTitles = Array.from(card.querySelectorAll('.prog-item'))
                .map(function(p){ return p.dataset.search || ''; }).join(' ');

            var matchSearch = searchQuery === '' ||
                name.includes(searchQuery) ||
                progTitles.includes(searchQuery);

            var matchDept = currentDept === '' || deptId === currentDept;

            var matchFilter =
                currentFilter === 'all'      ? true :
                currentFilter === 'high'     ? total >= 4 :
                currentFilter === 'medium'   ? (total >= 2 && total <= 3) :
                currentFilter === 'low'      ? total === 1 :
                currentFilter === 'saturday' ? saturdays > 0 :
                currentFilter === 'sunday'   ? sundays > 0 : true;

            var show = matchSearch && matchDept && matchFilter;
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        var noResults = document.getElementById('noResults');
        if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    }

    document.querySelectorAll('.f-pill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.f-pill').forEach(function (p) { p.classList.remove('on'); });
            this.classList.add('on');
            currentFilter = this.dataset.f;
            applyFilters();
        });
    });

    var deptSel = document.getElementById('deptFilter');
    if (deptSel) deptSel.addEventListener('change', function () { currentDept = this.value; applyFilters(); });

    var searchInp = document.getElementById('staffSearch');
    if (searchInp) searchInp.addEventListener('input', function () { searchQuery = this.value.toLowerCase(); applyFilters(); });

});
</script>
@endpush
