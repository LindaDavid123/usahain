<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPP Calculator - Usahain</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4A90E2;
            --success: #27ae60;
            --danger: #e74c3c;
            --warning: #f39c12;
            --bg: #F5F8FA;
            --card: #FFFFFF;
            --muted: #7f8c8d;
            --shadow: 0 4px 16px rgba(74,144,226,0.08);
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Arial, sans-serif; background: var(--bg); color: #2D3748; }
        nav { background: linear-gradient(90deg, var(--primary), #7EC8E3); color: #fff; padding: 18px 32px; font-size: 1.1rem; display: flex; align-items: center; }
        nav a { color: #fff; margin-right: 28px; text-decoration: none; font-weight: 600; transition: color 0.2s; }
        nav a:hover { color: #dbeafe; }
        nav .logout { margin-left: auto; }
        .container { max-width: 1100px; margin: 32px auto; padding: 0 18px; }
        .card { background: var(--card); border-radius: 16px; box-shadow: var(--shadow); padding: 32px 28px; margin-bottom: 32px; }
        .header { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 12px; }
        .header h2 { font-size: 1.5rem; font-weight: 700; color: var(--primary); }
        .btn { display: inline-block; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-warning { background: var(--warning); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn:hover { opacity: 0.92; }
        .summary-row { display: flex; gap: 18px; margin-bottom: 18px; }
        .summary-card { background: #eaf2ff; border-radius: 12px; padding: 18px 24px; flex: 1; text-align: center; box-shadow: 0 2px 8px rgba(74,144,226,0.08); }
        .summary-card .label { color: var(--muted); font-size: 1rem; margin-bottom: 4px; }
        .summary-card .value { font-size: 1.3rem; font-weight: 700; color: var(--primary); }
        .filter-row { display: flex; gap: 12px; margin-bottom: 18px; }
        .filter-row input[type="text"] { flex: 2; padding: 12px 16px; border-radius: 8px; border: 1.5px solid #e2e8f0; font-size: 1rem; background: #f7fafc; }
        .filter-row select { flex: 1; padding: 12px 16px; border-radius: 8px; border: 1.5px solid #e2e8f0; font-size: 1rem; background: #f7fafc; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; font-size: 1rem; }
        th, td { padding: 14px 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f7fafc; color: var(--primary); font-weight: 700; }
        .currency { text-align: right; font-weight: 600; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 0.98em; font-weight: 600; }
        .badge.success { background: #e6f9ed; color: var(--success); }
        .badge.danger { background: #ffecec; color: var(--danger); }
        .badge.warning { background: #fff5e6; color: var(--warning); }
        .alert { padding: 14px; margin-bottom: 20px; border-radius: 8px; font-size: 1rem; }
        .alert-success { background: #d4edda; color: #155724; }
        @media (max-width: 900px) {
            .summary-row, .filter-row { flex-direction: column; gap: 10px; }
            .header { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('dashboard'); ?>">Dashboard</a>
        <a href="<?= site_url('hpp'); ?>">HPP Calculator</a>
        <a href="<?= site_url('auth/logout'); ?>" class="logout">Logout (<?= $this->session->userdata('nama'); ?>)</a>
    </nav>
    <div class="container">
        <div class="card">
            <div class="header">
                <h2>HPP Calculator - Perhitungan Biaya Produksi</h2>
                <a href="<?= site_url('hpp/create'); ?>" class="btn btn-success">+ Tambah HPP</a>
            </div>
            <div class="summary-row">
                <div class="summary-card">
                    <div class="label">Total Data HPP</div>
                    <div class="value"><?= isset($hpp_list) ? count($hpp_list) : 0 ?></div>
                </div>
                <div class="summary-card">
                    <div class="label">Rata-rata Margin</div>
                    <div class="value">
                        <?php 
                        $avg_margin = 0;
                        if (!empty($hpp_list)) {
                            $total_margin = 0;
                            foreach ($hpp_list as $hpp) {
                                $total_margin += ($hpp->harga_jual - $hpp->total_biaya);
                            }
                            $avg_margin = $total_margin / count($hpp_list);
                        }
                        echo 'Rp ' . number_format($avg_margin, 0, ',', '.');
                        ?>
                    </div>
                </div>
            </div>
            <div class="filter-row">
                <input type="text" id="searchInput" placeholder="Cari data HPP..." onkeyup="filterTable()">
                <select id="marginFilter" onchange="filterTable()">
                    <option value="">Semua Margin</option>
                    <option value="plus">Margin Positif</option>
                    <option value="minus">Margin Negatif</option>
                </select>
            </div>
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if (empty($hpp_list)) : ?>
                <p style="padding: 20px; text-align: center; color: var(--muted);">Belum ada data HPP. <a href="<?= site_url('hpp/create'); ?>">Buat yang baru</a></p>
            <?php else : ?>
                <table id="hppTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Biaya Bahan</th>
                            <th>Biaya Tenaga Kerja</th>
                            <th>Total Biaya</th>
                            <th>Harga Jual</th>
                            <th>Margin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($hpp_list as $hpp) : ?>
                        <?php $margin = $hpp->harga_jual - $hpp->total_biaya; ?>
                        <tr data-margin="<?= $margin >= 0 ? 'plus' : 'minus' ?>">
                            <td><?= $no++; ?></td>
                            <td class="currency">Rp <?= number_format($hpp->bahan, 0, ',', '.'); ?></td>
                            <td class="currency">Rp <?= number_format($hpp->tenaga_kerja, 0, ',', '.'); ?></td>
                            <td class="currency"><strong>Rp <?= number_format($hpp->total_biaya, 0, ',', '.'); ?></strong></td>
                            <td class="currency">Rp <?= number_format($hpp->harga_jual, 0, ',', '.'); ?></td>
                            <td class="currency">
                                <span class="badge <?= $margin > 0 ? 'success' : ($margin < 0 ? 'danger' : 'warning') ?>">
                                    Rp <?= number_format($margin, 0, ',', '.'); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= site_url('hpp/view/'.$hpp->id_hpp); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Lihat</a>
                                <a href="<?= site_url('hpp/edit/'.$hpp->id_hpp); ?>" class="btn btn-warning" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                                <a href="<?= site_url('hpp/delete/'.$hpp->id_hpp); ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script>
    function filterTable() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var marginFilter = document.getElementById('marginFilter').value;
        var table = document.getElementById('hppTable');
        if (!table) return;
        var trs = table.getElementsByTagName('tr');
        for (var i = 1; i < trs.length; i++) {
            var tr = trs[i];
            var text = tr.textContent.toLowerCase();
            var marginType = tr.getAttribute('data-margin');
            var show = true;
            if (input && text.indexOf(input) === -1) show = false;
            if (marginFilter && marginType !== marginFilter) show = false;
            tr.style.display = show ? '' : 'none';
        }
    }
    </script>
</body>
</html>
