<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CS Attendance Monitoring System</title>
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
            --warning: #f59e0b;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
        }

        /* LEFT PANEL */
        .left-panel {
            width: 38%;
            background: linear-gradient(145deg, #0f172a 0%, #1a3560 100%);
            position: sticky; top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 44px;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            width: 360px; height: 360px; border-radius: 50%;
            background: rgba(26,86,219,0.1);
            top: -80px; right: -100px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 260px; height: 260px; border-radius: 50%;
            background: rgba(26,86,219,0.07);
            bottom: -60px; left: -40px;
        }
        .left-content { position: relative; z-index: 2; width: 100%; max-width: 300px; }
        .brand-block { display: flex; align-items: center; gap: 12px; margin-bottom: 48px; }
        .brand-logo { width: 44px; height: 44px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden; }
        .brand-logo svg { width: 36px; height: 36px; }
        .brand-name { font-size: 15px; font-weight: 800; color: #fff; }
        .brand-sub { font-size: 11px; color: rgba(255,255,255,0.45); }

        .panel-tag { display: inline-flex; align-items: center; gap: 7px; background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.3); border-radius: 20px; padding: 5px 13px; font-size: 11px; font-weight: 600; color: #6ee7b7; margin-bottom: 18px; }
        .panel-title { font-size: 30px; font-weight: 800; color: #fff; line-height: 1.2; margin-bottom: 14px; }
        .panel-title span { color: #60a5fa; }
        .panel-desc { font-size: 13px; color: rgba(255,255,255,0.5); line-height: 1.7; margin-bottom: 36px; }

        .steps-list { display: flex; flex-direction: column; gap: 16px; }
        .step-item { display: flex; align-items: flex-start; gap: 12px; }
        .step-num { width: 26px; height: 26px; border-radius: 7px; background: var(--primary); color: #fff; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }
        .step-text strong { font-size: 12.5px; color: rgba(255,255,255,0.85); display: block; font-weight: 700; }
        .step-text span { font-size: 11.5px; color: rgba(255,255,255,0.45); }

        /* RIGHT PANEL */
        .right-panel { flex: 1; overflow-y: auto; padding: 48px 40px; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; }
        .register-box { width: 100%; max-width: 480px; }

        .register-header { margin-bottom: 28px; }
        .register-header h2 { font-size: 24px; font-weight: 800; color: var(--text-main); }
        .register-header p { font-size: 13px; color: var(--text-muted); margin-top: 5px; }

        /* ALERTS */
        .alert-ojt { border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-danger-ojt { background: #fee2e2; color: #991b1b; }
        .alert-warning-ojt { background: #fef3c7; color: #92400e; }
        .alert-ojt ul { margin: 6px 0 0 16px; padding: 0; }
        .alert-ojt li { font-size: 12.5px; margin-bottom: 3px; }

        /* SECTION DIVIDER */
        .section-label {
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1px;
            color: var(--text-muted);
            display: flex; align-items: center; gap: 10px;
            margin: 24px 0 16px;
        }
        .section-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

        /* FORM */
        .form-group { margin-bottom: 16px; }
        .form-label-ojt { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 7px; display: block; }
        .form-control-ojt {
            width: 100%; border: 1.5px solid var(--border);
            border-radius: 10px; padding: 11px 16px;
            font-size: 13.5px; font-weight: 500;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff; color: var(--text-main);
            outline: none; transition: border-color .18s, box-shadow .18s;
        }
        .form-control-ojt:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,219,0.1); }
        .form-control-ojt::placeholder { color: #cbd5e1; }
        .form-hint { font-size: 11.5px; color: var(--text-muted); margin-top: 5px; }

        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #cbd5e1; font-size: 13px; }
        .form-control-ojt.has-icon { padding-left: 38px; }

        .row-group { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* SUBMIT */
        .btn-register {
            width: 100%; background: var(--success); color: #fff; border: none;
            border-radius: 10px; padding: 13px;
            font-size: 14.5px; font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; transition: opacity .18s, transform .1s;
            margin-top: 8px;
        }
        .btn-register:hover { opacity: .88; }
        .btn-register:active { transform: scale(.98); }

        .divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 12px; color: #cbd5e1; }

        .login-link { text-align: center; font-size: 13.5px; color: var(--text-muted); }
        .login-link a { color: var(--primary); font-weight: 700; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

        @media (max-width: 860px) {
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

        <div class="panel-tag"><i class="fas fa-user-plus" style="font-size:10px"></i> New Student Account</div>
        <div class="panel-title">Join the<br><span>Student</span><br>Portal Today.</div>
        <div class="panel-desc">Create your account in minutes and gain full access to CS attendance tracking, class schedules, and coordinator announcements.</div>

        <div class="steps-list">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <strong>Fill in your details</strong>
                    <span>Name, ID, course & year level</span>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <strong>Set your password</strong>
                    <span>Choose a secure password</span>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <strong>Log in & get started</strong>
                    <span>Access your full dashboard</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RIGHT -->
<div class="right-panel">
    <div class="register-box">
        <div class="register-header">
            <h2>Create your account</h2>
            <p>Fill in the form below to register as a CS student</p>
        </div>

        <?php if(session()->getFlashdata('msg')): ?>
        <div class="alert-ojt alert-danger-ojt">
            <i class="fas fa-exclamation-triangle" style="margin-top:2px"></i>
            <span><?= session()->getFlashdata('msg') ?></span>
        </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert-ojt alert-warning-ojt">
            <i class="fas fa-list" style="margin-top:2px"></i>
            <div>
                <strong>Please fix the following:</strong>
                <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('register/save') ?>" method="post">
            <div class="section-label">Personal Information</div>

            <div class="form-group">
                <label class="form-label-ojt">Full Name</label>
                <div class="input-wrap">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="full_name" class="form-control-ojt has-icon" placeholder="Juan dela Cruz" value="<?= old('full_name') ?>" required>
                </div>
            </div>

            <div class="row-group">
                <div class="form-group">
                    <label class="form-label-ojt">Student ID Number</label>
                    <div class="input-wrap">
                        <i class="fas fa-id-card input-icon"></i>
                        <input type="text" name="username" class="form-control-ojt has-icon"
                               placeholder="23-a-01647"
                               pattern="[0-9]{2}-[A-Za-z]-[0-9]{5}"
                               title="Format: 23-a-01647"
                               value="<?= old('username') ?>" required>
                    </div>
                    <div class="form-hint">Format: 23-a-01647</div>
                </div>

                <div class="form-group">
                    <label class="form-label-ojt">Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control-ojt has-icon" placeholder="you@uni.edu.ph" value="<?= old('email') ?>" required>
                    </div>
                </div>
            </div>

            <div class="section-label">Academic Details</div>

            <div class="row-group">
                <div class="form-group">
                    <label class="form-label-ojt">Course / Program</label>
                    <select name="course" class="form-control-ojt" required>
                        <option value="" disabled selected>Select course</option>
                        <option value="BSCS" <?= old('course') == 'BSCS' ? 'selected' : '' ?>>BSCS</option>
                        <option value="BSIS" <?= old('course') == 'BSIS' ? 'selected' : '' ?>>BSIS</option>
                        <option value="BSIT" <?= old('course') == 'BSIT' ? 'selected' : '' ?>>BSIT</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label-ojt">Year Level</label>
                    <select name="year_level_id" class="form-control-ojt">
                        <option value="1" <?= old('year_level_id') == '1' ? 'selected' : '' ?>>1st Year</option>
                        <option value="2" <?= old('year_level_id') == '2' ? 'selected' : '' ?>>2nd Year</option>
                        <option value="3" <?= old('year_level_id') == '3' ? 'selected' : '' ?>>3rd Year</option>
                        <option value="4" <?= old('year_level_id') == '4' ? 'selected' : '' ?>>4th Year</option>
                    </select>
                </div>
            </div>

            <div class="section-label">Security</div>

            <div class="form-group">
                <label class="form-label-ojt">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control-ojt has-icon" placeholder="Choose a strong password" required>
                </div>
            </div>

            <input type="hidden" name="role" value="student">
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus me-2"></i> Create Account
            </button>
        </form>

        <div class="divider"><span>OR</span></div>
        <div class="login-link">
            Already have an account? <a href="<?= base_url('login') ?>">Log in here</a>
        </div>
    </div>
</div>

</body>
</html>