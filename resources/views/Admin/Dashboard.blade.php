@extends('layouts.app')

@section('title','Admin Dashboard')
@section('page-title','Admin Dashboard')

@push('styles')
<style>

/* ══════════════════════════════════════
   DASHBOARD VARIABLES
══════════════════════════════════════ */
:root {
    --blue-deep:  #0f2d6e;
    --blue-mid:   #1a56db;
    --blue-light: #3b82f6;
    --amber:      #f59e0b;
    --amber-deep: #b45309;
    --green:      #16a34a;
    --red:        #ef4444;
    --indigo:     #6366f1;
    --surface:    #ffffff;
    --bg:         #f0f4ff;
    --border:     #e2e8f0;
    --text:       #0f172a;
    --muted:      #64748b;
}

/* ── Staggered fade-in animation ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}

.fade-up { animation: fadeUp .5s ease both; }
.delay-1 { animation-delay: .08s; }
.delay-2 { animation-delay: .16s; }
.delay-3 { animation-delay: .24s; }
.delay-4 { animation-delay: .32s; }
.delay-5 { animation-delay: .40s; }
.delay-6 { animation-delay: .48s; }

/* ══════════════════════════════════════
   GREETING HERO
══════════════════════════════════════ */
.admin-hero {
    background: linear-gradient(130deg, #0a1f52 0%, #0f2d6e 45%, #1a56db 100%);
    border-radius: 20px;
    padding: 30px 36px;
    position: relative;
    overflow: hidden;
    margin-bottom: 26px;
    box-shadow: 0 12px 40px rgba(15,45,110,0.22);
}

.admin-hero::before {
    content: '';
    position: absolute;
    width: 340px; height: 340px;
    border-radius: 50%;
    background: rgba(245,158,11,0.10);
    top: -120px; right: -80px;
    pointer-events: none;
}

.admin-hero::after {
    content: '';
    position: absolute;
    width: 200px; height: 200px;
    border-radius: 50%;
    background: rgba(96,165,250,0.10);
    bottom: -70px; left: 30%;
    pointer-events: none;
}

.hero-left h1 {
    font-size: 1.65rem;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
    line-height: 1.2;
}

.hero-left p {
    font-size: 14px;
    color: rgba(255,255,255,0.65);
    margin: 0;
}

.hero-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 20px;
}

.hero-chip {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.20);
    border-radius: 10px;
    padding: 7px 14px;
    font-size: 12.5px;
    font-weight: 600;
    color: rgba(255,255,255,0.88);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    backdrop-filter: blur(4px);
}

.hero-chip i { color: var(--amber); font-size: 13px; }

.hero-right {
    position: relative;
    z-index: 1;
    text-align: right;
}

.admin-shield {
    width: 72px; height: 72px;
    border-radius: 18px;
    background: rgba(255,255,255,0.12);
    border: 1.5px solid rgba(255,255,255,0.22);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 32px;
    color: var(--amber);
    backdrop-filter: blur(4px);
}

/* ══════════════════════════════════════
   STAT CARDS  (2×3 grid)
══════════════════════════════════════ */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 26px;
}

@media (max-width: 991px) { .stat-grid { grid-template-columns: repeat(2,1fr); } }
@media (max-width: 576px) { .stat-grid { grid-template-columns: 1fr; } }

.stat-card {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 18px;
    padding: 22px 22px 18px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(15,45,110,0.06);
    transition: transform .25s ease, box-shadow .25s ease;
    cursor: default;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 36px rgba(15,45,110,0.13);
}

.stat-card .card-glow {
    position: absolute;
    width: 120px; height: 120px;
    border-radius: 50%;
    top: -40px; right: -30px;
    pointer-events: none;
    opacity: .55;
}

