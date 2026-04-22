@extends('layouts.app')

@section('page-title', 'Manage Committee — ' . $program->title)

@push('styles')
<style>

/* ── Animations ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu  { animation: fadeUp .42s ease both; }
.d1  { animation-delay:.06s; }
.d2  { animation-delay:.13s; }
.d3  { animation-delay:.20s; }
.d4  { animation-delay:.27s; }

/* ── Page header ── */
.page-hdr {
    display:flex; align-items:flex-start;
    justify-content:space-between; flex-wrap:wrap;
    gap:16px; margin-bottom:24px;
}

.back-btn {
    display:inline-flex; align-items:center; gap:7px;
    background:#fff; border:1.5px solid #e2e8f0;
    border-radius:10px; padding:8px 15px;
    font-size:13px; font-weight:700; color:#475569;
    text-decoration:none; transition:all .2s;
}
.back-btn:hover { border-color:#bfdbfe; color:#1d4ed8; background:#f8faff; text-decoration:none; }

/* ── Program hero card ── */
.prog-hero {
    background: linear-gradient(130deg,#0a1f52 0%,#0f2d6e 48%,#1e40af 100%);
    border-radius: 18px;
    padding: 26px 30px;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 36px rgba(15,45,110,.22);
}
.prog-hero::before {
    content:''; position:absolute;
    width:260px; height:260px; border-radius:50%;
    background:rgba(245,158,11,.10);
    top:-80px; right:-50px; pointer-events:none;
}
.prog-hero-title {
    font-size:1.35rem; font-weight:800; color:#fff; margin:0 0 6px;
}
.prog-hero-sub { font-size:13px; color:rgba(255,255,255,.62); margin:0; }
.prog-meta-chips { display:flex; gap:8px; flex-wrap:wrap; margin-top:16px; }
.prog-chip {
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.2);
    border-radius:9px; padding:5px 12px;
    font-size:12px; font-weight:600;
    color:rgba(255,255,255,.88);
    display:inline-flex; align-items:center; gap:6px;
}
.prog-chip i { color:#f59e0b; }

/* ── Status badge ── */
.sb { font-size:11.5px; font-weight:700; padding:4px 11px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; }
.sb-upcoming    { background:#dbeafe; color:#1d4ed8; }
.sb-ongoing     { background:#dcfce7; color:#15803d; }
.sb-completed   { background:#e0e7ff; color:#3730a3; }
.sb-cancelled   { background:#fee2e2; color:#b91c1c; }
.sb-rescheduled { background:#fef9c3; color:#b45309; }

/* ── Main layout ── */
.cm-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 20px;
    align-items: start;
}
@media(max-width:1100px) { .cm-layout { grid-template-columns: 1fr; } }

/* ── Panel base ── */
.cm-panel {
    background:#fff;
    border:1.5px solid #e2e8f0;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 3px 18px rgba(15,45,110,.07);
}
.cm-panel-stripe { height:5px; }
.cm-panel-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:16px 22px 14px;
    border-bottom:1px solid #f1f5f9;
}
.cm-panel-title {
    font-size:14px; font-weight:800; color:#0f172a;
    display:flex; align-items:center; gap:8px;
}
.cm-panel-title i {
    width:28px; height:28px; border-radius:8px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:13px; flex-shrink:0;
}
.member-count {
    background:#eff6ff; color:#1d4ed8;
    font-size:12px; font-weight:700;
    padding:3px 10px; border-radius:20px;
}

/* ── Committee member cards ── */
.member-list { 
    padding:14px 16px; 
    display:flex; 
    flex-direction:column; 
    gap:10px; 

    /* scrollbar */
    max-height: 520px; 
    overflow-y: auto;
}

/* Custom scrollbar */
.member-list::-webkit-scrollbar {
    width: 8px;
}

.member-list::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

.member-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.member-list::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

.member-card {
    background:#f8faff;
    border:1.5px solid #e8effe;
    border-radius:14px;
    padding:14px 16px;
    display:flex;
    align-items:center;
    gap:13px;
    transition:all .22s ease;
    position:relative;
}
.member-card:hover {
    border-color:#bfdbfe;
    background:#f0f6ff;
    box-shadow:0 4px 16px rgba(26,86,219,.08);
    transform:translateY(-1px);
}

.member-card.is-lead {
    background:linear-gradient(135deg,#fffbeb,#fef9c3);
    border-color:#fde68a;
}
.member-card.is-lead:hover {
    border-color:#f59e0b;
    box-shadow:0 4px 16px rgba(245,158,11,.12);
}

.lead-crown {
    position:absolute; top:-8px; right:14px;
    background:#f59e0b; color:#fff;
    font-size:10px; font-weight:800;
    padding:2px 9px; border-radius:20px;
    display:flex; align-items:center; gap:4px;
    box-shadow:0 2px 8px rgba(245,158,11,.35);
}

.member-avatar {
    width:44px; height:44px; border-radius:13px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:14px; font-weight:800;
    flex-shrink:0;
    box-shadow:0 3px 10px rgba(15,45,110,.20);
}
.member-card.is-lead .member-avatar {
    background:linear-gradient(135deg,#b45309,#f59e0b);
}

.member-name  { font-size:14px; font-weight:700; color:#0f172a; }
.member-pos   { font-size:12px; color:#94a3b8; margin-top:1px; }
.member-resp  { font-size:12px; color:#64748b; margin-top:4px; font-style:italic; }

.role-tag {
    font-size:11.5px; font-weight:700;
    padding:3px 10px; border-radius:20px;
    display:inline-flex; align-items:center; gap:4px;
    margin-top:5px;
}
.role-committee_head   { background:#fef9c3; color:#b45309; }
.role-coordinator      { background:#e0e7ff; color:#3730a3; }
.role-secretary        { background:#dbeafe; color:#1d4ed8; }
.role-treasurer        { background:#dcfce7; color:#15803d; }
.role-facilitator      { background:#fce7f3; color:#9d174d; }
.role-committee_member { background:#f1f5f9; color:#475569; }

.member-actions { margin-left:auto; display:flex; gap:6px; flex-shrink:0; }

.act-btn {
    width:32px; height:32px; border:none; border-radius:9px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:13px; cursor:pointer; transition:all .18s;
}
.act-edit   { background:#fef9c3; color:#b45309; }
.act-remove { background:#fee2e2; color:#b91c1c; }
.act-btn:hover { filter:brightness(.88); transform:scale(1.08); }

/* ── Empty state ── */
.empty-state {
    text-align:center; padding:48px 24px; color:#94a3b8;
}
.empty-state i {
    font-size:44px; display:block;
    margin-bottom:14px; color:#cbd5e1;
}
.empty-state h6 { color:#475569; font-weight:700; margin-bottom:6px; }
.empty-state p  { font-size:13.5px; max-width:260px; margin:0 auto; }

/* ── Add member form ── */
.add-form { padding:18px 22px 20px; }

.form-group { margin-bottom:16px; }
.form-label {
    font-size:11.5px; font-weight:700; color:#475569;
    text-transform:uppercase; letter-spacing:.5px;
    display:block; margin-bottom:6px;
}

.form-control, .form-select {
    border:1.5px solid #e2e8f0 !important;
    border-radius:11px !important;
    padding:10px 14px !important;
    font-size:13.5px !important;
    font-family:inherit !important;
    background:#f8faff !important;
    color:#1e293b !important;
    box-shadow:none !important;
    transition:border-color .2s, box-shadow .2s !important;
    width:100%;
}
.form-control:focus, .form-select:focus {
    border-color:#1a56db !important;
    box-shadow:0 0 0 3px rgba(26,86,219,.10) !important;
    background:#fff !important;
    outline:none !important;
}

.lead-toggle {
    display:flex; align-items:center; gap:10px;
    background:#f8faff; border:1.5px solid #e2e8f0;
    border-radius:11px; padding:11px 14px;
    cursor:pointer; transition:all .2s;
    user-select:none;
}
.lead-toggle:hover { border-color:#fde68a; background:#fffbeb; }
.lead-toggle input { display:none; }
.toggle-track {
    width:38px; height:20px; border-radius:20px;
    background:#e2e8f0; position:relative;
    transition:background .2s; flex-shrink:0;
}
.toggle-thumb {
    width:14px; height:14px; border-radius:50%;
    background:#fff; position:absolute;
    top:3px; left:3px;
    transition:transform .2s;
    box-shadow:0 1px 4px rgba(0,0,0,.18);
}
.lead-toggle input:checked + .toggle-track { background:#f59e0b; }
.lead-toggle input:checked + .toggle-track .toggle-thumb { transform:translateX(18px); }
.toggle-label { font-size:13px; font-weight:700; color:#334155; }
.toggle-sub   { font-size:11.5px; color:#94a3b8; display:block; }

.btn-add-member {
    width:100%; background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff; border:none; border-radius:11px;
    padding:12px; font-size:14px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 4px 14px rgba(26,86,219,.28);
    transition:all .22s; display:flex; align-items:center;
    justify-content:center; gap:8px;
}
.btn-add-member:hover {
    transform:translateY(-2px);
    box-shadow:0 8px 22px rgba(26,86,219,.35);
}

/* Import CSV Button */
.btn-import-csv {
    background: linear-gradient(135deg,#14532d,#16a34a);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 7px 14px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;

    display: flex;
    align-items: center;
    gap: 6px;

    box-shadow: 0 3px 10px rgba(22,163,74,.25);
    transition: all .2s;
}

.btn-import-csv:hover {
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(22,163,74,.35);
}

/* ── Edit / Remove modals ── */
.modal-content {
    border:none !important; border-radius:18px !important;
    overflow:hidden;
    box-shadow:0 24px 60px rgba(15,45,110,.18) !important;
}
.m-stripe { height:5px; }
.modal-header {
    border-bottom:1px solid #f1f5f9 !important;
    padding:20px 24px 16px !important; background:#fff !important;
}
.modal-title {
    font-size:16px !important; font-weight:800 !important;
    color:#0f172a !important;
    display:flex; align-items:center; gap:10px;
}
.m-icon {
    width:34px; height:34px; border-radius:9px;
    display:flex; align-items:center; justify-content:center;
    font-size:15px;
}
.modal-body   { padding:20px 24px !important; }
.modal-footer {
    padding:14px 24px 20px !important;
    border-top:1px solid #f1f5f9 !important;
    background:#fff !important;
}

.danger-zone {
    background:#fef2f2; border:1.5px solid #fecaca;
    border-radius:12px; padding:16px;
    display:flex; align-items:flex-start; gap:12px;
}
.danger-zone i    { color:#ef4444; font-size:20px; flex-shrink:0; margin-top:2px; }
.danger-zone p    { margin:0; font-size:13.5px; color:#374151; line-height:1.5; }
.danger-zone strong { color:#b91c1c; }

.btn-cancel {
    background:#f1f5f9; color:#64748b; border:none;
    border-radius:10px; padding:10px 18px;
    font-size:13.5px; font-weight:600;
    cursor:pointer; font-family:inherit; transition:background .2s;
}
.btn-cancel:hover { background:#e2e8f0; }

.btn-save {
    background:linear-gradient(135deg,#b45309,#f59e0b);
    color:#fff; border:none; border-radius:10px;
    padding:10px 22px; font-size:13.5px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 4px 12px rgba(245,158,11,.25); transition:all .2s;
}
.btn-save:hover { transform:translateY(-1px); }

.btn-remove {
    background:linear-gradient(135deg,#991b1b,#ef4444);
    color:#fff; border:none; border-radius:10px;
    padding:10px 22px; font-size:13.5px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 4px 12px rgba(239,68,68,.25); transition:all .2s;
}
.btn-remove:hover { transform:translateY(-1px); }

</style>
@endpush

@section('content')

@php
    $sbClass = [
        'upcoming'=>'sb-upcoming','ongoing'=>'sb-ongoing',
        'completed'=>'sb-completed','cancelled'=>'sb-cancelled','rescheduled'=>'sb-rescheduled',
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
        'committee_head'   => 'fa-crown',
        'coordinator'      => 'fa-star',
        'secretary'        => 'fa-pen-clip',
        'treasurer'        => 'fa-coins',
        'facilitator'      => 'fa-chalkboard-user',
        'committee_member' => 'fa-user',
    ];
    $totalMembers = $program->committee->count();
    $leadMember   = $program->committee->firstWhere('pivot.is_lead', true);
@endphp

{{-- Page header --}}
<div class="page-hdr fu">
    <div>
        <a href="{{ route('head.programs.committee') }}" class="back-btn mb-2">
            <i class="fa fa-arrow-left"></i> Back to Programs Committee
        </a>
        <h2 style="font-size:1.3rem;font-weight:800;color:#0f172a;margin:8px 0 4px;">
            Manage Committee
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size:13px;">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}" style="color:#1a56db;text-decoration:none;">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('head.programs.index') }}" style="color:#1a56db;text-decoration:none;">Programs</a></li>
                <li class="breadcrumb-item active" style="color:#64748b;">Committee</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Program hero --}}
<div class="prog-hero fu d1">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div>
            <h2 class="prog-hero-title">{{ $program->title }}</h2>
            <p class="prog-hero-sub">
                <i class="fa fa-building me-1"></i>{{ $program->department->name ?? '—' }}
                @if($program->venue)
                    &nbsp;·&nbsp; <i class="fa fa-location-dot me-1"></i>{{ $program->venue }}
                @endif
            </p>
            <div class="prog-meta-chips">
                <span class="prog-chip">
                    <i class="fa fa-calendar-days"></i>
                    {{ $program->start_date->format('d M Y') }} — {{ $program->end_date->format('d M Y') }}
                </span>
                <span class="prog-chip">
                    <i class="fa fa-users"></i>
                    {{ $totalMembers }} {{ Str::plural('member', $totalMembers) }}
                </span>
                @if($leadMember)
                <span class="prog-chip">
                    <i class="fa fa-crown"></i>
                    Lead: {{ $leadMember->name }}
                </span>
                @endif
            </div>
        </div>
        <span class="sb {{ $sbClass[$program->status] ?? 'sb-upcoming' }}" style="font-size:13px;padding:6px 14px;align-self:flex-start;">
            {{ ucfirst($program->status) }}
        </span>
    </div>
</div>

{{-- Main layout --}}
<div class="cm-layout">

    {{-- ═══ LEFT — Committee members list ═══ --}}
    <div class="cm-panel fu d2">
        <div class="cm-panel-stripe" style="background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6);"></div>
        
        <div class="cm-panel-header" style="flex-direction:column;align-items:stretch;gap:10px;">

            <div style="display:flex;align-items:center;justify-content:space-between;">
                <div class="cm-panel-title">
                    <i class="fa fa-users" style="background:#eff6ff;color:#1d4ed8;"></i>
                    Committee Members
                </div>
                <span class="member-count">{{ $totalMembers }}</span>

                 {{-- ✅ Notify Committee Button --}}
                <form method="POST"
                    action="{{ route('head.committee.notify', $program->id) }}">

                    @csrf

                    {{-- <button type="submit"
                            class="btn-import-csv"
                            style="background:linear-gradient(135deg,#9333ea,#7e22ce);">

                        <i class="fa fa-bell"></i>
                        Notify Committee

                    </button> --}}

                    <button type="button"
                            class="btn-import-csv"
                            style="background:linear-gradient(135deg,#9333ea,#7e22ce);"
                            data-bs-toggle="modal"
                            data-bs-target="#notifyCommitteeModal"
                            {{ $program->committee->isEmpty() ? 'disabled' : '' }}>
                        <i class="fa fa-bell"></i>
                        Notify Committee
                    </button>

                </form>
            </div>

            {{-- Search Box --}}
            <div style="position:relative;">
            
                <input type="text"
                    id="memberSearch"
                    placeholder="Search committee member..."
                    class="form-control"
                    style="padding-left:46px;">
            </div>

        </div>

        @if($program->committee->isEmpty())
            <div class="empty-state">
                <i class="fa fa-user-group"></i>
                <h6>No members yet</h6>
                <p>Add staff from your department using the form on the right.</p>
            </div>
        @else
            <div class="member-list">
                @foreach($program->committee->sortByDesc('pivot.is_lead') as $member)
                @php
                    $isLead = $member->pivot->is_lead;
                    $role   = $member->pivot->role;
                @endphp
                <div class="member-card {{ $isLead ? 'is-lead' : '' }}">

                    @if($isLead)
                    <div class="lead-crown">
                        <i class="fa fa-crown" style="font-size:9px;"></i> Lead
                    </div>
                    @endif

                    <div class="member-avatar">
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    </div>

                    <div style="flex:1;min-width:0;">
                        <div class="member-name">{{ $member->name }}</div>
                        <div class="member-pos">{{ $member->staff_id }}</div>

                        <span class="role-tag role-{{ $role }}">
                            <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}" style="font-size:9px;"></i>
                            {{ $roleLabels[$role] ?? ucfirst($role) }}
                        </span>

                        @if($member->pivot->responsibility)
                            <div class="member-resp">
                                <i class="fa fa-note-sticky me-1" style="font-size:11px;"></i>
                                {{ $member->pivot->responsibility }}
                            </div>
                        @endif
                    </div>

                    <div class="member-actions">
                        {{-- Edit --}}
                        <button class="act-btn act-edit"
                                title="Edit member"
                                data-bs-toggle="modal"
                                data-bs-target="#editMemberModal"
                                data-id="{{ $member->id }}"
                                data-name="{{ $member->name }}"
                                data-role="{{ $role }}"
                                data-responsibility="{{ $member->pivot->responsibility ?? '' }}"
                                data-is-lead="{{ $isLead ? '1' : '0' }}">
                            <i class="fa fa-pen"></i>
                        </button>
  
                        {{-- Remove --}}
                        <button class="act-btn act-remove"
                                title="Remove member"
                                data-bs-toggle="modal"
                                data-bs-target="#removeMemberModal"
                                data-id="{{ $member->id }}"
                                data-name="{{ $member->name }}">
                            <i class="fa fa-user-minus"></i>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ═══ RIGHT — Add member form ═══ --}}
    <div class="fu d3">

        <div class="cm-panel">
            <div class="cm-panel-stripe" style="background:linear-gradient(90deg,#15803d,#4ade80);"></div>
            
            {{-- <div class="cm-panel-header">
                
                <div class="cm-panel-title">
                    <i class="fa fa-user-plus" style="background:#f0fdf4;color:#15803d;"></i>
                    Add Member
                </div>

                
            </div> --}}

            <div class="cm-panel-header">

                <div class="cm-panel-title">
                    <i class="fa fa-user-plus" style="background:#f0fdf4;color:#15803d;"></i>
                    Add Member
                </div>

                {{-- ✅ Import CSV Button --}}
                <button type="button"
                        class="btn-import-csv"
                        data-bs-toggle="modal"
                        data-bs-target="#importCSVModal">

                    <i class="fa fa-file-upload"></i>
                    Import CSV

                </button>

            </div>

            <form method="POST" action="{{ route('head.committee.store', $program->id) }}" class="add-form">
                @csrf

                {{-- Staff select --}}
                {{-- <div class="form-group">
                    <label class="form-label">Select Staff</label>
                    @if($availableStaff->isEmpty())
                        <div style="background:#f8faff;border:1.5px solid #e2e8f0;border-radius:11px;padding:14px;text-align:center;font-size:13px;color:#94a3b8;">
                            <i class="fa fa-circle-check me-1" style="color:#16a34a;"></i>
                            All department staff have been added.
                        </div>
                    @else
                        <select name="staff_id" class="form-select" required>
                            <option value="" disabled selected>Choose a staff member…</option>
                            @foreach($availableStaff as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->name }}
                                    — {{ $s->department->name ?? 'No Department' }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div> --}}

                <div class="form-group">
                    <label class="form-label">Select Staff</label>
                    @if($availableStaff->isEmpty())
                        <div style="background:#f8faff;border:1.5px solid #e2e8f0;border-radius:11px;padding:14px;text-align:center;font-size:13px;color:#94a3b8;">
                            <i class="fa fa-circle-check me-1" style="color:#16a34a;"></i>
                            All department staff have been added.
                        </div>
                    @else
                        {{-- Added id="staff-select" here --}}
                        <select name="staff_id" id="staff-select" class="form-select" required>
                            <option value="" disabled selected>Choose a staff member…</option>
                            @foreach($availableStaff as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->name }} — {{ $s->department->name ?? 'No Department' }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label class="form-label">Committee Role</label>
                    <select name="role" class="form-select" required>
                        @foreach($roles as $val => $label)
                            <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Responsibility --}}
                <div class="form-group">
                    <label class="form-label">Responsibility <span style="color:#94a3b8;font-weight:400;">(optional)</span></label>
                    <input type="text" name="responsibility" class="form-control"
                           placeholder="e.g. Manage registrations, Oversee venue…">
                </div>

                {{-- Is Lead toggle --}}
                {{-- <div class="form-group">
                    <label class="lead-toggle" for="addIsLead">
                        <input type="checkbox" name="is_lead" value="1" id="addIsLead">
                        <div class="toggle-track">
                            <div class="toggle-thumb"></div>
                        </div>
                        <div>
                            <span class="toggle-label">Mark as Lead</span>
                            <span class="toggle-sub">Sets this person as the primary lead</span>
                        </div>
                    </label>
                </div> --}}

                <button type="submit" class="btn-add-member" {{ $availableStaff->isEmpty() ? 'disabled' : '' }}>
                    <i class="fa fa-user-plus"></i> Add to Committee
                </button>

            </form>
        </div>

        {{-- Role reference card --}}
        <div class="cm-panel fu d4 mt-3">
            <div class="cm-panel-stripe" style="background:linear-gradient(90deg,#4338ca,#818cf8);"></div>
            <div class="cm-panel-header">
                <div class="cm-panel-title">
                    <i class="fa fa-circle-info" style="background:#e0e7ff;color:#4338ca;"></i>
                    Role Reference
                </div>
            </div>
            <div style="padding:10px 16px 14px;">
                @foreach($roleLabels as $key => $label)
                <div style="display:flex;align-items:center;gap:10px;padding:8px 6px;border-bottom:1px solid #f8faff;">
                    <span class="role-tag role-{{ $key }}" style="flex-shrink:0;">
                        <i class="fa {{ $roleIcons[$key] }}" style="font-size:9px;"></i>
                        {{ $label }}
                    </span>
                    <span style="font-size:12px;color:#64748b;">
                        @switch($key)
                            @case('committee_head')   Overall in charge of the committee @break
                            @case('coordinator')      Coordinates tasks & schedules @break
                            @case('secretary')        Handles documentation & minutes @break
                            @case('treasurer')        Manages budget & finances @break
                            @case('facilitator')      Facilitates sessions & activities @break
                            @case('committee_member') General committee member @break
                        @endswitch
                    </span>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>


{{-- ═══ EDIT MEMBER MODAL ═══ --}}
<div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="m-stripe" style="background:linear-gradient(90deg,#b45309,#f59e0b);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="m-icon" style="background:#fef9c3;color:#b45309;">
                        <i class="fa fa-pen"></i>
                    </span>
                    Edit Member
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editMemberForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <p style="font-size:13.5px;font-weight:700;color:#0f172a;margin-bottom:16px;" id="editMemberName"></p>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <select name="role" id="editRole" class="form-select">
                            @foreach($roles as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Responsibility</label>
                        <input type="text" name="responsibility" id="editResponsibility" class="form-control"
                               placeholder="Specific task or scope…">
                    </div>

                    <div class="form-group mb-0">
                        <label class="lead-toggle" for="editIsLead">
                            <input type="checkbox" name="is_lead" value="1" id="editIsLead">
                            <div class="toggle-track">
                                <div class="toggle-thumb"></div>
                            </div>
                            <div>
                                <span class="toggle-label">Mark as Lead</span>
                                <span class="toggle-sub">Replaces current lead if one exists</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-save">
                        <i class="fa fa-floppy-disk me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- ═══ REMOVE MEMBER MODAL ═══ --}}
<div class="modal fade" id="removeMemberModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="m-stripe" style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="m-icon" style="background:#fee2e2;color:#b91c1c;">
                        <i class="fa fa-user-minus"></i>
                    </span>
                    Remove Member
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="removeMemberForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="danger-zone">
                        <i class="fa fa-triangle-exclamation"></i>
                        <p>
                            Remove <strong id="removeMemberName">this member</strong> from the committee?
                            They can be re-added later.
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-remove">
                        <i class="fa fa-user-minus me-1"></i> Remove Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Import Committee CSV --}}
<div class="modal fade" id="importCSVModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="m-stripe"
            style="background:linear-gradient(90deg,#14532d,#16a34a);">
        </div>
            <div class="modal-header">
                <h5 class="modal-title">
                <span class="m-icon"
                    style="background:#dcfce7;color:#15803d;">
                <i class="fa fa-file-upload"></i>
                </span>
                Import Committee Members
                </h5>

                <button class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form method="POST"
                action="{{ route('head.committee.import.csv', $program->id) }}"
                enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <label class="form-label">Upload CSV File</label>

                    <input type="file"
                        name="file"
                        class="form-control"
                        accept=".csv"
                        required>

                    <p style="font-size:12px;margin-top:10px;color:#64748b;">
                        CSV format:
                        <br>
                        <strong>staff_id,role,responsibility</strong>
                    </p>

                </div>

                {{-- old no download template --}}
                {{-- <div class="modal-footer justify-content-between">

                    <button type="button"
                            class="btn-cancel"
                            data-bs-dismiss="modal">
                    Cancel
                    </button>

                    <button type="submit"
                            class="btn-save">

                    <i class="fa fa-upload me-1"></i>
                        Import Members
                    </button>
                </div> --}}

                <div class="modal-footer justify-content-between">

                    {{-- ✅ Download Template --}}
                        <a href="{{ asset('templates/committee_template.csv') }}"
                            class="btn-import-csv"
                            style="background:linear-gradient(135deg,#0f2d6e,#1a56db);"
                            download>

                                <i class="fa fa-download"></i>
                                Template

                        </a>

                    <div>

                        <button type="button"
                                class="btn-cancel"
                                data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit"
                                class="btn-save">

                            <i class="fa fa-upload me-1"></i>
                            Import Members

                        </button>

                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══ NOTIFY ALL COMMITTEE MODAL ═══ --}}
<div class="modal fade" id="notifyCommitteeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="m-stripe"
                style="background:linear-gradient(90deg,#7e22ce,#9333ea,#a855f7);">
            </div>

            <div class="modal-header">

                <h5 class="modal-title">

                    <span class="m-icon"
                        style="background:#f3e8ff;color:#7e22ce;">

                        <i class="fa fa-envelope-open-text"></i>

                    </span>

                    Hantar Notifikasi Jawatankuasa

                </h5>

                <button class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                {{-- Info banner --}}
                <div style="
                    background:#f3e8ff;
                    border:1.5px solid #d8b4fe;
                    border-radius:12px;
                    padding:13px 16px;
                    display:flex;
                    gap:10px;
                    margin-bottom:18px;
                ">

                    <i class="fa fa-circle-info"
                       style="color:#7e22ce;
                       flex-shrink:0;
                       margin-top:2px;">
                    </i>

                    <p style="
                        margin:0;
                        font-size:13px;
                        color:#4c1d95;
                        line-height:1.5;
                    ">

                        Notifikasi pelantikan jawatankuasa akan dihantar kepada
                        <strong>{{ $totalMembers }} ahli</strong>
                        di bawah secara serentak melalui emel.

                    </p>

                </div>

                {{-- Member list preview --}}
                <div style="
                    max-height:320px;
                    overflow-y:auto;
                    display:flex;
                    flex-direction:column;
                    gap:8px;
                ">

                    @foreach($program->committee->sortByDesc('pivot.is_lead') as $member)

                    @php
                        $role = $member->pivot->role;
                    @endphp

                    <div style="
                        background:#f8faff;
                        border:1.5px solid #e8effe;
                        border-radius:12px;
                        padding:11px 14px;
                        display:flex;
                        align-items:center;
                        gap:12px;
                    ">

                        <div class="member-avatar"
                            style="
                                width:36px;
                                height:36px;
                                font-size:12px;
                                border-radius:10px;
                                flex-shrink:0;
                            ">

                            {{ strtoupper(substr($member->name, 0, 2)) }}

                        </div>

                        <div style="flex:1;min-width:0;">

                            <div style="
                                font-size:13.5px;
                                font-weight:700;
                                color:#0f172a;
                            ">

                                {{ $member->name }}

                            </div>

                            <div style="
                                font-size:12px;
                                color:#94a3b8;
                            ">

                                {{ $member->email }}

                            </div>

                        </div>

                        <span class="role-tag role-{{ $role }}"
                              style="flex-shrink:0;">

                            <i class="fa {{ $roleIcons[$role] ?? 'fa-user' }}"
                               style="font-size:9px;">
                            </i>

                            {{ $roleLabels[$role] ?? ucfirst($role) }}

                        </span>

                        <i class="fa fa-envelope"
                           style="
                                color:#a78bfa;
                                font-size:13px;
                                flex-shrink:0;
                           "
                           title="Will receive email">
                        </i>

                    </div>

                    @endforeach

                </div>

            </div>

            <div class="modal-footer justify-content-between">

                <button type="button"
                        class="btn-cancel"
                        data-bs-dismiss="modal">

                    Batal

                </button>

                <form method="POST"
                      action="{{ route('head.committee.notify', $program->id) }}">

                    @csrf

                    <button type="submit"
                            class="btn-save"
                            style="
                                background:linear-gradient(135deg,#7e22ce,#9333ea);
                            ">

                        <i class="fa fa-paper-plane me-1"></i>

                        Hantar Notifikasi
                        ({{ $totalMembers }} Ahli)

                    </button>

                </form>

            </div>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
/* ── Custom toggle checkbox behaviour ── */
document.querySelectorAll('.lead-toggle').forEach(function (label) {
    var checkbox = label.querySelector('input[type="checkbox"]');
    var track    = label.querySelector('.toggle-track');
    var thumb    = label.querySelector('.toggle-thumb');

    function sync() {
        if (checkbox.checked) {
            track.style.background = '#f59e0b';
            thumb.style.transform  = 'translateX(18px)';
        } else {
            track.style.background = '#e2e8f0';
            thumb.style.transform  = 'translateX(0)';
        }
    }
    checkbox.addEventListener('change', sync);
    sync();
});

/* ── Edit Modal ── */
document.getElementById('editMemberModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    var programId = {{ $program->id }};
    var staffId   = b.dataset.id;

    document.getElementById('editMemberName').textContent = b.dataset.name;
    document.getElementById('editRole').value             = b.dataset.role;
    document.getElementById('editResponsibility').value   = b.dataset.responsibility;

    var isLeadChk   = document.getElementById('editIsLead');
    isLeadChk.checked = b.dataset.isLead === '1';
    isLeadChk.dispatchEvent(new Event('change')); // sync toggle UI

    document.getElementById('editMemberForm').action =
        '/head/programs/' + programId + '/committee/' + staffId;
});

/* ── Remove Modal ── */
document.getElementById('removeMemberModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    var programId = {{ $program->id }};
    var staffId   = b.dataset.id;

    document.getElementById('removeMemberName').textContent = b.dataset.name;
    document.getElementById('removeMemberForm').action =
        '/head/programs/' + programId + '/committee/' + staffId;
});

// 🔍 Committee Member Search
document.getElementById('memberSearch')
.addEventListener('keyup', function () {

    let search = this.value.toLowerCase();

    document.querySelectorAll('.member-card')
    .forEach(function (card) {

        let name = card
            .querySelector('.member-name')
            .textContent
            .toLowerCase();

        if (name.includes(search)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }

    });

});

$(document).ready(function() {
        $('#staff-select').select2({
            theme: 'bootstrap-5',
            placeholder: 'Choose a staff member...',
            width: '100%'
        });
    });
</script>
@endpush
