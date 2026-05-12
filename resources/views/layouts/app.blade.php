<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title','AmazingTrack')</title>

<link rel="icon" type="image/png" href="{{ asset('logo/icon.png') }}">
<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

{{-- Google Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

{{-- PWA Styles --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">

{{-- Select2 Styles --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<meta name="theme-color" content="#0f2d6e">


<style>
/* ── CSS Variables ── */
:root {
    --sidebar-from:     #0f2d6e;
    --sidebar-to:       #1a56db;
    --accent:           #f59e0b;
    --accent-light:     #fef3c7;
    --bg:               #f0f4ff;
    --surface:          #ffffff;
    --text-main:        #1e293b;
    --text-muted:       #64748b;
    --border:           #e2e8f0;
    --radius-lg:        16px;
    --radius-md:        10px;
    --shadow-sm:        0 1px 4px rgba(0,0,0,0.06);
    --shadow-md:        0 6px 24px rgba(15,45,110,0.10);
    --shadow-hover:     0 14px 36px rgba(15,45,110,0.14);
    --transition:       all .28s cubic-bezier(.4,0,.2,1);
}

/* ── Global ── */
*,*::before,*::after { box-sizing: border-box; }

body {
    background: var(--bg);
    font-family: 'Plus Jakarta Sans', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text-main);
    font-size: 15px;
    /* subtle dot-grid texture */
    background-image: radial-gradient(circle, #c7d5f8 1px, transparent 1px);
    background-size: 28px 28px;
}

/* ── Sidebar ── */
.sidebar {
    background: linear-gradient(175deg, var(--sidebar-from) 0%, var(--sidebar-to) 100%);
    min-height: 100vh;
    box-shadow: 4px 0 20px rgba(15,45,110,0.18);
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

/* decorative glow circles */
.sidebar::before,
.sidebar::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.sidebar::before {
    width: 200px; height: 200px;
    background: rgba(245,158,11,0.12);
    top: -60px; right: -60px;
}
.sidebar::after {
    width: 160px; height: 160px;
    background: rgba(96,165,250,0.10);
    bottom: 40px; left: -50px;
}

/* brand block */
.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 28px 22px 22px;
    border-bottom: 1px solid rgba(255,255,255,0.12);
    margin-bottom: 8px;
}

.sidebar-brand .brand-icon {
    width: 38px; height: 38px;
    background: var(--accent);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: #fff;
    box-shadow: 0 4px 12px rgba(245,158,11,0.45);
    flex-shrink: 0;
}

.sidebar h4 {
    font-weight: 700;
    letter-spacing: .6px;
    font-size: 1.1rem;
    color: #fff;
    margin: 0;
}

.sidebar-logo {
    width: 100px;
    height: auto;
    margin-bottom: 6px;
}

/* nav section label */
.sidebar .nav-label {
    font-size: 10.5px;
    font-weight: 600;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: rgba(255,255,255,0.42);
    padding: 18px 22px 6px;
}

.sidebar a {
    color: rgba(255,255,255,0.82);
    padding: 11px 22px;
    display: flex;
    align-items: center;
    gap: 11px;
    text-decoration: none;
    transition: var(--transition);
    font-size: 14.5px;
    font-weight: 500;
    border-radius: 0 50px 50px 0;
    margin-right: 16px;
    position: relative;
}

.sidebar a i {
    width: 20px;
    text-align: center;
    font-size: 15px;
    flex-shrink: 0;
}

/* active pill */
.sidebar a.active,
.sidebar a:hover {
    background: rgba(255,255,255,0.14);
    color: #fff;
    padding-left: 28px;
    box-shadow: inset 3px 0 0 var(--accent);
}

.sidebar a.active::after {
    content: '';
    position: absolute;
    right: -16px; top: 50%;
    transform: translateY(-50%);
    width: 8px; height: 8px;
    background: var(--accent);
    border-radius: 50%;
}

/* ── Desktop Sidebar Toggle ── */

/* Collapse sidebar column */
body.sidebar-collapsed .sidebar {
    width: 0 !important;
    min-width: 0 !important;
    flex: 0 0 0 !important;
    overflow: hidden;
    padding: 0 !important;
}

/* Expand main content */
body.sidebar-collapsed main {
    flex: 0 0 100% !important;
    max-width: 100% !important;
}

/* Smooth animation */
.sidebar,
main {
    transition: all 0.3s ease;
}

/* ── Navbar ── */
.navbar {
    background: var(--surface) !important;
    border-bottom: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
    padding: 0 24px;
    min-height: 62px;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--text-main) !important;
    display: flex; align-items: center; gap: 8px;
}

.navbar-brand .brand-dot {
    width: 9px; height: 9px;
    background: var(--accent);
    border-radius: 50%;
    display: inline-block;
}

/* avatar / user badge */
.nav-avatar {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    box-shadow: 0 2px 8px rgba(15,45,110,0.25);
}

/* notification bell badge */
.navbar .badge-dot {
    position: relative;
    display: inline-flex;
}
.navbar .badge-dot::after {
    content: '';
    position: absolute;
    top: 2px; right: 2px;
    width: 8px; height: 8px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid var(--surface);
}

/* ── Cards ── */
.card {
    border: 1px solid var(--border) !important;
    border-radius: var(--radius-lg) !important;
    background: var(--surface);
    box-shadow: var(--shadow-sm);
}

.card-header {
    background: transparent !important;
    border-bottom: 1px solid var(--border) !important;
    font-weight: 600;
    padding: 16px 20px !important;
}

/* stat cards */
.stat-card {
    border-radius: var(--radius-lg) !important;
    border: none !important;
    position: relative;
    overflow: hidden;
}

.stat-card .stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.card-hover {
    transition: var(--transition);
}

.card-hover:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-hover) !important;
    border-color: rgba(26,86,219,0.15) !important;
}

/* ── Tables ── */
.table {
    border-radius: var(--radius-md);
    overflow: hidden;
    border-collapse: separate;
    border-spacing: 0;
}

.table thead tr th {
    background: #eef2ff !important;
    color: var(--text-muted);
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .8px;
    text-transform: uppercase;
    border-bottom: 2px solid #dde6ff !important;
    padding: 14px 16px !important;
}

.table tbody tr {
    transition: var(--transition);
}

.table tbody tr:hover {
    background: #f8faff !important;
}

.table tbody td {
    padding: 13px 16px !important;
    vertical-align: middle;
    border-bottom: 1px solid var(--border) !important;
}

/* ── Buttons ── */
.btn {
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    letter-spacing: .2px;
    transition: var(--transition);
}

.btn-primary {
    background: linear-gradient(135deg, var(--sidebar-from), var(--sidebar-to));
    border: none;
    box-shadow: 0 4px 14px rgba(26,86,219,0.30);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(26,86,219,0.38);
    background: linear-gradient(135deg, #0f2d6e, #1e56db);
}

.btn-warning {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
    box-shadow: 0 4px 14px rgba(245,158,11,0.28);
}

.btn-warning:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(245,158,11,0.36);
    color: #fff;
}

/* ── Badges ── */
.badge {
    border-radius: 6px;
    font-weight: 600;
    font-size: 11.5px;
    padding: 4px 9px;
}

/* ── Page header helper ── */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}

.page-header h2 {
    font-size: 1.35rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-main);
}

.page-header .breadcrumb {
    margin: 0;
    font-size: 13px;
}

/* ── Scrollbar ── */
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #c7d5f8; border-radius: 10px; }

/* ── Offcanvas (mobile sidebar) ── */
.offcanvas {
    background: linear-gradient(175deg, var(--sidebar-from) 0%, var(--sidebar-to) 100%) !important;
}

.offcanvas a {
    text-decoration: none !important;
    color: rgba(255,255,255,0.82);
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 11px 14px;
    border-radius: var(--radius-md);
    transition: var(--transition);
    font-weight: 500;
    font-size: 14.5px;
}

.offcanvas a:hover,
.offcanvas a:focus,
.offcanvas a:active {
    text-decoration: none !important;
    color: #fff;
    background: rgba(255,255,255,0.14);
    padding-left: 18px;
}

/* ── Mobile & Tablet ── */
@media (max-width: 991px) {
    .sidebar { display: none; }
    main { width: 100%; }
    .container-fluid.p-4 { padding: 1rem !important; }
    .navbar { padding: 0 15px; }
}

/* ── Small Mobile ── */
@media (max-width: 576px) {
    h1, h2, h3, h4 { font-size: 1.15rem; }

    .btn {
        padding: 8px 13px;
        font-size: 13.5px;
    }

    .table { font-size: 13.5px; }
}
</style>

{{-- Flash toast styles --}}
    <style>
    .flash-toast {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 14px;
        border: 1.5px solid transparent;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        background: #fff;
        position: relative;
        overflow: hidden;
        animation: toastIn .3s cubic-bezier(.34,1.56,.64,1);
    }
    @keyframes toastIn {
        from { opacity:0; transform: translateX(60px) scale(.95); }
        to   { opacity:1; transform: translateX(0) scale(1); }
    }
    .flash-toast.hiding {
        animation: toastOut .25s ease forwards;
    }
    @keyframes toastOut {
        to { opacity:0; transform: translateX(60px) scale(.95); height:0; padding:0; margin:0; }
    }
    .flash-success { border-color: #bbf7d0; background: #f0fdf4; }
    .flash-error   { border-color: #fecaca; background: #fef2f2; }
    .flash-warning { border-color: #fde68a; background: #fffbeb; }
    .flash-info    { border-color: #bfdbfe; background: #eff6ff; }
    .flash-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }
    .flash-success .flash-icon { background: #dcfce7; color: #15803d; }
    .flash-error   .flash-icon { background: #fee2e2; color: #b91c1c; }
    .flash-warning .flash-icon { background: #fef9c3; color: #b45309; }
    .flash-info    .flash-icon { background: #dbeafe; color: #1d4ed8; }
    .flash-body { flex: 1; min-width: 0; }
    .flash-title { font-size: 13px; font-weight: 800; margin-bottom: 2px; }
    .flash-success .flash-title { color: #15803d; }
    .flash-error   .flash-title { color: #b91c1c; }
    .flash-warning .flash-title { color: #b45309; }
    .flash-info    .flash-title { color: #1d4ed8; }
    .flash-msg { font-size: 13px; color: #374151; line-height: 1.4; }
    .flash-close {
        background: none; border: none; padding: 2px 4px;
        cursor: pointer; color: #9ca3af; font-size: 14px;
        flex-shrink: 0; transition: color .2s;
    }
    .flash-close:hover { color: #374151; }
    .flash-progress {
        position: absolute; bottom: 0; left: 0;
        height: 3px; border-radius: 0 0 14px 14px;
        animation: progressShrink 4s linear forwards;
    }
    .flash-progress-success { background: #16a34a; }
    .flash-progress-error   { background: #dc2626; }
    .flash-progress-warning { background: #d97706; }
    .flash-progress-info    { background: #2563eb; }
    @keyframes progressShrink {
        from { width: 100%; }
        to   { width: 0%; }
    }
    </style>



@stack('styles')
</head>

<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Main Content -->
        <main class="col-12 col-lg-10 px-0">
            @include('partials.navbar')

            @include('partials.flash')

            <div class="container-fluid p-4">
                @yield('content')
            </div>

            @include('partials.footer')
        </main>

    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stack('scripts')

    {{-- Flash toast JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.flash-toast').forEach(function (toast) {
            setTimeout(function () { dismissToast(toast); }, 4000);
        });
    });
    function closeToast(btn) { dismissToast(btn.closest('.flash-toast')); }
    function dismissToast(toast) {
        toast.classList.add('hiding');
        setTimeout(function () {
            toast.remove();
            var c = document.getElementById('flashContainer');
            if (c && c.children.length === 0) c.remove();
        }, 250);
    }
    </script>

    {{-- PWA Script --}}
    <script>
    if ('serviceWorker' in navigator) {

        navigator.serviceWorker
            .register('/service-worker.js')
            .then(function() {
                console.log('Service Worker Registered');
            });

    }
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const toggleBtn = document.getElementById("desktopSidebarToggle");

        if (toggleBtn) {

            toggleBtn.addEventListener("click", function () {

                // Toggle sidebar
                document.body.classList.toggle("sidebar-collapsed");

                // Save state
                if (document.body.classList.contains("sidebar-collapsed")) {
                    localStorage.setItem("sidebar", "collapsed");
                } else {
                    localStorage.setItem("sidebar", "expanded");
                }

            });

        }

    });
    </script>

    <script>
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {

    // Prevent automatic mini-infobar
    e.preventDefault();

    // Save event
    deferredPrompt = e;

    // Create install button
    const installBox = document.createElement('div');

    installBox.innerHTML = `
        <div id="pwaInstallBox" style="
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border-radius: 16px;
            padding: 18px;
            width: 320px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            z-index: 9999;
            border: 1px solid #e2e8f0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        ">

            <div style="display:flex; gap:12px; align-items:flex-start;">

                <div style="
                    width:48px;
                    height:48px;
                    border-radius:12px;
                    background:linear-gradient(135deg,#0f2d6e,#1a56db);
                    color:white;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:20px;
                    flex-shrink:0;
                ">
                    <i class="fa fa-download"></i>
                </div>

                <div style="flex:1;">
                    <div style="
                        font-weight:700;
                        font-size:15px;
                        color:#0f172a;
                        margin-bottom:4px;
                    ">
                        Install AmazingTrack
                    </div>

                    <div style="
                        font-size:13px;
                        color:#64748b;
                        line-height:1.5;
                        margin-bottom:14px;
                    ">
                        Install this app for faster access and a better experience.
                    </div>

                    <div style="display:flex; gap:8px;">

                        <button id="installPWAButton" style="
                            border:none;
                            background:linear-gradient(135deg,#0f2d6e,#1a56db);
                            color:white;
                            padding:9px 14px;
                            border-radius:10px;
                            font-size:13px;
                            font-weight:600;
                            cursor:pointer;
                        ">
                            Install
                        </button>

                        <button id="closePWAButton" style="
                            border:none;
                            background:#f1f5f9;
                            color:#475569;
                            padding:9px 14px;
                            border-radius:10px;
                            font-size:13px;
                            font-weight:600;
                            cursor:pointer;
                        ">
                            Later
                        </button>

                    </div>
                </div>

            </div>
        </div>
    `;

    document.body.appendChild(installBox);

    // Install button click
    document.getElementById('installPWAButton')
        .addEventListener('click', async () => {

            document.getElementById('pwaInstallBox').remove();

            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;

            console.log('PWA install outcome:', outcome);

            deferredPrompt = null;
        });

    // Close button
    document.getElementById('closePWAButton')
        .addEventListener('click', () => {
            document.getElementById('pwaInstallBox').remove();
        });

});
</script>

</body>
</html>