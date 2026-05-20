<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Log | CS Attendance Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* Stat row */
        .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 22px; }
        .stat-mini {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 18px 20px;
            display: flex; align-items: center; gap: 14px;
            box-shadow: var(--shadow-sm); position: relative; overflow: hidden;
            transition: box-shadow var(--base), transform var(--base);
        }
        .stat-mini:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-mini::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 3px; border-radius: var(--r-xl) var(--r-xl) 0 0;
        }
        .stat-mini.blue::before  { background: linear-gradient(90deg, var(--primary), #6c8aff); }
        .stat-mini.green::before { background: linear-gradient(90deg, var(--success), #34d399); }
        .stat-mini.orange::before{ background: linear-gradient(90deg, var(--warning), #fbbf24); }
        .stat-mini-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
        .smi-blue   { background: var(--primary-light); color: var(--primary); }
        .smi-green  { background: var(--success-bg); color: var(--success); }
        .smi-orange { background: var(--warning-bg); color: var(--warning); }
        .stat-val   { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--text-main); line-height: 1; }
        .stat-label { font-size: 11px; color: var(--text-muted); font-weight: 600; margin-top: 4px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Table card */
        .table-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .table-card-header {
            padding: 15px 20px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .table-card-title {
            font-family: 'Sora', sans-serif; font-size: 13.5px; font-weight: 700;
            color: var(--text-main); display: flex; align-items: center; gap: 8px;
        }
        .table-card-title i { color: var(--primary); }

        .ojt-table { margin: 0; width: 100%; border-collapse: collapse; }
        .ojt-table thead th {
            background: #f6f8ff; font-size: 10px; font-weight: 700;
            color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.7px;
            padding: 13px 16px; border-bottom: 1.5px solid var(--border);
        }
        .ojt-table tbody td {
            padding: 12px 16px; font-size: 13.5px;
            border-bottom: 1px solid #f0f3f9; vertical-align: middle;
        }
        .ojt-table tbody tr:last-child td { border-bottom: none; }
        .ojt-table tbody tr:hover td { background: #f6f8ff; }

        .student-img { width: 38px; height: 38px; border-radius: 9px; object-fit: cover; border: 1.5px solid var(--border); }
        .student-name-cell { font-weight: 600; color: var(--text-main); font-size: 13.5px; }
        .id-badge { font-family: 'Courier New', monospace; font-size: 12px; font-weight: 700; color: var(--text-muted); background: #f1f5f9; padding: 3px 8px; border-radius: 5px; }
        .course-tag { font-size: 11px; font-weight: 600; background: var(--primary-light); color: var(--primary); padding: 4px 10px; border-radius: 6px; }

        .status-badge { display: inline-flex; align-items: center; gap: 5px; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
        .status-present { background: var(--success-bg); color: var(--success-dark); }
        .status-absent  { background: var(--danger-bg); color: var(--danger-dark); }
        .status-partial { background: var(--warning-bg); color: var(--warning-dark); }
        .status-no-event { background: #f1f3f5; color: #868e96; }

        .time-chip  { font-size: 12.5px; font-weight: 600; color: var(--text-main); display: inline-flex; align-items: center; gap: 5px; }
        .time-empty { font-size: 12px; color: #c8d2e8; }

        /* Buttons Container */
        .header-actions {
            display: flex; gap: 10px; align-items: center; flex-wrap: wrap;
        }

        .btn-export {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 8px 16px;
            font-size: 12.5px; font-weight: 600; color: var(--text-muted);
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            text-decoration: none; transition: border-color var(--fast), color var(--fast);
            font-family: 'DM Sans', sans-serif;
        }
        .btn-export:hover { border-color: var(--primary); color: var(--primary); }

        /* Action Buttons */
        .btn-bulk {
            border: none; border-radius: var(--r-md); padding: 8px 16px;
            font-size: 12.5px; font-weight: 600; color: #fff;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: filter var(--fast);
        }
        .btn-bulk:hover { filter: brightness(1.1); color: #fff; }
        .btn-mark-in { background: #10b981; }
        .btn-mark-out { background: #f59e0b; }

        .empty-state { padding: 60px 20px; text-align: center; color: var(--text-muted); }
        .empty-state i { font-size: 36px; opacity: 0.18; margin-bottom: 12px; display: block; }
        .empty-state p { font-size: 13.5px; }

        /* No event banner */
        .no-event-banner {
            background: #fff8e1; border: 1.5px solid #ffe082;
            border-radius: var(--r-xl); padding: 18px 22px;
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 22px; color: #b45309; font-size: 13.5px; font-weight: 600;
        }
        .no-event-banner i { font-size: 20px; color: #f59e0b; flex-shrink: 0; }

        /* Event selector pill */
        .event-pill {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--primary-light); color: var(--primary);
            border: 1.5px solid var(--primary-mid);
            border-radius: 20px; padding: 5px 14px;
            font-size: 12px; font-weight: 600;
        }
        .event-pill.no-event {
            background: #fff3cd; color: #856404;
            border-color: #ffc107;
        }

        /* Modal custom styling */
        .modal-content { border-radius: var(--r-xl); border: none; box-shadow: var(--shadow-md); }
        .modal-header { border-bottom: 1px solid var(--border); background: #f8faff; border-radius: var(--r-xl) var(--r-xl) 0 0; }
        .modal-footer { border-top: 1px solid var(--border); }
        .modal-title { font-size: 16px; font-weight: 700; color: var(--text-main); }
        .modal-icon-container { font-size: 40px; margin-bottom: 15px; }
        .modal-icon-in { color: #10b981; }
        .modal-icon-out { color: #f59e0b; }

        @media (max-width: 768px) { .stat-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

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
            <a class="topnav-link" href="<?= base_url('admin/students') ?>">
                <i class="fas fa-users"></i> Students
            </a>
            <a class="topnav-link active" href="<?= base_url('admin/check_attendance') ?>">
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

<div class="main-content">

    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">Attendance Log</h1>
            <p class="page-sub">Track and review student attendance records</p>
        </div>
        
        <div class="page-header-right header-actions">
            <span class="event-pill <?= $current_event_id == 0 ? 'no-event' : '' ?>">
                <i class="fas fa-calendar-check"></i>
                <?= esc($event_name) ?>
            </span>
            
            <?php if ($current_event_id > 0): ?>
            <button class="btn-bulk btn-mark-in" data-bs-toggle="modal" data-bs-target="#markAllInModal">
                <i class="fas fa-sign-in-alt"></i> Mark All In
            </button>
            <button class="btn-bulk btn-mark-out" data-bs-toggle="modal" data-bs-target="#markAllOutModal">
                <i class="fas fa-sign-out-alt"></i> Mark All Out
            </button>
            <?php endif; ?>
            
            <a href="#" class="btn-export"><i class="fas fa-download"></i> Export CSV</a>
        </div>
    </div>

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

    <?php if ($current_event_id == 0): ?>
    <div class="no-event-banner">
        <i class="fas fa-calendar-times"></i>
        <div>
            <strong>No Active Event Today</strong> — There is no event scheduled for today. Attendance tracking is disabled. Go to <a href="<?= base_url('admin/events') ?>" style="color:#b45309;text-decoration:underline;">Events</a> to create one.
        </div>
    </div>
    <?php endif; ?>

    <div class="stat-row">
        <div class="stat-mini blue">
            <div class="stat-mini-icon smi-blue"><i class="fas fa-users"></i></div>
            <div>
                <div class="stat-val"><?= count($students) ?></div>
                <div class="stat-label">Total Students</div>
            </div>
        </div>
        <div class="stat-mini green">
            <div class="stat-mini-icon smi-green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-val"><?= count(array_filter($students, fn($s) => !empty($s['time_in']) && !empty($s['time_out']))) ?></div>
                <div class="stat-label">Present Today</div>
            </div>
        </div>
        <div class="stat-mini orange">
            <div class="stat-mini-icon smi-orange"><i class="fas fa-clock"></i></div>
            <div>
                <div class="stat-val"><?= count(array_filter($students, fn($s) => !empty($s['time_in']) && empty($s['time_out']))) ?></div>
                <div class="stat-label">Pending Time-Out</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <i class="fas fa-list-check"></i> Attendance Records
                <?php if (!empty($search_query)): ?>
                    — filtered for <strong style="color:var(--primary)"><?= esc($search_query) ?></strong>
                    <a href="<?= base_url('admin/check_attendance') ?>" style="font-size:11px;color:var(--text-muted);margin-left:6px;font-weight:500;">Clear</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="table-responsive">
            <table class="ojt-table">
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
                                <img src="<?= !empty($student['profile_pic'])
                                    ? base_url('assets/uploads/profile_pics/' . $student['profile_pic'])
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($student['full_name']) . '&background=3b5bfc&color=fff&size=80'
                                ?>" class="student-img" alt="">
                            </td>
                            <td><span class="id-badge"><?= esc($student['id_number']) ?></span></td>
                            <td><span class="student-name-cell"><?= esc($student['full_name']) ?></span></td>
                            <td><span class="course-tag"><?= esc($student['course']) ?></span></td>
                            <td>Year <?= esc($student['year_level_id']) ?></td>
                            <td>
                                <?php if (!empty($student['time_in'])): ?>
                                    <span class="time-chip">
                                        <i class="fas fa-sign-in-alt" style="color:var(--success)"></i>
                                        <?= date('h:i A', strtotime($student['time_in'])) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="time-empty">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($student['time_out'])): ?>
                                    <span class="time-chip">
                                        <i class="fas fa-sign-out-alt" style="color:var(--warning)"></i>
                                        <?= date('h:i A', strtotime($student['time_out'])) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="time-empty">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($student['time_in']) && !empty($student['time_out'])): ?>
                                    <span class="status-badge status-present"><i class="fas fa-check"></i> Present</span>
                                <?php elseif (!empty($student['time_in'])): ?>
                                    <span class="status-badge status-partial"><i class="fas fa-clock"></i> In Progress</span>
                                <?php elseif ($current_event_id > 0): ?>
                                    <span class="status-badge status-absent"><i class="fas fa-times"></i> Absent</span>
                                <?php else: ?>
                                    <span class="status-badge status-no-event">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>No attendance records found for this session.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php if ($current_event_id > 0): ?>
<div class="modal fade" id="markAllInModal" tabindex="-1" aria-labelledby="markAllInLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('admin/mark_all_present') ?>" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="markAllInLabel">Confirm Bulk Time-In</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center py-4">
            <div class="modal-icon-container modal-icon-in">
                <i class="fas fa-check-circle"></i>
            </div>
            <p class="mb-0">Are you sure you want to mark <strong>all registered students</strong> as timed-in for the current active event?</p>
            <small class="text-muted mt-2 d-block">Students who already have a time-in record will be skipped.</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-sign-in-alt"></i> Proceed Time-In</button>
          </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="markAllOutModal" tabindex="-1" aria-labelledby="markAllOutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('admin/mark_all_timeout') ?>" method="POST">
          <div class="modal-header">
            <h5 class="modal-title" id="markAllOutLabel">Confirm Bulk Time-Out</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center py-4">
            <div class="modal-icon-container modal-icon-out">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <p class="mb-0">Are you sure you want to mark <strong>all timed-in students</strong> as timed-out?</p>
            <small class="text-muted mt-2 d-block">Students without a time-in record or who are already timed-out will be skipped.</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning text-white btn-sm"><i class="fas fa-sign-out-alt"></i> Proceed Time-Out</button>
          </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>