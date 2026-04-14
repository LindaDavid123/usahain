<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Keuangan - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <style>
        :root {
            --primary: #1c6494;
            --primary-dark: #175379;
            --success: #16a34a;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text: #111827;
            --text-secondary: #6b7280;
            --label: #374151;
            --bg: #f1f5f9;
            --card: #FFFFFF;
            --border: #e5e7eb;
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
            z-index: 999;
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
            justify-content: flex-start;
            gap: 12px;
        }
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1F6B99;
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
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding: 14px 12px;
            list-style: none;
        }
        .sidebar-menu-item { margin-bottom: 8px; }
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
            position: relative;
        }
        .sidebar-menu-link:hover {
            background: var(--bg);
            color: #1F6B99;
            transform: translateX(4px);
        }
        .sidebar-menu-link.active {
            background: linear-gradient(135deg, #1F6B99 0%, #3A88BA 100%);
            color: #fff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.25);
        }
        .sidebar-menu-icon {
            display: none;
            width: 18px;
            height: 18px;
            font-size: 16px;
        }
        .sidebar-menu-icon i,
        .sidebar-menu-icon svg {
            width: 18px;
            height: 18px;
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
            color: #1F6B99;
            transition: all 0.3s;
        }
        .sidebar-menu-link:hover .sidebar-menu-badge {
            background: rgba(31, 107, 153, 0.2);
        }
        .sidebar-menu-link.active .sidebar-menu-badge {
            background: #1C6494;
            color: #fff;
        }
        body.sidebar-collapsed .sidebar-menu-text,
        body.sidebar-collapsed .sidebar-menu-badge,
        body.sidebar-collapsed .sidebar-logo-text {
            display: none;
        }

        .main-wrapper {
            margin-left: 260px;
            width: calc(100% - 260px);
            transition: margin-left 0.3s ease, width 0.3s ease;
        }
        body.sidebar-collapsed .main-wrapper {
            margin-left: 84px;
            width: calc(100% - 84px);
        }
        .container { max-width: 1200px; margin: 32px auto; padding: 0 18px; }
        
        /* Header */
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 20px; font-weight: 600; color: #111827; margin-bottom: 6px; }
        .page-header p { font-size: 13px; color: #6b7280; }
        
        /* Summary Cards */
        .summary-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 32px; }
        .summary-card { background: var(--card); border-radius: 12px; padding: 20px; border: 1px solid var(--border); }
        .summary-card .label { color: #6b7280; font-size: 11px; font-weight: 500; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.8px; }
        .summary-card .value { font-size: 20px; font-weight: 700; color: #111827; }
        .summary-card .change { font-size: 11px; margin-top: 6px; color: #6b7280; }
        .summary-card.income .value { color: #16a34a; }
        .summary-card.expense .value { color: #ef4444; }
        
        /* Card Container */
        .card { background: var(--card); border-radius: 12px; border: 1px solid var(--border); padding: 24px; margin-bottom: 24px; }
        .card-title { font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 18px; }
        .card-title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }
        .card-title-row .card-title {
            margin-bottom: 0;
        }

        .export-dropdown {
            position: relative;
            margin-left: auto;
        }
        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #1c6494;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .export-btn i,
        .export-btn svg {
            width: 14px;
            height: 14px;
        }
        .export-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            min-width: 136px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
            display: none;
            overflow: hidden;
            z-index: 20;
        }
        .export-menu.show {
            display: block;
        }
        .export-item {
            width: 100%;
            text-align: left;
            border: none;
            background: #fff;
            color: #111827;
            font-size: 13px;
            padding: 9px 12px;
            cursor: pointer;
        }
        .export-item:hover {
            background: #f8fafc;
        }
        
        /* Form Section */
        .form-section { margin-bottom: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 2fr 1fr 1fr auto; gap: 12px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 12px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-row input, .form-row select { padding: 9px 12px; border-radius: 8px; border: 1px solid var(--border); font-size: 13px; background: #fff; color: var(--text); font-weight: 500; }
        .form-row input::placeholder { color: var(--text-secondary); }
        .form-row input:focus, .form-row select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(11,110,168,0.1); }
        
        .btn { padding: 9px 20px; border-radius: 8px; font-weight: 600; font-size: 13px; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-primary { background: #1c6494; color: #fff; }
        .btn-primary:hover { background: #175379; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        
        /* Filter Section */
        .filter-section { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-section input, .filter-section select { padding: 9px 12px; border-radius: 8px; border: 1px solid var(--border); font-size: 13px; background: #fff; color: var(--text); }
        .filter-section input:focus, .filter-section select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(11,110,168,0.1); }
        .filter-btn { background: #1c6494; color: #fff; padding: 9px 16px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 13px; }
        .filter-btn:hover { background: var(--primary-dark); }
        .filter-btn-reset { background: #f3f4f6; color: #374151; }
        .filter-btn-reset:hover { background: #e5e7eb; }
        
        /* Table */
        .table-wrapper { overflow-x: auto; border-radius: 12px; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 13px; }
        thead { background: #1c6494; }
        th { padding: 12px; color: #fff; font-size: 12px; font-weight: 500; text-align: left; border: none; }
        th:first-child { border-radius: 12px 0 0 0; }
        th:last-child { border-radius: 0 12px 0 0; }
        tbody tr { border-bottom: 1px solid var(--border); }
        tbody tr:hover { background: #f8fafc; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:last-child td:first-child { border-radius: 0 0 0 12px; }
        tbody tr:last-child td:last-child { border-radius: 0 0 12px 0; }
        td { padding: 12px; color: var(--text); border: none; }
        td:first-child { color: #111827; font-weight: 500; }
        .currency { text-align: right; font-weight: 700; font-variant-numeric: tabular-nums; }
        .saldo-positive { color: var(--success); font-weight: 700; }
        .saldo-negative { color: var(--danger); font-weight: 700; }
        
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge.income { background: rgba(22,163,74,0.1); color: #16a34a; }
        .badge.expense { background: rgba(239,68,68,0.1); color: #ef4444; }
        
        .action-buttons { display: flex; gap: 10px; justify-content: center; }
        .action-buttons button {
            padding: 0;
            border: none;
            background: transparent;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .action-buttons button i,
        .action-buttons button svg { width: 14px; height: 14px; }
        .action-buttons .btn-edit { color: #f59e0b; }
        .action-buttons .btn-delete { color: #ef4444; }
        
        .empty-state { padding: 40px 20px; text-align: center; color: var(--text-secondary); }
        .empty-state p { margin-bottom: 12px; }
        
        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: var(--card); border-radius: 12px; padding: 28px; max-width: 400px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.2); animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .modal-title { font-size: 1.2rem; font-weight: 700; color: #111827; margin-bottom: 16px; }
        .modal-close { float: right; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-secondary); }
        .modal-body { clear: both; margin-bottom: 20px; }
        .modal-body .form-group { margin-bottom: 14px; }
        .modal-body .form-group label { font-size: 12px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .modal-body .form-group input,
        .modal-body .form-group select { padding: 9px 12px; border-radius: 8px; border: 1px solid var(--border); font-size: 13px; width: 100%; }
        .modal-actions { display: flex; gap: 12px; }
        .modal-actions button { flex: 1; padding: 12px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
        .modal-actions .btn-save { background: var(--primary); color: #fff; }
        .modal-actions .btn-cancel { background: #f3f4f6; color: #374151; }
        
        /* Error Message */
        .error-message { color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: none; }
        .error-message.show { display: block; }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .form-row { grid-template-columns: 1fr 1fr; }
            .main-wrapper { margin-left: 0; width: 100%; }
            .sidebar { position: relative; width: 100%; height: auto; border-right: none; border-bottom: 1px solid var(--border); }
            body.sidebar-collapsed .main-wrapper { margin-left: 0; width: 100%; }
            body.sidebar-collapsed .sidebar-menu-text,
            body.sidebar-collapsed .sidebar-menu-badge,
            body.sidebar-collapsed .sidebar-logo-text { display: inline; }
        }
        @media (max-width: 768px) {
            .container { padding: 0 14px; margin: 24px auto; }
            .form-row { grid-template-columns: 1fr; }
            .filter-section { flex-direction: column; }
            .summary-row { grid-template-columns: 1fr; }
            .card-title-row {
                flex-direction: column;
                align-items: flex-start;
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
                <a href="<?= site_url('keuangan'); ?>" class="sidebar-menu-link active">
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

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Pencatatan Keuangan</h1>
            <p>Kelola dan pantau arus kas bisnis Anda dengan mudah dan akurat</p>
        </div>

        <!-- Summary Cards -->
        <div class="summary-row">
            <div class="summary-card">
                <div class="label">Saldo Akhir</div>
                <div class="value" id="saldoAkhir">Rp 0</div>
                <div class="change" id="saldoTrend">-</div>
            </div>
            <div class="summary-card income">
                <div class="label">Total Pemasukan</div>
                <div class="value" id="totalMasuk">Rp 0</div>
                <div class="change">Bulan ini</div>
            </div>
            <div class="summary-card expense">
                <div class="label">Total Pengeluaran</div>
                <div class="value" id="totalKeluar">Rp 0</div>
                <div class="change">Bulan ini</div>
            </div>
            <div class="summary-card">
                <div class="label">Jumlah Transaksi</div>
                <div class="value" id="jumlahTransaksi">0</div>
                <div class="change" id="lastTransaction">-</div>
            </div>
        </div>

        <!-- Input Form -->
        <div class="card">
            <div class="card-title">Tambah Transaksi Baru</div>
            <form id="formKeuangan" onsubmit="tambahTransaksi(event)">
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="jenisTransaksi">Jenis</label>
                            <select id="jenisTransaksi" required>
                                <option value="">Pilih jenis</option>
                                <option value="masuk">Pemasukan</option>
                                <option value="keluar">Pengeluaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" id="deskripsi" placeholder="Contoh: Penjualan produk A" required>
                            <div class="error-message" id="errorDeskripsi">Deskripsi tidak boleh kosong</div>
                        </div>
                        <div class="form-group">
                            <label for="tanggalInput">Tanggal</label>
                            <input type="date" id="tanggalInput" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah (Rp)</label>
                            <input type="text" id="jumlah" placeholder="Contoh: 100000" required>
                            <div class="error-message" id="errorJumlah">Jumlah harus lebih besar dari 0</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filter & Search -->
        <div class="card">
            <div class="card-title-row">
                <div class="card-title">Daftar Transaksi</div>
                <div class="export-dropdown">
                    <button type="button" class="export-btn" onclick="toggleExportMenu(event)">
                        <i data-lucide="download"></i>
                        <span>Cetak</span>
                    </button>
                    <div class="export-menu" id="exportMenu">
                        <button type="button" class="export-item" onclick="exportTransactions('pdf')">Unduh PDF</button>
                        <button type="button" class="export-item" onclick="exportTransactions('csv')">Unduh CSV</button>
                    </div>
                </div>
            </div>
            <div class="filter-section">
                <input type="date" id="filterTanggalAwal" placeholder="Dari tanggal">
                <input type="date" id="filterTanggalAkhir" placeholder="Sampai tanggal">
                <select id="filterJenis">
                    <option value="">Semua Jenis</option>
                    <option value="masuk">Pemasukan</option>
                    <option value="keluar">Pengeluaran</option>
                </select>
                <input type="text" id="filterDeskripsi" placeholder="Cari deskripsi...">
                <button class="filter-btn" onclick="applyFilter()">Filter</button>
                <button class="filter-btn filter-btn-reset" onclick="resetFilter()">Reset</button>
            </div>
            
            <div class="table-wrapper">
                <table id="tabelKeuangan">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Jenis</th>
                            <th class="currency">Jumlah</th>
                            <th class="currency">Saldo</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data transaksi akan muncul di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
            <div class="modal-title">Edit Transaksi</div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="form-group">
                        <label for="editJenis">Jenis</label>
                        <select id="editJenis" required>
                            <option value="masuk">Pemasukan</option>
                            <option value="keluar">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editDeskripsi">Deskripsi</label>
                        <input type="text" id="editDeskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="editTanggal">Tanggal</label>
                        <input type="date" id="editTanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="editJumlah">Jumlah (Rp)</label>
                        <input type="text" id="editJumlah" required>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button class="btn-save" onclick="saveEdit()">Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <script>
    const businessName = <?= json_encode($this->session->userdata('usaha') ?: 'Bisnis Anda'); ?>;
    let transaksi = [];
    let filteredTransaksi = [];
    let isFilterActive = false;
    let editingIndex = -1;

    function renderLucideIcons() {
        if (window.lucide) {
            lucide.createIcons();
        }
    }

    function toggleSidebar() {
        if (window.innerWidth <= 1024) {
            return;
        }
        document.body.classList.toggle('sidebar-collapsed');
        document.getElementById('sidebar').classList.toggle('collapsed');
    }

    function getDisplayData() {
        return isFilterActive ? filteredTransaksi : transaksi;
    }

    function getSummaryData() {
        return transaksi;
    }

    function refreshFilteredData() {
        if (!isFilterActive) {
            filteredTransaksi = [];
            return;
        }

        const filterTanggalAwal = document.getElementById('filterTanggalAwal').value;
        const filterTanggalAkhir = document.getElementById('filterTanggalAkhir').value;
        const tanggalAwal = filterTanggalAwal ? new Date(filterTanggalAwal) : null;
        const tanggalAkhir = filterTanggalAkhir ? new Date(filterTanggalAkhir) : null;
        const jenis = document.getElementById('filterJenis').value;
        const deskripsi = document.getElementById('filterDeskripsi').value.toLowerCase().trim();

        filteredTransaksi = transaksi.filter(tx => {
            let match = true;

            if (tanggalAwal && tx.tanggalObj < tanggalAwal) {
                match = false;
            }

            if (tanggalAkhir) {
                const batasAkhir = new Date(tanggalAkhir);
                batasAkhir.setHours(23, 59, 59, 999);
                if (tx.tanggalObj > batasAkhir) {
                    match = false;
                }
            }

            if (jenis && tx.jenis !== jenis) {
                match = false;
            }

            if (deskripsi && !tx.deskripsi.toLowerCase().includes(deskripsi)) {
                match = false;
            }

            return match;
        });
    }

    function getExportRows() {
        let saldo = 0;
        return getDisplayData().map(tx => {
            if (tx.jenis === 'masuk') {
                saldo += tx.jumlah;
            } else {
                saldo -= tx.jumlah;
            }

            return {
                tanggal: tx.tanggal,
                deskripsi: tx.deskripsi,
                jenis: tx.jenis === 'masuk' ? 'Masuk' : 'Keluar',
                jumlah: tx.jumlah,
                saldo: saldo
            };
        });
    }

    function toggleExportMenu(event) {
        event.stopPropagation();
        const menu = document.getElementById('exportMenu');
        if (!menu) return;
        menu.classList.toggle('show');
    }

    function closeExportMenu() {
        const menu = document.getElementById('exportMenu');
        if (menu) {
            menu.classList.remove('show');
        }
    }

    function exportTransactions(format) {
        const rows = getExportRows();
        closeExportMenu();

        if (!rows.length) {
            alert('Tidak ada data transaksi untuk diekspor.');
            return;
        }

        const fileDate = new Date().toISOString().slice(0, 10);

        if (format === 'csv') {
            const headers = ['Tanggal', 'Deskripsi', 'Jenis', 'Jumlah', 'Saldo'];
            const csvContent = [
                headers.join(','),
                ...rows.map(row => [
                    `"${String(row.tanggal).replace(/"/g, '""')}"`,
                    `"${String(row.deskripsi).replace(/"/g, '""')}"`,
                    `"${row.jenis}"`,
                    `"${row.jumlah}"`,
                    `"${row.saldo}"`
                ].join(','))
            ].join('\n');

            const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `transaksi-${fileDate}.csv`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            return;
        }

        if (format === 'pdf') {
            if (!window.jspdf || !window.jspdf.jsPDF) {
                alert('Library PDF belum tersedia.');
                return;
            }

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const totalPemasukan = rows
                .filter(row => row.jenis === 'Masuk')
                .reduce((sum, row) => sum + row.jumlah, 0);
            const totalPengeluaran = rows
                .filter(row => row.jenis === 'Keluar')
                .reduce((sum, row) => sum + row.jumlah, 0);
            const saldoAkhir = totalPemasukan - totalPengeluaran;

            doc.setFontSize(14);
            doc.text('Laporan Transaksi Keuangan', 14, 14);
            doc.setFontSize(10);
            doc.text(`Nama Bisnis: ${businessName}`, 14, 21);
            doc.text(`Tanggal Cetak: ${new Date().toLocaleDateString('id-ID')}`, 14, 27);

            doc.autoTable({
                startY: 33,
                head: [['Tanggal', 'Deskripsi', 'Jenis', 'Jumlah', 'Saldo']],
                body: rows.map(row => [
                    row.tanggal,
                    row.deskripsi,
                    row.jenis,
                    `Rp ${row.jumlah.toLocaleString('id-ID')}`,
                    `Rp ${row.saldo.toLocaleString('id-ID')}`
                ]),
                theme: 'grid',
                styles: { fontSize: 9, cellPadding: 2 },
                headStyles: { fillColor: [28, 100, 148], textColor: [255, 255, 255] },
                columnStyles: {
                    3: { halign: 'right' },
                    4: { halign: 'right' }
                },
                didDrawPage: function(data) {
                    const pageSize = doc.internal.pageSize;
                    const pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    doc.setFontSize(9);
                    doc.text(`Halaman ${data.pageNumber}`, pageSize.getWidth() - 30, pageHeight - 8);
                }
            });

            const finalY = doc.lastAutoTable ? doc.lastAutoTable.finalY + 8 : 45;
            doc.setFontSize(10);
            doc.text(`Total Pemasukan: Rp ${totalPemasukan.toLocaleString('id-ID')}`, 14, finalY);
            doc.text(`Total Pengeluaran: Rp ${totalPengeluaran.toLocaleString('id-ID')}`, 14, finalY + 6);
            doc.text(`Saldo Akhir: Rp ${saldoAkhir.toLocaleString('id-ID')}`, 14, finalY + 12);

            doc.save(`laporan-keuangan-${fileDate}.pdf`);
        }
    }

    document.addEventListener('click', function(event) {
        const exportArea = document.querySelector('.export-dropdown');
        if (!exportArea || !exportArea.contains(event.target)) {
            closeExportMenu();
        }
    });
    
    // Initialize date input dengan hari ini
    document.getElementById('tanggalInput').valueAsDate = new Date();
    
    // Format Rupiah saat input
    document.getElementById('jumlah').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            e.target.value = parseInt(value).toLocaleString('id-ID');
        }
    });
    
    document.getElementById('editJumlah').addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        if (value) {
            e.target.value = parseInt(value).toLocaleString('id-ID');
        }
    });

    function updateSubmitState() {
        const submitBtn = document.querySelector('#formKeuangan button[type="submit"]');
        if (!submitBtn || submitBtn.dataset.submitting === 'true') {
            return;
        }

        const jenis = document.getElementById('jenisTransaksi').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const tanggal = document.getElementById('tanggalInput').value;
        const jumlahText = document.getElementById('jumlah').value.replace(/[^0-9]/g, '');
        const jumlah = parseInt(jumlahText, 10);

        const isReady = Boolean(jenis && deskripsi && tanggal && jumlah && jumlah > 0);
        submitBtn.disabled = !isReady;
    }

    ['jenisTransaksi', 'deskripsi', 'tanggalInput', 'jumlah'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updateSubmitState);
            el.addEventListener('change', updateSubmitState);
        }
    });

    updateSubmitState();
    
    // Validasi form sebelum submit
    function validateForm() {
        const jenis = document.getElementById('jenisTransaksi').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const tanggalInput = document.getElementById('tanggalInput').value;
        const jumlahText = document.getElementById('jumlah').value.replace(/[^0-9]/g, '');
        const jumlah = parseInt(jumlahText);
        
        let isValid = true;
        
        if (!jenis) {
            showError('jenisTransaksi', 'Pilih jenis transaksi');
            isValid = false;
        }
        
        if (!deskripsi) {
            showError('deskripsi', 'Deskripsi tidak boleh kosong');
            isValid = false;
        } else {
            hideError('deskripsi');
        }

        if (!tanggalInput) {
            alert('Tanggal transaksi wajib diisi.');
            isValid = false;
        }
        
        if (!jumlah || isNaN(jumlah) || jumlah <= 0) {
            showError('jumlah', 'Jumlah harus lebih besar dari 0');
            isValid = false;
        } else {
            hideError('jumlah');
        }
        
        return isValid;
    }
    
    function showError(fieldId, message) {
        const errorId = `error${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`;
        const errorEl = document.getElementById(errorId);
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.add('show');
        }
    }
    
    function hideError(fieldId) {
        const errorId = `error${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`;
        const errorEl = document.getElementById(errorId);
        if (errorEl) {
            errorEl.classList.remove('show');
        }
    }
    
    // Tambah transaksi baru
    function tambahTransaksi(e) {
        e.preventDefault();
        
        if (!validateForm()) return;
        
        const jenis = document.getElementById('jenisTransaksi').value;
        const deskripsi = document.getElementById('deskripsi').value.trim();
        const tanggalInput = document.getElementById('tanggalInput').value;
        const jumlahRaw = document.getElementById('jumlah').value.replace(/[^0-9]/g, '');
        const jumlah = parseInt(jumlahRaw);
        const submitBtn = document.querySelector('#formKeuangan button[type="submit"]');
        if (submitBtn) {
            submitBtn.dataset.submitting = 'true';
            submitBtn.disabled = true;
        }
        
        // Format tanggal ke Indonesia
        const tanggalObj = new Date(tanggalInput);
        const tanggal = tanggalObj.toLocaleDateString('id-ID', { 
            weekday: 'short',
            day: '2-digit', 
            month: 'long', 
            year: 'numeric' 
        });
        
        const tempId = Date.now();
        const newTx = { 
            id: tempId,
            tanggal, 
            tanggalObj,
            deskripsi, 
            jenis, 
            jumlah 
        };
        
        transaksi.unshift(newTx);
        refreshFilteredData();
        updateTabel();
        
        // Simpan ke backend
        const formData = new FormData();
        formData.append('tanggal', tanggalInput);
        formData.append('deskripsi', deskripsi);
        formData.append('jenis', jenis);
        formData.append('jumlah', jumlah);
        
        fetch('<?= site_url("keuangan/save_transaksi") ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success || !data.id_transaksi) {
                throw new Error(data.message || 'Gagal menyimpan transaksi');
            }

            // Update ID dengan yang dari backend
            const idx = transaksi.findIndex(t => t.id === tempId);
            if (idx >= 0) {
                transaksi[idx].id = data.id_transaksi;
            }
            saveToLocalStorage();
            console.log('Data tersimpan ke database dengan ID:', data.id_transaksi);
        })
        .catch(error => {
            console.error('Gagal simpan ke backend:', error);
            const idx = transaksi.findIndex(t => t.id === tempId);
            if (idx >= 0) {
                transaksi.splice(idx, 1);
            }
            refreshFilteredData();
            updateTabel();
            alert('Transaksi gagal disimpan ke database. Silakan coba lagi.');
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.dataset.submitting = 'false';
            }
            updateSubmitState();
        });
        
        // Reset form
        document.getElementById('formKeuangan').reset();
        document.getElementById('tanggalInput').valueAsDate = new Date();
        updateSubmitState();
    }
    
    // Update tabel dengan saldo per transaksi
    function updateTabel() {
        const tbody = document.querySelector('#tabelKeuangan tbody');
        tbody.innerHTML = '';
        
        let saldo = 0;
        const displayData = getDisplayData();
        const summaryData = getSummaryData();
        let totalMasuk = 0, totalKeluar = 0;
        
        if (displayData.length === 0) {
            const emptyText = isFilterActive ? 'Tidak ada transaksi sesuai filter' : 'Belum ada transaksi';
            tbody.innerHTML = `<tr><td colspan="6" class="empty-state">${emptyText}</td></tr>`;
        } else {
            displayData.forEach((tx, index) => {
                saldo += tx.jenis === 'masuk' ? tx.jumlah : -tx.jumlah;
                
                const badge = tx.jenis === 'masuk' 
                    ? '<span class="badge income">Masuk</span>' 
                    : '<span class="badge expense">Keluar</span>';
                
                const saldoClass = saldo >= 0 ? 'saldo-positive' : 'saldo-negative';
                const realIndex = transaksi.findIndex(t => t.id === tx.id);
                
                tbody.innerHTML += `<tr>
                    <td>${tx.tanggal}</td>
                    <td>${tx.deskripsi}</td>
                    <td>${badge}</td>
                    <td class="currency" style="color: ${tx.jenis === 'masuk' ? '#16a34a' : '#ef4444'};">Rp ${tx.jumlah.toLocaleString('id-ID')}</td>
                    <td class="currency ${saldoClass}">Rp ${saldo.toLocaleString('id-ID')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal(${realIndex})" title="Edit" aria-label="Edit">
                                <i data-lucide="pencil"></i>
                            </button>
                            <button class="btn-delete" onclick="deleteTransaksi(${realIndex})" title="Hapus" aria-label="Hapus">
                                <i data-lucide="trash-2"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
            });
        }

        summaryData.forEach(tx => {
            if (tx.jenis === 'masuk') {
                totalMasuk += tx.jumlah;
            } else {
                totalKeluar += tx.jumlah;
            }
        });
        
        // Update ringkasan
        document.getElementById('totalMasuk').textContent = 'Rp ' + totalMasuk.toLocaleString('id-ID');
        document.getElementById('totalKeluar').textContent = 'Rp ' + totalKeluar.toLocaleString('id-ID');
        document.getElementById('saldoAkhir').textContent = 'Rp ' + (totalMasuk - totalKeluar).toLocaleString('id-ID');
        document.getElementById('jumlahTransaksi').textContent = transaksi.length;
        
        if (transaksi.length > 0) {
            const lastTx = transaksi[0];
            const lastDay = lastTx.tanggalObj.toLocaleDateString('id-ID', { weekday: 'long' });
            document.getElementById('lastTransaction').textContent = 'Transaksi terakhir: ' + lastDay;
        } else {
            document.getElementById('lastTransaction').textContent = '-';
        }
        
        // Warna saldo akhir
        const saldoFinal = totalMasuk - totalKeluar;
        if (saldoFinal >= 0) {
            document.getElementById('saldoAkhir').parentElement.classList.remove('expense');
            document.getElementById('saldoAkhir').parentElement.classList.add('income');
            document.getElementById('saldoTrend').textContent = 'Positif';
        } else {
            document.getElementById('saldoAkhir').parentElement.classList.remove('income');
            document.getElementById('saldoAkhir').parentElement.classList.add('expense');
            document.getElementById('saldoTrend').textContent = 'Negatif';
        }
        
        // Auto save ke localStorage
        saveToLocalStorage();
        renderLucideIcons();
    }
    
    // Filter transaksi
    function applyFilter() {
        const filterTanggalAwal = document.getElementById('filterTanggalAwal').value;
        const filterTanggalAkhir = document.getElementById('filterTanggalAkhir').value;
        const jenis = document.getElementById('filterJenis').value;
        const deskripsi = document.getElementById('filterDeskripsi').value.toLowerCase().trim();

        isFilterActive = Boolean(filterTanggalAwal || filterTanggalAkhir || jenis || deskripsi);

        if (!isFilterActive) {
            filteredTransaksi = [];
            updateTabel();
            return;
        }

        refreshFilteredData();
        
        updateTabel();
    }
    
    function resetFilter() {
        document.getElementById('filterTanggalAwal').value = '';
        document.getElementById('filterTanggalAkhir').value = '';
        document.getElementById('filterJenis').value = '';
        document.getElementById('filterDeskripsi').value = '';
        isFilterActive = false;
        filteredTransaksi = [];
        updateTabel();
    }
    
    // Edit modal
    function openEditModal(index) {
        editingIndex = index;
        const tx = transaksi[index];
        document.getElementById('editJenis').value = tx.jenis;
        document.getElementById('editDeskripsi').value = tx.deskripsi;
        document.getElementById('editTanggal').value = tx.tanggalObj.toISOString().split('T')[0];
        document.getElementById('editJumlah').value = tx.jumlah.toLocaleString('id-ID');
        document.getElementById('editModal').classList.add('active');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
        editingIndex = -1;
    }
    
    function saveEdit() {
        const jenis = document.getElementById('editJenis').value;
        const deskripsi = document.getElementById('editDeskripsi').value.trim();
        const tanggalInput = document.getElementById('editTanggal').value;
        const jumlahRaw = document.getElementById('editJumlah').value.replace(/[^0-9]/g, '');
        const jumlah = parseInt(jumlahRaw);
        
        if (!deskripsi || !jumlah || jumlah <= 0) {
            alert('Data tidak valid');
            return;
        }
        
        const tanggalObj = new Date(tanggalInput);
        const tanggal = tanggalObj.toLocaleDateString('id-ID', { 
            weekday: 'short',
            day: '2-digit', 
            month: 'long', 
            year: 'numeric' 
        });
        
        // Simpan ke backend
        const formData = new FormData();
        formData.append('jenis', jenis);
        formData.append('deskripsi', deskripsi);
        formData.append('tanggal', tanggalInput);
        formData.append('jumlah', jumlah);
        
        const txId = transaksi[editingIndex].id;
        
        fetch('<?= site_url("keuangan/update_transaksi/") ?>' + txId, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                transaksi[editingIndex] = { 
                    id: txId,
                    tanggal, 
                    tanggalObj,
                    deskripsi, 
                    jenis, 
                    jumlah 
                };
                
                // Sort by date
                transaksi.sort((a, b) => b.tanggalObj - a.tanggalObj);
                
                refreshFilteredData();
                updateTabel();
                closeEditModal();
            }
        })
        .catch(error => {
            console.log('Update failed');
            alert('Gagal menyimpan perubahan');
        });
    }
    
    // Hapus transaksi dengan konfirmasi
    function deleteTransaksi(index) {
        if (confirm('Yakin ingin menghapus transaksi ini?')) {
            const txId = transaksi[index].id;
            
            fetch('<?= site_url("keuangan/delete_transaksi/") ?>' + txId, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    transaksi.splice(index, 1);
                    refreshFilteredData();
                    updateTabel();
                }
            })
            .catch(error => {
                console.log('Delete failed');
                alert('Gagal menghapus data dari database. Silakan coba lagi.');
            });
        }
    }
    
    // Load data dari backend saat startup
    window.addEventListener('load', () => {
        renderLucideIcons();
        loadDataFromBackend();
    });
    
    // Load data dari backend database
    function loadDataFromBackend() {
        fetch('<?= site_url("keuangan/get_data") ?>')
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Data dari backend:', data);
                if (data.success && Array.isArray(data.transaksi)) {
                    transaksi = data.transaksi.map(tx => {
                        const dateObj = new Date(tx.tanggal);
                        return {
                            id: tx.id_transaksi,
                            tanggal: dateObj.toLocaleDateString('id-ID', { 
                                weekday: 'short',
                                day: '2-digit', 
                                month: 'long', 
                                year: 'numeric' 
                            }),
                            tanggalObj: dateObj,
                            deskripsi: tx.deskripsi,
                            jenis: (tx.jenis === 'pemasukan') ? 'masuk' : 'keluar',
                            jumlah: parseInt(tx.nominal)
                        };
                    });
                    // Sort by date descending
                    transaksi.sort((a, b) => b.tanggalObj - a.tanggalObj);
                    saveToLocalStorage();
                    console.log('Data berhasil dimuat dari backend, total:', transaksi.length);
                } else {
                    console.log('Backend return empty atau error');
                    transaksi = [];
                }
                updateTabel();
            })
            .catch(error => {
                console.error('Load dari backend gagal:', error);
                loadFromLocalStorage();
                updateTabel();
            });
    }
    
    // Simpan ke localStorage
    function saveToLocalStorage() {
        const dataToSave = transaksi.map(tx => ({
            id: tx.id,
            tanggal: tx.tanggal,
            tanggalObj: tx.tanggalObj.toISOString(),
            deskripsi: tx.deskripsi,
            jenis: tx.jenis,
            jumlah: tx.jumlah
        }));
        localStorage.setItem('pencatatan_keuangan', JSON.stringify(dataToSave));
        localStorage.setItem('keuangan_last_updated', String(Date.now()));
        console.log('Data disimpan ke localStorage, total:', dataToSave.length);
    }
    
    // Load dari localStorage
    function loadFromLocalStorage() {
        const saved = localStorage.getItem('pencatatan_keuangan');
        console.log('Mencoba load dari localStorage...');
        if (saved) {
            try {
                const parsed = JSON.parse(saved);
                transaksi = parsed.map(tx => ({
                    id: tx.id,
                    tanggal: tx.tanggal,
                    tanggalObj: new Date(tx.tanggalObj),
                    deskripsi: tx.deskripsi,
                    jenis: tx.jenis,
                    jumlah: tx.jumlah
                }));
                console.log('Data berhasil dimuat dari localStorage, total:', transaksi.length);
            } catch (e) {
                console.error('Error parsing localStorage:', e);
                transaksi = [];
            }
        } else {
            console.log('Tidak ada data di localStorage');
            transaksi = [];
        }
    }
    
    
    </script>
</body>
</html>
