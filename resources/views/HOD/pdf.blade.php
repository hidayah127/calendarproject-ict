<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Monthly Program Report - {{ $monthLabel }}</title>
<style>
    /*
        Zero-dependency PDF: this is a normal HTML page rendered by the
        browser, not run through a PHP PDF library. The "Print / Save as PDF"
        button below calls window.print() — every modern browser's print
        dialog has a "Save as PDF" destination, so no server-side PDF
        generator is needed at all.

        The stylesheet is still plain tables + inline-block with no CSS
        variables (kept from the original dompdf-safe version) since that
        renders identically well in a real browser AND happens to be exactly
        what print stylesheets want anyway — flexbox/grid are fine for the
        on-screen "paper" wrapper, but the report body itself stays table-based
        so a repeating <thead> and page-break-inside:avoid rows behave
        predictably when the browser paginates it for print.
    */
    @page {
        size: A4;
        margin: 16mm 14mm 20mm 14mm;
    }
    * { box-sizing: border-box; }
    html, body {
        margin: 0;
        background: #e2e8f0;
        font-family: Helvetica, Arial, sans-serif;
        color: #1e293b;
        font-size: 11px;
        line-height: 1.4;
    }

    /* ── On-screen "paper" preview — reset for print below ── */
    .paper {
        max-width: 900px;
        margin: 24px auto 60px;
        background: #fff;
        padding: 28px 32px 46px;
        box-shadow: 0 4px 24px rgba(15,45,110,0.12);
        border-radius: 10px;
    }

    /* ── Print toolbar (screen only) ── */
    .print-toolbar {
        max-width: 900px;
        margin: 16px auto 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 4px;
    }
    .print-toolbar .hint { font-size: 12.5px; color: #64748b; }
    .print-btn {
        background: linear-gradient(135deg, #0f2d6e, #1a56db);
        color: #fff;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(26,86,219,0.3);
    }
    .print-btn:hover { opacity: 0.92; }

    /* ── Header ── */
    .header-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
    .header-table td { vertical-align: middle; }
    .brand-name { font-size: 19px; font-weight: bold; color: #0f2d6e; }
    .brand-sub { font-size: 10.5px; color: #64748b; margin-top: 1px; }
    .header-right { text-align: right; }
    .report-title { font-size: 14px; font-weight: bold; color: #1a56db; }
    .report-period { font-size: 10.5px; color: #64748b; margin-top: 1px; }

    .divider { border-bottom: 2px solid #1a56db; margin: 8px 0 12px 0; }

    /* ── Meta bar ── */
    .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    .meta-table td {
        background: #eef2ff;
        padding: 8px 12px;
        font-size: 10px;
        color: #334155;
    }
    .meta-label { color: #64748b; font-size: 8.5px; text-transform: uppercase; font-weight: bold; letter-spacing: .4px; display: block; margin-bottom: 2px; }

    /* ── Section titles ── */
    .section-title {
        font-size: 11.5px;
        font-weight: bold;
        color: #0f2d6e;
        border-bottom: 1px solid #dde6ff;
        padding-bottom: 4px;
        margin: 18px 0 8px 0;
    }

    /* ── Summary stat grid ── */
    .stats-table { width: 100%; border-collapse: separate; border-spacing: 4px; }
    .stat-box {
        width: 14.28%;
        background: #f8faff;
        border: 1px solid #dde6ff;
        border-radius: 6px;
        padding: 9px 4px;
        text-align: center;
    }
    .stat-num { font-size: 16px; font-weight: bold; color: #1a56db; }
    .stat-lbl { font-size: 7.5px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: .2px; margin-top: 2px; }

    /* ── Data tables ── */
    table.data { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    table.data thead { display: table-header-group; } /* repeats header on each printed page */
    table.data th {
        background: #eef2ff;
        color: #475569;
        font-size: 8.5px;
        text-transform: uppercase;
        letter-spacing: .3px;
        text-align: left;
        padding: 6px 8px;
        border-bottom: 2px solid #dde6ff;
    }
    table.data td {
        padding: 6px 8px;
        font-size: 9.5px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: top;
    }
    table.data tr { page-break-inside: avoid; }
    table.data tbody tr:nth-child(even) td { background: #f8faff; }

    .badge {
        display: inline-block;
        padding: 2px 7px;
        border-radius: 8px;
        font-size: 8px;
        font-weight: bold;
    }
    .badge-upcoming    { background: #dbeafe; color: #1d4ed8; }
    .badge-ongoing     { background: #dcfce7; color: #15803d; }
    .badge-completed   { background: #e2e8f0; color: #334155; }
    .badge-cancelled   { background: #fee2e2; color: #b91c1c; }
    .badge-rescheduled { background: #fef9c3; color: #b45309; }

    .empty-note { text-align: center; color: #94a3b8; font-size: 10px; padding: 16px 0; }

    /* ── Footer (repeats on every printed page) ── */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0; right: 0;
        text-align: center;
        font-size: 8px;
        color: #94a3b8;
        border-top: 1px solid #e2e8f0;
        padding: 5px 0;
        background: #fff;
    }

    /* ── Print mode: strip the screen chrome, let @page own the margins ── */
    @media print {
        .print-toolbar { display: none !important; }
        html, body { background: #fff; }
        .paper {
            max-width: none;
            margin: 0;
            padding: 0 0 34px;
            box-shadow: none;
            border-radius: 0;
        }
    }
</style>
</head>
<body>

<div class="print-toolbar">
    <span class="hint"><i>Use your browser's print dialog and choose "Save as PDF" as the destination.</i></span>
    <button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>

<div class="paper">

<div class="footer">
    AmazingTrack &middot; Leader Monthly Program Report &middot; Generated {{ $generatedAt->format('d M Y, h:i A') }}
</div>

{{-- ═══════════════ HEADER ═══════════════ --}}
<table class="header-table">
    <tr>
        <td>
            <div class="brand-name">AmazingTrack</div>
            <div class="brand-sub">Program &amp; Committee Tracking System</div>
        </td>
        <td class="header-right">
            <div class="report-title">Monthly Program Report</div>
            <div class="report-period">{{ $monthLabel }}</div>
        </td>
    </tr>
</table>
<div class="divider"></div>

{{-- ═══════════════ META BAR ═══════════════ --}}
<table class="meta-table">
    <tr>
        <td style="width:40%;">
            <span class="meta-label">Department(s) Covered</span>
            {{ $departmentNames->implode(', ') ?: '—' }}
        </td>
        <td style="width:30%;">
            <span class="meta-label">Prepared By</span>
            {{ $leaderName }}
        </td>
        <td style="width:30%;">
            <span class="meta-label">Report Period</span>
            {{ $monthLabel }}
        </td>
    </tr>
</table>

{{-- ═══════════════ SUMMARY ═══════════════ --}}
<div class="section-title">Summary</div>
<table class="stats-table">
    <tr>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['total'] }}</div>
            <div class="stat-lbl">Total Programs</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['completed'] }}</div>
            <div class="stat-lbl">Completed</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['rescheduled'] }}</div>
            <div class="stat-lbl">Rescheduled</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['cancelled'] }}</div>
            <div class="stat-lbl">Cancelled</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['staff_involved'] }}</div>
            <div class="stat-lbl">Staff Involved</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $summary['merit_points'] }}</div>
            <div class="stat-lbl">Merit Points</div>
        </td>
        <td class="stat-box">
            <div class="stat-num">{{ $departmentNames->count() }}</div>
            <div class="stat-lbl">Departments</div>
        </td>
    </tr>
</table>

{{-- ═══════════════ DEPARTMENT BREAKDOWN ═══════════════ --}}
<div class="section-title">Breakdown By Department</div>
@if(count($breakdown))
<table class="data">
    <thead>
        <tr>
            <th>Department</th>
            <th>Total</th>
            <th>Completed</th>
            <th>Ongoing / Upcoming</th>
            <th>Rescheduled</th>
            <th>Cancelled</th>
        </tr>
    </thead>
    <tbody>
        @foreach($breakdown as $row)
        <tr>
            <td><strong>{{ $row['name'] }}</strong></td>
            <td>{{ $row['total'] }}</td>
            <td>{{ $row['completed'] }}</td>
            <td>{{ $row['active'] }}</td>
            <td>{{ $row['rescheduled'] }}</td>
            <td>{{ $row['cancelled'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty-note">No departments to report on.</div>
@endif

{{-- ═══════════════ PROGRAM LISTING ═══════════════ --}}
<div class="section-title">Programs This Month ({{ $programs->count() }})</div>
@if($programs->count())
<table class="data">
    <thead>
        <tr>
            <th style="width:20%;">Title</th>
            <th style="width:13%;">Department</th>
            <th style="width:10%;">Category</th>
            <th style="width:15%;">Venue</th>
            <th style="width:13%;">Start</th>
            <th style="width:13%;">End</th>
            <th style="width:11%;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
        <tr>
            <td>{{ $program->title }}</td>
            <td>{{ optional($program->department)->code ?? optional($program->department)->name ?? '—' }}</td>
            <td>{{ ucfirst($program->category ?? '—') }}</td>
            <td>{{ $program->venue }}</td>
            <td>{{ \Carbon\Carbon::parse($program->start_date)->format('d M, h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($program->end_date)->format('d M, h:i A') }}</td>
            <td><span class="badge badge-{{ $program->status }}">{{ ucfirst($program->status) }}</span></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty-note">No programs were scheduled in this period.</div>
@endif

</div>{{-- /.paper --}}

</body>
</html>
