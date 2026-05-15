<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>AmazingTrack — Be An Amazing You Portal</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">

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

/* ── Login Card ── */
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
    width:100px;height:auto;object-fit:contain;
    filter:drop-shadow(0 2px 4px rgba(0,0,0,.3));
}
.portal-header h1 {
    font-size:1.45rem;font-weight:900;color:#fff;
    margin:0 0 6px;position:relative;z-index:1;
}
.portal-header p {
    font-size:13.5px;color:rgba(255,255,255,.62);
    margin:0;position:relative;z-index:1;
}
.portal-tagline {
    font-size:12px;color:rgba(255,255,255,.75);
    margin-top:4px;font-style:italic;letter-spacing:.3px;
}

/* ── Body ── */
.portal-body { padding:32px 36px 36px; }

.form-label-custom {
    font-size:12px;font-weight:700;color:#475569;
    text-transform:uppercase;letter-spacing:.5px;
    display:block;margin-bottom:8px;
}
.id-input {
    border:2px solid #e2e8f0;border-radius:14px;
    padding:14px 18px;font-size:1.1rem;font-family:inherit;
    font-weight:700;letter-spacing:2px;color:#0f172a;
    background:#f8faff;width:100%;outline:none;
    text-transform:uppercase;transition:border-color .2s,box-shadow .2s;
    text-align:center;
}
.id-input:focus {
    border-color:#1a56db;box-shadow:0 0 0 4px rgba(26,86,219,.12);background:#fff;
}
.id-input.is-invalid {
    border-color:#ef4444;box-shadow:0 0 0 4px rgba(239,68,68,.10);
}
.btn-lookup {
    width:100%;background:linear-gradient(135deg,#0f2d6e,#1a56db);
    color:#fff;border:none;border-radius:14px;padding:15px;
    font-size:15px;font-weight:800;font-family:inherit;cursor:pointer;
    box-shadow:0 6px 20px rgba(26,86,219,.30);transition:all .22s;
    display:flex;align-items:center;justify-content:center;gap:10px;margin-top:20px;
}
.btn-lookup:hover { transform:translateY(-2px);box-shadow:0 10px 28px rgba(26,86,219,.38); }
.btn-lookup:active { transform:translateY(0); }

.merit-legend {
    background:#f8faff;border:1.5px solid #e8effe;
    border-radius:14px;padding:16px 18px;margin-top:20px;
}
.merit-legend-title {
    font-size:11px;font-weight:700;color:#94a3b8;
    text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;
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
.btn-back-home {
    display:inline-flex;align-items:center;gap:8px;
    background:#f8faff;color:#1a56db;border:1.5px solid #dbeafe;
    border-radius:12px;padding:11px 18px;text-decoration:none;
    font-size:13px;font-weight:700;transition:all .22s ease;
}
.btn-back-home:hover {
    background:#1a56db;color:white;transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(26,86,219,.18);
}
.alert-custom {
    background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;
    padding:13px 16px;color:#b91c1c;font-size:13.5px;font-weight:600;
    display:flex;align-items:center;gap:10px;margin-bottom:20px;
}

.login-footer {
    text-align: center;
    margin-top: 22px;
    font-size: 12.5px;
    color: rgba(0, 0, 0, 0.55);
}

/* ════════════════════════════════════════
   VIP WELCOME MODAL — TWO-COLUMN LAYOUT
   Left: full-bleed photo | Right: welcome
═══════════════════════════════════════ */
#vipOverlay {
    display:none;
    position:fixed;inset:0;
    background:rgba(5,15,45,0.82);
    backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);
    z-index:9999;
    align-items:center;justify-content:center;
    padding:20px;
}
#vipOverlay.active { display:flex; }

