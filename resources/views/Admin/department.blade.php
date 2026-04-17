@extends('layouts.app')

@section('title','Departments')
@section('page-title','Department Management')

@push('styles')
<style>

/* ── Page Header ── */
.dept-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 24px;
}

.dept-page-header h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.dept-page-header h2 .hdr-icon {
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

/* ── Add Button ── */
.btn-add-dept {
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
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
.btn-add-dept:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(26,86,219,0.38);
}

/* ── Stats row ── */
.dept-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.dept-stat-chip {
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
.dept-stat-chip:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(15,45,110,0.10);
}

.stat-chip-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.stat-chip-val {
    font-size: 1.7rem;
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

/* ── Main Card ── */
.dept-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(15,45,110,0.07);
    overflow: hidden;
}

.dept-card-stripe {
    height: 5px;
    background: linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6);
}

/* ── Toolbar ── */
.dept-toolbar {
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
.dept-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13.5px;
}

.dept-table thead th {
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

.dept-table tbody tr { transition: background .15s; }
.dept-table tbody tr:hover { background: #f8faff; }

.dept-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
}

.dept-table tbody tr:last-child td { border-bottom: none; }

/* ── Dept icon cell ── */
.dept-icon-wrap {
    width: 40px; height: 40px;
    border-radius: 11px;
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 16px;
    flex-shrink: 0;
}

.dept-name { font-weight: 700; color: #0f172a; font-size: 14px; }

/* ── Code badge ── */
.code-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 8px;
    font-family: 'Courier New', monospace;
    letter-spacing: .8px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* ── Row number ── */
.row-no {
    color: #94a3b8;
    font-weight: 600;
    font-size: 13px;
}

/* ── Action buttons ── */
.action-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
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
.act-btn:hover  { filter: brightness(.90); transform: scale(1.08); }

/* ── Footer ── */
.dept-footer {
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

/* ── Empty state ── */
.dept-empty {
    text-align: center;
    padding: 60px 20px;
    color: #94a3b8;
}
.dept-empty i {
    font-size: 44px;
    display: block;
    margin-bottom: 14px;
    color: #cbd5e1;
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
    flex-shrink: 0;
}

.modal-body  { padding: 20px 24px !important; }
.modal-footer {
    padding: 14px 24px 20px !important;
    border-top: 1px solid #f1f5f9 !important;
    background: #fff !important;
}

.form-label {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: block;
    text-transform: uppercase;
    letter-spacing: .5px;
}

.form-control {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
    font-size: 13.5px !important;
    font-family: inherit !important;
    color: #1e293b !important;
    background: #f8faff !important;
    box-shadow: none !important;
    outline: none !important;
    transition: border-color .2s, box-shadow .2s !important;
}
.form-control:focus {
    border-color: #1a56db !important;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.10) !important;
    background: #fff !important;
}

.btn-modal-cancel {
    background: #f1f5f9; color: #64748b;
    border: none; border-radius: 10px;
    padding: 10px 18px; font-size: 13.5px;
    font-weight: 600; cursor: pointer;
    font-family: inherit; transition: background .2s;
}
.btn-modal-cancel:hover { background: #e2e8f0; }

.btn-modal-primary {
    background: linear-gradient(135deg,#0f2d6e,#1a56db);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 22px; font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 12px rgba(26,86,219,0.25);
    transition: all .2s;
}
.btn-modal-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(26,86,219,0.32); }

.btn-modal-warning {
    background: linear-gradient(135deg,#b45309,#f59e0b);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 22px; font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 12px rgba(245,158,11,0.25);
    transition: all .2s;
}
.btn-modal-warning:hover { transform: translateY(-1px); }

.btn-modal-danger {
    background: linear-gradient(135deg,#991b1b,#ef4444);
    color: #fff; border: none; border-radius: 10px;
    padding: 10px 22px; font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: inherit;
    box-shadow: 0 4px 12px rgba(239,68,68,0.25);
    transition: all .2s;
}
.btn-modal-danger:hover { transform: translateY(-1px); }

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
    border-radius: 8px !important; font-size: 12.5px !important;
    font-weight: 600 !important; padding: 4px 11px !important; border: none !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg,#0f2d6e,#1a56db) !important;
    color: #fff !important; border: none !important;
}

</style>
@endpush

@section('content')

@php $total = count($departments); @endphp

{{-- Page Header --}}
<div class="dept-page-header">
    <div>
        <h2>
            <span class="hdr-icon"><i class="fa fa-building"></i></span>
            Department Management
        </h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Departments</li>
            </ol>
        </nav>
    </div>

    <button class="btn-add-dept"
            data-bs-toggle="modal"
            data-bs-target="#deptModal">
        <i class="fa fa-plus"></i> Add Department
    </button>
</div>

{{-- Stats ── --}}
<div class="dept-stats">
    <div class="dept-stat-chip">
        <div class="stat-chip-icon" style="background:#eff6ff;">
            <i class="fa fa-building-columns" style="color:#1d4ed8;"></i>
        </div>
        <div>
            <div class="stat-chip-val">{{ $total }}</div>
            <div class="stat-chip-label">Total Departments</div>
        </div>
    </div>
    <div class="dept-stat-chip">
        <div class="stat-chip-icon" style="background:#f0fdf4;">
            <i class="fa fa-users" style="color:#15803d;"></i>
        </div>
        <div>
            <div class="stat-chip-val">
                {{ $departments->sum(fn($d) => $d->staff_count ?? ($d->staff ? $d->staff->count() : 0)) }}
            </div>
            <div class="stat-chip-label">Total Staff</div>
        </div>
    </div>
</div>

{{-- Main Card --}}
<div class="dept-card">
    <div class="dept-card-stripe"></div>

    {{-- Toolbar --}}
    <div class="dept-toolbar">
        <div class="toolbar-title">
            All Departments
            <span class="count-pill">{{ $total }}</span>
        </div>
        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text" id="deptSearch" class="search-input" placeholder="Search departments...">
        </div>
    </div>

    {{-- Table --}}
    <div class="table-responsive">

        @if($total === 0)
            <div class="dept-empty">
                <i class="fa fa-building-slash"></i>
                <h6 style="color:#475569;font-weight:700;">No departments yet</h6>
                <p style="font-size:13.5px;max-width:280px;margin:6px auto 0;">
                    Get started by adding your first department.
                </p>
            </div>
        @else
        <table id="deptTable" class="dept-table">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Department</th>
                    <th>Code</th>
                    <th>Staff</th>
                    <th style="width:100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $index => $dept)
                <tr>

                    {{-- Row no --}}
                    <td class="row-no">{{ $index + 1 }}</td>

                    {{-- Department name --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="dept-icon-wrap">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="dept-name">{{ $dept->name }}</div>
                        </div>
                    </td>

                    {{-- Code --}}
                    <td>
                        <span class="code-badge">
                            <i class="fa fa-hashtag" style="font-size:10px;"></i>
                            {{ $dept->code }}
                        </span>
                    </td>

                    {{-- Staff count --}}
                    <td>
                        @php $staffCount = $dept->staff ? $dept->staff->count() : 0; @endphp
                        <span style="font-size:13px;font-weight:600;color:#475569;">
                            <i class="fa fa-users me-1" style="color:#94a3b8;font-size:12px;"></i>
                            {{ $staffCount }} {{ Str::plural('member', $staffCount) }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="action-wrap">
                            <button class="act-btn edit"
                                    title="Edit Department"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editDeptModal"
                                    data-id="{{ $dept->id }}"
                                    data-name="{{ $dept->name }}"
                                    data-code="{{ $dept->code }}">
                                <i class="fa fa-pen"></i>
                            </button>

                            <button class="act-btn delete"
                                    title="Delete Department"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteDeptModal"
                                    data-id="{{ $dept->id }}"
                                    data-name="{{ $dept->name }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    </div>

    {{-- Footer --}}
    @if($total > 0)
    <div class="dept-footer">
        <div id="dtInfo"></div>
        <div id="dtPaginate"></div>
    </div>
    @endif
</div>


{{-- ════════════════════
     MODALS
════════════════════ --}}

{{-- Add Department --}}
<div class="modal fade" id="deptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#0f2d6e,#1a56db);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#eff6ff;color:#1d4ed8;">
                        <i class="fa fa-building-circle-arrow-right"></i>
                    </span>
                    Add Department
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.departments.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" class="form-control"
                               placeholder="e.g. Computer Science" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Department Code</label>
                        <input type="text" name="code" class="form-control"
                               placeholder="e.g. CS">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-primary">
                        <i class="fa fa-plus me-1"></i> Add Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Department --}}
<div class="modal fade" id="editDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#b45309,#f59e0b);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fef9c3;color:#b45309;">
                        <i class="fa fa-pen"></i>
                    </span>
                    Edit Department
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="editDeptForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Department Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Department Code</label>
                        <input type="text" name="code" id="editCode" class="form-control" required>
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

{{-- Delete Department --}}
<div class="modal fade" id="deleteDeptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-stripe" style="background:linear-gradient(90deg,#991b1b,#ef4444);"></div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="modal-icon" style="background:#fee2e2;color:#b91c1c;">
                        <i class="fa fa-trash"></i>
                    </span>
                    Delete Department
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteDeptForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="danger-zone">
                        <i class="fa fa-triangle-exclamation"></i>
                        <p>
                            You are about to delete
                            <strong id="deleteDeptName">this department</strong>.
                            This may affect staff assigned to it. This action
                            <strong>cannot be undone</strong>.
                        </p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-danger">
                        <i class="fa fa-trash me-1"></i> Delete Department
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

    var table = $('#deptTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'tip',
        language: {
            info:      'Showing _START_–_END_ of _TOTAL_ departments',
            infoEmpty: 'No departments found',
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next:     '<i class="fa fa-chevron-right"></i>',
            }
        },
        initComplete: function () {
            $('#deptTable_info').appendTo('#dtInfo');
            $('#deptTable_paginate').appendTo('#dtPaginate');
        }
    });

    $('#deptSearch').on('input', function () {
        table.search(this.value).draw();
    });

});

/* Edit Modal */
document.getElementById('editDeptModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    document.getElementById('editName').value = b.dataset.name;
    document.getElementById('editCode').value = b.dataset.code;
    document.getElementById('editDeptForm').action = '/admin/departments/' + b.dataset.id;
});

/* Delete Modal */
// document.getElementById('deleteDeptModal').addEventListener('show.bs.modal', function (e) {
//     var b = e.relatedTarget;
//     document.getElementById('deleteDeptName').textContent = '"' + b.dataset.name + '"';
//     document.getElementById('deleteDeptForm').action = '/admin/departments/' + b.dataset.id;
// });

document.getElementById('deleteDeptModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    var action = '/admin/departments/' + b.dataset.id;
    console.log('Delete action:', action); // check this in browser console
    document.getElementById('deleteDeptName').textContent = '"' + b.dataset.name + '"';
    document.getElementById('deleteDeptForm').action = action;
});
</script>
@endpush
