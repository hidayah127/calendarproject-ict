<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $staff->name }} — AmazingTrack Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
/* ─── Tokens ─────────────────────────────────────────────── */
:root {
    --navy:    #0a1628;
    --ink:     #111827;
    --blue:    #1847f0;
    --blue-lt: #e8effe;
    --blue-md: #c7d7fc;
    --gold:    #f0a500;
    --gold-lt: #fef4dc;
    --green:   #0f9960;
    --green-lt:#dff4ec;
    --red:     #d93025;
    --red-lt:  #fde8e7;
    --amber:   #c27c0e;
    --amber-lt:#fef3dc;
    --muted:   #6b7280;
    --border:  #e5e9f0;
    --surface: #ffffff;
    --bg:      #f4f6fb;
    --radius:  14px;
    --radius-sm:9px;
    --shadow:  0 1px 4px rgba(0,0,0,.06), 0 4px 20px rgba(0,0,0,.06);
    --shadow-hover: 0 2px 8px rgba(0,0,0,.08), 0 8px 30px rgba(0,0,0,.10);
}

*, *::before, *::after { box-sizing: border-box; }

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--bg);
    color: var(--ink);
    font-size: 14.5px;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
}

::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--blue-md); border-radius: 99px; }

/* ─── Animations ─────────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fu { animation: fadeUp .4s ease both; }
.d1 { animation-delay: .05s; }
.d2 { animation-delay: .10s; }
.d3 { animation-delay: .15s; }
.d4 { animation-delay: .20s; }
.d5 { animation-delay: .25s; }

/* ─── Topbar ─────────────────────────────────────────────── */
/* .topbar {
    position: sticky;
    top: 0;
    z-index: 200;
    background: var(--navy);
    border-bottom: 1px solid rgba(255,255,255,.07);
    box-shadow: 0 2px 24px rgba(0,0,0,.25);
} */

.topbar {
    /* background: linear-gradient(
        90deg,
        #1E3A6D,
        #244A86
    ); */
    background: #162f5c; /* darker blue */
    
    border-bottom: 2px solid #ED1C24;
}

.topbar-inner {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 24px;
    height: 62px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.brand {
    display: flex;
    align-items: center;
    gap: 11px;
    text-decoration: none;
}
.brand-mark {
    background: rgba(255,255,255,0.95);
    border-radius: 8px;
    padding: 4px 8px;

    box-shadow: 0 2px 6px rgba(0,0,0,.15);
}

.brand-name {
    font-size: 15px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -.3px;
    line-height: 1.15;
}
.brand-sub {
    font-size: 10.5px;
    color: rgba(255,255,255,.4);
    font-weight: 400;
    letter-spacing: .2px;
}

.brand-logo {
    width: 100px;
    height: auto;
    object-fit: contain;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.merit-pill {
    display: flex;
    align-items: center;
    gap: 7px;
    background: rgba(240,165,0,.14);
    border: 1px solid rgba(240,165,0,.28);
    border-radius: 99px;
    padding: 6px 14px;
}
.merit-pill i { color: var(--gold); font-size: 13px; }
.merit-pill .val { font-size: 13.5px; font-weight: 800; color: #fff; }
.merit-pill .lbl { font-size: 10px; color: rgba(255,255,255,.45); margin-left: 1px; }

.staff-chip {
    display: flex;
    align-items: center;
    gap: 9px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 99px;
    padding: 5px 14px 5px 6px;
}
.staff-av {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--blue) 0%, #6c4ef0 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 800; color: #fff;
    flex-shrink: 0;
}
.staff-chip-name { font-size: 12.5px; font-weight: 700; color: #fff; }
.staff-chip-id   { font-size: 10px; color: rgba(255,255,255,.4); }

.btn-exit {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.14);
    border-radius: 99px;
    padding: 7px 16px;
    font-size: 12.5px;
    font-weight: 700;
    color: rgba(255,255,255,.75);
    text-decoration: none;
    transition: all .18s;
}
.btn-exit:hover { background: rgba(255,255,255,.15); color: #fff; text-decoration: none; }

/* ─── Layout ─────────────────────────────────────────────── */
.portal {
    max-width: 1160px;
    margin: 0 auto;
    padding: 28px 24px 60px;
}

/* ─── Flash messages ─────────────────────────────────────── */
.flash {
    display: flex;
    align-items: center;
    gap: 11px;
    border-radius: var(--radius);
    padding: 13px 18px;
    font-size: 13.5px;
    font-weight: 600;
    margin-bottom: 20px;
    border-width: 1px;
    border-style: solid;
}
.flash-success { background: var(--green-lt); border-color: #a7e8d0; color: var(--green); }
.flash-error   { background: var(--red-lt);   border-color: #f5b8b4; color: var(--red);   }
.flash i       { font-size: 16px; flex-shrink: 0; }

/* ─── Stat cards ─────────────────────────────────────────── */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
@media (max-width: 860px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 18px 18px 16px;
    box-shadow: var(--shadow);
    transition: box-shadow .2s, transform .2s;
    position: relative;
    overflow: hidden;
}
.stat-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--radius) var(--radius) 0 0;
}
.stat-card.gold::after    { background: var(--gold); }
.stat-card.greens::after  { background: var(--green); }
.stat-card.blues::after   { background: var(--blue); }
.stat-card.purples::after { background: #7c3aed; }

.stat-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }

.stat-icon {
    width: 38px; height: 38px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    margin-bottom: 14px;
}
.stat-val   { font-size: 2rem; font-weight: 900; color: var(--ink); line-height: 1; letter-spacing: -1px; }
.stat-label { font-size: 12px; color: var(--muted); font-weight: 500; margin-top: 4px; }

/* ─── Category summary ───────────────────────────────────── */
.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(148px, 1fr));
    gap: 12px;
}

.cat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: var(--shadow);
    transition: box-shadow .2s, transform .2s;
}
.cat-card:hover { box-shadow: var(--shadow-hover); transform: translateY(-2px); }

.cat-icon {
    width: 36px; height: 36px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}
