@extends('layouts.app')

@section('page-title','Dashboard')

@push('styles')
<style>

/* ── Greeting banner ── */
.greeting-banner {
    background: linear-gradient(135deg, #0f2d6e 0%, #1a56db 60%, #3b82f6 100%);
    border-radius: 18px;
    padding: 28px 32px;
    position: relative;
    overflow: hidden;
    margin-bottom: 28px;
}

.greeting-banner::before {
    content: '';
    position: absolute;
    width: 260px; height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    top: -80px; right: -60px;
}

.greeting-banner::after {
    content: '';
    position: absolute;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(245,158,11,0.15);
    bottom: -50px; right: 120px;
}

.greeting-banner h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 4px;
}

.greeting-banner p {
    font-size: 14px;
    color: rgba(255,255,255,0.72);
    margin: 0;
}

.greeting-date {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.18);
    border-radius: 10px;
    padding: 8px 16px;
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,0.90);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    backdrop-filter: blur(4px);
}

/* ── Stat cards ── */
.stat-card {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 16px !important;
    background: #fff;
    box-shadow: 0 2px 12px rgba(15,45,110,0.06) !important;
    transition: all .28s ease;
    overflow: hidden;
    position: relative;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 32px rgba(15,45,110,0.12) !important;
    border-color: #bfdbfe !important;
}

.stat-card .card-stripe {
    height: 4px;
    width: 100%;
}

.stat-card .card-body {
    padding: 20px 22px !important;
}

.stat-icon-wrap {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.stat-value {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    color: #0f172a;
    letter-spacing: -.5px;
}

.stat-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    margin-top: 3px;
}

.stat-change {
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* ── Section title ── */
.section-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
    margin-left: 4px;
}

/* ── Recent programs list ── */
.program-list-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 0;
    border-bottom: 1px solid #f1f5f9;
    transition: background .2s;
}

.program-list-item:last-child { border-bottom: none; }

.program-dot {
    width: 10px; height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}

.program-info { flex: 1; min-width: 0; }

.program-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.program-meta {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.program-status-pill {
    font-size: 11px;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 20px;
    flex-shrink: 0;
}

/* ── Quick actions ── */
.quick-action {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    text-decoration: none;
    transition: all .22s ease;
    margin-bottom: 10px;
}

.quick-action:last-child { margin-bottom: 0; }

.quick-action:hover {
    border-color: #bfdbfe;
    background: #f8faff;
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(15,45,110,0.08);
    text-decoration: none;
}

.quick-action-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.quick-action-text strong {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    display: block;
}

.quick-action-text span {
    font-size: 12px;
    color: #94a3b8;
}

.quick-action-arrow {
    margin-left: auto;
    color: #cbd5e1;
    font-size: 14px;
    transition: color .2s, transform .2s;
}

.quick-action:hover .quick-action-arrow {
    color: #1a56db;
    transform: translateX(3px);
}

/* ── Progress bar ── */
.progress-wrap { margin-bottom: 14px; }
.progress-wrap:last-child { margin-bottom: 0; }

.progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
}

.progress-bar-track {
    height: 8px;
    background: #f1f5f9;
    border-radius: 20px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    border-radius: 20px;
    transition: width 1s ease;
}

/* ── Info card ── */
.info-card {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 16px !important;
    background: #fff;
    box-shadow: 0 2px 12px rgba(15,45,110,0.06) !important;
    padding: 22px;
}

</style>
@endpush

@section('content')

@php
    $user        = auth()->user();
    $hour        = now()->hour;
    $greeting    = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
    $greetIcon   = $hour < 12 ? '🌤️' : ($hour < 17 ? '☀️' : '🌙');

    $totalPrograms = $totalPrograms ?? 0;
    $upcoming      = $upcoming      ?? 0;
    $ongoing       = $ongoing       ?? 0;
    $completed     = $completed     ?? 0;
    $cancelled     = $cancelled     ?? 0;
    $rescheduled   = $rescheduled   ?? 0;

    $safeTotal = $totalPrograms > 0 ? $totalPrograms : 1;
@endphp

