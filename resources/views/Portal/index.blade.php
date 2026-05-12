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

.btn-back-home{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#f8faff;
    color:#1a56db;
    border:1.5px solid #dbeafe;
    border-radius:12px;
    padding:11px 18px;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    transition:all .22s ease;
}
.btn-back-home:hover{
    background:#1a56db;
    color:white;
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(26,86,219,.18);
}

.alert-custom {
    background:#fef2f2;border:1.5px solid #fecaca;border-radius:12px;
    padding:13px 16px;color:#b91c1c;font-size:13.5px;font-weight:600;
    display:flex;align-items:center;gap:10px;margin-bottom:20px;
}

/* ════════════════════════════════════════
   VIP WELCOME MODAL
═══════════════════════════════════════ */
#vipOverlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(5, 15, 45, 0.82);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
#vipOverlay.active {
    display: flex;
}

#vipModal {
    background: #fff;
    border-radius: 28px;
    max-width: 480px;
    width: 100%;
    overflow: hidden;
    box-shadow: 0 40px 100px rgba(5,15,60,.5), 0 0 0 1px rgba(255,255,255,.08);
    animation: modalPop .55s cubic-bezier(.34,1.56,.64,1) both;
    position: relative;
}

@keyframes modalPop {
    from { opacity:0; transform: scale(.7) translateY(40px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}

/* Gold shimmer header */
.vip-header {
    background: linear-gradient(135deg, #0a1f52 0%, #162f6e 40%, #1e4dd8 100%);
    padding: 40px 36px 32px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.vip-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background: repeating-linear-gradient(
        45deg,
        transparent,
        transparent 12px,
        rgba(240,165,0,.04) 12px,
        rgba(240,165,0,.04) 24px
    );
}
.vip-header::after {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(240,165,0,.18) 0%, transparent 70%);
    top: -100px; left: 50%; transform: translateX(-50%);
    pointer-events: none;
}

/* VC photo ring */
.vip-photo-wrap {
    position: relative;
    display: inline-block;
    margin-bottom: 18px;
    z-index: 1;
}
.vip-photo-ring {
    width: 110px; height: 110px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, #f0a500, #ffd166, #f0a500, #e07b00);
    box-shadow: 0 0 0 4px rgba(240,165,0,.2), 0 8px 30px rgba(240,165,0,.35);
    animation: ringPulse 2.5s ease-in-out infinite;
}
@keyframes ringPulse {
    0%,100% { box-shadow: 0 0 0 4px rgba(240,165,0,.2), 0 8px 30px rgba(240,165,0,.35); }
    50%      { box-shadow: 0 0 0 8px rgba(240,165,0,.35), 0 8px 40px rgba(240,165,0,.5); }
}
.vip-photo-ring img {
    width: 100%; height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    display: block;
}
.vip-star-badge {
    position: absolute;
    bottom: 2px; right: 2px;
    width: 28px; height: 28px;
    background: linear-gradient(135deg, #f0a500, #ffd166);
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px;
    box-shadow: 0 2px 8px rgba(240,165,0,.5);
    animation: starSpin 4s linear infinite;
}
@keyframes starSpin {
    0%   { transform: rotate(0deg) scale(1);   }
    50%  { transform: rotate(180deg) scale(1.15); }
    100% { transform: rotate(360deg) scale(1);  }
}

.vip-launch-badge {
    display: inline-block;
    background: rgba(240,165,0,.18);
    border: 1px solid rgba(240,165,0,.4);
    border-radius: 99px;
    padding: 5px 14px;
    font-size: 10.5px;
    font-weight: 800;
    color: #ffd166;
    letter-spacing: .8px;
    text-transform: uppercase;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}

.vip-welcome-line {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255,255,255,.55);
    letter-spacing: .3px;
    margin-bottom: 4px;
    position: relative;
    z-index: 1;
}

.vip-name {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 1.9rem;
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 6px;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 20px rgba(240,165,0,.3);
}

/* Body */
.vip-body {
    padding: 28px 36px 32px;
    text-align: center;
    position: relative;
}

.vip-launch-title {
    font-size: 17px;
    font-weight: 900;
    color: #0a1f52;
    line-height: 1.35;
    margin-bottom: 10px;
    letter-spacing: -.3px;
}
.vip-launch-title span {
    background: linear-gradient(135deg, #0f2d6e, #1a56db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.vip-message {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 24px;
    font-weight: 500;
}

/* Gold divider */
.vip-divider {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
}
.vip-divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0);
}
.vip-divider-line.right {
    background: linear-gradient(90deg, #e2e8f0, transparent);
}
.vip-divider-star {
    font-size: 14px;
    color: #f0a500;
}

.btn-vip-enter {
    width: 100%;
    background: linear-gradient(135deg, #0a1f52, #1a56db);
    color: #fff;
    border: none;
    border-radius: 16px;
    padding: 16px 24px;
    font-size: 15px;
    font-weight: 800;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    box-shadow: 0 8px 28px rgba(26,86,219,.35);
    transition: all .22s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    letter-spacing: -.2px;
    position: relative;
    overflow: hidden;
}
.btn-vip-enter::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(240,165,0,.15), transparent);
    opacity: 0;
    transition: opacity .22s;
}
.btn-vip-enter:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 36px rgba(26,86,219,.45);
}
.btn-vip-enter:hover::before { opacity: 1; }

