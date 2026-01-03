<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hapus HPP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: #2c3e50; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .detail-group { margin-bottom: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; }
        .detail-label { font-weight: bold; color: #34495e; }
        .detail-value { color: #7f8c8d; margin-top: 5px; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn:hover { opacity: 0.8; }
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
            <h2>Hapus Data HPP</h2>
            
            <div class="alert alert-danger">
                ⚠️ Anda yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.
            </div>

            <div class="detail-group">
                <div class="detail-label">ID HPP:</div>
                <div class="detail-value"><?= $hpp->id_hpp; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Biaya Bahan:</div>
                <div class="detail-value">Rp <?= number_format($hpp->bahan, 0, ',', '.'); ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Biaya Tenaga Kerja:</div>
                <div class="detail-value">Rp <?= number_format($hpp->tenaga_kerja, 0, ',', '.'); ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Total Biaya:</div>
                <div class="detail-value"><strong>Rp <?= number_format($hpp->total_biaya, 0, ',', '.'); ?></strong></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Harga Jual:</div>
                <div class="detail-value">Rp <?= number_format($hpp->harga_jual, 0, ',', '.'); ?></div>
            </div>

            <form method="post" style="margin-top: 30px;">
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                    <a href="<?= site_url('hpp'); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
