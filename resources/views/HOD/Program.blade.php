@extends('layouts.app')

@section('page-title','Programs — Head of Department')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

<style>
/* ============================================================
   CSS VARIABLES
   ============================================================ */
:root {
    --ink:          #0d1117;
    --ink-soft:     #4a5568;
    --ink-faint:    #94a3b8;
    --surface:      #ffffff;
    --surface-alt:  #f8fafc;
    --border:       #e2e8f0;
    --accent:       #1e40af;
    --accent-lt:    #eff6ff;
    --green:        #166534;
    --green-lt:     #dcfce7;
    --amber:        #92400e;
    --amber-lt:     #fef3c7;
    --slate:        #475569;
    --slate-lt:     #f1f5f9;
    --radius:       10px;
    --radius-lg:    14px;
    --shadow:       0 1px 3px rgba(0,0,0,.07), 0 4px 16px rgba(0,0,0,.05);
    --shadow-hover: 0 8px 32px rgba(0,0,0,.12);
    --font-head:    'Playfair Display', Georgia, serif;
    --font-body:    'DM Sans', system-ui, sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: var(--font-body);
    color: var(--ink);
    background: var(--surface-alt);
}

/* ============================================================
   PAGE HEADER
   ============================================================ */
.page-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 24px;
}
.page-head-left h1 {
    font-family: var(--font-head);
    font-size: 24px;
    color: var(--ink);
    line-height: 1.2;
}
.page-head-left p {
    font-size: 13px;
    color: var(--ink-faint);
    margin-top: 4px;
}

/* ============================================================
   TOOLBAR
   ============================================================ */
.toolbar {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}
.toolbar select {
    padding: 8px 12px;
    border-radius: var(--radius);
    border: 1.5px solid var(--border);
    font-family: var(--font-body);
    font-size: 13px;
    color: var(--ink);
    background: var(--surface);
    cursor: pointer;
    outline: none;
    transition: border .15s;
}
.toolbar select:focus { border-color: var(--accent); }

