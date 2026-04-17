@extends('layouts.app')

@section('page-title', 'Programs & Committee')

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu { animation: fadeUp .42s ease both; }
.d1 { animation-delay:.06s; }
.d2 { animation-delay:.13s; }
.d3 { animation-delay:.20s; }
.d4 { animation-delay:.27s; }
.d5 { animation-delay:.34s; }

/* ── Hero ── */
.pc-hero {
    background: linear-gradient(128deg,#0a1f52 0%,#0f2d6e 50%,#1e40af 100%);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(15,45,110,.22);
}
.pc-hero::before {
    content:''; position:absolute;
    width:300px; height:300px; border-radius:50%;
    background:rgba(245,158,11,.10);
    top:-90px; right:-60px; pointer-events:none;
}
.pc-hero::after {
    content:''; position:absolute;
    width:200px; height:200px; border-radius:50%;
    background:rgba(96,165,250,.08);
    bottom:-70px; left:35%; pointer-events:none;
}
.pc-hero h1 { font-size:1.5rem; font-weight:800; color:#fff; margin:0 0 5px; }
.pc-hero p  { font-size:13.5px; color:rgba(255,255,255,.62); margin:0; }
.hero-meta  { display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; }
.hero-chip  {
    background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2);
    border-radius:10px; padding:6px 13px; font-size:12px; font-weight:600;
    color:rgba(255,255,255,.88); display:inline-flex; align-items:center; gap:7px;
}
.hero-chip i { color:#f59e0b; }

/* ── Stat strip ── */
.stat-strip {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 14px;
    margin-bottom: 24px;
}
@media(max-width:900px)  { .stat-strip { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px)  { .stat-strip { grid-template-columns: 1fr; } }

.s-chip {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:14px;
    padding:15px 18px; box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s; cursor:default;
    display:flex; align-items:center; gap:13px;
}
.s-chip:hover { transform:translateY(-3px); box-shadow:0 8px 22px rgba(15,45,110,.10); }
.s-chip-icon  { width:42px; height:42px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
.s-chip-val   { font-size:1.7rem; font-weight:900; color:#0f172a; line-height:1; }
.s-chip-label { font-size:12px; color:#64748b; font-weight:600; margin-top:2px; }

/* ── Search / filter bar ── */
.filter-bar {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; margin-bottom:20px;
}
.filter-left  { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.filter-right { display:flex; align-items:center; gap:8px; }

.f-pill {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:20px;
    padding:6px 14px; font-size:12.5px; font-weight:700; color:#475569;
    cursor:pointer; transition:all .18s; font-family:inherit;
}
.f-pill:hover, .f-pill.on { background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:9px 14px 9px 36px; font-size:13.5px;
    font-family:inherit; background:#f8faff; color:#1e293b;
    width:220px; outline:none; transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.10); background:#fff; }

/* ── Program cards ── */
.prog-list { display:flex; flex-direction:column; gap:16px; }

.prog-block {
    background:#fff;
    border:1.5px solid #e2e8f0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 2px 14px rgba(15,45,110,.06);
    transition:box-shadow .22s;
}
.prog-block:hover { box-shadow:0 8px 28px rgba(15,45,110,.11); }

/* status left stripe */
.prog-block-stripe { height:4px; }

/* ── Program header row ── */
.prog-header {
    display:flex; align-items:center; gap:14px;
    padding:16px 20px;
    cursor:pointer;
    user-select:none;
    transition:background .15s;
}
.prog-header:hover { background:#f8faff; }

.prog-color-dot {
    width:12px; height:12px; border-radius:50%;
    flex-shrink:0;
    box-shadow:0 0 0 3px rgba(0,0,0,.06);
}

.prog-main { flex:1; min-width:0; }
.prog-name { font-size:14.5px; font-weight:800; color:#0f172a; margin-bottom:4px; }
.prog-meta-row {
    display:flex; align-items:center; gap:12px;
    flex-wrap:wrap; font-size:12px; color:#64748b;
}
.prog-meta-row i { color:#94a3b8; font-size:11px; }

/* status badge */
.sb { font-size:11.5px; font-weight:700; padding:4px 11px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }
.sb-upcoming    { background:#dbeafe; color:#1d4ed8; }
.sb-ongoing     { background:#dcfce7; color:#15803d; }
.sb-completed   { background:#e0e7ff; color:#3730a3; }
.sb-cancelled   { background:#fee2e2; color:#b91c1c; }
.sb-rescheduled { background:#fef9c3; color:#b45309; }

.member-pill {
    background:#f1f5f9; color:#475569;
    font-size:11.5px; font-weight:700;
    padding:4px 10px; border-radius:20px;
    display:inline-flex; align-items:center; gap:5px;
}
.member-pill.has-members { background:#eff6ff; color:#1d4ed8; }

.prog-actions-right { display:flex; align-items:center; gap:8px; flex-shrink:0; }

.icon-btn {
    width:32px; height:32px; border:none; border-radius:9px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:13px; cursor:pointer; transition:all .18s; flex-shrink:0;
    text-decoration:none;
}
.icon-btn:hover { filter:brightness(.88); transform:scale(1.08); text-decoration:none; }
.btn-goto-prog { background:#eff6ff; color:#1d4ed8; }
.btn-manage-cm { background:#e0e7ff; color:#3730a3; }

.expand-icon {
    width:28px; height:28px; border:none; border-radius:8px;
    background:transparent; color:#94a3b8;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:12px; cursor:pointer; transition:all .2s;
}
.expand-icon:hover { background:#f1f5f9; color:#475569; }
.expand-icon.open i { transform:rotate(180deg); }
.expand-icon i { transition:transform .28s ease; }

/* ── Committee section ── */
.committee-section {
    border-top:1.5px solid #f1f5f9;
    background:linear-gradient(135deg,#f8faff,#eef2ff);
    padding:18px 20px 20px;
    display:none;
    animation:expandDown .25s ease;
}
@keyframes expandDown {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}

.cm-section-header {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:14px; flex-wrap:wrap; gap:8px;
}
.cm-section-title {
    font-size:13px; font-weight:800; color:#1e293b;
    display:flex; align-items:center; gap:7px;
}
.cm-section-title i {
    width:26px; height:26px; border-radius:7px; background:#e0e7ff;
    display:inline-flex; align-items:center; justify-content:center;
    color:#4338ca; font-size:12px;
}

.btn-manage-full {
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff; border:none; border-radius:9px;
    padding:7px 15px; font-size:12.5px; font-weight:700;
    cursor:pointer; font-family:inherit; text-decoration:none;
    display:inline-flex; align-items:center; gap:6px;
    transition:all .2s;
    box-shadow:0 3px 10px rgba(26,86,219,.25);
}
.btn-manage-full:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(26,86,219,.32); color:#fff; text-decoration:none; }

/* ── Member grid ── */
.member-grid {
    display:grid;
    grid-template-columns:repeat(auto-fill, minmax(220px,1fr));
    gap:10px;
}

.member-card {
    background:#fff;
    border:1.5px solid #e2e8f0;
    border-radius:13px;
    padding:13px 14px;
    display:flex;
    align-items:flex-start;
    gap:11px;
    position:relative;
    transition:all .2s;
    box-shadow:0 1px 6px rgba(15,45,110,.04);
}
.member-card:hover {
    border-color:#bfdbfe;
    box-shadow:0 4px 16px rgba(15,45,110,.09);
    transform:translateY(-2px);
}
.member-card.is-lead {
    background:linear-gradient(135deg,#fffbeb,#fef9c3);
    border-color:#fde68a;
}
.member-card.is-lead:hover { border-color:#f59e0b; }

.lead-crown {
    position:absolute; top:-8px; right:10px;
    background:#f59e0b; color:#fff;
    font-size:9.5px; font-weight:800;
    padding:2px 8px; border-radius:20px;
    display:flex; align-items:center; gap:3px;
    box-shadow:0 2px 8px rgba(245,158,11,.35);
}

.m-avatar {
    width:38px; height:38px; border-radius:11px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:12px; font-weight:800; flex-shrink:0;
}
.is-lead .m-avatar { background:linear-gradient(135deg,#b45309,#f59e0b); }

.m-name { font-size:13px; font-weight:700; color:#0f172a; }
.m-pos  { font-size:11.5px; color:#94a3b8; margin-top:1px; }
.m-resp { font-size:11.5px; color:#64748b; font-style:italic; margin-top:5px; line-height:1.4; }

.role-tag {
    font-size:10.5px; font-weight:700; padding:2px 8px;
    border-radius:20px; display:inline-flex; align-items:center;
    gap:3px; margin-top:5px;
}
.role-committee_head   { background:#fef9c3; color:#b45309; }
.role-coordinator      { background:#e0e7ff; color:#3730a3; }
.role-secretary        { background:#dbeafe; color:#1d4ed8; }
.role-treasurer        { background:#dcfce7; color:#15803d; }
.role-facilitator      { background:#fce7f3; color:#9d174d; }
.role-committee_member { background:#f1f5f9; color:#475569; }

/* ── Empty committee ── */
.empty-committee {
    text-align:center; padding:28px 20px; color:#94a3b8;
}
.empty-committee i { font-size:30px; display:block; margin-bottom:10px; color:#cbd5e1; }
.empty-committee p { font-size:13px; margin:0; }

/* ── Empty page ── */
.empty-page {
    text-align:center; padding:60px 20px;
    background:#fff; border:1.5px solid #e2e8f0;
    border-radius:18px;
}
.empty-page i { font-size:48px; display:block; margin-bottom:16px; color:#cbd5e1; }

</style>
@endpush

@section('content')

@php
    $programs    = $programs ?? collect();
    $totalProgs  = $programs->count();
    $totalMembers= $programs->sum(fn($p) => $p->committee->count());
    $withCommit  = $programs->filter(fn($p) => $p->committee->count() > 0)->count();
    $noCommit    = $totalProgs - $withCommit;

    $dotColor = [
        'upcoming'=>'#3b82f6','ongoing'=>'#16a34a',
        'completed'=>'#6366f1','rescheduled'=>'#f59e0b','cancelled'=>'#ef4444',
    ];
    $sbClass = [
        'upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing',
        'completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled',
    ];
    $sbIcon = [
        'upcoming'=>'fa-clock','ongoing'=>'fa-circle-play',
        'completed'=>'fa-circle-check','cancelled'=>'fa-ban','rescheduled'=>'fa-clock-rotate-left',
    ];
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
    $stripeColor = [
        'upcoming'=>'linear-gradient(90deg,#1d4ed8,#60a5fa)',
        'ongoing'=>'linear-gradient(90deg,#15803d,#4ade80)',
        'completed'=>'linear-gradient(90deg,#4338ca,#818cf8)',
        'rescheduled'=>'linear-gradient(90deg,#b45309,#fbbf24)',
        'cancelled'=>'linear-gradient(90deg,#b91c1c,#f87171)',
    ];
@endphp

{{-- Hero --}}
<div class="pc-hero fu">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h1><i class="fa fa-users-gear me-2" style="color:#f59e0b;"></i>Programs & Committee</h1>
            <p>Overview of all your programs and their assigned committee members.</p>
            <div class="hero-meta">
                <span class="hero-chip"><i class="fa fa-layer-group"></i>{{ $totalProgs }} programs</span>
                <span class="hero-chip"><i class="fa fa-users"></i>{{ $totalMembers }} total members</span>
                <span class="hero-chip"><i class="fa fa-circle-check"></i>{{ $withCommit }} with committee</span>
                @if($noCommit > 0)
                <span class="hero-chip"><i class="fa fa-circle-exclamation" style="color:#f87171;"></i>{{ $noCommit }} without committee</span>
                @endif
            </div>
        </div>
        <a href="{{ route('head.programs.index') }}"
           style="background:rgba(255,255,255,.14);border:1.5px solid rgba(255,255,255,.22);border-radius:12px;padding:10px 20px;color:#fff;font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:all .22s;"
           onmouseover="this.style.background='rgba(255,255,255,.22)'"
           onmouseout="this.style.background='rgba(255,255,255,.14)'">
            <i class="fa fa-arrow-left"></i> Back to Programs
        </a>
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    <div class="s-chip fu d1">
        <div class="s-chip-icon" style="background:#eff6ff;"><i class="fa fa-layer-group" style="color:#1d4ed8;"></i></div>
        <div><div class="s-chip-val">{{ $totalProgs }}</div><div class="s-chip-label">Total Programs</div></div>
    </div>
    <div class="s-chip fu d2">
        <div class="s-chip-icon" style="background:#e0e7ff;"><i class="fa fa-users" style="color:#4338ca;"></i></div>
        <div><div class="s-chip-val">{{ $totalMembers }}</div><div class="s-chip-label">Committee Members</div></div>
    </div>
    <div class="s-chip fu d3">
        <div class="s-chip-icon" style="background:#f0fdf4;"><i class="fa fa-circle-check" style="color:#15803d;"></i></div>
        <div><div class="s-chip-val">{{ $withCommit }}</div><div class="s-chip-label">With Committee</div></div>
    </div>
    <div class="s-chip fu d4">
        <div class="s-chip-icon" style="background:#fef2f2;"><i class="fa fa-circle-exclamation" style="color:#b91c1c;"></i></div>
        <div><div class="s-chip-val">{{ $noCommit }}</div><div class="s-chip-label">No Committee</div></div>
    </div>
</div>

{{-- Filter bar --}}
<div class="filter-bar fu d2">
    <div class="filter-left">
        <span style="font-size:13.5px;font-weight:700;color:#0f172a;">Programs</span>
        <button class="f-pill on" data-f="all">All</button>
        <button class="f-pill" data-f="has-committee">Has Committee</button>
        <button class="f-pill" data-f="no-committee">No Committee</button>
    </div>
    <div class="filter-right">
        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="pcSearch" class="search-inp" placeholder="Search programs…">
        </div>
    </div>
</div>

{{-- Programs list --}}
@if($programs->isEmpty())
<div class="empty-page fu d3">
    <i class="fa fa-calendar-xmark"></i>
    <h5 style="font-weight:800;color:#475569;margin-bottom:8px;">No programs yet</h5>
    <p style="font-size:13.5px;color:#94a3b8;max-width:300px;margin:0 auto 18px;">
        Create your first program to start assigning committee members.
    </p>
    <a href="{{ route('head.programs.index') }}"
       style="background:linear-gradient(135deg,#0f2d6e,#1a56db);color:#fff;padding:10px 22px;border-radius:11px;font-weight:700;font-size:13.5px;text-decoration:none;">
        <i class="fa fa-plus me-1"></i> Create Program
    </a>
</div>
@else
<div class="prog-list fu d3" id="progList">

    @foreach($programs as $program)
    @php
        $memberCount = $program->committee->count();
        $hasCommittee = $memberCount > 0;
    @endphp

    <div class="prog-block"
         data-has-committee="{{ $hasCommittee ? '1' : '0' }}"
         data-title="{{ strtolower($program->title) }}">

        {{-- Status stripe --}}
        <div class="prog-block-stripe"
             style="background:{{ $stripeColor[$program->status] ?? 'linear-gradient(90deg,#1d4ed8,#60a5fa)' }};"></div>

        {{-- Program header --}}
        <div class="prog-header" onclick="toggleBlock({{ $program->id }})">

            <div class="prog-color-dot"
                 style="background:{{ $dotColor[$program->status] ?? '#94a3b8' }};"></div>

            <div class="prog-main">
                <div class="prog-name">{{ $program->title }}</div>
                <div class="prog-meta-row">
                    <span><i class="fa fa-building"></i> {{ $program->department->name ?? '—' }}</span>
                    <span><i class="fa fa-location-dot"></i> {{ $program->venue }}</span>
                    <span><i class="fa fa-calendar-days"></i>
                        {{ $program->start_date->format('d M Y') }} — {{ $program->end_date->format('d M Y') }}
                    </span>
                </div>
            </div>

            <div class="prog-actions-right">

                <span class="sb {{ $sbClass[$program->status] ?? 'sb-upcoming' }}">
                    <i class="fa {{ $sbIcon[$program->status] ?? 'fa-clock' }}" style="font-size:10px;"></i>
                    {{ ucfirst($program->status) }}
                </span>

                <span class="member-pill {{ $hasCommittee ? 'has-members' : '' }}">
                    <i class="fa fa-users" style="font-size:10px;"></i>
                    {{ $memberCount }} {{ Str::plural('member', $memberCount) }}
                </span>

                {{-- Go to program --}}
                <a href="{{ route('head.programs.index') }}"
                   class="icon-btn btn-goto-prog"
                   title="View program"
                   onclick="event.stopPropagation();">
                    <i class="fa fa-arrow-up-right-from-square"></i>
                </a>

                {{-- Manage committee --}}
                <a href="{{ route('head.committee.index', $program->id) }}"
                   class="icon-btn btn-manage-cm"
                   title="Manage committee"
                   onclick="event.stopPropagation();">
                    <i class="fa fa-users-gear"></i>
                </a>

                {{-- Expand toggle --}}
                <button class="expand-icon" id="expand-btn-{{ $program->id }}"
                        onclick="event.stopPropagation(); toggleBlock({{ $program->id }})">
                    <i class="fa fa-chevron-down"></i>
                </button>

            </div>
        </div>

        {{-- Committee section (collapsible) --}}
        <div class="committee-section" id="committee-section-{{ $program->id }}">

            <div class="cm-section-header">
                <div class="cm-section-title">
                    <i class="fa fa-users-gear"></i>
                    Committee Members
                    <span style="background:#e0e7ff;color:#3730a3;font-size:11px;font-weight:700;padding:2px 8px;border-radius:20px;">
                        {{ $memberCount }}
                    </span>
                </div>
                <a href="{{ route('head.committee.index', $program->id) }}" class="btn-manage-full">
                    <i class="fa fa-pen"></i> Manage Committee
                </a>
            </div>

            @if($hasCommittee)
            <div class="member-grid">
                @foreach($program->committee->sortByDesc('pivot.is_lead') as $member)
                @php
                    $isLead = $member->pivot->is_lead;
                    $role   = $member->pivot->role;
                @endphp
                <div class="member-card {{ $isLead ? 'is-lead' : '' }}">

                    @if($isLead)
                    <div class="lead-crown">
                        <i class="fa fa-crown" style="font-size:8px;"></i> Lead
                    </div>
                    @endif

                    <div class="m-avatar">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>

                    <div style="flex:1;min-width:0;">
                        <div class="m-name">{{ $member->name }}</div>
                        <div class="m-pos">{{ $member->position ?? $member->staff_id }}</div>
                        <span class="role-tag role-{{ $role }}">
                            <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}" style="font-size:9px;"></i>
                            {{ $roleLabels[$role] ?? ucfirst($role) }}
                        </span>
                        @if($member->pivot->responsibility)
                        <div class="m-resp">
                            <i class="fa fa-note-sticky me-1" style="font-size:10px;"></i>
                            {{ $member->pivot->responsibility }}
                        </div>
                        @endif
                    </div>

                </div>
                @endforeach
            </div>

            @else
            <div class="empty-committee">
                <i class="fa fa-user-group"></i>
                <p>No committee members yet.<br>
                    <a href="{{ route('head.committee.index', $program->id) }}"
                       style="color:#1a56db;font-weight:700;font-size:13px;">
                        Add members →
                    </a>
                </p>
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

/* ── Toggle expand/collapse ── */
function toggleBlock(programId) {
    var section = document.getElementById('committee-section-' + programId);
    var btn     = document.getElementById('expand-btn-' + programId);
    var isOpen  = section.style.display === 'block';

    if (isOpen) {
        section.style.display = 'none';
        btn.classList.remove('open');
    } else {
        section.style.display = 'block';
        btn.classList.add('open');
    }
}

/* ── Filter pills ── */
var currentFilter = 'all';

document.querySelectorAll('.f-pill').forEach(function (pill) {
    pill.addEventListener('click', function () {
        document.querySelectorAll('.f-pill').forEach(function (p) { p.classList.remove('on'); });
        this.classList.add('on');
        currentFilter = this.dataset.f;
        applyFilter();
    });
});

/* ── Search ── */
document.getElementById('pcSearch').addEventListener('input', function () {
    applyFilter();
});

function applyFilter() {
    var query   = document.getElementById('pcSearch').value.toLowerCase();
    var blocks  = document.querySelectorAll('.prog-block');

    blocks.forEach(function (block) {
        var title        = block.dataset.title || '';
        var hasCommittee = block.dataset.hasCommittee === '1';

        var matchFilter =
            currentFilter === 'all' ||
            (currentFilter === 'has-committee'  && hasCommittee) ||
            (currentFilter === 'no-committee'   && !hasCommittee);

        var matchSearch = title.includes(query);

        block.style.display = (matchFilter && matchSearch) ? '' : 'none';
    });
}

/* ── Auto-expand programs without a committee (highlight attention needed) ── */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.prog-block').forEach(function (block) {
        if (block.dataset.hasCommittee === '0') {
            var id = block.querySelector('.committee-section').id.replace('committee-section-', '');
            // Don't auto-open — just leave collapsed
        }
    });
});
</script>
@endpush
