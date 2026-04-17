<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Change Password | UniManage</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root { --blue-dark:#0f2d6e; --blue-mid:#1a56db; --accent:#f59e0b; --radius:16px; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Plus Jakarta Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; background:linear-gradient(145deg,var(--blue-dark) 0%,var(--blue-mid) 60%,#2563eb 100%); overflow:hidden; }
    body::before,body::after { content:''; position:absolute; border-radius:50%; pointer-events:none; }
    body::before { width:420px; height:420px; background:rgba(245,158,11,0.10); top:-120px; right:-100px; }
    body::after { width:320px; height:320px; background:rgba(96,165,250,0.10); bottom:-80px; left:-80px; }
    .wrap { width:100%; max-width:480px; padding:16px; z-index:1; }
    .card { border:none!important; border-radius:var(--radius)!important; box-shadow:0 24px 64px rgba(10,20,60,0.35)!important; overflow:hidden; }
    .card-accent { height:5px; background:linear-gradient(90deg,var(--accent),#fbbf24,#f97316); }
    .card-body { padding:40px 36px 36px!important; }
    .brand-icon { width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid)); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; box-shadow:0 8px 24px rgba(26,86,219,0.30); }
    .brand-icon i { font-size:24px; color:#fff; }
    .logo { font-size:1.5rem; font-weight:700; color:#0f172a; }
    .subtitle { font-size:13.5px; color:#64748b; margin-top:4px; }
    .form-label { font-size:13.5px; font-weight:600; color:#374151; margin-bottom:6px; display:block; }
    .form-control { width:100%; border-radius:10px!important; border:1.5px solid #e2e8f0!important; padding:11px 14px!important; font-size:14.5px!important; font-family:inherit; color:#1e293b; transition:border-color .2s,box-shadow .2s; background:#f8faff!important; }
    .form-control:focus { border-color:var(--blue-mid)!important; box-shadow:0 0 0 3px rgba(26,86,219,0.12)!important; background:#fff!important; outline:none; }
    .pw-wrap { position:relative; }
    .pw-wrap .form-control { padding-right:46px!important; }
    .pw-toggle { position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:#94a3b8; cursor:pointer; padding:0; transition:color .2s; }
    .pw-toggle:hover { color:var(--blue-mid); }
    .btn-submit { background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid)); color:#fff; border:none; border-radius:10px; padding:12px; font-size:15px; font-weight:600; font-family:inherit; width:100%; cursor:pointer; box-shadow:0 6px 20px rgba(26,86,219,0.32); transition:transform .2s,box-shadow .2s; display:flex; align-items:center; justify-content:center; gap:8px; }
    .btn-submit:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(26,86,219,0.38); }
    .alert-danger { border-radius:10px!important; font-size:13.5px; border:none!important; background:#fef2f2!important; color:#b91c1c!important; padding:10px 14px!important; display:flex; align-items:center; gap:8px; margin-bottom:16px; }
    .alert-success { border-radius:10px!important; font-size:13.5px; border:none!important; background:#f0fdf4!important; color:#15803d!important; padding:10px 14px!important; display:flex; align-items:center; gap:8px; margin-bottom:16px; }
    .hint { font-size:12px; color:#94a3b8; margin-top:5px; }
    .match-msg { font-size:12px; margin-top:5px; }
    .back-link { font-size:13.5px; color:#1a56db; text-decoration:none; font-weight:500; display:inline-flex; align-items:center; gap:6px; }
    .back-link:hover { text-decoration:underline; }
    .footer { text-align:center; margin-top:22px; font-size:12.5px; color:rgba(255,255,255,0.55); }

    /* password strength bar */
    .strength-bar { height:4px; border-radius:4px; margin-top:8px; transition:all .3s; background:#e2e8f0; }
    .strength-bar .fill { height:100%; border-radius:4px; transition:all .3s; width:0%; }
    .strength-label { font-size:11px; margin-top:4px; }
</style>
</head>
<body>

<div class="wrap">
    <div class="card">
        <div class="card-accent"></div>
        <div class="card-body">

            {{-- Header --}}
            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fa fa-shield-halved"></i>
                </div>
                <h4 class="logo">Change Password</h4>
                <p class="subtitle">Update your UniManage account password</p>
            </div>

            {{-- Alerts --}}
            @if(session('error'))
            <div class="alert-danger">
                <i class="fa fa-circle-exclamation"></i> {{ session('error') }}
            </div>
            @endif

            @if(session('success'))
            <div class="alert-success">
                <i class="fa fa-circle-check"></i> {{ session('success') }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('change.password.process') }}">
                @csrf

                {{-- Current Password --}}
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="currentPassword" name="current_password"
                               class="form-control" placeholder="Enter current password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('currentPassword','icon1')">
                            <i class="fa fa-eye" id="icon1"></i>
                        </button>
                    </div>
                </div>

                {{-- New Password --}}
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="newPassword" name="password"
                               class="form-control" placeholder="Min. 8 characters" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('newPassword','icon2')">
                            <i class="fa fa-eye" id="icon2"></i>
                        </button>
                    </div>
                    {{-- Strength Bar --}}
                    <div class="strength-bar"><div class="fill" id="strengthFill"></div></div>
                    <div class="strength-label" id="strengthLabel"></div>
                </div>

                {{-- Confirm Password --}}
                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="confirmPassword" name="password_confirmation"
                               class="form-control" placeholder="Re-enter new password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('confirmPassword','icon3')">
                            <i class="fa fa-eye" id="icon3"></i>
                        </button>
                    </div>
                    <div class="match-msg" id="matchMsg"></div>
                </div>

                <button type="submit" class="btn-submit mb-3">
                    <i class="fa fa-lock"></i> Change Password
                </button>

                {{-- <div class="text-center">
                    <a href="{{ url()->previous() }}" class="back-link">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div> --}}

                <div class="text-center">
                    <a href="
                        @if(Auth::user()->role === 'admin')
                            {{ route('admin.dashboard') }}
                        @elseif(Auth::user()->role === 'hd')
                            {{ route('head.dashboard') }}
                        @elseif(Auth::user()->role === 'vc')
                            {{ route('vc.dashboard') }}
                        @endif
                    " class="back-link">
                        <i class="fa fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

            </form>
        </div>
    </div>

    <p class="footer">&copy; {{ date('Y') }} UniManage — All rights reserved</p>
</div>

<script>
    // Toggle password visibility
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
    }

    // Password strength checker
    const newPw       = document.getElementById('newPassword');
    const confPw      = document.getElementById('confirmPassword');
    const fill        = document.getElementById('strengthFill');
    const label       = document.getElementById('strengthLabel');
    const matchMsg    = document.getElementById('matchMsg');

    newPw.addEventListener('input', function () {
        const val = this.value;
        let strength = 0;

        if (val.length >= 8)              strength++;
        if (/[A-Z]/.test(val))            strength++;
        if (/[0-9]/.test(val))            strength++;
        if (/[^A-Za-z0-9]/.test(val))    strength++;

        const levels = [
            { width: '0%',   color: '',          text: '' },
            { width: '25%',  color: '#ef4444',   text: '🔴 Weak' },
            { width: '50%',  color: '#f59e0b',   text: '🟡 Fair' },
            { width: '75%',  color: '#3b82f6',   text: '🔵 Good' },
            { width: '100%', color: '#22c55e',   text: '🟢 Strong' },
        ];

        fill.style.width           = levels[strength].width;
        fill.style.backgroundColor = levels[strength].color;
        label.textContent          = levels[strength].text;
        label.style.color          = levels[strength].color;

        checkMatch();
    });

    // Password match checker
    confPw.addEventListener('input', checkMatch);

    function checkMatch() {
        if (confPw.value === '') {
            matchMsg.textContent = '';
            return;
        }
        if (newPw.value === confPw.value) {
            matchMsg.textContent = '✓ Passwords match';
            matchMsg.style.color = '#15803d';
        } else {
            matchMsg.textContent = '✗ Passwords do not match';
            matchMsg.style.color = '#b91c1c';
        }
    }
</script>

</body>
</html>