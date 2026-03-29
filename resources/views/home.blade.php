<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Access | Microsite System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            --primary: #4f46e5;
            --admin: #ef4444;
            --member: #10b981;
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .portal-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 32px;
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .system-logo {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        h1 {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 2.5rem;
        }

        /* --- Login Option Buttons --- */
        .login-option {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            background: white;
        }

        .login-option:last-child { margin-bottom: 0; }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
            transition: 0.3s;
        }

        .option-text {
            text-align: left;
        }

        .option-title {
            display: block;
            font-weight: 700;
            color: #1e293b;
            font-size: 1rem;
        }

        .option-desc {
            display: block;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* Hover States */
        .login-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
            border-color: var(--primary);
        }

        /* Variant Colors */
        .opt-club .icon-box { background: #eef2ff; color: var(--primary); }
        .opt-admin .icon-box { background: #fef2f2; color: var(--admin); }
        .opt-member .icon-box { background: #ecfdf5; color: var(--member); }

        .opt-club:hover { border-color: var(--primary); }
        .opt-admin:hover { border-color: var(--admin); }
        .opt-member:hover { border-color: var(--member); }

        .footer-note {
            margin-top: 2rem;
            font-size: 0.8rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="portal-card">
    <div class="system-logo">
        <i class="bi bi-shield-lock-fill"></i>
    </div>
    
    <h1>System Access</h1>
    <p class="subtitle">Select a portal to continue</p>

    <a href="/clubmember" class="login-option opt-member">
        <div class="icon-box">
            <i class="bi bi-person-badge"></i>
        </div>
        <div class="option-text">
            <span class="option-title">Club Member Login</span>
            <span class="option-desc">View your orders and dashboard</span>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
    </a>

    <a href="/club" class="login-option opt-club">
        <div class="icon-box">
            <i class="bi bi-building"></i>
        </div>
        <div class="option-text">
            <span class="option-title">Club Login</span>
            <span class="option-desc">Manage your specific club branch</span>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
    </a>

    {{-- <a href="/admin" class="login-option opt-admin">
        <div class="icon-box">
            <i class="bi bi-incognito"></i>
        </div>
        <div class="option-text">
            <span class="option-title">Admin Login</span>
            <span class="option-desc">Full system management access</span>
        </div>
        <i class="bi bi-chevron-right ms-auto text-muted"></i>
    </a> --}}

    <div class="footer-note">
        &copy; 2026 Microsite System. All rights reserved.
    </div>
</div>

</body>
</html>