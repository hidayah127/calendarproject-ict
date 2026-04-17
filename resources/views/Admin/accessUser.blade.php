@extends('layouts.app')

@section('title','System Users')
@section('page-title','System Users')

@push('styles')
<style>

/* ── Page header ── */
.users-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 24px;
}

.users-page-header h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.users-page-header h2 .hdr-icon {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    display: inline-flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 15px;
}

.breadcrumb { margin: 4px 0 0; }
.breadcrumb-item a { color: #1a56db; text-decoration: none; font-size: 13px; }
.breadcrumb-item.active { font-size: 13px; color: #64748b; }

/* ── Stat strip ── */
.stat-strip {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.stat-chip {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 10px rgba(15,45,110,0.05);
    transition: transform .2s, box-shadow .2s;
}
.stat-chip:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(15,45,110,0.10); }

.stat-chip-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.stat-chip-val {
    font-size: 1.6rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

.stat-chip-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    margin-top: 2px;
}

/* ── Main card ── */
.users-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(15,45,110,0.07);
    overflow: hidden;
}

.users-card-stripe {
    height: 5px;
    background: linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6);
}

/* ── Toolbar ── */
.users-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
}

.toolbar-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}

.count-pill {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}

.search-wrap { position: relative; }
.search-wrap i {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8; font-size: 13px;
    pointer-events: none;
}
.search-input {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 9px 14px 9px 35px;
    font-size: 13.5px;
    font-family: inherit;
    background: #f8faff;
    color: #1e293b;
    width: 230px;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.search-input:focus {
    border-color: #1a56db;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10);
    background: #fff;
}

/* ── Table ── */
.users-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13.5px;
}

