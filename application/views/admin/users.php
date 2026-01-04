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
        .admin-header {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 32px 36px 24px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header .title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .admin-header .subtitle {
            font-size: 1.1rem;
            font-weight: 500;
            opacity: .92;
        }
        .admin-header .avatar {
            width: 64px; height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff 0%, #eaf6ff 100%);
            color: var(--primary-dark);
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 700;
            box-shadow: 0 2px 12px rgba(74,144,226,0.10);
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
    <div class="admin-header">
        <div>
            <div class="title">Dashboard Admin</div>
            <div class="subtitle">Usahain Management System</div>
        </div>
        <div class="avatar">M</div>
    </div>
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
