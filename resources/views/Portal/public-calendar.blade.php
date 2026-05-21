<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>AmazingTrack | Programme Calendar</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
  --navy: #162f5c;
  --navy-dark: #0e1f3e;
  --red: #ED1C24;
  --blue: #1847f0;
  --blue-lt: #eef2ff;
  --blue-md: #c7d2fe;
  --border: #e8ecf4;
  --surface: #ffffff;
  --bg: #f3f5fb;
  --text: #111827;
  --muted: #6b7280;
  --radius-sm: 8px;
  --radius: 14px;
  --radius-lg: 20px;
  --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 2px 8px rgba(0,0,0,.04);
  --shadow: 0 2px 8px rgba(0,0,0,.07), 0 8px 32px rgba(0,0,0,.06);
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  -webkit-font-smoothing: antialiased;
}

/* ─── TOPBAR ─────────────────────────────────────── */
.topbar {
  background: var(--navy);
  border-bottom: 3px solid var(--red);
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(8px);
}

.topbar-inner {
  max-width: 1200px;
  margin: auto;
  padding: 0 28px;
  height: 66px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.brand {
  display: flex;
  align-items: center;
  gap: 14px;
  text-decoration: none;
  color: white;
}

.brand-logo-wrap {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 10px;
  width: 42px;
  height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  color: white;
}

.brand-name {
  font-size: 16px;
  font-weight: 800;
  letter-spacing: -.3px;
  color: white;
}

.brand-sub {
  font-size: 11px;
  color: rgba(255,255,255,.5);
  font-weight: 400;
  margin-top: 1px;
}

.btn-back {
  display: flex;
  align-items: center;
  gap: 7px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.2);
  color: white;
  font-family: inherit;
  font-size: 13px;
  font-weight: 600;
  padding: 8px 16px;
  border-radius: var(--radius-sm);
  cursor: pointer;
  text-decoration: none;
  transition: background .15s;
}
.btn-back:hover {
  background: rgba(255,255,255,.18);
  color: white;
}

/* ─── PORTAL LAYOUT ──────────────────────────────── */
.portal {
  max-width: 1200px;
  margin: auto;
  padding: 32px 28px 48px;
}

/* ─── HERO ───────────────────────────────────────── */
.hero {
  background: var(--navy);
  border-radius: var(--radius-lg);
  padding: 38px 44px;
  margin-bottom: 28px;
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
}

.hero::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 260px; height: 260px;
  background: rgba(24, 71, 240, .35);
  border-radius: 50%;
}

.hero::after {
  content: '';
  position: absolute;
  bottom: -80px; right: 80px;
  width: 200px; height: 200px;
  background: rgba(237, 28, 36, .18);
  border-radius: 50%;
}

.hero-text { position: relative; z-index: 1; }

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  color: rgba(255,255,255,.85);
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .8px;
  padding: 5px 12px;
  border-radius: 100px;
  margin-bottom: 14px;
}

.hero h1 {
  font-size: 28px;
  font-weight: 800;
  color: white;
  letter-spacing: -.5px;
  line-height: 1.2;
  margin-bottom: 8px;
}

.hero p {
  color: rgba(255,255,255,.6);
  font-size: 14px;
  font-weight: 400;
  line-height: 1.6;
}

.hero-stats {
  display: flex;
  gap: 12px;
  position: relative;
  z-index: 1;
  flex-shrink: 0;
}

.stat-pill {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: var(--radius);
  padding: 16px 22px;
  text-align: center;
  min-width: 90px;
}

.stat-num {
  font-size: 26px;
  font-weight: 800;
  color: white;
  display: block;
  line-height: 1;
  margin-bottom: 4px;
}

.stat-label {
  font-size: 11px;
  color: rgba(255,255,255,.55);
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: .5px;
}

/* ─── MAIN CARD ──────────────────────────────────── */
.card-main {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.card-header {
  padding: 20px 28px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid var(--border);
  background: #fafbfd;
}

.card-title {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
}

.card-title-icon {
  width: 34px;
  height: 34px;
  background: var(--blue-lt);
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--blue);
  font-size: 15px;
}

/* ─── FILTERS ────────────────────────────────────── */
.filters-area {
  padding: 20px 28px;
  border-bottom: 1px solid var(--border);
  display: flex;
  gap: 12px;
  align-items: center;
  flex-wrap: wrap;
  background: #fafbfd;
}

.search-wrap {
  position: relative;
  flex: 1;
  min-width: 220px;
}

