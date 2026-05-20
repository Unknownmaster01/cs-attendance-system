<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance Scanner | CS Attendance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a56db;
            --primary-light: #e8f0fe;
            --primary-dark: #1040b0;
            --success: #10b981;
            --warning: #f59e0b;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TOP BAR */
        .scanner-topbar {
            background: #0f172a;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar-brand { display: flex; align-items: center; gap: 12px; }
        .topbar-logo { width: 32px; height: 32px; background: var(--primary); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .topbar-logo svg { width: 26px; height: 26px; }
        .topbar-name { font-size: 13px; font-weight: 700; color: #fff; }
        .event-pill { background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); border-radius: 20px; padding: 5px 14px; font-size: 12px; color: rgba(255,255,255,0.7); font-weight: 500; display: flex; align-items: center; gap: 7px; }
        .event-pill i { color: var(--primary); }
        .topbar-back { color: rgba(255,255,255,0.5); font-size: 12.5px; text-decoration: none; transition: color .18s; }
        .topbar-back:hover { color: #fff; }

        /* MAIN */
        .scanner-main {
            flex: 1; display: flex; align-items: center; justify-content: center;
            padding: 40px 20px;
        }
        .scanner-wrap { width: 100%; max-width: 540px; }

        .scanner-hero { text-align: center; margin-bottom: 32px; }
        .scanner-icon { width: 64px; height: 64px; background: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 8px 24px rgba(26,86,219,0.25); }
        .scanner-icon i { color: #fff; font-size: 26px; }
        .scanner-title { font-size: 24px; font-weight: 800; color: var(--text-main); }
        .scanner-sub { font-size: 13.5px; color: var(--text-muted); margin-top: 6px; }

        /* SEARCH */
        .search-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
        }
        .search-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--text-muted); margin-bottom: 10px; }
        .search-row { display: flex; gap: 10px; }
        .search-input-lg {
            flex: 1;
            border: 2px solid var(--border);
            border-radius: 10px;
            padding: 13px 16px;
            font-size: 15px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            outline: none;
            transition: border-color .18s, box-shadow .18s;
            letter-spacing: .5px;
        }
        .search-input-lg:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(26,86,219,0.1);
        }
        .search-btn {
            background: var(--primary); color: #fff; border: none;
            border-radius: 10px; padding: 13px 22px;
            font-size: 15px; cursor: pointer;
            transition: background .18s;
        }
        .search-btn:hover { background: var(--primary-dark); }
        .scan-hint { font-size: 11.5px; color: var(--text-muted); margin-top: 10px; display: flex; align-items: center; gap: 6px; }

        /* ALERTS */
        .alert-success-ojt { background: #d1fae5; color: #065f46; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .alert-danger-ojt { background: #fee2e2; color: #991b1b; border-radius: 10px; padding: 12px 16px; font-size: 13px; font-weight: 500; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }

        /* STUDENT RESULT CARD */
        .result-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            animation: fadeUp .3s ease;
        }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }

        .result-top {
            padding: 28px 24px 24px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }
        .result-photo { width: 90px; height: 90px; border-radius: 18px; object-fit: cover; border: 3px solid var(--primary); margin-bottom: 14px; box-shadow: 0 6px 20px rgba(26,86,219,0.15); }
        .result-name { font-size: 20px; font-weight: 800; }
        .result-id { font-size: 12.5px; font-weight: 700; color: var(--primary); margin-top: 4px; font-family: monospace; }

        .result-meta-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            padding: 18px 24px;
            gap: 16px;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }
        .meta-field { }
        .meta-field-label { font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: var(--text-muted); margin-bottom: 3px; }
        .meta-field-val { font-size: 13.5px; font-weight: 600; }

        .result-action { padding: 20px 24px; text-align: center; }
        .checkin-time { font-size: 12px; font-weight: 600; color: var(--success); background: #d1fae5; display: inline-flex; align-items: center; gap: 6px; padding: 5px 14px; border-radius: 20px; margin-bottom: 14px; }

        .btn-timein { display: inline-flex; align-items: center; gap: 10px; background: var(--success); color: #fff; border: none; border-radius: 12px; padding: 14px 32px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; transition: opacity .18s; width: 100%; justify-content: center; }
        .btn-timein:hover { opacity: .88; color: #fff; }
        .btn-timeout { display: inline-flex; align-items: center; gap: 10px; background: var(--warning); color: #fff; border: none; border-radius: 12px; padding: 14px 32px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; transition: opacity .18s; width: 100%; justify-content: center; }
        .btn-timeout:hover { opacity: .88; color: #fff; }
        .status-done { display: flex; align-items: center; justify-content: center; gap: 10px; background: #f1f5f9; border-radius: 12px; padding: 14px; font-size: 14px; font-weight: 600; color: var(--text-muted); }

        .not-found-card {
            background: #fff; border: 1px solid var(--border); border-radius: 16px;
            padding: 48px 24px; text-align: center;
        }
        .not-found-card i { font-size: 40px; color: #fca5a5; margin-bottom: 14px; display: block; }
        .not-found-card h5 { font-size: 16px; font-weight: 700; margin-bottom: 6px; }
        .not-found-card p { font-size: 13px; color: var(--text-muted); }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="scanner-topbar">
    <div class="topbar-brand">
        <div class="topbar-logo"><svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="38" y="68" width="24" height="6" rx="2" fill="white" opacity="0.9"/>
                        <rect x="44" y="74" width="12" height="5" rx="1" fill="white" opacity="0.9"/>
                        <rect x="18" y="22" width="64" height="48" rx="5" fill="white" opacity="0.15"/>
                        <rect x="21" y="25" width="58" height="40" rx="3" fill="#0f172a" opacity="0.8"/>
                        <rect x="28" y="32" width="18" height="3" rx="1" fill="#60a5fa"/>
                        <rect x="28" y="39" width="32" height="3" rx="1" fill="#93c5fd" opacity="0.8"/>
                        <rect x="32" y="46" width="22" height="3" rx="1" fill="#60a5fa"/>
                        <rect x="28" y="53" width="14" height="3" rx="1" fill="#93c5fd" opacity="0.8"/>
                        <rect x="32" y="60" width="26" height="3" rx="1" fill="#60a5fa"/>
                        <ellipse cx="50" cy="78" rx="7" ry="7" fill="white" opacity="0.9"/>
                        <path d="M38 100 Q50 88 62 100 L64 115 L36 115 Z" fill="white" opacity="0.9"/>
                        <path d="M40 103 L26 110" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                        <path d="M60 103 L74 110" stroke="white" stroke-width="4" stroke-linecap="round" opacity="0.9"/>
                    </svg></div>
        <span class="topbar-name">Monitoring Attendance Scanner</span>
    </div>
    <div class="event-pill">
        <i class="fas fa-calendar-check"></i>
        <?= esc($event_name) ?>
    </div>
    <a href="<?= base_url('admin') ?>" class="topbar-back">
        <i class="fas fa-arrow-left me-1"></i> Dashboard
    </a>
</div>

<!-- MAIN -->
<div class="scanner-main">
    <div class="scanner-wrap">
        <div class="scanner-hero">
            <div class="scanner-icon"><i class="fas fa-id-badge"></i></div>
            <div class="scanner-title">Student ID Scanner</div>
            <div class="scanner-sub">Enter or scan a student ID to record attendance</div>
        </div>

        <!-- SEARCH -->
        <div class="search-card">
            <div class="search-label">Enter Student ID</div>
            <form action="<?= base_url('admin/students') ?>" method="GET">
                <div class="search-row">
                    <input type="text" name="search" class="search-input-lg" placeholder="e.g. 2024-0001" value="<?= esc($search_query ?? '') ?>" autofocus>
                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <div class="scan-hint"><i class="fas fa-info-circle"></i> You can use a barcode scanner — it will auto-submit after scanning.</div>
        </div>

        <!-- ALERTS -->
        <?php if(session()->getFlashdata('msg')): ?>
            <div class="alert-success-ojt"><i class="fas fa-check-circle"></i><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert-danger-ojt"><i class="fas fa-exclamation-triangle"></i><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- RESULT -->
        <?php if ($search_query): ?>
            <?php if ($student): ?>
            <div class="result-card">
                <div class="result-top">
                    <img src="<?= !empty($student['profile_pic']) ? base_url('uploads/profiles/'.$student['profile_pic']) : 'https://ui-avatars.com/api/?name='.urlencode($student['full_name']).'&size=180&background=1a56db&color=fff' ?>"
                         class="result-photo">
                    <div class="result-name"><?= esc($student['full_name']) ?></div>
                    <div class="result-id"><?= esc($student['id_number']) ?></div>
                </div>
                <div class="result-meta-grid">
                    <div class="meta-field">
                        <div class="meta-field-label">Course</div>
                        <div class="meta-field-val"><?= esc($student['course']) ?></div>
                    </div>
                    <div class="meta-field">
                        <div class="meta-field-label">Year Level</div>
                        <div class="meta-field-val">Year <?= esc($student['year_level_id']) ?></div>
                    </div>
                </div>
                <div class="result-action">
                    <?php if (empty($student['time_in'])): ?>
                        <a href="<?= base_url('admin/toggle_attendance/'.$student['id_number'].'/'.$current_event_id) ?>" class="btn-timein">
                            <i class="fas fa-sign-in-alt"></i> CONFIRM TIME-IN
                        </a>
                    <?php elseif (empty($student['time_out'])): ?>
                        <div class="checkin-time"><i class="fas fa-clock"></i> Checked in at <?= date('h:i A', strtotime($student['time_in'])) ?></div>
                        <a href="<?= base_url('admin/toggle_attendance/'.$student['id_number'].'/'.$current_event_id) ?>" class="btn-timeout">
                            <i class="fas fa-sign-out-alt"></i> CONFIRM TIME-OUT
                        </a>
                    <?php else: ?>
                        <div class="status-done">
                            <i class="fas fa-check-double" style="color:var(--success)"></i>
                            Attendance fully recorded for today
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="not-found-card">
                <i class="fas fa-user-times"></i>
                <h5>Student Not Found</h5>
                <p>No student with ID "<strong><?= esc($search_query) ?></strong>" was found in the system.</p>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>