@extends('layouts.app')

@section('title', 'My Departments - AmazingTrack')

@push('styles')
<style>
    .dept-card {
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        background: var(--surface);
        box-shadow: var(--shadow-sm);
        padding: 20px;
        height: 100%;
        transition: var(--transition);
    }
    .dept-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }
    .dept-code-badge {
        background: var(--accent-light); color: #92400e;
        font-weight: 700; font-size: 12px;
        padding: 4px 10px; border-radius: 30px;
        display: inline-block; margin-bottom: 10px;
    }
    .dept-name { font-weight: 700; font-size: 17px; margin-bottom: 14px; }
    .dept-stat { text-align: center; padding: 10px 4px; border-radius: var(--radius-md); background: #f8faff; }
    .dept-stat .num { font-size: 1.3rem; font-weight: 800; color: var(--sidebar-to); }
    .dept-stat .lbl { font-size: 10.5px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: .3px; }
    .empty-state { text-align: center; padding: 50px 20px; color: var(--text-muted); }
    .empty-state i { font-size: 42px; color: #c7d5f8; margin-bottom: 14px; display:block; }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-building-columns me-2" style="color:var(--sidebar-to)"></i>My Departments</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Departments</li>
            </ol>
        </nav>
    </div>
    <span class="text-muted small">{{ $departments->count() }} department(s) under your leadership</span>
</div>

<div class="row g-3">
    @forelse($departments as $dept)
    <div class="col-12 col-md-6 col-xl-4">
        <div class="dept-card">
            <span class="dept-code-badge">{{ $dept->code ?? 'DEPT' }}</span>
            <div class="dept-name">{{ $dept->name }}</div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="dept-stat">
                        <div class="num">{{ $dept->staff_count }}</div>
                        <div class="lbl">Staff</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="dept-stat">
                        <div class="num">{{ $dept->program_count }}</div>
                        <div class="lbl">Programs</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="dept-stat">
                        <div class="num">{{ $dept->this_month_count }}</div>
                        <div class="lbl">This Month</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="dept-stat">
                        <div class="num">{{ $dept->weekend_staff_count }}</div>
                        <div class="lbl">Weekend Duty</div>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('leader.dashboard', ['department_id' => $dept->id]) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="fa-solid fa-list-check me-1"></i>Programs
                </a>
                <a href="{{ route('leader.staff.index', ['department_id' => $dept->id]) }}" class="btn btn-outline-secondary btn-sm flex-fill">
                    <i class="fa-solid fa-address-book me-1"></i>Staff
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="empty-state">
                <i class="fa-solid fa-building-circle-xmark"></i>
                No departments have been assigned to your account yet — contact an administrator.
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection
