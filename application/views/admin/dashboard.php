<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$admin_user = array_merge([
    'nama' => 'Administrator',
    'email' => 'admin@usahain.com',
], (array)($admin_user ?? []));

$stats = array_merge([
    'total_users' => 0,
    'active_users_today' => 0,
    'active_subscriptions' => 0,
    'total_revenue' => 0,
], (array)($stats ?? []));

$latest_users = $latest_users ?? [];
$recent_activities = $recent_activities ?? [];
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<title>Dashboard Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/dashboard-shared.css'); ?>">

<style>
:root {
    --primary-color: #1F6B99;
    --primary-dark: #154A6F;
    --primary-light: #3A88BA;
    --background: #F8FAFC;
    --background-light: #FFFFFF;
    --text-primary: #1E293B;
    --text-secondary: #64748B;
    --text-muted: #94A3B8;
    --border-color: #E2E8F0;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    font-family: 'Inter', sans-serif;
    background: var(--background);
    color: var(--text-primary);
    line-height: 1.5;
}

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 260px;
    background: #fff;
    border-right: 1px solid var(--border-color);
    display: flex;
    flex-direction: column;
    z-index: 50;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    overflow-y: auto;
}

.sidebar.collapsed {
    width: 80px;
}

.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid var(--border-color);
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: var(--primary-color);
    font-weight: 800;
    font-size: 16px;
}

.sidebar-logo img {
    width: 40px;
    height: 40px;
    border-radius: 8px;
}

.sidebar.collapsed .sidebar-logo-text,
.sidebar.collapsed .sidebar-menu-text,
.sidebar.collapsed .sidebar-menu-badge,
.sidebar.collapsed .sidebar-logout span {
    display: none;
}

.sidebar-menu {
    flex: 1;
    padding: 16px 12px;
    list-style: none;
}

.sidebar-menu-item {
    margin-bottom: 8px;
}

.sidebar-menu-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-secondary);
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 14px;
}

.sidebar-menu-link:hover {
    background: #F1F5F9;
    color: var(--primary-color);
    transform: translateX(4px);
}

.sidebar-menu-link.active {
    background: #1C6494;
    color: #fff;
    font-weight: 600;
}

.sidebar-menu-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

.sidebar-menu-badge {
    margin-left: auto;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.4px;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.32);
    color: #fff;
    padding: 2px 8px;
    border-radius: 999px;
}

.sidebar-footer {
    padding: 12px;
    border-top: 1px solid var(--border-color);
}

.sidebar-logout {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 12px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 600;
    background: #fff;
}

.sidebar-logout:hover {
    background: #F8FAFC;
    color: #334155;
}

.main-wrapper {
    margin-left: 260px;
    flex: 1;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    transition: margin-left 0.3s ease;
}

body.sidebar-collapsed .main-wrapper {
    margin-left: 80px;
}

.top-header {
    background: #fff;
    border-bottom: 1px solid var(--border-color);
    padding: 16px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    position: sticky;
    top: 0;
    z-index: 40;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.header-title {
    font-size: 18px;
    font-weight: 600;
    color: #1c6494;
}

.sidebar-toggle {
    width: 36px;
    height: 36px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: #fff;
    color: var(--text-secondary);
    cursor: pointer;
    display: none;
    align-items: center;
    justify-content: center;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-user {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: inherit;
}

.header-user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #1C6494;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 700;
}

.header-user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.15;
}

.header-user-name {
    font-size: 13px;
    font-weight: 600;
    color: #1E293B;
}

.header-user-email {
    font-size: 12px;
    color: #64748B;
}

.content {
    padding: 24px 32px;
}

.admin-hero {
    background: #1c6494;
    margin-bottom: 22px;
}

.admin-hero .ds-hero-main {
    gap: 8px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 14px;
    margin-bottom: 22px;
}

.stat-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
}

.stat-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 500;
}

.stat-value {
    font-size: 24px;
    line-height: 1.15;
    font-weight: 700;
    color: #111827;
}

