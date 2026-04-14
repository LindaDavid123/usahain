<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
], (array) ($user ?? []));

$summary = array_merge([
    'total' => 0,
    'tinggi' => 0,
    'sedang' => 0,
    'rendah' => 0,
], (array) ($summary ?? []));

$risiko_list = is_array($risiko_list ?? null) ? $risiko_list : [];
$edit_risiko = $edit_risiko ?? null;
$is_edit = ! empty($edit_risiko);
$analyze_requested = ! empty($analyze_requested);
$auto_analysis = is_array($auto_analysis ?? null) ? $auto_analysis : [
    'has_financial_data' => false,
    'empty_message' => '',
    'detected_risks' => [],
    'projections' => [],
    'suggestions' => [],
];
$detected_risks = is_array($auto_analysis['detected_risks'] ?? null) ? $auto_analysis['detected_risks'] : [];
$projections = is_array($auto_analysis['projections'] ?? null) ? $auto_analysis['projections'] : [];
$suggestions = is_array($auto_analysis['suggestions'] ?? null) ? $auto_analysis['suggestions'] : [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Risiko - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --primary: #1c6494;
            --primary-dark: #15527a;
            --text: #111827;
            --text-secondary: #64748b;
            --bg: #f1f5f9;
            --card: #ffffff;
            --border: #e5e7eb;
            --danger: #ef4444;
            --warning: #f59e0b;
            --success: #16a34a;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; display: flex; }

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
            z-index: 50;
            transition: all 0.3s;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .sidebar.collapsed { width: 80px; }
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
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
            min-width: 40px;
        }
        .sidebar-logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }
        .sidebar-menu { flex: 1; overflow-y: auto; padding: 14px 12px; list-style: none; }
        .sidebar-menu-item { margin-bottom: 8px; }
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.25s;
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
        .sidebar-menu-badge {
            margin-left: auto;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            background: rgba(31, 107, 153, 0.1);
            color: #1f6b99;
        }
        .sidebar-menu-link.active .sidebar-menu-badge {
            background: #1c6494;
            color: #fff;
        }
        .sidebar-menu-icon { display: none; }

        body.sidebar-collapsed .sidebar-menu-text,
        body.sidebar-collapsed .sidebar-menu-badge,
        body.sidebar-collapsed .sidebar-logo-text { display: none; }

        .main-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        body.sidebar-collapsed .main-wrapper {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        .top-header {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .header-left { display: flex; align-items: center; gap: 14px; }
        .header-title { font-size: 18px; font-weight: 600; color: #1c6494; }
        .header-right { display: flex; align-items: center; gap: 12px; }
        .header-user {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
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
            font-weight: 800;
            font-size: 14px;
        }
        .header-user-info { display: flex; flex-direction: column; gap: 2px; }
        .header-user-name { font-size: 13px; font-weight: 600; }
        .header-user-email { font-size: 11px; color: var(--text-secondary); }

        .container {
            max-width: 1280px;
            margin: 28px auto;
            padding: 0 18px;
        }

        .alert {
            margin-bottom: 16px;
            border-radius: 10px;
            padding: 12px 14px;
            border: 1px solid transparent;
            font-size: 14px;
        }
        .alert-success {
            background: #ecfdf5;
            color: #166534;
            border-color: #bbf7d0;
        }
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border-color: #fecaca;
        }
        .alert ul { margin-left: 16px; }

        .summary-row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        .summary-card {
            background: var(--card);
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid var(--border);
        }
        .summary-label {
            color: var(--text-secondary);
            font-size: 10px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .summary-value {
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }
        .summary-card.total .summary-value { color: #1f2937; }
        .summary-card.high .summary-value { color: #ef4444; }
        .summary-card.medium .summary-value { color: #f59e0b; }
        .summary-card.low .summary-value { color: #16a34a; }

        .auto-analysis-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 14px;
        }
        .auto-analysis-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        .auto-analysis-subtitle {
            color: #64748b;
            font-size: 13px;
        }
        .btn-analyze {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            text-decoration: none;
            background: #1c6494;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
        }
        .btn-analyze:hover {
            background: #15527a;
        }
        .btn-analyze:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
        }
        .auto-refresh-control {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #475569;
            font-size: 12px;
            user-select: none;
        }
        .auto-refresh-control input {
            width: 14px;
            height: 14px;
            accent-color: #1c6494;
        }
        .auto-refresh-status {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 11px;
            color: #64748b;
        }
        .auto-refresh-status .countdown {
            color: #334155;
            font-weight: 600;
        }
        .auto-hint,
        .auto-empty,
        .no-risk-state {
            margin-top: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            padding: 14px;
        }

        .auto-risk-list {
            list-style: none;
            margin: 8px 0 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .auto-risk-item {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
            padding: 12px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .auto-risk-main {
            flex: 1;
        }
        .auto-risk-title-row {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 6px;
        }
        .risk-level-icon {
            width: 20px;
            height: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }
        .risk-level-icon i,
        .risk-level-icon svg {
            width: 14px;
            height: 14px;
        }
        .risk-level-icon.high {
            background: rgba(239,68,68,0.12);
            color: #dc2626;
        }
        .risk-level-icon.medium {
            background: rgba(245,158,11,0.16);
            color: #b45309;
        }
        .risk-level-icon.low {
            background: rgba(22,163,74,0.16);
            color: #15803d;
        }
        .auto-risk-desc {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.45;
        }
        .badge-level-high { background: rgba(239,68,68,0.1); color: #ef4444; }
        .badge-level-medium { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .badge-level-low { background: rgba(22,163,74,0.1); color: #16a34a; }
        .btn-add-risk {
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #1c6494;
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }
        .btn-add-risk:hover {
            background: #f8fafc;
        }

        .auto-block {
            margin-top: 16px;
            border-top: 1px solid #f1f5f9;
            padding-top: 14px;
        }
        .auto-block-title {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }
        .projection-wrapper {
            overflow-x: auto;
        }
        .projection-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
        }
        .projection-table th,
        .projection-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            font-size: 13px;
            text-transform: none;
            letter-spacing: normal;
        }
        .projection-table th {
            background: #f8fafc;
            color: #374151;
            font-weight: 700;
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
        }
        .status-pill.safe {
            background: rgba(22,163,74,0.12);
            color: #15803d;
        }
        .status-pill.warning {
            background: rgba(245,158,11,0.14);
            color: #b45309;
        }
        .status-pill.danger {
            background: rgba(239,68,68,0.12);
            color: #dc2626;
        }

        .suggestion-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .suggestion-list li {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: #374151;
            font-size: 13px;
            line-height: 1.45;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            background: #fff;
            padding: 10px;
        }
        .suggestion-icon {
            width: 15px;
            height: 15px;
            color: #f59e0b;
            margin-top: 1px;
            flex-shrink: 0;
        }

        .mini-toast-container {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 2000;
            pointer-events: none;
        }
        .mini-toast {
            min-width: 240px;
            max-width: 320px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 12px;
            line-height: 1.45;
            background: #fff;
            color: #1f2937;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.14);
            animation: miniToastIn 0.2s ease-out;
        }
        .mini-toast.success {
            border-color: #bbf7d0;
            background: #ecfdf5;
            color: #166534;
        }
        .mini-toast.error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
        }
        .mini-toast.info {
            border-color: #bfdbfe;
            background: #eff6ff;
            color: #1d4ed8;
        }

        @keyframes miniToastIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            background: var(--card);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 18px;
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .risk-form {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr 1.3fr 1fr auto;
            gap: 12px;
            align-items: end;
        }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label {
            font-size: 12px;
            color: #374151;
            font-weight: 500;
        }
        .form-group input,
        .form-group select {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 13px;
            background: #fff;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #94c9e9;
            box-shadow: 0 0 0 3px rgba(28, 100, 148, 0.12);
        }
        .btn-submit {
            height: 40px;
            border: none;
            border-radius: 8px;
            background: #1c6494;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            padding: 0 18px;
            white-space: nowrap;
        }
        .btn-submit:hover { background: var(--primary-dark); }
        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            text-decoration: none;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 600;
        }

        .table-wrapper { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 920px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 14px;
            vertical-align: middle;
        }
        th {
            background: #1c6494;
            color: #ffffff;
            font-size: 12px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            white-space: nowrap;
        }

        .badge-risk-tinggi { background: rgba(239,68,68,0.1); color: #ef4444; }
        .badge-risk-sedang { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .badge-risk-rendah { background: rgba(22,163,74,0.1); color: #16a34a; }

        .badge-status-belum { background: rgba(239,68,68,0.1); color: #ef4444; }
        .badge-status-proses { background: rgba(245,158,11,0.1); color: #f59e0b; }
        .badge-status-selesai { background: rgba(22,163,74,0.1); color: #16a34a; }

        .actions-cell {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .btn-action {
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-action i,
        .btn-action svg {
            width: 14px;
            height: 14px;
        }
        .btn-action.edit { color: #f59e0b; }
        .btn-action.delete { color: #ef4444; }

        .empty-state {
            text-align: center;
            padding: 28px 12px;
            color: #64748b;
            font-size: 14px;
        }

        .mobile-menu {
            display: none;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
        }

        @media (max-width: 1200px) {
            .summary-row { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .risk-form { grid-template-columns: 1fr 1fr; }
            .risk-form .form-group:last-child { grid-column: span 2; }
            .auto-analysis-actions {
                width: 100%;
                align-items: flex-start;
            }
        }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-wrapper,
            body.sidebar-collapsed .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
            .mobile-menu { display: inline-flex; }
            .header-user-email { display: none; }
            .header-user-name { display: none; }
        }

        @media (max-width: 640px) {
            .summary-row { grid-template-columns: 1fr; }
            .risk-form { grid-template-columns: 1fr; }
            .risk-form .form-group:last-child { grid-column: auto; }
            .top-header { padding: 14px 16px; }
            .container { padding: 0 12px; margin: 18px auto; }
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
                <a href="<?= site_url('risiko'); ?>" class="sidebar-menu-link active">
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
                <button class="mobile-menu" id="mobileMenuBtn" aria-label="Buka menu">
                    <i data-lucide="menu" style="width:20px;height:20px;"></i>
                </button>
                <div class="header-title">Manajemen Risiko</div>
            </div>
            <div class="header-right">
                <a href="<?= site_url('user/profile'); ?>" class="header-user">
                    <div class="header-user-avatar"><?= strtoupper(substr((string) $user['nama'], 0, 1)); ?></div>
                    <div class="header-user-info">
                        <div class="header-user-name"><?= htmlspecialchars((string) $user['nama']); ?></div>
                        <div class="header-user-email"><?= htmlspecialchars((string) $user['email']); ?></div>
                    </div>
                </a>
            </div>
        </header>

        <main class="container">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= htmlspecialchars((string) $this->session->flashdata('success')); ?></div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= htmlspecialchars((string) $this->session->flashdata('error')); ?></div>
            <?php endif; ?>

            <?php if (validation_errors()): ?>
                <div class="alert alert-danger">
                    <ul><?= validation_errors('<li>', '</li>'); ?></ul>
                </div>
            <?php endif; ?>

            <section class="summary-row">
                <div class="summary-card total">
                    <div class="summary-label">Total Risiko</div>
                    <div class="summary-value"><?= (int) $summary['total']; ?></div>
                </div>
                <div class="summary-card high">
                    <div class="summary-label">Risiko Tinggi</div>
                    <div class="summary-value"><?= (int) $summary['tinggi']; ?></div>
                </div>
                <div class="summary-card medium">
                    <div class="summary-label">Risiko Sedang</div>
                    <div class="summary-value"><?= (int) $summary['sedang']; ?></div>
                </div>
                <div class="summary-card low">
                    <div class="summary-label">Risiko Rendah</div>
                    <div class="summary-value"><?= (int) $summary['rendah']; ?></div>
                </div>
            </section>

            <section class="card" id="autoAnalysisSection">
                <div class="auto-analysis-header">
                    <div>
                        <h2 class="card-title" style="margin-bottom: 6px;">Deteksi Risiko dari Data Keuangan</h2>
                        <p class="auto-analysis-subtitle">Analisis otomatis berdasarkan data transaksi keuangan terbaru.</p>
                    </div>
                    <div class="auto-analysis-actions">
                        <button type="button" class="btn-analyze" id="btnAnalyzeNow">
                            <i data-lucide="sparkles"></i>
                            <span id="btnAnalyzeNowText">Analisis Sekarang</span>
                        </button>
                        <label class="auto-refresh-control" for="autoRefreshToggle">
                            <input type="checkbox" id="autoRefreshToggle">
                            <span>Auto-refresh setiap 60 detik</span>
                        </label>
                        <div class="auto-refresh-status" id="autoRefreshStatus">
                            <span id="autoRefreshStatusText">Auto-refresh nonaktif.</span>
                            <span id="autoRefreshCountdown" class="countdown"></span>
                        </div>
                    </div>
                </div>

                <div id="autoAnalysisContent">
                    <?php if (! $analyze_requested): ?>
                        <div class="auto-hint">Klik Analisis Sekarang untuk membaca data keuangan terbaru dan menghasilkan deteksi risiko otomatis.</div>
                    <?php else: ?>
                        <?php if (! ($auto_analysis['has_financial_data'] ?? false)): ?>
                            <div class="auto-empty"><?= htmlspecialchars((string) ($auto_analysis['empty_message'] ?? 'Belum ada data keuangan.')); ?></div>
                        <?php else: ?>
                            <?php if (! empty($detected_risks)): ?>
                                <ul class="auto-risk-list">
                                    <?php foreach ($detected_risks as $item): ?>
                                        <?php
                                        $level = (string) ($item['tingkat'] ?? 'Sedang');
                                        $icon = 'alert-circle';
                                        $icon_class = 'medium';
                                        $badge_class = 'badge-level-medium';

                                        if ($level === 'Tinggi') {
                                            $icon = 'triangle-alert';
                                            $icon_class = 'high';
                                            $badge_class = 'badge-level-high';
                                        } elseif ($level === 'Rendah') {
                                            $icon = 'shield-check';
                                            $icon_class = 'low';
                                            $badge_class = 'badge-level-low';
                                        }
                                        ?>
                                        <li class="auto-risk-item">
                                            <div class="auto-risk-main">
                                                <div class="auto-risk-title-row">
                                                    <span class="risk-level-icon <?= $icon_class; ?>">
                                                        <i data-lucide="<?= $icon; ?>"></i>
                                                    </span>
                                                    <strong><?= htmlspecialchars((string) ($item['nama_risiko'] ?? '-')); ?></strong>
                                                    <span class="badge <?= $badge_class; ?>"><?= htmlspecialchars($level); ?></span>
                                                </div>
                                                <p class="auto-risk-desc"><?= htmlspecialchars((string) ($item['keterangan'] ?? '-')); ?></p>
                                            </div>

                                            <form method="post" action="<?= site_url('risiko/add_auto_risk'); ?>">
                                                <input type="hidden" name="nama_risiko" value="<?= htmlspecialchars((string) ($item['nama_risiko'] ?? '')); ?>">
                                                <input type="hidden" name="tingkat" value="<?= htmlspecialchars($level); ?>">
                                                <input type="hidden" name="keterangan" value="<?= htmlspecialchars((string) ($item['keterangan'] ?? '')); ?>">
                                                <button type="submit" class="btn-add-risk">Tambahkan ke Daftar Risiko</button>
                                            </form>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <div class="no-risk-state">Tidak ditemukan risiko signifikan dari data keuangan saat ini.</div>
                            <?php endif; ?>

                            <div class="auto-block">
                                <h3 class="auto-block-title">Proyeksi Risiko 3 Bulan ke Depan</h3>
                                <div class="projection-wrapper">
                                    <table class="projection-table">
                                        <thead>
                                            <tr>
                                                <th>Periode</th>
                                                <th>Estimasi Pemasukan</th>
                                                <th>Estimasi Pengeluaran</th>
                                                <th>Estimasi Saldo</th>
                                                <th>Status Risiko</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($projections as $row): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars((string) ($row['periode'] ?? '-')); ?></td>
                                                    <td>Rp <?= number_format((float) ($row['estimasi_pemasukan'] ?? 0), 0, ',', '.'); ?></td>
                                                    <td>Rp <?= number_format((float) ($row['estimasi_pengeluaran'] ?? 0), 0, ',', '.'); ?></td>
                                                    <td>Rp <?= number_format((float) ($row['estimasi_saldo'] ?? 0), 0, ',', '.'); ?></td>
                                                    <td>
                                                        <?php $status_class = (string) ($row['status_class'] ?? 'warning'); ?>
                                                        <span class="status-pill <?= htmlspecialchars($status_class); ?>"><?= htmlspecialchars((string) ($row['status_label'] ?? 'Waspada')); ?></span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="auto-block">
                                <h3 class="auto-block-title">Saran Manajemen Keuangan</h3>
                                <ul class="suggestion-list">
                                    <?php foreach ($suggestions as $suggestion): ?>
                                        <li>
                                            <i data-lucide="lightbulb" class="suggestion-icon"></i>
                                            <span><?= htmlspecialchars((string) $suggestion); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="card">
                <h2 class="card-title"><?= $is_edit ? 'Edit Risiko' : 'Tambah Risiko'; ?></h2>
                <form method="post" action="<?= site_url('risiko'); ?>" class="risk-form">
                    <?php if ($is_edit): ?>
                        <input type="hidden" name="id_risiko" value="<?= (int) $edit_risiko->id_risiko; ?>">
                        <input type="hidden" name="tanggal" value="<?= htmlspecialchars((string) $edit_risiko->tanggal); ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="nama_risiko">Nama Risiko</label>
                        <input
                            type="text"
                            id="nama_risiko"
                            name="nama_risiko"
                            placeholder="Contoh: Ketergantungan pada 1 supplier"
                            value="<?= htmlspecialchars(set_value('nama_risiko', $is_edit ? (string) $edit_risiko->nama_risiko : '')); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat</label>
                        <?php $tingkat_value = set_value('tingkat', $is_edit ? (string) $edit_risiko->tingkat : 'Sedang'); ?>
                        <select id="tingkat" name="tingkat" required>
                            <option value="Tinggi" <?= $tingkat_value === 'Tinggi' ? 'selected' : ''; ?>>Tinggi</option>
                            <option value="Sedang" <?= $tingkat_value === 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
                            <option value="Rendah" <?= $tingkat_value === 'Rendah' ? 'selected' : ''; ?>>Rendah</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tindakan_mitigasi">Tindakan Mitigasi</label>
                        <input
                            type="text"
                            id="tindakan_mitigasi"
                            name="tindakan_mitigasi"
                            placeholder="Contoh: Cari 2-3 supplier alternatif"
                            value="<?= htmlspecialchars(set_value('tindakan_mitigasi', $is_edit ? (string) $edit_risiko->tindakan_mitigasi : '')); ?>"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="status_penanganan">Status</label>
                        <?php $status_value = set_value('status_penanganan', $is_edit ? (string) $edit_risiko->status_penanganan : 'Belum Ditangani'); ?>
                        <select id="status_penanganan" name="status_penanganan" required>
                            <option value="Belum Ditangani" <?= $status_value === 'Belum Ditangani' ? 'selected' : ''; ?>>Belum Ditangani</option>
                            <option value="Dalam Proses" <?= $status_value === 'Dalam Proses' ? 'selected' : ''; ?>>Dalam Proses</option>
                            <option value="Sudah Ditangani" <?= $status_value === 'Sudah Ditangani' ? 'selected' : ''; ?>>Sudah Ditangani</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn-submit"><?= $is_edit ? 'Simpan Perubahan' : 'Tambah Risiko'; ?></button>
                    </div>
                </form>
                <?php if ($is_edit): ?>
                    <div style="margin-top: 10px;">
                        <a href="<?= site_url('risiko'); ?>" class="btn-cancel">Batal Edit</a>
                    </div>
                <?php endif; ?>
            </section>

            <section class="card">
                <h2 class="card-title">Daftar Risiko</h2>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Risiko</th>
                                <th>Tingkat</th>
                                <th>Tindakan Mitigasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($risiko_list)): ?>
                                <tr>
                                    <td colspan="6" class="empty-state">Belum ada data risiko.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($risiko_list as $risiko): ?>
                                    <?php
                                    $tingkat = (string) ($risiko->tingkat ?? 'Sedang');
                                    $status = (string) ($risiko->status_penanganan ?? 'Belum Ditangani');
                                    $tingkat_class = 'badge-risk-sedang';
                                    if ($tingkat === 'Tinggi') {
                                        $tingkat_class = 'badge-risk-tinggi';
                                    } elseif ($tingkat === 'Rendah') {
                                        $tingkat_class = 'badge-risk-rendah';
                                    }

                                    $status_class = 'badge-status-belum';
                                    $status_label = 'Belum Ditangani';
                                    if ($status === 'Dalam Proses') {
                                        $status_class = 'badge-status-proses';
                                        $status_label = 'Dalam Proses';
                                    } elseif ($status === 'Sudah Ditangani') {
                                        $status_class = 'badge-status-selesai';
                                        $status_label = 'Sudah Ditangani';
                                    }

                                    $tanggal_value = ! empty($risiko->tanggal) ? date('d/m/Y', strtotime((string) $risiko->tanggal)) : '-';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) $risiko->nama_risiko); ?></td>
                                        <td><span class="badge <?= $tingkat_class; ?>"><?= htmlspecialchars($tingkat); ?></span></td>
                                        <td><?= htmlspecialchars((string) $risiko->tindakan_mitigasi); ?></td>
                                        <td><span class="badge <?= $status_class; ?>"><?= $status_label; ?></span></td>
                                        <td><?= htmlspecialchars($tanggal_value); ?></td>
                                        <td>
                                            <div class="actions-cell">
                                                <a class="btn-action edit" href="<?= site_url('risiko?edit=' . (int) $risiko->id_risiko); ?>" aria-label="Edit Risiko">
                                                    <i data-lucide="pencil"></i>
                                                </a>
                                                <form method="post" action="<?= site_url('risiko/delete/' . (int) $risiko->id_risiko); ?>" onsubmit="return confirm('Hapus risiko ini?');">
                                                    <button type="submit" class="btn-action delete" aria-label="Hapus Risiko">
                                                        <i data-lucide="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div class="mini-toast-container" id="miniToastContainer" aria-live="polite"></div>

    <script>
        lucide.createIcons();

        const autoAnalyzeBtn = document.getElementById('btnAnalyzeNow');
        const autoAnalyzeBtnText = document.getElementById('btnAnalyzeNowText');
        const autoAnalysisContent = document.getElementById('autoAnalysisContent');
        const autoAnalysisSection = document.getElementById('autoAnalysisSection');
        const autoRefreshToggle = document.getElementById('autoRefreshToggle');
        const autoRefreshStatus = document.getElementById('autoRefreshStatus');
        const autoRefreshStatusText = document.getElementById('autoRefreshStatusText');
        const autoRefreshCountdown = document.getElementById('autoRefreshCountdown');
        const miniToastContainer = document.getElementById('miniToastContainer');
        const autoAnalysisUrl = <?= json_encode(site_url('risiko/auto_analysis_data')); ?>;
        const addAutoRiskUrl = <?= json_encode(site_url('risiko/add_auto_risk')); ?>;
        const analyzeRequestedOnServer = <?= $analyze_requested ? 'true' : 'false'; ?>;
        const autoRefreshStorageKey = 'risiko_auto_refresh_60s_enabled';
        const AUTO_REFRESH_INTERVAL_SECONDS = 60;
        let autoRefreshIntervalId = null;
        let autoSectionVisible = true;
        let analysisRequestInFlight = false;
        let autoRefreshRemainingSeconds = AUTO_REFRESH_INTERVAL_SECONDS;
        let autoRefreshLastResult = '';

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatRupiah(value) {
            const number = Number(value || 0);
            return 'Rp ' + number.toLocaleString('id-ID');
        }

        function getRiskLevelMeta(level) {
            if (level === 'Tinggi') {
                return {
                    icon: 'triangle-alert',
                    iconClass: 'high',
                    badgeClass: 'badge-level-high'
                };
            }

            if (level === 'Rendah') {
                return {
                    icon: 'shield-check',
                    iconClass: 'low',
                    badgeClass: 'badge-level-low'
                };
            }

            return {
                icon: 'alert-circle',
                iconClass: 'medium',
                badgeClass: 'badge-level-medium'
            };
        }

        function setAnalyzeLoading(isLoading) {
            if (!autoAnalyzeBtn || !autoAnalyzeBtnText) {
                return;
            }

            autoAnalyzeBtn.disabled = isLoading;
            autoAnalyzeBtnText.textContent = isLoading ? 'Menganalisis...' : 'Analisis Sekarang';
        }

        function setAutoRefreshStatus(message) {
            if (!autoRefreshStatusText) {
                return;
            }
            autoRefreshStatusText.textContent = message;
        }

        function setAutoRefreshCountdown(seconds) {
            if (!autoRefreshCountdown) {
                return;
            }

            if (typeof seconds !== 'number' || seconds < 0) {
                autoRefreshCountdown.textContent = '';
                return;
            }

            autoRefreshCountdown.textContent = 'Refresh berikutnya dalam ' + seconds + ' detik.';
        }

        function showMiniToast(message, type) {
            if (!miniToastContainer) {
                return;
            }

            const toastType = type || 'info';
            const toast = document.createElement('div');
            toast.className = 'mini-toast ' + toastType;
            toast.textContent = message;

            miniToastContainer.appendChild(toast);

            window.setTimeout(() => {
                toast.remove();
            }, 2600);
        }

        function getCurrentTimeLabel() {
            return new Date().toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        function renderAutoAnalysis(analysis) {
            if (!autoAnalysisContent) {
                return;
            }

            if (!analysis || !analysis.has_financial_data) {
                const message = (analysis && analysis.empty_message)
                    ? analysis.empty_message
                    : 'Belum ada data keuangan. Mulai catat transaksi di Pencatatan Keuangan untuk mendapatkan analisis risiko otomatis.';

                autoAnalysisContent.innerHTML = '<div class="auto-empty">' + escapeHtml(message) + '</div>';
                if (window.lucide) {
                    window.lucide.createIcons();
                }
                return;
            }

            const risks = Array.isArray(analysis.detected_risks) ? analysis.detected_risks : [];
            const projections = Array.isArray(analysis.projections) ? analysis.projections : [];
            const suggestions = Array.isArray(analysis.suggestions) ? analysis.suggestions : [];

            let html = '';

            if (risks.length > 0) {
                html += '<ul class="auto-risk-list">';

                risks.forEach((item) => {
                    const level = item && item.tingkat ? item.tingkat : 'Sedang';
                    const meta = getRiskLevelMeta(level);
                    const name = item && item.nama_risiko ? item.nama_risiko : '-';
                    const desc = item && item.keterangan ? item.keterangan : '-';

                    html +=
                        '<li class="auto-risk-item">' +
                            '<div class="auto-risk-main">' +
                                '<div class="auto-risk-title-row">' +
                                    '<span class="risk-level-icon ' + meta.iconClass + '">' +
                                        '<i data-lucide="' + meta.icon + '"></i>' +
                                    '</span>' +
                                    '<strong>' + escapeHtml(name) + '</strong>' +
                                    '<span class="badge ' + meta.badgeClass + '">' + escapeHtml(level) + '</span>' +
                                '</div>' +
                                '<p class="auto-risk-desc">' + escapeHtml(desc) + '</p>' +
                            '</div>' +
                            '<form method="post" action="' + escapeHtml(addAutoRiskUrl) + '">' +
                                '<input type="hidden" name="nama_risiko" value="' + escapeHtml(name) + '">' +
                                '<input type="hidden" name="tingkat" value="' + escapeHtml(level) + '">' +
                                '<input type="hidden" name="keterangan" value="' + escapeHtml(desc) + '">' +
                                '<button type="submit" class="btn-add-risk">Tambahkan ke Daftar Risiko</button>' +
                            '</form>' +
                        '</li>';
                });

                html += '</ul>';
            } else {
                html += '<div class="no-risk-state">Tidak ditemukan risiko signifikan dari data keuangan saat ini.</div>';
            }

            html +=
                '<div class="auto-block">' +
                    '<h3 class="auto-block-title">Proyeksi Risiko 3 Bulan ke Depan</h3>' +
                    '<div class="projection-wrapper">' +
                        '<table class="projection-table">' +
                            '<thead>' +
                                '<tr>' +
                                    '<th>Periode</th>' +
                                    '<th>Estimasi Pemasukan</th>' +
                                    '<th>Estimasi Pengeluaran</th>' +
                                    '<th>Estimasi Saldo</th>' +
                                    '<th>Status Risiko</th>' +
                                '</tr>' +
                            '</thead>' +
                            '<tbody>';

            projections.forEach((row) => {
                const statusClass = row && row.status_class ? row.status_class : 'warning';
                const statusLabel = row && row.status_label ? row.status_label : 'Waspada';

                html +=
                    '<tr>' +
                        '<td>' + escapeHtml(row && row.periode ? row.periode : '-') + '</td>' +
                        '<td>' + formatRupiah(row && row.estimasi_pemasukan ? row.estimasi_pemasukan : 0) + '</td>' +
                        '<td>' + formatRupiah(row && row.estimasi_pengeluaran ? row.estimasi_pengeluaran : 0) + '</td>' +
                        '<td>' + formatRupiah(row && row.estimasi_saldo ? row.estimasi_saldo : 0) + '</td>' +
                        '<td><span class="status-pill ' + escapeHtml(statusClass) + '">' + escapeHtml(statusLabel) + '</span></td>' +
                    '</tr>';
            });

            html +=
                            '</tbody>' +
                        '</table>' +
                    '</div>' +
                '</div>';

            html +=
                '<div class="auto-block">' +
                    '<h3 class="auto-block-title">Saran Manajemen Keuangan</h3>' +
                    '<ul class="suggestion-list">';

            suggestions.forEach((item) => {
                html +=
                    '<li>' +
                        '<i data-lucide="lightbulb" class="suggestion-icon"></i>' +
                        '<span>' + escapeHtml(item) + '</span>' +
                    '</li>';
            });

            html +=
                    '</ul>' +
                '</div>';

            autoAnalysisContent.innerHTML = html;

            if (window.lucide) {
                window.lucide.createIcons();
            }
        }

        function shouldRunAutoRefreshNow() {
            return Boolean(
                autoRefreshToggle &&
                autoRefreshToggle.checked &&
                document.visibilityState === 'visible' &&
                autoSectionVisible
            );
        }

        function resetAutoRefreshCountdown() {
            autoRefreshRemainingSeconds = AUTO_REFRESH_INTERVAL_SECONDS;
            updateAutoRefreshStatusLine();
        }

        function updateAutoRefreshStatusLine() {
            if (!autoRefreshToggle || !autoRefreshToggle.checked) {
                setAutoRefreshStatus('Auto-refresh nonaktif.');
                setAutoRefreshCountdown(-1);
                return;
            }

            if (document.visibilityState !== 'visible') {
                setAutoRefreshStatus('Auto-refresh aktif (pause): tab tidak aktif.');
                setAutoRefreshCountdown(-1);
                return;
            }

            if (!autoSectionVisible) {
                setAutoRefreshStatus('Auto-refresh aktif (pause): section tidak terlihat.');
                setAutoRefreshCountdown(-1);
                return;
            }

            if (analysisRequestInFlight) {
                setAutoRefreshStatus('Auto-refresh aktif. Memperbarui data...');
                setAutoRefreshCountdown(-1);
                return;
            }

            if (autoRefreshLastResult !== '') {
                setAutoRefreshStatus(autoRefreshLastResult);
            } else {
                setAutoRefreshStatus('Auto-refresh aktif.');
            }

            setAutoRefreshCountdown(autoRefreshRemainingSeconds);
        }

        function requestAutoAnalysis(options) {
            if (!autoAnalysisUrl) {
                return;
            }

            const config = Object.assign({ showLoading: true, source: 'manual' }, options || {});

            if (analysisRequestInFlight) {
                return;
            }

            analysisRequestInFlight = true;

            if (config.showLoading) {
                setAnalyzeLoading(true);
            }

            if (config.source === 'auto') {
                updateAutoRefreshStatusLine();
            }

            fetch(autoAnalysisUrl, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then((result) => {
                if (!result || result.success !== true) {
                    throw new Error('Invalid response');
                }
                renderAutoAnalysis(result.analysis || null);

                if (config.source === 'auto') {
                    autoRefreshLastResult = 'Auto-refresh aktif. Diperbarui ' + getCurrentTimeLabel() + '.';
                    resetAutoRefreshCountdown();
                    showMiniToast('Analisis risiko diperbarui otomatis.', 'success');
                }
            })
            .catch(() => {
                if (autoAnalysisContent) {
                    autoAnalysisContent.innerHTML = '<div class="auto-empty">Gagal memuat analisis otomatis. Silakan coba lagi.</div>';
                }

                if (config.source === 'auto') {
                    autoRefreshLastResult = 'Auto-refresh aktif, tetapi pembaruan gagal.';
                    resetAutoRefreshCountdown();
                    showMiniToast('Auto-refresh gagal. Akan coba lagi.', 'error');
                }
            })
            .finally(() => {
                analysisRequestInFlight = false;

                if (config.showLoading) {
                    setAnalyzeLoading(false);
                }

                 if (config.source !== 'auto') {
                    if (autoRefreshToggle && autoRefreshToggle.checked) {
                        autoRefreshLastResult = 'Auto-refresh aktif. Diperbarui ' + getCurrentTimeLabel() + '.';
                        resetAutoRefreshCountdown();
                    }
                }

                updateAutoRefreshStatusLine();

                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        }

        function setupSectionVisibilityObserver() {
            if (!autoAnalysisSection) {
                autoSectionVisible = true;
                return;
            }

            if (!('IntersectionObserver' in window)) {
                autoSectionVisible = true;
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                const entry = entries[0];
                autoSectionVisible = Boolean(entry && entry.isIntersecting);

                if (shouldRunAutoRefreshNow()) {
                    updateAutoRefreshStatusLine();
                }
            }, { threshold: 0.2 });

            observer.observe(autoAnalysisSection);
        }

        function setupAutoRefreshInterval() {
            if (autoRefreshIntervalId) {
                clearInterval(autoRefreshIntervalId);
            }

            autoRefreshIntervalId = window.setInterval(() => {
                if (!autoRefreshToggle || !autoRefreshToggle.checked) {
                    updateAutoRefreshStatusLine();
                    return;
                }

                if (!shouldRunAutoRefreshNow()) {
                    updateAutoRefreshStatusLine();
                    return;
                }

                if (analysisRequestInFlight) {
                    updateAutoRefreshStatusLine();
                    return;
                }

                if (autoRefreshRemainingSeconds <= 0) {
                    requestAutoAnalysis({ showLoading: false, source: 'auto' });
                    return;
                }

                autoRefreshRemainingSeconds -= 1;
                updateAutoRefreshStatusLine();
            }, 1000);
        }

        function syncAutoRefreshToggleState() {
            if (!autoRefreshToggle) {
                return;
            }

            let enabled = false;

            try {
                enabled = window.localStorage.getItem(autoRefreshStorageKey) === '1';
            } catch (error) {
                enabled = false;
            }

            autoRefreshToggle.checked = enabled;

            if (enabled) {
                autoRefreshLastResult = 'Auto-refresh aktif. Data akan diperbarui tiap 60 detik saat section terlihat.';
                autoRefreshRemainingSeconds = AUTO_REFRESH_INTERVAL_SECONDS;
            } else {
                autoRefreshLastResult = '';
            }

            updateAutoRefreshStatusLine();
        }

        function onAutoRefreshToggleChanged() {
            if (!autoRefreshToggle) {
                return;
            }

            const enabled = autoRefreshToggle.checked;

            try {
                window.localStorage.setItem(autoRefreshStorageKey, enabled ? '1' : '0');
            } catch (error) {
                // Ignore storage error and continue.
            }

            if (enabled) {
                autoRefreshLastResult = 'Auto-refresh aktif. Data akan diperbarui tiap 60 detik saat section terlihat.';
                autoRefreshRemainingSeconds = AUTO_REFRESH_INTERVAL_SECONDS;
                updateAutoRefreshStatusLine();
                showMiniToast('Auto-refresh diaktifkan.', 'info');

                if (shouldRunAutoRefreshNow()) {
                    requestAutoAnalysis({ showLoading: false, source: 'auto' });
                }
            } else {
                autoRefreshLastResult = '';
                updateAutoRefreshStatusLine();
                showMiniToast('Auto-refresh dinonaktifkan.', 'info');
            }
        }

        if (autoAnalyzeBtn) {
            autoAnalyzeBtn.addEventListener('click', function () {
                requestAutoAnalysis({ showLoading: true, source: 'manual' });
            });
        }

        if (autoRefreshToggle) {
            autoRefreshToggle.addEventListener('change', onAutoRefreshToggleChanged);
        }

        document.addEventListener('visibilitychange', function () {
            if (shouldRunAutoRefreshNow()) {
                autoRefreshRemainingSeconds = AUTO_REFRESH_INTERVAL_SECONDS;
                requestAutoAnalysis({ showLoading: false, source: 'auto' });
                return;
            }

            updateAutoRefreshStatusLine();
        });

        setupSectionVisibilityObserver();
        syncAutoRefreshToggleState();
        setupAutoRefreshInterval();

        // Load analysis automatically on first open so users don't need to click first.
        if (!analyzeRequestedOnServer) {
            requestAutoAnalysis({ showLoading: false, source: 'manual' });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            body.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('collapsed');
        }

        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }

        document.querySelectorAll('.sidebar-menu-link').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 900) {
                    sidebar.classList.remove('mobile-open');
                }
            });
        });
    </script>
</body>
</html>