.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 14px;
    border-radius: var(--radius);
    font-family: var(--font-body);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: opacity .15s, transform .1s;
}
.btn:active { transform: scale(.97); }
.btn-dark   { background: var(--ink); color: #fff; }
.btn-dark:hover { opacity: .88; }

.print-dropdown { position: relative; }
.print-menu {
    display: none;
    position: absolute;
    top: calc(100% + 6px);
    right: 0;
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    width: 200px;
    z-index: 100;
    overflow: hidden;
}
.print-menu.open { display: block; }
.print-menu button {
    width: 100%;
    text-align: left;
    padding: 10px 14px;
    font-family: var(--font-body);
    font-size: 13px;
    background: none;
    border: none;
    color: var(--ink);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: background .1s;
}
.print-menu button:hover { background: var(--surface-alt); }

/* ============================================================
   SUMMARY STRIP
   ============================================================ */
.summary-strip {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.summary-chip {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: 999px;
    padding: 6px 14px;
    font-size: 12.5px;
    font-weight: 500;
    color: var(--ink-soft);
    display: flex;
    align-items: center;
    gap: 6px;
}
.chip-dot { width: 8px; height: 8px; border-radius: 50%; }
.dot-upcoming  { background: var(--accent); }
.dot-ongoing   { background: #16a34a; }
.dot-completed { background: #94a3b8; }

/* ============================================================
   PROGRAM LIST
   ============================================================ */
.prog-list { display: flex; flex-direction: column; gap: 14px; }

/* ============================================================
   PROGRAM CARD
   ============================================================ */
.prog-card {
    background: var(--surface);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: box-shadow .2s, transform .2s;
}
.prog-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }
.prog-card::before {
    content: '';
    display: block;
    height: 4px;
    background: linear-gradient(90deg, var(--accent), #3b82f6);
}
.prog-card.status-ongoing::before   { background: linear-gradient(90deg, #16a34a, #4ade80); }
.prog-card.status-completed::before { background: linear-gradient(90deg, #94a3b8, #cbd5e1); }

.prog-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    cursor: pointer;
    user-select: none;
}
.prog-icon {
    width: 42px; height: 42px;
    border-radius: 10px;
    background: var(--accent-lt);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; color: var(--accent);
    flex-shrink: 0; margin-top: 2px;
}
.status-ongoing  .prog-icon { background: var(--green-lt); color: var(--green); }
.status-completed .prog-icon { background: var(--slate-lt); color: var(--slate); }

.prog-info { flex: 1; min-width: 0; }
.prog-title {
    font-family: var(--font-head);
    font-size: 16px; font-weight: 600;
    color: var(--ink); line-height: 1.3;
}
.prog-meta {
    display: flex; flex-wrap: wrap; gap: 12px; margin-top: 6px;
}
.meta-item {
    font-size: 12.5px; color: var(--ink-faint);
    display: flex; align-items: center; gap: 4px;
}
.prog-actions {
    display: flex; align-items: center; gap: 8px; flex-shrink: 0;
}

.status-badge {
    font-size: 11px; font-weight: 600;
    padding: 4px 10px; border-radius: 999px;
    letter-spacing: .4px; text-transform: uppercase;
}
.badge-upcoming  { background: var(--accent-lt); color: var(--accent); }
.badge-ongoing   { background: var(--green-lt);  color: var(--green); }
.badge-completed { background: var(--slate-lt);  color: var(--slate); }

.btn-print-single {
    padding: 5px 10px; font-size: 11.5px;
    border-radius: 8px;
    background: var(--surface-alt);
    border: 1.5px solid var(--border);
    color: var(--ink-soft);
    cursor: pointer; font-family: var(--font-body);
    display: inline-flex; align-items: center; gap: 4px;
    transition: all .15s; white-space: nowrap;
}
.btn-print-single:hover {
    background: var(--accent-lt); border-color: var(--accent); color: var(--accent);
}

.toggle-chevron {
    font-size: 12px; color: var(--ink-faint); transition: transform .25s;
}
.prog-card.is-open .toggle-chevron { transform: rotate(180deg); }

.prog-body { display: none; border-top: 1px solid var(--border); }
.prog-card.is-open .prog-body { display: block; }

.prog-table-wrap { overflow-x: auto; }
.prog-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.prog-table thead th {
    background: var(--surface-alt); color: var(--ink-faint);
    font-size: 11px; font-weight: 600; text-transform: uppercase;
    letter-spacing: .7px; padding: 10px 16px; text-align: left;
    border-bottom: 1px solid var(--border);
}
.prog-table tbody td {
    padding: 11px 16px; border-bottom: 1px solid var(--border); color: var(--ink-soft);
}
.prog-table tbody tr:last-child td { border-bottom: none; }
.prog-table tbody tr:hover td { background: #f8faff; }

.lead-badge {
    font-size: 10px; font-weight: 700;
    background: var(--amber-lt); color: var(--amber);
    padding: 2px 7px; border-radius: 6px; margin-left: 6px; letter-spacing: .3px;
}
.empty-row td {
    text-align: center; color: var(--ink-faint); padding: 20px; font-style: italic;
}

/* WEEK DIVIDER */
.week-divider {
    display: flex; align-items: center; gap: 12px; margin: 20px 0 10px;
}
.week-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1px; color: var(--ink-faint); white-space: nowrap;
}
.week-line { flex: 1; height: 1px; background: var(--border); }

/* EMPTY STATE */
.empty-state { text-align: center; padding: 60px 20px; color: var(--ink-faint); }
.empty-state i { font-size: 36px; margin-bottom: 12px; display: block; }
.empty-state p { font-size: 14px; }

/* Hidden print-only elements */
.print-doc-header,
.print-week-header,
.print-single-header,
.print-footer,
.rpt-single { display: none; }

/* ============================================================
   PRINT STYLES — PROFESSIONAL REPORT
   ============================================================ */
@media print {

    @page {
        size: A4 portrait;
        margin: 20mm 18mm 24mm 18mm;
    }

    /* Reset visibility */
    body * { visibility: hidden; }

    /* Single program mode */
    body.print-single .rpt-single,
    body.print-single .rpt-single * { visibility: visible; }
    body.print-single .rpt-single {
        display: block !important;
        position: fixed; top: 0; left: 0; width: 100%;
    }

    /* Monthly / weekly / all mode */
    body.print-monthly .rpt-region,
    body.print-monthly .rpt-region *,
    body.print-weekly .rpt-region,
    body.print-weekly .rpt-region * { visibility: visible; }

    body.print-monthly .rpt-region,
    body.print-weekly .rpt-region {
        position: fixed; top: 0; left: 0; width: 100%;
    }

    /* Force expand all */
    .prog-body { display: block !important; }

    /* Hide UI controls */
    .toolbar, .page-head, .page-head-buttons,
    .btn-print-single, .toggle-chevron, .print-dropdown,
    .summary-strip, .week-divider, .prog-icon, .prog-actions {
        display: none !important;
    }

    /* ── LETTERHEAD ── */
    .print-doc-header {
        display: block !important;
        visibility: visible !important;
        margin-bottom: 0;
    }

    .rpt-letterhead {
        display: flex !important;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 10pt;
        border-bottom: 2pt solid #0d1117;
        margin-bottom: 0;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .rpt-org-name {
        font-family: Georgia, serif;
        font-size: 13pt;
        font-weight: 700;
        color: #0d1117;
        letter-spacing: .3px;
    }

    .rpt-dept-name {
        font-size: 9.5pt;
        color: #4a5568;
        margin-top: 2pt;
    }

    .rpt-logo-box {
        width: 40pt; height: 40pt;
        border: 1.5pt solid #0d1117;
        border-radius: 4pt;
        display: flex !important;
        align-items: center;
        justify-content: center;
        font-size: 17pt;
        color: #0d1117;
    }

    /* ── TITLE BLOCK ── */
    .rpt-title-block {
        margin-top: 12pt;
        padding-bottom: 10pt;
        border-bottom: 0.75pt solid #cbd5e1;
        margin-bottom: 10pt;
    }

    .rpt-report-label {
        font-size: 7.5pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #94a3b8;
    }

    .rpt-report-title {
        font-family: Georgia, serif;
        font-size: 19pt;
        font-weight: 700;
        color: #0d1117;
        line-height: 1.2;
        margin-top: 3pt;
    }

    .rpt-meta-row {
        display: flex !important;
        gap: 22pt;
        margin-top: 10pt;
        flex-wrap: wrap;
    }

    .rpt-meta-label {
        font-size: 7pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
    }

    .rpt-meta-value {
        font-size: 9pt;
        color: #0d1117;
        font-weight: 600;
        margin-top: 2pt;
    }

    /* ── SUMMARY TABLE ── */
    .print-summary-table {
        display: table !important;
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14pt;
        font-size: 8.5pt;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-summary-table th {
        background: #1e40af !important;
        color: #ffffff !important;
        font-size: 7.5pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
        padding: 5pt 10pt;
        text-align: left;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-summary-table td {
        border: 0.5pt solid #cbd5e1;
        padding: 5pt 10pt;
        color: #334155;
        font-size: 8.5pt;
    }

    .print-summary-table tr:nth-child(even) td {
        background: #f8fafc !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-summary-table td:first-child { font-weight: 600; color: #0d1117; }

    /* ── WEEK SECTION HEADER ── */
    .print-week-header {
        display: block !important;
        visibility: visible !important;
        font-size: 8pt;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #ffffff !important;
        background: #1e3a8a !important;
        padding: 5pt 10pt;
        margin: 14pt 0 6pt;
        break-after: avoid;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* ── PROGRAM CARD ── */
    .prog-card {
        box-shadow: none !important;
        border: 0.75pt solid #cbd5e1 !important;
        border-radius: 0 !important;
        transform: none !important;
        break-inside: avoid;
        margin-bottom: 8pt;
        overflow: visible !important;
    }

    .prog-card::before { display: none !important; }

    .prog-header {
        padding: 7pt 10pt !important;
        cursor: default;
        border-bottom: 0.75pt solid #e2e8f0;
        background: #f8fafc !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .prog-title {
        font-family: Georgia, serif !important;
        font-size: 10.5pt !important;
        font-weight: 700 !important;
        color: #0d1117 !important;
    }

    .meta-item {
        font-size: 7.5pt !important;
        color: #64748b !important;
    }

    .status-badge {
        font-size: 6.5pt !important;
        padding: 2pt 6pt !important;
        border-radius: 3pt !important;
        font-weight: 700 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* ── COMMITTEE TABLE ── */
    .prog-table-wrap { overflow: visible !important; }

    .prog-table { font-size: 8.5pt !important; width: 100% !important; }

    .prog-table thead th {
        background: #f1f5f9 !important;
        color: #475569 !important;
        font-size: 7pt !important;
        padding: 5pt 8pt !important;
        border-bottom: 1pt solid #cbd5e1 !important;
        border-right: 0.5pt solid #e2e8f0 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .prog-table tbody td {
        padding: 5pt 8pt !important;
        border-bottom: 0.5pt solid #e2e8f0 !important;
        border-right: 0.5pt solid #f1f5f9 !important;
        color: #334155 !important;
        font-size: 8.5pt !important;
    }

    .prog-table tbody tr:last-child td { border-bottom: none !important; }

    .prog-table tbody tr:nth-child(even) td {
        background: #f9fafb !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .lead-badge {
        font-size: 6pt !important;
        padding: 1pt 4pt !important;
        background: #fef3c7 !important;
        color: #92400e !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    /* ── FOOTER ── */
    .print-footer {
        display: flex !important;
        visibility: visible !important;
        position: fixed;
        bottom: 0; left: 0; right: 0;
        border-top: 0.75pt solid #cbd5e1;
        padding: 5pt 0 0;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .print-footer-left   { font-size: 7pt; color: #64748b; }
    .print-footer-center { font-size: 7pt; color: #94a3b8; text-align: center; font-style: italic; }
    .print-footer-right  { font-size: 7pt; color: #64748b; }

}
/* end @media print */

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 600px) {
    .prog-title  { font-size: 14.5px; }
    .prog-header { padding: 14px 14px; }
    .prog-table  { font-size: 12px; }
    .prog-actions { flex-wrap: wrap; }
}
</style>
@endpush


@section('content')

{{-- PAGE HEADER --}}
<div class="page-head">
    <div class="page-head-left">
        <h1>Programs</h1>
        <p>{{ $departmentName }} &mdash; {{ $selectedYear }}{{ $selectedMonth ? ', '.date('F', mktime(0,0,0,$selectedMonth,1)) : '' }}</p>
    </div>

    <div class="page-head-buttons">
        <form method="GET" class="toolbar" id="filterForm">

            <select name="year" onchange="document.getElementById('filterForm').submit()">
                @foreach($yearOptions as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>

            <select name="month" onchange="document.getElementById('filterForm').submit()">
                <option value="">All Months</option>
                @foreach($monthOptions as $month)
                    <option value="{{ $month['value'] }}" {{ $selectedMonth == $month['value'] ? 'selected' : '' }}>
                        {{ $month['label'] }}
                    </option>
                @endforeach
            </select>

            <div class="print-dropdown" id="printDropdown">
                <button type="button" class="btn btn-dark" onclick="togglePrintMenu()">
                    <i class="fa fa-print"></i> Print Report
                    <i class="fa fa-chevron-down" style="font-size:10px;margin-left:2px;"></i>
                </button>
                <div class="print-menu" id="printMenu">
                    <button onclick="printAll()">
                        <i class="fa fa-list"></i> All Programs
                    </button>
                    <button onclick="printMonthly()">
                        <i class="fa fa-calendar-days"></i> Monthly Report
                    </button>
                    <button onclick="printWeekly()">
                        <i class="fa fa-calendar-week"></i> Weekly Breakdown
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

{{-- SUMMARY CHIPS --}}
@php
    $countUpcoming  = $programs->where('status','upcoming')->count();
    $countOngoing   = $programs->where('status','ongoing')->count();
    $countCompleted = $programs->where('status','completed')->count();
@endphp

<div class="summary-strip">
    <div class="summary-chip"><span class="chip-dot dot-upcoming"></span>{{ $countUpcoming }} Upcoming</div>
    <div class="summary-chip"><span class="chip-dot dot-ongoing"></span>{{ $countOngoing }} Ongoing</div>
    <div class="summary-chip"><span class="chip-dot dot-completed"></span>{{ $countCompleted }} Completed</div>
    <div class="summary-chip">
        <i class="fa fa-layer-group" style="color:var(--ink-faint);font-size:11px;"></i>
        {{ $programs->count() }} Total
    </div>
</div>


{{-- ============================================================
     PRINTABLE REGION  (monthly / weekly / all modes)
     ============================================================ --}}
<div class="rpt-region" id="rptRegion">

    {{-- ── PRINT LETTERHEAD & TITLE (hidden on screen) ── --}}
    <div class="print-doc-header" id="printDocHeader">

        <div class="rpt-letterhead">
            <div class="rpt-org-block">
                <div class="rpt-org-name">Your Organisation</div>
                <div class="rpt-dept-name">{{ $departmentName }}</div>
            </div>
            <div class="rpt-logo-box"><i class="fa fa-building"></i></div>
        </div>

        <div class="rpt-title-block">
            <div class="rpt-report-label">Official Report</div>
            <div class="rpt-report-title" id="rptTitle">Program Report</div>
            <div class="rpt-meta-row">
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Period</div>
                    <div class="rpt-meta-value" id="rptPeriod">{{ $selectedYear }}</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Department</div>
                    <div class="rpt-meta-value">{{ $departmentName }}</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Programs</div>
                    <div class="rpt-meta-value" id="rptCount">{{ $programs->count() }}</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Printed On</div>
                    <div class="rpt-meta-value" id="rptDate">—</div>
                </div>
            </div>
        </div>

        <table class="print-summary-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Upcoming</td><td>{{ $countUpcoming }}</td></tr>
                <tr><td>Ongoing</td><td>{{ $countOngoing }}</td></tr>
                <tr><td>Completed</td><td>{{ $countCompleted }}</td></tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ $programs->count() }}</strong></td>
                </tr>
            </tbody>
        </table>

    </div>{{-- /print-doc-header --}}


    @if($programs->isEmpty())
        <div class="empty-state">
            <i class="fa fa-calendar-xmark"></i>
            <p>No programs found for the selected period.</p>
        </div>
    @else

        <div class="prog-list" id="progList">

            @foreach($grouped as $weekLabel => $weekPrograms)

                {{-- SCREEN: week divider --}}
                <div class="week-divider">
                    <span class="week-label">
                        <i class="fa fa-calendar-week" style="margin-right:5px;"></i>{{ $weekLabel }}
                    </span>
                    <span class="week-line"></span>
                    <span class="week-label" style="font-size:10px;">{{ $weekPrograms->count() }} prog.</span>
                    <button type="button" class="btn-print-single"
                        onclick="printWeek('{{ addslashes($weekLabel) }}')">
                        <i class="fa fa-print"></i> Print Week
                    </button>
                </div>

                {{-- PRINT: week section header --}}
                <div class="print-week-header" data-week-label="{{ $weekLabel }}">
                    Week: {{ $weekLabel }} &nbsp;&mdash;&nbsp; {{ $weekPrograms->count() }} program(s)
                </div>

                @foreach($weekPrograms as $program)
                <div class="prog-card status-{{ $program->status }}"
                     id="card-{{ $program->id }}"
                     data-week="{{ $weekLabel }}"
                     data-status="{{ $program->status }}">

                    <div class="prog-header" onclick="toggleCard({{ $program->id }})">

                        <div class="prog-icon">
                            @if($program->status === 'ongoing')
                                <i class="fa fa-spinner fa-spin"></i>
                            @elseif($program->status === 'completed')
                                <i class="fa fa-circle-check"></i>
                            @else
                                <i class="fa fa-calendar-plus"></i>
                            @endif
                        </div>

                        <div class="prog-info">
                            <div class="prog-title">{{ $program->title }}</div>
                            <div class="prog-meta">
                                <span class="meta-item">
                                    <i class="fa fa-calendar-range"></i>
                                    {{ $program->start_date->format('d M Y') }} &mdash; {{ $program->end_date->format('d M Y') }}
                                </span>
                                <span class="meta-item">
                                    <i class="fa fa-location-dot"></i>
                                    {{ $program->venue }}
                                </span>
                                <span class="meta-item">
                                    <i class="fa fa-users"></i>
                                    {{ $program->committee->count() }} members
                                </span>
                            </div>
                        </div>

                        <div class="prog-actions" onclick="event.stopPropagation()">
                            <span class="status-badge badge-{{ $program->status }}">
                                {{ ucfirst($program->status) }}
                            </span>
                            <button type="button" class="btn-print-single"
                                onclick="printSingle({{ $program->id }})">
                                <i class="fa fa-print"></i> Print
                            </button>
                            <i class="fa fa-chevron-down toggle-chevron"></i>
                        </div>

                    </div>

                    <div class="prog-body">
                        <div class="prog-table-wrap">
                            <table class="prog-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($program->committee->sortByDesc('pivot.is_lead') as $i => $member)
                                    <tr>
                                        <td style="color:var(--ink-faint);font-size:12px;">{{ $i + 1 }}</td>
                                        <td>
                                            {{ $member->name }}
                                            @if($member->pivot->is_lead)
                                                <span class="lead-badge">Lead</span>
                                            @endif
                                        </td>
                                        <td>{{ $roleLabels[$member->pivot->role] ?? ucfirst($member->pivot->role) }}</td>
                                        <td>{{ $member->position ?? '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr class="empty-row">
                                        <td colspan="4">No committee assigned yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>{{-- /.prog-card --}}
                @endforeach

            @endforeach

        </div>{{-- /.prog-list --}}

    @endif

    <div class="print-footer">
        <span class="print-footer-left">{{ $departmentName }}</span>
        <span class="print-footer-center">CONFIDENTIAL &mdash; For Internal Use Only</span>
        <span class="print-footer-right">Printed: <span id="printDate">—</span></span>
    </div>

</div>{{-- /.rpt-region --}}


{{-- ============================================================
     SINGLE-PROGRAM PRINT WRAPPER  (separate DOM island)
     ============================================================ --}}
<div class="rpt-single" id="rptSingle">

    <div class="print-doc-header print-single-header">

        <div class="rpt-letterhead">
            <div class="rpt-org-block">
                <div class="rpt-org-name">Your Organisation</div>
                <div class="rpt-dept-name">{{ $departmentName }}</div>
            </div>
            <div class="rpt-logo-box"><i class="fa fa-building"></i></div>
        </div>

        <div class="rpt-title-block">
            <div class="rpt-report-label">Program Report</div>
            <div class="rpt-report-title" id="singleTitle">—</div>
            <div class="rpt-meta-row">
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Dates</div>
                    <div class="rpt-meta-value" id="singleDates">—</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Venue</div>
                    <div class="rpt-meta-value" id="singleVenue">—</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Status</div>
                    <div class="rpt-meta-value" id="singleStatus">—</div>
                </div>
                <div class="rpt-meta-item">
                    <div class="rpt-meta-label">Printed On</div>
                    <div class="rpt-meta-value" id="singleDate">—</div>
                </div>
            </div>
        </div>

    </div>

    <div id="singleTableSlot"></div>

    <div class="print-footer">
        <span class="print-footer-left">{{ $departmentName }}</span>
        <span class="print-footer-center">CONFIDENTIAL &mdash; For Internal Use Only</span>
        <span class="print-footer-right">Printed: <span id="singlePrintDate">—</span></span>
    </div>

</div>{{-- /.rpt-single --}}


@push('scripts')
<script>
/* ── Globals ──────────────────────────────────────────────── */
const BODY      = document.body;
const printMenu = document.getElementById('printMenu');
const DEPT      = @json($departmentName);
const YEAR      = @json((string) $selectedYear);
const MONTH_NUM = @json($selectedMonth ?? '');

function pad(n){ return String(n).padStart(2,'0'); }
function todayStr(){
    const d = new Date();
    return `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()}`;
}
const TODAY = todayStr();

/* Stamp dates */
['printDate','rptDate','singleDate','singlePrintDate'].forEach(id => {
    const el = document.getElementById(id);
    if(el) el.textContent = TODAY;
});

/* ── Print menu ───────────────────────────────────────────── */
function togglePrintMenu(){ printMenu.classList.toggle('open'); }
document.addEventListener('click', e => {
    if(!document.getElementById('printDropdown').contains(e.target))
        printMenu.classList.remove('open');
});

/* ── Card toggle ──────────────────────────────────────────── */
function toggleCard(id){
    document.getElementById('card-'+id).classList.toggle('is-open');
}
function expandAll(){
    document.querySelectorAll('.prog-card').forEach(c => c.classList.add('is-open'));
}

/* ── Month name ───────────────────────────────────────────── */
function monthName(m){
    return ['','January','February','March','April','May','June',
            'July','August','September','October','November','December'][parseInt(m)] || '';
}

/* ── Shared pre-print setup ──────────────────────────────── */
function prepRegion(title, period, count){
    expandAll();
    document.getElementById('rptTitle').textContent  = title;
    document.getElementById('rptPeriod').textContent = period;
    document.getElementById('rptCount').textContent  = count;
    document.getElementById('rptDate').textContent   = TODAY;
}

/* ── Print: all ───────────────────────────────────────────── */
function printAll(){
    printMenu.classList.remove('open');
    showAllWeekHeaders();
    const total = document.querySelectorAll('.prog-card').length;
    prepRegion('All Programs Report',
               YEAR + (MONTH_NUM ? ' · ' + monthName(MONTH_NUM) : ''),
               total);
    doPrint('print-monthly');
}

/* ── Print: monthly ──────────────────────────────────────── */
function printMonthly(){
    printMenu.classList.remove('open');
    if(!MONTH_NUM){ alert('Please select a month first.'); return; }
    showAllWeekHeaders();
    const total = document.querySelectorAll('.prog-card').length;
    prepRegion(monthName(MONTH_NUM) + ' ' + YEAR + ' — Program Report',
               monthName(MONTH_NUM) + ' ' + YEAR,
               total);
    doPrint('print-monthly');
}

/* ── Print: weekly breakdown ─────────────────────────────── */
function printWeekly(){
    printMenu.classList.remove('open');
    showAllWeekHeaders();
    const total = document.querySelectorAll('.prog-card').length;
    prepRegion('Weekly Program Breakdown',
               YEAR + (MONTH_NUM ? ' · ' + monthName(MONTH_NUM) : ''),
               total);
    doPrint('print-weekly');
}

/* ── Print: single week ──────────────────────────────────── */
function printWeek(weekLabel){
    /* hide other cards + week headers */
    document.querySelectorAll('.prog-card').forEach(c => {
        c.style.display = c.dataset.week === weekLabel ? '' : 'none';
    });
    document.querySelectorAll('.print-week-header').forEach(h => {
        h.style.display = h.dataset.weekLabel === weekLabel ? '' : 'none';
    });

    const visible = document.querySelectorAll('.prog-card:not([style*="none"])').length;
    prepRegion('Week: ' + weekLabel, weekLabel, visible);
    doPrint('print-weekly');

    /* restore */
    document.querySelectorAll('.prog-card').forEach(c => c.style.display = '');
    document.querySelectorAll('.print-week-header').forEach(h => h.style.display = '');
}

/* ── Print: single program ───────────────────────────────── */
function printSingle(id){
    const card = document.getElementById('card-'+id);

    /* Pull metadata from the card's DOM */
    const title  = card.querySelector('.prog-title')?.textContent?.trim() || '—';
    const metas  = card.querySelectorAll('.meta-item');
    const dates  = metas[0]?.textContent?.trim() || '—';
    const venue  = metas[1]?.textContent?.trim() || '—';
    const status = card.dataset.status
        ? card.dataset.status[0].toUpperCase() + card.dataset.status.slice(1)
        : '—';

    document.getElementById('singleTitle').textContent  = title;
    document.getElementById('singleDates').textContent  = dates;
    document.getElementById('singleVenue').textContent  = venue;
    document.getElementById('singleStatus').textContent = status;
    document.getElementById('singleDate').textContent   = TODAY;
    document.getElementById('singlePrintDate').textContent = TODAY;

    /* Clone committee table */
    const slot = document.getElementById('singleTableSlot');
    slot.innerHTML = '';
    const tw = card.querySelector('.prog-table-wrap');
    if(tw) slot.appendChild(tw.cloneNode(true));

    doPrint('print-single');
    slot.innerHTML = '';
}

/* ── Core print + cleanup ────────────────────────────────── */
function doPrint(mode){
    BODY.className = mode;
    window.print();
    BODY.className = '';
}

function showAllWeekHeaders(){
    document.querySelectorAll('.print-week-header').forEach(h => h.style.display = '');
}

window.addEventListener('afterprint', () => { BODY.className = ''; });
</script>
@endpush

@endsection
