<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login | AmazingTrack</title>
<link rel="icon" type="image/png" href="{{ asset('logo/icon.png') }}">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

:root {
    --blue-dark:  #0f2d6e;
    --blue-mid:   #1a56db;
    --accent:     #f59e0b;
    --radius:     16px;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, var(--blue-dark) 0%, var(--blue-mid) 60%, #2563eb 100%);
    position: relative;
    overflow: hidden;
}

/* ── decorative blobs ── */
body::before, body::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
body::before {
    width: 420px; height: 420px;
    background: rgba(245,158,11,0.10);
    top: -120px; right: -100px;
}
body::after {
    width: 320px; height: 320px;
    background: rgba(96,165,250,0.10);
    bottom: -80px; left: -80px;
}

/* dot grid overlay */
body {
    background-image:
        linear-gradient(145deg, var(--blue-dark) 0%, var(--blue-mid) 60%, #2563eb 100%),
        radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
    background-size: cover, 26px 26px;
}

/* ── card ── */
.login-wrap {
    width: 100%;
    max-width: 440px;
    padding: 16px;
    z-index: 1;
}

.login-card {
    border: none !important;
    border-radius: var(--radius) !important;
    box-shadow: 0 24px 64px rgba(10,20,60,0.35) !important;
    overflow: hidden;
}

/* top accent stripe */
.card-accent {
    height: 5px;
    background: linear-gradient(90deg, var(--accent), #fbbf24, #f97316);
}

.card-body {
    padding: 40px 36px 36px !important;
}

/* ── brand ── */
/* .brand-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    box-shadow: 0 8px 24px rgba(26,86,219,0.30);
}

.brand-icon i {
    font-size: 24px;
    color: #fff;
} */

.brand-icon {
    width: 100px;
    height: 100px;
    margin: auto;
    display: flex; align-items: center; justify-content: center;


}

.brand-icon img {
    width: 90px;
}

.logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: .3px;
}

.subtitle {
    font-size: 13.5px;
    color: #64748b;
    margin-top: 4px;
}

.tagline {
    font-size: 12.5px;
    color: #94a3b8;
    margin-top: 2px;
    font-style: italic;
}

/* ── form ── */
.form-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-control {
    border-radius: 10px !important;
    border: 1.5px solid #e2e8f0 !important;
    padding: 11px 14px !important;
    font-size: 14.5px !important;
    font-family: inherit;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
    background: #f8faff !important;
}

.form-control:focus {
    border-color: var(--blue-mid) !important;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.12) !important;
    background: #fff !important;
    outline: none;
}

/* password wrapper */
.pw-wrap {
    position: relative;
}

.pw-wrap .form-control {
    padding-right: 46px !important;
}

.pw-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    transition: color .2s;
}

.pw-toggle:hover { color: var(--blue-mid); }

/* ── alert ── */
.alert-danger {
    border-radius: 10px !important;
    font-size: 13.5px;
    border: none !important;
    background: #fef2f2 !important;
    color: #b91c1c !important;
    padding: 10px 14px !important;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* ── submit button ── */
.btn-login {
    background: linear-gradient(135deg, var(--blue-dark), var(--blue-mid));
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-size: 15px;
    font-weight: 600;
    font-family: inherit;
    width: 100%;
    cursor: pointer;
    box-shadow: 0 6px 20px rgba(26,86,219,0.32);
    transition: transform .2s, box-shadow .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(26,86,219,0.38);
}

.btn-login:active {
    transform: translateY(0);
}

.btn-staff-portal {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;

    width: 100%;
    padding: 12px;

    font-size: 14.5px;
    font-weight: 600;

    border-radius: 10px;

    background: #ffffff;
    color: #1a56db;

    border: 1.5px solid #1a56db;

    text-decoration: none;

    transition: all .2s ease;
}

.btn-staff-portal:hover {

    background: #1a56db;
    color: #ffffff;

    transform: translateY(-2px);

}

/* ── footer note ── */
.login-footer {
    text-align: center;
    margin-top: 22px;
    font-size: 12.5px;
    color: rgba(255,255,255,0.55);
}

/* ── responsive ── */
@media (max-width: 480px) {
    .card-body { padding: 30px 22px 26px !important; }
}

</style>

</head>
<body>

<div class="login-wrap">

    <div class="card login-card">

        <div class="card-accent"></div>

        <div class="card-body">

            {{-- Brand --}}
            <div class="text-center mb-4">
                {{-- <div class="brand-icon">
                    <i class="fa fa-graduation-cap"></i>
                </div> --}}

                <div class="brand-icon">
                    <img src="{{ asset('logo/logo.png') }}" alt="Logo" style="height:40px;">
                </div>
                <h4 class="logo">AmazingTrack</h4>
                <p class="subtitle">Program Management System</p>
                <p class="tagline">"Empowering Amazing Performance"</p>
            </div>

            {{-- Error --}}
            @if(session('error'))
            <div class="alert alert-danger mb-3">
                <i class="fa fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                {{-- Staff ID --}}
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Enter your username"
                           value="{{ old('username') }}"
                           autocomplete="username"
                           required>
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="pw-wrap">
                        <input type="password"
                               id="passwordInput"
                               name="password"
                               class="form-control"
                               placeholder="Enter your password"
                               autocomplete="current-password"
                               required>
                        <button type="button"
                                class="pw-toggle"
                                id="pwToggle"
                                aria-label="Toggle password visibility">
                            <i class="fa fa-eye" id="pwIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Forgot Password --}}
                {{-- <div class="mb-4 text-end">
                    <a href="{{ route('forgot.password') }}"
                    style="font-size:13px; color:#1a56db; text-decoration:none; font-weight:500;">
                        Forgot password?
                    </a>
                </div> --}}

                {{-- Submit --}}
                <button type="submit" class="btn-login">
                    <i class="fa fa-sign-in-alt"></i>
                    Sign In
                </button>

                {{-- staff portal link --}}
                <div class="mt-4 text-center">
                    <a href="{{ route('index') }}" style="font-size:13px; color:#1a56db; text-decoration:none; font-weight:500;">
                        <i class="fa fa-home"></i> Back to Home
                    </a>
                </div>

                {{-- <a href="{{ route('portal.index') }}"
                class="btn-staff-portal mt-3">

                    <i class="fa fa-users"></i>
                    Be An Amazing You Portal

                </a> --}}

                {{-- <a href="{{ route('index') }}">Home</a> --}}

            </form>

        </div>
    </div>

    <p class="login-footer">
        &copy; {{ date('Y') }} AmazingTrack — All rights reserved<br>
        Developed by Information & Communication Technology Division UPTM
    </p>

</div>

<script>
    const toggle = document.getElementById('pwToggle');
    const input  = document.getElementById('passwordInput');
    const icon   = document.getElementById('pwIcon');

    toggle.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'fa fa-eye-slash' : 'fa fa-eye';
        toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
    });
</script>

</body>
</html>