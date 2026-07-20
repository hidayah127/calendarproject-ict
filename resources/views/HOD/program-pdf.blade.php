<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Program Report - {{ $program->title }}</title>
<style>
   
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

    .paper {
        max-width: 900px;
        margin: 24px auto 60px;
        background: #fff;
        padding: 28px 32px 46px;
        box-shadow: 0 4px 24px rgba(15,45,110,0.12);
        border-radius: 10px;
    }

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

    .header-table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
    .header-table td { vertical-align: middle; }
    .brand-name { font-size: 19px; font-weight: bold; color: #0f2d6e; }
    .brand-sub { font-size: 10.5px; color: #64748b; margin-top: 1px; }
    .header-right { text-align: right; }
    .report-title { font-size: 14px; font-weight: bold; color: #1a56db; }
    .report-period { font-size: 10.5px; color: #64748b; margin-top: 1px; }
    .divider { border-bottom: 2px solid #1a56db; margin: 8px 0 12px 0; }

    /* ── Program title block ── */
    .program-title-row { display: table; width: 100%; margin-bottom: 4px; }
    .program-name { font-size: 17px; font-weight: bold; color: #0f2d6e; }
    .program-dept { font-size: 10.5px; color: #64748b; margin-top: 2px; }

    .badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: bold;
    }
    .badge-upcoming    { background: #dbeafe; color: #1d4ed8; }
    .badge-ongoing     { background: #dcfce7; color: #15803d; }
    .badge-completed   { background: #e2e8f0; color: #334155; }
    .badge-cancelled   { background: #fee2e2; color: #b91c1c; }
    .badge-rescheduled { background: #fef9c3; color: #b45309; }
    .badge-pending     { background: #fef9c3; color: #b45309; }
    .badge-approved    { background: #dcfce7; color: #15803d; }
    .badge-rejected    { background: #fee2e2; color: #b91c1c; }
    .badge-lead        { background: #fef3c7; color: #92400e; }

    /* ── Detail grid (table-based, 2 columns) ── */
    .detail-table { width: 100%; border-collapse: collapse; margin: 14px 0; }
    .detail-table td { padding: 8px 12px; background: #f8faff; font-size: 10.5px; vertical-align: top; }
    .detail-label { color: #64748b; font-size: 8.5px; text-transform: uppercase; font-weight: bold; letter-spacing: .4px; display: block; margin-bottom: 2px; }

    .section-title {
        font-size: 11.5px;
        font-weight: bold;
        color: #0f2d6e;
        border-bottom: 1px solid #dde6ff;
        padding-bottom: 4px;
        margin: 18px 0 8px 0;
    }
    .description-box { font-size: 10.5px; color: #334155; line-height: 1.6; }

    table.data { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
    table.data thead { display: table-header-group; }
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

    .empty-note { text-align: center; color: #94a3b8; font-size: 10px; padding: 16px 0; }

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

    @media print {
        .print-toolbar { display: none !important; }
        html, body { background: #fff; }
        .paper { max-width: none; margin: 0; padding: 0 0 34px; box-shadow: none; border-radius: 0; }
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
    AmazingTrack &middot; Program Report &middot; Generated {{ $generatedAt->format('d M Y, h:i A') }}
</div>

{{-- ═══════════════ HEADER ═══════════════ --}}
<table class="header-table">
    <tr>
        <td>
            <div class="brand-name">AmazingTrack</div>
            <div class="brand-sub">Program &amp; Committee Tracking System</div>
        </td>
        <td class="header-right">
            <div class="report-title">Program Report</div>
            <div class="report-period">Prepared by {{ $leaderName }}</div>
        </td>
    </tr>
</table>
<div class="divider"></div>

{{-- ═══════════════ PROGRAM TITLE ═══════════════ --}}
<table class="header-table">
    <tr>
        <td>
            <div class="program-name">{{ $program->title }}</div>
            <div class="program-dept">{{ optional($program->department)->name ?? '—' }}</div>
        </td>
        <td class="header-right">
            <span class="badge badge-{{ $program->status }}">{{ ucfirst($program->status) }}</span>
        </td>
    </tr>
</table>

{{-- ═══════════════ DETAILS ═══════════════ --}}
<table class="detail-table">
    <tr>
        <td style="width:25%;"><span class="detail-label">Category</span>{{ ucfirst($program->category ?? '—') }}</td>
        <td style="width:25%;"><span class="detail-label">Venue</span>{{ $program->venue }}</td>
        <td style="width:25%;"><span class="detail-label">Start</span>{{ \Carbon\Carbon::parse($program->start_date)->format('d M Y, h:i A') }}</td>
        <td style="width:25%;"><span class="detail-label">End</span>{{ \Carbon\Carbon::parse($program->end_date)->format('d M Y, h:i A') }}</td>
    </tr>
    <tr>
        <td colspan="2"><span class="detail-label">Staff In Charge</span>{{ optional($program->staffInCharge)->name ?? '—' }}</td>
        <td colspan="2"><span class="detail-label">Committee Size</span>{{ $program->committee->count() }} member{{ $program->committee->count() === 1 ? '' : 's' }}</td>
    </tr>
</table>

{{-- ═══════════════ DESCRIPTION ═══════════════ --}}
<div class="section-title">Description</div>
<div class="description-box">{{ $program->description }}</div>

{{-- ═══════════════ COMMITTEE ═══════════════ --}}
<div class="section-title">Committee ({{ $program->committee->count() }})</div>
@if($program->committee->count())
<table class="data">
    <thead>
        <tr>
            <th>Staff</th>
            <th>Position</th>
            <th>Role</th>
            <th>Responsibility</th>
        </tr>
    </thead>
    <tbody>
        @foreach($program->committee as $member)
        <tr>
            <td>
                {{ $member->name }}
                @if($member->pivot->is_lead)
                    <span class="badge badge-lead">Lead</span>
                @endif
            </td>
            <td>{{ $member->position ?? '—' }}</td>
            <td>{{ str_replace('_', ' ', ucfirst($member->pivot->role)) }}</td>
            <td>{{ $member->pivot->responsibility ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty-note">No committee members assigned to this program.</div>
@endif

{{-- ═══════════════ MERIT CLAIMS ═══════════════ --}}
<div class="section-title">Merit Claims ({{ $meritClaims->count() }})</div>
@if($meritClaims->count())
<table class="data">
    <thead>
        <tr>
            <th>Staff</th>
            <th>Claim Type</th>
            <th>Points</th>
            <th>Status</th>
            <th>Reviewed</th>
        </tr>
    </thead>
    <tbody>
        @foreach($meritClaims as $claim)
        <tr>
            <td>{{ optional($claim->staff)->name ?? '—' }}</td>
            <td>{{ str_replace('_', ' ', ucfirst($claim->claim_type)) }}</td>
            <td>{{ $claim->merit_points }}</td>
            <td><span class="badge badge-{{ $claim->status }}">{{ ucfirst($claim->status) }}</span></td>
            <td>{{ $claim->reviewed_at ? \Carbon\Carbon::parse($claim->reviewed_at)->format('d M Y') : 'Pending' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="empty-note">No merit claims submitted for this program yet.</div>
@endif

</div>{{-- /.paper --}}

</body>
</html>
