<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Directory | CS Attendance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* ── Table card ── */
        .table-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .ojt-table { margin: 0; width: 100%; border-collapse: collapse; }
        .ojt-table thead th {
            background: #f6f8ff;
            font-size: 10px; font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.7px;
            padding: 13px 18px;
            border-bottom: 1.5px solid var(--border);
        }
        .ojt-table tbody td {
            padding: 13px 18px;
            font-size: 13.5px;
            border-bottom: 1px solid #f0f3f9;
            vertical-align: middle;
            color: var(--text-body);
        }
        .ojt-table tbody tr:last-child td { border-bottom: none; }
        .ojt-table tbody tr { transition: background var(--fast); }
        .ojt-table tbody tr:hover td { background: #f6f8ff; }

        .student-img {
            width: 40px; height: 40px;
            object-fit: cover; border-radius: 10px;
            border: 1.5px solid var(--border);
        }
        .student-name-cell { font-weight: 600; color: var(--text-main); font-size: 13.5px; }
        .id-badge {
            font-family: 'Courier New', monospace;
            font-size: 12px; font-weight: 700;
            color: var(--text-muted);
            background: #f1f5f9;
            padding: 3px 9px; border-radius: 5px;
        }
        .course-tag {
            font-size: 11px; font-weight: 600;
            background: var(--primary-light); color: var(--primary);
            padding: 4px 10px; border-radius: 6px;
        }
        .year-tag {
            font-size: 11px; font-weight: 600;
            background: var(--success-bg); color: var(--success-dark);
            padding: 4px 10px; border-radius: 6px;
        }
        .btn-view {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 600; color: var(--primary);
            background: var(--primary-light); border-radius: var(--r-md);
            padding: 7px 14px; text-decoration: none;
            border: 1.5px solid var(--primary-mid);
            transition: background var(--fast), color var(--fast), border-color var(--fast);
        }
        .btn-view:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

        .empty-state { padding: 60px 20px; text-align: center; color: var(--text-muted); }
        .empty-state i { font-size: 36px; opacity: 0.18; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 13.5px; }

        .count-chip {
            background: var(--primary-light); color: var(--primary);
            font-size: 12px; font-weight: 700;
            padding: 5px 13px; border-radius: 20px;
            white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;
        }

        /* inline search row */
        .search-group {
            display: inline-flex; align-items: center;
            border: 1.5px solid var(--border); border-radius: var(--r-md);
            background: var(--card-bg); overflow: hidden;
            transition: border-color var(--fast), box-shadow var(--fast);
        }
        .search-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3.5px var(--primary-glow);
        }
        .search-group input {
            border: none; outline: none; padding: 9px 14px;
            font-size: 13px; font-family: 'DM Sans', sans-serif;
            background: transparent; width: 260px; color: var(--text-main);
        }
        .search-group input::placeholder { color: var(--text-light); }
        .search-group button {
            background: var(--primary); border: none; color: #fff;
            padding: 9px 16px; cursor: pointer; font-size: 13px;
            transition: filter var(--fast);
        }
        .search-group button:hover { filter: brightness(1.1); }
        .search-group a {
            background: #f1f5f9; border: none; color: var(--text-muted);
            padding: 9px 13px; text-decoration: none;
            display: flex; align-items: center; font-size: 12px;
            transition: background var(--fast);
        }
        .search-group a:hover { background: var(--border); color: var(--text-main); }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════
     TOP NAV
══════════════════════════════════════ -->
<nav class="topnav">
    <div class="topnav-inner">

        <!-- Brand -->
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

        <!-- Nav links -->
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

        <!-- Right cluster -->
        <div class="topnav-right">
            <!-- Search -->
            <form action="<?= base_url('admin/students') ?>" method="GET" class="topnav-search-form">
                <div class="topnav-search">
                    <i class="fas fa-search"></i>
                    <input
                        type="text"
                        name="search"
                        class="topnav-search-input"
                        placeholder="Search by name or ID..."
                        value="<?= esc($search_query ?? '') ?>"
                    >
                </div>
            </form>

            <!-- Notifications -->
            <button class="topnav-icon-btn" title="Notifications">
                <i class="fas fa-bell"></i>
            </button>

            <!-- Admin badge -->
            <div class="topnav-admin">
                <div class="topnav-admin-avatar">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <span class="topnav-admin-name">Administrator</span>
                    <span class="topnav-admin-role">Super Admin</span>
                </div>
            </div>

            <!-- Logout -->
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
            <h1 class="page-title">Registered Students</h1>
            <p class="page-sub">Browse and manage all Registered Students</p>
        </div>
        <div class="page-header-right">
            <span class="count-chip">
                <i class="fas fa-user-graduate" style="font-size:11px;"></i>
                <?= count($students) ?> Students
            </span>
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

    <!-- Search bar -->
    <div style="margin-bottom: 20px;">
        <form action="<?= base_url('admin/students') ?>" method="GET">
            <div class="search-group">
                <input
                    type="text"
                    name="search"
                    placeholder="Search by name or ID..."
                    value="<?= esc($search_query ?? '') ?>"
                >
                <button type="submit"><i class="fas fa-search"></i></button>
                <?php if (!empty($search_query)): ?>
                    <a href="<?= base_url('admin/students') ?>" title="Clear search">
                        <i class="fas fa-times"></i>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Student Table -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="ojt-table">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>ID Number</th>
                        <th>Full Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td>
                                <img src="<?= !empty($student['profile_pic'])
                                    ? base_url('assets/uploads/profile_pics/' . $student['profile_pic'])
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($student['full_name']) . '&background=3b5bfc&color=fff&size=80'
                                ?>" class="student-img" alt="">
                            </td>
                            <td><span class="id-badge"><?= esc($student['id_number']) ?></span></td>
                            <td><span class="student-name-cell"><?= esc($student['full_name']) ?></span></td>
                            <td><span class="course-tag"><?= esc($student['course']) ?></span></td>
                            <td><span class="year-tag">Year <?= esc($student['year_level_id']) ?></span></td>
                            <td class="text-center">
                                <a href="<?= base_url('admin/view_student/' . $student['id_number']) ?>" class="btn-view">
                                    <i class="fas fa-eye"></i> View Profile
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-magnifying-glass"></i>
                                    <?php if (!empty($search_query)): ?>
                                        <p>No results for "<strong><?= esc($search_query) ?></strong>"</p>
                                    <?php else: ?>
                                        <p>No students registered in the system yet.</p>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- /main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>