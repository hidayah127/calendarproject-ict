@extends('layouts.app')

@section('page-title','My Calendar')

@push('styles')
{{-- FullCalendar --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<style>
/* ── Variables ── */
:root {
    --cal-radius: 14px;
    --blue:       #1a56db;
    --blue-dark:  #0f2d6e;
}

/* ── Legend badges ── */
.legend-dot {
    width: 11px; height: 11px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 500;
    color: #475569;
    background: #f8faff;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 4px 12px 4px 8px;
}

/* ── Calendar wrapper card ── */
.calendar-card {
    background: #fff;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: var(--cal-radius) !important;
    box-shadow: 0 4px 24px rgba(15,45,110,0.07) !important;
    padding: 20px;
}

/* ── FullCalendar overrides ── */
.fc .fc-toolbar-title {
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: #0f172a !important;
}

.fc .fc-button {
    background: #f1f5f9 !important;
    border: 1.5px solid #e2e8f0 !important;
    color: #475569 !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    padding: 6px 14px !important;
    box-shadow: none !important;
    transition: all .2s !important;
}

.fc .fc-button:hover {
    background: #e2e8f0 !important;
    color: #1e293b !important;
}

.fc .fc-button-primary:not(:disabled).fc-button-active,
.fc .fc-button-primary:not(:disabled):active {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue)) !important;
    border-color: var(--blue) !important;
    color: #fff !important;
}

.fc .fc-today-button {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue)) !important;
    border-color: var(--blue) !important;
    color: #fff !important;
}

.fc .fc-col-header-cell-cushion {
    font-size: 12.5px !important;
    font-weight: 700 !important;
    color: #64748b !important;
    text-transform: uppercase;
    letter-spacing: .6px;
    text-decoration: none !important;
}

.fc .fc-daygrid-day-number {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #334155 !important;
    text-decoration: none !important;
}

.fc .fc-day-today {
    background: #eff6ff !important;
}

.fc .fc-day-today .fc-daygrid-day-number {
    background: var(--blue);
    color: #fff !important;
    border-radius: 50%;
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px !important;
}

.fc-event {
    border-radius: 6px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    padding: 2px 6px !important;
    cursor: pointer !important;
    border: none !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12) !important;
    transition: transform .15s, box-shadow .15s !important;
}

.fc-event:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.18) !important;
    opacity: .92;
}

.fc .fc-scrollgrid {
    border-radius: 10px;
    overflow: hidden;
    border-color: #e2e8f0 !important;
}

.fc td, .fc th {
    border-color: #e2e8f0 !important;
}

.fc .fc-list-event:hover td {
    background: #f8faff !important;
    cursor: pointer;
}

/* ── Popup / Tooltip ── */
.event-popup {
    position: fixed;
    z-index: 9999;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 16px 48px rgba(15,45,110,0.18);
    padding: 0;
    width: 300px;
    overflow: hidden;
    display: none;
    animation: popIn .18s ease;
}

@keyframes popIn {
    from { opacity:0; transform: scale(.95) translateY(6px); }
    to   { opacity:1; transform: scale(1)  translateY(0); }
}

.popup-header {
    padding: 14px 16px 12px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
    border-bottom: 1px solid #f1f5f9;
}

.popup-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
    margin: 0;
}

