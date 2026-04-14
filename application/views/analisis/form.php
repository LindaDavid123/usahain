<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$isEdit = isset($produk);
$userName = (string) ($this->session->userdata('nama') ?: 'User');
$userEmail = (string) ($this->session->userdata('email') ?: '-');
$avatar = strtoupper(substr($userName, 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Analisis Produk' : 'Tambah Analisis Produk Baru'; ?> - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #1c6494;
            --primary-dark: #175379;
            --text: #111827;
            --text-secondary: #6b7280;
            --label: #374151;
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e5e7eb;
            --danger: #dc2626;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 260px;
            background: #fff;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 999;
            transition: all 0.3s;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1f6b99;
            font-size: 16px;
            font-weight: 800;
            white-space: nowrap;
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            list-style: none;
        }

        .sidebar-menu-item {
            margin-bottom: 8px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .sidebar-menu-link:hover {
            background: var(--bg);
            color: #1f6b99;
            transform: translateX(4px);
        }

        .sidebar-menu-link.active {
            background: linear-gradient(135deg, #1f6b99 0%, #3a88ba 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.25);
        }

        .sidebar-menu-icon,
        .sidebar-menu-icon i,
        .sidebar-menu-icon svg {
            display: none;
            width: 18px;
            height: 18px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .sidebar-menu-badge {
            margin-left: auto;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(31, 107, 153, 0.1);
            color: #1f6b99;
            transition: all 0.3s;
        }

        .sidebar-menu-link:hover .sidebar-menu-badge {
            background: rgba(31, 107, 153, 0.2);
        }

        .sidebar-menu-link.active .sidebar-menu-badge {
            background: #1c6494;
            color: #fff;
        }

        body.sidebar-collapsed .sidebar-logo-text,
        body.sidebar-collapsed .sidebar-menu-text,
        body.sidebar-collapsed .sidebar-menu-badge {
            display: none;
        }

        .main-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: margin-left 0.3s ease, width 0.3s ease;
        }

        body.sidebar-collapsed .main-wrapper {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        .top-header {
            height: 70px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .header-left,
        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sidebar-toggle {
            width: 34px;
            height: 34px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: #4b5563;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .header-title {
            font-size: 18px;
            font-weight: 600;
            color: #1c6494;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s;
        }

        .header-user:hover {
            background: rgba(31, 107, 153, 0.08);
        }

        .header-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1f6b99 0%, #7ec8e3 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
        }

        .header-user-info {
            display: flex;
            flex-direction: column;
        }

        .header-user-name {
            font-size: 13px;
            color: #111827;
            font-weight: 600;
            line-height: 1.2;
        }

        .header-user-email {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.2;
        }

        .content {
            padding: 40px 32px;
        }

        .form-shell {
            max-width: 480px;
            width: 100%;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .form-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .back-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            background: #f3f4f6;
            color: #4b5563;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            flex-shrink: 0;
        }

        .back-icon:hover {
            background: #e5e7eb;
        }

        .back-icon i,
        .back-icon svg {
            width: 16px;
            height: 16px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
            line-height: 1.25;
        }

        .validation-errors {
            margin-bottom: 14px;
            border: 1px solid #fecaca;
            background: #fef2f2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12px;
            line-height: 1.5;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 500;
            color: #374151;
        }

        .form-control {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            color: #111827;
            background: #fff;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #1c6494;
            box-shadow: 0 0 0 3px rgba(28, 100, 148, 0.1);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 8px;
            background: #1c6494;
            color: #fff;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #175379;
        }

        @media (max-width: 1024px) {
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: inline-flex;
            }
        }

        @media (max-width: 767px) {
            .top-header {
                padding: 16px 20px;
                height: 60px;
            }

            .header-left {
                gap: 12px;
            }

            .header-title {
                font-size: 16px;
            }

            .content {
                padding: 20px 16px;
            }

            .form-shell {
                padding: 14px;
            }

            .form-header {
                margin-bottom: 14px;
            }

            .form-group {
                margin-bottom: 12px;
            }

            .header-user-info {
                display: none;
            }
        }

        @media (max-width: 479px) {
            .top-header {
                padding: 12px 16px;
                height: 56px;
            }

            .header-title {
                font-size: 14px;
            }

            .header-right {
                gap: 8px;
            }

            .content {
                padding: 16px 12px;
            }

            .form-shell {
                padding: 12px;
            }

            .form-header {
                margin-bottom: 12px;
            }

            .form-group {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" onclick="toggleSidebar(); return false;" class="sidebar-logo" title="Klik untuk buka/tutup sidebar">
                <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
                <span class="sidebar-logo-text">Usahain</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="<?= site_url('auth/dashboard'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="layout-grid"></i></span>
                    <span class="sidebar-menu-text">Dashboard</span>
                    <span class="sidebar-menu-badge">Home</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('advisor'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="sparkles"></i></span>
                    <span class="sidebar-menu-text">AI Advisor</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('hpp'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="calculator"></i></span>
                    <span class="sidebar-menu-text">Kalkulator HPP</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('keuangan'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="wallet"></i></span>
                    <span class="sidebar-menu-text">Pencatatan Keuangan</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('risiko'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="shield-alert"></i></span>
                    <span class="sidebar-menu-text">Manajemen Risiko</span>
                </a>
            </li>
            <li class="sidebar-menu-item">
                <a href="<?= site_url('auth/info_bisnis'); ?>" class="sidebar-menu-link">
                    <span class="sidebar-menu-icon"><i data-lucide="book-open"></i></span>
                    <span class="sidebar-menu-text">Informasi Bisnis</span>
                </a>
            </li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="top-header">
            <div class="header-left">
                <button class="sidebar-toggle" id="mobileMenuBtn" type="button" aria-label="Menu">
                    <i data-lucide="menu"></i>
                </button>
                <div class="header-title">Analisis Produk</div>
            </div>
            <div class="header-right">
                <a href="<?= site_url('user/profile'); ?>" class="header-user">
                    <div class="header-user-avatar"><?= htmlspecialchars($avatar); ?></div>
                    <div class="header-user-info">
                        <div class="header-user-name"><?= htmlspecialchars($userName); ?></div>
                        <div class="header-user-email"><?= htmlspecialchars($userEmail); ?></div>
                    </div>
                </a>
            </div>
        </header>

        <main class="content">
            <section class="form-shell">
                <div class="form-header">
                    <a href="<?= site_url('analisis'); ?>" class="back-icon" aria-label="Kembali ke daftar">
                        <i data-lucide="arrow-left"></i>
                    </a>
                    <h1 class="form-title"><?= $isEdit ? 'Edit Analisis Produk' : 'Tambah Analisis Produk Baru'; ?></h1>
                </div>

                <?php if (validation_errors()): ?>
                    <div class="validation-errors">
                        <?= validation_errors(); ?>
                    </div>
                <?php endif; ?>

                <form method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input
                            type="text"
                            id="nama_produk"
                            name="nama_produk"
                            class="form-control"
                            placeholder="Contoh: Nasi Goreng Spesial"
                            value="<?= $isEdit ? htmlspecialchars($produk->nama_produk) : set_value('nama_produk'); ?>"
                            autofocus
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="penjualan">Penjualan</label>
                        <input
                            type="number"
                            id="penjualan"
                            name="penjualan"
                            class="form-control"
                            step="1"
                            min="0"
                            placeholder="50000"
                            value="<?= $isEdit ? (float) $produk->penjualan : set_value('penjualan'); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="biaya_produksi">Biaya Produksi</label>
                        <input
                            type="number"
                            id="biaya_produksi"
                            name="biaya_produksi"
                            class="form-control"
                            step="1"
                            min="0"
                            placeholder="25000"
                            value="<?= $isEdit ? (float) $produk->biaya_produksi : set_value('biaya_produksi'); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="analisis">Analisis Produk</label>
                        <textarea
                            id="analisis"
                            name="analisis"
                            class="form-control"
                            placeholder="Deskripsikan keunggulan dan strategi produk ini"
                            required
                        ><?= $isEdit ? htmlspecialchars($produk->analisis) : set_value('analisis'); ?></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Simpan Analisis</button>
                </form>
            </section>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            if (window.innerWidth <= 1024) {
                return;
            }

            document.body.classList.toggle('sidebar-collapsed');
            document.getElementById('sidebar').classList.toggle('collapsed');
        }

        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        function updateResponsiveSidebar() {
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('collapsed');
                document.body.classList.remove('sidebar-collapsed');
                mobileMenuBtn.style.display = 'inline-flex';
            } else {
                sidebar.classList.remove('mobile-open');
                mobileMenuBtn.style.display = 'none';
            }
        }

        mobileMenuBtn.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-open');
        });

        document.querySelectorAll('.sidebar-menu-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });

        window.addEventListener('resize', updateResponsiveSidebar);
        updateResponsiveSidebar();

        if (window.lucide) {
            window.lucide.createIcons();
        }
    </script>
</body>
</html>
