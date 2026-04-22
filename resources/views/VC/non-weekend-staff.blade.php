@extends('layouts.app')

@section('title', 'Staff Free on Weekends — ' . $monthDate->format('F Y'))

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes fillBar {
    from { width:0; }
    to   { width:var(--w); }
}

.fu{animation:fadeUp .42s ease both;}
.d1{animation-delay:.06s;}.d2{animation-delay:.12s;}
.d3{animation-delay:.18s;}.d4{animation-delay:.24s;}
.d5{animation-delay:.30s;}

/* ── Hero ── */
.hero {
    background:linear-gradient(132deg,#064e3b 0%,#065f46 40%,#047857 75%,#059669 100%);
    border-radius:22px; padding:0; margin-bottom:26px;
    position:relative; overflow:hidden;
    box-shadow:0 16px 48px rgba(6,78,59,.30);
}
.hero::before {
    content:'';position:absolute;inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);
    background-size:36px 36px;pointer-events:none;
}
.hero::after {
    content:'';position:absolute;
    width:380px;height:380px;border-radius:50%;
    background:radial-gradient(circle,rgba(255,255,255,.10) 0%,transparent 70%);
    top:-120px;right:-80px;pointer-events:none;
}
.hero-inner {
    position:relative;z-index:1;
    padding:32px 36px;
    display:flex;align-items:flex-start;
    justify-content:space-between;gap:20px;flex-wrap:wrap;
}
.hero-inner h1 { font-size:1.65rem;font-weight:900;color:#fff;margin:0 0 5px;line-height:1.15; }
.hero-inner p  { font-size:14px;color:rgba(255,255,255,.62);margin:0; }
.hero-chips { display:flex;gap:9px;flex-wrap:wrap;margin-top:20px; }
.hero-chip {
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.20);
    border-radius:10px;padding:7px 14px;font-size:12.5px;font-weight:600;
    color:rgba(255,255,255,.90);display:inline-flex;align-items:center;gap:7px;
    backdrop-filter:blur(6px);
}
.hero-chip i { color:#6ee7b7; }
.hero-emblem {
    width:76px;height:76px;border-radius:20px;
    background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.22);
    display:flex;align-items:center;justify-content:center;
    font-size:34px;color:#6ee7b7;
    backdrop-filter:blur(8px);box-shadow:0 8px 28px rgba(0,0,0,.18);
    position:relative;z-index:1;
}

