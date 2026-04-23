@extends('layouts.app')

@section('page-title','Department Staff')

@push('styles')
<style>

/* ── Page card ── */
.staff-card {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 20px rgba(15,45,110,0.07) !important;
    overflow: hidden;
}

.staff-card .card-top {
    height: 5px;
    background: linear-gradient(90deg, #0f2d6e, #1a56db, #3b82f6);
}

/* ── Search bar ── */
.staff-search-wrap {
    position: relative;
}

.staff-search-wrap i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.staff-search {
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 14px 10px 36px;
    font-size: 14px;
    font-family: inherit;
    background: #f8faff;
    color: #1e293b;
    width: 260px;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
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
    font-size: 14px;
}

.staff-table thead tr th {
    background: #f1f5ff !important;
    color: #64748b;
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .9px;
    text-transform: uppercase;
    padding: 13px 18px !important;
    border-bottom: 2px solid #dde6ff !important;
    white-space: nowrap;
}

.staff-table tbody tr {
    transition: background .18s;
}

.staff-table tbody tr:hover {
    background: #f8faff;
}

.staff-table tbody td {
    padding: 14px 18px !important;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9 !important;
    color: #334155;
}

.staff-table tbody tr:last-child td {
    border-bottom: none !important;
}

/* ── Avatar ── */
.staff-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

/* ── Staff ID badge ── */
.staff-id-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 8px;
    font-family: monospace;
    letter-spacing: .5px;
}

/* ── Position pill ── */
.position-pill {
    background: #f1f5f9;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* ── Email chip ── */
.email-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13.5px;
    color: #475569;
}

.email-chip i { color: #94a3b8; font-size: 13px; }

/* ── Empty state ── */
.empty-state {
    text-align: center;
    padding: 60px 24px;
    color: #94a3b8;
}

.empty-state i {
    font-size: 44px;
    display: block;
    margin-bottom: 14px;
    color: #cbd5e1;
}

/* ── Pagination override ── */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    padding: 5px 12px !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg,#0f2d6e,#1a56db) !important;
    border-color: #1a56db !important;
    color: #fff !important;
}

.dataTables_wrapper .dataTables_info {
    font-size: 13px;
    color: #64748b;
}

.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    display: none; /* hide default DT search — we use our own */
}

.dataTables_wrapper .dataTables_length { display: none; }
.dataTables_wrapper .dataTables_filter { display: none; }

/* ── Count badge ── */
.count-badge {
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    margin-left: 8px;
}

</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h2><i class="text-primary"></i>Department Staff</h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}"
                    class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Department Staff</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Staff card --}}
<div class="card staff-card">
    <div class="card-top"></div>

    {{-- Card header --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 px-4 pt-4 pb-3"
         style="border-bottom:1px solid #f1f5f9;">

        <div class="d-flex align-items-center gap-2">
            <h5 style="font-weight:700;font-size:1rem;color:#0f172a;margin:0;">
                Staff Members
            </h5>
            <span class="count-badge">{{ count($staff) }} total</span>
        </div>

        {{-- Custom search --}}
        <div class="staff-search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input type="text"
                   id="staffSearch"
                   class="staff-search"
                   placeholder="Search name, ID, email...">
        </div>

    </div>

    {{-- Table --}}
    <div class="table-responsive px-2 pb-2">

        @if(count($staff) === 0)
            <div class="empty-state">
                <i class="fa fa-users-slash"></i>
                <h6 style="color:#475569;font-weight:600;">No staff found</h6>
                <p style="font-size:13.5px;max-width:300px;margin:6px auto 0;">
                    There are no staff members in your department yet.
                </p>
            </div>
        @else
            <table id="deptStaffTable" class="staff-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Staff</th>
                        <th>Staff ID</th>
                        <th>Email</th>
                        <th>Position</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($staff as $index => $s)
                    <tr>

                        {{-- Row number --}}
                        <td style="color:#94a3b8;font-size:13px;font-weight:600;width:48px;">
                            {{ $index + 1 }}
                        </td>

                        {{-- Name + avatar --}}
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="staff-avatar">
                                    {{ strtoupper(substr($s->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight:700;color:#0f172a;font-size:14px;">
                                        {{ $s->name }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Staff ID --}}
                        <td>
                            <span class="staff-id-badge">{{ $s->staff_id }}</span>
                        </td>

                        {{-- Email --}}
                        <td>
                            <span class="email-chip">
                                <i class="fa fa-envelope"></i>
                                {{ $s->email }}
                            </span>
                        </td>

                        {{-- Position --}}
                        <td>
                            @if($s->position)
                                <span class="position-pill">
                                    <i class="fa fa-briefcase"></i>
                                    {{ $s->position }}
                                </span>
                            @else
                                <span style="color:#cbd5e1;font-size:13px;">—</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        @endif

    </div>

    {{-- Footer with DataTables info --}}
    @if(count($staff) > 0)
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 px-4 py-3"
         style="border-top:1px solid #f1f5f9;">
        <div id="dtInfo" style="font-size:13px;color:#64748b;"></div>
        <div id="dtPaginate"></div>
    </div>
    @endif

</div>

@endsection


@push('scripts')
<script>
$(document).ready(function () {

    const table = $('#deptStaffTable').DataTable({
        responsive: true,
        pageLength: 10,
        dom: 'tip', // only table, info, pagination
        language: {
            info:      'Showing _START_ to _END_ of _TOTAL_ staff',
            infoEmpty: 'No staff found',
            paginate: {
                previous: '<i class="fa fa-chevron-left"></i>',
                next:     '<i class="fa fa-chevron-right"></i>',
            }
        },
        // Move DT controls to our custom containers
        initComplete: function () {
            // Move info and pagination into our footer divs
            $('#deptStaffTable_info').appendTo('#dtInfo');
            $('#deptStaffTable_paginate').appendTo('#dtPaginate');
        }
    });

    // Wire our custom search input to DataTables
    $('#staffSearch').on('input', function () {
        table.search(this.value).draw();
    });

});
</script>
@endpush