.stat-icon {
    width: 18px;
    height: 18px;
    color: #1c6494;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i,
.stat-icon svg {
    width: 18px;
    height: 18px;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 18px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 700;
    color: #1E293B;
    margin-bottom: 14px;
}

.table-wrap {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 520px;
}

.data-table thead th {
    text-align: left;
    padding: 10px 12px;
    font-size: 12px;
    letter-spacing: 0.3px;
    text-transform: uppercase;
    color: #64748B;
    border-bottom: 1px solid #E5E7EB;
}

.data-table tbody td {
    padding: 12px;
    font-size: 13px;
    color: #1E293B;
    border-bottom: 1px solid #F1F5F9;
    vertical-align: top;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 8px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid;
}

.status-badge.active {
    background: #DCFCE7;
    border-color: #BBF7D0;
    color: #166534;
}

.status-badge.inactive {
    background: #F1F5F9;
    border-color: #E2E8F0;
    color: #475569;
}

.empty-row {
    color: #64748B;
    text-align: center;
    font-style: italic;
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 900px) {
    .sidebar {
        transform: translateX(-100%);
        width: 260px;
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .main-wrapper,
    body.sidebar-collapsed .main-wrapper {
        margin-left: 0;
    }

    .sidebar-toggle {
        display: inline-flex;
    }

    .top-header,
    .content {
        padding-left: 16px;
        padding-right: 16px;
    }

    .header-user-info {
        display: none;
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .ds-hero {
        padding: 20px;
    }
}
</style>
</head>

<body>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar(); return false;" class="sidebar-logo" title="Klik untuk buka atau tutup sidebar">
            <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
            <span class="sidebar-logo-text">Usahain</span>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="<?= site_url('admin/dashboard'); ?>" class="sidebar-menu-link active">
                <span class="sidebar-menu-icon"><i data-lucide="layout-grid"></i></span>
                <span class="sidebar-menu-text">Dashboard</span>
                <span class="sidebar-menu-badge">Home</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('admin/users'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="users"></i></span>
                <span class="sidebar-menu-text">Kelola Pengguna</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('admin/subscriptions'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="credit-card"></i></span>
                <span class="sidebar-menu-text">Kelola Langganan</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('admin/reports'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="file-text"></i></span>
                <span class="sidebar-menu-text">Laporan Sistem</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="<?= site_url('auth/logout'); ?>" class="sidebar-logout" onclick="return confirm('Yakin ingin logout?');">
            <i data-lucide="log-out"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

<div class="main-wrapper" id="mainWrapper">
    <header class="top-header">
        <div class="header-left">
            <button class="sidebar-toggle" id="mobileMenuBtn" type="button" onclick="toggleMobileSidebar()">
                <i data-lucide="menu"></i>
            </button>
            <div class="header-title">Dashboard Admin</div>
        </div>

        <div class="header-right">
            <a href="<?= site_url('admin/dashboard'); ?>" class="header-user">
                <div class="header-user-avatar"><?= strtoupper(substr((string) $admin_user['nama'], 0, 1)); ?></div>
                <div class="header-user-info">
                    <div class="header-user-name"><?= htmlspecialchars((string) $admin_user['nama']); ?></div>
                    <div class="header-user-email"><?= htmlspecialchars((string) $admin_user['email']); ?></div>
                </div>
            </a>
        </div>
    </header>

    <main class="content">
        <div class="ds-hero admin-hero">
            <div class="ds-hero-main">
                <h2 class="ds-hero-title">Dashboard Admin</h2>
                <p class="ds-hero-subtitle">Pantau pengguna, langganan, dan aktivitas sistem dalam satu halaman.</p>
            </div>
        </div>

        <section class="stats-grid">
            <article class="stat-card">
                <div class="stat-head">
                    <span class="stat-label">Total Pengguna</span>
                    <span class="stat-icon"><i data-lucide="users"></i></span>
                </div>
                <div class="stat-value"><?= number_format((float) $stats['total_users'], 0, ',', '.'); ?></div>
            </article>

            <article class="stat-card">
                <div class="stat-head">
                    <span class="stat-label">Pengguna Aktif Hari Ini</span>
                    <span class="stat-icon"><i data-lucide="user-check"></i></span>
                </div>
                <div class="stat-value"><?= number_format((float) $stats['active_users_today'], 0, ',', '.'); ?></div>
            </article>

            <article class="stat-card">
                <div class="stat-head">
                    <span class="stat-label">Total Langganan Aktif</span>
                    <span class="stat-icon"><i data-lucide="badge-check"></i></span>
                </div>
                <div class="stat-value"><?= number_format((float) $stats['active_subscriptions'], 0, ',', '.'); ?></div>
            </article>

            <article class="stat-card">
                <div class="stat-head">
                    <span class="stat-label">Total Pendapatan</span>
                    <span class="stat-icon"><i data-lucide="wallet"></i></span>
                </div>
                <div class="stat-value">Rp <?= number_format((float) $stats['total_revenue'], 0, ',', '.'); ?></div>
            </article>
        </section>

        <section class="content-grid">
            <article class="table-card">
                <h3 class="section-title">
                    <i data-lucide="user-plus"></i>
                    <span>Pengguna Terbaru</span>
                </h3>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($latest_users)): ?>
                            <?php foreach ($latest_users as $user_row): ?>
                                <?php $is_active = strtolower((string)($user_row['status'] ?? '')) === 'aktif'; ?>
                                <tr>
                                    <td><?= htmlspecialchars((string)($user_row['nama'] ?? '-')); ?></td>
                                    <td><?= htmlspecialchars((string)($user_row['email'] ?? '-')); ?></td>
                                    <td><?= !empty($user_row['created_at']) ? date('d M Y', strtotime((string) $user_row['created_at'])) : '-'; ?></td>
                                    <td>
                                        <span class="status-badge <?= $is_active ? 'active' : 'inactive'; ?>">
                                            <?= htmlspecialchars((string)($user_row['status'] ?? 'Tidak Aktif')); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="empty-row">Belum ada data pengguna terbaru.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="table-card">
                <h3 class="section-title">
                    <i data-lucide="activity"></i>
                    <span>Aktivitas Terkini</span>
                </h3>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Aktivitas</th>
                                <th>Pelaku</th>
                                <th>Sumber</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($recent_activities)): ?>
                            <?php foreach ($recent_activities as $activity): ?>
                                <tr>
                                    <td><?= htmlspecialchars((string)($activity['activity'] ?? '-')); ?></td>
                                    <td><?= htmlspecialchars((string)($activity['actor'] ?? '-')); ?></td>
                                    <td><?= htmlspecialchars((string)($activity['source'] ?? '-')); ?></td>
                                    <td><?= !empty($activity['activity_time']) ? date('d M Y H:i', strtotime((string) $activity['activity_time'])) : '-'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="empty-row">Belum ada data aktivitas terbaru.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </article>
        </section>
    </main>
</div>

<script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>
<script>
(function() {
    const sidebar = document.getElementById('sidebar');

    window.toggleSidebar = function() {
        if (window.innerWidth <= 900) {
            sidebar.classList.toggle('open');
            return;
        }
        document.body.classList.toggle('sidebar-collapsed');
        sidebar.classList.toggle('collapsed');
    };

    window.toggleMobileSidebar = function() {
        sidebar.classList.toggle('open');
    };

    document.addEventListener('click', function(e) {
        if (window.innerWidth > 900) {
            return;
        }

        const clickedInsideSidebar = sidebar.contains(e.target);
        const clickedToggle = e.target.closest('#mobileMenuBtn');

        if (!clickedInsideSidebar && !clickedToggle) {
            sidebar.classList.remove('open');
        }
    });

    if (window.lucide) {
        window.lucide.createIcons();
    }
})();
</script>

</body>
</html>
