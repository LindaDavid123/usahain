<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$userName = (string) ($this->session->userdata('nama') ?: 'User');
$userEmail = (string) ($this->session->userdata('email') ?: '-');
$avatar = strtoupper(substr($userName, 0, 1));

$margin = (float) $produk->penjualan - (float) $produk->biaya_produksi;
$isProfit = $margin >= 0;
$marginPercent = ((float) $produk->biaya_produksi > 0)
    ? ($margin / (float) $produk->biaya_produksi) * 100
    : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Analisis Produk - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --text: #111827;
            --text-secondary: #6b7280;
            --bg: #f1f5f9;
            --border: #e5e7eb;
            --primary: #1c6494;
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

        .detail-shell {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
        }

        .detail-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .detail-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
        }

        .id-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(31, 107, 153, 0.12);
            color: #1c6494;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .summary-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            padding: 20px;
        }

        .summary-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .summary-value.positive {
            color: #166534;
        }

        .summary-value.negative {
            color: #991b1b;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .info-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            padding: 12px;
        }

        .info-label {
            font-size: 11px;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 13px;
            color: #111827;
            font-weight: 600;
            line-height: 1.5;
        }

        .status {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 600;
        }

        .status.good {
            background: rgba(22, 163, 74, 0.12);
            color: #166534;
        }

        .status.bad {
            background: rgba(220, 38, 38, 0.12);
            color: #991b1b;
        }

        .analysis-box {
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            padding: 14px;
            margin-bottom: 16px;
        }

        .analysis-title {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .analysis-text {
            font-size: 13px;
            color: #111827;
            line-height: 1.65;
            white-space: pre-wrap;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn i,
        .btn svg {
            width: 14px;
            height: 14px;
        }

        .btn-primary {
            background: #1c6494;
            color: #fff;
        }

        .btn-primary:hover {
            background: #175379;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            border: 1.5px solid #e5e7eb;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
            border: 1.5px solid #dc2626;
        }

        .btn-danger:hover {
            background: #b91c1c;
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

            .detail-shell {
                padding: 14px;
            }

            .summary {
                gap: 10px;
                margin-bottom: 14px;
            }

            .summary-card {
                padding: 12px;
            }

            .info-grid {
                gap: 10px;
                margin-bottom: 14px;
            }

            .info-card {
                padding: 10px;
            }

            .analysis-box {
                padding: 12px;
                margin-bottom: 14px;
            }

            .actions {
                gap: 6px;
            }

            .btn {
                padding: 8px 14px;
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

            .detail-shell {
                padding: 12px;
            }

            .summary {
                gap: 8px;
                margin-bottom: 12px;
            }

            .summary-card {
                padding: 10px;
            }

            .info-card {
                padding: 9px;
            }

            .analysis-box {
                padding: 10px;
                margin-bottom: 12px;
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
            <section class="detail-shell">
                <div class="detail-head">
                    <h1 class="detail-title">Detail Analisis Produk</h1>
                    <span class="id-chip"><i data-lucide="hash"></i>ID: <?= (int) $produk->id_produk; ?></span>
                </div>

                <div class="summary">
                    <div class="summary-card">
                        <div class="summary-label">Penjualan</div>
                        <div class="summary-value">Rp <?= number_format($produk->penjualan, 0, ',', '.'); ?></div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Biaya Produksi</div>
                        <div class="summary-value">Rp <?= number_format($produk->biaya_produksi, 0, ',', '.'); ?></div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Margin</div>
                        <div class="summary-value <?= $isProfit ? 'positive' : 'negative'; ?>">Rp <?= number_format($margin, 0, ',', '.'); ?></div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-label">Persentase Margin</div>
                        <div class="summary-value <?= $isProfit ? 'positive' : 'negative'; ?>"><?= number_format($marginPercent, 1); ?>%</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Nama Produk</div>
                        <div class="info-value"><?= htmlspecialchars($produk->nama_produk); ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Tanggal Dibuat</div>
                        <div class="info-value"><?= !empty($produk->created_at) ? date('d M Y', strtotime($produk->created_at)) : '-'; ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Status Produk</div>
                        <div class="info-value">
                            <span class="status <?= $isProfit ? 'good' : 'bad'; ?>"><?= $isProfit ? 'Menguntungkan' : 'Rugi'; ?></span>
                        </div>
                    </div>
                </div>

                <div class="analysis-box">
                    <div class="analysis-title">Analisis Produk</div>
                    <div class="analysis-text"><?= htmlspecialchars($produk->analisis); ?></div>
                </div>

                <div class="actions">
                    <a href="<?= site_url('analisis'); ?>" class="btn btn-secondary">
                        <i data-lucide="arrow-left"></i>
                        Kembali
                    </a>
                    <a href="<?= site_url('analisis/edit/' . $produk->id_produk); ?>" class="btn btn-primary">
                        <i data-lucide="pencil"></i>
                        Edit Data
                    </a>
                    <a href="<?= site_url('analisis/delete/' . $produk->id_produk); ?>" class="btn btn-danger">
                        <i data-lucide="trash-2"></i>
                        Hapus
                    </a>
                </div>
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
