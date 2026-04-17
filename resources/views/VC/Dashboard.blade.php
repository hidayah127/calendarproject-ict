@extends('layouts.app')

@section('page-title','Vice Chancellor Dashboard')

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes countUp {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}
@keyframes pulse-ring {
    0%   { transform:scale(.9); opacity:.8; }
    100% { transform:scale(1.3); opacity:0; }
}

.fu  { animation:fadeUp .5s ease both; }
.d1  { animation-delay:.07s; }
.d2  { animation-delay:.14s; }
.d3  { animation-delay:.21s; }
.d4  { animation-delay:.28s; }
.d5  { animation-delay:.35s; }
.d6  { animation-delay:.42s; }

/* ══ HERO ══ */
.vc-hero {
    background:linear-gradient(135deg,#0a1f52 0%,#0f2d6e 40%,#1a4bab 75%,#1e56db 100%);
    border-radius:22px; padding:0; margin-bottom:26px;
    position:relative; overflow:hidden;
    box-shadow:0 16px 48px rgba(15,45,110,.28);
}
.vc-hero::before {
    content:''; position:absolute; inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),
        linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);
    background-size:40px 40px; pointer-events:none;
}
.vc-hero::after {
    content:''; position:absolute; width:380px; height:380px; border-radius:50%;
    background:radial-gradient(circle,rgba(245,158,11,.22) 0%,transparent 70%);
    top:-120px; right:-80px; pointer-events:none;
}
.hero-inner {
    position:relative; z-index:1; padding:32px 36px;
    display:flex; align-items:flex-start;
    justify-content:space-between; gap:20px; flex-wrap:wrap;
}
.hero-left h1 { font-size:1.75rem; font-weight:900; color:#fff; margin:0 0 6px; line-height:1.15; letter-spacing:-.3px; }
.hero-left p  { font-size:14px; color:rgba(255,255,255,.60); margin:0; }
.hero-chips   { display:flex; gap:9px; flex-wrap:wrap; margin-top:20px; }
.hero-chip {
    background:rgba(255,255,255,.11); border:1px solid rgba(255,255,255,.18);
    border-radius:10px; padding:7px 14px; font-size:12.5px; font-weight:600;
    color:rgba(255,255,255,.88); display:inline-flex; align-items:center; gap:7px;
    backdrop-filter:blur(6px);
}
.hero-chip i { color:#f59e0b; }
.hero-right { display:flex; flex-direction:column; align-items:flex-end; gap:14px; }
.vc-emblem {
    width:80px; height:80px; border-radius:20px;
    background:rgba(255,255,255,.10); border:1.5px solid rgba(255,255,255,.20);
    display:flex; align-items:center; justify-content:center;
    font-size:36px; color:#f59e0b;
    backdrop-filter:blur(8px); box-shadow:0 8px 28px rgba(0,0,0,.20);
}
.hero-nav { display:flex; gap:8px; }
.hnav-btn {
    background:rgba(255,255,255,.12); border:1.5px solid rgba(255,255,255,.20);
    border-radius:11px; padding:9px 18px; color:rgba(255,255,255,.90);
    font-size:13px; font-weight:700; display:inline-flex; align-items:center; gap:8px;
    text-decoration:none; transition:all .22s; backdrop-filter:blur(4px);
}
.hnav-btn:hover { background:rgba(255,255,255,.22); color:#fff; text-decoration:none; transform:translateY(-2px); }

/* ══ STAT CARDS ══ */
.stat-row {
    display:grid; grid-template-columns:repeat(5,1fr);
    gap:14px; margin-bottom:22px;
}
@media(max-width:1200px){ .stat-row{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:640px) { .stat-row{ grid-template-columns:repeat(2,1fr); } }

.sc {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:16px;
    padding:20px 18px 16px; position:relative; overflow:hidden;
    box-shadow:0 2px 12px rgba(15,45,110,.05);
    transition:transform .25s,box-shadow .25s,border-color .25s; cursor:default;
}
.sc:hover { transform:translateY(-5px); box-shadow:0 14px 36px rgba(15,45,110,.12); border-color:rgba(26,86,219,.15); }
.sc-glow  { position:absolute; width:110px; height:110px; border-radius:50%; top:-35px; right:-25px; pointer-events:none; opacity:.6; }
.sc-top   { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.sc-icon  { width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.sc-badge { font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px; display:inline-flex; align-items:center; gap:4px; }
.badge-blue   { background:#dbeafe; color:#1d4ed8; }
.badge-green  { background:#dcfce7; color:#15803d; }
.badge-amber  { background:#fef9c3; color:#b45309; }
.badge-purple { background:#e0e7ff; color:#4338ca; }
.sc-val   { font-size:2.2rem; font-weight:900; color:#0f172a; line-height:1; letter-spacing:-1px; animation:countUp .5s ease both; }
.sc-label { font-size:12.5px; font-weight:600; color:#64748b; margin-top:4px; }
.sc-bar   { height:3px; background:#f1f5f9; border-radius:20px; margin-top:14px; overflow:hidden; }
.sc-bar-fill { height:100%; border-radius:20px; transition:width 1.4s cubic-bezier(.4,0,.2,1); }

/* ══ WEEKEND ALERT ══ */
.wa-alert {
    background:#fff; border:1.5px solid #fed7aa; border-radius:18px;
    overflow:hidden; box-shadow:0 3px 18px rgba(194,65,12,.10); margin-bottom:22px;
}
.wa-stripe { height:4px; background:linear-gradient(90deg,#c2410c,#f97316,#fb923c); }
.wa-header {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; padding:16px 22px 14px;
    background:linear-gradient(135deg,#fff7ed,#ffedd5);
    border-bottom:1px solid #fed7aa;
}
.wa-title-icon {
    width:32px; height:32px; border-radius:9px;
    background:#fff7ed; color:#c2410c; border:1.5px solid #fed7aa;
    display:flex; align-items:center; justify-content:center; font-size:14px; flex-shrink:0;
}
.wa-title-text { font-size:14px; font-weight:800; color:#7c2d12; }
.wa-title-sub  { font-size:12px; font-weight:500; color:#92400e; margin-top:1px; }
.wa-view-btn {
    background:linear-gradient(135deg,#c2410c,#f97316); color:#fff; border:none;
    border-radius:10px; padding:8px 16px; font-size:12.5px; font-weight:700;
    display:inline-flex; align-items:center; gap:7px; text-decoration:none;
    box-shadow:0 3px 10px rgba(194,65,12,.28); transition:all .2s; flex-shrink:0;
}
.wa-view-btn:hover { transform:translateY(-2px); box-shadow:0 5px 16px rgba(194,65,12,.36); color:#fff; text-decoration:none; }
.wa-body { padding:16px 22px 18px; }
.wa-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:14px; }
@media(max-width:768px){ .wa-grid{ grid-template-columns:1fr; } }
.wa-box        { border-radius:13px; padding:14px 16px; }
.wa-box-orange { background:#fff7ed; border:1.5px solid #fed7aa; }
.wa-box-red    { background:#fef2f2; border:1.5px solid #fecaca; }
.wa-box-label  { font-size:10.5px; font-weight:700; letter-spacing:.5px; text-transform:uppercase; margin-bottom:10px; display:flex; align-items:center; gap:6px; }
.wa-nearest-title { font-size:14px; font-weight:800; color:#7c2d12; margin-bottom:7px; }
.wa-nearest-meta  { display:flex; flex-direction:column; gap:4px; font-size:12px; color:#92400e; }
.wa-nearest-meta i { color:#fb923c; width:14px; }
.wa-av {
    width:36px; height:36px; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:11px; font-weight:800;
    border:2px solid #fff; box-shadow:0 2px 6px rgba(0,0,0,.12);
    flex-shrink:0; cursor:default;
}
.wa-staff-line { display:flex; align-items:center; gap:7px; font-size:12px; color:#7f1d1d; margin-bottom:4px; }
.wa-staff-line:last-child { margin-bottom:0; }
.wa-staff-name { font-weight:700; }
.wa-staff-prog { color:#b91c1c; font-size:11px; }
.wa-chip        { font-size:11.5px; font-weight:700; padding:4px 12px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }
.wa-chip-orange { background:#fff7ed; border:1px solid #fed7aa; color:#c2410c; }
.wa-chip-red    { background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; }
.wa-chip-amber  { background:#fef9c3; border:1px solid #fde68a; color:#b45309; }

/* ══ BOTTOM GRID ══ */
.bottom-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; }
@media(max-width:1200px){ .bottom-grid{ grid-template-columns:1fr; } }
.left-col  { display:flex; flex-direction:column; gap:20px; }
.right-col { display:flex; flex-direction:column; gap:20px; }

/* ══ PANEL ══ */
.panel { background:#fff; border:1.5px solid #e2e8f0; border-radius:18px; overflow:hidden; box-shadow:0 2px 14px rgba(15,45,110,.06); }
.panel-stripe { height:4px; }
.panel-hdr { display:flex; align-items:center; justify-content:space-between; padding:16px 22px 14px; border-bottom:1px solid #f1f5f9; }
.panel-title { font-size:14px; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:9px; }
.panel-title-icon { width:28px; height:28px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:13px; }
.panel-link { font-size:12.5px; font-weight:700; color:#1a56db; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:gap .2s; }
.panel-link:hover { gap:8px; color:#0f2d6e; text-decoration:none; }

/* ══ PROGRAM LIST ══ */
.prog-item { display:flex; align-items:flex-start; gap:13px; padding:13px 22px; border-bottom:1px solid #f8faff; transition:background .15s; }
.prog-item:hover { background:#f8faff; }
.prog-item:last-child { border-bottom:none; }
.prog-status-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; margin-top:5px; position:relative; }
.prog-status-dot.pulse::after { content:''; position:absolute; inset:-3px; border-radius:50%; border:2px solid currentColor; animation:pulse-ring 1.4s ease-out infinite; }
.prog-info  { flex:1; min-width:0; }
.prog-title { font-size:13.5px; font-weight:700; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.prog-meta  { font-size:12px; color:#94a3b8; margin-top:3px; display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.prog-meta i { font-size:11px; }
.sb { font-size:11px; font-weight:700; padding:3px 9px; border-radius:20px; display:inline-flex; align-items:center; gap:4px; flex-shrink:0; }
.sb-upcoming    { background:#dbeafe; color:#1d4ed8; }
.sb-ongoing     { background:#dcfce7; color:#15803d; }
.sb-completed   { background:#e0e7ff; color:#3730a3; }
.sb-cancelled   { background:#fee2e2; color:#b91c1c; }
.sb-rescheduled { background:#fef9c3; color:#b45309; }

/* ══ DEPT ══ */
.dept-item { display:flex; align-items:center; gap:12px; padding:12px 22px; border-bottom:1px solid #f8faff; transition:background .15s; }
.dept-item:hover { background:#f8faff; }
.dept-item:last-child { border-bottom:none; }
.dept-av { width:38px; height:38px; border-radius:11px; background:linear-gradient(135deg,#0f2d6e,#1a56db); display:flex; align-items:center; justify-content:center; color:#fff; font-size:12px; font-weight:800; flex-shrink:0; }
.dept-name-t { font-size:13.5px; font-weight:700; color:#0f172a; }
.dept-code-t { font-size:11.5px; color:#94a3b8; margin-top:1px; }
.dept-prog-count { margin-left:auto; text-align:right; }
.dept-prog-count strong { font-size:15px; font-weight:800; color:#0f172a; display:block; }
.dept-prog-count span   { font-size:11px; color:#94a3b8; }
.dept-bar-track { height:5px; background:#f1f5f9; border-radius:10px; overflow:hidden; }
.dept-bar-fill  { height:100%; border-radius:10px; background:linear-gradient(90deg,#0f2d6e,#1a56db); transition:width 1.2s cubic-bezier(.4,0,.2,1); }

/* Department Scroll */
.dept-scroll { max-height: 580px; /* adjust height */ overflow-y: auto; scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;}
/* Chrome Scrollbar */
.dept-scroll::-webkit-scrollbar { width: 6px; }
.dept-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px;}
.dept-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8;}

/* ══ DONUT ══ */
.donut-wrap   { padding:20px 22px; display:flex; align-items:center; gap:24px; flex-wrap:wrap; }
.donut-svg    { flex-shrink:0; }
.donut-legend { flex:1; min-width:120px; }
.dl-item  { display:flex; align-items:center; gap:9px; margin-bottom:9px; font-size:13px; }
.dl-item:last-child { margin-bottom:0; }
.dl-dot   { width:10px; height:10px; border-radius:50%; flex-shrink:0; }
.dl-label { color:#475569; font-weight:600; flex:1; }
.dl-count { font-weight:800; color:#0f172a; }

/* ══ QUICK ACTIONS ══ */
.qa-item { display:flex; align-items:center; gap:13px; padding:13px 18px; border-bottom:1px solid #f8faff; text-decoration:none; transition:all .22s; }
.qa-item:last-child { border-bottom:none; }
.qa-item:hover { background:#f8faff; padding-left:24px; text-decoration:none; }
.qa-icon { width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:17px; flex-shrink:0; }
.qa-text strong { font-size:13.5px; font-weight:700; color:#1e293b; display:block; }
.qa-text span   { font-size:12px; color:#94a3b8; }
.qa-arr { margin-left:auto; color:#cbd5e1; font-size:13px; transition:color .2s,transform .2s; }
.qa-item:hover .qa-arr { color:#1a56db; transform:translateX(4px); }

/* ══ TIMELINE ══ */
.tl-item { display:flex; gap:14px; padding:12px 22px; border-bottom:1px solid #f8faff; transition:background .15s; }
.tl-item:hover { background:#f8faff; }
.tl-item:last-child { border-bottom:none; }
.tl-date-col { text-align:center; flex-shrink:0; width:40px; }
.tl-day   { font-size:20px; font-weight:900; color:#0f172a; line-height:1; }
.tl-month { font-size:10.5px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; }
.tl-divider { width:2px; background:linear-gradient(to bottom,#1a56db,#e2e8f0); border-radius:2px; flex-shrink:0; position:relative; }
.tl-divider::before { content:''; position:absolute; top:6px; left:50%; transform:translateX(-50%); width:8px; height:8px; border-radius:50%; background:#1a56db; border:2px solid #fff; box-shadow:0 0 0 2px #1a56db; }
.tl-info  { flex:1; min-width:0; }
.tl-title { font-size:13.5px; font-weight:700; color:#0f172a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.tl-sub   { font-size:12px; color:#94a3b8; margin-top:3px; display:flex; gap:10px; flex-wrap:wrap; }

</style>
@endpush

@section('content')

@php
    $user     = auth()->user();
    $hour     = now()->hour;
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');

    $programs     = $programs     ?? collect();
    $departments  = $departments  ?? collect();
    $wa           = $weekendAlert ?? ['program_count'=>0,'staff_count'=>0,'staff'=>[],'nearest'=>null];

    $totalPrograms   = $programs->count();
    $upcoming        = $programs->where('status','upcoming')->count();
    $ongoing         = $programs->where('status','ongoing')->count();
    $completed       = $programs->where('status','completed')->count();
    $cancelled       = $programs->where('status','cancelled')->count();
    $rescheduled     = $programs->where('status','rescheduled')->count();
    $recentPrograms  = $programs->sortByDesc('created_at')->take(6);
    $upcomingPrograms= $programs->whereIn('status',['upcoming','ongoing'])->sortBy('start_date')->take(5);
    $maxDeptCount    = $departments->max(fn($d) => $d->programs_count ?? 0) ?: 1;

    $dotColor = ['upcoming'=>'#3b82f6','ongoing'=>'#16a34a','completed'=>'#6366f1','rescheduled'=>'#f59e0b','cancelled'=>'#ef4444'];
    $sbClass  = ['upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing','completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled'];
    $sbIcon   = ['upcoming'=>'fa-clock','ongoing'=>'fa-circle-play','completed'=>'fa-circle-check','cancelled'=>'fa-ban','rescheduled'=>'fa-clock-rotate-left'];

    $donutTotal    = max($totalPrograms, 1);
    $circumference = 2 * M_PI * 42;
    $offset = 0;
    $donutSegments = [];
    foreach([
        ['upcoming',$upcoming,'#3b82f6'],['ongoing',$ongoing,'#16a34a'],
        ['completed',$completed,'#6366f1'],['rescheduled',$rescheduled,'#f59e0b'],['cancelled',$cancelled,'#ef4444'],
    ] as $seg){
        $dash = $circumference * ($seg[1] / $donutTotal);
        $donutSegments[] = ['label'=>$seg[0],'count'=>$seg[1],'color'=>$seg[2],'dash'=>$dash,'gap'=>$circumference-$dash,'offset'=>$circumference-$offset];
        $offset += $dash;
    }
@endphp

{{-- ══ HERO ══ --}}
<div class="vc-hero fu">
    <div class="hero-inner">
        <div class="hero-left">
            <h1>{{ $greeting }}, {{ $user->name }} 👋</h1>
            <p>University-wide programs overview &mdash; Vice Chancellor's view.</p>
            <div class="hero-chips">
                <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('l, d F Y') }}</span>
                <span class="hero-chip"><i class="fa fa-star"></i>Vice Chancellor</span>
                <span class="hero-chip"><i class="fa fa-circle" style="font-size:8px;color:#4ade80;"></i> All systems operational</span>
                @if($wa['program_count'] > 0)
                <span class="hero-chip" style="background:rgba(249,115,22,.20);border-color:rgba(249,115,22,.35);">
                    <i class="fa fa-triangle-exclamation" style="color:#fb923c;"></i>
                    {{ $wa['staff_count'] }} staff on weekend duty
                </span>
                @endif
            </div>
        </div>
        <div class="hero-right">
            {{-- <div class="vc-emblem"><i class="fa fa-star"></i></div> --}}
            <div class="hero-nav">
                <a href="{{ route('vc.programs') }}"    class="hnav-btn"><i class="fa fa-list"></i> Programs</a>
                <a href="{{ route('vc.calendar') }}" class="hnav-btn"><i class="fa fa-calendar-days"></i> Calendar</a>
            </div>
        </div>
    </div>
</div>

{{-- ══ STAT CARDS ══ --}}
<div class="stat-row">
    <div class="sc fu d1">
        <div class="sc-glow" style="background:radial-gradient(circle,#bfdbfe,transparent);"></div>
        <div class="sc-top">
            <div class="sc-icon" style="background:#eff6ff;color:#1d4ed8;"><i class="fa fa-layer-group"></i></div>
            <span class="sc-badge badge-blue"><i class="fa fa-minus" style="font-size:9px;"></i> All</span>
        </div>
        <div class="sc-val">{{ $totalPrograms }}</div>
        <div class="sc-label">Total Programs</div>
        <div class="sc-bar"><div class="sc-bar-fill" style="width:100%;background:linear-gradient(90deg,#1a56db,#3b82f6);"></div></div>
    </div>
    <div class="sc fu d2">
        <div class="sc-glow" style="background:radial-gradient(circle,#bbf7d0,transparent);"></div>
        <div class="sc-top">
            <div class="sc-icon" style="background:#f0fdf4;color:#15803d;"><i class="fa fa-circle-play"></i></div>
            <span class="sc-badge badge-green"><i class="fa fa-circle" style="font-size:7px;"></i> Live</span>
        </div>
        <div class="sc-val">{{ $ongoing }}</div>
        <div class="sc-label">Currently Ongoing</div>
        <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $totalPrograms > 0 ? round($ongoing/$totalPrograms*100) : 0 }}%;background:linear-gradient(90deg,#15803d,#4ade80);"></div></div>
    </div>
    <div class="sc fu d3">
        <div class="sc-glow" style="background:radial-gradient(circle,#bfdbfe,transparent);"></div>
        <div class="sc-top">
            <div class="sc-icon" style="background:#eff6ff;color:#1a56db;"><i class="fa fa-clock"></i></div>
            <span class="sc-badge badge-blue"><i class="fa fa-arrow-trend-up" style="font-size:9px;"></i> Soon</span>
        </div>
        <div class="sc-val">{{ $upcoming }}</div>
        <div class="sc-label">Upcoming Programs</div>
        <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $totalPrograms > 0 ? round($upcoming/$totalPrograms*100) : 0 }}%;background:linear-gradient(90deg,#1a56db,#60a5fa);"></div></div>
    </div>
    <div class="sc fu d4">
        <div class="sc-glow" style="background:radial-gradient(circle,#c7d2fe,transparent);"></div>
        <div class="sc-top">
            <div class="sc-icon" style="background:#e0e7ff;color:#4338ca;"><i class="fa fa-circle-check"></i></div>
            <span class="sc-badge badge-purple"><i class="fa fa-check" style="font-size:9px;"></i> Done</span>
        </div>
        <div class="sc-val">{{ $completed }}</div>
        <div class="sc-label">Completed</div>
        <div class="sc-bar"><div class="sc-bar-fill" style="width:{{ $totalPrograms > 0 ? round($completed/$totalPrograms*100) : 0 }}%;background:linear-gradient(90deg,#4338ca,#818cf8);"></div></div>
    </div>
    <div class="sc fu d5">
        <div class="sc-glow" style="background:radial-gradient(circle,#fde68a,transparent);"></div>
        <div class="sc-top">
            <div class="sc-icon" style="background:#fefce8;color:#b45309;"><i class="fa fa-building"></i></div>
            <span class="sc-badge badge-amber"><i class="fa fa-minus" style="font-size:9px;"></i> Active</span>
        </div>
        <div class="sc-val">{{ $departments->count() }}</div>
        <div class="sc-label">Departments</div>
        <div class="sc-bar"><div class="sc-bar-fill" style="width:80%;background:linear-gradient(90deg,#b45309,#fbbf24);"></div></div>
    </div>
</div>

{{-- ══ WEEKEND STAFF ALERT ══ --}}
@if($wa['program_count'] > 0)
<div class="wa-alert fu d2">
    <div class="wa-stripe"></div>
    <div class="wa-header">
        <div class="d-flex align-items-center gap-3">
            <div class="wa-title-icon"><i class="fa fa-triangle-exclamation"></i></div>
            <div>
                <div class="wa-title-text"><i class="fa fa-calendar-week me-1"></i> Weekend Staff Alert</div>
                <div class="wa-title-sub">
                    {{ $wa['staff_count'] }} {{ Str::plural('staff member', $wa['staff_count']) }}
                    working across {{ $wa['program_count'] }} {{ Str::plural('program', $wa['program_count']) }}
                    in the next 14 days
                </div>
            </div>
        </div>
        <a href="{{ route('vc.weekend-staff') }}" class="wa-view-btn">
            <i class="fa fa-calendar-week"></i> Full Report
        </a>
    </div>

    <div class="wa-body">
        <div class="wa-grid">

            @if($wa['nearest'])
            @php $n = $wa['nearest']; @endphp
            <div class="wa-box wa-box-orange">
                <div class="wa-box-label" style="color:#92400e;">
                    <i class="fa fa-circle-exclamation" style="color:#f97316;"></i> Nearest Weekend Program
                </div>
                <div class="wa-nearest-title">{{ $n['title'] }}</div>
                <div class="wa-nearest-meta">
                    <span><i class="fa fa-building"></i> {{ $n['dept'] }}</span>
                    <span><i class="fa fa-calendar-days"></i> {{ $n['start'] }}</span>
                    <span><i class="fa fa-calendar-week" style="color:#f97316;"></i> {{ $n['weekend_days'] }}</span>
                    <span><i class="fa fa-users"></i> {{ $n['member_count'] }} committee {{ Str::plural('member', $n['member_count']) }}</span>
                </div>
            </div>
            @endif

            <div class="wa-box wa-box-red">
                <div class="wa-box-label" style="color:#7f1d1d;">
                    <i class="fa fa-users" style="color:#f87171;"></i>
                    Staff on Weekend Duty
                    <span style="background:#fee2e2;color:#b91c1c;font-size:10px;padding:1px 7px;border-radius:20px;font-weight:700;margin-left:4px;">{{ $wa['staff_count'] }}</span>
                </div>
                <div class="d-flex flex-wrap gap-1 mb-2">
                    @foreach($wa['staff'] as $s)
                    <div class="wa-av" title="{{ $s['name'] }} — {{ $s['program'] }}"
                         style="background:{{ $s['is_lead'] ? 'linear-gradient(135deg,#b45309,#f59e0b)' : 'linear-gradient(135deg,#0f2d6e,#1a56db)' }};">
                        {{ $s['initials'] }}
                    </div>
                    @endforeach
                    @if($wa['staff_count'] > 6)
                    <div class="wa-av" style="background:#f1f5f9;color:#64748b;font-size:10px;">+{{ $wa['staff_count'] - 6 }}</div>
                    @endif
                </div>
                <div>
                    @foreach(array_slice($wa['staff'], 0, 3) as $s)
                    <div class="wa-staff-line">
                        @if($s['is_lead'])
                            <i class="fa fa-crown" style="color:#f59e0b;font-size:10px;"></i>
                        @else
                            <i class="fa fa-circle" style="color:#f87171;font-size:7px;"></i>
                        @endif
                        <span class="wa-staff-name">{{ $s['name'] }}</span>
                        <span class="wa-staff-prog">· {{ Str::limit($s['program'], 24) }}</span>
                    </div>
                    @endforeach
                    @if($wa['staff_count'] > 3)
                    <div style="font-size:12px;color:#b91c1c;font-weight:600;margin-top:4px;">+ {{ $wa['staff_count'] - 3 }} more staff...</div>
                    @endif
                </div>
            </div>

        </div>

        <div class="d-flex gap-2 flex-wrap">
            <span class="wa-chip wa-chip-orange"><i class="fa fa-calendar-week" style="font-size:10px;"></i> {{ $wa['program_count'] }} weekend {{ Str::plural('program', $wa['program_count']) }}</span>
            <span class="wa-chip wa-chip-red"><i class="fa fa-users" style="font-size:10px;"></i> {{ $wa['staff_count'] }} staff committed</span>
            <span class="wa-chip wa-chip-amber"><i class="fa fa-clock" style="font-size:10px;"></i> Within next 14 days</span>
        </div>
    </div>
</div>
@endif

{{-- ══ BOTTOM GRID ══ --}}
<div class="bottom-grid">

    <div class="left-col">

        {{-- Recent Programs --}}
        <div class="panel fu d3">
            <div class="panel-stripe" style="background:linear-gradient(90deg,#0f2d6e,#1a56db);"></div>
            <div class="panel-hdr">
                <div class="panel-title">
                    <span class="panel-title-icon" style="background:#eff6ff;color:#1d4ed8;"><i class="fa fa-layer-group"></i></span>
                    Recent Programs
                </div>
                <a href="{{ route('vc.programs') }}" class="panel-link">View all <i class="fa fa-arrow-right" style="font-size:11px;"></i></a>
            </div>
            @forelse($recentPrograms as $p)
            <div class="prog-item">
                <div class="prog-status-dot {{ $p->status === 'ongoing' ? 'pulse' : '' }}"
                     style="background:{{ $dotColor[$p->status] ?? '#94a3b8' }};color:{{ $dotColor[$p->status] ?? '#94a3b8' }};"></div>
                <div class="prog-info">
                    <div class="prog-title">{{ $p->title }}</div>
                    <div class="prog-meta">
                        <span><i class="fa fa-building"></i> {{ $p->department->name ?? '—' }}</span>
                        <span><i class="fa fa-location-dot"></i> {{ Str::limit($p->venue,24) }}</span>
                        <span><i class="fa fa-calendar-days"></i> {{ $p->start_date->format('d M Y') }}</span>
                    </div>
                </div>
                <span class="sb {{ $sbClass[$p->status] ?? 'sb-upcoming' }}">
                    <i class="fa {{ $sbIcon[$p->status] ?? 'fa-clock' }}" style="font-size:9px;"></i>
                    {{ ucfirst($p->status) }}
                </span>
            </div>
            @empty
            <div style="text-align:center;padding:40px 20px;color:#94a3b8;">
                <i class="fa fa-calendar-xmark" style="font-size:32px;display:block;margin-bottom:10px;color:#cbd5e1;"></i>
                No programs yet.
            </div>
            @endforelse
        </div>

        {{-- Department Breakdown --}}
        <div class="panel fu d4">
            <div class="panel-stripe" style="background:linear-gradient(90deg,#4338ca,#818cf8);"></div>
            <div class="panel-hdr">
                <div class="panel-title">
                    <span class="panel-title-icon" style="background:#e0e7ff;color:#4338ca;"><i class="fa fa-building"></i></span>
                    Programs by Department
                </div>
            </div>
            <div class="dept-scroll">
            @forelse($departments as $dept)
            @php $count = $dept->programs_count ?? 0; $pct = round($count/$maxDeptCount*100); @endphp
            <div class="dept-item">
                <div class="dept-av">{{ strtoupper(substr($dept->name,0,2)) }}</div>
                <div style="flex:1;min-width:0;">
                    <div class="dept-name-t">{{ $dept->name }}</div>
                    <div class="dept-code-t">{{ $dept->code }}</div>
                    <div class="dept-bar-track mt-2"><div class="dept-bar-fill" style="width:{{ $pct }}%;"></div></div>
                </div>
                <div class="dept-prog-count">
                    <strong>{{ $count }}</strong>
                    <span>programs</span>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:30px 20px;color:#94a3b8;font-size:13.5px;">No departments found.</div>
            @endforelse
            </div>
        </div>

    </div>

    <div class="right-col">

        {{-- Status Donut --}}
        <div class="panel fu d3">
            <div class="panel-stripe" style="background:linear-gradient(90deg,#15803d,#4ade80);"></div>
            <div class="panel-hdr">
                <div class="panel-title">
                    <span class="panel-title-icon" style="background:#f0fdf4;color:#15803d;"><i class="fa fa-chart-pie"></i></span>
                    Status Breakdown
                </div>
            </div>
            <div class="donut-wrap">
                <svg class="donut-svg" width="110" height="110" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="42" fill="none" stroke="#f1f5f9" stroke-width="12"/>
                    @foreach($donutSegments as $seg)
                    @if($seg['dash'] > 0)
                    <circle cx="50" cy="50" r="42" fill="none"
                            stroke="{{ $seg['color'] }}" stroke-width="12"
                            stroke-dasharray="{{ $seg['dash'] }} {{ $seg['gap'] }}"
                            stroke-dashoffset="{{ $seg['offset'] }}"
                            stroke-linecap="round"
                            transform="rotate(-90 50 50)"/>
                    @endif
                    @endforeach
                    <text x="50" y="46" text-anchor="middle" font-size="16" font-weight="900" fill="#0f172a">{{ $totalPrograms }}</text>
                    <text x="50" y="58" text-anchor="middle" font-size="8" fill="#94a3b8">total</text>
                </svg>
                <div class="donut-legend">
                    @foreach($donutSegments as $seg)
                    <div class="dl-item">
                        <div class="dl-dot" style="background:{{ $seg['color'] }};"></div>
                        <span class="dl-label">{{ ucfirst($seg['label']) }}</span>
                        <span class="dl-count">{{ $seg['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Upcoming Timeline --}}
        <div class="panel fu d4">
            <div class="panel-stripe" style="background:linear-gradient(90deg,#1a56db,#60a5fa);"></div>
            <div class="panel-hdr">
                <div class="panel-title">
                    <span class="panel-title-icon" style="background:#eff6ff;color:#1a56db;"><i class="fa fa-clock"></i></span>
                    Coming Up
                </div>
                <a href="{{ route('vc.calendar') }}" class="panel-link">Calendar <i class="fa fa-arrow-right" style="font-size:11px;"></i></a>
            </div>
            @forelse($upcomingPrograms as $p)
            <div class="tl-item">
                <div class="tl-date-col">
                    <div class="tl-day">{{ $p->start_date->format('d') }}</div>
                    <div class="tl-month">{{ $p->start_date->format('M') }}</div>
                </div>
                <div class="tl-divider"></div>
                <div class="tl-info">
                    <div class="tl-title">{{ $p->title }}</div>
                    <div class="tl-sub">
                        <span><i class="fa fa-building" style="font-size:10px;color:#94a3b8;"></i> {{ $p->department->name ?? '—' }}</span>
                        <span><i class="fa fa-location-dot" style="font-size:10px;color:#94a3b8;"></i> {{ Str::limit($p->venue,20) }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:30px 20px;color:#94a3b8;font-size:13.5px;">
                <i class="fa fa-calendar-check" style="font-size:28px;display:block;margin-bottom:8px;color:#cbd5e1;"></i>
                No upcoming programs.
            </div>
            @endforelse
        </div>

        {{-- Quick Actions --}}
        <div class="panel fu d5">
            <div class="panel-stripe" style="background:linear-gradient(90deg,#b45309,#f59e0b);"></div>
            <div class="panel-hdr">
                <div class="panel-title">
                    <span class="panel-title-icon" style="background:#fefce8;color:#b45309;"><i class="fa fa-bolt"></i></span>
                    Quick Access
                </div>
            </div>
            <a href="{{ route('vc.programs') }}" class="qa-item">
                <div class="qa-icon" style="background:#eff6ff;"><i class="fa fa-layer-group" style="color:#1d4ed8;"></i></div>
                <div class="qa-text"><strong>All Programs</strong><span>Browse & filter by department</span></div>
                <i class="fa fa-chevron-right qa-arr"></i>
            </a>
            <a href="{{ route('vc.calendar') }}" class="qa-item">
                <div class="qa-icon" style="background:#f0fdf4;"><i class="fa fa-calendar-days" style="color:#15803d;"></i></div>
                <div class="qa-text"><strong>Calendar View</strong><span>Visual timeline of programs</span></div>
                <i class="fa fa-chevron-right qa-arr"></i>
            </a>
            <a href="{{ route('vc.weekend-staff') }}" class="qa-item">
                <div class="qa-icon" style="background:#fff7ed;"><i class="fa fa-calendar-week" style="color:#c2410c;"></i></div>
                <div class="qa-text">
                    <strong>Weekend Staff</strong>
                    <span>{{ $wa['staff_count'] > 0 ? $wa['staff_count'].' staff on weekend duty' : 'Monitor weekend commitments' }}</span>
                </div>
                <i class="fa fa-chevron-right qa-arr"></i>
            </a>
            <a href="{{ route('vc.reports') }}" class="qa-item">
                <div class="qa-icon" style="background:#f0fdf4;"><i class="fa fa-chart-bar" style="color:#15803d;"></i></div>
                <div class="qa-text"><strong>Amazing Reports</strong><span>Generate and view reports</span></div>
                <i class="fa fa-chevron-right qa-arr"></i>
            </a>
        </div>

    </div>

</div>

@endsection
