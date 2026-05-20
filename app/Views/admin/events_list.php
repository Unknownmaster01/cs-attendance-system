<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | CS Attendance Monitoring System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/admin.css') ?>">
    <style>
        /* ── Filter Tabs ── */
        .filter-tabs {
            display: flex; gap: 8px; flex-wrap: wrap;
        }
        .filter-tab {
            padding: 7px 16px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
            text-decoration: none; border: 1.5px solid var(--border);
            color: var(--text-muted); background: var(--card-bg);
            transition: all var(--fast);
        }
        .filter-tab:hover { border-color: var(--primary); color: var(--primary); }
        .filter-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }

        /* ── Events Table Card ── */
        .events-card {
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .events-card-header {
            padding: 16px 22px;
            border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .events-card-title {
            font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700;
            color: var(--text-main); display: flex; align-items: center; gap: 9px;
        }
        .events-card-title i { color: var(--primary); }
        .count-chip {
            background: var(--primary-light); color: var(--primary);
            font-size: 11px; font-weight: 700; padding: 3px 11px; border-radius: 20px;
        }

        /* ── Event Row ── */
        .ev-row {
            display: flex; align-items: center; gap: 16px;
            padding: 14px 22px;
            border-bottom: 1px solid #f0f3f9;
            transition: background var(--fast);
        }
        .ev-row:last-child { border-bottom: none; }
        .ev-row:hover { background: #f6f8ff; }

        .ev-color-bar { width: 4px; height: 42px; border-radius: 4px; flex-shrink: 0; }
        .ev-icon {
            width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 15px;
        }
        .ev-info { flex: 1; min-width: 0; }
        .ev-title {
            font-size: 13.5px; font-weight: 600; color: var(--text-main);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .ev-desc {
            font-size: 11.5px; color: var(--text-muted); margin-top: 2px;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .ev-date { font-size: 11.5px; color: var(--text-muted); margin-top: 3px; display: flex; align-items: center; gap: 5px; }
        .ev-date i { font-size: 10px; color: var(--text-light); }

        .ev-badge {
            font-size: 10px; font-weight: 700; padding: 3px 10px;
            border-radius: 20px; white-space: nowrap; flex-shrink: 0;
        }
        .badge-today  { background: var(--primary-light); color: var(--primary); }
        .badge-soon   { background: var(--warning-bg);    color: var(--warning-dark); }
        .badge-past   { background: #f1f5f9;              color: var(--text-muted); }
        .badge-active { background: var(--success-bg);    color: var(--success-dark); }

        .ev-actions { display: flex; gap: 7px; flex-shrink: 0; }
        .btn-ev-edit {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 6px 13px; border-radius: var(--r-md);
            font-size: 11.5px; font-weight: 600; text-decoration: none;
            background: var(--primary-light); color: var(--primary);
            border: 1px solid transparent; transition: all var(--fast);
        }
        .btn-ev-edit:hover { background: var(--primary); color: #fff; }

        /* ── Empty State ── */
        .ev-empty {
            padding: 60px 20px; text-align: center; color: var(--text-muted);
        }
        .ev-empty i { font-size: 36px; opacity: .12; display: block; margin-bottom: 12px; }
        .ev-empty p { font-size: 13.5px; margin: 0; }

        /* ── Summary chips row ── */
        .summary-row {
            display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px;
        }
        .summary-chip {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 12px 18px;
            display: flex; align-items: center; gap: 10px;
            box-shadow: var(--shadow-sm); flex: 1; min-width: 140px;
        }
        .summary-chip-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0;
        }
        .summary-chip-val { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 700; color: var(--text-main); line-height: 1; }
        .summary-chip-label { font-size: 11px; color: var(--text-muted); margin-top: 2px; }
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
            <a class="topnav-link" href="<?= base_url('admin') ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a class="topnav-link" href="<?= base_url('admin/students') ?>">
                <i class="fas fa-users"></i> Students
            </a>
            <a class="topnav-link" href="<?= base_url('admin/check_attendance') ?>">
                <i class="fas fa-clipboard-check"></i> Attendance Log
            </a>
            <a class="topnav-link active" href="<?= base_url('admin/events') ?>">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
            <a class="topnav-link" href="<?= base_url('admin/announcements') ?>">
                <i class="fas fa-bullhorn"></i> Announcements
            </a>
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

<!-- ══════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════ -->
<div class="main-content">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">All Events</h1>
            <p class="page-sub">Browse, filter, and manage Attendance events.</p>
        </div>
        <div class="page-header-right">
            <a href="<?= base_url('admin') ?>" class="btn-logout-admin" title="Back to Dashboard" style="text-decoration:none;padding:8px 16px;font-size:12.5px;display:inline-flex;align-items:center;gap:7px;border-radius:var(--r-md);">
                <i class="fas fa-arrow-left"></i>
            </a>
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

    <!-- ── Summary Chips ── -->
    <?php
        $allEvents      = $events ?? [];
        $now            = time();
        $totalCount     = count($allEvents);
        $upcomingCount  = count(array_filter($allEvents, fn($e) => strtotime($e['start_event']) > $now));
        $pastCount      = count(array_filter($allEvents, fn($e) => strtotime($e['start_event']) < $now));
        $thisMonthCount = count(array_filter($allEvents, fn($e) => date('Y-m', strtotime($e['start_event'])) === date('Y-m')));
    ?>
    <div class="summary-row">
        <div class="summary-chip">
            <div class="summary-chip-icon" style="background:var(--primary-light);color:var(--primary)"><i class="fas fa-calendar-alt"></i></div>
            <div>
                <div class="summary-chip-val"><?= $totalCount ?></div>
                <div class="summary-chip-label">Total Events</div>
            </div>
        </div>
        <div class="summary-chip">
            <div class="summary-chip-icon" style="background:var(--success-bg);color:var(--success)"><i class="fas fa-calendar-check"></i></div>
            <div>
                <div class="summary-chip-val"><?= $thisMonthCount ?></div>
                <div class="summary-chip-label">This Month</div>
            </div>
        </div>
        <div class="summary-chip">
            <div class="summary-chip-icon" style="background:var(--warning-bg);color:var(--warning)"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="summary-chip-val"><?= $upcomingCount ?></div>
                <div class="summary-chip-label">Upcoming</div>
            </div>
        </div>
        <div class="summary-chip">
            <div class="summary-chip-icon" style="background:#f1f5f9;color:var(--text-muted)"><i class="fas fa-history"></i></div>
            <div>
                <div class="summary-chip-val"><?= $pastCount ?></div>
                <div class="summary-chip-label">Past Events</div>
            </div>
        </div>
    </div>

    <!-- ── Filter Tabs + Table ── -->
    <div class="events-card">
        <div class="events-card-header">
            <div class="events-card-title">
                <i class="fas fa-list-check"></i> Event List
            </div>
            <div class="filter-tabs">
                <a href="?filter=all"      class="filter-tab <?= ($filter === 'all')      ? 'active' : '' ?>"><i class="fas fa-layer-group"></i> All</a>
                <a href="?filter=month"    class="filter-tab <?= ($filter === 'month')    ? 'active' : '' ?>"><i class="fas fa-calendar"></i> This Month</a>
                <a href="?filter=upcoming" class="filter-tab <?= ($filter === 'upcoming') ? 'active' : '' ?>"><i class="fas fa-arrow-right"></i> Upcoming</a>
                <a href="?filter=past"     class="filter-tab <?= ($filter === 'past')     ? 'active' : '' ?>"><i class="fas fa-history"></i> Past</a>
            </div>
        </div>

        <?php if (!empty($events)): ?>
            <?php foreach ($events as $ev):
                $evTime = strtotime($ev['start_event']);
                $evDate = date('Y-m-d', $evTime);
                $today  = date('Y-m-d');
                if ($evDate === $today)      { $badgeClass = 'badge-today'; $badgeLabel = 'Today'; }
                elseif ($evTime > $now)      { $badgeClass = 'badge-soon';  $badgeLabel = 'Upcoming'; }
                else                         { $badgeClass = 'badge-past';  $badgeLabel = 'Past'; }
                $color = !empty($ev['color']) ? $ev['color'] : '#3b5bfc';
            ?>
            <div class="ev-row">
                <div class="ev-color-bar" style="background:<?= esc($color) ?>"></div>
                <div class="ev-icon" style="background:<?= esc($color) ?>18;">
                    <i class="fas fa-calendar-day" style="color:<?= esc($color) ?>"></i>
                </div>
                <div class="ev-info">
                    <div class="ev-title"><?= esc($ev['title']) ?></div>
                    <?php if (!empty($ev['description'])): ?>
                    <div class="ev-desc"><?= esc($ev['description']) ?></div>
                    <?php endif; ?>
                    <div class="ev-date">
                        <i class="fas fa-clock"></i>
                        <?= date('F j, Y · g:i A', $evTime) ?>
                    </div>
                </div>
                <span class="ev-badge <?= $badgeClass ?>"><?= $badgeLabel ?></span>
                <div class="ev-actions">
                    <!-- Triggers the same edit modal via JS -->
                    <a href="#" class="btn-ev-edit"
                       onclick="openEditModal('<?= esc($ev['id']) ?>','<?= esc(addslashes($ev['title'])) ?>','<?= date('Y-m-d', $evTime) ?>','<?= date('H:i', $evTime) ?>','<?= esc(addslashes($ev['description'] ?? '')) ?>','<?= esc($color) ?>'); return false;">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="ev-empty">
                <i class="fas fa-calendar-times"></i>
                <p>No events found for this filter.</p>
            </div>
        <?php endif; ?>
    </div>

</div><!-- /main-content -->

<!-- ══════════════════════════════════════
     EDIT EVENT MODAL  (same as dashboard)
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
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fas fa-check"></i> Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditModal(id, title, date, time, description, color) {
    document.getElementById('edit_title').value       = title;
    document.getElementById('edit_date').value        = date;
    document.getElementById('edit_time').value        = time;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_color').value       = color;
    document.getElementById('editEventForm').action   = '<?= base_url("admin/update_event") ?>/' + id;
    new bootstrap.Modal(document.getElementById('editEventModal')).show();
}
</script>
</body>
</html>