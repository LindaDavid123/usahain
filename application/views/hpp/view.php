<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail HPP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: #2c3e50; }
        .detail-group { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #ecf0f1; }
        .detail-label { font-weight: bold; color: #34495e; margin-bottom: 5px; }
        .detail-value { color: #7f8c8d; font-size: 16px; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn:hover { opacity: 0.8; }
        .highlight { background-color: #fffacd; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .margin-positive { color: #27ae60; font-weight: bold; }
        .margin-negative { color: #e74c3c; font-weight: bold; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('dashboard'); ?>">Dashboard</a>
        <a href="<?= site_url('hpp'); ?>">HPP Calculator</a>
        <a href="<?= site_url('auth/logout'); ?>" style="float: right;">Logout (<?= $this->session->userdata('nama'); ?>)</a>
    </nav>
    <div class="container">
        <div class="card">
            <h2>Detail Perhitungan HPP</h2>

            <div class="detail-group">
                <div class="detail-label">ID HPP</div>
                <div class="detail-value"><?= $hpp->id_hpp; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Biaya Bahan</div>
                <div class="detail-value">Rp <?= number_format($hpp->bahan, 0, ',', '.'); ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Biaya Tenaga Kerja</div>
                <div class="detail-value">Rp <?= number_format($hpp->tenaga_kerja, 0, ',', '.'); ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Total Biaya Produksi</div>
                <div class="detail-value"><strong>Rp <?= number_format($hpp->total_biaya, 0, ',', '.'); ?></strong></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Harga Jual</div>
                <div class="detail-value">Rp <?= number_format($hpp->harga_jual, 0, ',', '.'); ?></div>
            </div>

            <div class="highlight">
                <div class="detail-label">Margin Keuntungan</div>
                <div class="detail-value">
                    <?php $margin = $hpp->harga_jual - $hpp->total_biaya; ?>
                    <span class="<?= $margin >= 0 ? 'margin-positive' : 'margin-negative'; ?>">
                        Rp <?= number_format($margin, 0, ',', '.'); ?>
                    </span>
                </div>
                <div style="margin-top: 10px; font-size: 12px; color: #7f8c8d;">
                    Margin % = <?= $hpp->total_biaya > 0 ? round(($margin / $hpp->total_biaya) * 100, 2) : 0; ?>%
                </div>
            </div>

            <div class="btn-group">
                <a href="<?= site_url('hpp/edit/'.$hpp->id_hpp); ?>" class="btn btn-primary">Edit</a>
                <a href="<?= site_url('hpp/delete/'.$hpp->id_hpp); ?>" class="btn btn-danger">Hapus</a>
                <a href="<?= site_url('hpp'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
