<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Admin Usahain</title>
    <style>
        :root {
            --primary: #4A90E2;
            --primary-dark: #357ABD;
            --primary-light: #6BA4EC;
            --secondary: #7EC8E3;
            --accent: #87CEEB;
            --success: #52D79A;
            --warning: #FFA76C;
            --danger: #F57C7C;
            --bg: #F5F8FA;
            --bg-muted: #EDF2F7;
            --card-bg: #FFFFFF;
            --text: #2D3748;
            --text-secondary: #718096;
            --text-muted: #A0AEC0;
            --border-color: #E2E8F0;
            --shadow-md: 0 4px 12px rgba(74,144,226,0.10);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', Arial, sans-serif; background: var(--bg); color: var(--text); }
        .navbar-main {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 40px;
            height: 70px;
            padding: 0 32px;
        }
        .navbar-left {
            display: flex;
            align-items: center;
            min-width: fit-content;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1c6494;
            font-weight: 800;
            font-size: 22px;
            transition: opacity 0.2s;
        }
        .navbar-brand:hover {
            opacity: 0.8;
        }
        .navbar-logo {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .navbar-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .navbar-center {
            display: flex;
            gap: 32px;
            justify-content: center;
            flex: 1;
            align-items: center;
        }
        .navbar-link {
            position: relative;
            color: #4b5563;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s;
            padding-bottom: 8px;
        }
        .navbar-link:hover {
            color: #1c6494;
        }
        .navbar-link.active {
            color: #1c6494;
            font-weight: 700;
        }
        .navbar-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #1c6494;
            border-radius: 2px;
        }
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: fit-content;
        }
        .navbar-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .navbar-btn.btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }
        .navbar-btn.btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        .navbar-btn.btn-logout {
            background: #dc2626;
            color: #fff;
        }
        .navbar-btn.btn-logout:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }
        .navbar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4a90e2, #6ba4ec);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            transition: transform 0.2s;
        }
        .navbar-avatar:hover {
            transform: scale(1.05);
        }
        @media (max-width: 1024px) {
            .navbar-container {
                gap: 24px;
                padding: 0 24px;
            }
            .navbar-center {
                gap: 20px;
            }
            .navbar-btn {
                padding: 8px 16px;
                font-size: 13px;
            }
            .navbar-link {
                font-size: 13px;
            }
            .navbar-brand {
                font-size: 18px;
            }
        }
        @media (max-width: 768px) {
            .navbar-center {
                gap: 16px;
            }
            .navbar-container {
                gap: 16px;
                padding: 0 16px;
            }
            .navbar-link {
                font-size: 12px;
            }
            .navbar-brand {
                font-size: 16px;
            }
            .navbar-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
            .navbar-avatar {
                width: 38px;
                height: 38px;
                font-size: 14px;
            }
        }
        @media (max-width: 576px) {
            .navbar-container {
                flex-wrap: wrap;
                gap: 10px;
                padding: 10px 12px;
                height: auto;
            }
            .navbar-center {
                order: 3;
                width: 100%;
                gap: 12px;
                margin-top: 8px;
            }
            .navbar-right {
                gap: 8px;
            }
            .navbar-link {
                font-size: 11px;
            }
            .navbar-btn {
                padding: 6px 10px;
                font-size: 11px;
            }
        }
        .admin-tabs {
            margin: 0 auto 32px auto;
            background: var(--card-bg);
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(74,144,226,0.08);
            display: flex;
            justify-content: center;
            gap: 0;
            overflow: hidden;
            max-width: 700px;
        }
        .admin-tab {
            flex: 1;
            padding: 18px 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-secondary);
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .admin-tab.active {
            background: var(--bg-muted);
            color: var(--primary);
            box-shadow: 0 2px 8px rgba(74,144,226,0.10);
        }
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin: 32px 0 18px 0;
        }
        .user-stats {
            display: flex;
            gap: 18px;
            margin-bottom: 28px;
        }
        .user-stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            padding: 22px 18px;
            min-width: 120px;
            text-align: center;
            flex: 1;
        }
        .user-stat-card .value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .user-stat-card .label {
            font-size: 1rem;
            color: var(--text-secondary);
        }
        .user-stat-card.green .value { color: #2fb12f; }
        .user-stat-card.blue .value { color: var(--primary); }
        .user-stat-card.purple .value { color: #b832e6; }
        .user-stat-card.orange .value { color: #e67e22; }
        .user-stat-card.red .value { color: #e74c3c; }
        .user-filters {
            display: flex;
            gap: 18px;
            margin-bottom: 18px;
        }
        .user-filters input[type="text"] {
            flex: 2;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            font-size: 1rem;
            background: var(--card-bg);
        }
        .user-filters select {
            flex: 1;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            font-size: 1rem;
            background: var(--card-bg);
        }
        .user-table-section {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 24px 18px;
            margin-bottom: 32px;
        }
        table.user-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1rem;
        }
        table.user-table th, table.user-table td {
            padding: 12px 8px;
            border-bottom: 1px solid var(--bg-muted);
            text-align: left;
        }
        table.user-table th {
            color: var(--primary-dark);
            font-weight: 700;
            background: var(--bg-muted);
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.95em;
            font-weight: 600;
            margin-right: 2px;
        }
        .badge.green { background: #e6f9ed; color: #2fb12f; }
        .badge.orange { background: #fff5e6; color: #e67e22; }
        .badge.purple { background: #f3e8ff; color: #b832e6; }
        .badge.blue { background: #eaf2ff; color: var(--primary); }
        .badge.red { background: #ffecec; color: #e74c3c; }
        .badge.gray { background: #f4f4f4; color: #888; }
        .badge.black { background: #222; color: #fff; }
        .user-actions {
            display: flex;
            gap: 8px;
        }
        .user-actions button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
            padding: 4px 6px;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .user-actions .edit { color: var(--primary); }
        .user-actions .delete { color: #e74c3c; }
        .user-actions .edit:hover { background: var(--bg-muted); }
        .user-actions .delete:hover { background: #ffecec; }
        @media (max-width: 900px) {
            .user-stats { flex-direction: column; gap: 10px; }
            .user-filters { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
    <nav class="navbar-main">
        <div class="navbar-container">
            <div class="navbar-left">
                <a href="<?= site_url('admin/dashboard'); ?>" class="navbar-brand">
                    <span class="navbar-logo"><img src="<?= base_url('assets/logo_usahain.png'); ?>" alt="Usahain"></span>
                    <span class="navbar-title">Usahain Admin</span>
                </a>
            </div>
            <div class="navbar-center">
                <a href="<?= site_url('admin/dashboard'); ?>" class="navbar-link">Dashboard</a>
                <a href="<?= site_url('admin/users'); ?>" class="navbar-link active">Pengguna</a>
                <a href="<?= site_url('admin/fitur'); ?>" class="navbar-link">Fitur</a>
                <a href="<?= site_url('admin/pengaturan'); ?>" class="navbar-link">Pengaturan</a>
            </div>
            <div class="navbar-right">
                <div class="navbar-avatar"><?= strtoupper(substr($this->session->userdata('nama'),0,1)); ?></div>
                <a href="<?= site_url('auth/logout'); ?>" class="navbar-btn btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </nav>
    <div class="admin-tabs">
        <button class="admin-tab active"><span>📊</span> Overview</button>
        <button class="admin-tab active"><span>👥</span> Pengguna</button>
        <button class="admin-tab active"><span>🧩</span> Fitur</button>
        <button class="admin-tab active"><span>⚙️</span> Pengaturan</button>
    </div>
    <div class="container">
        <div class="section-title">Manajemen Pengguna</div>
        <div style="color:var(--text-secondary);margin-bottom:18px;">Kelola semua pengguna platform Usahain</div>
        <div class="user-stats">
            <div class="user-stat-card"><div class="value">10</div><div class="label">Total Pengguna</div></div>
            <div class="user-stat-card green"><div class="value">9</div><div class="label">Pengguna Aktif</div></div>
            <div class="user-stat-card blue"><div class="value">5</div><div class="label">Usaha Berjalan</div></div>
            <div class="user-stat-card orange"><div class="value">3</div><div class="label">Perencanaan</div></div>
            <div class="user-stat-card purple"><div class="value">5</div><div class="label">Premium</div></div>
            <div class="user-stat-card red"><div class="value">2</div><div class="label">Admin</div></div>
        </div>
        <div class="user-filters">
            <input type="text" placeholder="Cari Pengguna...">
            <select>
                <option>Semua Pengguna</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
                <option>Premium</option>
                <option>Admin</option>
            </select>
        </div>
        <div class="user-table-section">
            <div style="font-weight:700;margin-bottom:12px;">Daftar Pengguna (10)</div>
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Nama Pemilik</th>
                        <th>Nama Usaha</th>
                        <th>Status Usaha</th>
                        <th>Jenis Usaha</th>
                        <th>Role</th>
                        <th>Plan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Budi Santoso<br><span class="badge gray">bud@gmail.com</span></td>
                        <td>Warung Makan Bu Budi</td>
                        <td><span class="badge green">Sudah Berjalan</span></td>
                        <td>Kuliner</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge black">Premium</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Ahmad Wijaja<br><span class="badge gray">ahmad@gmail.com</span></td>
                        <td>Butik Rahayu Fashion</td>
                        <td><span class="badge green">Sudah Berjalan</span></td>
                        <td>Fashion</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge gray">Trial</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Dewi Lestari<br><span class="badge gray">dewi@gmail.com</span></td>
                        <td>warung Mbah Encun</td>
                        <td><span class="badge orange">Sudah Berjalan</span></td>
                        <td>Kuliner</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge black">Premium</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Anwar Joko<br><span class="badge gray">joko@gmail.com</span></td>
                        <td>Mochi Cih</td>
                        <td><span class="badge green">Sudah Berjalan</span></td>
                        <td>Kuliner</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge gray">Trial</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Eko Patrio<br><span class="badge gray">eko@gmail.com</span></td>
                        <td>Martabak 99</td>
                        <td><span class="badge green">Sudah Berjalan</span></td>
                        <td>Kuliner</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge black">Premium</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Maya Sari<br><span class="badge gray">maya@gmail.com</span></td>
                        <td>Jus Segar</td>
                        <td><span class="badge orange">Sudah Berjalan</span></td>
                        <td>Kuliner</td>
                        <td><span class="badge gray">User</span></td>
                        <td><span class="badge gray">Trial</span></td>
                        <td><span class="badge green">Aktif</span></td>
                        <td class="user-actions">
                            <button class="edit" title="Edit"><span>✏️</span></button>
                            <button class="delete" title="Hapus"><span>🗑️</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
