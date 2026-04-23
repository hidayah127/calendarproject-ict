@extends('layouts.app')

@section('page-title', 'Merit Claims Review')

@push('styles')
<style>

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu { animation:fadeUp .42s ease both; }
.d1 { animation-delay:.06s; }
.d2 { animation-delay:.12s; }
.d3 { animation-delay:.18s; }
.d4 { animation-delay:.24s; }

/* ── Page header ── */
.page-hdr {
    display:flex; align-items:flex-start;
    justify-content:space-between; flex-wrap:wrap;
    gap:14px; margin-bottom:24px;
}
.breadcrumb-item a { color:#1a56db; text-decoration:none; font-size:13px; }
.breadcrumb-item.active { font-size:13px; color:#64748b; }

/* ── Stat strip ── */
.stat-strip {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:14px; margin-bottom:22px;
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
.s-chip-val   { font-size:1.7rem; font-weight:900; color:#0f172a; line-height:1; }
.s-chip-label { font-size:12px; color:#64748b; font-weight:600; margin-top:2px; }

/* ── Main card ── */
.claims-card {
    background:#fff; border:1.5px solid #e2e8f0; border-radius:18px;
    overflow:hidden; box-shadow:0 4px 24px rgba(15,45,110,.07);
}
.claims-stripe { height:5px; background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6); }

/* ── Toolbar ── */
.toolbar {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; padding:16px 22px; border-bottom:1px solid #f1f5f9;
}
.toolbar-left { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.toolbar-title { font-size:14px; font-weight:800; color:#0f172a; }

.f-pill {
    background:#f8faff; border:1.5px solid #e2e8f0; border-radius:20px;
    padding:5px 13px; font-size:12px; font-weight:700; color:#475569;
    cursor:pointer; transition:all .18s; font-family:inherit;
}
.f-pill:hover,.f-pill.on { background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8; }
.f-pill.pending-pill.on  { background:#fef9c3; border-color:#fde68a; color:#b45309; }
.f-pill.approved-pill.on { background:#dcfce7; border-color:#bbf7d0; color:#15803d; }
.f-pill.rejected-pill.on { background:#fee2e2; border-color:#fecaca; color:#b91c1c; }

.prog-sel {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:8px 30px 8px 12px; font-size:13px; font-family:inherit;
    background:#f8faff; color:#475569; outline:none; cursor:pointer; appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
}
.prog-sel:focus { border-color:#1a56db; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94a3b8; font-size:13px; pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0; border-radius:10px;
    padding:9px 14px 9px 36px; font-size:13.5px; font-family:inherit;
    background:#f8faff; color:#1e293b; width:210px; outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,.10); background:#fff; }

/* ── Claim rows ── */
.claim-row {
    padding:16px 22px; border-bottom:1px solid #f1f5f9;
    transition:background .15s;
}
.claim-row:last-child { border-bottom:none; }
.claim-row:hover { background:#f8faff; }

.claim-top {
    display:flex; align-items:flex-start; gap:14px; flex-wrap:wrap;
}

.staff-av {
    width:42px; height:42px; border-radius:12px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:13px; font-weight:800; flex-shrink:0;
}

.claim-staff-name { font-size:14px; font-weight:800; color:#0f172a; }
.claim-staff-meta { font-size:12px; color:#94a3b8; margin-top:2px; }

.claim-prog-name { font-size:13px; font-weight:700; color:#334155; margin-top:4px; }
.claim-prog-meta { font-size:12px; color:#94a3b8; }

.role-tag {
    font-size:11.5px; font-weight:700; padding:4px 11px; border-radius:20px;
    display:inline-flex; align-items:center; gap:5px; flex-shrink:0;
}
.role-committee_head   { background:#fef9c3; color:#b45309; }
.role-coordinator      { background:#e0e7ff; color:#3730a3; }
.role-secretary        { background:#dbeafe; color:#1d4ed8; }
.role-treasurer        { background:#dcfce7; color:#15803d; }
.role-facilitator      { background:#fce7f3; color:#9d174d; }
.role-committee_member { background:#f1f5f9; color:#475569; }
.role-attendee         { background:#eff6ff; color:#1d4ed8; }

.merit-pts-badge {
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff; font-size:13px; font-weight:800;
    padding:5px 12px; border-radius:20px;
    display:inline-flex; align-items:center; gap:5px;
    flex-shrink:0;
}

.status-badge { font-size:11.5px; font-weight:700; padding:4px 11px; border-radius:20px; display:inline-flex; align-items:center; gap:5px; flex-shrink:0; }
.s-pending  { background:#fef9c3; color:#b45309; }
.s-approved { background:#dcfce7; color:#15803d; }
.s-rejected { background:#fee2e2; color:#b91c1c; }

/* ── Proof section ── */
.proof-section {
    display:flex; align-items:center; gap:10px;
    margin-top:10px; flex-wrap:wrap;
} 
.proof-link {
    display:inline-flex; align-items:center; gap:6px;
    background:#eff6ff; color:#1d4ed8; border-radius:8px;
    padding:5px 12px; font-size:12.5px; font-weight:700;
    text-decoration:none; transition:background .2s;
}
.proof-link:hover { background:#dbeafe; color:#1d4ed8; text-decoration:none; }
.proof-missing {
    font-size:12.5px; color:#94a3b8;
    display:inline-flex; align-items:center; gap:5px;
}

/* ── Action buttons ── */
.action-row { display:flex; align-items:center; gap:8px; margin-top:12px; flex-wrap:wrap; }

.btn-approve {
    background:linear-gradient(135deg,#15803d,#16a34a);
    color:#fff; border:none; border-radius:9px;
    padding:8px 18px; font-size:13px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 3px 10px rgba(21,128,61,.25);
    display:inline-flex; align-items:center; gap:7px;
    transition:all .2s;
}
.btn-approve:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(21,128,61,.32); }

.btn-reject {
    background:#fee2e2; color:#b91c1c; border:1.5px solid #fecaca;
    border-radius:9px; padding:8px 18px; font-size:13px; font-weight:700;
    cursor:pointer; font-family:inherit;
    display:inline-flex; align-items:center; gap:7px; transition:all .2s;
}
.btn-reject:hover { background:#fecaca; }

.btn-undo {
    background:#f1f5f9; color:#64748b; border:none;
    border-radius:9px; padding:8px 16px; font-size:13px; font-weight:600;
    cursor:pointer; font-family:inherit;
    display:inline-flex; align-items:center; gap:7px; transition:background .2s;
}
.btn-undo:hover { background:#e2e8f0; }

/* ── Reject modal ── */
.modal-content { border:none!important; border-radius:18px!important; overflow:hidden; box-shadow:0 24px 60px rgba(15,45,110,.18)!important; }
.m-stripe { height:5px; }
.modal-header { border-bottom:1px solid #f1f5f9!important; padding:20px 24px 16px!important; background:#fff!important; }
.modal-title  { font-size:16px!important; font-weight:800!important; color:#0f172a!important; display:flex; align-items:center; gap:10px; }
.m-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:15px; }
.modal-body   { padding:20px 24px!important; }
.modal-footer { padding:14px 24px 20px!important; border-top:1px solid #f1f5f9!important; background:#fff!important; }

.form-label-sm { font-size:11.5px; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.5px; display:block; margin-bottom:6px; }
.form-ctrl {
    border:1.5px solid #e2e8f0!important; border-radius:10px!important;
    padding:10px 14px!important; font-size:13.5px!important; font-family:inherit!important;
    background:#f8faff!important; color:#1e293b!important; box-shadow:none!important;
    transition:border-color .2s!important; width:100%;
}
.form-ctrl:focus { border-color:#ef4444!important; background:#fff!important; outline:none!important; }

.btn-modal-cancel {
    background:#f1f5f9; color:#64748b; border:none; border-radius:10px;
    padding:10px 18px; font-size:13.5px; font-weight:600;
    cursor:pointer; font-family:inherit; transition:background .2s;
}
.btn-modal-cancel:hover { background:#e2e8f0; }

.btn-modal-reject {
    background:linear-gradient(135deg,#991b1b,#ef4444); color:#fff; border:none;
    border-radius:10px; padding:10px 22px; font-size:13.5px; font-weight:700;
    cursor:pointer; font-family:inherit;
    box-shadow:0 4px 12px rgba(239,68,68,.25); transition:all .2s;
}
.btn-modal-reject:hover { transform:translateY(-1px); }

/* ── Empty ── */
.empty-state { text-align:center; padding:52px 20px; color:#94a3b8; }
.empty-state i { font-size:44px; display:block; margin-bottom:14px; color:#cbd5e1; }

/* ── Footer ── */
.claims-footer {
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:8px;
    padding:14px 22px; border-top:1px solid #f1f5f9;
    font-size:13px; color:#64748b;
}

</style>
@endpush

@section('content')

@php
    $totalClaims   = $pendingCount + $approvedCount + $rejectedCount;
    $totalMerits   = $claims->where('status','approved')->sum('merit_points');

    $roleLabels = App\Models\MeritClaim::$claimLabels;
    $roleIcons  = App\Models\MeritClaim::$claimIcons;
    $meritPts   = App\Models\MeritClaim::$meritPoints;
@endphp

{{-- Page header --}}
<div class="page-hdr fu">
    <div>
        <h2 style="font-size:1.3rem;font-weight:800;color:#0f172a;margin:0 0 6px;">
           Merit Claims Review
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Merit Claims</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    <div class="s-chip fu d1">
        <div class="s-chip-icon" style="background:#fef9c3;"><i class="fa fa-clock" style="color:#b45309;"></i></div>
        <div>
            <div class="s-chip-val">{{ $pendingCount }}</div>
            <div class="s-chip-label">Pending Review</div>
        </div>
    </div>
    <div class="s-chip fu d2">
        <div class="s-chip-icon" style="background:#f0fdf4;"><i class="fa fa-circle-check" style="color:#15803d;"></i></div>
        <div>
            <div class="s-chip-val">{{ $approvedCount }}</div>
            <div class="s-chip-label">Approved</div>
        </div>
    </div>
    <div class="s-chip fu d3">
        <div class="s-chip-icon" style="background:#fee2e2;"><i class="fa fa-circle-xmark" style="color:#b91c1c;"></i></div>
        <div>
            <div class="s-chip-val">{{ $rejectedCount }}</div>
            <div class="s-chip-label">Rejected</div>
        </div>
    </div>
    <div class="s-chip fu d4">
        <div class="s-chip-icon" style="background:#fefce8;"><i class="fa fa-star" style="color:#f59e0b;"></i></div>
        <div>
            <div class="s-chip-val">{{ $totalMerits }}</div>
            <div class="s-chip-label">Total Merits Awarded</div>
        </div>
    </div>
</div>

{{-- Main card --}}
<div class="claims-card fu d2">
    <div class="claims-stripe"></div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="toolbar-left">
            <span class="toolbar-title">All Claims</span>

            <button class="f-pill on"           data-f="all">All ({{ $totalClaims }})</button>
            <button class="f-pill pending-pill"  data-f="pending">
                <i class="fa fa-clock" style="font-size:10px;"></i> Pending ({{ $pendingCount }})
            </button>
            <button class="f-pill approved-pill" data-f="approved">
                <i class="fa fa-check" style="font-size:10px;"></i> Approved ({{ $approvedCount }})
            </button>
            <button class="f-pill rejected-pill" data-f="rejected">
                <i class="fa fa-xmark" style="font-size:10px;"></i> Rejected ({{ $rejectedCount }})
            </button>
        </div>

        

        {{-- <div class="d-flex gap-2 flex-wrap">
            <select id="progFilter" class="prog-sel">
                <option value="">All Programs</option>
                @foreach($programs as $prog)
                <option value="{{ $prog->id }}">{{ Str::limit($prog->title, 32) }}</option>
                @endforeach
            </select>
            <div class="search-wrap">
                <i class="fa fa-magnifying-glass"></i>
                <input type="text" id="claimSearch" class="search-inp" placeholder="Search staff…">
            </div>
        </div> --}}

        <div style="display:flex;flex-direction:column;gap:6px;">

    <div class="d-flex gap-2 flex-wrap">

        {{-- Program Filter --}}
        <select id="progFilter" class="prog-sel">
            <option value="">All Programs</option>

            @foreach($programs as $prog)
                <option value="{{ $prog->id }}">
                    {{ Str::limit($prog->title, 32) }}
                </option>
            @endforeach

        </select>

        {{-- Search --}}
        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>

            <input type="text"
                   id="claimSearch"
                   class="search-inp"
                   placeholder="Search staff…">

        </div>

    </div>

        {{-- ✅ Select All Below Dropdown --}}
        <div style="display:flex;align-items:center;gap:10px;">

                <label style="font-size:12px;font-weight:700;color:#475569;display:flex;align-items:center;gap:6px;">

                    <input type="checkbox"
                        id="selectAllClaims">

                    Select All

                </label>

                 {{-- Selected Count --}}
                <span id="selectedCount"
                    style="font-size:12px;
                            font-weight:700;
                            color:#1a56db;">

                    0 selected

                </span>

                {{-- Bulk Buttons --}}
                <button type="button"
                        class="btn-approve"
                        id="approveSelectedBtn">

                    <i class="fa fa-circle-check"></i>
                    Approve Selected

                </button>

                <button type="button"
                        class="btn-reject"
                        id="rejectSelectedBtn">

                    <i class="fa fa-circle-xmark"></i>
                    Reject Selected

                </button>

            </div>

        </div>
    </div>

    {{-- Claims list --}}
    @if($claims->isEmpty())
    <div class="empty-state">
        <i class="fa fa-inbox"></i>
        <h6 style="color:#475569;font-weight:700;margin-bottom:6px;">No claims yet</h6>
        <p style="font-size:13.5px;max-width:280px;margin:0 auto;">
            Claims will appear here once staff submit them through the portal.
        </p>
    </div>
    @else

    <div id="claimsList">
        @foreach($claims as $claim)
        <div class="claim-row"
             data-status="{{ $claim->status }}"
             data-prog="{{ $claim->program_id }}"
             data-name="{{ strtolower($claim->staff->name ?? '') }}">

            <div class="claim-top">

                {{-- Checkbox for selection all --}}
                <div class="claim-check">
                    @if($claim->status === 'pending')
                        <input type="checkbox"
                            class="claim-checkbox"
                            value="{{ $claim->id }}">
                    @endif
                </div>

                {{-- Staff avatar --}}
                <div class="staff-av">
                    {{ strtoupper(substr($claim->staff->name ?? 'UN', 0, 2)) }}
                </div>

                {{-- Staff info --}}
                <div style="flex:1;min-width:0;">
                    <div class="claim-staff-name">{{ $claim->staff->name ?? '—' }}</div>
                    <div class="claim-staff-meta">
                        <i class="fa fa-id-badge me-1"></i>{{ $claim->staff->staff_id ?? '—' }}
                        &nbsp;·&nbsp;
                        <i class="fa fa-building me-1"></i>{{ $claim->staff->department->name ?? '—' }}
                    </div>
                    <div class="claim-prog-name mt-1">
                        <i class="fa fa-layer-group me-1" style="color:#94a3b8;font-size:11px;"></i>
                        {{ $claim->program->title ?? '—' }}
                    </div>
                    <div class="claim-prog-meta">
                        Submitted {{ $claim->created_at->diffForHumans() }}
                        @if($claim->reviewed_at)
                            · Reviewed {{ $claim->reviewed_at->diffForHumans() }}
                        @endif
                    </div>
                </div>

                {{-- Role + merit + status --}}
                <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                    <span class="role-tag role-{{ $claim->claim_type }}">
                        <i class="fa {{ $roleIcons[$claim->claim_type] ?? 'fa-user' }}" style="font-size:10px;"></i>
                        {{ $roleLabels[$claim->claim_type] ?? ucfirst($claim->claim_type) }}
                    </span>
                    <span class="merit-pts-badge">
                        <i class="fa fa-star" style="font-size:10px;"></i>
                        {{ $meritPts[$claim->claim_type] ?? $claim->merit_points }} pts
                    </span>
                    <span class="status-badge s-{{ $claim->status }}">
                        @if($claim->status === 'pending')
                            <i class="fa fa-clock" style="font-size:9px;"></i> Pending
                        @elseif($claim->status === 'approved')
                            <i class="fa fa-circle-check" style="font-size:9px;"></i> Approved
                        @else
                            <i class="fa fa-circle-xmark" style="font-size:9px;"></i> Rejected
                        @endif
                    </span>
                </div>

            </div>

            {{-- Proof + rejection reason --}}
            <div class="proof-section">
                @if($claim->proof_path)
                    <a href="{{ Storage::url($claim->proof_path) }}" target="_blank" class="proof-link">
                        <i class="fa fa-file-circle-check"></i>
                        View Proof — {{ $claim->proof_original_name ?? 'Uploaded file' }}
                    </a>
                @else
                    <span class="proof-missing">
                        <i class="fa fa-file-circle-xmark"></i> No proof uploaded yet
                    </span>
                @endif

                @if($claim->status === 'rejected' && $claim->rejection_reason)
                <span style="font-size:12px;color:#b91c1c;font-style:italic;">
                    <i class="fa fa-circle-exclamation me-1"></i>{{ $claim->rejection_reason }}
                </span>
                @endif
            </div>

            {{-- Action buttons --}}
            <div class="action-row">

                @if($claim->status === 'pending')

                    {{-- Approve --}}
                    <form method="POST" action="{{ route('head.merit-claims.approve', $claim->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-approve">
                            <i class="fa fa-circle-check"></i> Approve
                        </button>
                    </form>

                    {{-- Reject --}}
                    <button class="btn-reject"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectModal"
                            data-id="{{ $claim->id }}"
                            data-name="{{ $claim->staff->name ?? '' }}">
                        <i class="fa fa-circle-xmark"></i> Reject
                    </button>

                @elseif($claim->status === 'approved')

                    {{-- Undo approve → back to pending --}}
                    <form method="POST" action="{{ route('head.merit-claims.reject', $claim->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="rejection_reason" value="Approval reversed by reviewer.">
                        <button type="submit" class="btn-undo"
                                onclick="return confirm('Reverse this approval?')">
                            <i class="fa fa-rotate-left"></i> Reverse Approval
                        </button>
                    </form>

                @elseif($claim->status === 'rejected')

                    {{-- Re-approve --}}
                    <form method="POST" action="{{ route('head.merit-claims.approve', $claim->id) }}" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn-approve">
                            <i class="fa fa-circle-check"></i> Approve Instead
                        </button>
                    </form>

                @endif

            </div>

        </div>
        @endforeach
    </div>

    @endif

    {{-- Footer --}}
    <div class="claims-footer">
        <div id="claimsInfo">Showing {{ $claims->count() }} claim(s)</div>
    </div>
</div>


{{-- ── REJECT MODAL ── --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="m-stripe" style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="m-icon" style="background:#fee2e2;color:#b91c1c;">
                        <i class="fa fa-circle-xmark"></i>
                    </span>
                    Reject Claim
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="rejectForm">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p style="font-size:13.5px;color:#334155;margin-bottom:16px;">
                        Rejecting claim for <strong id="rejectStaffName"></strong>.
                        Please provide a reason so the staff member knows what to resubmit.
                    </p>
                    <label class="form-label-sm">Reason for Rejection</label>
                    <textarea name="rejection_reason"
                              class="form-ctrl"
                              rows="3"
                              placeholder="e.g. Proof unclear, wrong document, not eligible…"
                              required></textarea>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-reject">
                        <i class="fa fa-circle-xmark me-1"></i> Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- BULK REJECT MODAL --}}
<div class="modal fade" id="bulkRejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="m-stripe"
                 style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>

            <div class="modal-header">
                <h5 class="modal-title">

                    <span class="m-icon"
                          style="background:#fee2e2;color:#b91c1c;">

                        <i class="fa fa-circle-xmark"></i>

                    </span>

                    Reject Selected Claims

                </h5>

                <button class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            <form method="POST"
                  id="bulkRejectForm">

                @csrf
                @method('PATCH')

                <div class="modal-body">

                    <p style="font-size:13.5px;color:#334155;">

                        You are rejecting
                        <strong id="bulkRejectCount">0</strong>
                        selected claim(s).

                    </p>

                    <label class="form-label-sm">
                        Reason for Rejection (Optional)
                    </label>

                    <textarea name="rejection_reason"
                              class="form-ctrl"
                              rows="3"
                              placeholder="Optional reason for rejection..."></textarea>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn-modal-cancel"
                            data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button type="submit"
                            class="btn-modal-reject">

                        <i class="fa fa-circle-xmark me-1"></i>

                        Reject Selected

                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>

/* ── Reject modal ── */
document.getElementById('rejectModal').addEventListener('show.bs.modal', function(e) {
    var b = e.relatedTarget;
    document.getElementById('rejectStaffName').textContent = b.dataset.name;
    document.getElementById('rejectForm').action =
        '/head/merit-claims/' + b.dataset.id + '/reject';
});

/* ── Filter pills ── */
var curFilter = 'all';
var curProg   = '';
var curSearch = '';

function applyFilters() {
    var rows    = document.querySelectorAll('.claim-row');
    var visible = 0;

    rows.forEach(function(row) {
        var status = row.dataset.status;
        var prog   = row.dataset.prog;
        var name   = row.dataset.name;

        var okFilter = curFilter === 'all' || status === curFilter;
        var okProg   = curProg   === ''    || prog   === curProg;
        var okSearch = curSearch === ''    || name.includes(curSearch);

        var show = okFilter && okProg && okSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    document.getElementById('claimsInfo').textContent = 'Showing ' + visible + ' claim(s)';
}

document.querySelectorAll('.f-pill').forEach(function(pill) {
    pill.addEventListener('click', function() {
        document.querySelectorAll('.f-pill').forEach(function(p) { p.classList.remove('on'); });
        this.classList.add('on');
        curFilter = this.dataset.f;
        applyFilters();
    });
});

document.getElementById('progFilter').addEventListener('change', function() {
    curProg = this.value;
    applyFilters();
});

document.getElementById('claimSearch').addEventListener('input', function() {
    curSearch = this.value.toLowerCase();
    applyFilters();
});

/* Update selected count */
function updateSelectedCount() {

    let count =
        document.querySelectorAll(
            '.claim-checkbox:checked'
        ).length;

    document.getElementById('selectedCount')
        .textContent = count + " selected";

}


/* Select All */
document.getElementById('selectAllClaims')
.addEventListener('change', function () {

    let checked = this.checked;

    document.querySelectorAll('.claim-row')
    .forEach(function(row) {

        if (row.style.display !== 'none') {

            let cb =
                row.querySelector('.claim-checkbox');

            if (cb) {

                cb.checked = checked;

            }

        }

    });

    updateSelectedCount();

});


/* Individual checkbox change */
document.querySelectorAll('.claim-checkbox')
.forEach(function(cb) {

    cb.addEventListener('change', function () {

        updateSelectedCount();

    });

});

/* Approve Selected */
document.getElementById('approveSelectedBtn')
.addEventListener('click', function () {

    let ids = [];

    document.querySelectorAll('.claim-checkbox:checked')
    .forEach(function(cb) {

        ids.push(cb.value);

    });

    if (ids.length === 0) {
        alert("Select at least one claim.");
        return;
    }

    submitBulkForm(
        "{{ route('head.merit-claims.bulk-approve') }}",
        ids
    );

});


/* Reject Selected */
// document.getElementById('rejectSelectedBtn')
// .addEventListener('click', function () {

//     let ids = [];

//     document.querySelectorAll('.claim-checkbox:checked')
//     .forEach(function(cb) {

//         ids.push(cb.value);

//     });

//     if (ids.length === 0) {
//         alert("Select at least one claim.");
//         return;
//     }

    

//     submitBulkForm(
//         "{{ route('head.merit-claims.bulk-reject') }}",
//         ids
//     );

// });

/* Reject Selected */
document.getElementById('rejectSelectedBtn')
.addEventListener('click', function () {

    let ids = [];

    document.querySelectorAll('.claim-checkbox:checked')
    .forEach(function(cb) {

        ids.push(cb.value);

    });

    if (ids.length === 0) {

        alert("Select at least one claim.");

        return;

    }

    /* Show modal */
    document.getElementById('bulkRejectCount')
        .textContent = ids.length;

    /* Store IDs temporarily */
    window.bulkRejectIds = ids;

    new bootstrap.Modal(
        document.getElementById('bulkRejectModal')
    ).show();

});

document.getElementById('bulkRejectForm')
.addEventListener('submit', function (e) {

    e.preventDefault();

    let form = this;

    let url =
        "{{ route('head.merit-claims.bulk-reject') }}";

    let ids = window.bulkRejectIds;

    let hiddenForm =
        document.createElement('form');

    hiddenForm.method = 'POST';
    hiddenForm.action = url;

    hiddenForm.innerHTML =
        '@csrf' +
        '@method("PATCH")';

    /* Add IDs */
    ids.forEach(function(id) {

        let input =
            document.createElement('input');

        input.type = 'hidden';
        input.name = 'claim_ids[]';
        input.value = id;

        hiddenForm.appendChild(input);

    });

    /* Add reason */
    let reason =
        form.querySelector(
            '[name="rejection_reason"]'
        ).value;

    let reasonInput =
        document.createElement('input');

    reasonInput.type = 'hidden';
    reasonInput.name = 'rejection_reason';
    reasonInput.value = reason;

    hiddenForm.appendChild(reasonInput);

    document.body.appendChild(hiddenForm);

    hiddenForm.submit();

});


function submitBulkForm(url, ids) {

    let form = document.createElement('form');

    form.method = 'POST';
    form.action = url;

    form.innerHTML =
        '@csrf' +
        '@method("PATCH")';

    ids.forEach(function(id) {

        let input = document.createElement('input');

        input.type = 'hidden';
        input.name = 'claim_ids[]';
        input.value = id;

        form.appendChild(input);

    });

    document.body.appendChild(form);

    form.submit();

}

</script>
@endpush
