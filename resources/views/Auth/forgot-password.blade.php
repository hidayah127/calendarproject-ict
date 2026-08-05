<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password | UniManage</title>
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
    .form-control, .form-select { border-radius:10px!important; border:1.5px solid #e2e8f0!important; padding:11px 14px!important; font-size:14.5px!important; font-family:inherit; color:#1e293b; transition:border-color .2s,box-shadow .2s; background:#f8faff!important; }
    .form-control:focus, .form-select:focus { border-color:var(--blue-mid)!important; box-shadow:0 0 0 3px rgba(26,86,219,0.12)!important; background:#fff!important; outline:none; }
    .btn-login { background:linear-gradient(135deg,var(--blue-dark),var(--blue-mid)); color:#fff; border:none; border-radius:10px; padding:12px; font-size:15px; font-weight:600; font-family:inherit; width:100%; cursor:pointer; box-shadow:0 6px 20px rgba(26,86,219,0.32); transition:transform .2s,box-shadow .2s; display:flex; align-items:center; justify-content:center; gap:8px; }
    .btn-login:hover { transform:translateY(-2px); box-shadow:0 10px 28px rgba(26,86,219,0.38); }
    .login-footer { text-align:center; margin-top:22px; font-size:12.5px; color:rgba(255,255,255,0.55); }
    .back-link { font-size:13.5px; color:#1a56db; text-decoration:none; font-weight:500; display:inline-flex; align-items:center; gap:6px; }
    .back-link:hover { text-decoration:underline; }
    .hint-box { font-size:12.5px; color:#64748b; background:#f8faff; border:1px solid #e2e8f0; border-radius:10px; padding:10px 12px; margin-bottom:20px; display:flex; gap:8px; align-items:flex-start; }
    .hint-box i { color:var(--blue-mid); margin-top:2px; }
    .fallback-box {
        display:none;
        font-size:12.5px; color:#92400e;
        background:#fffbeb; border:1px solid #fde68a;
        border-radius:10px; padding:12px 14px; margin-top:16px;
    }
    .fallback-box.show { display:block; }
    .fallback-box code { background:#fef3c7; padding:2px 6px; border-radius:6px; font-weight:700; }
    .invalid-text { color:#dc2626; font-size:12px; margin-top:5px; display:none; }
</style>
</head>
<body>
<div class="login-wrap">
    <div class="card login-card">
        <div class="card-accent"></div>
        <div class="card-body">

            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fa fa-key"></i>
                </div>
                <h4 class="logo">Forgot Password</h4>
                <p class="subtitle">We'll draft an email to ICT for you</p>
            </div>

            <div class="hint-box">
                <i class="fa fa-circle-info"></i>
                <span>Fill in your details below. This will open Gmail in a new tab with a message already addressed to ICT — just hit send.</span>
            </div>

            <form id="forgotForm" novalidate>
                <div class="mb-4">
                    <label class="form-label">AmazingTrack Username</label>
                    <input type="text" id="username" class="form-control"
                           placeholder="Enter your username" required>
                    <div class="invalid-text" id="usernameError">Please enter your username.</div>
                </div>

                <button type="submit" class="btn-login mb-3">
                    <i class="fa fa-envelope"></i> Continue to Gmail
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fa fa-arrow-left"></i> Back to Sign In
                    </a>
                </div>
            </form>

            <div class="fallback-box" id="fallbackBox">
                <i class="fa fa-triangle-exclamation"></i>
                If Gmail didn't open in a new tab (pop-up blocked, or you're not signed into a Google account), please email <code>ict@uptm.edu.my</code> directly with your username and department, requesting a password reset.
            </div>

        </div>
    </div>
    <p class="login-footer">&copy; {{ date('Y') }} UniManage — All rights reserved</p>
</div>

<script>
document.getElementById('forgotForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const username = document.getElementById('username').value.trim();

    const usernameError = document.getElementById('usernameError');

    if (!username) {
        usernameError.style.display = 'block';
        return;
    }
    usernameError.style.display = 'none';

    const subject = 'AmazingTrack Password Reset Request';
    const body =
        'Username: ' + username + '\n\n' +
        'I forgot my password and would like ICT to reset it to the default password.';

    const gmailComposeUrl =
        'https://mail.google.com/mail/?view=cm&fs=1' +
        '&to=' + encodeURIComponent('ict@uptm.edu.my') +
        '&su=' + encodeURIComponent(subject) +
        '&body=' + encodeURIComponent(body);

    window.open(gmailComposeUrl, '_blank');

    // Show a fallback note in case the popup was blocked or Gmail
    // isn't the user's signed-in account
    document.getElementById('fallbackBox').classList.add('show');
});
</script>

</body>
</html>
