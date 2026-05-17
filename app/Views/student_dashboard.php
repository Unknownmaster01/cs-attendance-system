<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Student Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>

        /* ══════════════════════════════════════
           ADMIN-MATCHING DESIGN TOKENS
        ══════════════════════════════════════ */
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

        :root {
            --primary:        #3b5bfc;
            --primary-light:  #eef1ff;
            --primary-mid:    #c5ceff;
            --primary-dark:   #2541d4;
            --primary-glow:   rgba(59,91,252,0.18);

            --success:        #12b76a;
            --success-bg:     #d1fadf;
            --success-dark:   #065f46;
            --warning:        #f79009;
            --warning-bg:     #fef0c7;
            --warning-dark:   #7a4a00;
            --danger:         #f04438;
            --danger-bg:      #fde8e7;

            --nav-bg:         #080e1e;
            --nav-border:     rgba(255,255,255,0.06);
            --nav-text:       #7a8fba;
            --nav-h:          62px;

            --bg:             #f0f3fa;
            --card-bg:        #ffffff;
            --border:         #e0e6f0;

            --text-main:      #080e1e;
            --text-body:      #2d3a52;
            --text-muted:     #5e6f8e;
            --text-light:     #9aa5be;

            --shadow-sm: 0 1px 4px rgba(8,14,30,0.06), 0 4px 14px rgba(8,14,30,0.06);
            --shadow-md: 0 4px 16px rgba(8,14,30,0.08), 0 14px 36px rgba(8,14,30,0.08);

            --r-sm: 6px; --r-md: 10px; --r-lg: 14px;
            --r-xl: 18px; --r-2xl: 24px;

            --ease: cubic-bezier(0.4,0,0.2,1);
            --fast: 130ms; --base: 210ms;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-body);
            font-size: 14px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
            padding-top: var(--nav-h);
        }
        a { text-decoration: none; color: inherit; }
        .ann-post-badge {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 11px; font-weight: 600; color: var(--primary);
            background: var(--primary-light); padding: 2px 8px; border-radius: 20px; margin-left: 6px;
        }
        .ann-post-author { font-size: 14.5px; font-weight: 700; color: var(--text-main); }

        /* ══════════════════════════════════════
           TOP NAV — identical to admin
        ══════════════════════════════════════ */
        .topnav {
            position: fixed; top: 0; left: 0; right: 0;
            height: var(--nav-h);
            background: var(--nav-bg);
            z-index: 300;
            border-bottom: 1px solid var(--nav-border);
            background-image:
                radial-gradient(ellipse 60% 200% at -5% 50%, rgba(59,91,252,0.18) 0%, transparent 55%),
                radial-gradient(ellipse 30% 150% at 105% 50%, rgba(59,91,252,0.08) 0%, transparent 60%);
        }
        .topnav-inner {
            display: flex; align-items: center;
            height: 100%; padding: 0 26px; gap: 0;
        }
        .topnav-brand {
            display: flex; align-items: center; gap: 11px;
            text-decoration: none; flex-shrink: 0; margin-right: 28px;
        }
        .brand-icon {
            width: 36px; height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 14px rgba(59,91,252,0.42); flex-shrink: 0;
            overflow: hidden;
        }
        .brand-icon svg { width: 28px; height: 28px; }
        .brand-text { display: flex; flex-direction: column; }
        .brand-title { font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 700; color: #fff; line-height: 1.2; }
        .brand-sub   { font-size: 9px; color: var(--nav-text); text-transform: uppercase; letter-spacing: 0.9px; }

        .topnav-links { display: flex; align-items: center; gap: 1px; flex: 1; }
        .topnav-link {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 11px; border-radius: var(--r-md);
            color: var(--nav-text); text-decoration: none;
            font-size: 12px; font-weight: 500;
            transition: background var(--fast), color var(--fast);
            white-space: nowrap;
        }
        .topnav-link:hover { background: rgba(255,255,255,0.06); color: #d4e0f7; }
        .topnav-link.active { background: rgba(59,91,252,0.24); color: #fff; font-weight: 600; box-shadow: inset 0 1px 0 rgba(255,255,255,0.08); }
        .topnav-link i { font-size: 11.5px; opacity: 0.75; }
        .topnav-link.active i { opacity: 1; }

        .topnav-right { display: flex; align-items: center; gap: 9px; margin-left: auto; flex-shrink: 0; }

        .topnav-user {
            display: flex; align-items: center; gap: 9px;
            padding: 5px 11px; border-radius: var(--r-md);
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.09);
        }
        .topnav-avatar {
            width: 28px; height: 28px; border-radius: 7px;
            object-fit: cover; border: 1.5px solid rgba(255,255,255,0.15); flex-shrink: 0;
        }
        .topnav-name { display: block; font-family: 'Sora', sans-serif; font-size: 11.5px; font-weight: 700; color: #fff; line-height: 1.2; }
        .topnav-id   { display: block; font-size: 9.5px; color: var(--nav-text); }

        .btn-logout {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 6px 13px; border-radius: var(--r-md);
            background: rgba(240,68,56,0.12); border: 1.5px solid rgba(240,68,56,0.22);
            color: #f87171; font-size: 12px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            transition: background var(--fast), color var(--fast);
        }
        .btn-logout:hover { background: var(--danger); color: #fff; }

        /* ══════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════ */
        .main-content { max-width: 1440px; margin: 0 auto; padding: 28px 28px 60px; }

        .page-header {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 22px; flex-wrap: wrap; gap: 12px;
        }
        .page-title { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 800; color: var(--text-main); letter-spacing: -0.5px; }
        .page-sub   { font-size: 13.5px; color: var(--text-muted); margin-top: 3px; }
        .page-sub strong { color: var(--text-body); font-weight: 600; }

        .header-date {
            display: flex; align-items: center; gap: 7px;
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 7px 13px;
            font-size: 12px; font-weight: 600; color: var(--text-muted);
            box-shadow: var(--shadow-sm);
        }
        .header-date i { color: var(--primary); }

        .flash-alert {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; border-radius: var(--r-xl);
            font-size: 13px; font-weight: 500; margin-bottom: 20px;
        }
        .flash-success { background: var(--success-bg); color: var(--success-dark); border-left: 3px solid var(--success); }
        .flash-danger  { background: var(--danger-bg);  color: #991b1b; border-left: 3px solid var(--danger); }

        /* ══════════════════════════════════════
           STAT CARDS — admin style
        ══════════════════════════════════════ */
        .stats-row {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 16px; margin-bottom: 24px;
        }
        .stat-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); padding: 20px 22px;
            display: flex; align-items: center; gap: 16px;
            box-shadow: var(--shadow-sm); position: relative; overflow: hidden;
            transition: box-shadow var(--base), transform var(--base);
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .stat-card-icon {
            width: 46px; height: 46px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .sci-blue   { background: var(--primary-light); color: var(--primary); }
        .sci-green  { background: var(--success-bg);    color: var(--success); }
        .sci-orange { background: var(--warning-bg);    color: var(--warning); }
        .stat-card-body  { flex: 1; min-width: 0; }
        .stat-label { font-size: 11.5px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-val   { font-family: 'Sora', sans-serif; font-size: 28px; font-weight: 800; color: var(--text-main); line-height: 1.1; margin-top: 2px; }
        .stat-sub   { font-size: 11.5px; color: var(--text-muted); margin-top: 3px; display: flex; align-items: center; gap: 5px; }
        .stat-card-ring {
            position: absolute; right: -18px; top: -18px;
            width: 90px; height: 90px; border-radius: 50%;
            opacity: 0.08; pointer-events: none;
        }
        .scr-blue   { background: var(--primary); }
        .scr-green  { background: var(--success); }
        .scr-orange { background: var(--warning); }

        /* ══════════════════════════════════════
           MAIN 2-COLUMN GRID
        ══════════════════════════════════════ */
        .dash-grid {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 20px; align-items: start;
        }

        /* ── SIDEBAR ── */
        .dash-sidebar { display: flex; flex-direction: column; gap: 16px; position: sticky; top: calc(var(--nav-h) + 20px); }

        /* Profile card */
        .profile-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-2xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .profile-banner {
            height: 110px;
            background: linear-gradient(135deg, #080e1e 0%, #1a2a6c 50%, var(--primary) 100%);
            position: relative; overflow: hidden;
        }
        .profile-banner::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.06'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/svg%3E");
        }
        .profile-body { padding: 0 24px 24px; text-align: center; }
        .profile-img-wrap { position: relative; display: inline-block; margin-top: -46px; margin-bottom: 12px; }
        .profile-img {
            width: 92px; height: 92px; border-radius: 50%;
            object-fit: cover; border: 4px solid #fff;
            box-shadow: 0 4px 16px rgba(59,91,252,0.22);
        }
        .verified-dot {
            position: absolute; bottom: 2px; right: 2px;
            width: 22px; height: 22px; border-radius: 50%;
            background: var(--success); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px; border: 2px solid #fff;
        }
        .profile-name { font-family: 'Sora', sans-serif; font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 5px; }
        .profile-id-badge {
            display: inline-block; font-family: monospace; font-size: 13px; font-weight: 700;
            background: var(--primary-light); color: var(--primary);
            padding: 3px 12px; border-radius: 20px; margin-bottom: 16px;
        }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; text-align: left; }
        .info-item { background: var(--bg); border-radius: var(--r-md); padding: 10px 12px; }
        .info-item.full-span { grid-column: 1 / -1; }
        .info-label { display: block; font-size: 10px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
        .info-value { display: block; font-size: 14px; font-weight: 600; color: var(--text-main); }
        .info-email { font-size: 12.5px; word-break: break-all; }

        .profile-upload-section { margin-top: 14px; border-top: 1.5px solid var(--border); padding-top: 12px; }
        .upload-label { font-size: 11px; font-weight: 700; color: var(--text-muted); margin-bottom: 7px; display: flex; align-items: center; gap: 6px; }
        .upload-label i { color: var(--primary); }
        .upload-form { display: flex; gap: 7px; align-items: center; }
        .upload-input { flex: 1; font-size: 11.5px; border: 1.5px solid var(--border); border-radius: var(--r-md); padding: 6px 8px; background: var(--bg); color: var(--text-main); min-width: 0; }
        .upload-input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        .btn-update-photo {
            background: var(--primary); color: #fff; border: none;
            border-radius: var(--r-md); padding: 7px 13px;
            font-size: 12px; font-weight: 700; cursor: pointer;
            font-family: 'DM Sans', sans-serif; flex-shrink: 0;
            transition: filter var(--fast);
        }
        .btn-update-photo:hover { filter: brightness(1.08); }

        /* Sidebar card (enrollment + quick links) */
        .sidebar-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .sidebar-card-header {
            padding: 12px 16px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 9px;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .sidebar-card-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0;
        }
        .sidebar-card-title { font-family: 'Sora', sans-serif; font-size: 12px; font-weight: 700; color: var(--text-main); }
        .sidebar-card-sub   { font-size: 10px; color: var(--text-muted); margin-top: 1px; }
        .sidebar-card-body  { padding: 12px 16px; }

        .enrollment-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 12.5px;
        }
        .enrollment-row:last-child { border-bottom: none; padding-bottom: 0; }
        .enrollment-row-label { color: var(--text-muted); font-weight: 500; }
        .enrollment-row-val   { font-weight: 700; color: var(--text-main); }
        .enrolled-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: var(--success-bg); color: var(--success-dark);
            font-size: 11px; font-weight: 700; padding: 2px 9px; border-radius: 20px;
        }
        .quick-links { display: flex; flex-direction: column; gap: 6px; }
        .quick-link-btn {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: var(--r-md);
            border: 1.5px solid var(--border); background: var(--card-bg);
            color: var(--text-main); font-size: 12.5px; font-weight: 600;
            transition: all var(--fast);
        }
        .quick-link-btn:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary-mid); transform: translateX(3px); }
        .quick-link-btn i { color: var(--primary); font-size: 12px; width: 15px; text-align: center; }

        /* ══════════════════════════════════════
           MAIN COLUMN
        ══════════════════════════════════════ */
        .dash-main { display: flex; flex-direction: column; gap: 16px; min-width: 0; }

        /* Generic content card */
        .content-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .content-card-header {
            padding: 14px 20px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .content-card-left { display: flex; align-items: center; gap: 10px; }
        .content-card-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;
        }
        .content-card-icon.green  { background: var(--success-bg); color: var(--success); }
        .content-card-icon.orange { background: var(--warning-bg); color: var(--warning); }
        .content-card-title { font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 700; color: var(--text-main); }
        .content-card-sub   { font-size: 11px; color: var(--text-muted); margin-top: 1px; }
        .chip {
            font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
            background: var(--primary-light); color: var(--primary);
        }
        .chip.orange { background: var(--warning-bg); color: var(--warning-dark); }

        /* ── Announcements ── */
        .announce-feed { padding: 2px 0; }
        .announce-card {
            display: flex; gap: 13px; padding: 14px 20px;
            border-bottom: 1px solid var(--border);
            animation: slideIn .3s ease both; transition: background var(--fast);
        }
        .announce-card:last-child { border-bottom: none; }
        .announce-card:hover { background: #f6f8ff; }
        @keyframes slideIn { from{opacity:0;transform:translateY(6px)} to{opacity:1;transform:translateY(0)} }

        .announce-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #6c8aff);
            color: #fff; display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }
        .announce-body { flex: 1; min-width: 0; }
        .announce-author { font-size: 12.5px; font-weight: 700; color: var(--text-main); }
        .announce-time   { font-size: 11px; color: var(--text-muted); margin-left: 8px; }
        .new-dot { display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--primary); margin-right: 4px; vertical-align: middle; }
        .announce-text { font-size: 13px; color: var(--text-body); margin-top: 5px; line-height: 1.55; }
        .announce-img-wrap { margin-top: 10px; border-radius: var(--r-md); overflow: hidden; }
        .announce-img { width: 100%; display: block; object-fit: contain; cursor: zoom-in; transition: opacity 0.15s; }
        .announce-img:hover { opacity: 0.88; }

        /* ── Lightbox ── */
        #ann-lightbox {
            display: none; position: fixed; inset: 0; z-index: 9999;
            background: rgba(8,14,30,0.88); backdrop-filter: blur(6px);
            align-items: center; justify-content: center; cursor: zoom-out;
        }
        #ann-lightbox.open { display: flex; }
        #ann-lightbox img {
            max-width: 92vw; max-height: 90vh;
            border-radius: 18px;
            box-shadow: 0 24px 80px rgba(0,0,0,0.6);
            object-fit: contain;
            animation: lb-pop 0.18s ease;
        }
        @keyframes lb-pop { from { transform: scale(0.92); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        #ann-lightbox-close {
            position: fixed; top: 18px; right: 22px;
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.12); border: 1.5px solid rgba(255,255,255,0.22);
            color: #fff; font-size: 16px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        #ann-lightbox-close:hover { background: rgba(255,255,255,0.24); }
        .mention { color: var(--primary); font-weight: 700; background: var(--primary-light); padding: 0 3px; border-radius: 3px; }
        .empty-feed { padding: 44px 20px; text-align: center; color: var(--text-muted); }
        .empty-feed-icon { font-size: 30px; opacity: .15; margin-bottom: 10px; }
        .empty-feed-title { font-family: 'Sora', sans-serif; font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .empty-feed-sub   { font-size: 12.5px; }

        /* ══════════════════════════════════════
           CALENDAR + ATTENDANCE SIDE-BY-SIDE ROW
        ══════════════════════════════════════ */
        .cal-att-row {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
            align-items: start;
        }

        /* Mini calendar card */
        .cal-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .cal-card-header {
            padding: 12px 16px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; gap: 9px;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .cal-card-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--primary-light); color: var(--primary);
            display: flex; align-items: center; justify-content: center; font-size: 11px;
        }
        .cal-card-title { font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text-main); }
        .cal-card-sub   { font-size: 10.5px; color: var(--text-muted); margin-top: 1px; }
        .cal-body { padding: 10px 12px 14px; }

        /* FullCalendar mini overrides */
        #mini-calendar .fc-toolbar            { margin-bottom: 7px !important; }
        #mini-calendar .fc-toolbar-title      { font-family: 'Sora', sans-serif !important; font-size: 12px !important; font-weight: 700 !important; color: var(--text-main) !important; }
        #mini-calendar .fc-button-primary     { background: var(--card-bg) !important; border: 1.5px solid var(--border) !important; color: var(--text-body) !important; border-radius: var(--r-sm) !important; font-size: 10px !important; padding: 3px 8px !important; box-shadow: none !important; text-shadow: none !important; }
        #mini-calendar .fc-button-primary:hover { background: var(--primary-light) !important; border-color: var(--primary) !important; color: var(--primary) !important; }
        #mini-calendar .fc-button-primary:not(:disabled).fc-button-active { background: var(--primary) !important; border-color: var(--primary) !important; color: #fff !important; }
        #mini-calendar .fc-daygrid-day        { min-height: 30px !important; }
        #mini-calendar .fc-daygrid-day-number { font-size: 10px !important; padding: 3px 4px !important; color: var(--text-muted) !important; }
        #mini-calendar .fc-col-header-cell-cushion { font-size: 9px !important; font-weight: 700 !important; text-transform: uppercase; letter-spacing: 0.6px; color: var(--text-muted) !important; padding: 3px 2px !important; }
        #mini-calendar .fc-event             { font-size: 8px !important; padding: 1px 3px !important; border-radius: 4px !important; font-weight: 600 !important; border: none !important; }
        #mini-calendar .fc-daygrid-day.fc-day-today { background: var(--primary-light) !important; }
        #mini-calendar .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { background: var(--primary); color: #fff; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-weight: 700; }
        #mini-calendar .fc-theme-standard td, #mini-calendar .fc-theme-standard th { border-color: var(--border) !important; }

        /* ══════════════════════════════════════
           ATTENDANCE LIST (scrollable, styled
           like the reference image)
        ══════════════════════════════════════ */
        .att-card {
            background: var(--card-bg); border: 1.5px solid var(--border);
            border-radius: var(--r-xl); overflow: hidden; box-shadow: var(--shadow-sm);
        }
        .att-card-header {
            padding: 12px 16px; border-bottom: 1.5px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(to bottom, #f8faff, #f4f6fd);
        }
        .att-card-left { display: flex; align-items: center; gap: 9px; }
        .att-card-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--success-bg); color: var(--success);
            display: flex; align-items: center; justify-content: center; font-size: 11px;
        }
        .att-card-title { font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text-main); }
        .att-card-sub   { font-size: 10.5px; color: var(--text-muted); margin-top: 1px; }

        /* Scrollable list body — max ~4 rows then scroll */
        .att-list-body {
            max-height: 320px;
            overflow-y: auto;
            padding: 6px 0;
        }
        .att-list-body::-webkit-scrollbar { width: 4px; }
        .att-list-body::-webkit-scrollbar-track { background: transparent; }
        .att-list-body::-webkit-scrollbar-thumb { background: #ccd5e8; border-radius: 4px; }

        /* Each attendance row — folder/list style */
        .att-row {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; border-bottom: 1px solid #f0f3f9;
            transition: background var(--fast);
        }
        .att-row:last-child { border-bottom: none; }
        .att-row:hover { background: #f6f8ff; }

        .att-row-icon {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            background: var(--primary-light);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: var(--primary);
        }
        .att-row-info { flex: 1; min-width: 0; }
        .att-row-event {
            font-size: 12.5px; font-weight: 600; color: var(--text-main);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .att-row-meta {
            font-size: 11px; color: var(--text-muted); margin-top: 2px;
            display: flex; align-items: center; gap: 8px;
        }
        .att-row-meta i { font-size: 9px; }
        .att-row-times { text-align: right; flex-shrink: 0; }
        .att-row-timein  { font-size: 11px; font-weight: 600; color: var(--text-body); }
        .att-row-timeout { font-size: 10.5px; color: var(--text-muted); margin-top: 1px; }

        .att-pill {
            font-size: 10.5px; font-weight: 700; padding: 2px 9px;
            border-radius: 20px; flex-shrink: 0;
        }
        .att-pill-present { background: var(--success-bg); color: var(--success-dark); }
        .att-pill-absent  { background: var(--danger-bg);  color: var(--danger); }
        .att-pill-warning { background: var(--warning-bg); color: var(--warning-dark); }

        .att-active-badge {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 10.5px; font-weight: 700; color: var(--success);
        }
        .pulse-dot {
            width: 6px; height: 6px; border-radius: 50%; background: var(--success);
            display: inline-block; animation: pulse 1.5s infinite;
        }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.3)} }

        .att-empty { padding: 36px 16px; text-align: center; color: var(--text-muted); }
        .att-empty i { font-size: 24px; opacity: .15; display: block; margin-bottom: 8px; }
        .att-empty p { font-size: 12.5px; }

        /* ══════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════ */
        @media (max-width: 1200px) { .cal-att-row { grid-template-columns: 1fr 280px; } }
        @media (max-width: 1024px) {
            .dash-grid { grid-template-columns: 1fr; }
            .dash-sidebar { position: static; }
            .cal-att-row { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 700px)  { .cal-att-row { grid-template-columns: 1fr; } }
        @media (max-width: 640px)  {
            .topnav-inner { padding: 0 16px; }
            .topnav-links { display: none; }
            .main-content { padding: 18px 16px 48px; }
            .stats-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════
     TOP NAV — admin-identical dark nav
══════════════════════════════════════════ -->
<nav class="topnav">
    <div class="topnav-inner">

        <a class="topnav-brand" href="#">
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
                <span class="brand-sub">Student Portal</span>
            </div>
        </a>

        <div class="topnav-links">
            <a class="topnav-link active" href="#"><i class="fas fa-home"></i> Dashboard</a>
        </div>

        <div class="topnav-right">
            <?php
                $avatarUrl = (empty($profile_pic) || $profile_pic == 'default.png')
                    ? "https://ui-avatars.com/api/?name=".urlencode($name)."&background=3b5bfc&color=fff&size=68"
                    : base_url('assets/uploads/profile_pics/' . $profile_pic);
            ?>
            <div class="topnav-user">
                <img src="<?= $avatarUrl ?>" class="topnav-avatar" alt="avatar">
                <div>
                    <span class="topnav-name"><?= esc(explode(' ', $name)[0]) ?></span>
                    <span class="topnav-id"><?= esc($id) ?></span>
                </div>
            </div>
            <a href="<?= base_url('logout') ?>" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>

    </div>
</nav>

<!-- ══════════════════════════════════════════
     MAIN CONTENT
══════════════════════════════════════════ -->
<div class="main-content">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">My Dashboard</h1>
            <p class="page-sub">Welcome back, <strong><?= esc(explode(' ', $name)[0]) ?></strong> — here's your overview for today.</p>
        </div>
        <span class="header-date">
            <i class="fas fa-calendar-day"></i>
            <?= date('F d, Y') ?>
        </span>
    </div>

    <!-- Flash messages -->
    <?php if(session()->getFlashdata('msg')): ?>
    <div class="flash-alert flash-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('msg') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
    <div class="flash-alert flash-danger"><i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <!-- ── STAT CARDS ── -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-icon sci-blue"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Total Attendance</div>
                <div class="stat-val"><?= count($attendance_logs ?? []) ?></div>
                <div class="stat-sub"><i class="fas fa-check-circle"></i> Events attended</div>
            </div>
            <div class="stat-card-ring scr-blue"></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon sci-green"><i class="fas fa-calendar-check"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Sessions Completed</div>
                <div class="stat-val"><?= count(array_filter($attendance_logs ?? [], fn($l) => !empty($l['time_out']))) ?></div>
                <div class="stat-sub"><i class="fas fa-check-double"></i> Fully recorded</div>
            </div>
            <div class="stat-card-ring scr-green"></div>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon sci-orange"><i class="fas fa-bullhorn"></i></div>
            <div class="stat-card-body">
                <div class="stat-label">Announcements</div>
                <div class="stat-val"><?= count($announcements ?? []) ?></div>
                <div class="stat-sub"><i class="fas fa-bell"></i> Posted</div>
            </div>
            <div class="stat-card-ring scr-orange"></div>
        </div>
    </div>

    <!-- ── MAIN GRID ── -->
    <div class="dash-grid">

        <!-- SIDEBAR -->
        <div class="dash-sidebar">

            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-banner"></div>
                <div class="profile-body">
                    <div class="profile-img-wrap">
                        <img src="<?= $avatarUrl ?>" class="profile-img" alt="Profile Photo">
                        <div class="verified-dot"><i class="fas fa-check"></i></div>
                    </div>
                    <div class="profile-name"><?= esc($name) ?></div>
                    <div class="profile-id-badge"><?= esc($id) ?></div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Program</span>
                            <span class="info-value"><?= esc($course) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Year Level</span>
                            <span class="info-value"><?= esc($year_level) ?></span>
                        </div>
                        <div class="info-item full-span">
                            <span class="info-label">Email Address</span>
                            <span class="info-value info-email"><?= esc($email) ?></span>
                        </div>
                    </div>
                    <div class="profile-upload-section">
                        <p class="upload-label"><i class="fas fa-camera"></i> Update Profile Photo</p>
                        <form action="<?= base_url('student/upload_pic') ?>" method="post" enctype="multipart/form-data" class="upload-form">
                            <input type="file" name="profile_pic" class="upload-input" accept="image/*" required>
                            <button type="submit" class="btn-update-photo">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enrollment Card -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <div class="sidebar-card-icon"><i class="fas fa-university"></i></div>
                    <div>
                        <div class="sidebar-card-title">Academic Enrollment</div>
                        <div class="sidebar-card-sub">Current academic standing</div>
                    </div>
                </div>
                <div class="sidebar-card-body">
                    <div class="enrollment-row">
                        <span class="enrollment-row-label">Status</span>
                        <span class="enrolled-badge"><i class="fas fa-circle-check"></i> Enrolled</span>
                    </div>
                    <div class="enrollment-row">
                        <span class="enrollment-row-label">Year Level</span>
                        <span class="enrollment-row-val"><?= esc($year_level) ?></span>
                    </div>
                    <div class="enrollment-row">
                        <span class="enrollment-row-label">Semester</span>
                        <span class="enrollment-row-val">2nd Semester</span>
                    </div>
                    <div class="enrollment-row">
                        <span class="enrollment-row-label">School Year</span>
                        <span class="enrollment-row-val">2025–2026</span>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="sidebar-card">
                <div class="sidebar-card-header">
                    <div class="sidebar-card-icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <div class="sidebar-card-title">Quick Navigation</div>
                        <div class="sidebar-card-sub">Jump to a section</div>
                    </div>
                </div>
                <div class="sidebar-card-body">
                    <div class="quick-links">
                        <a href="#" class="quick-link-btn"><i class="fas fa-home"></i> Dashboard Overview</a>
                        <a href="#attendance-section" class="quick-link-btn"><i class="fas fa-clipboard-list"></i> My Attendance Log</a>
                        <a href="#calendar-section" class="quick-link-btn"><i class="fas fa-calendar-alt"></i> School Events</a>
                        <a href="#announcements" class="quick-link-btn"><i class="fas fa-bullhorn"></i> Announcements</a>
                    </div>
                </div>
            </div>

        </div><!-- /dash-sidebar -->

        <!-- MAIN COLUMN -->
        <div class="dash-main">

            <!-- ANNOUNCEMENTS -->
            <div class="content-card" id="announcements">
                <div class="content-card-header">
                    <div class="content-card-left">
                        <div class="content-card-icon orange"><i class="fas fa-bullhorn"></i></div>
                        <div>
                            <div class="content-card-title">Announcements</div>
                            <div class="content-card-sub">Latest updates from your coordinator</div>
                        </div>
                    </div>
                   
                </div>

                <?php if (!empty($announcements)): ?>
                <div class="announce-feed">
                    <?php foreach ($announcements as $i => $post): ?>
                    <div class="announce-card" style="animation-delay:<?= $i * 0.07 ?>s">
                        <div class="announce-avatar"><i class="fas fa-user-shield"></i></div>
                        <div class="announce-body">
                            <div>
                              <span class="ann-post-author">Administrator</span>
                                <span class="ann-post-badge"><i class="fas fa-shield-alt" style="font-size:9px"></i> Admin</span>
                                <span class="announce-time">
                                    <span class="new-dot"></span>
                                    <?= date('M d, Y · h:i A', strtotime($post['created_at'])) ?>
                                </span>
                            </div>
                            <p class="announce-text">
                                <?= preg_replace('/@(\w+)/', '<span class="mention">@$1</span>', esc($post['message'])) ?>
                            </p>
                            <?php if (!empty($post['image_path'])): ?>
                            <div class="announce-img-wrap">
                                <img src="<?= base_url('assets/uploads/announcements/' . $post['image_path']) ?>" class="announce-img" alt="" onclick="openAnnLightbox(this.src)">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="empty-feed">
                    <div class="empty-feed-icon"><i class="fas fa-bell-slash"></i></div>
                    <p class="empty-feed-title">No announcements yet</p>
                    <p class="empty-feed-sub">Your coordinator hasn't posted anything. Check back later.</p>
                </div>
                <?php endif; ?>
            </div>

            <!-- ══ CALENDAR + ATTENDANCE SIDE BY SIDE ══ -->
            <div class="cal-att-row" id="calendar-section">

                <!-- Mini Calendar -->
                <div class="cal-card">
                    <div class="cal-card-header">
                        <div class="cal-card-icon"><i class="fas fa-calendar-day"></i></div>
                        <div>
                            <div class="cal-card-title">School Events</div>
                            <div class="cal-card-sub">Upcoming OJT schedule</div>
                        </div>
                    </div>
                    <div class="cal-body">
                        <div id="mini-calendar"></div>
                    </div>
                </div>

                <!-- Attendance List -->
                <div class="att-card" id="attendance-section">
                    <div class="att-card-header">
                        <div class="att-card-left">
                            <div class="att-card-icon"><i class="fas fa-clipboard-list"></i></div>
                            <div>
                                <div class="att-card-title">My Attendance History</div>
                                <div class="att-card-sub"><?= count($attendance_logs ?? []) ?> record<?= count($attendance_logs ?? []) !== 1 ? 's' : '' ?></div>
                            </div>
                        </div>
                        <span class="chip"><?= count($attendance_logs ?? []) ?></span>
                    </div>

                    <div class="att-list-body">
                        <?php if (!empty($attendance_logs)): ?>
                            <?php foreach ($attendance_logs as $log): ?>
                            <div class="att-row">
                                <div class="att-row-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="att-row-info">
                                    <div class="att-row-event"><?= esc($log['event_title'] ?? 'OJT Session') ?></div>
                                    <div class="att-row-meta">
                                        <span><i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($log['time_in'])) ?></span>
                                        <span>· 1 session</span>
                                    </div>
                                </div>
                                <div class="att-row-times">
                                    <div class="att-row-timein">
                                        <?php if (!empty($log['time_out'])): ?>
                                            <span class="att-pill att-pill-present">Present</span>
                                        <?php else: ?>
                                            <span class="att-active-badge"><span class="pulse-dot"></span> Active</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="att-row-timeout">
                                        <?php if (!empty($log['time_out'])): ?>
                                            <?= date('h:i A', strtotime($log['time_in'])) ?> – <?= date('h:i A', strtotime($log['time_out'])) ?>
                                        <?php else: ?>
                                            In since <?= date('h:i A', strtotime($log['time_in'])) ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="att-empty">
                            <i class="fas fa-inbox"></i>
                            <p>No attendance records found.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div><!-- /cal-att-row -->

        </div><!-- /dash-main -->
    </div><!-- /dash-grid -->
</div><!-- /main-content -->

<div id="ann-lightbox" onclick="closeAnnLightbox()">
    <button id="ann-lightbox-close" onclick="closeAnnLightbox()"><i class="fas fa-times"></i></button>
    <img id="ann-lightbox-img" src="" alt="Full image" onclick="event.stopPropagation()">
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

<!-- Event Info Modal -->
<div class="modal fade" id="eventInfoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px;border:1.5px solid var(--border);overflow:hidden;">
            <div class="modal-header" style="background:linear-gradient(to bottom,#f8faff,#f4f6fd);border-bottom:1.5px solid var(--border);padding:16px 20px;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div id="modal-color-bar" style="width:4px;height:36px;border-radius:4px;flex-shrink:0;background:var(--primary)"></div>
                    <div>
                        <h5 class="modal-title" id="modal-event-title" style="font-family:'Sora',sans-serif;font-size:15px;font-weight:800;color:var(--text-main);margin:0;"></h5>
                        <div id="modal-event-badge" style="margin-top:4px;"></div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="margin-left:auto;"></button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:center;gap:10px;background:var(--bg);border-radius:10px;padding:12px 14px;">
                        <i class="fas fa-clock" style="color:var(--primary);font-size:14px;flex-shrink:0;"></i>
                        <div>
                            <div style="font-size:10.5px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Date & Time</div>
                            <div id="modal-event-date" style="font-size:13px;font-weight:600;color:var(--text-main);margin-top:2px;"></div>
                        </div>
                    </div>
                    <div id="modal-desc-wrap" style="display:flex;align-items:flex-start;gap:10px;background:var(--bg);border-radius:10px;padding:12px 14px;">
                        <i class="fas fa-align-left" style="color:var(--primary);font-size:14px;flex-shrink:0;margin-top:2px;"></i>
                        <div>
                            <div style="font-size:10.5px;color:var(--text-muted);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Notes</div>
                            <div id="modal-event-desc" style="font-size:13px;color:var(--text-body);margin-top:2px;line-height:1.55;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openAnnLightbox(src) {
        document.getElementById('ann-lightbox-img').src = src;
        document.getElementById('ann-lightbox').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeAnnLightbox() {
        document.getElementById('ann-lightbox').classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAnnLightbox();
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var miniEl = document.getElementById('mini-calendar');
    var calendar = new FullCalendar.Calendar(miniEl, {
        initialView: 'dayGridMonth',
        contentHeight: 'auto',
        headerToolbar: { left: 'prev', center: 'title', right: 'next' },
        events: '<?= base_url("student/get_calendar_events") ?>',
        eventClick: function(info) {
            var ev      = info.event;
            var color   = ev.backgroundColor || '#3b5bfc';
            var start   = ev.start;
            var now     = new Date();
            var today   = new Date(); today.setHours(0,0,0,0);
            var evDay   = new Date(start); evDay.setHours(0,0,0,0);

            // Badge
            var badgeHtml = '';
            if (evDay.getTime() === today.getTime()) {
                badgeHtml = '<span style="background:var(--primary-light);color:var(--primary);font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;">Today</span>';
            } else if (start > now) {
                badgeHtml = '<span style="background:var(--warning-bg);color:var(--warning-dark);font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;">Upcoming</span>';
            } else {
                badgeHtml = '<span style="background:#f1f5f9;color:var(--text-muted);font-size:10px;font-weight:700;padding:2px 9px;border-radius:20px;">Past</span>';
            }

            // Format date
            var dateStr = start.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' })
                        + ' · '
                        + start.toLocaleTimeString('en-US', { hour:'numeric', minute:'2-digit', hour12:true });

            // Description
            var desc = ev.extendedProps.description || '';

            document.getElementById('modal-color-bar').style.background = color;
            document.getElementById('modal-event-title').textContent    = ev.title;
            document.getElementById('modal-event-badge').innerHTML      = badgeHtml;
            document.getElementById('modal-event-date').textContent     = dateStr;
            document.getElementById('modal-event-desc').textContent     = desc || 'No additional notes.';
            document.getElementById('modal-desc-wrap').style.display    = desc ? 'flex' : 'none';

            new bootstrap.Modal(document.getElementById('eventInfoModal')).show();
        }
    });
    calendar.render();
});
</script>
</body>
</html>