.users-table thead th {
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

.users-table tbody tr { transition: background .15s; }
.users-table tbody tr:hover { background: #f8faff; }

.users-table tbody td {
    padding: 13px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

.users-table tbody tr:last-child td { border-bottom: none; }

/* ── User cell ── */
.user-avatar {
    width: 38px; height: 38px;
    border-radius: 11px;
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    flex-shrink: 0;
}

.user-name  { font-weight: 700; color: #0f172a; font-size: 14px; }
.user-email { font-size: 12px; color: #94a3b8; margin-top: 2px; }

/* ── Badges ── */
.sid-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 7px;
    font-family: 'Courier New', monospace;
}

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

.role-badge {
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.role-admin { background: #e0e7ff; color: #3730a3; }
.role-hd    { background: #fef9c3; color: #b45309; }
.role-vc    { background: #f0fdf4; color: #15803d; }
.role-other { background: #f1f5f9; color: #475569; }

.status-active {
    background: #dcfce7;
    color: #15803d;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* ── Revoke button ── */
.btn-revoke {
    background: #fee2e2;
    color: #b91c1c;
    border: none;
    border-radius: 8px;
    padding: 7px 13px;
    font-size: 12.5px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    transition: all .18s;
    font-family: inherit;
}
.btn-revoke:hover {
    background: #fecaca;
    transform: scale(1.04);
}

/* ── Footer ── */
.users-footer {
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

/* ── Modal ── */
.modal-content {
    border: none !important;
    border-radius: 18px !important;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(15,45,110,0.18) !important;
}

.modal-stripe { height: 5px; }

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

.modal-icon {
    width: 34px; height: 34px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
}

.modal-body  { padding: 20px 24px !important; }
.modal-footer {
    padding: 14px 24px 20px !important;
    border-top: 1px solid #f1f5f9 !important;
    background: #fff !important;
}

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

.btn-modal-cancel {
    background: #f1f5f9; color: #64748b;
    border: none; border-radius: 10px;
    padding: 10px 18px; font-size: 13.5px;
    font-weight: 600; cursor: pointer;
    font-family: inherit;
    transition: background .2s;
}
.btn-modal-cancel:hover { background: #e2e8f0; }

.btn-modal-danger {
    background: linear-gradient(135deg,#991b1b,#ef4444);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 22px; font-size: 13.5px;
    font-weight: 700; cursor: pointer;
    font-family: inherit;
    box-shadow: 0 4px 12px rgba(239,68,68,0.28);
    transition: all .2s;
}
.btn-modal-danger:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(239,68,68,0.35); }

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

@php
    $totalUsers  = count($users);
    $adminCount  = collect($users)->where('role','admin')->count();
    $hdCount     = collect($users)->where('role','hd')->count();
    $vcCount     = collect($users)->where('role','vc')->count();
    $ldCount     = collect($users)->where('role','ld')->count();
@endphp

{{-- Page Header --}}
<div class="users-page-header">
    <div>
        <h2>
            <span class="hdr-icon"><i class="fa fa-shield-halved"></i></span>
            System Users
        </h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">System Users</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Stat Strip --}}
<div class="stat-strip">

    <div class="stat-chip">
        <div class="stat-chip-icon" style="background:#eff6ff;">
            <i class="fa fa-users" style="color:#1d4ed8;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $totalUsers }}</div>
            <div class="stat-chip-label">Total Users</div>
        </div>
    </div>

    <div class="stat-chip">
        <div class="stat-chip-icon" style="background:#e0e7ff;">
            <i class="fa fa-user-gear" style="color:#3730a3;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $adminCount }}</div>
            <div class="stat-chip-label">Admins</div>
        </div>
    </div>

    <div class="stat-chip">
        <div class="stat-chip-icon" style="background:#fef9c3;">
            <i class="fa fa-crown" style="color:#b45309;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $hdCount }}</div>
            <div class="stat-chip-label">Program Secreatriat</div>
        </div>
    </div>

    <div class="stat-chip">
        <div class="stat-chip-icon" style="background:#f0fdf4;">
            <i class="fa fa-star" style="color:#15803d;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $vcCount }}</div>
            <div class="stat-chip-label">Vice Chancellor</div>
        </div>
    </div>

     <div class="stat-chip">
        <div class="stat-chip-icon" style="background:#ffd9d9;">
            <i class="fa fa-user-tie" style="color:#c41a1a;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $ldCount }}</div>
            <div class="stat-chip-label">Head of Department</div>
        </div>
    </div>

</div>

{{-- Main Card --}}
<div class="users-card">
    <div class="users-card-stripe"></div>

    {{-- Toolbar --}}
    <div class="users-toolbar">
        <div class="toolbar-title">
            Active Accounts
            <span class="count-pill">{{ $totalUsers }}</span>
        </div>
        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="userSearch" class="search-input" placeholder="Search users...">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table id="userTable" class="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Staff ID</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr>

                    {{-- Row no --}}
                    <td style="color:#94a3b8;font-weight:600;font-size:13px;">{{ $index + 1 }}</td>

                    {{-- User --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="user-avatar">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Staff ID --}}
                    <td>
                        <span class="sid-badge">{{ $user->staff->staff_id ?? '—' }}</span>
                    </td>

                    {{-- Department --}}
                    <td>
                        <span class="dept-badge">
                            <i class="fa fa-building" style="font-size:11px;"></i>
                            {{ $user->staff->department->name ?? '—' }}
                        </span>
                    </td>

                    {{-- Role --}}
                    <td>
                        @php
                            $roleClass = match($user->role) {
                                'admin' => 'role-admin',
                                'hd'    => 'role-hd',
                                'vc'    => 'role-vc',
                                'ld'    => 'role-ld',
                                default => 'role-other',
                            };
                            $roleIcon = match($user->role) {
                                'admin' => 'fa-user-gear',
                                'hd'    => 'fa-crown',
                                'vc'    => 'fa-star',
                                'ld'    => 'fa-user-tie',
                                default => 'fa-user',
                            };
                            $roleLabel = match($user->role) {
                                'admin' => 'Admin',
                                'hd'    => 'Programme Secretariat',
                                'vc'    => 'Vice Chancellor',
                                'ld'    => 'Head of Department',
                                default => strtoupper($user->role),
                            };
                        @endphp
                        <span class="role-badge {{ $roleClass }}">
                            <i class="fa {{ $roleIcon }}" style="font-size:10px;"></i>
                            {{ $roleLabel }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="status-active">
                            <i class="fa fa-circle" style="font-size:7px;"></i>
                            Active
                        </span>
                    </td>

                    {{-- Action --}}
                    <td>
                        <button class="btn-revoke"
                                data-bs-toggle="modal"
                                data-bs-target="#removeAccessModal"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}">
                            <i class="fa fa-user-slash"></i> Revoke
                        </button>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="users-footer">
        <div id="dtInfo"></div>
        <div id="dtPaginate"></div>
    </div>
</div>


{{-- ── Remove Access Modal ── --}}
<div class="modal fade" id="removeAccessModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-stripe" style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>

            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fee2e2;color:#b91c1c;">
                        <i class="fa fa-user-slash"></i>
                    </span>
                    Revoke System Access
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
                            You are about to revoke system access for
                            <strong id="revokeUserName">this user</strong>.
                            They will immediately lose the ability to log in.
                        </p>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa fa-user-slash me-1"></i> Revoke Access
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

    var table = $('#userTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'tip',
        language: {
            info:      'Showing _START_–_END_ of _TOTAL_ users',
            infoEmpty: 'No users found',
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next:     '<i class="fa fa-chevron-right"></i>',
            }
        },
        initComplete: function () {
            $('#userTable_info').appendTo('#dtInfo');
            $('#userTable_paginate').appendTo('#dtPaginate');
        }
    });

    $('#userSearch').on('input', function () {
        table.search(this.value).draw();
    });

});

document.getElementById('removeAccessModal').addEventListener('show.bs.modal', function (e) {
    var btn = e.relatedTarget;
    document.getElementById('revokeUserName').textContent = btn.dataset.name ?? 'this user';
    document.getElementById('removeAccessForm').action = '/admin/users/' + btn.dataset.id;
});
</script>
@endpush
