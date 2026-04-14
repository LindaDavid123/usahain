<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$userName = (string) ($this->session->userdata('nama') ?: 'User');
$userEmail = (string) ($this->session->userdata('email') ?: '-');
$avatar = strtoupper(substr($userName, 0, 1));

$hasHppData = !empty($has_hpp_data);
$produkComparison = $produk_comparison ?? [];
$summaryData = $summary ?? [];
$produkTerlaris = $summaryData['produk_terlaris'] ?? null;
$produkPalingMenguntungkan = $summaryData['produk_paling_menguntungkan'] ?? null;
$produkPerluPerhatian = $summaryData['produk_perlu_perhatian'] ?? null;
$totalProdukAktif = (int) ($summaryData['total_produk_aktif'] ?? 0);

$chartLabels = json_encode(array_values($chart['labels'] ?? []), JSON_UNESCAPED_UNICODE);
$chartValues = json_encode(array_values($chart['values'] ?? []));
$rekomendasiItems = $rekomendasi ?? [];

$toastSuccess = (string) ($toast_success ?? '');
$toastInfo = (string) ($toast_info ?? '');
$toastMessage = $toastSuccess !== '' ? $toastSuccess : $toastInfo;
$toastClass = $toastSuccess !== '' ? 'success' : 'info';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Produk - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1c6494;
            --primary-dark: #175379;
            --text: #111827;
            --text-secondary: #6b7280;
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e5e7eb;
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #d97706;
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

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 20px;
        }

        .metric-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
        }

        .metric-head {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
            color: #6b7280;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .metric-head i,
        .metric-head svg {
            width: 14px;
            height: 14px;
            color: #1c6494;
        }

        .metric-main {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            line-height: 1.4;
        }

        .metric-sub {
            margin-top: 4px;
            font-size: 12px;
            color: #6b7280;
        }

        .panel {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
        }

        .table-wrap {
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            text-align: left;
            padding: 10px 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        th {
            font-size: 12px;
            font-weight: 600;
            color: #374151;
            background: #f8fafc;
            white-space: nowrap;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .money {
            font-weight: 600;
            white-space: nowrap;
        }

        .money.positive {
            color: #166534;
        }

        .money.negative {
            color: #991b1b;
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

        .trend {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border-radius: 999px;
            padding: 3px 9px;
            font-size: 11px;
            font-weight: 600;
        }

        .trend.up {
            background: rgba(22, 163, 74, 0.12);
            color: #166534;
        }

        .trend.down {
            background: rgba(220, 38, 38, 0.12);
            color: #991b1b;
        }

        .trend.stable {
            background: rgba(107, 114, 128, 0.14);
            color: #374151;
        }

        .trend i,
        .trend svg {
            width: 12px;
            height: 12px;
        }

        .source-badge {
            display: inline;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
            color: #9ca3af;
        }

        .source-badge.hpp {
            color: #9ca3af;
        }

        .source-badge.mix {
            color: #9ca3af;
        }

        .chart-wrap {
            height: 220px;
            max-height: 220px;
        }

        .recommend-list {
            display: grid;
            gap: 12px;
        }

        .recommend-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .recommend-icon,
        .recommend-icon i,
        .recommend-icon svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .recommend-icon.positive {
            color: #16a34a;
        }

        .recommend-icon.warning {
            color: #ef4444;
        }

        .recommend-text {
            font-size: 13px;
            color: #374151;
            line-height: 1.6;
        }

        .recommend-title {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
        }

        .empty-state {
            border: 1px dashed #d1d5db;
            border-radius: 12px;
            padding: 36px 20px;
            text-align: center;
            background: #fff;
        }

        .empty-icon {
            width: 44px;
            height: 44px;
            color: #9ca3af;
            margin: 0 auto 12px;
        }

        .empty-title {
            font-size: 15px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .empty-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 14px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #1c6494;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #175379;
        }

        .btn-primary i,
        .btn-primary svg {
            width: 14px;
            height: 14px;
        }

        .toast {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 1200;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 500;
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
            transition: opacity 0.2s ease, transform 0.2s ease;
        }

        .toast.success {
            background: #16a34a;
            color: #fff;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.28);
        }

        .toast.info {
            background: #1c6494;
            color: #fff;
            box-shadow: 0 8px 20px rgba(28, 100, 148, 0.26);
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
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

            .panel,
            .metric-card {
                padding: 14px;
            }

            .metrics-grid {
                gap: 10px;
            }

            .header-user-info {
                display: none;
            }

            th,
            td {
                padding: 8px 10px;
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

            .panel,
            .metric-card {
                padding: 12px;
            }

            .metrics-grid {
                gap: 8px;
            }

            .empty-state {
                padding: 20px 12px;
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
            <?php if (!$hasHppData): ?>
                <section class="empty-state">
                    <i data-lucide="package-search" class="empty-icon"></i>
                    <div class="empty-title">Belum ada data produk. Tambahkan data di Kalkulator HPP terlebih dahulu.</div>
                    <div class="empty-subtitle">Analisis otomatis akan muncul setelah Anda memiliki data produk di Kalkulator HPP.</div>
                    <a href="<?= site_url('hpp'); ?>" class="btn-primary">
                        <i data-lucide="calculator"></i>
                        Buka Kalkulator HPP
                    </a>
                </section>
            <?php else: ?>
                <section class="metrics-grid">
                    <article class="metric-card">
                        <div class="metric-head"><i data-lucide="trending-up"></i>Produk Terlaris</div>
                        <div class="metric-main"><?= $produkTerlaris ? htmlspecialchars($produkTerlaris['nama_produk']) : '-'; ?></div>
                        <div class="metric-sub">
                            <?= $produkTerlaris ? 'Penjualan: Rp ' . number_format((float) $produkTerlaris['total_penjualan'], 0, ',', '.') : 'Belum ada data'; ?>
                        </div>
                    </article>

                    <article class="metric-card">
                        <div class="metric-head"><i data-lucide="award"></i>Produk Paling Menguntungkan</div>
                        <div class="metric-main"><?= $produkPalingMenguntungkan ? htmlspecialchars($produkPalingMenguntungkan['nama_produk']) : '-'; ?></div>
                        <div class="metric-sub">
                            <?= $produkPalingMenguntungkan ? 'Margin: Rp ' . number_format((float) $produkPalingMenguntungkan['margin'], 0, ',', '.') : 'Belum ada data'; ?>
                        </div>
                    </article>

                    <article class="metric-card">
                        <div class="metric-head"><i data-lucide="alert-triangle"></i>Produk Perlu Perhatian</div>
                        <div class="metric-main"><?= $produkPerluPerhatian ? htmlspecialchars($produkPerluPerhatian['nama_produk']) : '-'; ?></div>
                        <div class="metric-sub">
                            <?= $produkPerluPerhatian ? 'Margin: Rp ' . number_format((float) $produkPerluPerhatian['margin'], 0, ',', '.') : 'Belum ada data'; ?>
                        </div>
                    </article>

                    <article class="metric-card">
                        <div class="metric-head"><i data-lucide="package"></i>Total Produk Aktif</div>
                        <div class="metric-main"><?= number_format($totalProdukAktif, 0, ',', '.'); ?> Produk</div>
                        <div class="metric-sub">Terdata dari Kalkulator HPP</div>
                    </article>
                </section>

                <section class="panel">
                    <h2 class="panel-title">Perbandingan Performa Antar Produk</h2>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Sumber Data</th>
                                    <th>Total Penjualan</th>
                                    <th>Biaya Produksi</th>
                                    <th>Margin</th>
                                    <th>Status</th>
                                    <th>Tren</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produkComparison as $item): ?>
                                    <?php
                                    $marginPositive = (float) $item['margin'] >= 0;
                                    $trendClass = $item['trend_direction'] === 'up'
                                        ? 'up'
                                        : ($item['trend_direction'] === 'down' ? 'down' : 'stable');
                                    $trendIcon = $item['trend_direction'] === 'up'
                                        ? 'trending-up'
                                        : ($item['trend_direction'] === 'down' ? 'trending-down' : 'minus');
                                    $sourceType = isset($item['sumber_data_type']) ? $item['sumber_data_type'] : 'hpp';
                                    $sourceLabel = isset($item['sumber_data_label']) ? $item['sumber_data_label'] : 'Data HPP saja';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['nama_produk']); ?></td>
                                        <td>
                                            <span class="source-badge <?= $sourceType === 'mix' ? 'mix' : 'hpp'; ?>">
                                                <?= htmlspecialchars($sourceLabel); ?>
                                            </span>
                                        </td>
                                        <td class="money">Rp <?= number_format((float) $item['total_penjualan'], 0, ',', '.'); ?></td>
                                        <td class="money">Rp <?= number_format((float) $item['biaya_produksi'], 0, ',', '.'); ?></td>
                                        <td class="money <?= $marginPositive ? 'positive' : 'negative'; ?>">Rp <?= number_format((float) $item['margin'], 0, ',', '.'); ?></td>
                                        <td>
                                            <span class="status <?= $marginPositive ? 'good' : 'bad'; ?>">
                                                <?= htmlspecialchars($item['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="trend <?= $trendClass; ?>">
                                                <i data-lucide="<?= $trendIcon; ?>"></i>
                                                <?php if ((float) $item['trend_percentage'] > 0): ?>
                                                    <?= htmlspecialchars($item['trend_label']); ?> (<?= number_format((float) $item['trend_percentage'], 1); ?>%)
                                                <?php else: ?>
                                                    <?= htmlspecialchars($item['trend_label']); ?>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="panel">
                    <h2 class="panel-title">Grafik Perbandingan Penjualan Antar Produk</h2>
                    <div class="chart-wrap">
                        <canvas id="penjualanProdukChart"></canvas>
                    </div>
                </section>

                <section class="panel">
                    <h2 class="panel-title recommend-title">Rekomendasi Otomatis</h2>
                    <div class="recommend-list">
                        <?php foreach ($rekomendasiItems as $text): ?>
                            <?php
                            $isWarning = stripos($text, 'margin negatif') !== false || stripos($text, 'evaluasi') !== false;
                            $iconName = $isWarning ? 'alert-triangle' : 'check-circle';
                            $iconClass = $isWarning ? 'warning' : 'positive';
                            ?>
                            <div class="recommend-item">
                                <i data-lucide="<?= $iconName; ?>" class="recommend-icon <?= $iconClass; ?>"></i>
                                <div class="recommend-text"><?= htmlspecialchars($text); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <?php if ($toastMessage !== ''): ?>
        <div class="toast <?= $toastClass; ?>" id="mainToast"><?= htmlspecialchars($toastMessage); ?></div>
    <?php endif; ?>

    <script>
        const chartLabels = <?= $chartLabels ?: '[]'; ?>;
        const chartValues = <?= $chartValues ?: '[]'; ?>;

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

        const toast = document.getElementById('mainToast');
        if (toast) {
            requestAnimationFrame(function () {
                toast.classList.add('show');
            });

            setTimeout(function () {
                toast.classList.remove('show');
            }, 3000);
        }

        const chartCanvas = document.getElementById('penjualanProdukChart');
        if (chartCanvas && Array.isArray(chartLabels) && chartLabels.length > 0 && window.Chart) {
            const maxBars = 10;
            const labels = chartLabels.slice(0, maxBars);
            const values = chartValues.slice(0, maxBars);

            function formatRupiahShort(value) {
                const num = Number(value || 0);
                const abs = Math.abs(num);

                if (abs >= 1000000000) {
                    return 'Rp ' + (num / 1000000000).toFixed(abs >= 10000000000 ? 0 : 1).replace('.0', '') + 'M';
                }

                if (abs >= 1000000) {
                    return 'Rp ' + (num / 1000000).toFixed(abs >= 10000000 ? 0 : 1).replace('.0', '') + 'jt';
                }

                if (abs >= 1000) {
                    return 'Rp ' + (num / 1000).toFixed(abs >= 10000 ? 0 : 1).replace('.0', '') + 'rb';
                }

                return 'Rp ' + num.toLocaleString('id-ID');
            }

            new Chart(chartCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: values,
                        backgroundColor: '#1c6494',
                        borderColor: '#1c6494',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const value = Number(context.raw || 0);
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return formatRupiahShort(value);
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>
