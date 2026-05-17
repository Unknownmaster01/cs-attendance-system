<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile | <?= esc($student['full_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* ── Profile card layout ── */
        .profile-wrap {
            max-width: 820px;
            margin: 0 auto;
        }

        .profile-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-2xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
        }

        /* Top section: avatar + name + actions */
        .profile-top {
            display: flex; align-items: center; gap: 22px;
            padding: 28px 32px 24px;
            border-bottom: 1.5px solid var(--border);
            flex-wrap: wrap;
        }
        .profile-img-wrap { position: relative; flex-shrink: 0; }
        .profile-img-lg {
            width: 90px; height: 90px;
            border-radius: var(--r-lg);
            object-fit: cover;
            border: 2.5px solid var(--primary);
            box-shadow: 0 6px 18px rgba(59,91,252,0.20);
        }
        .online-dot {
            width: 13px; height: 13px;
            background: var(--success);
            border-radius: 50%;
            border: 2px solid #fff;
            position: absolute; bottom: 4px; right: 4px;
        }
        .profile-name {
            font-family: 'Sora', sans-serif;
            font-size: 20px; font-weight: 800;
            color: var(--text-main); letter-spacing: -0.4px;
        }
        .profile-id-badge {
            display: inline-block;
            font-family: 'Courier New', monospace;
            font-size: 12px; font-weight: 700;
            color: var(--primary); background: var(--primary-light);
            padding: 3px 10px; border-radius: 6px;
            margin-top: 5px;
        }
        .profile-meta { display: flex; gap: 14px; margin-top: 10px; flex-wrap: wrap; }
        .meta-chip {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--text-muted); font-weight: 500;
        }
        .meta-chip i { color: var(--primary); font-size: 11px; width: 13px; }

        .profile-actions { margin-left: auto; display: flex; gap: 8px; align-self: center; }
        .btn-action-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: var(--r-md);
            font-size: 12px; font-weight: 600;
            text-decoration: none;
            border: 1.5px solid var(--border);
            color: var(--text-muted); background: var(--card-bg);
            cursor: pointer; transition: border-color var(--fast), color var(--fast);
            font-family: 'DM Sans', sans-serif;
        }
        .btn-action-sm:hover { border-color: var(--primary); color: var(--primary); }

        /* Attendance control box */
        .attendance-box {
            background: linear-gradient(to bottom right, #f6f8ff, #eef1ff);
            border-bottom: 1.5px solid var(--border);
            padding: 22px 32px;
        }
        .att-section-label {
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: var(--text-muted); margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .att-section-label::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }
        .event-tag {
            display: inline-flex; align-items: center; gap: 7px;
            font-size: 12.5px; font-weight: 600; color: var(--text-main);
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 6px 14px; margin-bottom: 16px;
        }

        .btn-timein {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--success); color: #fff; border: none;
            border-radius: var(--r-md); padding: 11px 26px;
            font-size: 13.5px; font-weight: 700; cursor: pointer;
            text-decoration: none; font-family: 'DM Sans', sans-serif;
            transition: filter var(--fast), transform var(--fast);
        }
        .btn-timein:hover { filter: brightness(1.08); transform: translateY(-1px); color: #fff; }

        .btn-timeout {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--warning); color: #fff; border: none;
            border-radius: var(--r-md); padding: 11px 26px;
            font-size: 13.5px; font-weight: 700; cursor: pointer;
            text-decoration: none; font-family: 'DM Sans', sans-serif;
            transition: filter var(--fast), transform var(--fast);
        }
        .btn-timeout:hover { filter: brightness(1.08); transform: translateY(-1px); color: #fff; }

        .timein-badge {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 600; color: var(--success);
            background: var(--success-bg); padding: 5px 12px;
            border-radius: 20px; margin-bottom: 12px;
        }
        .status-done {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 11px 20px;
            font-size: 13px; font-weight: 600; color: var(--text-muted);
        }
        .no-event-msg {
            display: flex; align-items: center; gap: 10px;
            font-size: 13px; font-weight: 500;
            color: var(--warning-dark); background: var(--warning-bg);
            padding: 12px 16px; border-radius: var(--r-md);
        }

        /* Info grid */
        .info-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 24px; padding: 26px 32px;
            border-bottom: 1.5px solid var(--border);
        }
        .info-label {
            font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: var(--text-muted); margin-bottom: 5px;
            display: flex; align-items: center; gap: 6px;
        }
        .info-label i { color: var(--primary); font-size: 10px; width: 13px; }
        .info-value { font-size: 14.5px; font-weight: 600; color: var(--text-main); }
        .info-value.empty { color: var(--text-light); font-style: italic; font-weight: 400; }

        /* Card footer */
        .card-footer-bar {
            padding: 16px 32px;
            display: flex; gap: 10px; flex-wrap: wrap;
        }

        /* Back link */
        .back-link {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--text-muted); font-size: 12.5px; font-weight: 600;
            text-decoration: none; margin-bottom: 20px;
            transition: color var(--fast);
        }
        .back-link:hover { color: var(--primary); }

        @media (max-width: 768px) {
            .profile-top { flex-direction: column; align-items: flex-start; }
            .profile-actions { margin-left: 0; }
            .info-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════
     TOP NAV (matches dashboard exactly)
══════════════════════════════════════ -->
<nav class="topnav">
    <div class="topnav-inner">
        <a class="topnav-brand" href="<?= base_url('admin') ?>">
            <div class="brand-icon"><svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
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
            <div class="brand-text">
                <span class="brand-title">CS Attendance Monitoring System</span>
                <span class="brand-sub">Admin Portal</span>
            </div>
        </a>
        <div class="topnav-links">
            <a class="topnav-link" href="<?= base_url('admin') ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="topnav-link active" href="<?= base_url('admin/students') ?>">
                <i class="fas fa-users"></i> Students
            </a>
            <a class="topnav-link" href="<?= base_url('admin/check_attendance') ?>">
                <i class="fas fa-clipboard-check"></i> Attendance Log
            </a>
            <a class="topnav-link" href="<?= base_url('admin/events') ?>">
                <i class="fas fa-calendar-check"></i> Events   
            </a>
            <a class="topnav-link" href="<?= base_url('admin/announcements') ?>">
                <i class="fas fa-bullhorn"></i> Announcements       
            </a>  
        </div>
        <div class="topnav-right">
            <button class="topnav-icon-btn" title="Notifications">
                <i class="fas fa-bell"></i>
            </button>
            <div class="topnav-admin">
                <div class="topnav-admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <span class="topnav-admin-name">Administrator</span>
                    <span class="topnav-admin-role">Super Admin</span>
                </div>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn-logout-admin" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</nav>

<!-- ══════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════ -->
<div class="main-content">

    <!-- Page header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Student Profile</h1>
            <p class="page-sub">Viewing details for <?= esc($student['full_name']) ?></p>
        </div>
        <div class="page-header-right">
            <a href="<?= base_url('admin/students') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Students
            </a>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('msg')): ?>
    <div class="flash-alert flash-success">
        <i class="fas fa-check-circle"></i>
        <?= session()->getFlashdata('msg') ?>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-alert flash-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <div class="profile-wrap">
        <div class="profile-card">

            <!-- TOP -->
            <div class="profile-top">
                <div class="profile-img-wrap">
                    <img src="<?= !empty($student['profile_pic'])
                        ? base_url('assets/uploads/profile_pics/' . $student['profile_pic'])
                        : 'https://ui-avatars.com/api/?name=' . urlencode($student['full_name']) . '&size=200&background=3b5bfc&color=fff'
                    ?>" class="profile-img-lg" alt="">
                    <div class="online-dot"></div>
                </div>
                <div style="flex:1">
                    <div class="profile-name"><?= esc($student['full_name']) ?></div>
                    <div class="profile-id-badge"><?= esc($student['id_number']) ?></div>
                    <div class="profile-meta">
                        <div class="meta-chip"><i class="fas fa-graduation-cap"></i><?= esc($student['course']) ?></div>
                        <div class="meta-chip"><i class="fas fa-layer-group"></i>Year <?= esc($student['year_level_id']) ?></div>
                        <div class="meta-chip"><i class="fas fa-tag"></i>OJT Student</div>
                    </div>
                </div>
                <div class="profile-actions">
                    <button class="btn-action-sm" onclick="window.print()">
                        <i class="fas fa-print"></i> Print
                    </button>
                    <a href="<?= base_url('admin/check_attendance?search=' . $student['id_number']) ?>" class="btn-action-sm">
                        <i class="fas fa-history"></i> History
                    </a>
                </div>
            </div>

            <!-- ATTENDANCE CONTROL -->
            <div class="attendance-box">
                <div class="att-section-label">
                    <i class="fas fa-fingerprint"></i> Attendance Control
                </div>

                <?php if ($current_event_id == 0): ?>
                    <div class="no-event-msg">
                        <i class="fas fa-exclamation-triangle"></i>
                        No active event found. Please create an event from the dashboard first.
                    </div>
                <?php else: ?>
                    <div class="event-tag">
                        <i class="fas fa-calendar-check" style="color:var(--primary)"></i>
                        <?= esc($event_name) ?>
                    </div>
                    <div>
                        <?php if (!$attendance): ?>
                            <a href="<?= base_url('admin/toggle_attendance/' . $student['id_number'] . '/' . $current_event_id) ?>" class="btn-timein">
                                <i class="fas fa-sign-in-alt"></i> TIME IN
                            </a>
                        <?php elseif (empty($attendance['time_out'])): ?>
                            <div class="timein-badge">
                                <i class="fas fa-clock"></i> Timed In at <?= date('h:i A', strtotime($attendance['time_in'])) ?>
                            </div>
                            <br>
                            <a href="<?= base_url('admin/toggle_attendance/' . $student['id_number'] . '/' . $current_event_id) ?>" class="btn-timeout">
                                <i class="fas fa-sign-out-alt"></i> TIME OUT
                            </a>
                        <?php else: ?>
                            <div class="status-done">
                                <i class="fas fa-check-double" style="color:var(--success)"></i>
                                Attendance Record Completed
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- INFO GRID -->
            <div class="info-grid">
                <div>
                    <div class="info-label"><i class="fas fa-id-card"></i> Student ID</div>
                    <div class="info-value"><?= esc($student['id_number']) ?></div>
                </div>
                <div>
                    <div class="info-label"><i class="fas fa-graduation-cap"></i> Course</div>
                    <div class="info-value"><?= esc($student['course']) ?></div>
                </div>
                <div>
                    <div class="info-label"><i class="fas fa-layer-group"></i> Year Level</div>
                    <div class="info-value">Year <?= esc($student['year_level_id']) ?></div>
                </div>
                <div>
                    <div class="info-label"><i class="fas fa-envelope"></i> Email Address</div>
                    <div class="info-value <?= empty($student['email']) ? 'empty' : '' ?>">
                        <?= esc($student['email'] ?? 'Not provided') ?>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="card-footer-bar">
                <button class="btn-action-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Info
                </button>
                <a href="<?= base_url('admin/check_attendance?search=' . $student['id_number']) ?>" class="btn-action-sm">
                    <i class="fas fa-history"></i> View Attendance History
                </a>
            </div>

        </div>
    </div>

</div><!-- /main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>