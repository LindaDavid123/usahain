<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$admin_user = array_merge([
    'nama' => 'Administrator',
    'email' => 'admin@usahain.com',
], (array) ($admin_user ?? []));
$summary = array_merge([
    'total_users' => 0,
    'new_users_this_month' => 0,
    'total_transactions' => 0,
    'total_revenue' => 0,
], (array) ($summary ?? []));
$activity_logs = is_array($activity_logs ?? null) ? $activity_logs : [];
$pagination = array_merge([
    'total_rows' => count($activity_logs),
    'from_row' => count($activity_logs) > 0 ? 1 : 0,
    'to_row' => count($activity_logs),
    'current_page' => 1,
    'total_pages' => 1,
    'prev_url' => '',
    'next_url' => '',
    'links' => [],
], (array) ($pagination ?? []));
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<title>Laporan Sistem - Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root { --primary:#1c6494; --text:#111827; --muted:#6b7280; --border:#e5e7eb; --bg:#f8fafc; }
* { box-sizing:border-box; margin:0; padding:0; }
body { font-family:'Inter',sans-serif; background:var(--bg); color:var(--text); display:flex; }
.sidebar { position:fixed; left:0; top:0; width:260px; height:100vh; background:#fff; border-right:1px solid var(--border); display:flex; flex-direction:column; }
.sidebar-header { padding:24px 20px; border-bottom:1px solid var(--border); }
.sidebar-logo { display:flex; align-items:center; gap:12px; text-decoration:none; color:var(--primary); font-size:16px; font-weight:800; }
.sidebar-logo img { width:40px; height:40px; border-radius:8px; }
.sidebar-menu { list-style:none; padding:16px 12px; flex:1; }
.sidebar-menu-item { margin-bottom:8px; }
.sidebar-menu-link { display:flex; align-items:center; gap:10px; padding:12px 14px; border-radius:10px; text-decoration:none; color:var(--muted); font-size:14px; font-weight:500; }
.sidebar-menu-link:hover { background:#f1f5f9; color:var(--primary); }
.sidebar-menu-link.active { background:var(--primary); color:#fff; font-weight:600; }
.sidebar-menu-icon,.sidebar-menu-icon i,.sidebar-menu-icon svg { width:18px; height:18px; }
.sidebar-footer { padding:12px; border-top:1px solid var(--border); }
.sidebar-logout { display:inline-flex; width:100%; justify-content:center; align-items:center; gap:8px; border:1px solid var(--border); border-radius:10px; padding:10px 12px; color:var(--muted); text-decoration:none; font-size:13px; font-weight:600; }

.main-wrapper { margin-left:260px; flex:1; }
.top-header { height:70px; background:#fff; border-bottom:1px solid var(--border); padding:0 24px; display:flex; align-items:center; justify-content:space-between; }
.header-title { font-size:18px; font-weight:600; color:var(--primary); }
.export-btn { text-decoration:none; border:1px solid var(--primary); background:var(--primary); color:#fff; border-radius:8px; padding:8px 12px; font-size:13px; font-weight:600; }
.content { padding:22px 24px; }

.stats-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin-bottom:16px; }
.stat-card { background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px; }
.stat-label { font-size:12px; color:#6b7280; margin-bottom:8px; }
.stat-value { font-size:24px; font-weight:700; color:#111827; }

.table-card { background:#fff; border:1px solid var(--border); border-radius:12px; overflow:hidden; }
.table-wrap { overflow-x:auto; }
.data-table { width:100%; border-collapse:collapse; min-width:760px; }
.data-table th { text-align:left; padding:12px; font-size:12px; text-transform:uppercase; color:var(--muted); letter-spacing:.3px; border-bottom:1px solid var(--border); }
.data-table td { padding:12px; font-size:13px; border-bottom:1px solid #f1f5f9; }
.data-table tbody tr:last-child td { border-bottom:none; }
.empty-row { text-align:center; color:var(--muted); font-style:italic; }

.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px;
    border-top: 1px solid var(--border);
    background: #fff;
}
.pagination-info { font-size: 12px; color: var(--muted); }
.pagination-links { display: flex; align-items: center; gap: 6px; }
.page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    height: 34px;
    padding: 0 10px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #334155;
    text-decoration: none;
    background: #fff;
}
.page-link.active { border-color: var(--primary); background: var(--primary); color: #fff; }
.page-link.disabled { opacity: 0.5; pointer-events: none; }

@media (max-width: 1100px) { .stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
@media (max-width: 680px) { .stats-grid { grid-template-columns:1fr; } }
</style>
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-header">
        <a href="<?= site_url('admin/dashboard'); ?>" class="sidebar-logo">
            <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
            <span>Usahain</span>
        </a>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/dashboard'); ?>" class="sidebar-menu-link"><span class="sidebar-menu-icon"><i data-lucide="layout-grid"></i></span><span>Dashboard</span></a></li>
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/users'); ?>" class="sidebar-menu-link"><span class="sidebar-menu-icon"><i data-lucide="users"></i></span><span>Kelola Pengguna</span></a></li>
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/subscriptions'); ?>" class="sidebar-menu-link"><span class="sidebar-menu-icon"><i data-lucide="credit-card"></i></span><span>Kelola Langganan</span></a></li>
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/reports'); ?>" class="sidebar-menu-link active"><span class="sidebar-menu-icon"><i data-lucide="file-text"></i></span><span>Laporan Sistem</span></a></li>
    </ul>
    <div class="sidebar-footer"><a href="<?= site_url('auth/logout'); ?>" class="sidebar-logout" onclick="return confirm('Yakin ingin logout?');"><i data-lucide="log-out"></i><span>Logout</span></a></div>
</aside>

<div class="main-wrapper">
    <header class="top-header">
        <div class="header-title">Laporan Sistem</div>
        <a href="<?= site_url('admin/reports_export_csv'); ?>" class="export-btn">Export CSV</a>
    </header>

    <main class="content">
        <section class="stats-grid">
            <article class="stat-card"><div class="stat-label">Total Pengguna</div><div class="stat-value"><?= number_format((float) $summary['total_users'], 0, ',', '.'); ?></div></article>
            <article class="stat-card"><div class="stat-label">Pengguna Baru Bulan Ini</div><div class="stat-value"><?= number_format((float) $summary['new_users_this_month'], 0, ',', '.'); ?></div></article>
            <article class="stat-card"><div class="stat-label">Total Transaksi Platform</div><div class="stat-value"><?= number_format((float) $summary['total_transactions'], 0, ',', '.'); ?></div></article>
            <article class="stat-card"><div class="stat-label">Total Pendapatan</div><div class="stat-value">Rp <?= number_format((float) $summary['total_revenue'], 0, ',', '.'); ?></div></article>
        </section>

        <section class="table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($activity_logs)): ?>
                        <?php foreach ($activity_logs as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($row['actor'] ?? '-')); ?></td>
                                <td><?= htmlspecialchars((string) ($row['activity'] ?? '-')); ?></td>
                                <td><?= !empty($row['activity_time']) ? date('d M Y H:i', strtotime((string) $row['activity_time'])) : '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" class="empty-row">Belum ada data aktivitas.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">
                <div class="pagination-info">
                    Menampilkan <?= (int) ($pagination['from_row'] ?? 0); ?>-<?= (int) ($pagination['to_row'] ?? 0); ?> dari <?= (int) ($pagination['total_rows'] ?? 0); ?> data
                </div>
                <div class="pagination-links">
                    <a class="page-link <?= empty($pagination['prev_url']) ? 'disabled' : ''; ?>" href="<?= !empty($pagination['prev_url']) ? htmlspecialchars((string) $pagination['prev_url']) : '#'; ?>">Prev</a>
                    <?php foreach ((array) ($pagination['links'] ?? []) as $link): ?>
                        <a class="page-link <?= !empty($link['active']) ? 'active' : ''; ?>" href="<?= htmlspecialchars((string) ($link['url'] ?? '#')); ?>"><?= htmlspecialchars((string) ($link['label'] ?? '1')); ?></a>
                    <?php endforeach; ?>
                    <a class="page-link <?= empty($pagination['next_url']) ? 'disabled' : ''; ?>" href="<?= !empty($pagination['next_url']) ? htmlspecialchars((string) $pagination['next_url']) : '#'; ?>">Next</a>
                </div>
            </div>
        </section>
    </main>
</div>

<script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>
<script>if (window.lucide) { window.lucide.createIcons(); }</script>
</body>
</html>