/* bottom bar */
.hero-bar { position:relative;z-index:1;display:flex;border-top:1px solid rgba(255,255,255,.12); }
.hb-item  { flex:1;padding:16px 20px;border-right:1px solid rgba(255,255,255,.08);text-align:center;transition:background .2s; }
.hb-item:last-child{border-right:none;}
.hb-item:hover{background:rgba(255,255,255,.05);}
.hb-val   {font-size:1.8rem;font-weight:900;color:#fff;line-height:1;letter-spacing:-1px;}
.hb-label {font-size:10.5px;font-weight:600;color:rgba(255,255,255,.45);margin-top:4px;text-transform:uppercase;letter-spacing:.8px;}

/* ── Filter bar ── */
.filter-card {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;
    padding:18px 22px;margin-bottom:22px;
    box-shadow:0 2px 12px rgba(15,45,110,.06);
    display:flex;align-items:center;flex-wrap:wrap;gap:14px;
}
.filter-label {
    font-size:12px;font-weight:700;color:#475569;
    text-transform:uppercase;letter-spacing:.5px;
    display:block;margin-bottom:6px;
}
.filter-select {
    border:1.5px solid #e2e8f0;border-radius:10px;
    padding:9px 32px 9px 14px;font-size:13.5px;font-family:inherit;
    background:#f8faff;color:#1e293b;outline:none;cursor:pointer;
    appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 12px center;
    transition:border-color .2s,box-shadow .2s;
    min-width:200px;
}
.filter-select:focus {
    border-color:#059669;
    box-shadow:0 0 0 3px rgba(5,150,105,.10);
    background-color:#fff;
}

.btn-filter {
    background:linear-gradient(135deg,#047857,#059669);
    color:#fff;border:none;border-radius:10px;
    padding:10px 22px;font-size:13.5px;font-weight:700;
    cursor:pointer;font-family:inherit;
    box-shadow:0 3px 10px rgba(5,150,105,.25);
    transition:all .2s;display:inline-flex;align-items:center;gap:7px;
}
.btn-filter:hover { transform:translateY(-1px);box-shadow:0 5px 16px rgba(5,150,105,.32); }

/* ── Stat strip ── */
.stat-strip {
    display:grid;grid-template-columns:repeat(4,1fr);
    gap:14px;margin-bottom:24px;
}
@media(max-width:900px){ .stat-strip{grid-template-columns:repeat(2,1fr);} }

.s-chip {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;
    padding:16px 18px;display:flex;align-items:center;gap:13px;
    box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;
}
.s-chip:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(15,45,110,.10);}
.s-chip-icon {width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:19px;flex-shrink:0;}
.s-chip-val  {font-size:1.7rem;font-weight:900;color:#0f172a;line-height:1;}
.s-chip-label{font-size:12px;color:#64748b;font-weight:600;margin-top:2px;}

/* ── Weekend calendar mini ── */
.weekend-mini {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;
    padding:18px 20px;margin-bottom:22px;
    box-shadow:0 2px 12px rgba(15,45,110,.06);
}
.wm-title {
    font-size:12px;font-weight:700;color:#64748b;
    text-transform:uppercase;letter-spacing:.5px;
    margin-bottom:12px;display:flex;align-items:center;gap:7px;
}
.wm-days { display:flex;flex-wrap:wrap;gap:8px; }
.wm-day  {
    padding:7px 14px;border-radius:10px;font-size:12.5px;font-weight:700;
    display:inline-flex;align-items:center;gap:6px;
}
.wm-sat { background:#fff7ed;color:#c2410c;border:1.5px solid #fed7aa; }
.wm-sun { background:#fef2f2;color:#b91c1c;border:1.5px solid #fecaca; }

/* ── Progress gauge ── */
.gauge-wrap {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;
    padding:18px 22px;margin-bottom:22px;
    box-shadow:0 2px 12px rgba(15,45,110,.06);
}
.gauge-title { font-size:13px;font-weight:800;color:#0f172a;margin-bottom:14px; }
.gauge-row   { margin-bottom:12px; }
.gauge-row:last-child{margin-bottom:0;}
.gauge-label { display:flex;align-items:center;justify-content:space-between;font-size:12.5px;font-weight:700;color:#334155;margin-bottom:5px; }
.gauge-label span{ color:#64748b;font-weight:600; }
.gauge-track { height:10px;background:#f1f5f9;border-radius:20px;overflow:hidden; }
.gauge-fill  { height:100%;border-radius:20px;animation:fillBar .9s cubic-bezier(.4,0,.2,1) both;animation-delay:.3s; }
.gauge-free  { background:linear-gradient(90deg,#047857,#10b981); }
.gauge-busy  { background:linear-gradient(90deg,#c2410c,#f97316); }

/* ── Main layout ── */
.main-layout {
    display:grid;grid-template-columns:1fr 280px;
    gap:20px;align-items:start;
}
@media(max-width:1100px){ .main-layout{grid-template-columns:1fr;} }

/* ── Department sections ── */
.dept-section {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;
    overflow:hidden;box-shadow:0 3px 16px rgba(15,45,110,.07);
    margin-bottom:16px;
}
.dept-section:last-child{margin-bottom:0;}

.dept-header {
    display:flex;align-items:center;gap:14px;
    padding:16px 22px;
    background:linear-gradient(135deg,#f0fdf4,#dcfce7);
    border-bottom:1px solid #bbf7d0;
    cursor:pointer;user-select:none;
    transition:background .18s;
}
.dept-header:hover{background:linear-gradient(135deg,#dcfce7,#bbf7d0);}

.dept-av {
    width:42px;height:42px;border-radius:12px;
    background:linear-gradient(135deg,#047857,#059669);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:14px;font-weight:800;flex-shrink:0;
    box-shadow:0 3px 10px rgba(4,120,87,.25);
}
.dept-name { font-size:14px;font-weight:800;color:#064e3b; }
.dept-code { font-size:12px;color:#065f46;margin-top:1px; }
.dept-count-badge {
    margin-left:auto;
    background:linear-gradient(135deg,#047857,#059669);
    color:#fff;font-size:12px;font-weight:800;
    padding:4px 12px;border-radius:20px;flex-shrink:0;
    box-shadow:0 2px 8px rgba(4,120,87,.25);
}
.dept-chev { color:#065f46;font-size:12px;transition:transform .25s;flex-shrink:0; }
.dept-chev.open{transform:rotate(180deg);}

.dept-body {
    padding:14px 20px 16px;
}

/* ── Staff grid in dept ── */
.staff-chips {
    display:flex;flex-wrap:wrap;gap:8px;
}
.staff-chip {
    display:flex;align-items:center;gap:9px;
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:12px;padding:9px 13px;
    transition:all .18s;
}
.staff-chip:hover{border-color:#bfdbfe;background:#f0f6ff;transform:translateY(-1px);}

.sc-av {
    width:32px;height:32px;border-radius:9px;
    background:linear-gradient(135deg,#047857,#059669);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:10px;font-weight:800;flex-shrink:0;
}
.sc-name { font-size:13px;font-weight:700;color:#0f172a; }
.sc-id   { font-size:11px;color:#94a3b8; }
.sc-pos  { font-size:11px;color:#64748b; }

/* search in list */
.list-search {
    position:relative;margin-bottom:16px;
}
.list-search i { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none; }
.list-search input {
    width:100%;border:1.5px solid #e2e8f0;border-radius:11px;
    padding:10px 14px 10px 37px;font-size:13.5px;font-family:inherit;
    background:#fff;color:#1e293b;outline:none;
    box-shadow:0 2px 8px rgba(15,45,110,.04);
    transition:border-color .2s,box-shadow .2s;
}
.list-search input:focus {
    border-color:#059669;
    box-shadow:0 0 0 3px rgba(5,150,105,.10);
}

/* ── Right sidebar ── */
.right-sidebar { display:flex;flex-direction:column;gap:16px;position:sticky;top:84px; }

.side-panel {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;
    overflow:hidden;box-shadow:0 2px 14px rgba(15,45,110,.06);
}
.side-panel-stripe{height:4px;}
.side-panel-hdr {
    padding:14px 18px 12px;border-bottom:1px solid #f1f5f9;
    font-size:13px;font-weight:800;color:#0f172a;
    display:flex;align-items:center;gap:8px;
}
.side-panel-hdr i {
    width:26px;height:26px;border-radius:7px;
    display:inline-flex;align-items:center;justify-content:center;font-size:12px;
}

/* dept summary list */
.dept-sum-item {
    display:flex;align-items:center;gap:10px;
    padding:10px 18px;border-bottom:1px solid #f8faff;
    font-size:13px;transition:background .15s;
}
.dept-sum-item:last-child{border-bottom:none;}
.dept-sum-item:hover{background:#f8faff;}
.dsi-av {
    width:32px;height:32px;border-radius:9px;
    background:linear-gradient(135deg,#047857,#059669);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:10px;font-weight:800;flex-shrink:0;
}
.dsi-name{font-weight:700;color:#0f172a;flex:1;}
.dsi-count{
    font-weight:800;font-size:13px;
    color:#059669;
}

/* program alert in sidebar */
.wp-item {
    display:flex;align-items:flex-start;gap:10px;
    padding:10px 18px;border-bottom:1px solid #f8faff;
}
.wp-item:last-child{border-bottom:none;}
.wp-dot { width:8px;height:8px;border-radius:50%;flex-shrink:0;margin-top:5px; }
.wp-title{font-size:12.5px;font-weight:700;color:#1e293b;}
.wp-meta {font-size:11px;color:#94a3b8;margin-top:2px;}

/* ── Empty ── */
.empty-panel {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;
    text-align:center;padding:60px 20px;color:#94a3b8;
    box-shadow:0 3px 16px rgba(15,45,110,.06);
}
.empty-panel i{font-size:52px;display:block;margin-bottom:16px;color:#cbd5e1;}
.empty-panel h5{color:#475569;font-weight:800;margin-bottom:8px;}

/* ── Status dots ── */
.dot-upcoming   {background:#3b82f6;}
.dot-ongoing    {background:#16a34a;}
.dot-completed  {background:#6366f1;}
.dot-rescheduled{background:#f59e0b;}

</style>
@endpush

@section('content')

@php
    $totalAllStaff        = $totalAllStaff       ?? 0;
    $totalWeekendStaff    = $totalWeekendStaff    ?? 0;
    $totalNonWeekend      = $totalNonWeekend      ?? 0;
    $weekendPct           = $weekendPct           ?? 0;
    $nonWeekendPct        = $nonWeekendPct        ?? 0;
    $weekendDaysInMonth   = $weekendDaysInMonth   ?? [];
    $weekendPrograms      = $weekendPrograms      ?? collect();
    $byDepartment         = $byDepartment         ?? collect();
    $departments          = $departments          ?? collect();
    $monthOptions         = $monthOptions         ?? [];
    $selectedMonth        = $selectedMonth        ?? now()->format('Y-m');
    $selectedDept         = $selectedDept         ?? '';
    $satCount             = collect($weekendDaysInMonth)->where('day','Saturday')->count();
    $sunCount             = collect($weekendDaysInMonth)->where('day','Sunday')->count();
@endphp

{{-- Hero --}}
<div class="hero fu">
    <div class="hero-inner">
        <div>
            <h1>
                <i class="fa fa-umbrella-beach me-2" style="color:#6ee7b7;"></i>
                Weekend-Free Staff
            </h1>
            <p>Staff not committed to any weekend programs in the selected month.</p>
            <div class="hero-chips">
                <span class="hero-chip">
                    <i class="fa fa-calendar-days"></i>{{ $monthDate->format('F Y') }}
                </span>
                <span class="hero-chip">
                    <i class="fa fa-users"></i>{{ $totalNonWeekend }} staff free on weekends
                </span>
                <span class="hero-chip">
                    <i class="fa fa-calendar-week"></i>
                    {{ count($weekendDaysInMonth) }} weekend days this month
                </span>
            </div>
        </div>
        <div class="hero-emblem"><i class="fa fa-umbrella-beach"></i></div>
    </div>
    <div class="hero-bar">
        <div class="hb-item">
            <div class="hb-val">{{ $totalAllStaff }}</div>
            <div class="hb-label">Total Staff</div>
        </div>
        <div class="hb-item">
            <div class="hb-val" style="color:#6ee7b7;">{{ $totalNonWeekend }}</div>
            <div class="hb-label">Free on Weekends</div>
        </div>
        <div class="hb-item">
            <div class="hb-val" style="color:#fca5a5;">{{ $totalWeekendStaff }}</div>
            <div class="hb-label">On Weekend Duty</div>
        </div>
        <div class="hb-item">
            <div class="hb-val">{{ $satCount }}</div>
            <div class="hb-label">Saturdays</div>
        </div>
        <div class="hb-item">
            <div class="hb-val">{{ $sunCount }}</div>
            <div class="hb-label">Sundays</div>
        </div>
    </div>
</div>

{{-- Filter card --}}
<form method="GET" action="{{ route('vc.non-weekend-staff') }}">
<div class="filter-card fu d1">
    {{-- <div>
        <span class="filter-label">Month</span>
        <select name="month" class="filter-select">
            @foreach($monthOptions as $opt)
            <option value="{{ $opt['value'] }}" {{ $selectedMonth === $opt['value'] ? 'selected' : '' }}>
                {{ $opt['label'] }}
            </option>
            @endforeach
        </select>
    </div> --}}

    {{-- Year Filter --}}
    <div>
        <span class="filter-label">Year</span>
        <select name="year" class="filter-select">
            @foreach($yearOptions as $year)
            <option value="{{ $year }}"
                {{ $selectedYear == $year ? 'selected' : '' }}>
                {{ $year }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- Month Filter --}}
    <div>
        <span class="filter-label">Month</span>
        <select name="month" class="filter-select">
            @foreach($monthOptions as $opt)
            <option value="{{ $opt['value'] }}"
                {{ $selectedMonth === $opt['value'] ? 'selected' : '' }}>
                {{ $opt['label'] }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <span class="filter-label">Department</span>
        <select name="dept" class="filter-select">
            <option value="">All Departments</option>
            @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ $selectedDept == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div style="align-self:flex-end;">
        <button type="submit" class="btn-filter">
            <i class="fa fa-magnifying-glass"></i> Apply Filter
        </button>
    </div>
</div>
</form>

{{-- Stat strip --}}
<div class="stat-strip">
    <div class="s-chip fu d1">
        <div class="s-chip-icon" style="background:#f0fdf4;"><i class="fa fa-users" style="color:#15803d;"></i></div>
        <div><div class="s-chip-val">{{ $totalAllStaff }}</div><div class="s-chip-label">Total Staff</div></div>
    </div>
    <div class="s-chip fu d2">
        <div class="s-chip-icon" style="background:#dcfce7;"><i class="fa fa-umbrella-beach" style="color:#15803d;"></i></div>
        <div><div class="s-chip-val">{{ $totalNonWeekend }}</div><div class="s-chip-label">Free on Weekends</div></div>
    </div>
    <div class="s-chip fu d3">
        <div class="s-chip-icon" style="background:#fff7ed;"><i class="fa fa-calendar-week" style="color:#c2410c;"></i></div>
        <div><div class="s-chip-val">{{ $totalWeekendStaff }}</div><div class="s-chip-label">On Weekend Duty</div></div>
    </div>
    <div class="s-chip fu d4">
        <div class="s-chip-icon" style="background:#eff6ff;"><i class="fa fa-layer-group" style="color:#1d4ed8;"></i></div>
        <div><div class="s-chip-val">{{ $weekendPrograms->count() }}</div><div class="s-chip-label">Weekend Programs</div></div>
    </div>
</div>

{{-- Weekend days in month --}}
@if(count($weekendDaysInMonth) > 0)
<div class="weekend-mini fu d2">
    <div class="wm-title">
        <i class="fa fa-calendar-week" style="color:#94a3b8;"></i>
        Weekend Days in {{ $monthDate->format('F Y') }}
    </div>
    <div class="wm-days">
        @foreach($weekendDaysInMonth as $wd)
        <span class="wm-day {{ $wd['day'] === 'Saturday' ? 'wm-sat' : 'wm-sun' }}">
            <i class="fa fa-{{ $wd['day'] === 'Saturday' ? 'sun' : 'moon' }}" style="font-size:10px;"></i>
            {{ $wd['full'] }}
        </span>
        @endforeach
    </div>
</div>
@endif

{{-- Gauge --}}
<div class="gauge-wrap fu d2">
    <div class="gauge-title">
        <i class="fa fa-chart-bar me-2" style="color:#94a3b8;font-size:13px;"></i>
        Staff Weekend Commitment Ratio — {{ $monthDate->format('F Y') }}
    </div>
    <div class="gauge-row">
        <div class="gauge-label">
            Weekend-Free Staff
            <span>{{ $totalNonWeekend }} / {{ $totalAllStaff }} ({{ $nonWeekendPct }}%)</span>
        </div>
        <div class="gauge-track">
            <div class="gauge-fill gauge-free" style="--w:{{ $nonWeekendPct }}%;width:{{ $nonWeekendPct }}%;"></div>
        </div>
    </div>
    <div class="gauge-row">
        <div class="gauge-label">
            On Weekend Duty
            <span>{{ $totalWeekendStaff }} / {{ $totalAllStaff }} ({{ $weekendPct }}%)</span>
        </div>
        <div class="gauge-track">
            <div class="gauge-fill gauge-busy" style="--w:{{ $weekendPct }}%;width:{{ $weekendPct }}%;"></div>
        </div>
    </div>
</div>

{{-- Main layout --}}
<div class="main-layout">

    {{-- Left: Dept sections --}}
    <div>

        {{-- Search --}}
        <div class="list-search fu d2">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="staffSearch" placeholder="Search staff by name or ID…">
        </div>

        @if($byDepartment->isEmpty())
        <div class="empty-panel fu d3">
            <i class="fa fa-umbrella-beach"></i>
            <h5>All staff are on weekend duty!</h5>
            <p style="font-size:13.5px;max-width:300px;margin:0 auto;">
                Every staff member is committed to a weekend program in {{ $monthDate->format('F Y') }}.
            </p>
        </div>
        @else

        <div id="deptList">
            @foreach($byDepartment as $dept)
            <div class="dept-section fu d3"
                 data-dept="{{ strtolower($dept['dept_name']) }}">

                {{-- Dept header --}}
                <div class="dept-header" onclick="toggleDept('dept-{{ $dept['dept_id'] }}', this)">
                    <div class="dept-av">{{ strtoupper(substr($dept['dept_name'],0,2)) }}</div>
                    <div>
                        <div class="dept-name">{{ $dept['dept_name'] }}</div>
                        <div class="dept-code">{{ $dept['dept_code'] }}</div>
                    </div>
                    <span class="dept-count-badge">{{ $dept['count'] }} {{ Str::plural('staff',$dept['count']) }} free</span>
                    <i class="fa fa-chevron-down dept-chev open" id="chev-dept-{{ $dept['dept_id'] }}"></i>
                </div>

                {{-- Staff chips --}}
                <div class="dept-body" id="dept-{{ $dept['dept_id'] }}">
                    <div class="staff-chips">
                        @foreach($dept['staff'] as $s)
                        <div class="staff-chip"
                             data-name="{{ strtolower($s['name']) }}"
                             data-sid="{{ strtolower($s['staff_id']) }}">
                            <div class="sc-av">{{ $s['initials'] }}</div>
                            <div>
                                <div class="sc-name">{{ $s['name'] }}</div>
                                <div class="sc-id">{{ $s['staff_id'] }}</div>
                                @if($s['position'] !== '—')
                                <div class="sc-pos">{{ $s['position'] }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        @endif
    </div>

    {{-- Right sidebar --}}
    <div class="right-sidebar fu d3">

        {{-- Dept summary ── --}}
        <div class="side-panel">
            <div class="side-panel-stripe" style="background:linear-gradient(90deg,#047857,#10b981);"></div>
            <div class="side-panel-hdr">
                <i class="fa fa-building" style="background:#dcfce7;color:#15803d;"></i>
                By Department
            </div>
            @forelse($byDepartment as $dept)
            <div class="dept-sum-item">
                <div class="dsi-av">{{ strtoupper(substr($dept['dept_name'],0,2)) }}</div>
                <div>
                    <div class="dsi-name">{{ Str::limit($dept['dept_name'],22) }}</div>
                    <div style="font-size:11px;color:#94a3b8;">{{ $dept['dept_code'] }}</div>
                </div>
                <div class="dsi-count">{{ $dept['count'] }}</div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:#94a3b8;font-size:13px;">
                All departments have weekend duty.
            </div>
            @endforelse
        </div>

        {{-- Weekend programs this month ── --}}
        <div class="side-panel">
            <div class="side-panel-stripe" style="background:linear-gradient(90deg,#c2410c,#f97316);"></div>
            <div class="side-panel-hdr">
                <i class="fa fa-calendar-week" style="background:#fff7ed;color:#c2410c;"></i>
                Weekend Programs
                <span style="margin-left:auto;background:#fff7ed;color:#c2410c;font-size:10px;font-weight:800;padding:1px 7px;border-radius:20px;">{{ $weekendPrograms->count() }}</span>
            </div>
            @forelse($weekendPrograms->take(8) as $wp)
            <div class="wp-item">
                <div class="wp-dot dot-{{ $wp->status }}" style="background:{{ match($wp->status){ 'ongoing'=>'#16a34a','completed'=>'#6366f1','rescheduled'=>'#f59e0b',default=>'#3b82f6' } }};"></div>
                <div>
                    <div class="wp-title">{{ Str::limit($wp->title,28) }}</div>
                    <div class="wp-meta">
                        {{ $wp->department->name ?? '—' }}
                        · {{ $wp->committee->count() }} members
                    </div>
                    <div class="wp-meta">
                        {{ $wp->start_date->format('d M') }} — {{ $wp->end_date->format('d M Y') }}
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:20px;color:#94a3b8;font-size:13px;">
                No weekend programs this month.
            </div>
            @endforelse
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

/* ── Toggle dept section ── */
function toggleDept(id, header) {
    var body = document.getElementById(id);
    var chev = document.getElementById('chev-' + id);
    var isOpen = body.style.display !== 'none';
    body.style.display = isOpen ? 'none' : 'block';
    chev.classList.toggle('open', !isOpen);
}

/* ── Live search across all staff chips ── */
document.getElementById('staffSearch').addEventListener('input', function(){
    var q = this.value.toLowerCase();

    document.querySelectorAll('.staff-chip').forEach(function(chip){
        var name = chip.dataset.name || '';
        var sid  = chip.dataset.sid  || '';
        var show = q === '' || name.includes(q) || sid.includes(q);
        chip.style.display = show ? '' : 'none';
    });

    // Hide dept sections where all chips are hidden
    document.querySelectorAll('.dept-section').forEach(function(section){
        var visible = Array.from(section.querySelectorAll('.staff-chip'))
            .some(function(c){ return c.style.display !== 'none'; });
        section.style.display = visible ? '' : 'none';
    });
});

</script>
@endpush
  