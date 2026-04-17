<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>{{ $staff->name }} — Staff Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
*,*::before,*::after{box-sizing:border-box;}
body {
    font-family:'Plus Jakarta Sans',sans-serif;
    background:#f0f4ff;
    background-image:radial-gradient(circle,#c7d5f8 1px,transparent 1px);
    background-size:28px 28px;
    color:#1e293b;
    font-size:15px;
    min-height:100vh;
}
::-webkit-scrollbar{width:6px;}
::-webkit-scrollbar-thumb{background:#c7d5f8;border-radius:10px;}

@keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
.fu{animation:fadeUp .42s ease both;}
.d1{animation-delay:.06s;}.d2{animation-delay:.12s;}
.d3{animation-delay:.18s;}.d4{animation-delay:.24s;}
.d5{animation-delay:.30s;}

/* ── Topbar ── */
.topbar {
    background:linear-gradient(135deg,#0a1f52 0%,#0f2d6e 50%,#1e56db 100%);
    padding:0;position:sticky;top:0;z-index:100;
    box-shadow:0 4px 20px rgba(15,45,110,.25);
}
.topbar::before {
    content:'';position:absolute;inset:0;
    background-image:linear-gradient(rgba(255,255,255,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.04) 1px,transparent 1px);
    background-size:30px 30px;pointer-events:none;
}
.topbar-inner {
    position:relative;z-index:1;
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 28px;gap:16px;flex-wrap:wrap;
}
.topbar-brand { display:flex;align-items:center;gap:10px; }
.topbar-logo  {
    width:38px;height:38px;border-radius:10px;
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.22);
    display:flex;align-items:center;justify-content:center;
    color:#f59e0b;font-size:17px;
}
.topbar-brand h1 { font-size:1.1rem;font-weight:800;color:#fff;margin:0; }
.topbar-brand p  { font-size:12px;color:rgba(255,255,255,.55);margin:0; }

.staff-badge {
    display:flex;align-items:center;gap:10px;
    background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.20);
    border-radius:12px;padding:8px 14px;backdrop-filter:blur(4px);
}
.staff-av {
    width:34px;height:34px;border-radius:9px;
    background:linear-gradient(135deg,#f59e0b,#b45309);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-size:12px;font-weight:800;flex-shrink:0;
}
.staff-badge-name { font-size:13px;font-weight:700;color:#fff; }
.staff-badge-id   { font-size:11px;color:rgba(255,255,255,.55); }

.merit-counter {
    display:flex;align-items:center;gap:8px;
    background:rgba(245,158,11,.20);border:1px solid rgba(245,158,11,.35);
    border-radius:12px;padding:8px 14px;
}
.merit-counter i { color:#f59e0b;font-size:15px; }
.merit-counter span { font-size:13px;font-weight:800;color:#fff; }
.merit-counter small{ font-size:11px;color:rgba(255,255,255,.60); }

.btn-back {
    background:rgba(255,255,255,.12);border:1.5px solid rgba(255,255,255,.22);
    border-radius:10px;padding:8px 16px;color:rgba(255,255,255,.88);
    font-size:13px;font-weight:700;text-decoration:none;
    display:inline-flex;align-items:center;gap:7px;transition:all .2s;
}
.btn-back:hover{background:rgba(255,255,255,.22);color:#fff;text-decoration:none;}

/* ── Page layout ── */
.portal-body { max-width:1100px;margin:0 auto;padding:28px 20px; }

/* ── Section titles ── */
.section-title {
    font-size:1.15rem;font-weight:800;color:#0f172a;
    display:flex;align-items:center;gap:10px;margin-bottom:16px;
}
.section-title i {
    width:32px;height:32px;border-radius:9px;
    display:inline-flex;align-items:center;justify-content:center;
    font-size:14px;flex-shrink:0;
}

/* ── Merit summary cards ── */
.merit-strip {
    display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:26px;
}
@media(max-width:900px){.merit-strip{grid-template-columns:repeat(2,1fr);}}
@media(max-width:500px){.merit-strip{grid-template-columns:1fr;}}

.ms-card {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:16px;
    padding:16px 18px;box-shadow:0 2px 10px rgba(15,45,110,.05);
    transition:transform .2s,box-shadow .2s;display:flex;align-items:center;gap:13px;
}
.ms-card:hover{transform:translateY(-3px);box-shadow:0 8px 22px rgba(15,45,110,.10);}
.ms-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;}
.ms-val  {font-size:1.7rem;font-weight:900;color:#0f172a;line-height:1;}
.ms-label{font-size:12px;color:#64748b;font-weight:600;margin-top:2px;}

/* ── Programs list ── */
.prog-panel {
    background:#fff;border:1.5px solid #e2e8f0;border-radius:18px;
    overflow:hidden;box-shadow:0 3px 16px rgba(15,45,110,.07);margin-bottom:26px;
}
.prog-panel-stripe{height:5px;background:linear-gradient(90deg,#0f2d6e,#1a56db,#3b82f6);}
.prog-panel-header{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 22px 14px;border-bottom:1px solid #f1f5f9;
}
.prog-panel-title{font-size:14px;font-weight:800;color:#0f172a;}

.prog-item {
    border-bottom:1px solid #f1f5f9;
    transition:background .15s;
}
.prog-item:last-child{border-bottom:none;}
.prog-item-header{
    display:flex;align-items:flex-start;justify-content:space-between;
    gap:14px;padding:16px 22px;cursor:pointer;
    transition:background .15s;
}
.prog-item-header:hover{background:#f8faff;}

.prog-color-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:5px;}
.prog-title-text{font-size:14px;font-weight:700;color:#0f172a;}
.prog-meta-text {font-size:12px;color:#94a3b8;margin-top:3px;display:flex;flex-wrap:wrap;gap:10px;}
.prog-meta-text i{font-size:11px;}

.sb{font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;flex-shrink:0;}
.sb-upcoming{background:#dbeafe;color:#1d4ed8;}
.sb-ongoing {background:#dcfce7;color:#15803d;}
.sb-completed{background:#e0e7ff;color:#3730a3;}
.sb-rescheduled{background:#fef9c3;color:#b45309;}

/* ── Claim form (expandable) ── */
.claim-form-wrap{
    padding:0 22px 0;max-height:0;overflow:hidden;
    transition:max-height .35s ease,padding .3s;
}
.claim-form-wrap.open{max-height:600px;padding:0 22px 18px;}

.claim-section-title{
    font-size:11.5px;font-weight:700;color:#64748b;
    text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;margin-top:16px;
}

/* Role claim cards */
.role-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin-bottom:14px;}

.role-card {
    border:1.5px solid #e2e8f0;border-radius:13px;padding:13px;
    cursor:pointer;transition:all .2s;position:relative;
    background:#fff;text-align:center;
}
.role-card:hover{border-color:#bfdbfe;background:#f8faff;transform:translateY(-2px);}
.role-card.selected{border-color:#1a56db;background:#eff6ff;box-shadow:0 0 0 3px rgba(26,86,219,.12);}
.role-card.claimed{border-color:#bbf7d0;background:#f0fdf4;cursor:not-allowed;opacity:.7;}
.role-card.claimed-rejected{border-color:#fecaca;background:#fef2f2;cursor:not-allowed;opacity:.7;}

.role-card input[type="radio"]{display:none;}
.role-card-icon{font-size:22px;margin-bottom:8px;display:block;}
.role-card-label{font-size:12.5px;font-weight:700;color:#1e293b;display:block;margin-bottom:4px;}
.role-card-pts{
    font-size:11.5px;font-weight:800;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.role-card-badge{
    position:absolute;top:-8px;right:8px;
    font-size:9.5px;font-weight:800;padding:2px 7px;border-radius:20px;
}
.badge-approved{background:#dcfce7;color:#15803d;}
.badge-pending {background:#fef9c3;color:#b45309;}
.badge-rejected{background:#fee2e2;color:#b91c1c;}

/* Upload area */
.upload-area {
    border:2px dashed #bfdbfe;border-radius:12px;padding:20px;
    text-align:center;cursor:pointer;transition:all .2s;background:#f8faff;
    margin-bottom:12px;
}
.upload-area:hover{border-color:#1a56db;background:#f0f6ff;}
.upload-area input[type="file"]{display:none;}
.upload-area-icon{font-size:28px;color:#bfdbfe;display:block;margin-bottom:8px;}
.upload-area-text{font-size:13px;font-weight:600;color:#64748b;}
.upload-area-sub {font-size:11.5px;color:#94a3b8;margin-top:4px;}
.upload-preview{font-size:12.5px;font-weight:700;color:#1d4ed8;margin-top:6px;}

.btn-submit-claim {
    width:100%;background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff;border:none;border-radius:12px;padding:12px;
    font-size:14px;font-weight:800;font-family:inherit;cursor:pointer;
    box-shadow:0 4px 14px rgba(26,86,219,.28);transition:all .22s;
    display:flex;align-items:center;justify-content:center;gap:9px;
}
.btn-submit-claim:hover{transform:translateY(-2px);box-shadow:0 7px 20px rgba(26,86,219,.36);}

/* ── My claims ── */
.claim-item {
    display:flex;align-items:flex-start;gap:14px;
    padding:14px 22px;border-bottom:1px solid #f1f5f9;transition:background .15s;
}
.claim-item:hover{background:#f8faff;}
.claim-item:last-child{border-bottom:none;}

.claim-icon{
    width:40px;height:40px;border-radius:11px;
    display:flex;align-items:center;justify-content:center;
    font-size:16px;flex-shrink:0;
}
.claim-title{font-size:13.5px;font-weight:700;color:#0f172a;}
.claim-prog {font-size:12px;color:#94a3b8;margin-top:2px;}
.claim-pts  {
    font-size:1.1rem;font-weight:900;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    flex-shrink:0;text-align:right;
}
.claim-pts small{font-size:10px;color:#94a3b8;display:block;font-weight:600;-webkit-text-fill-color:#94a3b8;}

.status-badge{font-size:11px;font-weight:700;padding:3px 9px;border-radius:20px;display:inline-flex;align-items:center;gap:4px;margin-top:4px;}
.s-pending {background:#fef9c3;color:#b45309;}
.s-approved{background:#dcfce7;color:#15803d;}
.s-rejected{background:#fee2e2;color:#b91c1c;}

.btn-upload-proof {
    background:#eff6ff;color:#1d4ed8;border:none;border-radius:8px;
    padding:5px 12px;font-size:12px;font-weight:700;cursor:pointer;
    font-family:inherit;transition:background .2s;display:inline-flex;align-items:center;gap:5px;
    margin-top:6px;
}
.btn-upload-proof:hover{background:#dbeafe;}

/* ── Flash messages ── */
.flash-success{background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:13px;padding:13px 18px;color:#15803d;font-size:13.5px;font-weight:600;display:flex;align-items:center;gap:10px;margin-bottom:18px;}
.flash-error  {background:#fef2f2;border:1.5px solid #fecaca;border-radius:13px;padding:13px 18px;color:#b91c1c;font-size:13.5px;font-weight:600;display:flex;align-items:center;gap:10px;margin-bottom:18px;}

/* ── Search ── */
.search-bar{position:relative;margin-bottom:16px;}
.search-bar i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:14px;pointer-events:none;}
.search-bar input{
    width:100%;border:1.5px solid #e2e8f0;border-radius:12px;
    padding:11px 14px 11px 40px;font-size:14px;font-family:inherit;
    background:#fff;color:#1e293b;outline:none;
    transition:border-color .2s,box-shadow .2s;
}
.search-bar input:focus{border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.10);}

/* filter pills */
.filter-pills{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;}
.fp{background:#fff;border:1.5px solid #e2e8f0;border-radius:20px;padding:5px 13px;font-size:12px;font-weight:700;color:#475569;cursor:pointer;font-family:inherit;transition:all .18s;}
.fp:hover,.fp.on{background:#eff6ff;border-color:#bfdbfe;color:#1d4ed8;}

/* dot colors */
.dot-upcoming   {background:#3b82f6;}
.dot-ongoing    {background:#16a34a;}
.dot-completed  {background:#6366f1;}
.dot-rescheduled{background:#f59e0b;}
</style>
</head>

<body>

{{-- ── Topbar ── --}}
<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-brand">
            <div class="topbar-logo"><i class="fa fa-graduation-cap"></i></div>
            <div>
                <h1>AmazingTrack</h1>
                <p>Staff Self-Service Portal</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            {{-- Merit counter --}}
            <div class="merit-counter">
                <i class="fa fa-star"></i>
                <div>
                    <span>{{ $totalMerits }} pts</span><br>
                    <small>Total Merit</small>
                </div>
            </div>

            {{-- Staff badge --}}
            <div class="staff-badge">
                <div class="staff-av">{{ strtoupper(substr($staff->name,0,2)) }}</div>
                <div>
                    <div class="staff-badge-name">{{ $staff->name }}</div>
                    <div class="staff-badge-id">{{ $staff->staff_id }}</div>
                </div>
            </div>

            {{-- Back --}}
            <a href="{{ route('portal.index') }}" class="btn-back">
                <i class="fa fa-arrow-right-to-bracket fa-flip-horizontal"></i> Exit
            </a>
        </div>
    </div>
</div>

{{-- ── Portal body ── --}}
<div class="portal-body">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="flash-success fu"><i class="fa fa-circle-check" style="font-size:18px;flex-shrink:0;"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="flash-error fu"><i class="fa fa-circle-xmark" style="font-size:18px;flex-shrink:0;"></i> {{ session('error') }}</div>
    @endif

    {{-- ── Merit summary strip ── --}}
    @php
        $pendingCount  = $claims->where('status','pending')->count();
        $approvedCount = $claims->where('status','approved')->count();
        $rejectedCount = $claims->where('status','rejected')->count();
    @endphp
    <div class="merit-strip">
        <div class="ms-card fu d1">
            <div class="ms-icon" style="background:#fefce8;"><i class="fa fa-star" style="color:#f59e0b;"></i></div>
            <div><div class="ms-val">{{ $totalMerits }}</div><div class="ms-label">Total Merit Points</div></div>
        </div>
        <div class="ms-card fu d2">
            <div class="ms-icon" style="background:#f0fdf4;"><i class="fa fa-circle-check" style="color:#15803d;"></i></div>
            <div><div class="ms-val">{{ $approvedCount }}</div><div class="ms-label">Approved Claims</div></div>
        </div>
        <div class="ms-card fu d3">
            <div class="ms-icon" style="background:#fef9c3;"><i class="fa fa-clock" style="color:#b45309;"></i></div>
            <div><div class="ms-val">{{ $pendingCount }}</div><div class="ms-label">Pending Review</div></div>
        </div>
        <div class="ms-card fu d4">
            <div class="ms-icon" style="background:#eff6ff;"><i class="fa fa-layer-group" style="color:#1d4ed8;"></i></div>
            <div><div class="ms-val">{{ $claims->count() }}</div><div class="ms-label">Total Submissions</div></div>
        </div>
    </div>

    <div class="row g-4">

        {{-- ── LEFT: Programs to claim ── --}}
        <div class="col-lg-7">

            <div class="section-title fu d1">
                <i class="fa fa-calendar-check" style="background:#eff6ff;color:#1d4ed8;"></i>
                Available Programs
            </div>

            {{-- Search & filter --}}
            <div class="search-bar fu d2">
                <i class="fa fa-magnifying-glass"></i>
                <input type="text" id="progSearch" placeholder="Search programs…">
            </div>
            <div class="filter-pills fu d2">
                <button class="fp on" data-f="all">All</button>
                <button class="fp" data-f="upcoming">Upcoming</button>
                <button class="fp" data-f="ongoing">Ongoing</button>
                <button class="fp" data-f="completed">Completed</button>
            </div>

            <div class="prog-panel fu d3" id="progList">
                <div class="prog-panel-stripe"></div>
                <div class="prog-panel-header">
                    <span class="prog-panel-title">
                        <i class="fa fa-layer-group me-2" style="color:#1a56db;"></i>
                        {{ $programs->count() }} Programs
                    </span>
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

                <div class="prog-item" data-status="{{ $program->status }}" data-title="{{ strtolower($program->title) }}">

                    {{-- Program header (clickable to expand) --}}
                    <div class="prog-item-header" onclick="toggleProgram({{ $program->id }})">
                        <div class="d-flex align-items-start gap-2" style="flex:1;min-width:0;">
                            <div class="prog-color-dot {{ $dotClass }}" style="margin-top:5px;flex-shrink:0;"></div>
                            <div style="min-width:0;">
                                <div class="prog-title-text">{{ $program->title }}</div>
                                <div class="prog-meta-text">
                                    <span><i class="fa fa-building"></i> {{ $program->department->name ?? '—' }}</span>
                                    <span><i class="fa fa-location-dot"></i> {{ $program->venue }}</span>
                                    <span><i class="fa fa-calendar-days"></i> {{ $program->start_date->format('d M Y') }} — {{ $program->end_date->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <span class="sb {{ $sbClass }}">{{ ucfirst($program->status) }}</span>
                            <i class="fa fa-chevron-down" id="chevron-{{ $program->id }}" style="font-size:12px;color:#94a3b8;transition:transform .25s;"></i>
                        </div>
                    </div>

                    {{-- Claim form (collapsible) --}}
                    <div class="claim-form-wrap" id="form-{{ $program->id }}">

                        <div class="claim-section-title">Select your role in this program:</div>

                        <form method="POST" action="{{ route('portal.claim') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="staff_id"   value="{{ $staff->id }}">
                            <input type="hidden" name="program_id" value="{{ $program->id }}">
                            <input type="hidden" name="claim_type" id="claimType-{{ $program->id }}" value="">

                            {{-- Role cards --}}
                            <div class="role-grid">
                                @foreach($roleTypes as $role)
                                @php
                                    $key      = $program->id . '_' . $role;
                                    $existing = $claims->where('program_id', $program->id)->where('claim_type', $role)->first();
                                    $isClaimed = isset($claimedKeys[$key]);
                                    $claimStatus = $existing?->status;
                                @endphp

                                <label class="role-card {{ $isClaimed ? ($claimStatus === 'rejected' ? 'claimed-rejected' : 'claimed') : '' }}"
                                       onclick="{{ $isClaimed ? 'return false' : "selectRole('{$program->id}','{$role}', this)" }}">

                                    @if($isClaimed)
                                    <span class="role-card-badge {{ $claimStatus === 'approved' ? 'badge-approved' : ($claimStatus === 'rejected' ? 'badge-rejected' : 'badge-pending') }}">
                                        {{ ucfirst($claimStatus) }}
                                    </span>
                                    @endif

                                    <i class="fa {{ App\Models\MeritClaim::$claimIcons[$role] ?? 'fa-user' }} role-card-icon"
                                       style="color:{{ $isClaimed ? '#94a3b8' : '#1a56db' }};"></i>
                                    <span class="role-card-label">{{ App\Models\MeritClaim::$claimLabels[$role] }}</span>
                                    <span class="role-card-pts">{{ App\Models\MeritClaim::$meritPoints[$role] }} pts</span>

                                </label>
                                @endforeach
                            </div>

                            {{-- Proof upload --}}
                            <div class="upload-area" onclick="document.getElementById('proof-{{ $program->id }}').click()">
                                <input type="file" id="proof-{{ $program->id }}" name="proof"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       onchange="showPreview('{{ $program->id }}', this)">
                                <i class="fa fa-cloud-arrow-up upload-area-icon"></i>
                                <div class="upload-area-text">Upload Proof (optional)</div>
                                <div class="upload-area-sub">Photo, screenshot or PDF · Max 5MB</div>
                                <div class="upload-preview" id="preview-{{ $program->id }}"></div>
                            </div>

                            <button type="submit" class="btn-submit-claim"
                                    id="submitBtn-{{ $program->id }}" disabled>
                                <i class="fa fa-paper-plane"></i> Submit Claim
                            </button>

                        </form>
                    </div>

                </div>
                @empty
                <div style="text-align:center;padding:40px;color:#94a3b8;">
                    <i class="fa fa-calendar-xmark" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                    No programs available.
                </div>
                @endforelse

            </div>
        </div>

        {{-- ── RIGHT: My claims ── --}}
        <div class="col-lg-5">

            <div class="section-title fu d1">
                <i class="fa fa-list-check" style="background:#f0fdf4;color:#15803d;"></i>
                My Claims & Merit History
            </div>

            <div class="prog-panel fu d2">
                <div class="prog-panel-stripe" style="background:linear-gradient(90deg,#15803d,#4ade80);"></div>
                <div class="prog-panel-header">
                    <span class="prog-panel-title">
                        <i class="fa fa-star me-2" style="color:#f59e0b;"></i>
                        {{ $totalMerits }} Merit Points Earned
                    </span>
                </div>

                @forelse($claims as $claim)
                <div class="claim-item">
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
                        <span class="status-badge s-{{ $claim->status }}">
                            @if($claim->status === 'approved')
                                <i class="fa fa-circle-check" style="font-size:9px;"></i> Approved
                            @elseif($claim->status === 'rejected')
                                <i class="fa fa-circle-xmark" style="font-size:9px;"></i> Rejected
                            @else
                                <i class="fa fa-clock" style="font-size:9px;"></i> Pending
                            @endif
                        </span>

                        @if($claim->status === 'rejected' && $claim->rejection_reason)
                        <div style="font-size:11.5px;color:#b91c1c;margin-top:4px;font-style:italic;">
                            <i class="fa fa-circle-exclamation me-1"></i>{{ $claim->rejection_reason }}
                        </div>
                        @endif

                        {{-- Upload proof button for pending/rejected with no proof --}}
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
                        @elseif($claim->proof_path)
                        <div style="font-size:11.5px;color:#15803d;margin-top:4px;">
                            <i class="fa fa-file-circle-check me-1"></i>
                            Proof: {{ $claim->proof_original_name ?? 'Uploaded' }}
                        </div>
                        @endif
                    </div>
                    <div class="claim-pts">
                        {{ $claim->status === 'approved' ? $claim->merit_points : '–' }}
                        <small>pts</small>
                    </div>
                </div>
                @empty
                <div style="text-align:center;padding:40px 20px;color:#94a3b8;">
                    <i class="fa fa-inbox" style="font-size:36px;display:block;margin-bottom:12px;color:#cbd5e1;"></i>
                    <p style="font-size:13.5px;margin:0;">No claims yet.<br>Select a program on the left to get started.</p>
                </div>
                @endforelse

            </div>

            {{-- Merit breakdown by role --}}
            @if($approvedCount > 0)
            <div class="prog-panel fu d3">
                <div class="prog-panel-stripe" style="background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
                <div class="prog-panel-header">
                    <span class="prog-panel-title">
                        <i class="fa fa-trophy me-2" style="color:#f59e0b;"></i>
                        Merit Breakdown
                    </span>
                </div>
                @foreach($claims->where('status','approved')->groupBy('claim_type') as $type => $typeClaims)
                <div style="display:flex;align-items:center;gap:12px;padding:11px 22px;border-bottom:1px solid #f8faff;">
                    <div style="width:32px;height:32px;border-radius:9px;background:#fefce8;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                        <i class="fa {{ App\Models\MeritClaim::$claimIcons[$type] ?? 'fa-user' }}" style="color:#b45309;"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:13px;font-weight:700;color:#0f172a;">{{ App\Models\MeritClaim::$claimLabels[$type] ?? ucfirst($type) }}</div>
                        <div style="font-size:11.5px;color:#94a3b8;">{{ $typeClaims->count() }} {{ Str::plural('claim',$typeClaims->count()) }}</div>
                    </div>
                    <div style="font-size:1.2rem;font-weight:900;background:linear-gradient(135deg,#b45309,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        {{ $typeClaims->sum('merit_points') }} pts
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>

<script>
/* ── Toggle program expand ── */
function toggleProgram(id) {
    var wrap    = document.getElementById('form-' + id);
    var chevron = document.getElementById('chevron-' + id);
    var isOpen  = wrap.classList.contains('open');
    // Close all others
    document.querySelectorAll('.claim-form-wrap.open').forEach(function(el){ el.classList.remove('open'); });
    document.querySelectorAll('[id^="chevron-"]').forEach(function(el){ el.style.transform=''; });
    if (!isOpen) {
        wrap.classList.add('open');
        chevron.style.transform = 'rotate(180deg)';
    }
}

/* ── Select role card ── */
function selectRole(programId, role, card) {
    // Deselect all in this program
    card.closest('.role-grid').querySelectorAll('.role-card:not(.claimed):not(.claimed-rejected)').forEach(function(c){
        c.classList.remove('selected');
    });
    card.classList.add('selected');
    document.getElementById('claimType-' + programId).value = role;
    document.getElementById('submitBtn-' + programId).disabled = false;
}

/* ── Show file preview ── */
function showPreview(programId, input) {
    var preview = document.getElementById('preview-' + programId);
    if (input.files && input.files[0]) {
        preview.textContent = '✓ ' + input.files[0].name;
    }
}

/* ── Search programs ── */
document.getElementById('progSearch').addEventListener('input', function(){
    var q = this.value.toLowerCase();
    document.querySelectorAll('.prog-item').forEach(function(item){
        var title = item.dataset.title || '';
        item.style.display = title.includes(q) ? '' : 'none';
    });
});

/* ── Filter pills ── */
var curFilter = 'all';
document.querySelectorAll('.fp').forEach(function(pill){
    pill.addEventListener('click', function(){
        document.querySelectorAll('.fp').forEach(function(p){ p.classList.remove('on'); });
        this.classList.add('on');
        curFilter = this.dataset.f;
        document.querySelectorAll('.prog-item').forEach(function(item){
            var s = item.dataset.status;
            item.style.display = (curFilter === 'all' || s === curFilter) ? '' : 'none';
        });
    });
});
</script>

</body>
</html>
