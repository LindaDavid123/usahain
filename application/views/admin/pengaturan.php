<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sistem - Admin Usahain</title>
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
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 16px 32px 16px;
        }
        .section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary);
            margin: 32px 0 18px 0;
        }
        .setting-section {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 28px 22px 22px 22px;
            margin-bottom: 32px;
        }
        .setting-label {
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 1.08rem;
        }
        .setting-group {
            margin-bottom: 18px;
        }
        .setting-input, .setting-textarea {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1.5px solid var(--border-color);
            font-size: 1rem;
            background: var(--bg-muted);
            margin-bottom: 10px;
        }
        .setting-switch-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-muted);
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 10px;
        }
        .setting-switch-label {
            font-weight: 500;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .switch input { display: none; }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #ccc;
            border-radius: 24px;
            transition: .4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: .4s;
        }
        input:checked + .slider {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        input:checked + .slider:before {
            transform: translateX(20px);
        }
        .setting-btn-row {
            display: flex;
            gap: 18px;
            margin-top: 18px;
        }
        .btn {
            padding: 14px 0;
            border-radius: 10px;
            border: none;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            flex: 1;
            transition: background 0.2s;
        }
        .btn-primary {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            color: #fff;
        }
        .btn-secondary {
            background: #fff;
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }
        .api-status {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 8px;
            background: #e6f9ed;
            color: #2fb12f;
            font-size: 1rem;
            font-weight: 700;
            margin-left: 10px;
        }
        @media (max-width: 900px) {
            .container { padding: 0 4px 32px 4px; }
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
                <a href="<?= site_url('admin/users'); ?>" class="navbar-link">Pengguna</a>
                <a href="<?= site_url('admin/fitur'); ?>" class="navbar-link">Fitur</a>
                <a href="<?= site_url('admin/pengaturan'); ?>" class="navbar-link active">Pengaturan</a>
            </div>
            <div class="navbar-right">
                <div class="navbar-avatar"><?= strtoupper(substr($this->session->userdata('nama'),0,1)); ?></div>
                <a href="<?= site_url('auth/logout'); ?>" class="navbar-btn btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
            </div>
        </div>
    </nav>
    <div class="admin-tabs">
        <button class="admin-tab"><span>📊</span> Overview</button>
        <button class="admin-tab"><span>👥</span> Pengguna</button>
        <button class="admin-tab"><span>🧩</span> Fitur</button>
        <button class="admin-tab active"><span>⚙️</span> Pengaturan</button>
    </div>
    <div class="container">
        <div class="section-title">Pengaturan Sistem</div>
        <div style="color:var(--text-secondary);margin-bottom:18px;">Konfigurasi sistem dan platform</div>
        <div class="setting-section">
            <div class="setting-label">Pengaturan Umum</div>
            <div class="setting-group">
                <input class="setting-input" type="text" value="Usahain" readonly placeholder="Nama Platform">
            </div>
            <div class="setting-group">
                <input class="setting-input" type="email" value="support@usahain.com" readonly placeholder="Email Support">
            </div>
            <div class="setting-group">
                <input class="setting-input" type="number" value="18000" readonly placeholder="Harga Premium (Rp/bulan)">
            </div>
        </div>
        <div class="setting-section">
            <div class="setting-label">Status Sistem</div>
            <div class="setting-switch-row">
                <span class="setting-switch-label">Mode Maintenance<br><span style="font-weight:400;color:var(--text-secondary);font-size:0.97em">Nonaktifkan akses sementara untuk maintenance</span></span>
                <label class="switch"><input type="checkbox"><span class="slider"></span></label>
            </div>
            <div class="setting-switch-row">
                <span class="setting-switch-label">Izinkan Registrasi<br><span style="font-weight:400;color:var(--text-secondary);font-size:0.97em">Pengguna baru dapat mendaftar</span></span>
                <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
            </div>
            <div class="setting-switch-row">
                <span class="setting-switch-label">Notifikasi Email<br><span style="font-weight:400;color:var(--text-secondary);font-size:0.97em">Kirim notifikasi via email ke pengguna</span></span>
                <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
            </div>
            <div class="setting-switch-row">
                <span class="setting-switch-label">Analytics Tracking<br><span style="font-weight:400;color:var(--text-secondary);font-size:0.97em">Aktifkan pelacakan analytics</span></span>
                <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
            </div>
        </div>
        <div class="setting-section">
            <div class="setting-label">Keamanan</div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">Password Policy</div>
                <div style="color:var(--text-secondary);font-size:0.98em;">
                    Minimum 8 karakter<br>
                    Harus mengandung huruf besar dan kecil<br>
                    Harus mengandung angka<br>
                    Password expiry: 90 hari
                </div>
            </div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">Session Management</div>
                <div style="color:var(--text-secondary);font-size:0.98em;">
                    Session timeout: 30 menit<br>
                    Max concurrent sessions: 3<br>
                    Auto logout setelah inaktif
                </div>
            </div>
            <button class="setting-input" style="background:#eee;font-weight:700;cursor:pointer;">Reset Semua Password</button>
        </div>
        <div class="setting-section">
            <div class="setting-label">Notifikasi & Email</div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">Welcome Email Template</div>
                <textarea class="setting-textarea" rows="2" readonly>Selamat datang di Usahain! Terima kasih telah bergabung...</textarea>
            </div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">Premium Upgrade Email</div>
                <textarea class="setting-textarea" rows="2" readonly>Terima kasih telah upgrade ke Premium! Nikmati fitur eksklusif...</textarea>
            </div>
            <button class="setting-input" style="background:#eee;font-weight:700;cursor:pointer;">Test Email</button>
        </div>
        <div class="setting-section">
            <div class="setting-label">API & Integrasi</div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">API Status <span class="api-status">Aktif</span></div>
                <div style="color:var(--text-secondary);font-size:0.98em;">
                    API Version: v2.1.0<br>
                    Rate Limit: 1000 request/hour
                </div>
            </div>
            <div class="setting-group">
                <div style="margin-bottom:8px;font-weight:500;">API Key</div>
                <input class="setting-input" type="text" value="................................................................." readonly>
            </div>
            <div class="setting-btn-row">
                <button class="btn btn-secondary">API Document</button>
                <button class="btn btn-secondary">Generate New Key</button>
            </div>
        </div>
        <div class="setting-btn-row">
            <button class="btn btn-secondary">Batal</button>
            <button class="btn btn-primary">Simpan Pengaturan</button>
        </div>
    </div>
</body>
</html>