.popup-close {
    background: #f1f5f9;
    border: none;
    border-radius: 6px;
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: #64748b;
    flex-shrink: 0;
    font-size: 12px;
    transition: background .15s;
}
.popup-close:hover { background: #e2e8f0; }

.popup-body {
    padding: 14px 16px;
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.popup-row {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    font-size: 13px;
    color: #475569;
}

.popup-row i {
    width: 16px;
    color: var(--blue);
    flex-shrink: 0;
    margin-top: 1px;
}

.popup-status {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
    letter-spacing: .3px;
}

.popup-footer {
    padding: 12px 16px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 8px;
}

.popup-btn-edit {
    flex: 1;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue));
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
    box-shadow: 0 3px 10px rgba(26,86,219,0.25);
    transition: all .2s;
}
.popup-btn-edit:hover { transform: translateY(-1px); color: #fff; }

.popup-btn-close {
    background: #f1f5f9;
    color: #475569;
    border: none;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: background .2s;
}
.popup-btn-close:hover { background: #e2e8f0; }

/* overlay to close popup on outside click */
#popupOverlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9998;
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h2><i class="fa fa-calendar-days me-2 text-primary"></i>My Calendar</h2>
        <nav aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('head.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('head.programs.index') }}"
       style="background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 20px;font-size:14px;font-weight:600;font-family:inherit;display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:background .2s;"
       onmouseover="this.style.background='#e2e8f0'"
       onmouseout="this.style.background='#f1f5f9'">
        <i class="fa fa-list"></i> My Programs
    </a>
</div>

{{-- Legend --}}
<div class="d-flex flex-wrap gap-2 mb-4">
    @foreach([
        ['Upcoming',    '#3b82f6'],
        ['Ongoing',     '#16a34a'],
        ['Completed',   '#6366f1'],
        ['Rescheduled', '#f59e0b'],
        ['Cancelled',   '#ef4444'],
    ] as [$label, $color])
    <span class="legend-item">
        <span class="legend-dot" style="background:{{ $color }};"></span>
        {{ $label }}
    </span>
    @endforeach
</div>

{{-- Calendar --}}
<div class="card calendar-card">
    <div id="calendar"></div>
</div>

{{-- Event popup overlay --}}
<div id="popupOverlay"></div>

{{-- Event popup --}}
<div class="event-popup" id="eventPopup">
    <div class="popup-header">
        <p class="popup-title" id="popupTitle"></p>
        <button class="popup-close" id="popupCloseBtn"><i class="fa fa-xmark"></i></button>
    </div>
    <div class="popup-body">
        <div class="popup-row">
            <i class="fa fa-circle-half-stroke"></i>
            <span id="popupStatus"></span>
        </div>
        <div class="popup-row">
            <i class="fa fa-location-dot"></i>
            <span id="popupVenue"></span>
        </div>
        <div class="popup-row">
            <i class="fa fa-calendar"></i>
            <span id="popupStart"></span>
        </div>
        <div class="popup-row">
            <i class="fa fa-calendar-check"></i>
            <span id="popupEnd"></span>
        </div>
        <div class="popup-row" id="popupDescRow" style="display:none;">
            <i class="fa fa-align-left"></i>
            <span id="popupDesc"></span>
        </div>
    </div>
    <div class="popup-footer">
        <a href="#" id="popupEditBtn" class="popup-btn-edit">
            <i class="fa fa-pen"></i> Edit Program
        </a>
        <button class="popup-btn-close" id="popupFooterClose">Close</button>
    </div>
</div>

@endsection


@push('scripts')
{{-- FullCalendar --}}
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Programs data from Laravel ── */
    const programs = @json($programs);

    /* ── Popup elements ── */
    const popup          = document.getElementById('eventPopup');
    const overlay        = document.getElementById('popupOverlay');
    const popupTitle     = document.getElementById('popupTitle');
    const popupStatus    = document.getElementById('popupStatus');
    const popupVenue     = document.getElementById('popupVenue');
    const popupStart     = document.getElementById('popupStart');
    const popupEnd       = document.getElementById('popupEnd');
    const popupDesc      = document.getElementById('popupDesc');
    const popupDescRow   = document.getElementById('popupDescRow');
    const popupEditBtn   = document.getElementById('popupEditBtn');
    const popupCloseBtn  = document.getElementById('popupCloseBtn');
    const popupFooterClose = document.getElementById('popupFooterClose');

    /* ── Status badge colours ── */
    const statusStyle = {
        upcoming:    { bg:'#dbeafe', color:'#1d4ed8' },
        ongoing:     { bg:'#dcfce7', color:'#15803d' },
        completed:   { bg:'#e0e7ff', color:'#3730a3' },
        rescheduled: { bg:'#fef9c3', color:'#b45309' },
        cancelled:   { bg:'#fee2e2', color:'#b91c1c' },
    };

    /* ── Format datetime ── */
    function fmt(iso) {
        return new Date(iso).toLocaleString('en-MY', {
            day:'2-digit', month:'short', year:'numeric',
            hour:'2-digit', minute:'2-digit', hour12:true
        });
    }

    /* ── Show popup near clicked element ── */
    function showPopup(info) {
        const ep    = info.event.extendedProps;
        const rect  = info.el.getBoundingClientRect();
        const style = statusStyle[ep.status] || statusStyle.upcoming;

        popupTitle.textContent = info.event.title;

        popupStatus.innerHTML = `
            <span style="background:${style.bg};color:${style.color};font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;">
                ${ep.status.charAt(0).toUpperCase() + ep.status.slice(1)}
            </span>`;

        popupVenue.textContent = ep.venue || '—';
        popupStart.textContent = fmt(info.event.startStr);
        popupEnd.textContent   = fmt(info.event.endStr || info.event.startStr);

        if (ep.description) {
            popupDesc.textContent    = ep.description;
            popupDescRow.style.display = 'flex';
        } else {
            popupDescRow.style.display = 'none';
        }

        popupEditBtn.href = ep.edit_url;

        // Position popup
        popup.style.display = 'block';
        overlay.style.display = 'block';

        const popW  = 300;
        const popH  = popup.offsetHeight || 260;
        const vw    = window.innerWidth;
        const vh    = window.innerHeight;

        let left = rect.right + 10;
        let top  = rect.top;

        if (left + popW > vw - 10) left = rect.left - popW - 10;
        if (left < 10)             left = 10;
        if (top + popH > vh - 10)  top  = vh - popH - 10;
        if (top < 10)              top  = 10;

        popup.style.left = left + 'px';
        popup.style.top  = top  + 'px';
    }

    function closePopup() {
        popup.style.display   = 'none';
        overlay.style.display = 'none';
    }

    popupCloseBtn.addEventListener('click',   closePopup);
    popupFooterClose.addEventListener('click', closePopup);
    overlay.addEventListener('click',          closePopup);

    /* ── FullCalendar init ── */
    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView:     'dayGridMonth',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,listMonth'
        },
        buttonText: {
            today:     'Today',
            month:     'Month',
            week:      'Week',
            list:      'List',
        },
        events:          programs,
        eventClick:      showPopup,
        height:          'auto',
        dayMaxEvents:    3,
        nowIndicator:    true,
        eventTimeFormat: {
            hour:   '2-digit',
            minute: '2-digit',
            hour12: true
        },
        moreLinkContent: (args) => `+${args.num} more`,
        moreLinkClick:   'popover',
    });

    calendar.render();
});
</script>
@endpush
