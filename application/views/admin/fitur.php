<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Fitur - Admin Usahain</title>
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
        .feature-stats {
            display: flex;
            gap: 18px;
            margin-bottom: 28px;
        }
        .feature-stat-card {
            background: var(--card-bg);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            padding: 22px 18px;
            min-width: 120px;
            text-align: center;
            flex: 1;
        }
        .feature-stat-card .value {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 4px;
        }
        .feature-stat-card .label {
            font-size: 1rem;
            color: var(--text-secondary);
        }
        .feature-stat-card.green .value { color: #2fb12f; }
        .feature-stat-card.blue .value { color: var(--primary); }
        .feature-stat-card.purple .value { color: #b832e6; }
        .feature-stat-card.orange .value { color: #e67e22; }
        .feature-section {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            padding: 24px 18px;
            margin-bottom: 32px;
        }
        .feature-section .section-label {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }
        .feature-card {
            background: #f7f7f7;
            border-radius: 12px;
            padding: 18px 18px 12px 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
        }
        .feature-card .feature-header {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .feature-card .feature-icon {
            width: 38px; height: 38px;
            border-radius: 8px;
            background: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .feature-card .feature-title {
            font-weight: 700;
            font-size: 1.1rem;
        }
        .feature-card .feature-desc {
            color: var(--text-secondary);
            font-size: 0.98rem;
        }
        .feature-card .feature-switch {
            position: absolute;
            top: 18px; right: 18px;
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
        .feature-card .feature-bar-bg {
            background: #e0e7ef;
            border-radius: 8px;
            height: 10px;
            overflow: hidden;
            margin: 8px 0 2px 0;
        }
        .feature-card .feature-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        .feature-card .feature-usage {
            font-size: 0.98rem;
            color: var(--text-secondary);
            margin-bottom: 2px;
        }
        .feature-card .feature-users {
            font-size: 0.98rem;
            color: var(--text-secondary);
        }
        @media (max-width: 900px) {
            .feature-stats { flex-direction: column; gap: 10px; }
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
                <a href="<?= site_url('admin/fitur'); ?>" class="navbar-link active">Fitur</a>
                <a href="<?= site_url('admin/pengaturan'); ?>" class="navbar-link">Pengaturan</a>
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
        <button class="admin-tab active"><span>� feature</span> Fitur</button>
        <button class="admin-tab"><span>⚙️</span> Pengaturan</button>
    </div>
    <div class="container">
        <div class="section-title">Manajemen Fitur</div>
        <div style="color:var(--text-secondary);margin-bottom:18px;">Kelola dan pantau penggunaan fitur platform</div>
        <div class="feature-stats">
            <div class="feature-stat-card"><div class="value">8</div><div class="label">Total Fitur</div></div>
            <div class="feature-stat-card green"><div class="value">8</div><div class="label">Fitur Aktif</div></div>
            <div class="feature-stat-card blue"><div class="value">47.224</div><div class="label">Total Penggunaan</div></div>
            <div class="feature-stat-card purple"><div class="value">2.266</div><div class="label">Rata-rata User/Fitur</div></div>
        </div>
        <div class="feature-section">
            <div class="section-label"><span>🧩</span> Fitur Inti</div>
            <div class="feature-list">
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">🤖</div>
                        <div>
                            <div class="feature-title">AI Advisor</div>
                            <div class="feature-desc">Rekomendasi bisnis berdasarkan AI</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:80%"></div>
                    </div>
                    <div class="feature-usage">8.540 kali</div>
                    <div class="feature-users">3.245 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">📊</div>
                        <div>
                            <div class="feature-title">Kalkulator HPP</div>
                            <div class="feature-desc">Hitung harga pokok produksi</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:70%"></div>
                    </div>
                    <div class="feature-usage">7.234 kali</div>
                    <div class="feature-users">2.876 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">💰</div>
                        <div>
                            <div class="feature-title">Pencatatan Keuangan</div>
                            <div class="feature-desc">Kelola arus kas dan laporan keuangan</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:90%"></div>
                    </div>
                    <div class="feature-usage">9.128 kali</div>
                    <div class="feature-users">3.654 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">🛡️</div>
                        <div>
                            <div class="feature-title">Manajemen Risiko</div>
                            <div class="feature-desc">Kelola risiko bisnis</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:60%"></div>
                    </div>
                    <div class="feature-usage">5.432 kali</div>
                    <div class="feature-users">1.987 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">📈</div>
                        <div>
                            <div class="feature-title">Analisis Produk</div>
                            <div class="feature-desc">Analisis performa produk</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:75%"></div>
                    </div>
                    <div class="feature-usage">6.891 kali</div>
                    <div class="feature-users">2.456 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">💳</div>
                        <div>
                            <div class="feature-title">Subscription</div>
                            <div class="feature-desc">Kelola langganan premium</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:55%"></div>
                    </div>
                    <div class="feature-usage">4.876 kali</div>
                    <div class="feature-users">2.330 pengguna</div>
                </div>
            </div>
        </div>
        <div class="feature-section">
            <div class="section-label"><span>✨</span> Fitur Premium</div>
            <div class="feature-list">
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">🤖</div>
                        <div>
                            <div class="feature-title">AI Advisor</div>
                            <div class="feature-desc">Rekomendasi bisnis berbasis AI tanpa batas</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:90%"></div>
                    </div>
                    <div class="feature-usage">7.542 kali</div>
                    <div class="feature-users">2.245 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">💰</div>
                        <div>
                            <div class="feature-title">Pencatatan Keuangan</div>
                            <div class="feature-desc">Laporan keuangan otomatis</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:80%"></div>
                    </div>
                    <div class="feature-usage">5.542 kali</div>
                    <div class="feature-users">1.245 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">📊</div>
                        <div>
                            <div class="feature-title">Laporan Analytics</div>
                            <div class="feature-desc">Laporan analisis bisnis lengkap</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:40%"></div>
                    </div>
                    <div class="feature-usage">3.245 kali</div>
                    <div class="feature-users">1.234 pengguna</div>
                </div>
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">👥</div>
                        <div>
                            <div class="feature-title">Konsultasi 1-on-1</div>
                            <div class="feature-desc">Konsultasi bisnis personal</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:20%"></div>
                    </div>
                    <div class="feature-usage">1.876 kali</div>
                    <div class="feature-users">458 pengguna</div>
                </div>
            </div>
        </div>
        <div class="feature-section">
            <div class="section-label"><span>🟩</span> Fitur Rekomendasi Bisnis</div>
            <div class="feature-list">
                <div class="feature-card">
                    <div class="feature-header">
                        <div class="feature-icon">🟩</div>
                        <div>
                            <div class="feature-title">Rekomendasi Informasi Bisnis</div>
                            <div class="feature-desc">Rekomendasi informasi seputar bisnis</div>
                        </div>
                        <div class="feature-switch">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                    <div class="feature-bar-bg">
                        <div class="feature-bar" style="width:75%"></div>
                    </div>
                    <div class="feature-usage">6.891 kali</div>
                    <div class="feature-users">2.543 pengguna</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