.search-wrap i {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--muted);
  font-size: 14px;
  pointer-events: none;
}

.search-wrap input {
  width: 100%;
  padding: 10px 14px 10px 38px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  font-family: inherit;
  font-size: 13.5px;
  color: var(--text);
  background: white;
  transition: border-color .15s, box-shadow .15s;
  outline: none;
}

.search-wrap input:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(24,71,240,.1);
}

.filter-select {
  padding: 10px 36px 10px 14px;
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  font-family: inherit;
  font-size: 13.5px;
  color: var(--text);
  background: white;
  appearance: none;
  -webkit-appearance: none;
  cursor: pointer;
  min-width: 160px;
  outline: none;
  transition: border-color .15s, box-shadow .15s;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
}

.filter-select:focus {
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(24,71,240,.1);
}

/* ─── STATUS LEGEND ──────────────────────────────── */
.legend-area {
  padding: 14px 28px;
  border-bottom: 1px solid var(--border);
  display: flex;
  gap: 8px;
  flex-wrap: wrap;
  align-items: center;
}

.legend-label {
  font-size: 12px;
  font-weight: 600;
  color: var(--muted);
  margin-right: 4px;
}

.status-chip {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 12px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 700;
  letter-spacing: .1px;
}

.status-chip::before {
  content: '';
  width: 7px;
  height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
}