.vip-countdown {
    font-size: 11.5px;
    color: #94a3b8;
    font-weight: 600;
    margin-top: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.vip-countdown-num {
    font-weight: 900;
    color: #1a56db;
    font-size: 13px;
    min-width: 14px;
    display: inline-block;
    text-align: center;
}

/* ── Confetti canvas ── */
#confettiCanvas {
    position: fixed;
    inset: 0;
    pointer-events: none;
    z-index: 10000;
}


</style>
</head>

<body>

{{-- ══ VIP Welcome Modal (hidden until triggered) ══ --}}
<div id="vipOverlay">
    <canvas id="confettiCanvas"></canvas>

    <div id="vipModal">
        <div class="vip-header">
            <div class="vip-photo-wrap">
                <div class="vip-photo-ring">
                    <img src="{{ asset('logo/vc.jpg') }}" alt="VIP Staff Photo">
                </div>
                <div class="vip-star-badge">⭐</div>
            </div>

            <div class="vip-launch-badge">🎉 Special Launch Access</div>
            <div class="vip-welcome-line">Welcome,</div>
            <h2 class="vip-name" id="vipStaffName">Staff Member</h2>
        </div>

        <div class="vip-body">
            <div class="vip-launch-title">
                The Official Launch of <span>Be An Amazing You</span><br>
                Powered by <span>AmazingTrack System</span>
            </div>

            <div class="vip-divider">
                <div class="vip-divider-line"></div>
                <div class="vip-divider-star">★ ★ ★</div>
                <div class="vip-divider-line right"></div>
            </div>

            <p class="vip-message">
                You're stepping into a new era of growth and excellence.<br>
                <strong style="color:#0a1f52;">Track. Grow. Be Amazing.</strong><br>
                Every program, every role, every merit point — all in one place.
            </p>

            <button class="btn-vip-enter" id="vipEnterBtn">
                <i class="fa fa-rocket"></i>
                Enter My Dashboard
            </button>

            <div class="vip-countdown">
                <i class="fa fa-clock" style="font-size:11px;"></i>
                Auto-entering in <span class="vip-countdown-num" id="countNum">5</span> seconds
            </div>
        </div>
    </div>
</div>

{{-- ══ Hidden form to submit after modal ══ --}}
<form id="vipForm" method="POST" action="{{ route('portal.lookup') }}" style="display:none;">
    @csrf
    <input type="hidden" name="staff_id" id="vipFormStaffId">
</form>

<div class="portal-card fu">

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

            <div style="text-align:center; margin-top:14px;">
                <a href="{{ url('/') }}" class="btn-back-home">
                    <i class="fa fa-arrow-left"></i>
                    Back to Home
                </a>
            </div>

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

    </div>
</div>

