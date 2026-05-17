<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CS Attendance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a56db;
            --primary-dark: #1040b0;
            --primary-light: #e8f0fe;
            --success: #10b981;
            --danger: #ef4444;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: stretch;
            background: #f8fafc;
        }

        /* LEFT PANEL */
        .left-panel {
            width: 45%;
            background: linear-gradient(145deg, #0f172a 0%, #1a3560 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 48px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(26,86,219,0.12);
            top: -100px; right: -100px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(26,86,219,0.08);
            bottom: -80px; left: -60px;
        }
        .left-content { position: relative; z-index: 2; width: 100%; max-width: 340px; }

        .brand-block { display: flex; align-items: center; gap: 14px; margin-bottom: 56px; }
        .brand-logo {
            width: 48px; height: 48px;
            background: var(--primary);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }
        .brand-logo svg { width: 38px; height: 38px; }
        .brand-name { font-size: 16px; font-weight: 800; color: #fff; line-height: 1.2; }
        .brand-sub { font-size: 11px; color: rgba(255,255,255,0.5); font-weight: 400; }

        .hero-tag {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(26,86,219,0.3);
            border: 1px solid rgba(26,86,219,0.4);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 11px; font-weight: 600;
            color: rgba(255,255,255,0.8);
            margin-bottom: 20px;
        }
        .hero-tag i { font-size: 10px; color: var(--primary); }

        .hero-title {
            font-size: 36px; font-weight: 800;
            color: #fff; line-height: 1.15;
            margin-bottom: 16px;
        }
        .hero-title span { color: #60a5fa; }
        .hero-desc {
            font-size: 14px; color: rgba(255,255,255,0.55);
            line-height: 1.7; margin-bottom: 40px;
        }

        .feature-list { display: flex; flex-direction: column; gap: 14px; }
        .feature-item { display: flex; align-items: center; gap: 12px; }
        .feature-dot { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-dot i { color: #60a5fa; font-size: 13px; }
        .feature-text { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 500; }

        /* RIGHT PANEL */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            background: #f8fafc;
        }
        .login-box { width: 100%; max-width: 400px; }

        .login-header { margin-bottom: 32px; }
        .login-header h2 { font-size: 26px; font-weight: 800; color: var(--text-main); }
        .login-header p { font-size: 13.5px; color: var(--text-muted); margin-top: 6px; }

        /* ALERT */
        .alert-info-ojt {
            background: var(--primary-light); color: var(--primary);
            border-radius: 10px; padding: 12px 16px;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 20px;
        }

        /* FORM */
        .form-group { margin-bottom: 18px; }
        .form-label-ojt {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .6px;
            color: var(--text-muted); margin-bottom: 7px; display: block;
        }
        .form-control-ojt {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px; font-weight: 500;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            color: var(--text-main);
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }
        .form-control-ojt:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
        }
        .form-control-ojt::placeholder { color: #cbd5e1; }

        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #cbd5e1; font-size: 14px; }
        .form-control-ojt.has-icon { padding-left: 40px; }

        .btn-login {
            width: 100%;
            background: var(--primary);
            color: #fff; border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 14.5px; font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: background .18s, transform .1s;
            margin-top: 6px;
        }
        .btn-login:hover { background: var(--primary-dark); }
        .btn-login:active { transform: scale(.98); }

        .divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 12px; color: #cbd5e1; font-weight: 500; }

        .register-link {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; font-size: 13.5px; color: var(--text-muted);
        }
        .register-link a { color: var(--primary); font-weight: 700; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        .copyright { text-align: center; font-size: 11.5px; color: #cbd5e1; margin-top: 28px; }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 32px 20px; }
        }
    </style>
</head>
<body>

<!-- LEFT -->
<div class="left-panel">
    <div class="left-content">
        <div class="brand-block">
            <div class="brand-logo">
                    <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- monitor stand -->
                        <rect x="38" y="68" width="24" height="6" rx="2" fill="white" opacity="0.9"/>
                        <rect x="44" y="74" width="12" height="5" rx="1" fill="white" opacity="0.9"/>
                        <!-- monitor -->
                        <rect x="18" y="22" width="64" height="48" rx="5" fill="white" opacity="0.15"/>
                        <rect x="21" y="25" width="58" height="40" rx="3" fill="#0f172a" opacity="0.8"/>
                        <!-- code lines on screen -->
                        <rect x="28" y="32" width="18" height="3" rx="1" fill="#60a5fa"/>
                        <rect x="28" y="39" width="32" height="3" rx="1" fill="#93c5fd" opacity="0.8"/>
                        <rect x="32" y="46" width="22" height="3" rx="1" fill="#60a5fa"/>
                        <rect x="28" y="53" width="14" height="3" rx="1" fill="#93c5fd" opacity="0.8"/>
                        <rect x="32" y="60" width="26" height="3" rx="1" fill="#60a5fa"/>
                        <!-- person head -->
                        <ellipse cx="50" cy="78" rx="7" ry="7" fill="white" opacity="0.9"/>
                        <!-- person body -->
                        <path d="M38 100 Q50 88 62 100 L64 115 L36 115 Z" fill="white" opacity="0.9"/>
                        <!-- arms -->
                        <path d="M40 103 L26 110" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                        <path d="M60 103 L74 110" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                    </svg>
                </div>
            <div>
                <div class="brand-name">CS Attendance Monitoring System</div>
                <div class="brand-sub">College of Computing Studies</div>
            </div>
        </div>

        <div class="hero-tag"><i class="fas fa-circle"></i> Student Portal</div>
        <div class="hero-title">Monitor Your<br><span>CS Attendance</span><br>with Ease.</div>
        <div class="hero-desc">Log in to view your attendance records, monitor class schedules, and stay updated with announcements from your coordinators.</div>

        <div class="feature-list">
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-clock"></i></div>
                <div class="feature-text">Real-time attendance tracking</div>
            </div>
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-calendar-check"></i></div>
                <div class="feature-text">CS class schedule & calendar</div>
            </div>
            <div class="feature-item">
                <div class="feature-dot"><i class="fas fa-bell"></i></div>
                <div class="feature-text">Instant announcements from admin</div>
            </div>
        </div>
    </div>
</div>

<!-- RIGHT -->
<div class="right-panel">
    <div class="login-box">
        <div class="login-header">
            <h2>Welcome back 👋</h2>
            <p>Enter your Student ID and password to continue</p>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert-info-ojt">
            <i class="fas fa-info-circle"></i>
            <?= session()->getFlashdata('msg') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('/login/auth') ?>" method="post">
            <div class="form-group">
                <label class="form-label-ojt">Student ID Number</label>
                <div class="input-wrap">
                    <i class="fas fa-id-card input-icon"></i>
                    <input type="text" name="username" class="form-control-ojt has-icon" placeholder="e.g. 23-a-01647" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label-ojt">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control-ojt has-icon" placeholder="Enter your password" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Log In to Portal
            </button>
        </form>

        <div class="divider"><span>OR</span></div>

        <div class="register-link">
            Don't have an account? <a href="<?= base_url('/register') ?>">Create one here</a>
        </div>

        <div class="copyright">&copy; 2026 College of Computing Studies &bull; BSCS | BSIS | BSIT</div>
    </div>
</div>

</body>
</html>