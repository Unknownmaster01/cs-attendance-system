<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Attendance System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* ── NEW 3-COLUMN DASHBOARD GRID ── */
        .dash-grid {
            display: grid;
            grid-template-columns: 300px 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        /* ── LEFT: Mini Calendar + quick stats ── */
        .dash-col-left {}

        /* Mini calendar override — tight and clean */
        .mini-cal-wrap {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }
        .mini-cal-header {
            padding: 14px 18px 10px;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 10px;
        }
        .mini-cal-icon {
            width: 32px; height: 32px; border-radius: 9px;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .mini-cal-title { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: var(--text-main); }
        .mini-cal-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .mini-cal-body  { padding: 12px 14px 16px; }

        /* FullCalendar mini overrides */
        #mini-calendar .fc-toolbar { margin-bottom: 8px !important; }
        #mini-calendar .fc-toolbar-title {
            font-family: 'Sora', sans-serif !important;
            font-size: 12px !important; font-weight: 700 !important;
        }
        #mini-calendar .fc-button {
            padding: 2px 7px !important; font-size: 10px !important;
        }
        #mini-calendar .fc-daygrid-day { min-height: 34px !important; }
        #mini-calendar .fc-daygrid-day-number {
            font-size: 10px !important; padding: 3px 5px !important;
        }
        #mini-calendar .fc-col-header-cell-cushion {
            font-size: 9px !important; padding: 4px 2px !important;
        }
        #mini-calendar .fc-event {
            font-size: 8px !important; padding: 1px 3px !important;
        }
        #mini-calendar .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            width: 20px; height: 20px; font-size: 10px !important;
        }

        /* Quick info cards under mini calendar */
        .quick-info-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            padding: 16px 18px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }
        .quick-info-title {
            font-family: 'Sora', sans-serif;
            font-size: 12px; font-weight: 700;
            color: var(--text-main); margin-bottom: 12px;
            display: flex; align-items: center; gap: 7px;
        }
        .quick-info-title i { color: var(--primary); font-size: 11px; }
        .quick-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 0; border-bottom: 1px solid #f0f3f9; font-size: 12.5px;
        }
        .quick-row:last-child { border-bottom: none; padding-bottom: 0; }
        .quick-row-label { color: var(--text-muted); font-weight: 500; display: flex; align-items: center; gap: 7px; }
        .quick-row-label i { width: 14px; text-align: center; font-size: 11px; color: var(--primary); }
        .quick-row-val { font-weight: 700; color: var(--text-main); font-size: 13px; }

        /* ── CENTRE: Event list ── */
        .dash-col-mid {}

        .event-list-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }
        .event-list-header {
            padding: 15px 20px;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .event-list-title {
            font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text-main); display: flex; align-items: center; gap: 8px;
        }
        .event-list-title i { color: var(--primary); }
        .event-count-chip {
            background: var(--primary-light); color: var(--primary);
            font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
        }

        .event-row {
            display: flex; align-items: center; gap: 14px;
            padding: 13px 20px;
            border-bottom: 1px solid #f0f3f9;
            transition: background var(--fast);
        }
        .event-row:last-child { border-bottom: none; }
        .event-row:hover { background: #f6f8ff; }

        .event-color-bar {
            width: 4px; height: 38px; border-radius: 4px; flex-shrink: 0;
        }
        .event-row-icon {
            width: 36px; height: 36px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 14px;
        }
        .event-row-info { flex: 1; min-width: 0; }
        .event-row-name {
            font-size: 13px; font-weight: 600; color: var(--text-main);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .event-row-date { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }
        .event-badge {
            font-size: 10px; font-weight: 700; padding: 3px 9px;
            border-radius: 20px; white-space: nowrap; flex-shrink: 0;
        }
        .badge-today  { background: var(--primary-light); color: var(--primary); }
        .badge-soon   { background: var(--warning-bg);    color: var(--warning-dark); }
        .badge-active { background: var(--success-bg);    color: var(--success-dark); }
        .badge-past   { background: #f1f5f9;              color: var(--text-muted); }

        .event-empty {
            padding: 40px 20px; text-align: center; color: var(--text-muted);
        }
        .event-empty i { font-size: 28px; opacity: .15; display: block; margin-bottom: 8px; }
        .event-empty p { font-size: 13px; }

        /* Announcement feed */
        .ann-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .ann-header {
            padding: 15px 20px;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .ann-title {
            font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700;
            color: var(--text-main); display: flex; align-items: center; gap: 8px;
        }
        .ann-title i { color: var(--warning); }

        /* ── RIGHT: Forms ── */
        .dash-col-right {}

        .form-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 16px;
        }
        .form-card-header {
            padding: 14px 18px;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 10px;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .form-card-icon {
            width: 32px; height: 32px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .fci-blue   { background: var(--primary-light); color: var(--primary); }
        .fci-orange { background: var(--warning-bg); color: var(--warning); }
        .form-card-title { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: var(--text-main); }
        .form-card-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .form-card-body  { padding: 16px 18px; }

        /* Search result */
        .result-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 18px 20px;
            box-shadow: var(--shadow-sm); margin-bottom: 20px;
            display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
        }
        .result-avatar { width: 52px; height: 52px; border-radius: var(--r-md); object-fit: cover; border: 2px solid var(--primary); flex-shrink: 0; }
        .result-info { flex: 1; min-width: 0; }
        .result-name { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 700; color: var(--text-main); }
        .result-id-badge { display: inline-block; font-family: monospace; font-size: 11.5px; font-weight: 700; background: var(--primary-light); color: var(--primary); padding: 2px 8px; border-radius: 5px; margin-top: 3px; }
        .result-meta { display: flex; gap: 12px; margin-top: 6px; flex-wrap: wrap; }
        .result-meta span { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 5px; }
        .result-meta i { color: var(--primary); font-size: 11px; }
        .result-divider { width: 1px; height: 60px; background: var(--border); flex-shrink: 0; }
        .result-action { display: flex; flex-direction: column; gap: 8px; align-items: flex-start; }

        /* Attendance status labels */
        .att-status-label { font-size: 11.5px; font-weight: 600; display: flex; align-items: center; gap: 6px; margin-bottom: 6px; }
        .att-status-label.pending { color: var(--text-muted); }
        .att-status-label.active  { color: var(--success); }
        .pulse-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--success); display: inline-block; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.3)} }

        .btn-timein  { display: inline-flex; align-items: center; gap: 7px; background: var(--success); color: #fff; border: none; border-radius: var(--r-md); padding: 9px 18px; font-size: 12.5px; font-weight: 700; text-decoration: none; font-family: 'DM Sans', sans-serif; transition: filter var(--fast); }
        .btn-timein:hover { filter: brightness(1.08); color: #fff; }
        .btn-timeout { display: inline-flex; align-items: center; gap: 7px; background: var(--warning); color: #fff; border: none; border-radius: var(--r-md); padding: 9px 18px; font-size: 12.5px; font-weight: 700; text-decoration: none; font-family: 'DM Sans', sans-serif; transition: filter var(--fast); }
        .btn-timeout:hover { filter: brightness(1.08); color: #fff; }
        .status-done { display: inline-flex; align-items: center; gap: 7px; background: var(--success-bg); color: var(--success-dark); border-radius: var(--r-md); padding: 9px 16px; font-size: 12.5px; font-weight: 600; }

        @media (max-width: 1280px) {
            .dash-grid { grid-template-columns: 260px 1fr 290px; }
        }
        @media (max-width: 1024px) {
            .dash-grid { grid-template-columns: 1fr 1fr; }
            .dash-col-left { grid-column: 1 / -1; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
            .mini-cal-wrap { margin-bottom: 0; }
            .quick-info-card { margin-bottom: 0; }
        }
        @media (max-width: 640px) {
            .dash-grid { grid-template-columns: 1fr; }
            .dash-col-left { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════
     TOP NAV
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
            <a class="topnav-link active" href="<?= base_url('admin') ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="topnav-link" href="<?= base_url('admin/students') ?>">
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
            <form action="<?= base_url('admin') ?>" method="GET" class="topnav-search-form">
                <div class="topnav-search">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" class="topnav-search-input"
                           placeholder="Search student ID..."
                           value="<?= esc($search_query ?? '') ?>">
                </div>
            </form>
            <div class="topnav-admin">
                <div class="topnav-admin-avatar"><i class="fas fa-user-shield"></i></div>
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

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Dashboard</h1>
            <p class="page-sub">Welcome back — here's what's happening today.</p>
        </div>
        <div class="page-header-right">
            <span class="header-date">
                <i class="fas fa-calendar-day"></i>
                <?= date('F d, Y') ?>
            </span>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('msg')): ?>
    <div class="flash-alert flash-success">
        <i class="fas fa-check-circle"></i><?= session()->getFlashdata('msg') ?>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-alert flash-danger">
        <i class="fas fa-exclamation-triangle"></i><?= session()->getFlashdata('error') ?>
    </div>
    <?php endif; ?>

    <!-- ── STAT CARDS ── -->
    <div class="stats-row">
        <a href="<?= base_url('admin/events') ?>" class="stat-card blue" style="text-decoration:none;">
            <div class="stat-card-icon blue"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Events This Month</div>
                <div class="stat-val"><?= $event_count ?? 0 ?></div>
                <div class="stat-sub"><i class="fas fa-arrow-up"></i> Active</div>
            </div>
            <div class="stat-card-ring blue"></div>
        </a>
        <a href="<?= base_url('admin/students') ?>" class="stat-card green" style="text-decoration:none;">
            <div class="stat-card-icon green"><i class="fas fa-user-graduate"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Students Enrolled</div>
                <div class="stat-val"><?= $student_count ?? 0 ?></div>
                <div class="stat-sub"><i class="fas fa-arrow-up"></i> Registered</div>
            </div>
            <div class="stat-card-ring green"></div>
        </a>
        <a href="<?= base_url('admin/announcements') ?>" class="stat-card orange" style="text-decoration:none;">
            <div class="stat-card-icon orange"><i class="fas fa-bullhorn"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Announcements</div>
                <div class="stat-val"><?= $announcement_count ?? 0 ?></div>
                <div class="stat-sub"><i class="fas fa-check"></i> Posted</div>
            </div>
            <div class="stat-card-ring orange"></div>
        </a>
    </div>

    <!-- ── STUDENT SEARCH RESULT ── -->
    <?php if (!empty($search_query)): ?>
    <div style="margin-bottom: 20px;">
        <?php if ($student): ?>
        <div class="result-card">
            <img src="<?= !empty($student['profile_pic'])
                ? base_url('uploads/profiles/' . $student['profile_pic'])
                : 'https://ui-avatars.com/api/?name=' . urlencode($student['full_name']) . '&background=3b5bfc&color=fff&size=70'
            ?>" class="result-avatar" alt="">
            <div class="result-info">
                <div class="result-name"><?= esc($student['full_name']) ?></div>
                <div class="result-id-badge"># <?= esc($student['id_number']) ?></div>
                <div class="result-meta">
                    <span><i class="fas fa-graduation-cap"></i><?= esc($student['course']) ?></span>
                    <span><i class="fas fa-layer-group"></i>Year <?= esc($student['year_level_id']) ?></span>
                </div>
            </div>
            <div class="result-divider"></div>
            <div class="result-action">
                <?php if (empty($student['time_in'])): ?>
                    <div class="att-status-label pending"><i class="fas fa-clock"></i> Not Yet Checked In</div>
                    <a href="<?= base_url('admin/toggle_attendance/' . $student['id_number'] . '/' . $current_event_id) ?>" class="btn-timein">
                        <i class="fas fa-sign-in-alt"></i> Confirm Time-In
                    </a>
                <?php elseif (empty($student['time_out'])): ?>
                    <div class="att-status-label active"><span class="pulse-dot"></span> Currently In-Attendance</div>
                    <a href="<?= base_url('admin/toggle_attendance/' . $student['id_number'] . '/' . $current_event_id) ?>" class="btn-timeout">
                        <i class="fas fa-sign-out-alt"></i> Confirm Time-Out
                    </a>
                <?php else: ?>
                    <div class="status-done"><i class="fas fa-check-circle"></i> Attendance Recorded</div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
        <div class="flash-alert flash-danger">
            <i class="fas fa-user-slash"></i>
            No student found with ID: <strong><?= esc($search_query) ?></strong>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════
         NEW 3-COLUMN GRID
    ══════════════════════════════════════ -->
    <div class="dash-grid">

        <!-- ── LEFT: Mini calendar + quick stats ── -->
        <div class="dash-col-left">

            <!-- Mini Calendar -->
            <div class="mini-cal-wrap">
                <div class="mini-cal-header">
                    <div class="mini-cal-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <div class="mini-cal-title">Event Schedule</div>
                        <div class="mini-cal-sub">Click event to edit</div>
                    </div>
                </div>
                <div class="mini-cal-body">
                    <div id="mini-calendar"></div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-info-card">
                <div class="quick-info-title"><i class="fas fa-bolt"></i> Quick Stats</div>
                <div class="quick-row">
                    <span class="quick-row-label"><i class="fas fa-calendar-check"></i> This Month Events</span>
                    <span class="quick-row-val"><?= $event_count ?? 0 ?></span>
                </div>
                <div class="quick-row">
                    <span class="quick-row-label"><i class="fas fa-users"></i> Total Students</span>
                    <span class="quick-row-val"><?= $student_count ?? 0 ?></span>
                </div>
                <div class="quick-row">
                    <span class="quick-row-label"><i class="fas fa-bullhorn"></i> Announcements</span>
                    <span class="quick-row-val"><?= $announcement_count ?? 0 ?></span>
                </div>
                <div class="quick-row">
                    <span class="quick-row-label"><i class="fas fa-calendar-day"></i> Today</span>
                    <span class="quick-row-val" style="font-size:11px;font-weight:600;color:var(--text-muted)"><?= date('M j') ?></span>
                </div>
            </div>

        </div>

        <!-- ── CENTRE: Event list + announcements ── -->
        <div class="dash-col-mid">

            <!-- Events List -->
            <div class="event-list-card">
                <div class="event-list-header">
                    <div class="event-list-title">
                        <i class="fas fa-list-check"></i> All Events
                    </div>
                    <span class="event-count-chip"><?= $event_count ?? 0 ?> this month</span>
                </div>

                <?php if (!empty($upcoming_events)): ?>
                    <?php foreach ($upcoming_events as $ev):
                        $evTime = strtotime($ev['start_event']);
                        $now    = time();
                        $evDate = date('Y-m-d', $evTime);
                        $today  = date('Y-m-d');
                        if ($evDate === $today)    { $badgeClass = 'badge-today'; $badgeLabel = 'Today'; }
                        elseif ($evTime > $now)    { $badgeClass = 'badge-soon';  $badgeLabel = 'Soon'; }
                        elseif ($evTime < $now)    { $badgeClass = 'badge-past';  $badgeLabel = 'Past'; }
                        else                       { $badgeClass = 'badge-active';$badgeLabel = 'Active'; }
                        $color = $ev['color'] ?? '#3b5bfc';
                    ?>
                    <div class="event-row">
                        <div class="event-color-bar" style="background:<?= esc($color) ?>"></div>
                        <div class="event-row-icon" style="background:<?= esc($color) ?>18;">
                            <i class="fas fa-calendar-day" style="color:<?= esc($color) ?>"></i>
                        </div>
                        <div class="event-row-info">
                            <div class="event-row-name"><?= esc($ev['title']) ?></div>
                            <div class="event-row-date">
                                <i class="fas fa-clock" style="font-size:10px;margin-right:3px;color:var(--text-light)"></i>
                                <?= date('M j, Y · g:i A', $evTime) ?>
                            </div>
                        </div>
                        <span class="event-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="event-empty">
                        <i class="fas fa-calendar-times"></i>
                        <p>No events yet. Add one from the right panel.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Announcement post form (moved here for balance) -->
            <div class="ann-card">
                <div class="ann-header">
                    <div class="ann-title"><i class="fas fa-bullhorn"></i> Post Announcement</div>
                </div>
                <div style="padding: 16px 20px;">
                    <form action="<?= base_url('admin/save_announcement') ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="3"
                                      placeholder="What's happening? Use @everyone..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Attach Photo <span style="color:var(--text-light);font-weight:400">(optional)</span></label>
                            <div class="upload-drop-zone">
                                <input type="file" name="announcement_pic" accept="image/*"
                                       class="upload-file-input" id="announcementPic">
                                <label for="announcementPic" class="upload-drop-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span><strong>Browse file</strong> or drag &amp; drop</span>
                                    <span class="upload-hint">PNG, JPG, GIF up to 5MB</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn-warning-ojt">
                            <i class="fas fa-paper-plane"></i> Post Announcement
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- ── RIGHT: Add event form ── -->
        <div class="dash-col-right">

            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon fci-blue"><i class="fas fa-plus-circle"></i></div>
                    <div>
                        <div class="form-card-title">Add New Event</div>
                        <div class="form-card-sub">Schedule an Event</div>
                    </div>
                </div>
                <div class="form-card-body">
                    <form action="<?= base_url('admin/save_event') ?>" method="POST">
                        <div class="form-group">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control"
                                   placeholder="e.g. Event Orientation" required>
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Time</label>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Notes</label>
                            <textarea name="description" class="form-control" rows="2"
                                      placeholder="Additional details..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Label Color</label>
                            <div class="color-swatch-row">
                                <label class="color-swatch-item selected">
                                    <input type="radio" name="color" value="#3b5bfc" checked>
                                    <span class="swatch" style="background:#3b5bfc"></span>
                                </label>
                                <label class="color-swatch-item">
                                    <input type="radio" name="color" value="#12b76a">
                                    <span class="swatch" style="background:#12b76a"></span>
                                </label>
                                <label class="color-swatch-item">
                                    <input type="radio" name="color" value="#f79009">
                                    <span class="swatch" style="background:#f79009"></span>
                                </label>
                                <label class="color-swatch-item">
                                    <input type="radio" name="color" value="#f04438">
                                    <span class="swatch" style="background:#f04438"></span>
                                </label>
                                <label class="color-swatch-item">
                                    <input type="radio" name="color" value="#a855f7">
                                    <span class="swatch" style="background:#a855f7"></span>
                                </label>
                                <label class="color-swatch-item">
                                    <input type="radio" name="color" value="#ec4899">
                                    <span class="swatch" style="background:#ec4899"></span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn-primary-ojt">
                            <i class="fas fa-calendar-plus"></i> Save Event
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Event Box -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon fci-blue" style="background:var(--success-bg);color:var(--success)">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>
                    <div>
                        <div class="form-card-title">Active Event</div>
                        <div class="form-card-sub">Latest scheduled event</div>
                    </div>
                </div>
                <div class="form-card-body">
                    <div style="display:flex;align-items:center;gap:10px;background:var(--success-bg);border-radius:var(--r-md);padding:12px 14px;">
                        <i class="fas fa-calendar-check" style="color:var(--success);font-size:16px;flex-shrink:0"></i>
                        <div>
                            <div style="font-size:13px;font-weight:700;color:var(--text-main)"><?= esc($event_name) ?></div>
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Used for attendance check-ins</div>
                        </div>
                    </div>
                    <a href="<?= base_url('admin/check_attendance') ?>"
                       style="display:flex;align-items:center;justify-content:center;gap:7px;margin-top:12px;padding:10px;background:var(--primary-light);color:var(--primary);border-radius:var(--r-md);font-size:12.5px;font-weight:600;text-decoration:none;transition:background var(--fast);"
                       onmouseover="this.style.background='var(--primary)';this.style.color='#fff'"
                       onmouseout="this.style.background='var(--primary-light)';this.style.color='var(--primary)'">
                        <i class="fas fa-clipboard-list"></i> View Attendance Log
                    </a>
                </div>
            </div>

        </div>

    </div><!-- /dash-grid -->

</div><!-- /main-content -->

<!-- ══════════════════════════════════════
     EDIT EVENT MODAL
══════════════════════════════════════ -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editEventForm" method="POST">
                <div class="modal-header">
                    <div class="modal-header-icon"><i class="fas fa-calendar-pen"></i></div>
                    <h5 class="modal-title">Edit Attendance Event</h5>
                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time</label>
                            <input type="time" name="time" id="edit_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <input type="color" name="color" id="edit_color" class="form-control form-control-color">
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 16px 20px;">
                    
                    <a href="#" id="btnDeleteEvent" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.');" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px;">
                        <i class="fas fa-trash"></i> Delete Event
                    </a>
                    
                    <div style="display: flex; gap: 10px; align-items: center;">
                        
                        <button type="submit" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; padding: 8px 16px; border-radius: 8px; background: #3b5bfc; border: none;">
                            <i class="fas fa-check"></i> Update Event
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Mini FullCalendar ── */
    var miniEl = document.getElementById('mini-calendar');
    var miniCal = new FullCalendar.Calendar(miniEl, {
        initialView: 'dayGridMonth',
        contentHeight: 'auto',
        headerToolbar: { left: 'prev', center: 'title', right: 'next' },
        events: '<?= base_url("api/get-events") ?>',
        eventClick: function (info) {
            var event    = info.event;
            var startStr = event.startStr.split('T');
            document.getElementById('edit_title').value       = event.title;
            document.getElementById('edit_date').value        = startStr[0];
            document.getElementById('edit_time').value        = startStr[1] ? startStr[1].substring(0, 5) : '';
            document.getElementById('edit_description').value = event.extendedProps.description || '';
            document.getElementById('edit_color').value       = event.backgroundColor;
            
            // Set update form action
            document.getElementById('editEventForm').action   = '<?= base_url("admin/update_event") ?>/' + event.id;
            
            // NEW: Set delete button link
            document.getElementById('btnDeleteEvent').href    = '<?= base_url("admin/delete_event") ?>/' + event.id;
            
            new bootstrap.Modal(document.getElementById('editEventModal')).show();
        }
    });
    miniCal.render();

    /* ── File upload label ── */
    var fileInput = document.getElementById('announcementPic');
    if (fileInput) {
        fileInput.addEventListener('change', function () {
            var label = this.closest('.upload-drop-zone').querySelector('strong');
            if (this.files[0]) label.textContent = this.files[0].name;
        });
    }

    /* ── Color swatches ── */
    document.querySelectorAll('.color-swatch-item input').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.color-swatch-item').forEach(function (el) {
                el.classList.remove('selected');
            });
            this.closest('.color-swatch-item').classList.add('selected');
        });
    });

});
</script>
</body>
</html>