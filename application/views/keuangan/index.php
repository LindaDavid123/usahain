<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatatan Keuangan - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4A90E2;
            --success: #27ae60;
            --danger: #e74c3c;
            --bg: #F5F8FA;
            --card: #FFFFFF;
            --muted: #7f8c8d;
            --shadow: 0 4px 16px rgba(74,144,226,0.08);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; background: var(--bg); color: #2D3748; }
        .container { max-width: 900px; margin: 32px auto; padding: 0 18px; }
        .card { background: var(--card); border-radius: 16px; box-shadow: var(--shadow); padding: 32px 28px; margin-bottom: 32px; }
        h2 { color: var(--primary); font-size: 1.4rem; font-weight: 700; margin-bottom: 18px; }
        .summary-row { display: flex; gap: 18px; margin-bottom: 18px; }
        .summary-card { background: #eaf2ff; border-radius: 12px; padding: 18px 24px; flex: 1; text-align: center; box-shadow: 0 2px 8px rgba(74,144,226,0.08); }
        .summary-card .label { color: var(--muted); font-size: 1rem; margin-bottom: 4px; }
        .summary-card .value { font-size: 1.3rem; font-weight: 700; color: var(--primary); }
        .form-row { display: flex; gap: 12px; margin-bottom: 18px; }
        .form-row input, .form-row select { flex: 1; padding: 12px 16px; border-radius: 8px; border: 1.5px solid #e2e8f0; font-size: 1rem; background: #f7fafc; }
        .btn { padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; background: var(--primary); color: #fff; transition: background 0.2s; }
        .btn:hover { opacity: 0.92; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; font-size: 1rem; }
        th, td { padding: 14px 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f7fafc; color: var(--primary); font-weight: 700; }
        .currency { text-align: right; font-weight: 600; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 0.98em; font-weight: 600; }
        .badge.success { background: #e6f9ed; color: var(--success); }
        .badge.danger { background: #ffecec; color: var(--danger); }
        @media (max-width: 900px) { .summary-row, .form-row { flex-direction: column; gap: 10px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Pencatatan Keuangan</h2>
            <div class="summary-row">
                <div class="summary-card">
                    <div class="label">Saldo Akhir</div>
                    <div class="value" id="saldoAkhir">Rp 0</div>
                </div>
                <div class="summary-card">
                    <div class="label">Total Pemasukan</div>
                    <div class="value" id="totalMasuk">Rp 0</div>
                </div>
                <div class="summary-card">
                    <div class="label">Total Pengeluaran</div>
                    <div class="value" id="totalKeluar">Rp 0</div>
                </div>
            </div>
            <form id="formKeuangan" onsubmit="tambahTransaksi(event)">
                <div class="form-row">
                    <select id="jenisTransaksi" required>
                        <option value="masuk">Pemasukan</option>
                        <option value="keluar">Pengeluaran</option>
                    </select>
                    <input type="text" id="deskripsi" placeholder="Deskripsi" required>
                    <input type="text" id="jumlah" placeholder="Jumlah (Rp)" required oninput="formatRupiah(this)">
                    <button type="submit" class="btn">Tambah</button>
                </div>
            </form>
            <table id="tabelKeuangan">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Jenis</th>
                        <th class="currency">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data transaksi akan muncul di sini -->
                </tbody>
            </table>
        </div>
    </div>
    <script>
    let transaksi = [];
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('id-ID');
        }
        input.value = value;
    }
    function tambahTransaksi(e) {
        e.preventDefault();
        const jenis = document.getElementById('jenisTransaksi').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const jumlahRaw = document.getElementById('jumlah').value.replace(/[^0-9]/g, '');
        const jumlah = parseInt(jumlahRaw);
        if (!jumlah || isNaN(jumlah) || jumlah <= 0) {
            alert('Masukkan jumlah yang valid!');
            return;
        }
        const tanggal = new Date().toLocaleDateString('id-ID');
        transaksi.unshift({ tanggal, deskripsi, jenis, jumlah });
        updateTabel();
        document.getElementById('formKeuangan').reset();
    }
    function updateTabel() {
        const tbody = document.querySelector('#tabelKeuangan tbody');
        tbody.innerHTML = '';
        let totalMasuk = 0, totalKeluar = 0;
        transaksi.forEach(tx => {
            if (tx.jenis === 'masuk') totalMasuk += tx.jumlah;
            else totalKeluar += tx.jumlah;
            const badge = tx.jenis === 'masuk' ? '<span class="badge success">Masuk</span>' : '<span class="badge danger">Keluar</span>';
            tbody.innerHTML += `<tr>
                <td>${tx.tanggal}</td>
                <td>${tx.deskripsi}</td>
                <td>${badge}</td>
                <td class="currency">Rp ${tx.jumlah.toLocaleString('id-ID')}</td>
            </tr>`;
        });
        document.getElementById('totalMasuk').textContent = 'Rp ' + totalMasuk.toLocaleString('id-ID');
        document.getElementById('totalKeluar').textContent = 'Rp ' + totalKeluar.toLocaleString('id-ID');
        document.getElementById('saldoAkhir').textContent = 'Rp ' + (totalMasuk-totalKeluar).toLocaleString('id-ID');
    }
    </script>
</body>
</html>
