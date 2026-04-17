<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Reset Password | UniManage</title>
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
    .login-wrap { width:100%; max-width:440px; padding:16px; z-index:1; }
    .login-card { border:none!important; border-radius:var(--radius)!important; box-shadow:0 24px 64px rgba(10,20,60,0.35)!important; overflow:hidden; }
    .card-accent { height:5px; background:linear-gradient(90deg,var(--accent),#fbbf24,#f97316); }
    .card-body { padding:40px 36px 36px!important; }
    .brand-icon { width:56px; height:56px; border-radius:16px; background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid)); display:flex; align-items:center; justify-content:center; margin:0 auto 14px; box-shadow:0 8px 24px rgba(26,86,219,0.30); }
    .brand-icon i { font-size:24px; color:#fff; }
    .logo { font-size:1.5rem; font-weight:700; color:#0f172a; }
    .subtitle { font-size:13.5px; color:#64748b; margin-top:4px; }
    .form-label { font-size:13.5px; font-weight:600; color:#374151; margin-bottom:6px; }
    .form-control { border-radius:10px!important; border:1.5px solid #e2e8f0!important; padding:11px 14px!important; font-size:14.5px!important; font-family:inherit; color:#1e293b; transition:border-color .2s,box-shadow .2s; background:#f8faff!important; }
    .form-control:focus { border-color:var(--blue-mid)!important; box-shadow:0 0 0 3px rgba(26,86,219,0.12)!important; background:#fff!important; outline:none; }
    .pw-wrap { position:relative; }
    .pw-wrap .form-control { padding-right:46px!important; }
    .pw-toggle { position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; color:#94a3b8; cursor:pointer; padding:0; transition:color .2s; }
    .pw-toggle:hover { color:var(--blue-mid); }
    .btn-login { background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid)); color:#fff; border:none; border-radius:10px; padding:12px; font-size:15px; font-weight:600; font-family:inherit; width:100%; cursor:pointer; box-shadow:0 6px 20px rgba(26,86,219,0.32); transition:transform .2s,box-shadow .2s; display:flex; align-items:center; justify-content:center; gap:8px; }
    .btn-login:hover { transform:translateY(-2px); }
    .alert-danger { border-radius:10px!important; font-size:13.5px; border:none!important; background:#fef2f2!important; color:#b91c1c!important; padding:10px 14px!important; display:flex; align-items:center; gap:8px; }
    .login-footer { text-align:center; margin-top:22px; font-size:12.5px; color:rgba(255,255,255,0.55); }
    .password-hint { font-size:12px; color:#94a3b8; margin-top:5px; }
</style>
</head>
<body>
<div class="login-wrap">
    <div class="card login-card">
        <div class="card-accent"></div>
        <div class="card-body">

            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fa fa-lock-open"></i>
                </div>
                <h4 class="logo">Reset Password</h4>
                <p class="subtitle">Enter your new password below</p>
            </div>

            @if(session('error'))
            <div class="alert alert-danger mb-3">
                <i class="fa fa-circle-exclamation"></i> {{ session('error') }}
            </div>
            @endif

            @error('password')
            <div class="alert alert-danger mb-3">
                <i class="fa fa-circle-exclamation"></i> {{ $message }}
            </div>
            @enderror

            <form method="POST" action="{{ route('reset.password.process') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="newPassword" name="password"
                               class="form-control" placeholder="Min. 8 characters" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('newPassword', 'icon1')">
                            <i class="fa fa-eye" id="icon1"></i>
                        </button>
                    </div>
                    <p class="password-hint">Minimum 8 characters</p>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm New Password</label>
                    <div class="pw-wrap">
                        <input type="password" id="confirmPassword" name="password_confirmation"
                               class="form-control" placeholder="Re-enter new password" required>
                        <button type="button" class="pw-toggle" onclick="togglePw('confirmPassword', 'icon2')">
                            <i class="fa fa-eye" id="icon2"></i>
                        </button>
                    </div>
                    <div id="matchMsg" style="font-size:12px; margin-top:5px;"></div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fa fa-check"></i> Reset Password
                </button>
            </form>

        </div>
    </div>
    <p class="login-footer">&copy; {{ date('Y') }} UniManage — All rights reserved</p>
</div>

<script>
    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        const show  = input.type === 'password';
        input.type  = show ? 'text' : 'password';
        icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
    }

    // Live password match check
    const newPw  = document.getElementById('newPassword');
    const confPw = document.getElementById('confirmPassword');
    const msg    = document.getElementById('matchMsg');

    [newPw, confPw].forEach(el => el.addEventListener('input', () => {
        if (confPw.value === '') { msg.textContent = ''; return; }
        if (newPw.value === confPw.value) {
            msg.textContent = '✓ Passwords match';
            msg.style.color = '#15803d';
        } else {
            msg.textContent = '✗ Passwords do not match';
            msg.style.color = '#b91c1c';
        }
    }));
</script>
</body>
</html>