.chip-upcoming { background: #eef2ff; color: #3730a3; }
.chip-upcoming::before { background: #4f46e5; }

.chip-ongoing { background: #dcfce7; color: #166534; }
.chip-ongoing::before { background: #16a34a; }

.chip-completed { background: #ede9fe; color: #4c1d95; }
.chip-completed::before { background: #7c3aed; }

.chip-cancelled { background: #fee2e2; color: #991b1b; }
.chip-cancelled::before { background: #dc2626; }

.chip-rescheduled { background: #fef9c3; color: #854d0e; }
.chip-rescheduled::before { background: #d97706; }

/* ─── CALENDAR AREA ──────────────────────────────── */
.calendar-area {
  padding: 28px;
}

.fc {
  font-family: 'Plus Jakarta Sans', sans-serif !important;
}

.fc .fc-toolbar.fc-header-toolbar {
  margin-bottom: 20px !important;
}

.fc .fc-toolbar-title {
  font-size: 18px !important;
  font-weight: 800 !important;
  color: var(--text) !important;
  letter-spacing: -.3px;
}

.fc .fc-button {
  background: white !important;
  border: 1.5px solid var(--border) !important;
  color: var(--text) !important;
  font-family: inherit !important;
  font-size: 13px !important;
  font-weight: 600 !important;
  border-radius: var(--radius-sm) !important;
  padding: 7px 14px !important;
  box-shadow: var(--shadow-sm) !important;
  transition: all .15s !important;
}

.fc .fc-button:hover {
  background: var(--blue-lt) !important;
  border-color: var(--blue-md) !important;
  color: var(--blue) !important;
}

.fc .fc-button-primary:not(:disabled).fc-button-active {
  background: var(--blue) !important;
  border-color: var(--blue) !important;
  color: white !important;
}

.fc .fc-col-header-cell-cushion {
  font-size: 12px !important;
  font-weight: 700 !important;
  color: var(--muted) !important;
  text-transform: uppercase;
  letter-spacing: .7px;
  padding: 10px 0 !important;
}

.fc .fc-daygrid-day-number {
  font-size: 13px !important;
  font-weight: 600 !important;
  color: var(--text);
  padding: 6px 10px !important;
}

.fc .fc-day-today {
  background: #eef2ff !important;
}

.fc .fc-day-today .fc-daygrid-day-number {
  background: var(--blue);
  color: white !important;
  border-radius: 8px;
  width: 28px;
  height: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 !important;
  margin: 4px;
}

.fc-event {
  border: none !important;
  border-radius: 7px !important;
  padding: 3px 7px !important;
  font-size: 11.5px !important;
  font-weight: 600 !important;
  cursor: pointer !important;
  transition: filter .15s, transform .1s !important;
}

.fc-event:hover {
  filter: brightness(.9) !important;
  transform: scale(1.02);
}

.fc-daygrid-event { white-space: normal !important; }

.fc th { border-color: var(--border) !important; }
.fc td { border-color: var(--border) !important; }

/* ─── MODAL ──────────────────────────────────────── */
.modal-content {
  border: none !important;
  border-radius: var(--radius-lg) !important;
  box-shadow: 0 20px 60px rgba(0,0,0,.15) !important;
  overflow: hidden;
}

.modal-header {
  background: var(--navy);
  border: none !important;
  padding: 22px 26px 20px !important;
}

.modal-title-text {
  font-size: 16px;
  font-weight: 800;
  color: white;
  line-height: 1.3;
}

.modal-header .btn-close {
  filter: invert(1);
  opacity: .7;
}

.modal-body {
  padding: 22px 26px !important;
}

.detail-row {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 12px 0;
  border-bottom: 1px solid var(--border);
}

.detail-row:last-child { border-bottom: none; }

.detail-icon {
  width: 34px;
  height: 34px;
  border-radius: var(--radius-sm);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  flex-shrink: 0;
  margin-top: 1px;
}

.detail-icon.blue { background: var(--blue-lt); color: var(--blue); }
.detail-icon.green { background: #dcfce7; color: #16a34a; }
.detail-icon.purple { background: #ede9fe; color: #7c3aed; }
.detail-icon.amber { background: #fef9c3; color: #d97706; }

.detail-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .6px;
  color: var(--muted);
  margin-bottom: 3px;
}

.detail-value {
  font-size: 14px;
  font-weight: 500;
  color: var(--text);
  line-height: 1.5;
}

.status-badge-modal {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 13px;
  border-radius: 100px;
  font-size: 12px;
  font-weight: 700;
  margin-top: 16px;
}

/* empty state */
.empty-calendar {
  text-align: center;
  padding: 60px 20px;
  color: var(--muted);
}
.empty-calendar i { font-size: 48px; margin-bottom: 12px; opacity: .3; }
.empty-calendar p { font-size: 14px; }

/* ─── FOOTER ─────────────────────────────────────── */
.footer {
  background: var(--navy);
  border-top: 3px solid var(--red);
  margin-top: 48px;
}

.footer-inner {
  max-width: 1200px;
  margin: auto;
  padding: 40px 28px 28px;
}

.footer-top {
  display: grid;
  grid-template-columns: 1.8fr 1fr 1fr;
  gap: 40px;
  padding-bottom: 32px;
  border-bottom: 1px solid rgba(255,255,255,.1);
}

.footer-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
  text-decoration: none;
}

.footer-brand-icon {
  width: 40px;
  height: 40px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 16px;
  flex-shrink: 0;
}

.footer-brand-name {
  font-size: 15px;
  font-weight: 800;
  color: white;
  letter-spacing: -.2px;
}

.footer-brand-sub {
  font-size: 11px;
  color: rgba(255,255,255,.45);
  margin-top: 1px;
}

.footer-desc {
  font-size: 13px;
  color: rgba(255,255,255,.5);
  line-height: 1.7;
  max-width: 280px;
}

.footer-col-title {
  font-size: 11px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: .8px;
  color: rgba(255,255,255,.4);
  margin-bottom: 14px;
}

.footer-links {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.footer-links a {
  font-size: 13px;
  color: rgba(255,255,255,.65);
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: color .15s;
}

.footer-links a:hover { color: white; }

.footer-links a i {
  font-size: 12px;
  opacity: .5;
  width: 14px;
}

.footer-bottom {
  padding-top: 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 16px;
  flex-wrap: wrap;
}

.footer-copy {
  font-size: 12px;
  color: rgba(255,255,255,.35);
}

.footer-copy strong {
  color: rgba(255,255,255,.6);
  font-weight: 700;
}

.footer-powered {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  color: rgba(255,255,255,.35);
}

.footer-powered span {
  color: rgba(255,255,255,.6);
  font-weight: 600;
}

/* ─── RESPONSIVE ─────────────────────────────────── */
@media(max-width: 768px) {
  .portal { padding: 20px 16px 40px; }
  .hero { padding: 26px 24px; flex-direction: column; }
  .hero-stats { display: none; }
  .filters-area { gap: 10px; }
  .search-wrap { min-width: 100%; }
  .filter-select { min-width: 0; flex: 1; }
  .calendar-area { padding: 16px; }
  .hero h1 { font-size: 22px; }
  .footer-top { grid-template-columns: 1fr; gap: 28px; }
  .footer-bottom { flex-direction: column; align-items: flex-start; gap: 8px; }
}
</style>
</head>
<body>

<!-- TOPBAR -->
<nav class="topbar">
  <div class="topbar-inner">
    <a href="{{ route('Portal.index') }}" class="brand">
      <div class="brand-logo-wrap">
        <i class="fa fa-calendar-check"></i>
      </div>
      <div>
        <div class="brand-name">AmazingTrack</div>
        <div class="brand-sub">Public Portal</div>
      </div>
    </a>
    <a href="{{ route('Portal.index') }}" class="btn-back">
      <i class="fa fa-arrow-left" style="font-size:11px"></i>
      Back to Portal
    </a>
  </div>
</nav>

<!-- PORTAL -->
<div class="portal">

  <!-- HERO -->
  <div class="hero">
    <div class="hero-text">
      <div class="hero-badge">
        <i class="fa fa-circle" style="font-size:7px;color:#4ade80"></i>
        Live Calendar
      </div>
      <h1>University Programme Calendar</h1>
      <p>Browse upcoming activities and programmes organised by departments.<br>Click any event for full details.</p>
    </div>
    <div class="hero-stats">
      <div class="stat-pill">
        <span class="stat-num" id="statTotal">—</span>
        <span class="stat-label">Events</span>
      </div>
      <div class="stat-pill">
        <span class="stat-num" id="statUpcoming">—</span>
        <span class="stat-label">Upcoming</span>
      </div>
      <div class="stat-pill">
        <span class="stat-num" id="statOngoing">—</span>
        <span class="stat-label">Ongoing</span>
      </div>
    </div>
  </div>

  <!-- MAIN CARD -->
  <div class="card-main">

    <!-- Card Header -->
    <div class="card-header">
      <div class="card-title">
        <div class="card-title-icon">
          <i class="fa fa-calendar-days"></i>
        </div>
        Programme Calendar
      </div>
    </div>

    <!-- Filters -->
    <div class="filters-area">
      <div class="search-wrap">
        <i class="fa fa-magnifying-glass"></i>
        <input type="text" id="searchProgram" placeholder="Search programmes…">
      </div>
      <select id="departmentFilter" class="filter-select">
        <option value="">All Departments</option>
        @foreach($departments as $department)
          <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
      </select>
      <select id="statusFilter" class="filter-select">
        <option value="">All Status</option>
        <option value="upcoming">Upcoming</option>
        <option value="ongoing">Ongoing</option>
        <option value="completed">Completed</option>
        <option value="cancelled">Cancelled</option>
        <option value="rescheduled">Rescheduled</option>
      </select>
    </div>

    <!-- Legend -->
    <div class="legend-area">
      <span class="legend-label">Status:</span>
      <span class="status-chip chip-upcoming">Upcoming</span>
      <span class="status-chip chip-ongoing">Ongoing</span>
      <span class="status-chip chip-completed">Completed</span>
      <span class="status-chip chip-cancelled">Cancelled</span>
      <span class="status-chip chip-rescheduled">Rescheduled</span>
    </div>

    <!-- Calendar -->
    <div class="calendar-area">
      <div id="calendar"></div>
    </div>

  </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="programModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="flex:1">
          <div id="modalStatusBadge"></div>
          <div class="modal-title-text mt-2" id="programTitle"></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="detail-row">
          <div class="detail-icon blue"><i class="fa fa-building"></i></div>
          <div>
            <div class="detail-label">Department</div>
            <div class="detail-value" id="department"></div>
          </div>
        </div>
        <div class="detail-row">
          <div class="detail-icon green"><i class="fa fa-location-dot"></i></div>
          <div>
            <div class="detail-label">Venue</div>
            <div class="detail-value" id="venue"></div>
          </div>
        </div>
        <div class="detail-row">
          <div class="detail-icon purple"><i class="fa fa-user-tie"></i></div>
          <div>
            <div class="detail-label">Person in Charge</div>
            <div class="detail-value" id="pic"></div>
          </div>
        </div>
        <div class="detail-row">
          <div class="detail-icon amber"><i class="fa fa-align-left"></i></div>
          <div>
            <div class="detail-label">Description</div>
            <div class="detail-value" id="description"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-inner">
    <div class="footer-top">
      <div>
        <a href="{{ route('Portal.index') }}" class="footer-brand">
          <div class="footer-brand-icon"><i class="fa fa-calendar-check"></i></div>
          <div>
            <div class="footer-brand-name">AmazingTrack</div>
            <div class="footer-brand-sub">Public Portal</div>
          </div>
        </a>
        <p class="footer-desc">A centralised platform for tracking university programmes, activities, and departmental events across all faculties.</p>
      </div>
      <div>
        <div class="footer-col-title">Quick Links</div>
        <ul class="footer-links">
          <li><a href="{{ route('Portal.index') }}"><i class="fa fa-house"></i> Portal Home</a></li>
          <li><a href="#"><i class="fa fa-calendar-days"></i> Programme Calendar</a></li>
          <li><a href="#"><i class="fa fa-building"></i> Departments</a></li>
          <li><a href="#"><i class="fa fa-circle-info"></i> About</a></li>
        </ul>
      </div>
      <div>
        <div class="footer-col-title">Event Status Guide</div>
        <ul class="footer-links">
          <li><a href="#"><i class="fa fa-circle" style="color:#4f46e5;opacity:1"></i> Upcoming</a></li>
          <li><a href="#"><i class="fa fa-circle" style="color:#16a34a;opacity:1"></i> Ongoing</a></li>
          <li><a href="#"><i class="fa fa-circle" style="color:#7c3aed;opacity:1"></i> Completed</a></li>
          <li><a href="#"><i class="fa fa-circle" style="color:#dc2626;opacity:1"></i> Cancelled</a></li>
          <li><a href="#"><i class="fa fa-circle" style="color:#d97706;opacity:1"></i> Rescheduled</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-copy">&copy; {{ date('Y') }} <strong>AmazingTrack</strong>. All rights reserved. University Public Portal.</div>
      <div class="footer-powered"><i class="fa fa-bolt" style="font-size:11px;color:rgba(255,255,255,.4)"></i> Powered by <span>AmazingTrack System</span></div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

  const STATUS_COLORS = {
    upcoming:    { bg: '#4f46e5', chip: 'chip-upcoming', label: 'Upcoming' },
    ongoing:     { bg: '#16a34a', chip: 'chip-ongoing',  label: 'Ongoing'  },
    completed:   { bg: '#7c3aed', chip: 'chip-completed', label: 'Completed' },
    cancelled:   { bg: '#dc2626', chip: 'chip-cancelled', label: 'Cancelled' },
    rescheduled: { bg: '#d97706', chip: 'chip-rescheduled', label: 'Rescheduled' },
  };

  let allEvents = @json($calendarEvents);

  allEvents.forEach(e => {
    const s = STATUS_COLORS[e.status] || STATUS_COLORS.upcoming;
    e.backgroundColor = s.bg;
    e.borderColor = s.bg;
  });

  // Update hero stats
  document.getElementById('statTotal').textContent = allEvents.length;
  document.getElementById('statUpcoming').textContent = allEvents.filter(e => e.status === 'upcoming').length;
  document.getElementById('statOngoing').textContent  = allEvents.filter(e => e.status === 'ongoing').length;

  const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    height: 'auto',
    events: allEvents,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,listMonth'
    },
    buttonText: {
      today: 'Today',
      month: 'Month',
      list: 'List'
    },
    eventClick: function(info) {
      const s = STATUS_COLORS[info.event.extendedProps.status] || STATUS_COLORS.upcoming;
      document.getElementById('programTitle').textContent = info.event.title;
      document.getElementById('department').textContent   = info.event.extendedProps.department || '—';
      document.getElementById('venue').textContent        = info.event.extendedProps.venue || '—';
      document.getElementById('pic').textContent          = info.event.extendedProps.person_in_charge || '—';
      document.getElementById('description').textContent  = info.event.extendedProps.description || '—';
      document.getElementById('modalStatusBadge').innerHTML =
        `<span class="status-chip ${s.chip}" style="font-size:11px;padding:4px 10px">${s.label}</span>`;
      new bootstrap.Modal(document.getElementById('programModal')).show();
    }
  });

  calendar.render();

  function applyFilter() {
    const keyword    = document.getElementById('searchProgram').value.toLowerCase();
    const department = document.getElementById('departmentFilter').value;
    const status     = document.getElementById('statusFilter').value;
    const filtered   = allEvents.filter(e => {
      return (!keyword || e.title.toLowerCase().includes(keyword))
          && (!department || String(e.department_id) === department)
          && (!status || e.status === status);
    });
    calendar.removeAllEvents();
    calendar.addEventSource(filtered);
  }

  document.getElementById('searchProgram').addEventListener('input', applyFilter);
  document.getElementById('departmentFilter').addEventListener('change', applyFilter);
  document.getElementById('statusFilter').addEventListener('change', applyFilter);
});
</script>
</body>
</html>