.cat-val   { font-size: 1.45rem; font-weight: 900; color: var(--ink); line-height: 1; letter-spacing: -.5px; }
.cat-label { font-size: 11px; color: var(--muted); font-weight: 500; margin-top: 2px; }

/* ─── Section heading ────────────────────────────────────── */
.sec-head {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 14px;
    letter-spacing: -.3px;
}
.sec-head-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

/* ─── Panel (card wrapper) ───────────────────────────────── */
.panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 20px;
}
.panel-accent {
    height: 3px;
}
.panel-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
}
.panel-title {
    font-size: 13px;
    font-weight: 800;
    color: var(--ink);
    display: flex;
    align-items: center;
    gap: 8px;
}
.panel-count {
    font-size: 11px;
    background: var(--blue-lt);
    color: var(--blue);
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 99px;
}

/* ─── Search ─────────────────────────────────────────────── */
.search-wrap {
    position: relative;
    margin-bottom: 12px;
}
.search-wrap i {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
}
.search-wrap input {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 10px 14px 10px 37px;
    font-size: 13.5px;
    font-family: 'DM Sans', sans-serif;
    background: var(--surface);
    color: var(--ink);
    outline: none;
    transition: border-color .18s, box-shadow .18s;
}
.search-wrap input::placeholder { color: #b0b8c7; }
.search-wrap input:focus {
    border-color: var(--blue);
    box-shadow: 0 0 0 3px rgba(24,71,240,.10);
}

/* ─── Filter pills ───────────────────────────────────────── */
.pills {
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
    margin-bottom: 14px;
}
.pill {
    border: 1px solid var(--border);
    border-radius: 99px;
    padding: 5px 13px;
    font-size: 12px;
    font-weight: 700;
    color: var(--muted);
    background: var(--surface);
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all .16s;
}
.pill:hover, .pill.on {
    background: var(--blue-lt);
    border-color: var(--blue-md);
    color: var(--blue);
}

/* ─── Program item ───────────────────────────────────────── */
.prog-item {
    border-bottom: 1px solid var(--border);
}
.prog-item:last-child { border-bottom: none; }

.prog-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    padding: 15px 20px;
    cursor: pointer;
    transition: background .14s;
}
.prog-row:hover { background: #fafbff; }

.prog-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 6px;
}
.dot-upcoming    { background: var(--blue); }
.dot-ongoing     { background: var(--green); }
.dot-completed   { background: #7c3aed; }
.dot-rescheduled { background: var(--gold); }

.prog-name { font-size: 13.5px; font-weight: 700; color: var(--ink); }
.prog-meta {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 4px;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}
.prog-meta i { font-size: 10px; }

/* Status badges */
.sb {
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}
.sb-upcoming    { background: var(--blue-lt);  color: var(--blue);  }
.sb-ongoing     { background: var(--green-lt); color: var(--green); }
.sb-completed   { background: #ede9fe;         color: #5b21b6; }
.sb-rescheduled { background: var(--amber-lt); color: var(--amber); }

.chevron {
    font-size: 11px;
    color: #c4cad6;
    transition: transform .24s ease;
    flex-shrink: 0;
    margin-top: 3px;
}

/* ─── Claim form ─────────────────────────────────────────── */
.claim-form-wrap {
    max-height: 0;
    overflow: hidden;
    transition: max-height .36s ease, padding .28s;
    padding: 0 20px;
}
.claim-form-wrap.open {
    max-height: 700px;
    padding: 0 20px 18px;
}

.form-section-label {
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #9ca3af;
    margin: 14px 0 10px;
}

.role-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 9px;
    margin-bottom: 14px;
}

.role-card {
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 13px 11px;
    cursor: pointer;
    text-align: center;
    transition: all .18s;
    background: var(--surface);
    position: relative;
}
.role-card:hover:not(.claimed):not(.claimed-rejected) {
    border-color: var(--blue-md);
    background: var(--blue-lt);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(24,71,240,.10);
}
.role-card.selected {
    border-color: var(--blue);
    background: var(--blue-lt);
    box-shadow: 0 0 0 3px rgba(24,71,240,.10);
}
.role-card.claimed          { border-color: #bbf7d0; background: #f0fdf4; cursor: default; opacity: .75; }
.role-card.claimed-rejected { border-color: #fecaca; background: #fef2f2; cursor: default; opacity: .75; }

.role-card input[type="radio"] { display: none; }

.role-card-badge {
    position: absolute;
    top: -8px; right: 8px;
    font-size: 9px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 99px;
}
.badge-approved { background: var(--green-lt); color: var(--green); }
.badge-pending  { background: var(--amber-lt); color: var(--amber); }
.badge-rejected { background: var(--red-lt);   color: var(--red);   }

.role-card-icon  { font-size: 20px; display: block; margin-bottom: 7px; }
.role-card-label { font-size: 12px; font-weight: 700; color: var(--ink); display: block; margin-bottom: 4px; }
.role-card-pts   {
    font-size: 11.5px; font-weight: 800;
    color: var(--blue);
}

/* Upload area */
.upload-area {
    border: 1.5px dashed var(--blue-md);
    border-radius: var(--radius-sm);
    padding: 18px;
    text-align: center;
    cursor: pointer;
    background: #fafbff;
    transition: all .18s;
    margin-bottom: 12px;
}
.upload-area:hover   { border-color: var(--blue); background: var(--blue-lt); }
.upload-area input   { display: none; }
.upload-area-icon    { font-size: 24px; color: var(--blue-md); display: block; margin-bottom: 7px; }
.upload-area-text    { font-size: 13px; font-weight: 600; color: var(--muted); }
.upload-area-sub     { font-size: 11px; color: #b0b8c7; margin-top: 3px; }
.upload-preview      { font-size: 12px; font-weight: 700; color: var(--blue); margin-top: 6px; }

.btn-submit {
    width: 100%;
    background: var(--blue);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    padding: 11px 20px;
    font-size: 13.5px;
    font-weight: 800;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .18s;
    box-shadow: 0 3px 12px rgba(24,71,240,.25);
    letter-spacing: -.2px;
}
.btn-submit:hover:not(:disabled) {
    background: #1038d8;
    box-shadow: 0 6px 20px rgba(24,71,240,.35);
    transform: translateY(-1px);
}
.btn-submit:disabled { background: #d1d8f5; box-shadow: none; cursor: default; }

/* ─── Claim list ─────────────────────────────────────────── */
.claim-row {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border);
    transition: background .14s;
}
.claim-row:hover    { background: #fafbff; }
.claim-row:last-child { border-bottom: none; }

.claim-icon {
    width: 38px; height: 38px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

.claim-title { font-size: 13px; font-weight: 700; color: var(--ink); }
.claim-prog  { font-size: 11.5px; color: #9ca3af; margin-top: 2px; }

.status-chip {
    font-size: 10.5px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 99px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 5px;
}
.s-pending  { background: var(--amber-lt); color: var(--amber); }
.s-approved { background: var(--green-lt); color: var(--green); }
.s-rejected { background: var(--red-lt);   color: var(--red);   }

.claim-pts {
    font-size: 1.15rem;
    font-weight: 900;
    color: var(--ink);
    flex-shrink: 0;
    text-align: right;
    letter-spacing: -.5px;
    line-height: 1;
}
.claim-pts small { font-size: 10px; color: var(--muted); display: block; font-weight: 500; margin-top: 2px; }

.rejection-note {
    font-size: 11px;
    color: var(--red);
    margin-top: 4px;
    font-style: italic;
}

.btn-upload-proof {
    background: var(--blue-lt);
    color: var(--blue);
    border: none;
    border-radius: 7px;
    padding: 4px 11px;
    font-size: 11.5px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 6px;
    transition: background .16s;
}
.btn-upload-proof:hover { background: var(--blue-md); }

/* ─── Merit breakdown ────────────────────────────────────── */
.breakdown-row {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 11px 20px;
    border-bottom: 1px solid var(--border);
}
.breakdown-row:last-child { border-bottom: none; }

.breakdown-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: var(--gold-lt);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.breakdown-name  { font-size: 13px; font-weight: 700; color: var(--ink); }
.breakdown-count { font-size: 11px; color: #9ca3af; margin-top: 1px; }

.breakdown-pts {
    font-size: 1.15rem;
    font-weight: 900;
    color: var(--gold);
    margin-left: auto;
    letter-spacing: -.5px;
}

/* ─── Table ──────────────────────────────────────────────── */
.merit-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12.5px;
}
.merit-table thead th {
    background: #f8f9fc;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--muted);
    padding: 10px 14px;
    border-bottom: 1px solid var(--border);
}
.merit-table tbody td {
    padding: 10px 14px;
    border-bottom: 1px solid #f1f3f9;
    vertical-align: middle;
}
.merit-table tbody tr:last-child td { border-bottom: none; }
.merit-table tbody tr:hover td { background: #fafbff; }
.merit-table tfoot td {
    padding: 10px 14px;
    background: var(--gold-lt);
    font-weight: 800;
    font-size: 13px;
    color: var(--amber);
    border-top: 1.5px solid #f0d5a0;
}

.cat-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .4px;
    padding: 2px 8px;
    border-radius: 99px;
    background: var(--blue-lt);
    color: var(--blue);
}

.cat-wrap{
    gap:.5rem;
    flex-wrap:wrap;
}

.cat-pill{
    width:40px;
    height:40px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:0;
    font-size:.95rem;
}

.cat-pill.on{
    background:var(--blue);
    color:#fff;
    border-color:var(--blue);
}

/* make ALL button slightly wider */
.cat-pill[data-cat="all"]{
    width:auto;
    padding:0 14px;
    font-size:.85rem;
    font-weight:600;
}

/* ─── Empty states ───────────────────────────────────────── */
.empty {
    text-align: center;
    padding: 48px 24px;
    color: #c4cad6;
}
.empty i { font-size: 32px; display: block; margin-bottom: 12px; }
.empty p { font-size: 13px; color: var(--muted); margin: 0; line-height: 1.6; }

/* Proof Files */
/* ─────────────────────────────
   Proof Files
───────────────────────────── */

.proof-files-wrapper{
    margin-top:12px;

    display:flex;
    flex-wrap:wrap;

    gap:10px;
}

.proof-file-card{
    display:flex;
    align-items:center;
    justify-content:space-between;

    width:calc(50% - 5px);
    /* width:calc(25% - 8px); */
    /* min-width:180px; */

    background:#ffffff;

    border:1px solid #e5e7eb;

    border-radius:12px;

    padding:10px 12px;

    text-decoration:none;

    transition:all .2s ease;
}

.proof-file-card:hover{
    transform:translateY(-2px);

    border-color:#c7d2fe;

    box-shadow:0 8px 18px rgba(99,102,241,.10);
}

.proof-file-left{
    display:flex;
    align-items:center;
    gap:10px;

    min-width:0;
}

.proof-file-icon{
    width:36px;
    height:36px;

    border-radius:10px;

    background:#eef2ff;

    color:#4f46e5;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:15px;

    flex-shrink:0;
}

.proof-file-info{
    min-width:0;
}

.proof-file-name{
    font-size:12px;
    font-weight:700;

    color:#111827;

    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;

    max-width:140px;
}

.proof-file-meta{
    font-size:10px;

    color:#9ca3af;

    margin-top:2px;
}

.proof-file-action{
    color:#9ca3af;

    font-size:11px;

    margin-left:8px;

    flex-shrink:0;
}

.disabled-role{
    opacity: 0.5;
    pointer-events: none;
    cursor: not-allowed;
}

.submit-btn:disabled{
    opacity: 0.6;
    cursor: not-allowed;
}

/* Mobile */
@media(max-width:768px){

    .proof-file-card{
        width:100%;
    }

}

/* ─── Responsive ─────────────────────────────────────────── */
@media (max-width: 640px) {
    .topbar-inner { height: auto; padding: 12px 16px; flex-wrap: wrap; }
    .topbar-right { gap: 7px; }
    .portal { padding: 18px 14px 48px; }
    .panel-head { padding: 12px 16px; }
    .prog-row, .claim-row { padding: 13px 16px; }
    .claim-form-wrap { padding: 0 16px; }
    .claim-form-wrap.open { padding: 0 16px 16px; }
}

/* Tablet */
@media(max-width:1200px){

    .proof-file-card{
        width:calc(33.33% - 7px);
    }

}

/* Small tablet */
@media(max-width:768px){

    .proof-file-card{
        width:calc(50% - 5px);
    }

}

/* Mobile */
@media(max-width:500px){

    .proof-file-card{
        width:100%;
    }

}
</style>
</head>

<body>

{{-- ── Topbar ────────────────────────────────────────────────── --}}
<nav class="topbar">
    <div class="topbar-inner">
        <a href="{{ route('Portal.index') }}" class="brand">
            <div class="brand-mark">
                <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="brand-logo">
            </div>
            <div>
                <div class="brand-name">AmazingTrack</div>
                <div class="brand-sub">Staff Self-Service Portal</div>
            </div>
        </a>

        <div class="topbar-right">
            <div class="merit-pill">
                <i class="fa fa-star"></i>
                <div>
                    <span class="val">{{ $totalMerits }}</span>
                    <span class="lbl">pts</span>
                </div>
            </div>

            <div class="staff-chip">
                <div class="staff-av">{{ strtoupper(substr($staff->name, 0, 2)) }}</div>
                <div>
                    <div class="staff-chip-name">{{ $staff->name }}</div>
                    <div class="staff-chip-id">{{ $staff->staff_id }}</div>
                </div>
            </div>

            <a href="{{ route('Portal.index') }}" class="btn-exit">
                <i class="fa fa-arrow-right-from-bracket"></i> Exit
            </a>
        </div>
    </div>
</nav>

{{-- ── Portal body ─────────────────────────────────────────────── --}}
<div class="portal">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="flash flash-success fu">
        <i class="fa fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash flash-error fu">
        <i class="fa fa-circle-xmark"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- Form validation errors --}}
    @if ($errors->any())

    <div class="flash flash-error fu">

        <i class="fa fa-circle-exclamation"></i>

        <div>

            <strong>Submission failed:</strong>

            <ul style="
                margin:6px 0 0 18px;
                padding:0;
            ">
                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach
            </ul>

        </div>

    </div>

    @endif

    {{-- ── Stat cards ──────────────────────────────────────────── --}}
    @php
        $pendingCount  = $claims->where('status','pending')->count();
        $approvedCount = $claims->where('status','approved')->count();
        $rejectedCount = $claims->where('status','rejected')->count();
    @endphp

    <div class="stat-grid">
        <div class="stat-card gold fu d1">
            <div class="stat-icon" style="background:var(--gold-lt);">
                <i class="fa fa-star" style="color:var(--gold);"></i>
            </div>
            <div class="stat-val">{{ $totalMerits }}</div>
            <div class="stat-label">Total Merit Points</div>
        </div>

        <div class="stat-card greens fu d2">
            <div class="stat-icon" style="background:var(--green-lt);">
                <i class="fa fa-circle-check" style="color:var(--green);"></i>
            </div>
            <div class="stat-val">{{ $approvedCount }}</div>
            <div class="stat-label">Approved Claims</div>
        </div>

        <div class="stat-card blues fu d3">
            <div class="stat-icon" style="background:var(--amber-lt);">
                <i class="fa fa-clock" style="color:var(--amber);"></i>
            </div>
            <div class="stat-val">{{ $pendingCount }}</div>
            <div class="stat-label">Pending Review</div>
        </div>

        <div class="stat-card purples fu d4">
            <div class="stat-icon" style="background:#ede9fe;">
                <i class="fa fa-layer-group" style="color:#7c3aed;"></i>
            </div>
            <div class="stat-val">{{ $claims->count() }}</div>
            <div class="stat-label">Total Submissions</div>
        </div>
    </div>

    {{-- ── Category summary ─────────────────────────────────────── --}}
    @if(isset($categorySummary) && count($categorySummary))
    <div class="panel fu d2" style="margin-bottom:24px;">
        <div class="panel-accent" style="background:linear-gradient(90deg,#7c3aed,#a78bfa);"></div>
        <div class="panel-head">
            <div class="panel-title">
                <i class="fa fa-layer-group" style="color:#7c3aed;"></i>
                Merit by Category
            </div>
        </div>
        <div style="padding:16px 20px;">
            <div class="cat-grid">
                @foreach($categorySummary as $category => $points)
                <div class="cat-card">
                    <div class="cat-icon"
                         style="background:#ede9fe;color:#7c3aed;">
                        <i class="fa
                            @if($category=='social') fa-users
                            @elseif($category=='mind') fa-brain
                            @elseif($category=='fitness') fa-person-running
                            @elseif($category=='spiritual') fa-mosque
                            @else fa-folder
                            @endif
                        "></i>
                    </div>
                    <div>
                        <div class="cat-val">{{ $points }}</div>
                        <div class="cat-label">{{ ucfirst($category) }}</div>
                    </div>
                </div>
                @endforeach

                {{-- Total --}}
                <div class="cat-card">
                    <div class="cat-icon" style="background:var(--blue-lt);color:var(--blue);">
                        <i class="fa fa-star"></i>
                    </div>
                    <div>
                        <div class="cat-val">{{ $totalMerits }}</div>
                        <div class="cat-label">Total</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Two-column layout ────────────────────────────────────── --}}
    <div class="row g-4">

        {{-- LEFT: Programs ──────────────────────────── --}}
        <div class="col-lg-7">

            <div class="sec-head fu d1">
                <div class="sec-head-icon" style="background:var(--blue-lt);">
                    <i class="fa fa-calendar-check" style="color:var(--blue);"></i>
                </div>
                Available Programs
            </div>

            {{-- Search --}}
            <div class="search-wrap fu d2">
                <i class="fa fa-magnifying-glass"></i>
                <input type="text" id="progSearch" placeholder="Search programs…">
            </div>

            {{-- Filter pills --}}
            <div class="pills fu d2">
                <button class="pill on" data-f="all">All</button>
                <button class="pill" data-f="upcoming">Upcoming</button>
                <button class="pill" data-f="ongoing">Ongoing</button>
                <button class="pill" data-f="completed">Completed</button>
            </div>

            <!-- CATEGORY FILTER -->
            <div class="pills fu d2 mb-4 cat-wrap">

    <button class="pill cat-pill on" data-cat="all">
        All
    </button>

    <button class="pill cat-pill" data-cat="social" title="Social">
        <i class="fa fa-users"></i>
    </button>

    <button class="pill cat-pill" data-cat="mind" title="Mind">
        <i class="fa fa-brain"></i>
    </button>

    <button class="pill cat-pill" data-cat="fitness" title="Fitness">
        <i class="fa fa-person-running"></i>
    </button>

    <button class="pill cat-pill" data-cat="spiritual" title="Spiritual">
        <i class="fa fa-mosque"></i>
    </button>

</div>

            <div class="panel fu d3" id="progList">
                <div class="panel-accent"></div>
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fa fa-layer-group" style="color:var(--blue);"></i>
                        Programs
                    </div>
                    <span class="panel-count">{{ $programs->count() }}</span>
                </div>

                @forelse($programs as $program)
                @php
                    $dotClass = 'dot-' . $program->status;
                    $sbClass  = match($program->status){
                        'ongoing'     => 'sb-ongoing',
                        'completed'   => 'sb-completed',
                        'rescheduled' => 'sb-rescheduled',
                        default       => 'sb-upcoming',
                    };
                    $roleTypes = array_keys(App\Models\MeritClaim::$meritPoints);
                @endphp

                <div class="prog-item"
                     data-status="{{ $program->status }}"
                     data-category="{{ strtolower($program->category) }}"
                     data-title="{{ strtolower($program->title) }}">

                    {{-- Header row --}}
                    <div class="prog-row" onclick="toggleProgram({{ $program->id }})">
                        <div class="d-flex align-items-start gap-2" style="flex:1;min-width:0;">
                            <div class="prog-dot {{ $dotClass }}"></div>
                            <div style="min-width:0;">
                                <div class="prog-name">{{ $program->title }}</div>
                                <div class="prog-meta">
                                    <span><i class="fa fa-building me-1"></i>{{ $program->department->name ?? '—' }}</span>
                                    <span><i class="fa fa-location-dot me-1"></i>{{ $program->venue }}</span>
                                    <span><i class="fa fa-calendar me-1"></i>{{ $program->start_date->format('d M Y') }} – {{ $program->end_date->format('d M Y') }}</span>
                                    @php
                                        $categoryIcon = match($program->category) {
                                            'social' => 'fa-users',
                                            'mind' => 'fa-brain',
                                            'fitness' => 'fa-person-running',
                                            'spiritual' => 'fa-mosque',
                                            default => 'fa-folder'
                                        };
                                    @endphp

                                    <span>
                                        <i class="fa {{ $categoryIcon }}"></i>
                                        {{ ucfirst($program->category ?? '—') }}
                                    </span>
                                </div>
                                {{-- PIC Information --}}
                                <div class="prog-meta mt-1">
                                    <span><i class="fa fa-user me-1"></i>{{ $program->staffInCharge->name ?? '—' }}</span>
                                    <span><i class="fa fa-envelope me-1"></i>{{ $program->staffInCharge->email ?? '—' }}</span>
                                </div>

                                   
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="sb {{ $sbClass }}">{{ ucfirst($program->status) }}</span>
                            <i class="fa fa-chevron-down chevron" id="chevron-{{ $program->id }}"></i>
                        </div>
                    </div>

                    {{-- Expandable claim form --}}
                    <div class="claim-form-wrap" id="form-{{ $program->id }}">
                        <div class="form-section-label">Select your role</div>

                        @php
                            $isCompleted = $program->status === 'completed';
                            $isUpcoming = $program->status === 'upcoming';
                        @endphp

                        <form method="POST" 
                              action="{{ route('portal.claim') }}" 
                              enctype="multipart/form-data"
                              class="claimForm">
                            @csrf
                            <input type="hidden" name="staff_id"   value="{{ $staff->id }}">
                            <input type="hidden" name="program_id" value="{{ $program->id }}">
                            <input type="hidden" name="claim_type" id="claimType-{{ $program->id }}" value="">

                            <div class="role-grid">
                                @foreach($roleTypes as $role)
                                @php
                                    $key         = $program->id . '_' . $role;
                                    $existing    = $claims->where('program_id', $program->id)->where('claim_type', $role)->first();
                                    $isClaimed   = isset($claimedKeys[$key]) && $claimedKeys[$key] !== 'rejected';
                                    $claimStatus = $existing?->status;
                                @endphp

                               <label class="role-card {{ $isClaimed ? ($claimStatus === 'rejected' ? 'claimed-rejected' : 'claimed') : '' }} {{ $isCompleted || $isUpcoming ? 'disabled-role' : '' }}"
                                       onclick="{{ ($isClaimed || $isCompleted || $isUpcoming) ? 'return false' : "selectRole('{$program->id}','{$role}', this)" }}" >

                                    @if($isClaimed)
                                    <span class="role-card-badge {{ $claimStatus === 'approved' ? 'badge-approved' : ($claimStatus === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($claimStatus) }}
                                    </span>
                                    @endif

                                    <i class="fa {{ App\Models\MeritClaim::$claimIcons[$role] ?? 'fa-user' }} role-card-icon"
                                       style="color:{{ $isClaimed ? '#c4cad6' : 'var(--blue)' }};"></i>
                                    <span class="role-card-label">{{ App\Models\MeritClaim::$claimLabels[$role] }}</span>
                                    <span class="role-card-pts">{{ App\Models\MeritClaim::$meritPoints[$role] }} pts</span>

                                </label>
                                @endforeach
                            </div>

                            {{-- <div class="upload-area"
                                 onclick="document.getElementById('proof-{{ $program->id }}').click()">
                                <input type="file"
                                       id="proof-{{ $program->id }}"
                                       name="proof[]"
                                       multiple
                                       {{ $isCompleted || $isUpcoming ? 'disabled' : '' }}
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       onchange="showPreview('{{ $program->id }}', this)" required>
                                <i class="fa fa-cloud-arrow-up upload-area-icon"></i>
                                <div class="upload-area-text">Upload Proof (required)</div>
                                <div class="upload-area-sub">JPG · PNG · PDF &nbsp;·&nbsp; Max 5 MB</div>
                                <div class="upload-preview" id="preview-{{ $program->id }}"></div>
                            </div> --}}

                            <div id="uploadWrapper-{{ $program->id }}">

                                <div class="upload-area"
                                    onclick="document.getElementById('proof-{{ $program->id }}-0').click()">

                                    <input type="file"
                                        id="proof-{{ $program->id }}-0"
                                        name="proof[]"
                                        multiple
                                        {{ $isCompleted || $isUpcoming? 'disabled' : '' }}
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        onchange="addNewInput('{{ $program->id }}', this)"
                                        hidden>

                                    <i class="fa fa-cloud-arrow-up upload-area-icon"></i>

                                    <div class="upload-area-text">
                                        Upload Proof (Required)
                                    </div>

                                    <div class="upload-area-sub">
                                        JPG · PNG · PDF
                                    </div>

                                </div>

                                <div id="previewList-{{ $program->id }}"></div>

                            </div>

                            <button type="submit"
                                    class="btn-submit"
                                    id="submitBtn-{{ $program->id }}"
                                    disabled>
                                <i class="fa fa-paper-plane"></i> Submit Claim
                            </button>
                        </form>

                        @if($isCompleted)
                            <div class="alert alert-danger mt-3">
                                Merit claim submission is closed because this program has been completed.
                            </div>
                        @endif
                        @if($isUpcoming)
                            <div class="alert alert-warning mt-3">
                                Merit claim submission is closed because this program is upcoming.
                            </div>
                        @endif
                    </div>

                </div>
                @empty
                <div class="empty">
                    <i class="fa fa-calendar-xmark"></i>
                    <p>No programs available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT: Claims & history ─────────────────── --}}
        <div class="col-lg-5">

            <div class="sec-head fu d1">
                <div class="sec-head-icon" style="background:var(--green-lt);">
                    <i class="fa fa-list-check" style="color:var(--green);"></i>
                </div>
                My Claims &amp; History
            </div>

            {{-- Claims list --}}
            <div class="panel fu d2">
                <div class="panel-accent" style="background:linear-gradient(90deg,var(--green),#4ade80);"></div>
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fa fa-star" style="color:var(--gold);"></i>
                        {{ $totalMerits }} Merit Points Earned
                    </div>
                </div>

                @forelse($claims as $claim)
                <div class="claim-row">
                    <div class="claim-icon"
                         style="background:{{ $claim->status_bg }};">
                        <i class="fa {{ App\Models\MeritClaim::$claimIcons[$claim->claim_type] ?? 'fa-user' }}"
                           style="color:{{ $claim->status_color }};"></i>
                    </div>

                    <div style="flex:1;min-width:0;">
                        <div class="claim-title">
                            {{ App\Models\MeritClaim::$claimLabels[$claim->claim_type] ?? ucfirst($claim->claim_type) }}
                        </div>
                        <div class="claim-prog">{{ Str::limit($claim->program->title ?? '—', 40) }}</div>

                        <span class="status-chip s-{{ $claim->status }}">
                            @if($claim->status === 'approved')
                                <i class="fa fa-circle-check" style="font-size:9px;"></i> Approved
                            @elseif($claim->status === 'rejected')
                                <i class="fa fa-circle-xmark" style="font-size:9px;"></i> Rejected
                            @else
                                <i class="fa fa-clock" style="font-size:9px;"></i> Pending
                            @endif
                        </span>

                        @if($claim->status === 'rejected' && $claim->rejection_reason)
                        <div class="rejection-note">
                            <i class="fa fa-circle-exclamation me-1"></i>{{ $claim->rejection_reason }}
                        </div>
                        @endif

                        @if(in_array($claim->status, ['pending','rejected']) && !$claim->proof_path)
                        <form method="POST" action="{{ route('portal.upload-proof', $claim->id) }}"
                              enctype="multipart/form-data" style="display:inline;">
                            @csrf
                            <input type="file" id="reproof-{{ $claim->id }}" name="proof"
                                   accept=".jpg,.jpeg,.png,.pdf" style="display:none;"
                                   onchange="this.closest('form').submit()">
                            <button type="button" class="btn-upload-proof"
                                    onclick="document.getElementById('reproof-{{ $claim->id }}').click()">
                                <i class="fa fa-cloud-arrow-up"></i> Upload Proof
                            </button>
                        </form>
                        {{-- @elseif($claim->proof_path)
                        <div style="font-size:11px;color:var(--green);margin-top:5px;">
                            <i class="fa fa-file-circle-check me-1"></i>
                            {{ $claim->proof_original_name ?? 'Proof uploaded' }}
                        </div> --}}
                        @endif

                        {{-- @if($claim->files->count())

                            @foreach($claim->files as $file)

                                <div class="mb-1">

                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                    target="_blank">

                                        <i class="fa fa-file me-1"></i>

                                        {{ $file->original_name }}

                                    </a>

                                </div>

                            @endforeach

                        @endif --}}

                        @if($claim->files->count())

                            <div class="proof-files-wrapper">

                                @foreach($claim->files as $file)

                                    @php
                                        $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));

                                        $icon = match($extension) {
                                            'pdf' => 'fa-file-pdf',
                                            'jpg', 'jpeg', 'png' => 'fa-file-image',
                                            default => 'fa-file',
                                        };
                                    @endphp

                                    <a href="{{ asset('storage/' . $file->file_path) }}"
                                    target="_blank"
                                    class="proof-file-card">

                                        <div class="proof-file-left">

                                            <div class="proof-file-icon">
                                                <i class="fa {{ $icon }}"></i>
                                            </div>

                                            <div class="proof-file-info">

                                                <div class="proof-file-name">
                                                    {{ Str::limit($file->original_name, 38) }}
                                                </div>

                                                <div class="proof-file-meta">
                                                    {{ strtoupper($extension) }} File
                                                </div>

                                            </div>

                                        </div>

                                        <div class="proof-file-action">
                                            <i class="fa fa-arrow-up-right-from-square"></i>
                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        @endif
                    </div>

                    <div class="claim-pts">
                        {{ $claim->status === 'approved' ? $claim->merit_points : '–' }}
                        <small>pts</small>
                    </div>
                </div>
                @empty
                <div class="empty">
                    <i class="fa fa-inbox"></i>
                    <p>No claims yet.<br>Select a program on the left to get started.</p>
                </div>
                @endforelse
            </div>

            {{-- Merit breakdown by role --}}
            @if($approvedCount > 0)
            <div class="panel fu d3">
                <div class="panel-accent" style="background:linear-gradient(90deg,var(--gold),#fbbf24);"></div>
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fa fa-trophy" style="color:var(--gold);"></i>
                        Merit Breakdown by Role
                    </div>
                </div>

                @foreach($claims->where('status','approved')->groupBy('claim_type') as $type => $typeClaims)
                <div class="breakdown-row">
                    <div class="breakdown-icon">
                        <i class="fa {{ App\Models\MeritClaim::$claimIcons[$type] ?? 'fa-user' }}"
                           style="color:var(--amber);"></i>
                    </div>
                    <div>
                        <div class="breakdown-name">{{ App\Models\MeritClaim::$claimLabels[$type] ?? ucfirst($type) }}</div>
                        <div class="breakdown-count">{{ $typeClaims->count() }} {{ Str::plural('claim', $typeClaims->count()) }}</div>
                    </div>
                    <div class="breakdown-pts">{{ $typeClaims->sum('merit_points') }} <span style="font-size:.7em;opacity:.7;">pts</span></div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Program Category Breakdown table --}}
            @if(isset($categoryBreakdown) && count($categoryBreakdown))
            <div class="panel fu d4">
                <div class="panel-accent" style="background:linear-gradient(90deg,#7c3aed,#a78bfa);"></div>
                <div class="panel-head">
                    <div class="panel-title">
                        <i class="fa fa-table" style="color:#7c3aed;"></i>
                        Category Breakdown
                    </div>
                </div>

                <div style="overflow-x:auto;">
                    <table class="merit-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Program</th>
                                <th>Role</th>
                                <th style="text-align:right;">Pts</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($categoryBreakdown as $category => $catClaims)
                                @foreach($catClaims as $claim)
                                    @php $grandTotal += $claim->merit_points; @endphp
                                    <tr>
                                        <td><span class="cat-badge">{{ $category }}</span></td>
                                        <td>{{ Str::limit($claim->program->title, 28) }}</td>
                                        <td>{{ App\Models\MeritClaim::$claimLabels[$claim->claim_type] ?? ucfirst($claim->claim_type) }}</td>
                                        <td style="text-align:right;font-weight:800;">{{ $claim->merit_points }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total Marks</td>
                                <td style="text-align:right;">{{ $grandTotal }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* toggle program accordion */
function toggleProgram(id) {
    const wrap    = document.getElementById('form-' + id);
    const chevron = document.getElementById('chevron-' + id);
    const isOpen  = wrap.classList.contains('open');

    document.querySelectorAll('.claim-form-wrap.open').forEach(el => el.classList.remove('open'));
    document.querySelectorAll('[id^="chevron-"]').forEach(el => el.style.transform = '');

    if (!isOpen) {
        wrap.classList.add('open');
        chevron.style.transform = 'rotate(180deg)';
    }
}

/* select role card */
function selectRole(programId, role, card) {
    card.closest('.role-grid')
        .querySelectorAll('.role-card:not(.claimed):not(.claimed-rejected)')
        .forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    document.getElementById('claimType-' + programId).value = role;
    document.getElementById('submitBtn-' + programId).disabled = false;
}

/* file preview */
// function showPreview(programId, input) {
//     const preview = document.getElementById('preview-' + programId);
//     if (input.files && input.files[0]) {
//         // preview.textContent = '✓ ' + input.files[0].name;
//         let html = '';

//         for(let i = 0; i < input.files.length; i++){

//             html += '✓ ' + input.files[i].name + '<br>';

//         }

//         preview.innerHTML = html;
//     }
// }


let uploadIndex = {};

function addNewInput(programId, input){

    if(!uploadIndex[programId]){
        uploadIndex[programId] = 1;
    }

    const previewList = document.getElementById(
        'previewList-' + programId
    );

    if(input.files[0]){

        const currentInputId = input.id;

        // Preview item
        const div = document.createElement('div');

        div.style.marginTop = '8px';

        div.innerHTML = `
            <div style="
                background:#f8fafc;
                border:1px solid #e2e8f0;
                border-radius:10px;
                padding:12px 14px;
                font-size:13px;
                display:flex;
                align-items:center;
                justify-content:space-between;
            ">

                <div style="
                    display:flex;
                    align-items:center;
                    gap:8px;
                    overflow:hidden;
                ">
                    <i class="fa fa-file"
                       style="color:#2563eb;"></i>

                    <span style="
                        white-space:nowrap;
                        overflow:hidden;
                        text-overflow:ellipsis;
                    ">
                        ${input.files[0].name}
                    </span>
                </div>

                <button type="button"
                    style="
                        border:none;
                        background:#fee2e2;
                        color:#dc2626;
                        width:26px;
                        height:26px;
                        border-radius:50%;
                        font-size:14px;
                        cursor:pointer;
                        flex-shrink:0;
                    "
                    onclick="removeFile('${programId}','${currentInputId}',this)"
                >
                    ×
                </button>

            </div>
        `;

        previewList.appendChild(div);


        // Create next hidden input
        const newInput = document.createElement('input');

        newInput.type='file';

        newInput.name='proof[]';

        newInput.accept='.jpg,.jpeg,.png,.pdf';

        newInput.hidden=true;

        const currentIndex=uploadIndex[programId];

        newInput.id=`proof-${programId}-${currentIndex}`;

        newInput.onchange=function(){
            addNewInput(programId,this);
        };

        document
        .getElementById('uploadWrapper-'+programId)
        .appendChild(newInput);


        document
        .querySelector(
            `#uploadWrapper-${programId} .upload-area`
        )
        .setAttribute(
            'onclick',
            `document.getElementById(
                'proof-${programId}-${currentIndex}'
            ).click()`
        );

        uploadIndex[programId]++;

    }

}


// remove file from preview and delete corresponding hidden input (18/5/2026) - Hidayah
function removeFile(programId,inputId,btn){

    // remove preview card
    btn.closest('div').parentElement.remove();

    // remove hidden input
    const fileInput=document.getElementById(inputId);

    if(fileInput){
        fileInput.remove();
    }

}

// form submission confirmation 
// document.querySelectorAll('.claimForm').forEach(form=>{

//     form.addEventListener('submit',function(e){

//         e.preventDefault();

//         const role = this.querySelector(
//             'input[name="claim_type"],input[id^="claimType"]'
//         )?.value;

//         if(!role){
//             alert("Please select your role before submitting.");
//             return;
//         }

//         const confirm1 = confirm(
//             "Are you sure you want to submit this merit claim?"
//         );

//         if(!confirm1) return;

//         const confirm2 = confirm(
//             "Final confirmation.\n\nAfter submission, your claim will be sent for review.\nContinue?"
//         );

//         if(!confirm2) return;

//         this.submit();

//     });

// });

// Enhanced form submission confirmation with SweetAlert2
document.querySelectorAll('.claimForm').forEach(form=>{

    form.addEventListener('submit', async function(e){

        e.preventDefault();

        const role = this.querySelector(
            '[id^="claimType"]'
        )?.value;

        if(!role){

            Swal.fire({
                icon:'warning',
                title:'Role Required',
                text:'Please select your role before submitting.',
                confirmButtonColor:'#1847f0',
                background:'#fff',
                borderRadius:'18px'
            });

            return;
        }

        // First confirmation
        const first = await Swal.fire({

            title:'Submit Merit Claim?',
            html:`
                <div style="font-size:14px;color:#6b7280">
                Please review your details before submission.
                </div>
            `,

            icon:'question',

            showCancelButton:true,

            confirmButtonText:'Continue',

            cancelButtonText:'Cancel',

            confirmButtonColor:'#1847f0',

            cancelButtonColor:'#d1d5db',

            reverseButtons:true,

            background:'#fff',

            borderRadius:'20px',

            backdrop:`
                rgba(17,24,39,.55)
                blur(6px)
            `,

            showClass:{
                popup:'animate__animated animate__zoomIn'
            }

        });

        if(!first.isConfirmed) return;


        // Final confirmation
        const second = await Swal.fire({

            title:'Final Confirmation',

            html:`
            <div style="line-height:1.8">

                <div style="
                    width:65px;
                    height:65px;
                    margin:auto;
                    background:#e8effe;
                    border-radius:50%;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    margin-bottom:15px;
                ">
                    <i class="fa fa-paper-plane"
                    style="
                    color:#1847f0;
                    font-size:24px;
                    "></i>
                </div>

                Your claim will be submitted for review.<br>
                You cannot edit it after submission.

            </div>
            `,

            showCancelButton:true,

            confirmButtonText:'Submit Now',

            cancelButtonText:'Go Back',

            confirmButtonColor:'#10b981',

            cancelButtonColor:'#d1d5db',

            background:'#fff',

            borderRadius:'20px',

            backdrop:`
                rgba(17,24,39,.55)
                blur(6px)
            `

        });


        if(second.isConfirmed){

            Swal.fire({

                title:'Submitting...',
                html:'Please wait',

                allowOutsideClick:false,

                didOpen:()=>{

                    Swal.showLoading();

                }

            });

            this.submit();
        }

    });

});

/* search */
document.getElementById('progSearch').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.prog-item').forEach(item => {
        item.style.display = (item.dataset.title || '').includes(q) ? '' : 'none';
    });
});

