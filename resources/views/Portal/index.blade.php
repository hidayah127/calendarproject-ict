<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AmazingTrack — Be An Amazing You Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
*,*::before,*::after { box-sizing:border-box; }

body {
    font-family:'Plus Jakarta Sans',sans-serif;
    background:#f0f4ff;
    background-image:radial-gradient(circle,#c7d5f8 1px,transparent 1px);
    background-size:28px 28px;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

@keyframes fadeUp {
    from{opacity:0;transform:translateY(24px);}
    to{opacity:1;transform:translateY(0);}
}
.fu{animation:fadeUp .5s ease both;}
.d1{animation-delay:.1s;}
.d2{animation-delay:.2s;}
.d3{animation-delay:.3s;}

/* ── Card ── */
.portal-card {
    background:#fff;
    border:1.5px solid #e2e8f0;
    border-radius:24px;
    box-shadow:0 20px 60px rgba(15,45,110,.14);
    width:100%;
    max-width:480px;
    overflow:hidden;
}

/* ── Header ── */
.portal-header {
    background:linear-gradient(135deg,#0a1f52 0%,#0f2d6e 50%,#1e56db 100%);
    padding:36px 36px 30px;
    position:relative;
    overflow:hidden;
    text-align:center;
}
.portal-header::before {
    content:'';position:absolute;
    width:260px;height:260px;border-radius:50%;
    background:rgba(245,158,11,.12);
    top:-80px;right:-60px;pointer-events:none;
}
.portal-header::after {
    content:'';position:absolute;
    width:160px;height:160px;border-radius:50%;
    background:rgba(96,165,250,.10);
    bottom:-50px;left:20%;pointer-events:none;
}

.portal-logo {
    display:inline-flex;align-items:center;justify-content:center;
    font-size:30px;color:#f59e0b;
    margin-bottom:16px;
    position:relative;z-index:1;
}



.portal-logo img {
    width: 100px;
    height: auto;
    object-fit: contain;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,.3));
}

.portal-header h1 {
    font-size:1.45rem;font-weight:900;color:#fff;
    margin:0 0 6px;position:relative;z-index:1;
}
.portal-header p {
    font-size:13.5px;color:rgba(255,255,255,.62);
    margin:0;position:relative;z-index:1;
}

/* ── Body ── */
.portal-body { padding:32px 36px 36px; }

.portal-tagline {
    font-size: 12px;
    color: rgba(255,255,255,.75);
    margin-top: 4px;
    font-style: italic;
    letter-spacing: .3px;
}

.form-label-custom {
    font-size:12px;font-weight:700;color:#475569;
    text-transform:uppercase;letter-spacing:.5px;
    display:block;margin-bottom:8px;
}



.id-input {
    border:2px solid #e2e8f0;
    border-radius:14px;
    padding:14px 18px;
    font-size:1.1rem;
    font-family:inherit;
    font-weight:700;
    letter-spacing:2px;
    color:#0f172a;
    background:#f8faff;
    width:100%;
    outline:none;
    text-transform:uppercase;
    transition:border-color .2s,box-shadow .2s;
    text-align:center;
}
.id-input:focus {
    border-color:#1a56db;
    box-shadow:0 0 0 4px rgba(26,86,219,.12);
    background:#fff;
}
.id-input.is-invalid {
    border-color:#ef4444;
    box-shadow:0 0 0 4px rgba(239,68,68,.10);
}

.btn-lookup {
    width:100%;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff;border:none;border-radius:14px;
    padding:15px;font-size:15px;font-weight:800;
    font-family:inherit;cursor:pointer;
    box-shadow:0 6px 20px rgba(26,86,219,.30);
    transition:all .22s;
    display:flex;align-items:center;justify-content:center;gap:10px;
    margin-top:20px;
}
.btn-lookup:hover {
    transform:translateY(-2px);
    box-shadow:0 10px 28px rgba(26,86,219,.38);
}
.btn-lookup:active { transform:translateY(0); }

/* ── Info pills ── */
.info-pills {
    display:flex;flex-wrap:wrap;gap:8px;
    margin-top:24px;justify-content:center;
}
.info-pill {
    background:#f1f5f9;color:#475569;
    font-size:12px;font-weight:600;
    padding:5px 12px;border-radius:20px;
    display:inline-flex;align-items:center;gap:6px;
}
.info-pill i { font-size:11px;color:#1a56db; }

/* ── Merit legend ── */
.merit-legend {
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:14px;padding:16px 18px;margin-top:20px;
}
.merit-legend-title {
    font-size:11px;font-weight:700;color:#94a3b8;
    text-transform:uppercase;letter-spacing:.5px;
    margin-bottom:12px;
}
.merit-row {
    display:flex;align-items:center;justify-content:space-between;
    padding:5px 0;border-bottom:1px solid #f1f5f9;font-size:13px;
}
.merit-row:last-child{border-bottom:none;}
.merit-role { font-weight:600;color:#334155;display:flex;align-items:center;gap:8px; }
.merit-role i { font-size:11px;color:#64748b; }
.merit-pts {
    font-weight:800;font-size:13.5px;
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* ── Error ── */
.alert-custom {
    background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;
    padding:13px 16px;color:#b91c1c;font-size:13.5px;font-weight:600;
    display:flex;align-items:center;gap:10px;margin-bottom:20px;
}
</style>
</head>

<body>

<div class="portal-card fu">

    {{-- Header without logo.png--}}
    {{-- <div class="portal-header">
        <div class="portal-logo"><i class="fa fa-graduation-cap"></i></div>
        <h1>Staff Portal</h1>
        <p>Check in to programs & claim your Amazing merit points</p>
    </div> --}}

    {{-- Header with logo.png --}}
    <div class="portal-header">
        <div class="portal-logo">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="logo-img">
        </div>
        <h1>Be An Amazing You Portal</h1>
        <p>Check in to programs & claim your Amazing merit points</p>
        <p class="portal-tagline">
            "Empowering Amazing Performance"
        </p>
    </div>

    {{-- Body --}}
    <div class="portal-body">

        @if($errors->has('staff_id'))
        <div class="alert-custom fu d1">
            <i class="fa fa-circle-xmark" style="font-size:18px;flex-shrink:0;"></i>
            {{ $errors->first('staff_id') }}
        </div>
        @endif

        <form method="POST" action="{{ route('portal.lookup') }}">
            @csrf

            <label class="form-label-custom">Enter Your Staff ID</label>
            <input type="text"
                   name="staff_id"
                   class="id-input {{ $errors->has('staff_id') ? 'is-invalid' : '' }}"
                   placeholder="e.g. FP04428"
                   value="{{ old('staff_id') }}"
                   autocomplete="off"
                   spellcheck="false"
                   autofocus>

            <button type="submit" class="btn-lookup">
                <i class="fa fa-arrow-right-to-bracket"></i>
                Access My Dashboard
            </button>
        </form>

        {{-- <div class="info-pills fu d2">
            <span class="info-pill"><i class="fa fa-lock"></i> No password needed</span>
            <span class="info-pill"><i class="fa fa-shield-halved"></i> Staff ID only</span>
            <span class="info-pill"><i class="fa fa-star"></i> Earn merit points</span>
        </div> --}}

        {{-- Merit legend --}}
        <div class="merit-legend fu d3">
            <div class="merit-legend-title"><i class="fa fa-star me-1"></i> Merit Points by Role</div>
            @foreach(App\Models\MeritClaim::$meritPoints as $type => $pts)  
            <div class="merit-row">
                <span class="merit-role">
                    <i class="fa {{ App\Models\MeritClaim::$claimIcons[$type] ?? 'fa-user' }}"></i>
                    {{ App\Models\MeritClaim::$claimLabels[$type] ?? ucfirst($type) }}
                </span>
                <span class="merit-pts">{{ $pts }} pts</span>
            </div>
            @endforeach
        </div>

    </div>
</div>

</body>
</html>
