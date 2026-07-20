@extends('layouts.app')

@section('title', 'Staff Directory - AmazingTrack')

@push('styles')
<style>
    .staff-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: var(--surface);
        padding: 18px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
        height: 100%;
    }
    .staff-avatar {
        width: 46px; height: 46px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    .staff-name { font-weight: 700; font-size: 14.5px; margin-bottom: 2px; }
    .staff-position { font-size: 12.5px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .4px; font-weight: 600; margin-bottom: 8px; }
    .staff-meta { font-size: 13px; color: var(--text-main); display: flex; align-items: center; gap: 6px; margin-bottom: 3px; }
    .staff-meta i { width: 14px; color: var(--text-muted); }
    .dept-badge { background: var(--accent-light); color: #92400e; font-size: 11px; font-weight: 700; padding: 3px 8px; border-radius: 6px; }
    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: var(--shadow-sm);
    }
    .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 42px; color: #c7d5f8; margin-bottom: 14px; display:block; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-address-book me-2" style="color:var(--sidebar-to)"></i>Staff Directory</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Staff Directory</li>
            </ol>
        </nav>
    </div>
    <span class="text-muted small">{{ $staff->total() }} staff across your department(s)</span>
</div>

<div class="filter-bar">
    <form method="GET" action="{{ route('leader.staff.index') }}" class="row g-2 align-items-end">
        <div class="col-6 col-md-4">
            <label class="form-label small fw-semibold mb-1">Department</label>
            <select name="department_id" class="form-select form-select-sm select2-leader">
                <option value="">All my departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected(request('department_id') == $dept->id)>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-6">
            <label class="form-label small fw-semibold mb-1">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" placeholder="Name, staff ID, position or email">
        </div>
        <div class="col-12 col-md-2">
            <button type="submit" class="btn btn-primary btn-sm w-100"><i class="fa-solid fa-filter me-1"></i>Filter</button>
        </div>
    </form>
</div>

<div class="row g-3">
    @forelse($staff as $person)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="staff-card">
            <div class="staff-avatar">{{ strtoupper(substr($person->name, 0, 1)) }}</div>
            <div class="flex-grow-1 min-w-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="staff-name">{{ $person->name }}</div>
                    <span class="dept-badge">{{ optional($person->department)->code }}</span>
                </div>
                <div class="staff-position">{{ $person->position ?? 'Staff' }} &middot; {{ $person->staff_id }}</div>
                <div class="staff-meta"><i class="fa-solid fa-envelope"></i><span class="text-truncate">{{ $person->email }}</span></div>
                @if($person->phone)
                    <div class="staff-meta"><i class="fa-solid fa-phone"></i>{{ $person->phone }}</div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="empty-state">
                <i class="fa-solid fa-user-slash"></i>
                No staff found for your department(s) yet.
            </div>
        </div>
    </div>
    @endforelse
</div>

@if(method_exists($staff, 'links'))
<div class="mt-4">
    {{ $staff->links() }}
</div>
@endif

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2-leader').select2({ theme: 'bootstrap-5', width: '100%' });
});
</script>
@endpush
