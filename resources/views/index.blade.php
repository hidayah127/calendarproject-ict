<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmazingTrack</title>
    <link rel="icon" type="image/png" href="{{ asset('logo/icon.png') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'DM Sans',sans-serif;
            min-height:100vh;

            background:
                linear-gradient(rgba(15,23,42,0.80), rgba(15,23,42,0.90)),
                url('{{ asset('logo/uptm3.jpg') }}') center/cover no-repeat;

            display:flex;
            justify-content:center;
            align-items:center;

            padding:20px;
        }

        .landing-container{
            width:100%;
            max-width:900px;

            background:rgba(255,255,255,0.08);

            backdrop-filter:blur(14px);

            border:1px solid rgba(255,255,255,0.12);

            border-radius:30px;

            padding:65px 55px;

            text-align:center;

            box-shadow:0 20px 60px rgba(0,0,0,0.28);

            color:white;
        }

        /* =========================================
           LOGO
        ========================================= */

        .logo{
            width:115px;
            height:115px;

            margin:0 auto 28px;

            border-radius:28px;

            background:white;

            display:flex;
            justify-content:center;
            align-items:center;

            box-shadow:0 12px 30px rgba(0,0,0,0.25);

            overflow:hidden;
        }

        .logo img{
            width:78%;
            height:auto;
            object-fit:contain;
        }

        /* =========================================
           TEXT
        ========================================= */

        h1{
            font-size:56px;
            font-weight:700;

            letter-spacing:-1px;

            margin-bottom:14px;
        }

        .subtitle{
            font-size:22px;
            font-weight:600;

            color:white;

            margin-bottom:14px;
        }

        .description{
            font-size:15px;

            line-height:1.8;

            color:rgba(255,255,255,0.78);

            max-width:650px;

            margin:0 auto 50px;
        }

        /* =========================================
           BUTTONS
        ========================================= */

        .button-group{
            display:flex;
            justify-content:center;
            gap:18px;
            flex-wrap:wrap;
        }

        .btn{
            min-width:220px;

            padding:16px 24px;

            border-radius:16px;

            text-decoration:none;

            font-size:15px;
            font-weight:600;

            transition:0.25s ease;

            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
        }

        .btn-primary{
            background:linear-gradient(135deg,#4f46e5,#6366f1);

            color:white;

            box-shadow:0 10px 25px rgba(99,102,241,0.35);
        }

        .btn-primary:hover{
            transform:translateY(-3px);

            box-shadow:0 18px 35px rgba(99,102,241,0.45);
        }

        .btn-secondary{
            background:rgba(255,255,255,0.12);

            border:1px solid rgba(255,255,255,0.15);

            color:white;
        }

        .btn-secondary:hover{
            transform:translateY(-3px);

            background:rgba(255,255,255,0.18);
        }

        /* =========================================
           FOOTER
        ========================================= */

        .footer{
            margin-top:50px;

            font-size:13px;

            color:rgba(255,255,255,0.6);
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media(max-width:768px){

            .landing-container{
                padding:45px 25px;
            }

            h1{
                font-size:40px;
            }

            .subtitle{
                font-size:18px;
            }

            .description{
                font-size:14px;
            }

            .btn{
                width:100%;
            }
        }

    </style>
</head>

<body>

    <div class="landing-container">

        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('logo/logo.png') }}" alt="UPTM Logo">
        </div>

        <!-- TITLE -->
        <h1>AmazingTrack System</h1>

        <!-- TAGLINE -->
        <div class="subtitle">
            Empowering Amazing Performance
        </div>

        <!-- DESCRIPTION -->
        <div class="description">
            Smart programme management and staff tracking platform designed to streamline reporting,
            committee coordination, programme monitoring, and organizational activities efficiently.
        </div>

        <!-- BUTTON GROUP -->
        <div class="button-group">

            <!-- SYSTEM LOGIN -->
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="fa-solid fa-right-to-bracket"></i>
                System Login
            </a>

            <!-- STAFF PORTAL -->
            <a href="{{ route('Portal.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-users"></i>
                Staff Portal
            </a>

            {{-- Public Calendar --}}
            <a href="{{ route('public.calendar') }}" class="btn btn-secondary">
                <i class="fa-solid fa-calendar-days"></i>
                Program Calendar
            </a>

        </div>

        <!-- FOOTER --> 
        <div class="footer">
            © {{ date('Y') }} AmazingTrack System. All Rights Reserved.
            <br>
            Developed by Information & Communication Technology Division 
            <br>
            UPTM
        </div>

    </div>

   <!-- PWA INSTALL BANNER -->
<div id="installBanner" class="install-banner">

    <div class="install-icon">
        <i class="fa fa-download"></i>
    </div>

    <div class="install-content">

        <div class="install-title">
            Install AmazingTrack
        </div>

        <div class="install-text">
            Install this app for faster access and a better experience.
        </div>

        <div class="install-actions">

            <button id="installBtn">
                Install App
            </button>

            <button id="closeInstallBanner">
                Later
            </button>

        </div>

    </div>

</div>

<style>

.install-banner{
    position:fixed;
    bottom:20px;
    left:50%;
    transform:translateX(-50%);
    width:min(92%,420px);
    background:white;
    border-radius:22px;
    padding:18px;
    box-shadow:0 15px 40px rgba(0,0,0,0.18);
    z-index:9999;
    border:1px solid #e2e8f0;

    display:flex;
    align-items:center;
    gap:15px;

    animation:slideUp .4s ease;
}

@keyframes slideUp{
    from{
        opacity:0;
        transform:translate(-50%,40px);
    }
    to{
        opacity:1;
        transform:translate(-50%,0);
    }
}

.install-icon{
    width:56px;
    height:56px;
    border-radius:16px;
    background:linear-gradient(135deg,#4f46e5,#6366f1);

    display:flex;
    align-items:center;
    justify-content:center;

    color:white;
    font-size:22px;

    flex-shrink:0;
}

.install-content{
    flex:1;
}

.install-title{
    font-size:16px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:4px;
}

.install-text{
    font-size:13px;
    line-height:1.5;
    color:#64748b;
    margin-bottom:14px;
}

.install-actions{
    display:flex;
    gap:8px;
}

.install-actions button{
    border:none;
    border-radius:10px;
    padding:10px 16px;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

#installBtn{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:white;
}

#closeInstallBanner{
    background:#f1f5f9;
    color:#475569;
}

</style>

<script>

let deferredPrompt;

const installBanner = document.getElementById('installBanner');
const installBtn = document.getElementById('installBtn');
const closeBtn = document.getElementById('closeInstallBanner');

installBanner.style.display = 'none';

window.addEventListener('beforeinstallprompt', (e) => {

    e.preventDefault();

    deferredPrompt = e;

    installBanner.style.display = 'flex';

});

installBtn.addEventListener('click', async () => {

    if (!deferredPrompt) {
        alert('Install is not available yet.');
        return;
    }

    deferredPrompt.prompt();

    const { outcome } = await deferredPrompt.userChoice;

    console.log(outcome);

    deferredPrompt = null;

    installBanner.style.display = 'none';

});

closeBtn.addEventListener('click', () => {

    installBanner.style.display = 'none';

});

</script>

<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js');
}
</script>

</body>
</html>