#vipModal {
    background:#fff;
    border-radius:28px;
    max-width:780px;width:100%;
    overflow:hidden;
    box-shadow:0 40px 100px rgba(5,15,60,.5), 0 0 0 1px rgba(255,255,255,.08);
    animation:modalPop .55s cubic-bezier(.34,1.56,.64,1) both;
    display:flex;flex-direction:row;
    /* fixed height so photo fills the panel */
    min-height:480px;
}
@keyframes modalPop {
    from { opacity:0; transform:scale(.75) translateY(40px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}

/* ── LEFT: Full-bleed photo ── */
.vip-left {
    width:300px;
    flex-shrink:0;
    position:relative;
    overflow:hidden;
    border-radius:28px 0 0 28px;
    /* deep navy base so padding around image looks intentional */
    background:#070f2b;
    padding:18px 18px 18px 18px;
    display:flex;
    align-items:stretch;
}

/* rotating gold conic-gradient ring behind the image frame */
.vip-left::before {
    content:'';
    position:absolute;
    inset:-3px;
    border-radius:30px 0 0 30px;
    background:conic-gradient(
        from var(--ring-angle, 0deg),
        #f0a500 0%,
        #ffd166 15%,
        #fff8e7 25%,
        transparent 35%,
        transparent 65%,
        #fff8e7 75%,
        #ffd166 85%,
        #f0a500 100%
    );
    z-index:0;
    animation:ringRotate 3s linear infinite;
}
/* static gold inner glow layer */
.vip-left::after {
    content:'';
    position:absolute;
    inset:3px;
    border-radius:26px 0 0 26px;
    background:transparent;
    box-shadow:
        inset 0 0 40px rgba(240,165,0,.25),
        inset 0 0 80px rgba(240,165,0,.10),
        0 0 60px rgba(240,165,0,.18);
    z-index:2;
    pointer-events:none;
}
@property --ring-angle {
    syntax: '<angle>';
    inherits: false;
    initial-value: 0deg;
}
@keyframes ringRotate {
    to { --ring-angle: 360deg; }
}

/* image wrapper — sits above the rotating ring */
.vip-img-frame {
    position:relative;
    z-index:1;
    flex:1;
    border-radius:16px;
    overflow:hidden;
    /* inner gold border on the frame itself */
    outline:2px solid rgba(240,165,0,.55);
    outline-offset:-1px;
    box-shadow:
        0 0 0 1px rgba(255,215,0,.3),
        0 0 30px rgba(240,165,0,.35),
        inset 0 0 20px rgba(240,165,0,.08);
}

/* the image stretches to fill the frame */
.vip-left-img {
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    object-position:center top;
    display:block;
}
/* subtle dark vignette overlay so star badge is readable */
.vip-left-vignette {
    position:absolute;inset:0;pointer-events:none;
    background:linear-gradient(to bottom,
        rgba(5,15,45,.25) 0%,
        transparent 28%,
        transparent 62%,
        rgba(5,15,45,.50) 100%);
    z-index:1;
}
/* spinning star badge top-right */
.vip-star-badge {
    position:absolute;
    top:26px;right:26px;
    width:38px;height:38px;
    background:linear-gradient(135deg,#f0a500,#ffd166);
    border-radius:50%;border:3px solid #fff;
    display:flex;align-items:center;justify-content:center;
    font-size:17px;
    box-shadow:0 3px 16px rgba(240,165,0,.75), 0 0 0 2px rgba(240,165,0,.3);
    animation:starSpin 4s linear infinite;
    z-index:5;
}
@keyframes starSpin {
    0%   { transform:rotate(0deg) scale(1); }
    50%  { transform:rotate(180deg) scale(1.15); }
    100% { transform:rotate(360deg) scale(1); }
}

/* ── RIGHT: Welcome content ── */
.vip-right {
    flex:1;
    display:flex;flex-direction:column;justify-content:center;
    padding:40px 38px 36px;
    background:#fff;
}

.vip-launch-badge {
    display:inline-flex;align-items:center;gap:6px;
    background:rgba(26,86,219,.08);border:1px solid rgba(26,86,219,.2);
    border-radius:99px;padding:5px 14px;
    font-size:10.5px;font-weight:800;color:#1a56db;
    letter-spacing:.6px;text-transform:uppercase;
    margin-bottom:16px;width:fit-content;
}

.vip-welcome-label {
    font-size:11.5px;font-weight:700;color:#94a3b8;
    letter-spacing:.5px;text-transform:uppercase;margin-bottom:4px;
}

/* Name + title block on right panel */
.vip-name-block {
    margin-bottom:18px;
}
.vip-name {
    font-family:'Playfair Display',Georgia,serif;
    font-size:1.55rem;font-weight:900;
    color:#0a1f52;line-height:1.2;
    margin:0 0 6px;
    text-shadow:none;
}
.vip-title-tag {
    display:inline-flex;align-items:center;gap:6px;
    background:linear-gradient(135deg,#0a1f52,#1a56db);
    color:#fff;border-radius:8px;padding:4px 12px;
    font-size:11px;font-weight:800;letter-spacing:.6px;text-transform:uppercase;
}

.vip-launch-title {
    font-size:14px;font-weight:700;color:#334155;
    line-height:1.5;margin-bottom:14px;
}
.vip-launch-title span {
    background:linear-gradient(135deg,#0f2d6e,#1a56db);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    font-weight:900;
}

.vip-divider {
    display:flex;align-items:center;gap:10px;margin-bottom:16px;
}
.vip-divider-line { flex:1;height:1px;background:linear-gradient(90deg,transparent,#e2e8f0); }
.vip-divider-line.right { background:linear-gradient(90deg,#e2e8f0,transparent); }
.vip-divider-star { font-size:12px;color:#f0a500; }

.vip-message {
    font-size:13px;color:#64748b;line-height:1.65;
    margin-bottom:22px;font-weight:500;
}
.vip-message strong { color:#0a1f52; }

/* Stat chips */
.vip-stats { display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap; }
.vip-stat-chip {
    background:#f0f6ff;border:1.5px solid #dbeafe;border-radius:12px;
    padding:9px 14px;display:flex;align-items:center;gap:8px;
    flex:1;min-width:90px;
}
.vip-stat-chip i { color:#1a56db;font-size:14px; }
.vip-stat-chip-label { font-size:9.5px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px;display:block;line-height:1; }
.vip-stat-chip-val   { font-size:12.5px;font-weight:800;color:#0a1f52;display:block;line-height:1.35; }

/* CTA */
.btn-vip-enter {
    width:100%;background:linear-gradient(135deg,#0a1f52,#1a56db);
    color:#fff;border:none;border-radius:16px;
    padding:15px 24px;font-size:14.5px;font-weight:800;
    font-family:'Plus Jakarta Sans',sans-serif;cursor:pointer;
    box-shadow:0 8px 28px rgba(26,86,219,.35);transition:all .22s;
    display:flex;align-items:center;justify-content:center;gap:10px;
    letter-spacing:-.2px;position:relative;overflow:hidden;
}
.btn-vip-enter::before {
    content:'';position:absolute;inset:0;
    background:linear-gradient(135deg,rgba(240,165,0,.15),transparent);
    opacity:0;transition:opacity .22s;
}
.btn-vip-enter:hover { transform:translateY(-2px);box-shadow:0 12px 36px rgba(26,86,219,.45); }
.btn-vip-enter:hover::before { opacity:1; }

.vip-countdown {
    font-size:11.5px;color:#94a3b8;font-weight:600;margin-top:11px;
    display:flex;align-items:center;justify-content:center;gap:6px;
}
.vip-countdown-num {
    font-weight:900;color:#1a56db;font-size:13px;
    min-width:14px;display:inline-block;text-align:center;
}

/* ── Confetti ── */
#confettiCanvas { position:fixed;inset:0;pointer-events:none;z-index:10000; }

/* ── Responsive ── */
@media (max-width:620px) {
    #vipModal { flex-direction:column; min-height:unset; }
    .vip-left {
        width:100%; height:260px;
        border-radius:28px 28px 0 0;
        padding:14px;
    }
    .vip-left::before { border-radius:30px 30px 0 0; }
    .vip-left::after  { border-radius:26px 26px 0 0; }
    .vip-img-frame    { border-radius:14px; }
    .vip-right { padding:28px 24px 28px; }
    .vip-stats { flex-direction:column; }
    .vip-name { font-size:1.3rem; }
}
</style>
</head>

<body>

{{-- VIP Welcome Modal --}}
<div id="vipOverlay">
    <canvas id="confettiCanvas"></canvas>

    <div id="vipModal">

        {{-- LEFT: Full-bleed photo with luxury gold ring border --}}
        <div class="vip-left">
            <div class="vip-img-frame">
                <img class="vip-left-img" src="{{ asset('logo/vc1.jpeg') }}" alt="Vice Chancellor Photo">
                <div class="vip-left-vignette"></div>
            </div>
            <div class="vip-star-badge">⭐</div>
        </div>

        {{-- RIGHT: Welcome content --}}
        <div class="vip-right">

            <div class="vip-launch-badge">🎉 Special Launch Access</div>

            <div class="vip-welcome-label">Welcome,</div>

            <div class="vip-name-block">
                <h2 class="vip-name" id="vipStaffName">Staff Member</h2>
                <span class="vip-title-tag" id="vipStaffTitle">Vice Chancellor</span>
            </div>

            <div class="vip-launch-title">
                The Official Launch of
                <span>Be An Amazing You</span> —
                Powered by <span>AmazingTrack System</span>
            </div>

            <div class="vip-divider">
                <div class="vip-divider-line"></div>
                <div class="vip-divider-star">★ ★ ★</div>
                <div class="vip-divider-line right"></div>
            </div>

            <p class="vip-message">
                You're stepping into a new era of growth and excellence.
                <strong>Track. Grow. Be Amazing.</strong><br>
                Every program, every role, every merit point — all in one place.
            </p>

           

            <button class="btn-vip-enter" id="vipEnterBtn">
                <i class="fa fa-rocket"></i>
                Enter My Dashboard
            </button>

            <div class="vip-countdown">
                <i class="fa fa-clock" style="font-size:11px;"></i>
                Auto-entering in <span class="vip-countdown-num" id="countNum">20</span> seconds
            </div>

        </div>
    </div>
</div>

{{-- Hidden form to submit after modal --}}
<form id="vipForm" method="POST" action="{{ route('portal.lookup') }}" style="display:none;">
    @csrf
    <input type="hidden" name="staff_id" id="vipFormStaffId">
</form>


{{-- Login Card --}}
<div class="portal-card fu">

    <div class="portal-header">
        <div class="portal-logo">
            <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="logo-img">
        </div>
        <h1>Be An Amazing You Portal</h1>
        <p>Check in to programs &amp; claim your Amazing merit points</p>
        <p class="portal-tagline">"Empowering Amazing Performance"</p>
    </div>

    <div class="portal-body">

        @if($errors->has('staff_id'))
        <div class="alert-custom fu d1">
            <i class="fa fa-circle-xmark" style="font-size:18px;flex-shrink:0;"></i>
            {{ $errors->first('staff_id') }}
        </div>
        @endif

        <form method="POST" action="{{ route('portal.lookup') }}" id="mainLookupForm">
            @csrf

            <label class="form-label-custom">Enter Your Staff ID</label>

            <input type="text"
                name="staff_id"
                id="staffIdInput"
                class="id-input {{ $errors->has('staff_id') ? 'is-invalid' : '' }}"
                placeholder="e.g. FP04428"
                value="{{ old('staff_id') }}"
                autocomplete="off"
                spellcheck="false"
                autofocus>

            <button type="submit" class="btn-lookup" id="mainSubmitBtn">
                <i class="fa fa-arrow-right-to-bracket"></i>
                Access My Dashboard
            </button>

            

        </form>

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

        <div style="text-align:center; margin-top:14px;">
            <a href="{{ url('/') }}" class="btn-back-home">
                <i class="fa fa-arrow-left"></i>
                Back to Home
            </a>
        </div>
        
        <div class="login-footer">
            © {{ date('Y') }} AmazingTrack System. All Rights Reserved.
            <br>
            Developed by Information & Communication Technology Division 
            <br>
            UPTM
        </div>

    </div>
</div>


<script>
const VIP_STAFF = {
    'FP02961': {
        name:  'Prof. Dr. Sharifah Syahirah binti Sy Shiekh',
        title: 'Vice Chancellor'
    }
};

/* ── Confetti ── */
const canvas  = document.getElementById('confettiCanvas');
const ctx     = canvas.getContext('2d');
let particles = [];
let rafId     = null;

function resizeCanvas() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
}
window.addEventListener('resize', resizeCanvas);
resizeCanvas();

const COLORS = [
    '#f0a500','#ffd166','#1a56db','#0f2d6e',
    '#ff6b6b','#4ecdc4','#45b7d1','#96ceb4',
    '#ffffff','#ffeaa7','#fd79a8','#6c5ce7'
];

function createParticle() {
    const size = Math.random() * 10 + 5;
    return {
        x: Math.random() * canvas.width, y: -20,
        w: size, h: size * (Math.random() > .5 ? 1 : 0.4),
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        vx: (Math.random() - .5) * 5, vy: Math.random() * 4 + 2,
        angle: Math.random() * Math.PI * 2, spin: (Math.random() - .5) * .15,
        life: 1, decay: Math.random() * .008 + .004,
        shape: Math.random() > .6 ? 'circle' : 'rect'
    };
}

function launchConfetti() {
    particles = [];
    for (let i = 0; i < 200; i++) {
        const p = createParticle();
        p.y = Math.random() * canvas.height * .4 - 20;
        particles.push(p);
    }
    if (rafId) cancelAnimationFrame(rafId);
    animateConfetti();
    let elapsed = 0;
    const burst = setInterval(() => {
        for (let i = 0; i < 14; i++) particles.push(createParticle());
        elapsed += 100;
        if (elapsed >= 15000) clearInterval(burst);
    }, 100);
}

function animateConfetti() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles = particles.filter(p => p.life > 0 && p.y < canvas.height + 30);
    particles.forEach(p => {
        p.x += p.vx; p.y += p.vy; p.angle += p.spin;
        p.vy += .07; p.vx *= .99; p.life -= p.decay;
        ctx.save();
        ctx.translate(p.x, p.y); ctx.rotate(p.angle);
        ctx.globalAlpha = Math.max(0, p.life);
        ctx.fillStyle = p.color;
        if (p.shape === 'circle') {
            ctx.beginPath(); ctx.arc(0,0,p.w/2,0,Math.PI*2); ctx.fill();
        } else {
            ctx.fillRect(-p.w/2,-p.h/2,p.w,p.h);
        }
        ctx.restore();
    });
    if (particles.length > 0) { rafId = requestAnimationFrame(animateConfetti); }
    else { ctx.clearRect(0,0,canvas.width,canvas.height); }
}

/* ── Modal ── */
let countdownInterval = null;

function showVIPModal(staffId, staffData) {
    document.getElementById('vipStaffName').textContent  = staffData.name;
    document.getElementById('vipStaffTitle').textContent = staffData.title || 'Vice Chancellor';
    document.getElementById('vipFormStaffId').value      = staffId;
    document.getElementById('vipOverlay').classList.add('active');
    launchConfetti();
    startCountdown();
}

function startCountdown() {
    let count = 20;
    const numEl = document.getElementById('countNum');
    numEl.textContent = count;
    if (countdownInterval) clearInterval(countdownInterval);
    countdownInterval = setInterval(() => {
        count--;
        numEl.textContent = count;
        if (count <= 0) { clearInterval(countdownInterval); submitVIPForm(); }
    }, 1000);
}

function submitVIPForm() {
    if (countdownInterval) clearInterval(countdownInterval);
    if (rafId) cancelAnimationFrame(rafId);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('vipForm').submit();
}

document.getElementById('vipEnterBtn').addEventListener('click', submitVIPForm);

document.getElementById('mainLookupForm').addEventListener('submit', function(e) {
    const inputVal = document.getElementById('staffIdInput').value.trim().toUpperCase();
    if (VIP_STAFF[inputVal]) {
        e.preventDefault();
        showVIPModal(inputVal, VIP_STAFF[inputVal]);
    }
});

document.getElementById('staffIdInput').addEventListener('input', function() {
    const pos = this.selectionStart;
    this.value = this.value.toUpperCase();
    this.setSelectionRange(pos, pos);
});
</script>

</body>
</html>
