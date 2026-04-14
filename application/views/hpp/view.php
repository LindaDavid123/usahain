<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail HPP</title>
    <style>
        :root {
            --primary: #1F6B99;
            --primary-dark: #154A6F;
            --primary-light: #E8F4FB;
            --secondary: #7EC8E3;
            --success: #10B981;
            --danger: #EF4444;
            --text: #1E293B;
            --text-secondary: #64748B;
            --bg: #F8FAFC;
            --card: #FFFFFF;
            --border: #E2E8F0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', Arial, sans-serif; background-color: var(--bg); }
        nav { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 14px 20px; box-shadow: 0 2px 8px rgba(31,107,153,0.12); }
        nav a { color: white; margin-right: 20px; text-decoration: none; transition: opacity 0.3s; }
        nav a:hover { opacity: 0.8; }
        .container { max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .card { background: var(--card); border-radius: 12px; box-shadow: 0 4px 12px rgba(31,107,153,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: var(--primary-dark); }
        .detail-group { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--border); }
        .detail-label { font-weight: bold; color: var(--primary); margin-bottom: 5px; }
        .detail-value { color: var(--text-secondary); font-size: 16px; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(31,107,153,0.2); }
        .btn-danger { background-color: var(--danger); color: white; }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-secondary { background-color: var(--text-secondary); color: white; }
        .btn-secondary:hover { opacity: 0.9; }
        .highlight { background-color: var(--primary-light); padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid var(--primary); }
        .margin-positive { color: var(--success); font-weight: bold; }
        .margin-negative { color: var(--danger); font-weight: bold; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('auth/dashboard'); ?>">Dashboard</a>
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
