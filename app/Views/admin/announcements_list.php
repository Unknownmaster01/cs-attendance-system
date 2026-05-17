<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | CS Attendance Monitoring System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* ── Page background ── */
        .main-content {
            background:
                radial-gradient(ellipse 70% 50% at 75% 5%, rgba(59,91,252,0.07) 0%, transparent 60%),
                radial-gradient(ellipse 45% 35% at 15% 85%, rgba(247,185,40,0.06) 0%, transparent 55%),
                var(--bg);
        }

        /* ── Hero banner replaces plain page-header ── */
        .ann-hero {
            background: linear-gradient(118deg, #1a2f7a 0%, #3b5bfc 52%, #7b9bff 100%);
            border-radius: var(--r-xl);
            padding: 16px 22px;
            margin-bottom: 22px;
            display: flex; align-items: center; justify-content: space-between; gap: 20px;
            position: relative; overflow: hidden;
            box-shadow: 0 8px 32px rgba(59,91,252,0.25);
        }
        .ann-hero::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background:
                radial-gradient(circle 180px at 90% 50%, rgba(255,255,255,0.07) 0%, transparent 70%),
                url("data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.035'%3E%3Ccircle cx='26' cy='26' r='4'/%3E%3C/g%3E%3C/svg%3E");
        }
        .ann-hero-left { position: relative; }
        .ann-hero-eyebrow { font-size: 10px; font-weight: 700; letter-spacing: 1.8px; text-transform: uppercase; color: rgba(255,255,255,0.6); margin-bottom: 4px; }
        .ann-hero-title  { font-size: 18px; font-weight: 800; color: #fff; font-family: 'Sora', sans-serif; line-height: 1.15; }
        .ann-hero-sub    { font-size: 12px; color: rgba(255,255,255,0.68); margin-top: 3px; }
        .ann-hero-right  { display: flex; align-items: center; gap: 12px; position: relative; }
        .ann-hero-icon {
            width: 60px; height: 60px; border-radius: 16px; flex-shrink: 0;
            background: rgba(255,255,255,0.13); border: 1.5px solid rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: #fff;
        }
        .ann-hero-back {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.13); border: 1.5px solid rgba(255,255,255,0.22);
            color: #fff; border-radius: 10px; padding: 8px 16px;
            font-size: 12.5px; font-weight: 600; text-decoration: none;
            transition: background 0.15s;
        }
        .ann-hero-back:hover { background: rgba(255,255,255,0.22); color: #fff; }

        /* ── Stats strip ── */
        .ann-stats {
            display: flex; gap: 14px; margin-bottom: 22px;
            max-width: 860px; margin-left: auto; margin-right: auto;
        }
        .ann-stat-chip {
            flex: 1; background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 16px 18px;
            display: flex; align-items: center; gap: 13px;
            box-shadow: var(--shadow-sm); position: relative; overflow: hidden;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .ann-stat-chip:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,0.09); }
        .ann-stat-chip::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
        }
        .ann-stat-chip:nth-child(1)::after { background: linear-gradient(90deg,#f7b928,#f79009); }
        .ann-stat-chip:nth-child(2)::after { background: linear-gradient(90deg,#3b5bfc,#6d8dff); }
        .ann-stat-chip:nth-child(3)::after { background: linear-gradient(90deg,#12b76a,#34d399); }
        .ann-stat-icon {
            width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 15px;
        }
        .ann-stat-val   { font-size: 22px; font-weight: 800; color: var(--text-main); line-height: 1; }
        .ann-stat-label { font-size: 11px; color: var(--text-muted); margin-top: 2px; font-weight: 500; }

        /* ── Single-column feed ── */
        .ann-layout { display: block; max-width: 860px; margin: 0 auto; }

        /* ── Composer ── */
        .ann-composer {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 0;
            box-shadow: var(--shadow-sm); margin-bottom: 20px; overflow: hidden;
        }
        .ann-composer-header {
            padding: 10px 20px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 10px;
            background: linear-gradient(110deg, #fffbeb 0%, #fef3c7 60%, #fff8e1 100%);
        }
        .ann-composer-header-icon {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 14px;
            background: linear-gradient(135deg,#f7b928,#f59e0b); color: #fff;
            box-shadow: 0 2px 8px rgba(247,185,40,0.35);
        }
        .ann-composer-header-title { font-size: 13.5px; font-weight: 700; color: var(--text-main); }
        .ann-composer-header-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .ann-composer-inner { padding: 16px 20px; }
        .ann-composer-top { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .ann-avatar-circle {
            width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg,#3b5bfc,#6d8dff); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 17px;
            box-shadow: 0 2px 10px rgba(59,91,252,0.28);
        }
        .ann-composer-trigger {
            flex: 1; background: var(--bg); border: 1.5px solid var(--border);
            border-radius: 24px; padding: 11px 20px;
            font-size: 14px; color: var(--text-muted);
            cursor: pointer; transition: background 0.15s, border-color 0.15s, box-shadow 0.15s;
        }
        .ann-composer-trigger:hover { background: #eef2ff; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(59,91,252,0.08); }
        .ann-composer-divider { height: 1px; background: var(--border); margin: 0 -20px 14px; }
        .ann-composer-actions { display: flex; gap: 4px; }
        .ann-composer-btn {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 9px; border-radius: var(--r-md); border: none; background: transparent;
            font-size: 13px; font-weight: 600; color: var(--text-muted);
            cursor: pointer; transition: background 0.15s, color 0.15s; font-family: inherit;
        }
        .ann-composer-btn:hover { background: var(--bg); color: var(--text-main); }
        .ann-composer-btn.c-photo i { color: #45bd62; }
        .ann-composer-btn.c-ann   i { color: #f7b928; }
        .ann-composer-btn.c-tag   i { color: var(--primary); }

        /* ── Post card ── */
        .ann-post {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-left: 4px solid #3b5bfc;
            border-radius: var(--r-xl); box-shadow: var(--shadow-sm);
            margin-bottom: 16px; overflow: hidden;
            animation: fadeUp 0.35s ease both;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .ann-post:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.1); transform: translateY(-2px); }
        .ann-post:nth-child(even) { border-left-color: #f7b928; }
        .ann-post:nth-child(3n)   { border-left-color: #12b76a; }
        .ann-post:nth-child(1) { animation-delay: 0.05s; }
        .ann-post:nth-child(2) { animation-delay: 0.10s; }
        .ann-post:nth-child(3) { animation-delay: 0.15s; }
        .ann-post:nth-child(4) { animation-delay: 0.20s; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }

        .ann-post-header { padding: 16px 20px 10px; display: flex; align-items: flex-start; gap: 12px; }
        .ann-post-avatar {
            width: 46px; height: 46px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg,#3b5bfc,#6d8dff); color: #fff;
            display: flex; align-items: center; justify-content: center; font-size: 18px;
            box-shadow: 0 2px 8px rgba(59,91,252,0.22);
        }
        .ann-post-author { font-size: 14.5px; font-weight: 700; color: var(--text-main); }
        .ann-post-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600; color: var(--primary);
            background: var(--primary-light); padding: 2px 8px; border-radius: 20px; margin-left: 6px;
        }
        .ann-post-time { font-size: 12px; color: var(--text-muted); margin-top: 3px; display: flex; align-items: center; gap: 5px; }
        .ann-post-menu { margin-left: auto; color: var(--text-muted); font-size: 20px; cursor: pointer; padding: 2px 6px; border-radius: 6px; transition: background 0.15s; }
        .ann-post-menu:hover { background: var(--bg); }
        .ann-post-body { padding: 2px 20px 14px; }
        .ann-post-text { font-size: 15px; color: var(--text-main); line-height: 1.7; word-break: break-word; }
        .ann-post-text.large { font-size: 21px; font-weight: 600; line-height: 1.45; }
        .ann-post-img { width: 100%; display: block; object-fit: cover; max-height: 500px; cursor: zoom-in; transition: opacity 0.15s; }
        .ann-post-img:hover { opacity: 0.93; }
        .ann-post-footer { padding: 4px 20px 14px; display: flex; align-items: center; gap: 2px; border-top: 1px solid var(--border); margin-top: 10px; }
        .ann-react-btn {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 7px;
            padding: 9px; border-radius: var(--r-md); border: none; background: transparent;
            font-size: 13px; font-weight: 600; color: var(--text-muted);
            cursor: pointer; transition: background 0.15s, color 0.15s; font-family: inherit;
        }
        .ann-react-btn:hover { background: var(--bg); color: var(--text-main); }
        .ann-react-btn i { font-size: 16px; }
        .ann-react-btn.liked { color: var(--primary); }

        /* ── Empty ── */
        .ann-empty { padding: 60px 20px; text-align: center; color: var(--text-muted); }
        .ann-empty i { font-size: 36px; opacity:.1; display: block; margin-bottom: 12px; }
        .ann-empty p { font-size: 13.5px; }

        /* ── Modal ── */
        .ann-modal-overlay { display:none; position:fixed; inset:0; z-index:1000; background:rgba(0,0,0,0.52); align-items:center; justify-content:center; padding:16px; backdrop-filter:blur(3px); }
        .ann-modal-overlay.open { display:flex; }
        .ann-modal { background:var(--card-bg); border-radius:var(--r-xl); width:100%; max-width:560px; box-shadow:0 24px 64px rgba(0,0,0,0.24); animation:popIn 0.22s ease; overflow:hidden; }
        @keyframes popIn { from{transform:scale(0.95) translateY(8px);opacity:0} to{transform:scale(1) translateY(0);opacity:1} }
        .ann-modal-header { padding:14px 20px; border-bottom:1.5px solid var(--border); display:flex; align-items:center; gap:10px; background:linear-gradient(110deg,#fffbeb 0%,#fef3c7 60%,#fff8e1 100%); }
        .ann-modal-header-icon { width:34px; height:34px; border-radius:9px; flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:14px; background:linear-gradient(135deg,#f7b928,#f59e0b); color:#fff; box-shadow:0 2px 8px rgba(247,185,40,0.35); }
        .ann-modal-title  { font-size:14px; font-weight:700; color:var(--text-main); flex:1; }
        .ann-modal-title-sub { font-size:11px; color:var(--text-muted); margin-top:1px; }
        .ann-modal-close  { width:32px; height:32px; border-radius:50%; border:none; background:rgba(0,0,0,0.05); color:var(--text-muted); font-size:14px; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:background 0.15s; flex-shrink:0; }
        .ann-modal-close:hover { background:var(--border); }
        .ann-modal-body   { padding:18px 20px; }
        .ann-modal-who    { display:flex; align-items:center; gap:12px; margin-bottom:14px; }
        .ann-modal-textarea { width:100%; border:none; outline:none; resize:none; font-size:16px; font-family:inherit; color:var(--text-main); background:transparent; min-height:110px; line-height:1.65; }
        .ann-modal-textarea::placeholder { color:var(--text-muted); }
        .ann-modal-img-preview { display:none; border-radius:var(--r-md); overflow:hidden; border:1.5px solid var(--border); margin-top:12px; }
        .ann-modal-img-preview img { width:100%; max-height:200px; object-fit:cover; display:block; }
        .ann-modal-footer { padding:12px 20px; border-top:1.5px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:10px; }
        .ann-modal-addons { display:flex; align-items:center; gap:6px; }
        .ann-modal-addon-label { font-size:12.5px; font-weight:600; color:var(--text-muted); margin-right:4px; }
        .ann-modal-addon-btn { width:34px; height:34px; border-radius:50%; border:none; background:var(--bg); cursor:pointer; font-size:16px; display:flex; align-items:center; justify-content:center; transition:background 0.15s; }
        .ann-modal-addon-btn:hover { background:var(--border); }
        .ann-modal-submit { background:linear-gradient(135deg,#3b5bfc,#6d8dff); color:#fff; border:none; border-radius:8px; padding:9px 26px; font-size:14px; font-weight:700; cursor:pointer; font-family:inherit; transition:opacity 0.15s, box-shadow 0.15s; box-shadow:0 3px 12px rgba(59,91,252,0.3); }
        .ann-modal-submit:hover { opacity:0.88; box-shadow:0 5px 18px rgba(59,91,252,0.4); }
        .ann-modal-file { display:none; }

        /* ── Lightbox ── */
        #ann-lightbox { display:none; position:fixed; inset:0; z-index:9999; background:rgba(8,14,30,0.93); align-items:center; justify-content:center; cursor:zoom-out; }
        #ann-lightbox.open { display:flex; }
        #ann-lightbox img { max-width:92vw; max-height:90vh; border-radius:12px; object-fit:contain; }
        #ann-lb-close { position:fixed; top:18px; right:22px; width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.12); border:1.5px solid rgba(255,255,255,0.22); color:#fff; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
        #ann-lb-close:hover { background:rgba(255,255,255,0.24); }

        /* ── Flash alerts ── */
        .flash-alert { margin-bottom: 16px; }
    </style>
</head>
<body>

<nav class="topnav">
    <div class="topnav-inner">
        <a class="topnav-brand" href="<?= base_url('admin') ?>">
            <div class="brand-icon">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                </svg>
            </div>
            <div class="brand-text">
                <span class="brand-title">CS Attendance Monitoring System</span>
                <span class="brand-sub">Admin Portal</span>
            </div>
        </a>
        <div class="topnav-links">
            <a class="topnav-link" href="<?= base_url('admin') ?>"><i class="fas fa-home"></i> Dashboard</a>
            <a class="topnav-link" href="<?= base_url('admin/students') ?>"><i class="fas fa-users"></i> Students</a>
            <a class="topnav-link" href="<?= base_url('admin/check_attendance') ?>"><i class="fas fa-clipboard-check"></i> Attendance Log</a>
            <a class="topnav-link" href="<?= base_url('admin/events') ?>"><i class="fas fa-calendar-alt"></i> Events</a>
            <a class="topnav-link active" href="<?= base_url('admin/announcements') ?>"><i class="fas fa-bullhorn"></i> Announcements</a>
        </div>
        <div class="topnav-right">
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

<div class="main-content">

    <!-- Hero Banner -->
    <div class="ann-hero">
        <div class="ann-hero-left">
            <div class="ann-hero-eyebrow"><i class="fas fa-bullhorn" style="margin-right:6px;opacity:0.7"></i>Admin · Broadcast Center</div>
            <div class="ann-hero-title">Announcements</div>
            <div class="ann-hero-sub">Post updates and notify all students instantly.</div>
        </div>
        <div class="page-header-right">
            <a href="<?= base_url('admin') ?>" class="btn-logout-admin" title="Back to Dashboard" style="text-decoration:none;padding:8px 16px;font-size:12.5px;display:inline-flex;align-items:center;gap:7px;border-radius:var(--r-md);">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('msg')): ?>
    <div class="flash-alert flash-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-alert flash-danger"><i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php
        $allAnn   = $announcements ?? [];
        $total    = count($allAnn);
        $withImg  = count(array_filter($allAnn, fn($a) => !empty($a['image_path'])));
        $today    = date('Y-m-d');
        $todayAnn = count(array_filter($allAnn, fn($a) => date('Y-m-d', strtotime($a['created_at'])) === $today));
    ?>

    <div class="ann-stats">
        <div class="ann-stat-chip">
            <div class="ann-stat-icon" style="background:var(--warning-bg);color:var(--warning)"><i class="fas fa-bullhorn"></i></div>
            <div><div class="ann-stat-val"><?= $total ?></div><div class="ann-stat-label">Total Posted</div></div>
        </div>
        <div class="ann-stat-chip">
            <div class="ann-stat-icon" style="background:var(--primary-light);color:var(--primary)"><i class="fas fa-calendar-day"></i></div>
            <div><div class="ann-stat-val"><?= $todayAnn ?></div><div class="ann-stat-label">Today</div></div>
        </div>
        <div class="ann-stat-chip">
            <div class="ann-stat-icon" style="background:var(--success-bg);color:var(--success)"><i class="fas fa-image"></i></div>
            <div><div class="ann-stat-val"><?= $withImg ?></div><div class="ann-stat-label">With Images</div></div>
        </div>
    </div>

    <div class="ann-layout">

        <!-- LEFT: Feed -->
        <div class="ann-feed">
            <div class="ann-composer">
                <div class="ann-composer-header">
                    <div class="ann-composer-header-icon"><i class="fas fa-paper-plane"></i></div>
                    <div>
                        <div class="ann-composer-header-title">Post Announcement</div>
                        <div class="ann-composer-header-sub">Notify all students instantly</div>
                    </div>
                </div>
                <div class="ann-composer-inner">
                    <div class="ann-composer-top">
                        <div class="ann-avatar-circle"><i class="fas fa-user-shield"></i></div>
                        <div class="ann-composer-trigger" onclick="openModal()">What's your announcement, Admin?</div>
                    </div>
                    <div class="ann-composer-divider"></div>
                    <div class="ann-composer-actions">
                        <button class="ann-composer-btn c-photo" onclick="openModal()"><i class="fas fa-image"></i> Photo</button>
                        <button class="ann-composer-btn c-ann"   onclick="openModal()"><i class="fas fa-bullhorn"></i> Announce</button>
                        <button class="ann-composer-btn c-tag"   onclick="openModal()"><i class="fas fa-tag"></i> Tag Students</button>
                    </div>
                </div>
            </div>

            <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $ann): ?>
                <?php $isShort = strlen($ann['message']) < 80 && empty($ann['image_path']); ?>
                <div class="ann-post">
                    <div class="ann-post-header">
                        <div class="ann-post-avatar"><i class="fas fa-user-shield"></i></div>
                        <div style="flex:1">
                            <div>
                                <span class="ann-post-author">Administrator</span>
                                <span class="ann-post-badge"><i class="fas fa-shield-alt" style="font-size:9px"></i> Admin</span>
                            </div>
                            <div class="ann-post-time">
                                <i class="fas fa-globe-asia"></i>
                                <?= date('F j, Y · g:i A', strtotime($ann['created_at'])) ?>
                            </div>
                        </div>
                        <div class="ann-post-menu">&#8943;</div>
                    </div>
                    <div class="ann-post-body">
                        <div class="ann-post-text <?= $isShort ? 'large' : '' ?>">
                            <?= nl2br(esc($ann['message'])) ?>
                        </div>
                    </div>
                    <?php if (!empty($ann['image_path'])): ?>
                    <img src="<?= base_url('assets/uploads/announcements/' . esc($ann['image_path'])) ?>"
                         class="ann-post-img" alt="Announcement image" onclick="openLightbox(this.src)">
                    <?php endif; ?>
                    <div class="ann-post-footer">
                        <button class="ann-react-btn" onclick="this.classList.toggle('liked')"><i class="fas fa-thumbs-up"></i> Like</button>
                        <button class="ann-react-btn"><i class="fas fa-comment"></i> Comment</button>
                        <button class="ann-react-btn"><i class="fas fa-share"></i> Share</button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="ann-post">
                    <div class="ann-empty">
                        <i class="fas fa-bullhorn"></i>
                        <p>No announcements posted yet.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="ann-modal-overlay" id="annModal" onclick="closeModal(event)">
    <div class="ann-modal">
        <div class="ann-modal-header">
            <div class="ann-modal-header-icon"><i class="fas fa-paper-plane"></i></div>
            <div style="flex:1">
                <div class="ann-modal-title">Create Announcement</div>
                <div class="ann-modal-title-sub">Notify all students instantly</div>
            </div>
            <button class="ann-modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="ann-modal-body">
            <form action="<?= base_url('admin/save_announcement') ?>" method="POST" enctype="multipart/form-data">
                <div class="ann-modal-who">
                    <div class="ann-avatar-circle"><i class="fas fa-user-shield"></i></div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:var(--text-main)">Administrator</div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px"><i class="fas fa-users" style="font-size:10px"></i> All Students</div>
                    </div>
                </div>
                <textarea name="message" class="ann-modal-textarea" placeholder="What's your announcement, Admin?" required></textarea>
                <div class="ann-modal-img-preview" id="modalPreviewWrap">
                    <img id="modalPreview" src="" alt="">
                </div>
                <input type="file" name="announcement_pic" accept="image/*" class="ann-modal-file" id="modalPic">
                <div class="ann-modal-footer">
                    <div class="ann-modal-addons">
                        <span class="ann-modal-addon-label">Add to post</span>
                        <button type="button" class="ann-modal-addon-btn" onclick="document.getElementById('modalPic').click()" title="Photo">
                            <i class="fas fa-image" style="color:#45bd62"></i>
                        </button>
                        <button type="button" class="ann-modal-addon-btn" title="Tag">
                            <i class="fas fa-user-tag" style="color:var(--primary)"></i>
                        </button>
                        <button type="button" class="ann-modal-addon-btn" title="Emoji">
                            <i class="fas fa-smile" style="color:#f7b928"></i>
                        </button>
                    </div>
                    <button type="submit" class="ann-modal-submit">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="ann-lightbox" onclick="closeLightbox()">
    <button id="ann-lb-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <img id="ann-lb-img" src="" alt="" onclick="event.stopPropagation()">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openModal() { document.getElementById('annModal').classList.add('open'); document.body.style.overflow = 'hidden'; }
    function closeModal(e) {
        if (!e || e.target === document.getElementById('annModal')) {
            document.getElementById('annModal').classList.remove('open');
            document.body.style.overflow = '';
        }
    }
    function openLightbox(src) {
        document.getElementById('ann-lb-img').src = src;
        document.getElementById('ann-lightbox').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        document.getElementById('ann-lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeModal(); closeLightbox(); } });

    document.getElementById('modalPic').addEventListener('change', function() {
        if (this.files[0]) {
            var r = new FileReader();
            r.onload = e => { document.getElementById('modalPreview').src = e.target.result; document.getElementById('modalPreviewWrap').style.display = 'block'; };
            r.readAsDataURL(this.files[0]);
        }
    });
</script>
</body>
</html>