@extends('layouts.app')

@section('title','Staff Management')
@section('page-title','Staff Management')

@push('styles')
<style>

/* ── Page header ── */
.staff-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 24px;
}

.staff-page-header h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.staff-page-header h2 span {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 16px;
}

.breadcrumb { margin: 4px 0 0; }
.breadcrumb-item a { color: #1a56db; text-decoration: none; font-size: 13px; }
.breadcrumb-item.active { font-size: 13px; color: #64748b; }

/* ── Add button ── */
.btn-add-staff {
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    color: #fff;
    border: none;
    border-radius: 11px;
    padding: 10px 20px;
    font-size: 13.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all .22s ease;
    box-shadow: 0 4px 14px rgba(26,86,219,0.30);
    font-family: inherit;
}
.btn-add-staff:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,86,219,0.38);
}

/* ── Main card ── */
.staff-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(15,45,110,0.07);
    overflow: hidden;
}

.staff-card-stripe {
    height: 5px;
    background: linear-gradient(90deg, #0f2d6e, #1a56db, #3b82f6);
}

/* ── Toolbar ── */
.staff-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
}

.toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.staff-count-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 20px;
}

.staff-search-wrap {
    position: relative;
}
.staff-search-wrap i {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    pointer-events: none;
}
.staff-search {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 14px 9px 35px;
    font-size: 13.5px;
    font-family: inherit;
    background: #f8faff;
    color: #1e293b;
    width: 240px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.staff-search:focus {
    border-color: #1a56db;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10);
    background: #fff;
}

/* ── Table ── */
.staff-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13.5px;
}

.staff-table thead th {
    background: #f8faff;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    padding: 12px 16px;
    border-bottom: 2px solid #e8effe;
    white-space: nowrap;
}

.staff-table tbody tr {
    transition: background .15s;
}
.staff-table tbody tr:hover { background: #f8faff; }

.staff-table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

.staff-table tbody tr:last-child td {
    border-bottom: none;
}

/* ── Avatar ── */
.staff-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    flex-shrink: 0;
}

