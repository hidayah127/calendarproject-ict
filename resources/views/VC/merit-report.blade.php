@extends('layouts.app')

@section('page-title', 'Be an Amazing You Merit Leaderboard — Vice Chancellor')

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fillBar {
    from { width:0%; }
    to   { width:var(--w); }
}
@keyframes countUp {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}

.fu { animation:fadeUp .42s ease both; }
.d1{animation-delay:.06s;}.d2{animation-delay:.12s;}
.d3{animation-delay:.18s;}.d4{animation-delay:.24s;}
.d5{animation-delay:.30s;}

/* ── Hero ── */
.ml-hero {
    background:linear-gradient(130deg,#0a1f52 0%,#0f2d6e 48%,#1e40af 100%);
    border-radius:20px; padding:28px 32px; margin-bottom:24px;
    position:relative; overflow:hidden;
    box-shadow:0 12px 40px rgba(15,45,110,.22);
}
.ml-hero::before {
    content:''; position:absolute; width:300px; height:300px; border-radius:50%;
    background:rgba(245,158,11,.12); top:-90px; right:-60px; pointer-events:none;
}
.ml-hero::after {
    content:''; position:absolute; width:200px; height:200px; border-radius:50%;
    background:rgba(96,165,250,.08); bottom:-70px; left:30%; pointer-events:none;
}
.ml-hero h1 { font-size:1.5rem; font-weight:800; color:#fff; margin:0 0 5px; }
.ml-hero p  { font-size:13.5px; color:rgba(255,255,255,.60); margin:0; }
.hero-chips { display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; }
.hero-chip  {
    background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2);
    border-radius:10px; padding:6px 13px; font-size:12px; font-weight:600;
    color:rgba(255,255,255,.88); display:inline-flex; align-items:center; gap:7px;
}
.hero-chip i { color:#f59e0b; }

/* ── Stat strip ── */
.stat-strip {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:14px; margin-bottom:24px;
}
@media(max-width:900px){ .stat-strip{ grid-template-columns:repeat(2,1fr); } }

.s-chip {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:14px;
    padding:15px 18px; display:flex; align-items:center; gap:13px;
    box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;
}
.s-chip:hover { transform:translateY(-3px); box-shadow:0 8px 22px rgba(15,45,110,.10); }
.s-chip-icon  { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.s-chip-val   { font-size:1.7rem; font-weight:900; color:#0f172a; line-height:1; animation:countUp .6s ease both; }
.s-chip-label { font-size:12px; color:#64748b; font-weight:600; margin-top:2px; }

/* ── Top 3 podium ── */
.podium {
    display:grid; grid-template-columns:1fr 1.1fr 1fr;
    gap:12px; margin-bottom:24px; align-items:end;
}
@media(max-width:700px){ .podium{ grid-template-columns:1fr; } }

.podium-card {
    border-radius:18px; padding:20px 18px;
    text-align:center; position:relative; overflow:hidden;
    transition:transform .2s,box-shadow .2s;
}
.podium-card:hover { transform:translateY(-4px); }

.podium-1 {
    background:linear-gradient(135deg,#fef9c3,#fef3c7);
    border:2px solid #fde68a;
    box-shadow:0 6px 24px rgba(245,158,11,.18);
}
.podium-2 {
    background:linear-gradient(135deg,#f8faff,#eff6ff);
    border:2px solid #bfdbfe;
    box-shadow:0 4px 16px rgba(26,86,219,.10);
}
.podium-3 {
    background:linear-gradient(135deg,#fff7ed,#ffedd5);
    border:2px solid #fed7aa;
    box-shadow:0 4px 16px rgba(249,115,22,.10);
}

.podium-rank {
    font-size:2rem; font-weight:900; line-height:1;
    margin-bottom:10px; display:block;
}
.podium-1 .podium-rank { color:#f59e0b; }
.podium-2 .podium-rank { color:#1a56db; }
.podium-3 .podium-rank { color:#f97316; }

.podium-av {
    width:56px; height:56px; border-radius:16px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:18px; font-weight:900; color:#fff;
    margin-bottom:10px;
    box-shadow:0 4px 14px rgba(0,0,0,.15);
}
.podium-1 .podium-av { background:linear-gradient(135deg,#b45309,#f59e0b); }
.podium-2 .podium-av { background:linear-gradient(135deg,#0f2d6e,#1a56db); }
.podium-3 .podium-av { background:linear-gradient(135deg,#c2410c,#f97316); }

.podium-name  { font-size:14px; font-weight:800; color:#0f172a; margin-bottom:3px; }
.podium-dept  { font-size:12px; color:#64748b; margin-bottom:10px; }
.podium-pts   {
    font-size:1.5rem; font-weight:900; line-height:1;
    display:inline-block;
}
.podium-1 .podium-pts { background:linear-gradient(135deg,#b45309,#f59e0b); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.podium-2 .podium-pts { background:linear-gradient(135deg,#0f2d6e,#1a56db); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.podium-3 .podium-pts { background:linear-gradient(135deg,#c2410c,#f97316); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.podium-pts-label { font-size:11px; color:#94a3b8; font-weight:600; display:block; margin-top:2px; }

.podium-crown {
    position:absolute; top:10px; right:12px;
    font-size:18px;
}

/* ── Main leaderboard card ── */
.lb-card {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:18px;
    overflow:hidden; box-shadow:0 4px 24px rgba(15,45,110,.07);
}
.lb-stripe { height:5px; background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6); }

/* ── Toolbar ── */
.toolbar {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; padding:16px 22px; border-bottom:1px solid #f1f5f9;
}
.toolbar-left { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.toolbar-title { font-size:14px; font-weight:800; color:#0f172a; }
.count-pill { background:#eff6ff; color:#1d4ed8; font-size:11.5px; font-weight:700; padding:3px 10px; border-radius:20px; }

.dept-sel {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:8px 30px 8px 12px; font-size:13px; font-family:inherit;
    background:#f8faff; color:#475569; outline:none; cursor:pointer; appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
}
.dept-sel:focus { border-color:#1a56db; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:9px 14px 9px 36px; font-size:13.5px; font-family:inherit;
    background:#f8faff; color:#1e293b; width:210px; outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.10); background:#fff; }

/* ── Staff rows ── */
.staff-row {
    display:flex; align-items:center; gap:16px;
    padding:14px 22px; border-bottom:1px solid #f1f5f9;
    transition:background .15s; cursor:pointer;
}
.staff-row:hover { background:#f8faff; }
.staff-row:last-child { border-bottom:none; }

/* rank badge */
.rank-badge {
    width:32px; height:32px; border-radius:9px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:800;
}
.rank-1 { background:linear-gradient(135deg,#fbbf24,#f59e0b); color:#fff; box-shadow:0 3px 10px rgba(245,158,11,.35); }
.rank-2 { background:linear-gradient(135deg,#94a3b8,#64748b); color:#fff; }
.rank-3 { background:linear-gradient(135deg,#f97316,#ea580c); color:#fff; }
.rank-n { background:#f1f5f9; color:#64748b; font-size:12px; }

.staff-av {
    width:42px; height:42px; border-radius:12px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:13px; font-weight:800; flex-shrink:0;
}

.staff-name  { font-size:14px; font-weight:700; color:#0f172a; }
.staff-meta  { font-size:12px; color:#94a3b8; margin-top:2px; }
.staff-dept  {
    font-size:12px; font-weight:600; color:#475569;
    background:#f1f5f9; padding:3px 9px; border-radius:7px;
    display:inline-flex; align-items:center; gap:4px; margin-top:4px;
}

/* merit bar */
.merit-bar-wrap { flex:1; min-width:80px; }
.merit-bar-track { height:7px; background:#f1f5f9; border-radius:20px; overflow:hidden; margin-bottom:4px; }
.merit-bar-fill  {
    height:100%; border-radius:20px;
    background:linear-gradient(90deg,#0f2d6e,#1a56db);
    animation:fillBar .9s cubic-bezier(.4,0,.2,1) both;
    animation-delay:.3s;
}
.merit-bar-label { font-size:11px; color:#94a3b8; font-weight:600; }

/* role mini badges */
.role-mini-wrap { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
.role-mini {
    font-size:10px; font-weight:700; padding:2px 7px; border-radius:20px;
    display:inline-flex; align-items:center; gap:3px;
}
.role-committee_head   { background:#fef9c3; color:#b45309; }
.role-coordinator      { background:#e0e7ff; color:#3730a3; }
.role-secretary        { background:#dbeafe; color:#1d4ed8; }
.role-treasurer        { background:#dcfce7; color:#15803d; }
.role-facilitator      { background:#fce7f3; color:#9d174d; }
.role-committee_member { background:#f1f5f9; color:#475569; }
.role-attendee         { background:#eff6ff; color:#1d4ed8; }

/* merit total */
.merit-total {
    text-align:right; flex-shrink:0; min-width:60px;
}
.mt-val {
    font-size:1.5rem; font-weight:900; line-height:1;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}
.mt-label { font-size:10.5px; color:#94a3b8; font-weight:600; margin-top:2px; }
.mt-claims { font-size:11px; color:#94a3b8; }

/* expand row */
.expand-row {
    display:none;
    background:linear-gradient(135deg,#f8faff,#eef2ff);
    border-bottom:2px solid #e8effe;
    padding:14px 22px 16px;
    animation:fadeUp .2s ease;
}
.expand-row.open { display:block; }

.expand-title {
    font-size:11px; font-weight:700; color:#94a3b8;
    text-transform:uppercase; letter-spacing:.5px; margin-bottom:10px;
}
.expand-prog-list { display:flex; flex-direction:column; gap:6px; }
.expand-prog-item {
    display:flex; align-items:center; gap:10px;
    background:#fff; border:1.5px solid #e2e8f0; border-radius:10px;
    padding:9px 12px; font-size:13px;
}
.expand-prog-title { font-weight:700; color:#1e293b; flex:1; min-width:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.expand-prog-pts   {
    font-weight:800; font-size:13px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    flex-shrink:0;
}

/* chevron */
.row-chevron { color:#94a3b8; font-size:12px; transition:transform .25s; flex-shrink:0; }
.row-chevron.open { transform:rotate(180deg); }

/* ── Footer ── */
.lb-footer {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:8px;
    padding:14px 22px; border-top:1px solid #f1f5f9;
    font-size:13px; color:#64748b;
}

/* ── Empty ── */
.empty-state { text-align:center; padding:60px 20px; color:#94a3b8; }
.empty-state i { font-size:48px; display:block; margin-bottom:14px; color:#cbd5e1; }

/* ── Merit legend card ── */
.legend-card {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:16px;
    overflow:hidden; box-shadow:0 2px 12px rgba(15,45,110,.06);
    margin-bottom:22px;
}
.legend-stripe { height:4px; background:linear-gradient(90deg,#f59e0b,#fbbf24); }
.legend-body   { padding:14px 18px; }
.legend-title  { font-size:12px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; margin-bottom:12px; }
.legend-row {
    display:flex; align-items:center; justify-content:space-between;
    padding:7px 0; border-bottom:1px solid #f8faff; font-size:13px;
}
.legend-row:last-child { border-bottom:none; }
.legend-role { font-weight:600; color:#334155; display:flex; align-items:center; gap:8px; }
.legend-role i { color:#64748b; font-size:11px; width:14px; }
.legend-pts {
    font-weight:800; font-size:13.5px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
}

/* ===============================
   TABLET RESPONSIVE (≤ 1024px)
================================ */
@media (max-width:1024px){

    /* Left legend full width */
    .legend-card{
        width:100%;
    }

    /* Stack legend + leaderboard */
    .d-flex.gap-4.align-items-start{
        flex-direction:column;
    }

}


/* ===============================
   TABLET SMALL (≤ 768px)
================================ */
@media (max-width:768px){

    /* Hero padding smaller */
    .ml-hero{
        padding:20px;
    }

    .ml-hero h1{
        font-size:1.2rem;
    }

    /* Toolbar stack */
    .toolbar{
        flex-direction:column;
        align-items:stretch;
    }

    .toolbar-left{
        justify-content:space-between;
        width:100%;
    }

    /* Search full width */
    .search-inp{
        width:100%;
    }

    /* Dropdown full width */
    .dept-sel{
        width:100%;
    }

    /* Podium stack */
    .podium{
        grid-template-columns:1fr;
    }

    /* Staff row vertical spacing */
    .staff-row{
        flex-wrap:wrap;
        gap:10px;
    }

}


/* ===============================
   MOBILE (≤ 576px)
================================ */
@media (max-width:576px){

    /* Smaller avatar */
    .staff-av{
        width:36px;
        height:36px;
        font-size:11px;
    }

    /* Rank smaller */
    .rank-badge{
        width:26px;
        height:26px;
        font-size:11px;
    }

    /* Staff name smaller */
    .staff-name{
        font-size:13px;
    }

    /* Merit bar full width */
    .merit-bar-wrap{
        width:100%;
    }

    /* Total points move below */
    .merit-total{
        width:100%;
        text-align:left;
        margin-top:5px;
    }

    /* Footer stack */
    .lb-footer{
        flex-direction:column;
        align-items:flex-start;
    }

}

.legend-wrapper{
    width:220px;
    flex-shrink:0;
}

@media(max-width:768px){
    .legend-wrapper{
        width:100%;
    }
}

.filter-group{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

@media(max-width:576px){
    .filter-group{
        flex-direction:column;
    }
}

@media(max-width:576px){

    .staff-row{
        align-items:flex-start;
    }

    .merit-bar-wrap{
        order:5;
    }

    .merit-total{
        order:6;
    }

}

@media(max-width:480px){
    .stat-strip{
        grid-template-columns:1fr;
    }
}
</style>
@endpush

@section('content')

@php
    $staffMerits          = $staffMerits          ?? [];
    $departments          = $departments          ?? collect();
    $totalStaffWithMerit  = $totalStaffWithMerit  ?? 0;
    $totalMeritsAwarded   = $totalMeritsAwarded   ?? 0;
    $totalClaimsApproved  = $totalClaimsApproved  ?? 0;
    $topStaff             = $topStaff             ?? null;
    $maxMerits            = max($maxMerits ?? 1, 1);
    $meritPoints          = $meritPoints          ?? [];
    $roleLabels           = $roleLabels           ?? [];
    $roleIcons            = $roleIcons            ?? [];

    $top3 = array_slice($staffMerits, 0, 3);
@endphp

{{-- Hero --}}
<div class="ml-hero fu">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fa fa-trophy me-2" style="color:#f59e0b;"></i>Be an Amazing You Merit Leaderboard</h1>
            <p>University-wide merit points earned through program participation and committee roles.</p>
            <div class="hero-chips">
                <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('d F Y') }}</span>
                <span class="hero-chip"><i class="fa fa-users"></i>{{ $totalStaffWithMerit }} staff with merits</span>
                <span class="hero-chip"><i class="fa fa-star"></i>{{ $totalMeritsAwarded }} total points awarded</span>
                @if($topStaff)
                <span class="hero-chip"><i class="fa fa-crown"></i>Top: {{ $topStaff['name'] }} ({{ $topStaff['total_merits'] }} pts)</span>
                @endif
            </div>
        </div>
        {{-- <div style="position:relative;z-index:1;">
            <div style="width:70px;height:70px;border-radius:18px;background:rgba(255,255,255,.10);border:1.5px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:30px;color:#f59e0b;">
                <i class="fa fa-trophy"></i>
            </div>
        </div> --}}
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    <div class="s-chip fu d1">
        <div class="s-chip-icon" style="background:#fefce8;"><i class="fa fa-star" style="color:#f59e0b;"></i></div>
        <div><div class="s-chip-val">{{ $totalMeritsAwarded }}</div><div class="s-chip-label">Total Merits Awarded</div></div>
    </div>
    <div class="s-chip fu d2">
        <div class="s-chip-icon" style="background:#eff6ff;"><i class="fa fa-users" style="color:#1d4ed8;"></i></div>
        <div><div class="s-chip-val">{{ $totalStaffWithMerit }}</div><div class="s-chip-label">Staff with Merits</div></div>
    </div>
    <div class="s-chip fu d3">
        <div class="s-chip-icon" style="background:#f0fdf4;"><i class="fa fa-circle-check" style="color:#15803d;"></i></div>
        <div><div class="s-chip-val">{{ $totalClaimsApproved }}</div><div class="s-chip-label">Claims Approved</div></div>
    </div>
    <div class="s-chip fu d4">
        <div class="s-chip-icon" style="background:#e0e7ff;"><i class="fa fa-building" style="color:#4338ca;"></i></div>
        <div><div class="s-chip-val">{{ $departments->count() }}</div><div class="s-chip-label">Departments</div></div>
    </div>
</div>

{{-- Top 3 Podium --}}
@if(count($top3) >= 1)
<div class="podium fu d2">

    {{-- 2nd place --}}
    @if(isset($top3[1]))
    <div class="podium-card podium-2">
        <span class="podium-rank">2</span>
        <div class="podium-av">{{ strtoupper(substr($top3[1]['name'],0,2)) }}</div>
        <div class="podium-name">{{ $top3[1]['name'] }}</div>
        <div class="podium-dept">{{ $top3[1]['department'] }}</div>
        <div class="podium-pts">{{ $top3[1]['total_merits'] }}</div>
        <div class="podium-pts-label">merit points</div>
    </div>
    @else <div></div>
    @endif

    {{-- 1st place --}}
    <div class="podium-card podium-1">
        <span class="podium-crown">👑</span>
        <span class="podium-rank">1</span>
        <div class="podium-av">{{ strtoupper(substr($top3[0]['name'],0,2)) }}</div>
        <div class="podium-name">{{ $top3[0]['name'] }}</div>
        <div class="podium-dept">{{ $top3[0]['department'] }}</div>
        <div class="podium-pts">{{ $top3[0]['total_merits'] }}</div>
        <div class="podium-pts-label">merit points</div>
    </div>

    {{-- 3rd place --}}
    @if(isset($top3[2]))
    <div class="podium-card podium-3">
        <span class="podium-rank">3</span>
        <div class="podium-av">{{ strtoupper(substr($top3[2]['name'],0,2)) }}</div>
        <div class="podium-name">{{ $top3[2]['name'] }}</div>
        <div class="podium-dept">{{ $top3[2]['department'] }}</div>
        <div class="podium-pts">{{ $top3[2]['total_merits'] }}</div>
        <div class="podium-pts-label">merit points</div>
    </div>
    @else <div></div>
    @endif

</div>
@endif

{{-- Merit reference + full leaderboard side by side --}}
<div class="d-flex gap-4 align-items-start flex-wrap">

    {{-- Left: Merit reference --}}
    <div style="legend-wrapper">
        <div class="legend-card">
            <div class="legend-stripe"></div>
            <div class="legend-body">
                <div class="legend-title"><i class="fa fa-star me-1"></i> Points Reference</div>
                @foreach($meritPoints as $role => $pts)
                <div class="legend-row">
                    <span class="legend-role">
                        <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}"></i>
                        {{ $roleLabels[$role] ?? ucfirst($role) }}
                    </span>
                    <span class="legend-pts">{{ $pts }} pts</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right: Full leaderboard table --}}
    <div style="flex:1;min-width:0;" class="fu d3">

        <div class="lb-card">
            <div class="lb-stripe"></div>

            {{-- Toolbar --}}
            <div class="toolbar">
                <a href="{{ route('vc.reports.export') }}"
                    class="btn btn-success btn-sm">

                    <i class="fa fa-file-csv me-1"></i>
                    Export CSV

                </a>
                <div class="toolbar-left">
                    <span class="toolbar-title">Full Rankings</span>
                    <span class="count-pill">{{ $totalStaffWithMerit }} staff</span>
                </div>
                {{-- <div class="filter-group">
                    <select id="deptFilter" class="dept-sel">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <div class="search-wrap">
                        <i class="fa fa-magnifying-glass"></i>
                        <input type="text" id="staffSearch" class="search-inp" placeholder="Search staff…">
                    </div>
                </div> --}}

                <form method="GET" action="{{ route('vc.reports') }}">
                    <div class="filter-group">
                        {{-- Year Filter --}}
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


                        {{-- Department Filter (keep existing style) --}}
                        <select id="deptFilter"
                                name="dept"
                                class="dept-sel">

                            <option value="">All Departments</option>

                            @foreach($departments as $dept)
                            <option value="{{ $dept->id }}"
                                {{ request('dept') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                            @endforeach

                        </select>


                        {{-- Search --}}
                        <div class="search-wrap">
                            <i class="fa fa-magnifying-glass"></i>

                            <input type="text"
                                id="staffSearch"
                                class="search-inp"
                                placeholder="Search staff…">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Rows --}}
            @if(empty($staffMerits))
            <div class="empty-state">
                <i class="fa fa-star"></i>
                <h6 style="color:#475569;font-weight:700;margin-bottom:6px;">No merits awarded yet</h6>
                <p style="font-size:13.5px;max-width:280px;margin:0 auto;">
                    Merit points will appear here once claims are approved.
                </p>
            </div>
            @else

            <div id="leaderboardRows">
                @foreach($staffMerits as $idx => $staff)
                @php
                    $rank    = $idx + 1;
                    $barPct  = round(($staff['total_merits'] / $maxMerits) * 100);
                    $rankCls = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-n'));
                @endphp

                {{-- Staff row --}}
                <div class="staff-row"
                     data-dept="{{ $staff['dept_id'] }}"
                     data-name="{{ strtolower($staff['name']) }}"
                     onclick="toggleExpand({{ $staff['id'] }})">

                    {{-- Rank --}}
                    <div class="rank-badge {{ $rankCls }}">{{ $rank }}</div>

                    {{-- Avatar --}}
                    <div class="staff-av">{{ strtoupper(substr($staff['name'],0,2)) }}</div>

                    {{-- Info --}}
                    <div style="flex:1;min-width:0;">
                        <div class="staff-name">{{ $staff['name'] }}</div>
                        <div class="staff-meta">
                            <i class="fa fa-id-badge me-1"></i>{{ $staff['staff_id'] }}
                            {{-- @if($staff['position'] !== '—')
                                &nbsp;·&nbsp; {{ $staff['position'] }}
                            @endif --}}
                        </div>
                        <span class="staff-dept">
                            <i class="fa fa-building" style="font-size:10px;"></i>
                            {{ $staff['department'] }}
                        </span>

                        {{-- Role mini badges --}}
                        <div class="role-mini-wrap">
                            @foreach($staff['by_role'] as $role => $data)
                            <span class="role-mini role-{{ $role }}">
                                <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}" style="font-size:9px;"></i>
                                {{ $data['count'] }}× {{ $roleLabels[$role] ?? ucfirst($role) }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Merit bar --}}
                    <div class="merit-bar-wrap">
                        <div class="merit-bar-track">
                            <div class="merit-bar-fill" style="--w:{{ $barPct }}%;width:{{ $barPct }}%;"></div>
                        </div>
                        <div class="merit-bar-label">{{ $staff['total_claims'] }} {{ Str::plural('claim',$staff['total_claims']) }} approved</div>
                    </div>

                    {{-- Total --}}
                    <div class="merit-total">
                        <div class="mt-val">{{ $staff['total_merits'] }}</div>
                        <div class="mt-label">pts</div>
                    </div>

                    {{-- Chevron --}}
                    <i class="fa fa-chevron-down row-chevron" id="chev-{{ $staff['id'] }}"></i>

                </div>

                {{-- Expand: program breakdown --}}
                <div class="expand-row" id="exp-{{ $staff['id'] }}">
                    <div class="expand-title">
                        <i class="fa fa-layer-group me-1"></i> Programs Contributed
                    </div>
                    <div class="expand-prog-list">
                        @foreach($staff['programs'] as $prog)
                        <div class="expand-prog-item">
                            <i class="fa {{ $roleIcons[$prog['claim_type']] ?? 'fa-user' }}"
                               style="color:#94a3b8;font-size:13px;flex-shrink:0;"></i>
                            <span class="expand-prog-title">{{ $prog['title'] }}</span>
                            <span class="role-mini role-{{ $prog['claim_type'] }}">
                                {{ $roleLabels[$prog['claim_type']] ?? ucfirst($prog['claim_type']) }}
                            </span>
                            <span class="expand-prog-pts">+{{ $prog['pts'] }} pts</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                @endforeach
            </div>

            @endif

            {{-- Footer --}}
            <div class="lb-footer">
                <div id="lbInfo">Showing {{ $totalStaffWithMerit }} staff</div>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>

/* ── Toggle expand ── */
function toggleExpand(id) {
    var row   = document.getElementById('exp-'  + id);
    var chev  = document.getElementById('chev-' + id);
    var isOpen = row.classList.contains('open');

    // Close all
    document.querySelectorAll('.expand-row.open').forEach(function(r){ r.classList.remove('open'); });
    document.querySelectorAll('.row-chevron.open').forEach(function(c){ c.classList.remove('open'); });

    if (!isOpen) {
        row.classList.add('open');
        chev.classList.add('open');
    }
}

/* ── Dept filter ── */
document.getElementById('deptFilter').addEventListener('change', function(){
    applyFilters();
});

/* ── Search ── */
document.getElementById('staffSearch').addEventListener('input', function(){
    applyFilters();
});

function applyFilters() {
    var dept    = document.getElementById('deptFilter').value;
    var query   = document.getElementById('staffSearch').value.toLowerCase();
    var rows    = document.querySelectorAll('.staff-row');
    var visible = 0;

    rows.forEach(function(row) {
        var rowDept = row.dataset.dept;
        var rowName = row.dataset.name;
        var id      = row.querySelector('[id^="chev-"]').id.replace('chev-','');

        var okDept   = dept  === '' || rowDept === dept;
        var okSearch = query === '' || rowName.includes(query);
        var show     = okDept && okSearch;

        row.style.display = show ? '' : 'none';
        // Hide expand row too if parent hidden
        var exp = document.getElementById('exp-' + id);
        if (exp && !show) { exp.classList.remove('open'); }
        if (show) visible++;
    });

    document.getElementById('lbInfo').textContent = 'Showing ' + visible + ' staff';
}

</script>
@endpush
