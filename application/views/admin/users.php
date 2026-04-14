<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$admin_user = array_merge([
    'nama' => 'Administrator',
    'email' => 'admin@usahain.com',
], (array) ($admin_user ?? []));

$users = is_array($users ?? null) ? $users : [];
$filters = array_merge([
    'q' => '',
], (array) ($filters ?? []));
$pagination = array_merge([
    'total_rows' => count($users),
    'from_row' => count($users) > 0 ? 1 : 0,
    'to_row' => count($users),
    'current_page' => 1,
    'total_pages' => 1,
    'prev_url' => '',
    'next_url' => '',
    'links' => [],
], (array) ($pagination ?? []));
$return_url = (string) ($return_url ?? site_url('admin/users'));

$flash_success = $this->session->flashdata('success');
$flash_error = $this->session->flashdata('error');
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<title>Kelola Pengguna - Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --primary: #1c6494;
    --text: #111827;
    --text-secondary: #6b7280;
    --border: #e5e7eb;
    --bg: #f8fafc;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; }

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 260px;
    height: 100vh;
    background: #fff;
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
}
.sidebar-header { padding: 24px 20px; border-bottom: 1px solid var(--border); }
.sidebar-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; color: var(--primary); font-weight: 800; font-size: 16px; }
.sidebar-logo img { width: 40px; height: 40px; border-radius: 8px; }
.sidebar-menu { list-style: none; padding: 16px 12px; flex: 1; }
.sidebar-menu-item { margin-bottom: 8px; }
.sidebar-menu-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    border-radius: 10px;
    text-decoration: none;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 500;
}
.sidebar-menu-link:hover { background: #f1f5f9; color: var(--primary); }
.sidebar-menu-link.active { background: var(--primary); color: #fff; font-weight: 600; }
.sidebar-menu-icon,
.sidebar-menu-icon i,
.sidebar-menu-icon svg { width: 18px; height: 18px; }
.sidebar-footer { padding: 12px; border-top: 1px solid var(--border); }
.sidebar-logout {
    display: inline-flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    gap: 8px;
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 10px 12px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.main-wrapper { margin-left: 260px; flex: 1; min-height: 100vh; }
.top-header {
    height: 70px;
    background: #fff;
    border-bottom: 1px solid var(--border);
    padding: 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.header-title { font-size: 18px; font-weight: 600; color: var(--primary); }
.header-user { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: inherit; }
.header-user-avatar { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; }
.header-user-info { line-height: 1.2; }
.header-user-name { font-size: 13px; font-weight: 600; }
.header-user-email { font-size: 12px; color: var(--text-secondary); }

.content { padding: 22px 24px; }
.alert {
    margin-bottom: 16px;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 500;
}
.alert.success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.alert.error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

.toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}
.toolbar h2 { font-size: 16px; font-weight: 700; color: #1e293b; }
.toolbar-right { display: flex; align-items: center; gap: 8px; }
.search-form { display: flex; gap: 8px; width: min(520px, 100%); }
.search-input {
    flex: 1;
    padding: 10px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
}
.search-btn,
.reset-btn {
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}
.search-btn { background: var(--primary); border-color: var(--primary); color: #fff; }
.reset-btn { background: #fff; color: #374151; }
.add-btn {
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: 10px 12px;
    background: #ecfdf5;
    color: #166534;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}

.table-card {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
}
.table-wrap { overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; min-width: 900px; }
.data-table th {
    text-align: left;
    padding: 12px;
    font-size: 12px;
    text-transform: uppercase;
    color: #6b7280;
    border-bottom: 1px solid var(--border);
    letter-spacing: 0.3px;
}
.data-table td {
    padding: 12px;
    font-size: 13px;
    color: #111827;
    border-bottom: 1px solid #f1f5f9;
}
.data-table tbody tr:last-child td { border-bottom: none; }
.badge {
    display: inline-flex;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid;
}
.badge.active { background: #dcfce7; color: #166534; border-color: #bbf7d0; }
.badge.inactive { background: #fee2e2; color: #991b1b; border-color: #fecaca; }

.actions { display: inline-flex; gap: 8px; }
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    background: #fff;
    color: #334155;
    cursor: pointer;
}
.btn.primary { border-color: #bfdbfe; background: #eff6ff; color: #1e40af; }
.btn.warn { border-color: #fecaca; background: #fff1f2; color: #b91c1c; }
.btn.good { border-color: #bbf7d0; background: #ecfdf5; color: #166534; }

.empty-row {
    text-align: center;
    color: #6b7280;
    font-style: italic;
}

.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 12px;
    border-top: 1px solid var(--border);
    background: #fff;
}
.pagination-info { font-size: 12px; color: var(--text-secondary); }
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
.page-link.active {
    border-color: var(--primary);
    background: var(--primary);
    color: #fff;
}
.page-link.disabled {
    opacity: 0.5;
    pointer-events: none;
}
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
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/users'); ?>" class="sidebar-menu-link active"><span class="sidebar-menu-icon"><i data-lucide="users"></i></span><span>Kelola Pengguna</span></a></li>
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/subscriptions'); ?>" class="sidebar-menu-link"><span class="sidebar-menu-icon"><i data-lucide="credit-card"></i></span><span>Kelola Langganan</span></a></li>
        <li class="sidebar-menu-item"><a href="<?= site_url('admin/reports'); ?>" class="sidebar-menu-link"><span class="sidebar-menu-icon"><i data-lucide="file-text"></i></span><span>Laporan Sistem</span></a></li>
    </ul>
    <div class="sidebar-footer">
        <a href="<?= site_url('auth/logout'); ?>" class="sidebar-logout" onclick="return confirm('Yakin ingin logout?');"><i data-lucide="log-out"></i><span>Logout</span></a>
    </div>
</aside>

<div class="main-wrapper">
    <header class="top-header">
        <div class="header-title">Kelola Pengguna</div>
        <a href="<?= site_url('admin/dashboard'); ?>" class="header-user">
            <span class="header-user-avatar"><?= strtoupper(substr((string) $admin_user['nama'], 0, 1)); ?></span>
            <span class="header-user-info">
                <span class="header-user-name"><?= htmlspecialchars((string) $admin_user['nama']); ?></span>
                <span class="header-user-email"><?= htmlspecialchars((string) $admin_user['email']); ?></span>
            </span>
        </a>
    </header>

    <main class="content">
        <?php if (!empty($flash_success)): ?><div class="alert success"><?= htmlspecialchars((string) $flash_success); ?></div><?php endif; ?>
        <?php if (!empty($flash_error)): ?><div class="alert error"><?= htmlspecialchars((string) $flash_error); ?></div><?php endif; ?>

        <section class="toolbar">
            <h2>Daftar Seluruh Pengguna</h2>
            <div class="toolbar-right">
                <form method="get" class="search-form">
                    <input type="text" name="q" class="search-input" value="<?= htmlspecialchars((string) $filters['q']); ?>" placeholder="Cari nama atau email...">
                    <button type="submit" class="search-btn">Cari</button>
                    <a href="<?= site_url('admin/users'); ?>" class="reset-btn">Reset</a>
                </form>
                <a href="<?= site_url('admin/create_user') . '?return=' . rawurlencode($return_url); ?>" class="add-btn">Tambah Pengguna</a>
            </div>
        </section>

        <section class="table-card">
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th>Paket</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) ($row['nama'] ?? '-')); ?></td>
                                <td><?= htmlspecialchars((string) ($row['email'] ?? '-')); ?></td>
                                <td><?= !empty($row['created_at']) ? date('d M Y', strtotime((string) $row['created_at'])) : '-'; ?></td>
                                <td><?= htmlspecialchars((string) ($row['paket'] ?? '-')); ?></td>
                                <td>
                                    <span class="badge <?= !empty($row['is_active']) ? 'active' : 'inactive'; ?>">
                                        <?= htmlspecialchars((string) ($row['status_label'] ?? 'Aktif')); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="actions">
                                        <a class="btn primary" href="<?= site_url('admin/user_detail/' . (int) ($row['id_user'] ?? 0)) . '?return=' . rawurlencode($return_url); ?>">Lihat Detail</a>
                                        <?php if ((string) ($row['role'] ?? '') !== 'admin'): ?>
                                            <form method="post" action="<?= site_url('admin/toggle_user_status/' . (int) ($row['id_user'] ?? 0)); ?>?q=<?= rawurlencode((string) $filters['q']); ?>&page=<?= (int) ($pagination['current_page'] ?? 1); ?>" style="display:inline;">
                                                <button class="btn <?= !empty($row['is_active']) ? 'warn' : 'good'; ?>" type="submit">
                                                    <?= !empty($row['is_active']) ? 'Nonaktifkan' : 'Aktifkan'; ?>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="btn" style="cursor:default;opacity:0.7;">Admin</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="empty-row">Tidak ada data pengguna.</td></tr>
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
<script>
if (window.lucide) { window.lucide.createIcons(); }
</script>
</body>
</html>