.stat-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.stat-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.stat-trend {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.trend-up   { background: #dcfce7; color: #15803d; }
.trend-down { background: #fee2e2; color: #b91c1c; }
.trend-neu  { background: #f1f5f9; color: #475569; }

.stat-value {
    font-size: 2.4rem;
    font-weight: 900;
    color: var(--text);
    line-height: 1;
    letter-spacing: -1px;
}

.stat-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    margin-top: 5px;
}

.stat-bar-track {
    height: 4px;
    background: #f1f5f9;
    border-radius: 20px;
    margin-top: 16px;
    overflow: hidden;
}

.stat-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width 1.2s cubic-bezier(.4,0,.2,1);
}

/* ══════════════════════════════════════
   BOTTOM SECTION
══════════════════════════════════════ */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 20px;
}

@media (max-width: 1200px) { .bottom-grid { grid-template-columns: 1fr; } }

/* ── Info panel base ── */
.info-panel {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 2px 14px rgba(15,45,110,0.06);
}

.panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px 14px;
    border-bottom: 1px solid #f1f5f9;
}

.panel-title {
    font-size: 14px;
    font-weight: 800;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 8px;
}

.panel-title i {
    width: 28px; height: 28px;
    border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px;
}

.panel-link {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--blue-mid);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: gap .2s;
}
.panel-link:hover { gap: 8px; color: var(--blue-deep); }

/* ── Recent activity list ── */
.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 13px 22px;
    border-bottom: 1px solid #f8faff;
    transition: background .15s;
}
.activity-item:hover { background: #f8faff; }
.activity-item:last-child { border-bottom: none; }

.act-dot-wrap {
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
    padding-top: 2px;
}

.act-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px currentColor;
}

.act-line {
    width: 2px;
    flex: 1;
    background: #f1f5f9;
    margin-top: 4px;
    min-height: 20px;
}

.act-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.act-body { flex: 1; min-width: 0; }

.act-body p {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 3px;
    line-height: 1.4;
}

.act-body span {
    font-size: 12px;
    color: #94a3b8;
}

/* ── Quick actions ── */
.quick-actions { padding: 16px 22px 20px; }

.quick-title {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #94a3b8;
    margin-bottom: 12px;
}

.qa-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 15px;
    border-radius: 12px;
    border: 1.5px solid var(--border);
    background: #fff;
    text-decoration: none;
    transition: all .22s ease;
    margin-bottom: 10px;
    cursor: pointer;
    width: 100%;
    font-family: inherit;
}

.qa-btn:last-child { margin-bottom: 0; }

.qa-btn:hover {
    border-color: #bfdbfe;
    background: #f8faff;
    transform: translateX(5px);
    box-shadow: 0 4px 16px rgba(15,45,110,0.08);
    text-decoration: none;
}

.qa-icon {
    width: 40px; height: 40px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}

.qa-text strong {
    font-size: 13.5px;
    font-weight: 700;
    color: #1e293b;
    display: block;
}

.qa-text span {
    font-size: 12px;
    color: #94a3b8;
}

.qa-arrow {
    margin-left: auto;
    color: #cbd5e1;
    font-size: 13px;
    transition: color .2s, transform .2s;
}
.qa-btn:hover .qa-arrow { color: var(--blue-mid); transform: translateX(3px); }

/* ── Department breakdown ── */
.dept-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 22px;
    border-bottom: 1px solid #f8faff;
    transition: background .15s;
}
.dept-row:last-child { border-bottom: none; }
.dept-row:hover { background: #f8faff; }

.dept-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    flex-shrink: 0;
}