/* filter pills */
document.querySelectorAll('.pill').forEach(pill => {
    pill.addEventListener('click', function () {
        document.querySelectorAll('.pill').forEach(p => p.classList.remove('on'));
        this.classList.add('on');
        const f = this.dataset.f;
        document.querySelectorAll('.prog-item').forEach(item => {
            item.style.display = (f === 'all' || item.dataset.status === f) ? '' : 'none';
        });
    });
});

const statusButtons = document.querySelectorAll('[data-f]');
const categoryButtons = document.querySelectorAll('[data-cat]');
const cards = document.querySelectorAll('.prog-item');

let currentStatus = 'all';
let currentCategory = 'all';

function filterCards() {
    cards.forEach(card => {
        const status = card.dataset.status;
        const category = card.dataset.category;

        const statusMatch = currentStatus === 'all' || status === currentStatus;
        const categoryMatch = currentCategory === 'all' || category === currentCategory;

        card.style.display = statusMatch && categoryMatch ? 'block' : 'none';
    });
}

statusButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        statusButtons.forEach(b => b.classList.remove('on'));
        btn.classList.add('on');

        currentStatus = btn.dataset.f;
        filterCards();
    });
});

categoryButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        categoryButtons.forEach(b => b.classList.remove('on'));
        btn.classList.add('on');

        currentCategory = btn.dataset.cat;
        filterCards();
    });
});
</script>

</body>
</html>