{{-- ── Greeting Banner ── --}}
<div class="greeting-banner">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h2>{{ $greetIcon }} {{ $greeting }}, {{ $user->name }}!</h2>
            <p>Here's an overview of your programs today.</p>
        </div>
        <div class="greeting-date">
            <i class="fa fa-calendar-days"></i>
            {{ now()->format('l, d F Y') }}
        </div>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="row g-3 mb-4">

    @foreach([
        [
            'label'  => 'Total Programs',
            'val'    => $totalPrograms,
            'icon'   => 'fa-layer-group',
            'stripe' => 'linear-gradient(90deg,#0f2d6e,#3b82f6)',
            'ibg'    => '#eff6ff',
            'ic'     => '#1d4ed8',
        ],
        [
            'label'  => 'Upcoming',
            'val'    => $upcoming,
            'icon'   => 'fa-clock',
            'stripe' => 'linear-gradient(90deg,#1d4ed8,#60a5fa)',
            'ibg'    => '#dbeafe',
            'ic'     => '#1d4ed8',
        ],
        [
            'label'  => 'Ongoing',
            'val'    => $ongoing,
            'icon'   => 'fa-circle-play',
            'stripe' => 'linear-gradient(90deg,#15803d,#4ade80)',
            'ibg'    => '#dcfce7',
            'ic'     => '#15803d',
        ],
        [
            'label'  => 'Completed',
            'val'    => $completed,
            'icon'   => 'fa-circle-check',
            'stripe' => 'linear-gradient(90deg,#4338ca,#818cf8)',
            'ibg'    => '#e0e7ff',
            'ic'     => '#4338ca',
        ],
        [
            'label'  => 'Rescheduled',
            'val'    => $rescheduled,
            'icon'   => 'fa-clock-rotate-left',
            'stripe' => 'linear-gradient(90deg,#b45309,#fbbf24)',
            'ibg'    => '#fef9c3',
            'ic'     => '#b45309',
        ],
        [
            'label'  => 'Cancelled',
            'val'    => $cancelled,
            'icon'   => 'fa-ban',
            'stripe' => 'linear-gradient(90deg,#b91c1c,#f87171)',
            'ibg'    => '#fee2e2',
            'ic'     => '#b91c1c',
        ],
    ] as $s)
    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card">
            <div class="card-stripe" style="background:{{ $s['stripe'] }};"></div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon-wrap" style="background:{{ $s['ibg'] }};">
                        <i class="fa {{ $s['icon'] }}" style="color:{{ $s['ic'] }};"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $s['val'] }}</div>
                <div class="stat-label">{{ $s['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach

</div>

{{-- ── Bottom Section ── --}}
<div class="row g-4">

    {{-- Recent Programs --}}
    <div class="col-12 col-lg-7">
        <div class="info-card">
            <p class="section-title">
                <i class="fa fa-rectangle-list" style="color:#1a56db;"></i>
                Recent Programs
            </p>

            @php $recent = $recentPrograms ?? collect(); @endphp

            @if($recent->isEmpty())
                <div style="text-align:center;padding:40px 0;color:#94a3b8;">
                    <i class="fa fa-calendar-xmark" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                    <p style="font-size:14px;margin:0;">No programs yet. Create your first one!</p>
                </div>
            @else
                @php
                    $dotColors = [
                        'upcoming'    => '#3b82f6',
                        'ongoing'     => '#16a34a',
                        'completed'   => '#6366f1',
                        'rescheduled' => '#f59e0b',
                        'cancelled'   => '#ef4444',
                    ];
                    $pillStyles = [
                        'upcoming'    => 'background:#dbeafe;color:#1d4ed8;',
                        'ongoing'     => 'background:#dcfce7;color:#15803d;',
                        'completed'   => 'background:#e0e7ff;color:#3730a3;',
                        'rescheduled' => 'background:#fef9c3;color:#b45309;',
                        'cancelled'   => 'background:#fee2e2;color:#b91c1c;',
                    ];
                @endphp

                @foreach($recent as $program)
                <div class="program-list-item">
                    <div class="program-dot"
                         style="background:{{ $dotColors[$program->status] ?? '#94a3b8' }};"></div>
                    <div class="program-info">
                        <div class="program-name">{{ $program->title }}</div>
                        <div class="program-meta">
                            <span><i class="fa fa-location-dot me-1"></i>{{ $program->venue }}</span>
                            <span><i class="fa fa-calendar me-1"></i>{{ $program->start_date->format('d M Y') }}</span>
                        </div>
                    </div>
                    <span class="program-status-pill"
                          style="{{ $pillStyles[$program->status] ?? 'background:#f1f5f9;color:#475569;' }}">
                        {{ ucfirst($program->status) }}
                    </span>
                </div>
                @endforeach

                <div style="margin-top:16px;">
                    <a href="{{ route('head.programs.index') }}"
                       style="font-size:13.5px;font-weight:600;color:#1a56db;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                        View all programs <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Right column --}}
    <div class="col-12 col-lg-5">

        {{-- Program breakdown --}}
        <div class="info-card mb-4">
            <p class="section-title">
                <i class="fa fa-chart-pie" style="color:#1a56db;"></i>
                Program Breakdown
            </p>

            @foreach([
                ['Upcoming',    $upcoming,    '#3b82f6', '#dbeafe'],
                ['Ongoing',     $ongoing,     '#16a34a', '#dcfce7'],
                ['Completed',   $completed,   '#6366f1', '#e0e7ff'],
                ['Rescheduled', $rescheduled, '#f59e0b', '#fef9c3'],
                ['Cancelled',   $cancelled,   '#ef4444', '#fee2e2'],
            ] as [$label, $val, $color, $track])
            <div class="progress-wrap">
                <div class="progress-label">
                    <span>{{ $label }}</span>
                    <span style="color:{{ $color }};">{{ $val }}</span>
                </div>
                <div class="progress-bar-track" style="background:{{ $track }};">
                    <div class="progress-bar-fill"
                         style="width:{{ $safeTotal > 0 ? round(($val / $safeTotal) * 100) : 0 }}%;background:{{ $color }};">
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Quick Actions --}}
        <div class="info-card">
            <p class="section-title">
                <i class="fa fa-bolt" style="color:#f59e0b;"></i>
                Quick Actions
            </p>

            <a href="{{ route('head.programs.create') }}" class="quick-action">
                <div class="quick-action-icon" style="background:#eff6ff;">
                    <i class="fa fa-circle-plus" style="color:#1d4ed8;"></i>
                </div>
                <div class="quick-action-text">
                    <strong>New Program</strong>
                    <span>Create a new program</span>
                </div>
                <i class="fa fa-chevron-right quick-action-arrow"></i>
            </a>

            <a href="{{ route('head.programs.index') }}" class="quick-action">
                <div class="quick-action-icon" style="background:#f0fdf4;">
                    <i class="fa fa-list-check" style="color:#15803d;"></i>
                </div>
                <div class="quick-action-text">
                    <strong>My Programs</strong>
                    <span>View & manage programs</span>
                </div>
                <i class="fa fa-chevron-right quick-action-arrow"></i>
            </a>

            <a href="{{ route('head.calendar.index') }}" class="quick-action">
                <div class="quick-action-icon" style="background:#fef9c3;">
                    <i class="fa fa-calendar-days" style="color:#b45309;"></i>
                </div>
                <div class="quick-action-text">
                    <strong>Calendar</strong>
                    <span>View programs on calendar</span>
                </div>
                <i class="fa fa-chevron-right quick-action-arrow"></i>
            </a>

            <a href="{{ route('head.merit-claims') }}" class="quick-action">
                <div class="quick-action-icon" style="background:#fff7ed;">
                    <i class="fa fa-trophy" style="color:#ea580c;"></i>
                </div>
                <div class="quick-action-text">
                    <strong>Amazing Merit Claims</strong>
                    <span>View and manage merit claims</span>
                </div>
                <i class="fa fa-chevron-right quick-action-arrow"></i>
            </a>

        </div>

    </div>

</div>

@endsection