.dept-name-text { font-size: 13.5px; font-weight: 700; color: #0f172a; }
.dept-code-text { font-size: 11.5px; color: #94a3b8; margin-top: 1px; }

.dept-staff-count {
    margin-left: auto;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}

/* ── Right column ── */
.right-col { display: flex; flex-direction: column; gap: 20px; }

/* ── System health ── */
.health-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px 22px;
    border-bottom: 1px solid #f8faff;
}
.health-item:last-child { border-bottom: none; }

.health-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.health-label { font-size: 13px; font-weight: 600; color: #334155; flex: 1; }

.health-badge {
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}
.health-ok  { background: #dcfce7; color: #15803d; }
.health-warn { background: #fef9c3; color: #b45309; }

</style>
@endpush

@section('content')

@php
    $user           = auth()->user();
    $hour           = now()->hour;
    $greeting       = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');

    /* Pass these from your AdminDashboardController */
    $totalStaff       = $totalStaff       ?? 0;
    $totalDepartments = $totalDepartments ?? 0;
    $totalUsers       = $totalUsers       ?? 0;
    $totalPrograms    = $totalPrograms    ?? 0;
    $activePrograms   = $activePrograms   ?? 0;
    $departments      = $departments      ?? collect();
    $recentActivity   = $recentActivity   ?? collect();
@endphp

{{-- ══ HERO ══ --}}
<div class="admin-hero fade-up">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div class="hero-left">
            <h1>{{ $greeting }}, {{ $user->name }} 👋</h1>
            <p>Here's what's happening across UniManage today.</p>
            <div class="hero-meta">
                <span class="hero-chip">
                    <i class="fa fa-calendar-days"></i>
                    {{ now()->format('l, d F Y') }}
                </span>
                <span class="hero-chip">
                    <i class="fa fa-shield-halved"></i>
                    Administrator
                </span>
                <span class="hero-chip">
                    <i class="fa fa-circle" style="font-size:8px;color:#4ade80;"></i>
                    System Online
                </span>
            </div>
        </div>
        <div class="hero-right">
            <div class="admin-shield">
                <i class="fa fa-shield-halved"></i>
            </div>
        </div>
    </div>
</div>

{{-- ══ STAT CARDS ══ --}}
<div class="stat-grid">

    {{-- Total Staff --}}
    <div class="stat-card fade-up delay-1">
        <div class="card-glow" style="background:radial-gradient(circle,#bfdbfe,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#eff6ff;color:#1d4ed8;">
                <i class="fa fa-users"></i>
            </div>
            <span class="stat-trend trend-up">
                <i class="fa fa-arrow-trend-up"></i> Active
            </span>
        </div>
        <div class="stat-value">{{ $totalStaff }}</div>
        <div class="stat-label">Total Staff Members</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill" style="width:78%;background:linear-gradient(90deg,#1a56db,#3b82f6);"></div>
        </div>
    </div>

    {{-- Departments --}}
    <div class="stat-card fade-up delay-2">
        <div class="card-glow" style="background:radial-gradient(circle,#c7d2fe,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#e0e7ff;color:#4338ca;">
                <i class="fa fa-building"></i>
            </div>
            <span class="stat-trend trend-neu">
                <i class="fa fa-minus"></i> Stable
            </span>
        </div>
        <div class="stat-value">{{ $totalDepartments }}</div>
        <div class="stat-label">Departments</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill" style="width:60%;background:linear-gradient(90deg,#4338ca,#818cf8);"></div>
        </div>
    </div>

    {{-- System Users --}}
    <div class="stat-card fade-up delay-3">
        <div class="card-glow" style="background:radial-gradient(circle,#bbf7d0,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#f0fdf4;color:#15803d;">
                <i class="fa fa-user-shield"></i>
            </div>
            <span class="stat-trend trend-up">
                <i class="fa fa-arrow-trend-up"></i> Access
            </span>
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-label">System Users</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill" style="width:{{ $totalStaff > 0 ? round(($totalUsers/$totalStaff)*100) : 0 }}%;background:linear-gradient(90deg,#16a34a,#4ade80);"></div>
        </div>
    </div>

    {{-- Total Programs --}}
    <div class="stat-card fade-up delay-4">
        <div class="card-glow" style="background:radial-gradient(circle,#fed7aa,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#fff7ed;color:#c2410c;">
                <i class="fa fa-layer-group"></i>
            </div>
            <span class="stat-trend trend-neu">
                <i class="fa fa-minus"></i> Total
            </span>
        </div>
        <div class="stat-value">{{ $totalPrograms }}</div>
        <div class="stat-label">Total Programs</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill" style="width:55%;background:linear-gradient(90deg,#ea580c,#fb923c);"></div>
        </div>
    </div>

    {{-- Active Programs --}}
    <div class="stat-card fade-up delay-5">
        <div class="card-glow" style="background:radial-gradient(circle,#fde68a,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#fefce8;color:#b45309;">
                <i class="fa fa-circle-play"></i>
            </div>
            <span class="stat-trend trend-up">
                <i class="fa fa-circle" style="font-size:8px;"></i> Live
            </span>
        </div>
        <div class="stat-value">{{ $activePrograms }}</div>
        <div class="stat-label">Active Programs</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill" style="width:{{ $totalPrograms > 0 ? round(($activePrograms/$totalPrograms)*100) : 0 }}%;background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
        </div>
    </div>

    {{-- Access Rate --}}
    <div class="stat-card fade-up delay-6">
        <div class="card-glow" style="background:radial-gradient(circle,#fecdd3,transparent);"></div>
        <div class="stat-card-top">
            <div class="stat-icon" style="background:#fff1f2;color:#be123c;">
                <i class="fa fa-chart-pie"></i>
            </div>
            <span class="stat-trend trend-up">
                <i class="fa fa-arrow-trend-up"></i> Rate
            </span>
        </div>
        <div class="stat-value">
            {{ $totalStaff > 0 ? round(($totalUsers / $totalStaff) * 100) : 0 }}<span style="font-size:1.2rem;font-weight:600;color:#64748b;">%</span>
        </div>
        <div class="stat-label">Staff Access Rate</div>
        <div class="stat-bar-track">
            <div class="stat-bar-fill"
                 style="width:{{ $totalStaff > 0 ? round(($totalUsers / $totalStaff) * 100) : 0 }}%;background:linear-gradient(90deg,#be123c,#f43f5e);">
            </div>
        </div>
    </div>

</div>

{{-- ══ BOTTOM SECTION ══ --}}
<div class="bottom-grid">

    {{-- LEFT: Recent activity + Departments --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Recent Activity --}}
        <div class="info-panel fade-up delay-1">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fa fa-clock-rotate-left" style="background:#eff6ff;color:#1a56db;"></i>
                    Recent Activity
                </div>
                <a href="{{ route('admin.staff.index') }}" class="panel-link">
                    View all <i class="fa fa-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>

            @if($recentActivity->isEmpty())
                <div style="text-align:center;padding:40px 20px;color:#94a3b8;">
                    <i class="fa fa-inbox" style="font-size:32px;display:block;margin-bottom:10px;color:#cbd5e1;"></i>
                    <p style="font-size:13.5px;margin:0;">No recent activity yet.</p>
                </div>
            @else
                @foreach($recentActivity as $act)
                <div class="activity-item">
                    <div class="act-icon" style="background:{{ $act['icon_bg'] ?? '#eff6ff' }};">
                        <i class="fa {{ $act['icon'] ?? 'fa-bell' }}" style="color:{{ $act['icon_color'] ?? '#1d4ed8' }};"></i>
                    </div>
                    <div class="act-body">
                        <p>{{ $act['message'] }}</p>
                        <span><i class="fa fa-clock me-1"></i>{{ $act['time'] }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Departments ── --}}
        <div class="info-panel fade-up delay-2">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fa fa-building" style="background:#e0e7ff;color:#4338ca;"></i>
                    Departments
                </div>
                <a href="{{ route('admin.departments.index') }}" class="panel-link">
                    Manage <i class="fa fa-arrow-right" style="font-size:11px;"></i>
                </a>
            </div>

            @forelse($departments as $dept)
            <div class="dept-row">
                <div class="dept-avatar">{{ strtoupper(substr($dept->name, 0, 2)) }}</div>
                <div>
                    <div class="dept-name-text">{{ $dept->name }}</div>
                    <div class="dept-code-text">{{ $dept->code }}</div>
                </div>
                <span class="dept-staff-count">
                    {{ $dept->staff_count ?? ($dept->staff ? $dept->staff->count() : 0) }}
                    staff
                </span>
            </div>
            @empty
            <div style="text-align:center;padding:30px 20px;color:#94a3b8;font-size:13.5px;">
                No departments found.
            </div>
            @endforelse
        </div>

    </div>

    {{-- RIGHT column ── --}}
    <div class="right-col">

        {{-- Quick Actions ── --}}
        <div class="info-panel fade-up delay-3">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fa fa-bolt" style="background:#fefce8;color:#b45309;"></i>
                    Quick Actions
                </div>
            </div>
            <div class="quick-actions">

                <a href="{{ route('admin.staff.index') }}" class="qa-btn">
                    <div class="qa-icon" style="background:#eff6ff;">
                        <i class="fa fa-users" style="color:#1d4ed8;"></i>
                    </div>
                    <div class="qa-text">
                        <strong>Manage Staff</strong>
                        <span>View & edit all staff</span>
                    </div>
                    <i class="fa fa-chevron-right qa-arrow"></i>
                </a>

                <a href="{{ route('admin.departments.index') }}" class="qa-btn">
                    <div class="qa-icon" style="background:#e0e7ff;">
                        <i class="fa fa-building" style="color:#4338ca;"></i>
                    </div>
                    <div class="qa-text">
                        <strong>Departments</strong>
                        <span>Add or edit departments</span>
                    </div>
                    <i class="fa fa-chevron-right qa-arrow"></i>
                </a>

                <a href="{{ route('admin.users.index') }}" class="qa-btn">
                    <div class="qa-icon" style="background:#f0fdf4;">
                        <i class="fa fa-user-shield" style="color:#15803d;"></i>
                    </div>
                    <div class="qa-text">
                        <strong>System Users</strong>
                        <span>Manage access & roles</span>
                    </div>
                    <i class="fa fa-chevron-right qa-arrow"></i>
                </a>

            </div>
        </div>

        {{-- System Health ── --}}
        <div class="info-panel fade-up delay-4">
            <div class="panel-header">
                <div class="panel-title">
                    <i class="fa fa-heart-pulse" style="background:#fff1f2;color:#be123c;"></i>
                    System Health
                </div>
            </div>

            @php
                $accessRate = $totalStaff > 0 ? round(($totalUsers / $totalStaff) * 100) : 0;
            @endphp

            <div class="health-item">
                <div class="health-icon" style="background:#dcfce7;">
                    <i class="fa fa-server" style="color:#15803d;"></i>
                </div>
                <span class="health-label">Database</span>
                <span class="health-badge health-ok"><i class="fa fa-circle" style="font-size:7px;"></i> Online</span>
            </div>

            <div class="health-item">
                <div class="health-icon" style="background:#dcfce7;">
                    <i class="fa fa-calendar-check" style="color:#15803d;"></i>
                </div>
                <span class="health-label">Scheduler</span>
                <span class="health-badge health-ok"><i class="fa fa-circle" style="font-size:7px;"></i> Running</span>
            </div>

            <div class="health-item">
                <div class="health-icon" style="background:{{ $accessRate >= 50 ? '#dcfce7' : '#fef9c3' }};">
                    <i class="fa fa-key" style="color:{{ $accessRate >= 50 ? '#15803d' : '#b45309' }};"></i>
                </div>
                <span class="health-label">Staff Access Rate</span>
                <span class="health-badge {{ $accessRate >= 50 ? 'health-ok' : 'health-warn' }}">
                    {{ $accessRate }}%
                </span>
            </div>

            <div class="health-item">
                <div class="health-icon" style="background:#dcfce7;">
                    <i class="fa fa-shield-halved" style="color:#15803d;"></i>
                </div>
                <span class="health-label">Authentication</span>
                <span class="health-badge health-ok"><i class="fa fa-circle" style="font-size:7px;"></i> Secure</span>
            </div>

        </div>

    </div>

</div>

@endsection
