<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Keuangan - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0b6ea8;
            --primary-dark: #084f8a;
            --primary-light: #ecf9ff;
            --secondary: #27b0e3;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --text: #1E293B;
            --text-secondary: #64748B;
            --bg: #f8fafc;
            --card: #FFFFFF;
            --border: #E2E8F0;
            --shadow: 0 4px 12px rgba(11,110,168,0.1);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; background: linear-gradient(135deg, #ecf9ff 0%, #dff4fb 50%, #d0ecf8 100%); color: var(--text); min-height: 100vh; }
        nav { background: linear-gradient(135deg, #0b6ea8 0%, #1a8dd5 50%, #27b0e3 100%); color: #fff; padding: 18px 32px; display: flex; align-items: center; box-shadow: 0 4px 24px rgba(11,110,168,0.25); }
        nav a { color: #fff; margin-right: 28px; text-decoration: none; font-weight: 600; transition: color 0.2s; }
        nav a:hover { color: rgba(255,255,255,0.8); }
        nav .logout { margin-left: auto; }
        .container { max-width: 1200px; margin: 32px auto; padding: 0 18px; }
        
        /* Header */
        .page-header { margin-bottom: 32px; }
        .page-header h1 { font-size: 2rem; font-weight: 800; color: #084f8a; margin-bottom: 8px; }
        .page-header p { font-size: 1rem; color: #64748b; }
        
        /* Summary Cards */
        .summary-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; margin-bottom: 32px; }
        .summary-card { background: var(--card); border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-top: 4px solid var(--primary); }
        .summary-card.income { border-top-color: var(--success); }
        .summary-card.expense { border-top-color: var(--danger); }
        .summary-card .label { color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; margin-bottom: 8px; }
        .summary-card .value { font-size: 1.8rem; font-weight: 800; color: #084f8a; }
        .summary-card .change { font-size: 0.85rem; margin-top: 6px; color: var(--text-secondary); }
        
        /* Card Container */
        .card { background: var(--card); border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 28px; margin-bottom: 32px; }
        .card-title { font-size: 1.3rem; font-weight: 800; color: #084f8a; margin-bottom: 20px; }
        
        /* Form Section */
        .form-section { margin-bottom: 28px; padding-bottom: 28px; border-bottom: 2px solid var(--border); }
        .form-section h3 { font-size: 1rem; font-weight: 700; color: #084f8a; margin-bottom: 16px; }
        .form-row { display: grid; grid-template-columns: 1fr 2fr 1fr 1fr 100px; gap: 12px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 6px; }
        .form-row input, .form-row select { padding: 12px 14px; border-radius: 8px; border: 2px solid var(--border); font-size: 0.95rem; background: #fff; color: var(--text); font-weight: 500; }
        .form-row input::placeholder { color: var(--text-secondary); }
        .form-row input:focus, .form-row select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(11,110,168,0.1); }
        
        .btn { padding: 12px 20px; border-radius: 8px; font-weight: 700; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: #fff; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(11,110,168,0.3); }
        .btn-danger { background: var(--danger); color: #fff; padding: 6px 10px; font-size: 0.8rem; }
        .btn-warning { background: var(--warning); color: #fff; padding: 6px 10px; font-size: 0.8rem; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        
        /* Filter Section */
        .filter-section { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-section input, .filter-section select { padding: 10px 14px; border-radius: 8px; border: 2px solid var(--border); font-size: 0.9rem; background: #fff; color: var(--text); }
        .filter-section input:focus, .filter-section select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(11,110,168,0.1); }
        .filter-btn { background: var(--primary); color: #fff; padding: 10px 14px; border-radius: 8px; border: none; cursor: pointer; font-weight: 600; font-size: 0.9rem; }
        .filter-btn:hover { background: var(--primary-dark); }
        
        /* Table */
        .table-wrapper { overflow-x: auto; border-radius: 12px; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 0.95rem; }
        thead { background: linear-gradient(135deg, #0b6ea8 0%, #1a8dd5 100%); }
        th { padding: 14px 12px; color: #fff; font-weight: 700; text-align: left; border: none; }
        th:first-child { border-radius: 12px 0 0 0; }
        th:last-child { border-radius: 0 12px 0 0; }
        tbody tr { border-bottom: 1px solid var(--border); transition: all 0.2s ease; }
        tbody tr:hover { background: #f0f9fc; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:last-child td:first-child { border-radius: 0 0 0 12px; }
        tbody tr:last-child td:last-child { border-radius: 0 0 12px 0; }
        td { padding: 12px; color: var(--text); border: none; }
        td:first-child { color: var(--primary); font-weight: 600; }
        .currency { text-align: right; font-weight: 700; font-variant-numeric: tabular-nums; }
        .saldo-positive { color: var(--success); font-weight: 700; }
        .saldo-negative { color: var(--danger); font-weight: 700; }
        
        .badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
        .badge.income { background: #D1FAE5; color: #065F46; }
        .badge.expense { background: #FEE2E2; color: #991B1B; }
        
        .action-buttons { display: flex; gap: 6px; justify-content: center; }
        .action-buttons button { padding: 6px 10px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.8rem; font-weight: 600; transition: all 0.2s; }
        .action-buttons .btn-edit { background: var(--warning); color: #fff; }
        .action-buttons .btn-delete { background: var(--danger); color: #fff; }
        .action-buttons button:hover { opacity: 0.85; transform: scale(1.05); }
        
        .empty-state { padding: 40px 20px; text-align: center; color: var(--text-secondary); }
        .empty-state p { margin-bottom: 12px; }
        
        /* Modal */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; }
        .modal.active { display: flex; }
        .modal-content { background: var(--card); border-radius: 12px; padding: 28px; max-width: 400px; width: 90%; box-shadow: 0 10px 40px rgba(0,0,0,0.2); animation: slideUp 0.3s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .modal-title { font-size: 1.2rem; font-weight: 700; color: #084f8a; margin-bottom: 16px; }
        .modal-close { float: right; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-secondary); }
        .modal-body { clear: both; margin-bottom: 20px; }
        .modal-body .form-group { margin-bottom: 14px; }
        .modal-actions { display: flex; gap: 12px; }
        .modal-actions button { flex: 1; padding: 12px; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; }
        .modal-actions .btn-save { background: var(--success); color: #fff; }
        .modal-actions .btn-cancel { background: var(--border); color: var(--text); }
        
        /* Error Message */
        .error-message { color: var(--danger); font-size: 0.85rem; margin-top: 4px; display: none; }
        .error-message.show { display: block; }
        
        /* Responsive */
        @media (max-width: 900px) {
            .form-row { grid-template-columns: 1fr 1fr; }
            .filter-section { flex-direction: column; }
            .summary-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('dashboard'); ?>">Dashboard</a>
        <a href="<?= site_url('keuangan'); ?>">Pencatatan Keuangan</a>
        <a href="<?= site_url('auth/logout'); ?>" class="logout">🚪 Log out</a>
    </nav>

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
                        <button type="submit" class="btn btn-primary" style="height: 48px;">Tambah</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filter & Search -->
        <div class="card">
            <div class="card-title">Daftar Transaksi</div>
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
                <button class="filter-btn" style="background: var(--text-secondary);" onclick="resetFilter()">Reset</button>
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
    let transaksi = [];
    let filteredTransaksi = [];
    let editingIndex = -1;
    
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
    
    // Validasi form sebelum submit
    function validateForm() {
        const jenis = document.getElementById('jenisTransaksi').value.trim();
        const deskripsi = document.getElementById('deskripsi').value.trim();
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
            if (data.success && data.id_transaksi) {
                // Update ID dengan yang dari backend
                const idx = transaksi.findIndex(t => t.id === tempId);
                if (idx >= 0) {
                    transaksi[idx].id = data.id_transaksi;
                }
                saveToLocalStorage();
                console.log('Data tersimpan ke database dengan ID:', data.id_transaksi);
            }
        })
        .catch(error => {
            console.error('Gagal simpan ke backend:', error);
            saveToLocalStorage();
        });
        
        // Reset form
        document.getElementById('formKeuangan').reset();
        document.getElementById('tanggalInput').valueAsDate = new Date();
    }
    
    // Update tabel dengan saldo per transaksi
    function updateTabel() {
        const tbody = document.querySelector('#tabelKeuangan tbody');
        tbody.innerHTML = '';
        
        let totalMasuk = 0, totalKeluar = 0, saldo = 0;
        const displayData = filteredTransaksi.length > 0 ? filteredTransaksi : transaksi;
        
        if (displayData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="empty-state">Belum ada transaksi</td></tr>';
        } else {
            displayData.forEach((tx, index) => {
                if (tx.jenis === 'masuk') {
                    totalMasuk += tx.jumlah;
                    saldo += tx.jumlah;
                } else {
                    totalKeluar += tx.jumlah;
                    saldo -= tx.jumlah;
                }
                
                const badge = tx.jenis === 'masuk' 
                    ? '<span class="badge income">Masuk</span>' 
                    : '<span class="badge expense">Keluar</span>';
                
                const saldoClass = saldo >= 0 ? 'saldo-positive' : 'saldo-negative';
                const realIndex = transaksi.findIndex(t => t.id === tx.id);
                
                tbody.innerHTML += `<tr>
                    <td>${tx.tanggal}</td>
                    <td>${tx.deskripsi}</td>
                    <td>${badge}</td>
                    <td class="currency" style="color: ${tx.jenis === 'masuk' ? '#10B981' : '#EF4444'};">Rp ${tx.jumlah.toLocaleString('id-ID')}</td>
                    <td class="currency ${saldoClass}">Rp ${saldo.toLocaleString('id-ID')}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal(${realIndex})" title="Edit">Edit</button>
                            <button class="btn-delete" onclick="deleteTransaksi(${realIndex})" title="Hapus">Hapus</button>
                        </div>
                    </td>
                </tr>`;
            });
        }
        
        // Update ringkasan
        document.getElementById('totalMasuk').textContent = 'Rp ' + totalMasuk.toLocaleString('id-ID');
        document.getElementById('totalKeluar').textContent = 'Rp ' + totalKeluar.toLocaleString('id-ID');
        document.getElementById('saldoAkhir').textContent = 'Rp ' + (totalMasuk - totalKeluar).toLocaleString('id-ID');
        document.getElementById('jumlahTransaksi').textContent = transaksi.length;
        
        if (transaksi.length > 0) {
            const lastTx = transaksi[0];
            const lastDate = lastTx.tanggal.split(',')[0];
            document.getElementById('lastTransaction').textContent = 'Transaksi terakhir: ' + lastDate;
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
    }
    
    // Filter transaksi
    function applyFilter() {
        const tanggalAwal = new Date(document.getElementById('filterTanggalAwal').value);
        const tanggalAkhir = new Date(document.getElementById('filterTanggalAkhir').value);
        const jenis = document.getElementById('filterJenis').value;
        const deskripsi = document.getElementById('filterDeskripsi').value.toLowerCase();
        
        filteredTransaksi = transaksi.filter(tx => {
            let match = true;
            
            if (document.getElementById('filterTanggalAwal').value) {
                if (tx.tanggalObj < tanggalAwal) match = false;
            }
            
            if (document.getElementById('filterTanggalAkhir').value) {
                tanggalAkhir.setHours(23, 59, 59);
                if (tx.tanggalObj > tanggalAkhir) match = false;
            }
            
            if (jenis && tx.jenis !== jenis) match = false;
            
            if (deskripsi && !tx.deskripsi.toLowerCase().includes(deskripsi)) match = false;
            
            return match;
        });
        
        updateTabel();
    }
    
    function resetFilter() {
        document.getElementById('filterTanggalAwal').value = '';
        document.getElementById('filterTanggalAkhir').value = '';
        document.getElementById('filterJenis').value = '';
        document.getElementById('filterDeskripsi').value = '';
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
                    updateTabel();
                }
            })
            .catch(error => {
                console.log('Delete failed');
                // Fallback: delete dari array saja
                transaksi.splice(index, 1);
                updateTabel();
            });
        }
    }
    
    // Load data dari backend saat startup
    window.addEventListener('load', () => {
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
                if (data.success && data.transaksi && data.transaksi.length > 0) {
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
                    loadFromLocalStorage();
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
    
    
    // Load pada startup
    window.addEventListener('load', () => {
        loadDataFromBackend();
    });
    </script>
</body>
</html>
