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
    <div class="admin-header">
        <div>
            <div class="title">Dashboard Admin</div>
            <div class="subtitle">Usahain Management System</div>
        </div>
        <div class="avatar">M</div>
    </div>
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