<script>
/* ══════════════════════════════════════════
   VIP STAFF CONFIG
   Add any special staff IDs here
══════════════════════════════════════════ */
const VIP_STAFF = {
    'FP02961': {
        name: 'Prof. Dr. Sharifah Syahirah binti Sy Shiekh', // ← Replace with actual name
        title: 'Vice Chancellor'                  // ← Replace with actual title
    }
};

/* ══════════════════════════════════════════
   CONFETTI ENGINE
══════════════════════════════════════════ */
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
        x:     Math.random() * canvas.width,
        y:     -20,
        w:     size,
        h:     size * (Math.random() > .5 ? 1 : 0.4),
        color: COLORS[Math.floor(Math.random() * COLORS.length)],
        vx:    (Math.random() - .5) * 5,
        vy:    Math.random() * 4 + 2,
        angle: Math.random() * Math.PI * 2,
        spin:  (Math.random() - .5) * .15,
        life:  1,
        decay: Math.random() * .008 + .004,
        shape: Math.random() > .6 ? 'circle' : 'rect'
    };
}

function launchConfetti() {
    particles = [];
    for (let i = 0; i < 180; i++) {
        const p = createParticle();
        p.y = Math.random() * canvas.height * .4 - 20;
        particles.push(p);
    }
    if (rafId) cancelAnimationFrame(rafId);
    animateConfetti();

    // Continuous burst for 3s
    let elapsed = 0;
    const burst = setInterval(() => {
        for (let i = 0; i < 12; i++) particles.push(createParticle());
        elapsed += 100;
        if (elapsed >= 3000) clearInterval(burst);
    }, 100);
}

function animateConfetti() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles = particles.filter(p => p.life > 0 && p.y < canvas.height + 30);

    particles.forEach(p => {
        p.x     += p.vx;
        p.y     += p.vy;
        p.angle += p.spin;
        p.vy    += .07; // gravity
        p.vx    *= .99;
        p.life  -= p.decay;

        ctx.save();
        ctx.translate(p.x, p.y);
        ctx.rotate(p.angle);
        ctx.globalAlpha = Math.max(0, p.life);
        ctx.fillStyle   = p.color;

        if (p.shape === 'circle') {
            ctx.beginPath();
            ctx.arc(0, 0, p.w / 2, 0, Math.PI * 2);
            ctx.fill();
        } else {
            ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
        }
        ctx.restore();
    });

    if (particles.length > 0) {
        rafId = requestAnimationFrame(animateConfetti);
    } else {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
}

/* ══════════════════════════════════════════
   MODAL LOGIC
══════════════════════════════════════════ */
let countdownInterval = null;

function showVIPModal(staffId, staffData) {
    document.getElementById('vipStaffName').textContent = staffData.name;
    document.getElementById('vipFormStaffId').value = staffId;

    const overlay = document.getElementById('vipOverlay');
    overlay.classList.add('active');

    launchConfetti();
    startCountdown();
}

function startCountdown() {
    let count = 10;
    const numEl = document.getElementById('countNum');
    numEl.textContent = count;

    if (countdownInterval) clearInterval(countdownInterval);

    countdownInterval = setInterval(() => {
        count--;
        numEl.textContent = count;
        if (count <= 0) {
            clearInterval(countdownInterval);
            submitVIPForm();
        }
    }, 1000);
}

function submitVIPForm() {
    if (countdownInterval) clearInterval(countdownInterval);
    if (rafId) cancelAnimationFrame(rafId);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    document.getElementById('vipForm').submit();
}

// Enter button
document.getElementById('vipEnterBtn').addEventListener('click', submitVIPForm);

// Intercept main form submit
document.getElementById('mainLookupForm').addEventListener('submit', function(e) {
    const inputVal = document.getElementById('staffIdInput').value.trim().toUpperCase();

    if (VIP_STAFF[inputVal]) {
        e.preventDefault();
        showVIPModal(inputVal, VIP_STAFF[inputVal]);
    }
    // else: normal form submission proceeds
});

// Auto-uppercase input
document.getElementById('staffIdInput').addEventListener('input', function() {
    const pos = this.selectionStart;
    this.value = this.value.toUpperCase();
    this.setSelectionRange(pos, pos);
});
</script>

</body>
</html>
