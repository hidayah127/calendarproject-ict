@extends('layouts.app')

@section('title', 'Overview - AmazingTrack')

@push('styles')
<style>
    /* ═══════════════ Layout helpers ═══════════════ */
    .dept-chip {
        background: var(--accent-light); color: #92400e;
        font-weight: 600; font-size: 12px;
        padding: 5px 12px; border-radius: 30px;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .view-switch-link { font-size: 12.5px; font-weight: 600; color: var(--sidebar-to); text-decoration: none; }
    .view-switch-link:hover { text-decoration: underline; }

    /* ═══════════════ Hero figure ═══════════════ */
    .hero-card {
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        border-radius: var(--radius-lg);
        padding: 26px 28px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .hero-card::after {
        content: ''; position: absolute; width: 220px; height: 220px; border-radius: 50%;
        background: rgba(245,158,11,0.14); top: -70px; right: -60px; pointer-events: none;
    }
    .hero-label { font-size: 13px; font-weight: 600; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
    .hero-value { font-size: 52px; font-weight: 700; line-height: 1; margin-bottom: 10px; } /* proportional figures — this is a display number, not a table column */
    .hero-delta { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; padding: 5px 12px; border-radius: 30px; background: rgba(255,255,255,0.14); }
    .hero-delta.up { color: #bbf7d0; }
    .hero-delta.down { color: rgba(255,255,255,0.75); }
    .hero-sub { font-size: 12.5px; color: rgba(255,255,255,0.65); margin-top: 14px; }

    /* ═══════════════ KPI stat tiles ═══════════════ */
    .kpi-tile {
        background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg);
        padding: 16px 18px; height: 100%;
    }
    .kpi-value { font-size: 26px; font-weight: 700; color: var(--text-main); } /* proportional figures */
    .kpi-label { font-size: 12px; color: var(--text-muted); font-weight: 600; margin-top: 2px; }

    /* ═══════════════ Bar charts (built in plain HTML — no chart library) ═══════════════ */
    .chart-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; height: 100%; }
    .chart-title { font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 4px; }
    .chart-subtitle { font-size: 11.5px; color: var(--text-muted); margin-bottom: 16px; }
    .bar-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .bar-row:last-child { margin-bottom: 0; }
    .bar-label { width: 96px; flex-shrink: 0; font-size: 12.5px; font-weight: 600; color: var(--text-main); }
    .bar-track { flex: 1; height: 18px; background: #eef2ff; border-radius: 4px; overflow: hidden; }
    .bar-fill { height: 100%; border-radius: 0 4px 4px 0; min-width: 3px; transition: width .4s ease; }
    .bar-value { width: 28px; flex-shrink: 0; text-align: right; font-size: 12.5px; font-weight: 700; color: var(--text-main); font-variant-numeric: tabular-nums; }

    /* ═══════════════ Agenda / list widgets ═══════════════ */
    .widget-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 20px; height: 100%; }
    .widget-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
    .widget-title { font-size: 13.5px; font-weight: 700; color: var(--text-main); }
    .widget-link { font-size: 12px; font-weight: 600; color: var(--sidebar-to); text-decoration: none; }
    .widget-link:hover { text-decoration: underline; }

    .agenda-item { display: flex; gap: 12px; align-items: flex-start; padding: 10px 0; border-bottom: 1px solid var(--border); cursor: pointer; }
    .agenda-item:last-child { border-bottom: none; padding-bottom: 0; }
    .agenda-date {
        width: 42px; height: 42px; border-radius: 10px; background: #eef2ff; color: var(--sidebar-to);
        display: flex; flex-direction: column; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .agenda-date .d { font-size: 15px; font-weight: 800; line-height: 1; }
    .agenda-date .m { font-size: 9px; font-weight: 700; text-transform: uppercase; }
    .agenda-title { font-size: 13px; font-weight: 600; color: var(--text-main); margin-bottom: 2px; }
    .agenda-meta { font-size: 11.5px; color: var(--text-muted); }

    .weekend-item { display: flex; gap: 10px; align-items: center; padding: 9px 0; border-bottom: 1px solid var(--border); }
    .weekend-item:last-child { border-bottom: none; padding-bottom: 0; }
    .weekend-avatar {
        width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12.5px; flex-shrink: 0;
    }
    .weekend-name { font-size: 12.5px; font-weight: 600; color: var(--text-main); }
    .weekend-meta { font-size: 11px; color: var(--text-muted); }

    .notif-mini { display: flex; gap: 10px; align-items: flex-start; padding: 9px 0; border-bottom: 1px solid var(--border); }
    .notif-mini:last-child { border-bottom: none; padding-bottom: 0; }
    .notif-mini-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 12.5px; flex-shrink: 0; }
    .notif-mini-msg { font-size: 12px; color: var(--text-main); line-height: 1.4; }
    .notif-mini-time { font-size: 10.5px; color: var(--text-muted); margin-top: 2px; }

    .quick-action-btn {
        display: flex; align-items: center; gap: 10px; width: 100%;
        padding: 11px 14px; border-radius: var(--radius-md); border: 1px solid var(--border);
        background: var(--surface); color: var(--text-main); font-size: 13px; font-weight: 600;
        text-decoration: none; margin-bottom: 8px; transition: var(--transition);
    }
    .quick-action-btn:last-child { margin-bottom: 0; }
    .quick-action-btn:hover { background: #eef2ff; border-color: rgba(26,86,219,0.2); color: var(--sidebar-to); }
    .quick-action-btn i { width: 18px; text-align: center; color: var(--sidebar-to); }

    .empty-mini { text-align: center; color: var(--text-muted); font-size: 12px; padding: 20px 0; }

    /* status/category badges reused from the main dashboard */
    .status-badge-upcoming    { background:#dbeafe; color:#1d4ed8; }
    .status-badge-ongoing     { background:#dcfce7; color:#15803d; }
    .status-badge-completed   { background:#e2e8f0; color:#334155; }
    .status-badge-cancelled   { background:#fee2e2; color:#b91c1c; }
    .status-badge-rescheduled { background:#fef9c3; color:#b45309; }
    .weekend-badge-sat { background:#fef3c7; color:#92400e; }
    .weekend-badge-sun { background:#fee2e2; color:#b91c1c; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-chart-line me-2" style="color:var(--sidebar-to)"></i>Overview</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.overview') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex align-items-center flex-wrap gap-2">
        @foreach($departments as $dept)
            <span class="dept-chip"><i class="fa-solid fa-circle" style="font-size:8px;"></i>{{ $dept->code ?? $dept->name }}</span>
        @endforeach
        <a href="{{ route('leader.dashboard') }}" class="view-switch-link ms-2"><i class="fa-solid fa-table-list me-1"></i>Switch to classic view</a>
    </div>
</div>

{{-- ═══════════════ HERO + KPI ROW ═══════════════ --}}
<div class="row g-3 mb-3">
    <div class="col-12 col-lg-5">
        <div class="hero-card h-100">
            <div class="hero-label">Total Programs This Month</div>
            <div class="hero-value">{{ $reportSummary['total'] }}</div>
            <span class="hero-delta {{ $momDelta >= 0 ? 'up' : 'down' }}">
                <i class="fa-solid fa-arrow-{{ $momDelta >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($momDelta) }} vs last month
            </span>
            <div class="hero-sub">Across {{ $departments->count() }} department{{ $departments->count() === 1 ? '' : 's' }} you manage</div>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="row g-3 h-100">
            <div class="col-6">
                <div class="kpi-tile">
                    <div class="kpi-value">{{ $stats['programs'] }}</div>
                    <div class="kpi-label">Total Programs (All Time)</div>
                </div>
            </div>
            <div class="col-6">
                <div class="kpi-tile">
                    <div class="kpi-value">{{ $stats['weekend_staff'] }}</div>
                    <div class="kpi-label">Weekend Duty Staff</div>
                </div>
            </div>
            <div class="col-6">
                <div class="kpi-tile">
                    <div class="kpi-value">{{ $reportSummary['staff_involved'] }}</div>
                    <div class="kpi-label">Staff Involved This Month</div>
                </div>
            </div>
            <div class="col-6">
                <div class="kpi-tile">
                    <div class="kpi-value">{{ $reportSummary['merit_points'] }}</div>
                    <div class="kpi-label">Merit Points This Month</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ BREAKDOWN CHARTS ═══════════════ --}}
@php
    $maxStatus = max(1, $statusCounts->max());
    $maxDept   = max(1, $departmentCounts->max('total') ?? 1);
    $statusMeta = [
        'upcoming'    => ['label' => 'Upcoming',    'color' => '#1d4ed8'],
        'ongoing'     => ['label' => 'Ongoing',     'color' => '#15803d'],
        'completed'   => ['label' => 'Completed',   'color' => '#64748b'],
        'rescheduled' => ['label' => 'Rescheduled', 'color' => '#b45309'],
        'cancelled'   => ['label' => 'Cancelled',   'color' => '#b91c1c'],
    ];
@endphp
<div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-title">Programs by Status</div>
            <div class="chart-subtitle">This month, across all your departments</div>
            @foreach($statusMeta as $key => $meta)
                @php $count = $statusCounts[$key] ?? 0; @endphp
                <div class="bar-row">
                    <div class="bar-label">{{ $meta['label'] }}</div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width: {{ $count > 0 ? max(4, round($count / $maxStatus * 100)) : 0 }}%; background: {{ $meta['color'] }};" title="{{ $meta['label'] }}: {{ $count }}"></div>
                    </div>
                    <div class="bar-value">{{ $count }}</div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="chart-card">
            <div class="chart-title">Programs by Department</div>
            <div class="chart-subtitle">This month{{ $departmentCounts->count() >= 8 ? ' &middot; top 8' : '' }}</div>
            @forelse($departmentCounts as $row)
                <div class="bar-row">
                    <div class="bar-label text-truncate" title="{{ $row['name'] }}">{{ $row['name'] }}</div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width: {{ $row['total'] > 0 ? max(4, round($row['total'] / $maxDept * 100)) : 0 }}%; background: #1a56db;" title="{{ $row['name'] }}: {{ $row['total'] }}"></div>
                    </div>
                    <div class="bar-value">{{ $row['total'] }}</div>
                </div>
            @empty
                <div class="empty-mini">No programs scheduled this month.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ═══════════════ AGENDA + WEEKEND DUTY ═══════════════ --}}
<div class="row g-3 mb-3">
    <div class="col-12 col-lg-6">
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title"><i class="fa-solid fa-calendar-day me-2" style="color:var(--sidebar-to)"></i>Upcoming Programs</span>
                <a href="{{ route('leader.dashboard', ['tab' => 'programs']) }}" class="widget-link">View all</a>
            </div>
            @forelse($upcomingPrograms as $program)
                @php $start = \Carbon\Carbon::parse($program->start_date); @endphp
                <div class="agenda-item" onclick="viewProgram({{ $program->id }})">
                    <div class="agenda-date">
                        <div class="d">{{ $start->format('d') }}</div>
                        <div class="m">{{ $start->format('M') }}</div>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="agenda-title text-truncate">{{ $program->title }}</div>
                        <div class="agenda-meta">{{ optional($program->department)->code }} &middot; {{ $start->format('h:i A') }} &middot; {{ $program->venue }}</div>
                    </div>
                    <span class="badge status-badge-{{ $program->status }}">{{ ucfirst($program->status) }}</span>
                </div>
            @empty
                <div class="empty-mini">No upcoming programs scheduled.</div>
            @endforelse
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title"><i class="fa-solid fa-people-roof me-2" style="color:var(--sidebar-to)"></i>Weekend Duty — Coming Up</span>
                <a href="{{ route('leader.dashboard', ['tab' => 'weekend']) }}" class="widget-link">View all</a>
            </div>
            @forelse($nextWeekendStaff as $row)
                @php $wDate = \Carbon\Carbon::parse($row->program->start_date); $isSat = $wDate->isSaturday(); @endphp
                <div class="weekend-item">
                    <div class="weekend-avatar">{{ strtoupper(substr($row->staff->name ?? '?', 0, 1)) }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="weekend-name text-truncate">{{ $row->staff->name ?? '—' }}</div>
                        <div class="weekend-meta text-truncate">{{ $row->program->title ?? '—' }}</div>
                    </div>
                    <span class="badge {{ $isSat ? 'weekend-badge-sat' : 'weekend-badge-sun' }}">{{ $wDate->format('D, d M') }}</span>
                </div>
            @empty
                <div class="empty-mini">No staff scheduled for an upcoming weekend. 🎉</div>
            @endforelse
        </div>
    </div>
</div>

{{-- ═══════════════ QUICK ACTIONS + NOTIFICATIONS ═══════════════ --}}
<div class="row g-3">
    <div class="col-12 col-lg-5">
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title"><i class="fa-solid fa-bolt me-2" style="color:var(--sidebar-to)"></i>Quick Actions</span>
            </div>
            <a href="{{ route('leader.dashboard', ['tab' => 'programs', 'action' => 'create']) }}" class="quick-action-btn">
                <i class="fa-solid fa-calendar-plus"></i> Add a Program
            </a>
            <a href="{{ route('leader.dashboard', ['tab' => 'reports']) }}" class="quick-action-btn">
                <i class="fa-solid fa-chart-column"></i> Generate Monthly Report
            </a>
            <a href="{{ route('leader.calendar.index') }}" class="quick-action-btn">
                <i class="fa-solid fa-calendar-days"></i> View Program Calendar
            </a>
            <a href="{{ route('leader.staff.index') }}" class="quick-action-btn">
                <i class="fa-solid fa-address-book"></i> Browse Staff Directory
            </a>
        </div>
    </div>
    <div class="col-12 col-lg-7">
        <div class="widget-card">
            <div class="widget-header">
                <span class="widget-title"><i class="fa-solid fa-bell me-2" style="color:var(--sidebar-to)"></i>Recent Notifications</span>
                <a href="{{ route('leader.notifications.index') }}" class="widget-link">View all</a>
            </div>
            @forelse($recentNotifications as $n)
                <div class="notif-mini">
                    <div class="notif-mini-icon" style="background: {{ $n->icon_bg }}; color: {{ $n->icon_color }};">
                        <i class="fa-solid {{ $n->icon }}"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="notif-mini-msg">{{ $n->message }}</div>
                        <div class="notif-mini-time">{{ \Carbon\Carbon::parse($n->created_at)->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-mini">No notifications yet.</div>
            @endforelse
        </div>
    </div>
</div>

{{-- Reuses the same "View Program Details" modal pattern as the dashboard / calendar --}}
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

@endsection

@push('scripts')
<script>
function viewProgram(id) {
    new bootstrap.Modal(document.getElementById('viewProgramModal')).show();
    fetch(`/leader/programs/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => { document.getElementById('viewProgramBody').innerHTML = html; });
}
</script>
@endpush
