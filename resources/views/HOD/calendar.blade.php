@extends('layouts.app')

@section('title', 'Program Calendar - AmazingTrack')

@push('styles')
<style>
    #leaderCalendar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        padding: 18px;
    }
    .fc .fc-toolbar-title { font-size: 1.15rem; font-weight: 700; color: var(--text-main); }
    .fc .fc-button-primary {
        background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
        border: none;
        text-transform: capitalize;
        box-shadow: 0 2px 8px rgba(26,86,219,0.25);
    }
    .fc .fc-button-primary:hover { background: linear-gradient(135deg, #0f2d6e, #1e56db); }
    .fc .fc-button-primary:disabled { background: #94a3b8; }
    .fc-daygrid-event { border: none; border-radius: 6px; padding: 1px 6px; font-size: 11.5px; font-weight: 600; }
    .fc-event-title { padding-left: 2px; }
    .legend-item { display: inline-flex; align-items: center; gap: 6px; font-size: 12.5px; font-weight: 600; color: var(--text-muted); margin-right: 16px; }
    .legend-dot { width: 9px; height: 9px; border-radius: 50%; display: inline-block; }
    .filter-bar {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 16px;
        margin-bottom: 18px;
        box-shadow: var(--shadow-sm);
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div>
        <h2><i class="fa-solid fa-calendar-days me-2" style="color:var(--sidebar-to)"></i>Program Calendar</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('leader.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Calendar</li>
            </ol>
        </nav>
    </div>
    <div>
        <span class="legend-item"><span class="legend-dot" style="background:#1d4ed8"></span>Upcoming</span>
        <span class="legend-item"><span class="legend-dot" style="background:#15803d"></span>Ongoing</span>
        <span class="legend-item"><span class="legend-dot" style="background:#64748b"></span>Completed</span>
        <span class="legend-item"><span class="legend-dot" style="background:#b45309"></span>Rescheduled</span>
        <span class="legend-item"><span class="legend-dot" style="background:#b91c1c"></span>Cancelled</span>
    </div>
</div>

<div class="filter-bar">
    <div class="row g-2 align-items-end">
        <div class="col-6 col-md-4">
            <label class="form-label small fw-semibold mb-1">Department</label>
            <select id="calendarDepartmentFilter" class="form-select form-select-sm select2-leader">
                <option value="">All my departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div id="leaderCalendar"></div>

{{-- Reuses the same "View Program Details" modal pattern as the dashboard --}}
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
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2-leader').select2({ theme: 'bootstrap-5', width: '100%' });

    const calendarEl = document.getElementById('leaderCalendar');
    let currentDepartment = '';

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth',
        },
        height: 'auto',
        events: function (info, successCallback, failureCallback) {
            fetch(`{{ route('leader.calendar.events') }}?start=${info.startStr}&end=${info.endStr}&department_id=${currentDepartment}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(res => res.json())
                .then(data => successCallback(data))
                .catch(err => failureCallback(err));
        },
        eventClick: function (info) {
            info.jsEvent.preventDefault();
            viewProgram(info.event.id);
        },
    });

    calendar.render();

    $('#calendarDepartmentFilter').on('change', function () {
        currentDepartment = $(this).val() || '';
        calendar.refetchEvents();
    });
});

function viewProgram(id) {
    new bootstrap.Modal(document.getElementById('viewProgramModal')).show();
    fetch(`/leader/programs/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => { document.getElementById('viewProgramBody').innerHTML = html; });
}
</script>
@endpush
