@extends('layouts.app')

@section('page-title','Amazing You Gallery — Vice Chancellor')

@push('styles')
<style>
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
.fu  { animation:fadeUp .45s ease both; }
.d1  { animation-delay:.06s; }
.d2  { animation-delay:.12s; }
.d3  { animation-delay:.18s; }
.d4  { animation-delay:.24s; }
.d5  { animation-delay:.30s; }

/* ── Hero ── */
.vc-hero {
    background:linear-gradient(128deg,#0a1f52 0%,#0f2d6e 50%,#1e40af 100%);
    border-radius:20px;padding:28px 32px;margin-bottom:24px;
    position:relative;overflow:hidden;
    box-shadow:0 12px 40px rgba(15,45,110,.22);
}
.vc-hero::before {
    content:'';position:absolute;width:300px;height:300px;border-radius:50%;
    background:rgba(245,158,11,.10);top:-90px;right:-60px;pointer-events:none;
}
.vc-hero::after {
    content:'';position:absolute;width:180px;height:180px;border-radius:50%;
    background:rgba(96,165,250,.08);bottom:-60px;left:35%;pointer-events:none;
}
.vc-hero h1   { font-size:1.55rem;font-weight:800;color:#fff;margin:0 0 5px; }
.vc-hero p    { font-size:13.5px;color:rgba(255,255,255,.62);margin:0; }
.hero-bottom  { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-top:20px; }
.hero-chips   { display:flex;gap:8px;flex-wrap:wrap; }
.hero-chip {
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
    border-radius:10px;padding:6px 13px;font-size:12px;font-weight:600;
    color:rgba(255,255,255,.88);display:inline-flex;align-items:center;gap:7px;
}
.hero-chip i { color:#f59e0b; }
.view-switcher { display:flex;gap:8px; }
.vs-btn {
    background:rgba(255,255,255,.13);border:1.5px solid rgba(255,255,255,.22);
    border-radius:11px;padding:9px 18px;color:rgba(255,255,255,.85);
    font-size:13px;font-weight:700;display:inline-flex;align-items:center;gap:8px;
    text-decoration:none;transition:all .22s;
}
.vs-btn:hover  { background:rgba(255,255,255,.22);color:#fff;text-decoration:none;transform:translateY(-1px); }
.vs-btn.active { background:#f59e0b;border-color:#f59e0b;color:#fff;box-shadow:0 4px 16px rgba(245,158,11,.38); }

/* ── Stat strip ── */
.stat-strip { display:grid;grid-template-columns:repeat(4,1fr);gap:13px;margin-bottom:22px; }
@media(max-width:900px){ .stat-strip{ grid-template-columns:repeat(2,1fr); } }

.s-chip {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;
    padding:14px 16px;box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;cursor:default;
}
.s-chip:hover { transform:translateY(-3px);box-shadow:0 8px 22px rgba(15,45,110,.10); }
.s-chip-icon  { width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:15px;margin-bottom:10px; }
.s-chip-val   { font-size:1.65rem;font-weight:900;color:#0f172a;line-height:1; }
.s-chip-label { font-size:11.5px;color:#64748b;font-weight:600;margin-top:3px; }

/* ── Gallery card shell ── */
.gal-card { background:#fff;border:1.5px solid #e2e8f0;border-radius:18px; overflow:hidden;box-shadow:0 4px 24px rgba(15,45,110,.07); }
.gal-stripe { height:5px;background:linear-gradient(90deg,#0f2d6e,#1a56db,#f59e0b); }

/* ── Toolbar ── */
.toolbar { display:flex;align-items:center;justify-content:space-between; flex-wrap:wrap;gap:12px;padding:16px 22px;border-bottom:1px solid #f1f5f9; }
.toolbar-left  { display:flex;align-items:center;gap:10px;flex-wrap:wrap; }
.toolbar-title { font-size:14px;font-weight:800;color:#0f172a; }
.count-pill    { background:#eff6ff;color:#1d4ed8;font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:20px; }

.filter-pill {
    background:#f8faff;border:1.5px solid #e2e8f0;border-radius:20px;
    padding:5px 13px;font-size:12px;font-weight:700;color:#475569;
    cursor:pointer;transition:all .18s;white-space:nowrap;font-family:inherit;
}
.filter-pill:hover,.filter-pill.on { background:#eff6ff;border-color:#bfdbfe;color:#1d4ed8; }

.toolbar-right { display:flex;gap:10px;flex-wrap:wrap;align-items:center; }

.dept-sel {
    border:1.5px solid #e2e8f0;border-radius:10px;
    padding:8px 30px 8px 12px;font-size:13px;font-family:inherit;
    background:#f8faff;color:#475569;outline:none;cursor:pointer;appearance:none;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat:no-repeat;background-position:right 10px center;transition:border-color .2s;
}
.dept-sel:focus { border-color:#1a56db; }

.search-wrap { position:relative; }
.search-wrap i { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;pointer-events:none; }
.search-inp {
    border:1.5px solid #e2e8f0;border-radius:10px;
    padding:9px 14px 9px 35px;font-size:13.5px;font-family:inherit;
    background:#f8faff;color:#1e293b;width:210px;outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-inp:focus { border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.10);background:#fff; }

/* ── Masonry gallery ── */
.gallery-wrap { padding:20px 22px 26px; }
.gallery-masonry {
    column-count:4; column-gap:14px;
}
@media(max-width:1200px){ .gallery-masonry{ column-count:3; } }
@media(max-width:800px) { .gallery-masonry{ column-count:2; } }
@media(max-width:500px) { .gallery-masonry{ column-count:1; } }

.gal-tile {
    break-inside:avoid; margin-bottom:14px; border-radius:16px;
    overflow:hidden; position:relative; cursor:pointer;
    background:#fff; border:1.5px solid #e2e8f0;
    box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .22s, box-shadow .22s;
    animation:fadeUp .4s ease both;
}
.gal-tile:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(15,45,110,.16); }
.gal-tile img { width:100%; display:block; }

.gal-doc-tile {
    aspect-ratio:4/3; display:flex; flex-direction:column;
    align-items:center; justify-content:center; gap:10px;
    background:linear-gradient(135deg,#f8faff,#eef2ff);
}
.gal-doc-tile i { font-size:36px; color:#4338ca; }
.gal-doc-tile span {
    font-size:11.5px; font-weight:600; color:#475569;
    max-width:85%; text-align:center; overflow:hidden;
    text-overflow:ellipsis; white-space:nowrap;
}

.gal-status-badge {
    position:absolute; top:10px; right:10px; z-index:2;
    font-size:10.5px; font-weight:800; padding:4px 10px; border-radius:20px;
    display:inline-flex; align-items:center; gap:5px;
    box-shadow:0 2px 8px rgba(0,0,0,.18);
}
.gal-status-pending  { background:#fef9c3;color:#b45309; }
.gal-status-approved { background:#dcfce7;color:#15803d; }
.gal-status-rejected { background:#fee2e2;color:#b91c1c; }

.gal-points-badge {
    position:absolute; top:10px; left:10px; z-index:2;
    background:linear-gradient(135deg,#b45309,#f59e0b); color:#fff;
    font-size:10.5px; font-weight:800; padding:4px 10px; border-radius:20px;
    display:inline-flex; align-items:center; gap:4px;
    box-shadow:0 2px 8px rgba(180,83,9,.35);
}

.gal-overlay {
    position:absolute; left:0; right:0; bottom:0; z-index:2;
    background:linear-gradient(0deg, rgba(10,20,55,.92) 0%, rgba(10,20,55,.55) 60%, rgba(10,20,55,0) 100%);
    padding:26px 12px 10px; color:#fff;
    opacity:0; transform:translateY(6px);
    transition:opacity .2s, transform .2s;
}
.gal-tile:hover .gal-overlay { opacity:1; transform:translateY(0); }
.gal-doc-tile .gal-overlay { opacity:1; transform:none; position:static; background:none; color:#334155; padding:0 14px 14px; }

.gal-overlay .gal-staff { font-size:12.5px; font-weight:700; display:flex; align-items:center; gap:6px; }
.gal-overlay .gal-staff i { font-size:10px; color:#f59e0b; }
.gal-doc-tile .gal-overlay .gal-staff i { color:#b45309; }
.gal-overlay .gal-program { font-size:11px; opacity:.85; margin-top:2px; display:flex; align-items:center; gap:6px; }
.gal-doc-tile .gal-overlay .gal-program { opacity:.7; }

.gal-empty {
    text-align:center; padding:60px 20px; color:#94a3b8;
}
.gal-empty i { font-size:44px; display:block; margin-bottom:14px; color:#cbd5e1; }
.gal-empty p { font-size:14px; font-weight:600; }

/* ── Role / claim-type tags (reused style) ── */
.role-tag { font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;display:inline-flex;align-items:center;gap:3px; }
.role-attendee          { background:#e0f2fe;color:#0369a1; }
.role-committee_head    { background:#fef9c3;color:#b45309; }
.role-coordinator       { background:#e0e7ff;color:#3730a3; }
.role-secretary         { background:#dbeafe;color:#1d4ed8; }
.role-treasurer         { background:#dcfce7;color:#15803d; }
.role-facilitator       { background:#fce7f3;color:#9d174d; }
.role-committee_member  { background:#f1f5f9;color:#475569; }

/* ── Lightbox modal ── */
.modal-content  { border:none!important;border-radius:18px!important;overflow:hidden;box-shadow:0 24px 60px rgba(15,45,110,.18)!important; }
.m-stripe       { height:5px; }
.modal-header   { border-bottom:1px solid #f1f5f9!important;padding:20px 24px 16px!important;background:#fff!important; }
.modal-title    { font-size:16px!important;font-weight:800!important;color:#0f172a!important;display:flex;align-items:center; }
.modal-footer   { padding:14px 24px 20px!important;border-top:1px solid #f1f5f9!important;background:#fff!important; }
.btn-dismiss    { background:#f1f5f9;color:#64748b;border:none;border-radius:10px;padding:10px 20px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .2s; }
.btn-dismiss:hover { background:#e2e8f0; }
.btn-confirm {
    border:none;border-radius:10px;color:#fff;font-weight:700;
    font-size:13.5px;padding:10px 20px;cursor:pointer;transition:opacity .2s;
    display:inline-flex;align-items:center;gap:6px;text-decoration:none;
}
.btn-confirm:hover { opacity:.9;color:#fff; }

.lb-body { display:flex; gap:0; padding:0!important; }
.lb-media {
    flex:1.3; background:#0a1f3a; display:flex; align-items:center; justify-content:center;
    min-height:340px; max-height:70vh; overflow:hidden;
}
.lb-media img { width:100%; height:100%; object-fit:contain; max-height:70vh; }
.lb-media .lb-doc-preview { display:flex; flex-direction:column; align-items:center; gap:14px; color:#cbd5e1; padding:40px; }
.lb-media .lb-doc-preview i { font-size:56px; color:#60a5fa; }
.lb-details { flex:1; padding:22px 24px; overflow-y:auto; max-height:70vh; }
.lb-d-row { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #f8faff; font-size:13.5px; }
.lb-d-row:last-child { border-bottom:none; }
.lb-d-key { width:110px; font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.5px; flex-shrink:0; padding-top:1px; }
.lb-d-val { color:#1e293b; font-weight:600; flex:1; }

@media(max-width:700px){ .lb-body{ flex-direction:column; } .lb-media{ max-height:280px; } .lb-details{ max-height:none; } }
</style>
@endpush

@section('content')

@php
    $tiles    = $tiles    ?? collect();
    $programs = $programs ?? collect();
    $counts   = $counts   ?? ['total'=>0,'pending'=>0,'approved'=>0,'rejected'=>0];

    $statusIcon = ['pending'=>'fa-hourglass-half','approved'=>'fa-circle-check','rejected'=>'fa-circle-xmark'];
    $roleIcons  = [
        'attendee'=>'fa-user-check','committee_head'=>'fa-crown','coordinator'=>'fa-star',
        'secretary'=>'fa-pen-clip','treasurer'=>'fa-coins',
        'facilitator'=>'fa-chalkboard-user','committee_member'=>'fa-user',
    ];
@endphp

{{-- Hero --}}
<div class="vc-hero fu">
    <h1><i class="fa fa-images me-2" style="color:#f59e0b;"></i>Amazing You Gallery</h1>
    <p>Every proof submitted by participants — who joined, what they did, and where.</p>
    <div class="hero-bottom">
        <div class="hero-chips">
            <span class="hero-chip"><i class="fa fa-calendar-days"></i>{{ now()->format('d F Y') }}</span>
            <span class="hero-chip"><i class="fa fa-images"></i>{{ $counts['total'] }} proofs</span>
            <span class="hero-chip"><i class="fa fa-layer-group"></i>{{ $programs->count() }} programs</span>
        </div>
        <div class="view-switcher">
            <a href="{{ route('vc.programs') }}" class="vs-btn">
                <i class="fa fa-list"></i> Programs
            </a>
            <a href="{{ route('vc.gallery') }}" class="vs-btn active">
                <i class="fa fa-images"></i> Gallery
            </a>
        </div>
    </div>
</div>

{{-- Stat strip --}}
<div class="stat-strip">
    @foreach([
        ['Total Proofs', $counts['total'],    'fa-images',        '#eff6ff','#1d4ed8'],
        ['Pending',      $counts['pending'],  'fa-hourglass-half','#fef9c3','#b45309'],
        ['Approved',     $counts['approved'], 'fa-circle-check',  '#dcfce7','#15803d'],
        ['Rejected',     $counts['rejected'], 'fa-circle-xmark',  '#fee2e2','#b91c1c'],
    ] as $i => [$lbl,$val,$ico,$bg,$col])
    <div class="s-chip fu d{{ $i + 1 }}">
        <div class="s-chip-icon" style="background:{{ $bg }};"><i class="fa {{ $ico }}" style="color:{{ $col }};"></i></div>
        <div class="s-chip-val">{{ $val }}</div>
        <div class="s-chip-label">{{ $lbl }}</div>
    </div>
    @endforeach
</div>

{{-- Gallery card --}}
<div class="gal-card fu d2">
    <div class="gal-stripe"></div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <div class="toolbar-left">
            <span class="toolbar-title">Submitted Proofs</span>
            <span class="count-pill">{{ $counts['total'] }}</span>
            <button class="filter-pill on" data-f="all">All</button>
            <button class="filter-pill" data-f="pending">Pending</button>
            <button class="filter-pill" data-f="approved">Approved</button>
            <button class="filter-pill" data-f="rejected">Rejected</button>
        </div>

        <form method="GET" action="{{ route('vc.gallery') }}">
            <div class="toolbar-right">

                {{-- Program filter (server-side) --}}
                <select name="program" class="dept-sel" onchange="this.form.submit()">
                    <option value="">All Programs</option>
                    @foreach($programs as $p)
                    <option value="{{ $p->id }}" {{ (string)$selectedProgram === (string)$p->id ? 'selected' : '' }}>
                        {{ $p->title }}
                    </option>
                    @endforeach
                </select>

                {{-- Claim type filter (server-side) --}}
                <select name="type" class="dept-sel" onchange="this.form.submit()">
                    <option value="">All Roles</option>
                    @foreach($claimTypeLabels as $val => $label)
                    <option value="{{ $val }}" {{ $selectedType === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                {{-- Search (client-side) --}}
                <div class="search-wrap">
                    <i class="fa fa-magnifying-glass"></i>
                    <input id="gallerySearch" type="text" class="search-inp" placeholder="Search staff or program...">
                </div>
            </div>
        </form>
    </div>

    {{-- Masonry grid --}}
    <div class="gallery-wrap">
        @if($tiles->isEmpty())
        <div class="gal-empty">
            <i class="fa fa-image-slash"></i>
            <p>No proof submissions found for these filters.</p>
        </div>
        @else
        <div class="gallery-masonry" id="galleryGrid">
            @foreach($tiles as $t)
            <div class="gal-tile {{ $t['is_image'] ? '' : 'gal-doc-tile' }}"
                 data-status="{{ $t['status'] }}"
                 data-search="{{ strtolower($t['staff_name'].' '.$t['program_title']) }}"
                 data-bs-toggle="modal"
                 data-bs-target="#lightboxModal"
                 data-file="{{ $t['file_url'] }}"
                 data-filename="{{ $t['file_name'] }}"
                 data-is-image="{{ $t['is_image'] ? '1' : '0' }}"
                 data-staff="{{ $t['staff_name'] }}"
                 data-position="{{ $t['staff_position'] }}"
                 data-program="{{ $t['program_title'] }}"
                 data-type="{{ $t['claim_type'] }}"
                 data-type-label="{{ $t['claim_type_label'] }}"
                 data-status-full="{{ $t['status'] }}"
                 data-points="{{ $t['merit_points'] }}"
                 data-date="{{ $t['uploaded_at'] }}"
                 data-reason="{{ $t['rejection_reason'] }}">

                <span class="gal-status-badge gal-status-{{ $t['status'] }}">
                    <i class="fa {{ $statusIcon[$t['status']] ?? 'fa-circle' }}" style="font-size:9px;"></i>
                    {{ ucfirst($t['status']) }}
                </span>

                @if($t['merit_points'] > 0)
                <span class="gal-points-badge">
                    <i class="fa fa-star" style="font-size:9px;"></i>{{ $t['merit_points'] }} pts
                </span>
                @endif

                @if($t['is_image'])
                    <img src="{{ $t['file_url'] }}" alt="{{ $t['file_name'] }}" loading="lazy">
                @else
                    <div class="gal-doc-tile" style="position:absolute;inset:0;">
                        <i class="fa {{ str_contains($t['ext'],'pdf') ? 'fa-file-pdf' : (in_array($t['ext'],['doc','docx']) ? 'fa-file-word' : 'fa-file-lines') }}"></i>
                        <span>{{ $t['file_name'] }}</span>
                    </div>
                @endif

                <div class="gal-overlay">
                    <div class="gal-staff"><i class="fa {{ $roleIcons[$t['claim_type']] ?? 'fa-user' }}"></i>{{ $t['staff_name'] }}</div>
                    <div class="gal-program"><i class="fa fa-layer-group" style="font-size:9px;"></i>{{ $t['program_title'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ── Lightbox Modal ── --}}
<div class="modal fade" id="lightboxModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="m-stripe" id="lbStripe"></div>
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-image me-2" style="color:#1a56db;"></i>Proof Details</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body lb-body">
                <div class="lb-media" id="lbMedia"></div>
                <div class="lb-details">
                    <div class="lb-d-row"><div class="lb-d-key">Staff</div><div class="lb-d-val" id="lbStaff"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">Program</div><div class="lb-d-val" id="lbProgram"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">Role</div><div class="lb-d-val" id="lbType"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">Status</div><div class="lb-d-val" id="lbStatus"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">Points</div><div class="lb-d-val" id="lbPoints"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">Uploaded</div><div class="lb-d-val" id="lbDate"></div></div>
                    <div class="lb-d-row"><div class="lb-d-key">File</div><div class="lb-d-val" id="lbFileName"></div></div>
                    <div class="lb-d-row" id="lbReasonRow" style="display:none;"><div class="lb-d-key">Reason</div><div class="lb-d-val" id="lbReason" style="color:#b91c1c;"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-dismiss" data-bs-dismiss="modal">Close</button>
                <a href="#" id="lbDownload" target="_blank" class="btn-confirm" style="background:#1a56db;">
                    <i class="fa fa-download"></i> Open Original
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var sbHtml = {
    pending:  '<span style="color:#b45309;"><i class="fa fa-hourglass-half" style="font-size:10px"></i> Pending</span>',
    approved: '<span style="color:#15803d;"><i class="fa fa-circle-check" style="font-size:10px"></i> Approved</span>',
    rejected: '<span style="color:#b91c1c;"><i class="fa fa-circle-xmark" style="font-size:10px"></i> Rejected</span>',
};
var stripeColor = {
    pending:  'linear-gradient(90deg,#b45309,#fbbf24)',
    approved: 'linear-gradient(90deg,#15803d,#4ade80)',
    rejected: 'linear-gradient(90deg,#b91c1c,#f87171)',
};

// ── Status pill filter (client-side) ──
$(document).ready(function () {
    var curStatus = 'all';

    function applyFilter() {
        var q = $('#gallerySearch').val().toLowerCase().trim();
        $('#galleryGrid .gal-tile').each(function () {
            var s = $(this).data('status');
            var searchable = $(this).data('search') || '';
            var statusOk = (curStatus === 'all' || s === curStatus);
            var searchOk = (q === '' || String(searchable).indexOf(q) !== -1);
            $(this).toggle(statusOk && searchOk);
        });
    }

    $('.filter-pill').on('click', function () {
        $('.filter-pill').removeClass('on');
        $(this).addClass('on');
        curStatus = $(this).data('f');
        applyFilter();
    });

    $('#gallerySearch').on('input', applyFilter);
});

// ── Lightbox ──
document.getElementById('lightboxModal').addEventListener('show.bs.modal', function (e) {
    var b = e.relatedTarget;
    var s = b.dataset.statusFull;

    document.getElementById('lbStripe').style.background = stripeColor[s] || '#1a56db';
    document.getElementById('lbStaff').textContent   = b.dataset.staff + (b.dataset.position ? ' · ' + b.dataset.position : '');
    document.getElementById('lbProgram').textContent = b.dataset.program;
    document.getElementById('lbType').textContent    = b.dataset.typeLabel;
    document.getElementById('lbStatus').innerHTML     = sbHtml[s] || s;
    document.getElementById('lbPoints').textContent  = b.dataset.points + ' pts';
    document.getElementById('lbDate').textContent    = b.dataset.date;
    document.getElementById('lbFileName').textContent = b.dataset.filename;
    document.getElementById('lbDownload').href       = b.dataset.file;

    var reasonRow = document.getElementById('lbReasonRow');
    if (s === 'rejected' && b.dataset.reason) {
        reasonRow.style.display = 'flex';
        document.getElementById('lbReason').textContent = b.dataset.reason;
    } else {
        reasonRow.style.display = 'none';
    }

    var media = document.getElementById('lbMedia');
    if (b.dataset.isImage === '1') {
        media.innerHTML = '<img src="' + b.dataset.file + '" alt="' + b.dataset.filename + '">';
    } else {
        var ext = (b.dataset.filename.split('.').pop() || '').toLowerCase();
        var icon = ext === 'pdf' ? 'fa-file-pdf' : (['doc','docx'].indexOf(ext) !== -1 ? 'fa-file-word' : 'fa-file-lines');
        media.innerHTML = '<div class="lb-doc-preview"><i class="fa ' + icon + '"></i><span>' + b.dataset.filename + '</span></div>';
    }
});
</script>
@endpush