.staff-name { font-weight: 700; color: #0f172a; }
.staff-email { font-size: 12px; color: #94a3b8; margin-top: 2px; }

/* ── Staff ID badge ── */
.sid-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 7px;
    font-family: 'Courier New', monospace;
    letter-spacing: .4px;
}

/* ── Dept badge ── */
.dept-badge {
    background: #f1f5f9;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* ── Position badge ── */
.pos-badge {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.pos-hd   { background: #e0e7ff; color: #3730a3; }
.pos-staff { background: #f0fdf4; color: #15803d; }
.pos-ld { background: #fef3c7; color: #b45309; }
.pos-other { background: #f1f5f9; color: #475569; }

/* ── Access badge ── */
.access-yes { background: #dcfce7; color: #15803d; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.access-no  { background: #fee2e2; color: #b91c1c; font-size: 11.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

/* ── Action buttons ── */
.action-wrap {
    display: flex;
    align-items: center;
    gap: 5px;
}

.act-btn {
    width: 32px; height: 32px;
    border: none;
    border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px;
    cursor: pointer;
    transition: all .18s;
}

.act-btn.edit   { background: #fef9c3; color: #b45309; }
.act-btn.delete { background: #fee2e2; color: #b91c1c; }
.act-btn.access { background: #dcfce7; color: #15803d; }
.act-btn.revoke { background: #f1f5f9; color: #475569; }

.act-btn:hover { filter: brightness(.92); transform: scale(1.08); }

.act-divider {
    width: 1px; height: 20px;
    background: #e2e8f0;
    flex-shrink: 0;
}

/* ── Table footer ── */
.staff-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    padding: 14px 22px;
    border-top: 1px solid #f1f5f9;
    font-size: 13px;
    color: #64748b;
}

/* ── Modal redesign ── */
.modal-content {
    border: none !important;
    border-radius: 18px !important;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(15,45,110,0.18) !important;
}

.modal-stripe {
    height: 5px;
}

.modal-header {
    border-bottom: 1px solid #f1f5f9 !important;
    padding: 20px 24px 16px !important;
    background: #fff !important;
}

.modal-header .modal-title {
    font-size: 16px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-header .modal-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
}

.modal-header .btn-close {
    opacity: .4;
    transition: opacity .2s;
}
.modal-header .btn-close:hover { opacity: 1; }

.modal-body { padding: 20px 24px !important; }
.modal-footer {
    padding: 14px 24px 20px !important;
    border-top: 1px solid #f1f5f9 !important;
    background: #fff !important;
}

/* ── Form controls ── */
.form-label {
    font-size: 12.5px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: block;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.form-control, .form-select {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
    font-size: 13.5px !important;
    font-family: inherit !important;
    color: #1e293b !important;
    background: #f8faff !important;
    transition: border-color .2s, box-shadow .2s !important;
    outline: none !important;
    box-shadow: none !important;
}

.form-control:focus, .form-select:focus {
    border-color: #1a56db !important;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10) !important;
    background: #fff !important;
}

/* ── Modal buttons ── */
.btn-modal-primary {
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(26,86,219,0.25);
}
.btn-modal-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(26,86,219,0.32); }

.btn-modal-warning {
    background: linear-gradient(135deg, #b45309, #f59e0b);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(245,158,11,0.25);
}
.btn-modal-warning:hover { transform: translateY(-1px); }

.btn-modal-danger {
    background: linear-gradient(135deg, #991b1b, #ef4444);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(239,68,68,0.25);
}
.btn-modal-danger:hover { transform: translateY(-1px); }

.btn-modal-success {
    background: linear-gradient(135deg, #14532d, #16a34a);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(22,163,74,0.25);
}
.btn-modal-success:hover { transform: translateY(-1px); }

.btn-modal-cancel {
    background: #f1f5f9;
    color: #64748b;
    border: none;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: background .2s;
}
.btn-modal-cancel:hover { background: #e2e8f0; }

/* Danger zone box */
.danger-zone {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
}
.danger-zone i { color: #ef4444; font-size: 20px; flex-shrink: 0; margin-top: 2px; }
.danger-zone p { margin: 0; font-size: 13.5px; color: #374151; line-height: 1.5; }
.danger-zone strong { color: #b91c1c; }

/* DT overrides */
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_length { display: none; }
.dataTables_wrapper .dataTables_info { font-size: 13px; color: #64748b; }
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    font-size: 12.5px !important;
    font-weight: 600 !important;
    padding: 4px 11px !important;
    border: none !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg,#0f2d6e,#1a56db) !important;
    color: #fff !important;
    border: none !important;
}

</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="staff-page-header">
    <div>
        <h2>
            <span><i class="fa fa-users"></i></span>
            Staff Management
        </h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Staff</li>
            </ol>
        </nav>
    </div>

    <button class="btn-add-staff"
        data-bs-toggle="modal"
        data-bs-target="#importCSVModal">
    <i class="fa fa-file-upload"></i> Import CSV
    </button>

    <button class="btn-add-staff"
            data-bs-toggle="modal"
            data-bs-target="#staffModal">
        <i class="fa fa-plus"></i> Add Staff
    </button>

    

</div>

{{-- Main Card --}}
<div class="staff-card">
    <div class="staff-card-stripe"></div>

    {{-- Toolbar --}}
    <div class="staff-toolbar">
        <div class="toolbar-left">
            <span style="font-size:14px;font-weight:700;color:#0f172a;">All Staff</span>
            <span class="staff-count-badge">{{ count($staff) }} members</span>
        </div>
        <div class="staff-search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="staffSearch" class="staff-search" placeholder="Search staff...">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table id="staffTable" class="staff-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Staff</th>
                    <th>Staff ID</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>System Access</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staff as $index => $s)
                <tr>

                    {{-- Row no --}}
                    <td style="color:#94a3b8;font-weight:600;font-size:13px;">{{ $index + 1 }}</td>

                    {{-- Staff name + email --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="staff-avatar">
                                {{ strtoupper(substr($s->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="staff-name">{{ $s->name }}</div>
                                <div class="staff-email">{{ $s->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Staff ID --}}
                    <td><span class="sid-badge">{{ $s->staff_id }}</span></td>

                    {{-- Department --}}
                    <td>
                        <span class="dept-badge">
                            <i class="fa fa-building" style="font-size:11px;"></i>
                            {{ $s->department->name ?? '—' }}
                        </span>
                    </td>

                    {{-- Position --}}
                    <td>
                        @php
                            $posClass = match($s->position) {
                                'hd'    => 'pos-hd',
                                'staff' => 'pos-staff',
                                'ld'    => 'pos-ld',
                                default => 'pos-other',
                            };
                            $posIcon = match($s->position) {
                                'hd'    => 'fa-crown',
                                'staff' => 'fa-user',
                                'ld'    => 'fa-user-tie',
                                default => 'fa-circle',
                            };
                            $posLabel = match($s->position) {
                                'hd'    => 'Programme Secretariat',
                                'ld'    => 'Head of Department',
                                'staff' => 'Staff',
                                default => ucfirst($s->position),
                            };
                        @endphp
                        <span class="pos-badge {{ $posClass }}">
                            <i class="fa {{ $posIcon }}" style="font-size:10px;"></i>
                            {{ $posLabel }}
                        </span>
                    </td>

                    {{-- System access --}}
                    <td>
                        @if($s->user)
                            <span class="access-yes"><i class="fa fa-circle-check me-1"></i>Active</span>
                        @else
                            <span class="access-no"><i class="fa fa-circle-xmark me-1"></i>No Access</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-wrap">

                            {{-- Edit --}}
                            <button class="act-btn edit"
                                    title="Edit Staff"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editStaffModal"
                                    data-id="{{ $s->id }}"
                                    data-staffid="{{ $s->staff_id }}"
                                    data-name="{{ $s->name }}"
                                    data-email="{{ $s->email }}"
                                    data-department="{{ $s->department_id }}"
                                    data-role="{{ $s->position }}">
                                <i class="fa fa-pen"></i>
                            </button>

                            {{-- Delete --}}
                            <button class="act-btn delete"
                                    title="Delete Staff"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteStaffModal"
                                    data-id="{{ $s->id }}"
                                    data-name="{{ $s->name }}">
                                <i class="fa fa-trash"></i>
                            </button>

                            <div class="act-divider"></div>

                            {{-- Give Access --}}
                            <button class="act-btn access"
                                    title="Give System Access"
                                    data-bs-toggle="modal"
                                    data-bs-target="#giveAccessModal"
                                    data-id="{{ $s->id }}"
                                    data-name="{{ $s->name }}">
                                <i class="fa fa-key"></i>
                            </button>

                            {{-- Remove Access --}}
                            <button class="act-btn revoke"
                                    title="Remove System Access"
                                    data-bs-toggle="modal"
                                    data-bs-target="#removeAccessModal"
                                    data-id="{{ $s->id }}"
                                    data-name="{{ $s->name }}">
                                <i class="fa fa-user-slash"></i>
                            </button>

                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="staff-footer">
        <div id="dtInfo"></div>
        <div id="dtPaginate"></div>
    </div>
</div>


{{-- ═══════════════════════════════════
     MODALS
═══════════════════════════════════ --}}

{{-- Add Staff --}}
<div class="modal fade" id="staffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#0f2d6e,#1a56db);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#eff6ff;color:#1d4ed8;">
                        <i class="fa fa-user-plus"></i>
                    </span>
                    Add New Staff
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.staff.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="col-6">
                            <label class="form-label">Staff ID</label> --}}
                            {{-- <input type="text" name="staff_id" class="form-control" placeholder="e.g. FP00000" required> --}}
                            {{-- <input type="text" name="staff_id" class="form-control" 
                            placeholder="e.g. FP00000" 
                            pattern="FP\d{5}" 
                            title="Staff ID must be FP followed by 5 digits (e.g. FP04428)"
                            required>
                        </div> --}}

                        <div class="col-6">
                            <label class="form-label">Staff ID</label>
                            <input type="text" name="staff_id" id="staff_id" class="form-control" 
                                placeholder="e.g. FP00000" required>
                            <div id="staff_id_feedback" class="invalid-feedback">
                                Staff ID must start with "FP" followed by exactly 5 digits (e.g. FP04428)
                            </div>
                            <div id="staff_id_valid" class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Full name" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="email@uptm.edu.my" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Department</label>
                            
                            <select name="department_id" class="form-select">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Position</label>
                            <select name="position" class="form-select">
                                <option value="">Select Position</option>
                                <option value="ld">Head of Department</option>
                                <option value="hd">Programme Secretariat</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-primary">
                        <i class="fa fa-plus me-1"></i> Add Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Staff --}}
<div class="modal fade" id="editStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#b45309,#f59e0b);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fef9c3;color:#b45309;">
                        <i class="fa fa-pen"></i>
                    </span>
                    Edit Staff
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editStaffForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="col-6">
                            <label class="form-label">Staff ID</label>
                            <input type="text" name="staff_id" id="editStaffID" class="form-control">
                        </div> --}}

                        <div class="col-6">
                            <label class="form-label">Staff ID</label>
                            <input type="text" name="staff_id" id="editStaffID" class="form-control">
                            <div class="invalid-feedback">
                                Staff ID must start with "FP" followed by exactly 5 digits (e.g. FP04428)
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" id="editName" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" id="editEmail" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Department</label>
                            <select name="department_id" id="editDepartment" class="form-select">
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Position</label>
                            <select name="position" id="editRole" class="form-select">
                                <option value="hd">Programme Secretariat</option>
                                <option value="ld">Head of Department</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-warning">
                        <i class="fa fa-floppy-disk me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete Staff --}}
<div class="modal fade" id="deleteStaffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fee2e2;color:#b91c1c;">
                        <i class="fa fa-trash"></i>
                    </span>
                    Delete Staff
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteStaffForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="danger-zone">
                        <i class="fa fa-triangle-exclamation"></i>
                        <p>
                            You are about to delete <strong id="deleteStaffName">this staff member</strong>.
                            This action <strong>cannot be undone</strong> and will also remove their system access if any.
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa fa-trash me-1"></i> Delete Staff
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Give Access --}}
<div class="modal fade" id="giveAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#14532d,#16a34a);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#dcfce7;color:#15803d;">
                        <i class="fa fa-key"></i>
                    </span>
                    Give System Access
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="giveAccessForm">
                @csrf
                <div class="modal-body">
                    <p style="font-size:13.5px;color:#475569;margin-bottom:16px;">
                        Granting system access to <strong id="giveAccessName" style="color:#0f172a;"></strong>.
                        They will receive login credentials.
                    </p>
                    {{-- username textbox --}}
                    <div class="mb-3">
                        <label class="form-label">Assign Username</label>

                        <input 
                            type="text" 
                            name="username"
                            class="form-control"
                            placeholder="Enter username"
                            required
                        >  

                        <small class="text-muted">
                            Username will be used for login.
                        </small>
                    </div>

                    {{-- Role Selection --}}
                    <div>
                        <label class="form-label">Assign Role</label>
                        <select name="role" class="form-select">
                            <option value="ld">Head of Department</option>
                            <option value="vc">Vice Chancellor</option>
                            <option value="hd">Programme Secretariat</option>
                            <option value="az">Be An Amazing You</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-success">
                        <i class="fa fa-key me-1"></i> Give Access
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Remove Access --}}
<div class="modal fade" id="removeAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#374151,#6b7280);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#f1f5f9;color:#374151;">
                        <i class="fa fa-user-slash"></i>
                    </span>
                    Remove System Access
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="removeAccessForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="danger-zone">
                        <i class="fa fa-triangle-exclamation"></i>
                        <p>
                            Removing access for <strong id="removeAccessName">this staff member</strong>.
                            They will no longer be able to log in to the system.
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa fa-user-slash me-1"></i> Remove Access
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Import CSV --}}
<div class="modal fade" id="importCSVModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        <div class="modal-stripe"
            style="background:linear-gradient(90deg,#14532d,#16a34a);">
        </div>

        <div class="modal-header">
            <h5 class="modal-title">
            <span class="modal-icon"
                style="background:#dcfce7;color:#15803d;">
            <i class="fa fa-file-upload"></i>
            </span>
            Import Staff CSV
            </h5>

            <button class="btn-close"
                    data-bs-dismiss="modal">
            </button>
        </div>

            <form method="POST"
                action="{{ route('admin.staff.import.csv') }}"
                enctype="multipart/form-data">

            @csrf

                <div class="modal-body">

                    <label class="form-label">
                    Upload CSV File
                    </label>

                    <input type="file"
                        name="file"
                        class="form-control"
                        accept=".csv"
                        required>

                    <p style="font-size:12px;margin-top:10px;color:#64748b;">
                        CSV columns must be:
                        <br>
                        <strong>
                        staff_id,name,email,phone,position,department_id
                        </strong>
                    </p>

                </div>

                <div class="modal-footer justify-content-between">

                    <button type="button"
                            class="btn-modal-cancel"
                            data-bs-dismiss="modal">
                    Cancel
                    </button>

                    <button type="submit"
                            class="btn-modal-success">
                    <i class="fa fa-upload me-1"></i>
                    Import Staff
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endsection


@push('scripts')
<script>
$(document).ready(function () {

    var table = $('#staffTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'tip',
        language: {
            info:      'Showing _START_–_END_ of _TOTAL_ staff',
            infoEmpty: 'No staff found',
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next:     '<i class="fa fa-chevron-right"></i>',
            }
        },
        initComplete: function () {
            $('#staffTable_info').appendTo('#dtInfo');
            $('#staffTable_paginate').appendTo('#dtPaginate');
        }
    });

    $('#staffSearch').on('input', function () {
        table.search(this.value).draw();
    });

});

/* ── Edit Staff ── */
document.getElementById('editStaffModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    document.getElementById('editStaffID').value    = b.dataset.staffid;
    document.getElementById('editName').value       = b.dataset.name;
    document.getElementById('editEmail').value      = b.dataset.email;
    document.getElementById('editDepartment').value = b.dataset.department;
    document.getElementById('editRole').value       = b.dataset.role;
    document.getElementById('editStaffForm').action = '/admin/staff/' + b.dataset.id;
});

/* ── Delete Staff ── */
document.getElementById('deleteStaffModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    document.getElementById('deleteStaffName').textContent = b.dataset.name ?? 'this staff member';
    document.getElementById('deleteStaffForm').action = '/admin/staff/' + b.dataset.id;
});

/* ── Give Access ── */
document.getElementById('giveAccessModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    document.getElementById('giveAccessName').textContent = b.dataset.name ?? 'this staff member';
    document.getElementById('giveAccessForm').action = '/admin/staff/' + b.dataset.id + '/give-access';
});

/* ── Remove Access ── */
document.getElementById('removeAccessModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    document.getElementById('removeAccessName').textContent = b.dataset.name ?? 'this staff member';
    document.getElementById('removeAccessForm').action = '/admin/staff/' + b.dataset.id + '/remove-access';
});
</script>

<script>
    const regex = /^FP\d{5}$/;

    // Apply to both add and edit staff ID inputs
    ['staff_id', 'editStaffID'].forEach(function(id) {
        const input = document.getElementById(id);
        if (!input) return;

        input.addEventListener('input', function () {
            const value = this.value.toUpperCase();
            this.value = value;

            if (value === '') {
                this.classList.remove('is-valid', 'is-invalid');
            } else if (regex.test(value)) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    });
</script>
@endpush
