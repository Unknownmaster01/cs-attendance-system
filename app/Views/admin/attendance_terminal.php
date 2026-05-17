<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Log | CS Attendance Monitoring System</title>
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
            --danger: #ef4444;
            --sidebar-bg: #0f172a;
            --sidebar-text: #94a3b8;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
        }
        * { box-sizing: border-box; }
        body { background: var(--bg); font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-main); margin: 0; }

        .sidebar { width: 240px; min-height: 100vh; background: var(--sidebar-bg); position: fixed; top: 0; left: 0; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-brand { padding: 28px 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.06); }
        .brand-icon { width: 42px; height: 42px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; overflow: hidden; }
        .brand-icon svg { width: 34px; height: 34px; }
        .brand-title { font-size: 13px; font-weight: 700; color: #fff; }
        .brand-sub { font-size: 11px; color: var(--sidebar-text); margin-top: 2px; }
        .sidebar-nav { flex: 1; padding: 16px 12px; }
        .nav-section-label { font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 1px; padding: 0 8px; margin: 16px 0 6px; }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; color: var(--sidebar-text); text-decoration: none; font-size: 13.5px; font-weight: 500; transition: all .18s; margin-bottom: 2px; }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar-link.active { background: var(--primary); color: #fff; }
        .sidebar-link i { width: 18px; text-align: center; font-size: 14px; }
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,0.06); }
        .admin-chip { display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(255,255,255,0.05); border-radius: 10px; }
        .admin-avatar { width: 34px; height: 34px; border-radius: 8px; background: var(--primary); display: flex; align-items: center; justify-content: center; }
        .admin-avatar i { color: #fff; font-size: 14px; }
        .admin-name { font-size: 12px; font-weight: 600; color: #fff; }
        .admin-role { font-size: 10px; color: var(--sidebar-text); }

        .main-content { margin-left: 240px; min-height: 100vh; padding: 32px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 16px; }
        .page-title { font-size: 22px; font-weight: 800; }
        .page-sub { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        /* STAT ROW */
        .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-mini { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 18px 20px; display: flex; align-items: center; gap: 14px; }
        .stat-mini-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 17px; flex-shrink: 0; }
        .smi-blue { background: var(--primary-light); color: var(--primary); }
        .smi-green { background: #d1fae5; color: var(--success); }
        .smi-orange { background: #fef3c7; color: var(--warning); }
        .stat-mini-val { font-size: 22px; font-weight: 800; line-height: 1; }
        .stat-mini-label { font-size: 11.5px; color: var(--text-muted); font-weight: 500; margin-top: 3px; }

        /* TABLE */
        .table-card { background: #fff; border: 1px solid var(--border); border-radius: 14px; overflow: hidden; }
        .table-card-header { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .table-card-title { font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px; }
        .table { margin: 0; }
        .table thead th { background: #f8fafc; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; padding: 14px 16px; border-bottom: 1.5px solid var(--border); border-top: none; }
        .table tbody td { padding: 13px 16px; font-size: 13.5px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover td { background: #f8fafc; }
        .student-img { width: 38px; height: 38px; border-radius: 9px; object-fit: cover; border: 1.5px solid var(--border); }
        .student-name { font-weight: 600; }
        .id-badge { font-family: monospace; font-size: 12px; font-weight: 700; color: var(--text-muted); background: #f1f5f9; padding: 3px 8px; border-radius: 5px; }
        .status-present { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; background: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 20px; }
        .status-absent { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 20px; }
        .status-partial { display: inline-flex; align-items: center; gap: 5px; font-size: 11.5px; font-weight: 700; background: #fef3c7; color: #92400e; padding: 4px 10px; border-radius: 20px; }
        .time-chip { font-size: 12.5px; font-weight: 600; color: var(--text-main); }
        .time-empty { font-size: 12px; color: #cbd5e1; }
        .btn-export { background: #fff; border: 1.5px solid var(--border); border-radius: 9px; padding: 8px 16px; font-size: 13px; font-weight: 600; color: var(--text-muted); cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: all .18s; text-decoration: none; }
        .btn-export:hover { border-color: var(--primary); color: var(--primary); }
        .empty-state { padding: 60px; text-align: center; color: var(--text-muted); }
        .empty-state i { font-size: 38px; opacity: .2; margin-bottom: 12px; display: block; }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="sidebar-brand">
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
        <div class="brand-title">CS Attendance Monitoring System</div>
        <div class="brand-sub">Admin Portal</div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a class="sidebar-link" href="<?= base_url('admin') ?>"><i class="fas fa-home"></i> Dashboard</a>
        <a class="sidebar-link" href="<?= base_url('admin/students') ?>"><i class="fas fa-users"></i> Students</a>
        <a class="sidebar-link active" href="<?= base_url('admin/check_attendance') ?>"><i class="fas fa-clipboard-check"></i> Attendance Log</a>
        <div class="nav-section-label">Tools</div>
        <a class="sidebar-link" href="<?= base_url('admin/attendance_terminal') ?>"><i class="fas fa-qrcode"></i> ID Scanner</a>
        <div class="nav-section-label">Account</div>
        <a class="sidebar-link" href="<?= base_url('logout') ?>" style="color:#f87171"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="sidebar-footer">
        <div class="admin-chip">
            <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
            <div>
                <div class="admin-name"><?= session()->get('full_name') ?></div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>
    </div>
</nav>

<div class="main-content">
    <div class="topbar">
        <div>
            <div class="page-title">Attendance Log</div>
            <div class="page-sub">Track and review student attendance records</div>
        </div>
        <a href="#" class="btn-export"><i class="fas fa-download"></i> Export CSV</a>
    </div>

    <!-- STAT ROW -->
    <div class="stat-row">
        <div class="stat-mini">
            <div class="stat-mini-icon smi-blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-mini-val"><?= count($students) ?></div>
                <div class="stat-mini-label">Total Students</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon smi-green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-mini-val">—</div>
                <div class="stat-mini-label">Present Today</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon smi-orange"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-mini-val">—</div>
                <div class="stat-mini-label">Pending Time-Out</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title"><i class="fas fa-list-check" style="color:var(--primary)"></i> Attendance Records</div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>ID Number</th>
                        <th>Full Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td>
                                <img src="<?= !empty($student['profile_pic']) ? base_url('uploads/profiles/'.$student['profile_pic']) : 'https://ui-avatars.com/api/?name='.urlencode($student['full_name']).'&background=1a56db&color=fff&size=80' ?>"
                                     class="student-img">
                            </td>
                            <td><span class="id-badge"><?= esc($student['id_number']) ?></span></td>
                            <td><span class="student-name"><?= esc($student['full_name']) ?></span></td>
                            <td><?= esc($student['course']) ?></td>
                            <td>Year <?= esc($student['year_level_id']) ?></td>
                            <td>
                                <?php if (!empty($student['time_in'])): ?>
                                    <span class="time-chip"><i class="fas fa-sign-in-alt me-1" style="color:var(--success)"></i><?= date('h:i A', strtotime($student['time_in'])) ?></span>
                                <?php else: ?>
                                    <span class="time-empty">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($student['time_out'])): ?>
                                    <span class="time-chip"><i class="fas fa-sign-out-alt me-1" style="color:var(--warning)"></i><?= date('h:i A', strtotime($student['time_out'])) ?></span>
                                <?php else: ?>
                                    <span class="time-empty">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($student['time_in']) && !empty($student['time_out'])): ?>
                                    <span class="status-present"><i class="fas fa-check"></i> Present</span>
                                <?php elseif (!empty($student['time_in'])): ?>
                                    <span class="status-partial"><i class="fas fa-clock"></i> In Progress</span>
                                <?php else: ?>
                                    <span class="status-absent"><i class="fas fa-times"></i> Absent</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>No attendance records found.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>