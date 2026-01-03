<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Risiko</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 800px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: #2c3e50; }
        .detail-group { margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #ecf0f1; }
        .detail-label { font-weight: bold; color: #34495e; margin-bottom: 5px; }
        .detail-value { color: #7f8c8d; font-size: 16px; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('dashboard'); ?>">Dashboard</a>
        <a href="<?= site_url('risiko'); ?>">Manajemen Risiko</a>
        <a href="<?= site_url('auth/logout'); ?>" style="float: right;">Logout (<?= $this->session->userdata('nama'); ?>)</a>
    </nav>
    <div class="container">
        <div class="card">
            <h2>Detail Manajemen Risiko</h2>

            <div class="detail-group">
                <div class="detail-label">ID Risiko</div>
                <div class="detail-value"><?= $risiko->id_risiko; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Jenis Usaha</div>
                <div class="detail-value"><?= $risiko->jenis_usaha; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Daftar Risiko yang Diidentifikasi</div>
                <div class="detail-value"><?= $risiko->daftar_risiko; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Rekomendasi Mitigasi (Pengurangan Risiko)</div>
                <div class="detail-value"><?= $risiko->rekomendasi_mitigasi; ?></div>
            </div>

            <div class="detail-group">
                <div class="detail-label">Tanggal Dibuat</div>
                <div class="detail-value"><?= date('d M Y H:i', strtotime($risiko->created_at)); ?></div>
            </div>

            <div class="btn-group">
                <a href="<?= site_url('risiko/edit/'.$risiko->id_risiko); ?>" class="btn btn-primary">Edit</a>
                <a href="<?= site_url('risiko/delete/'.$risiko->id_risiko); ?>" class="btn btn-danger">Hapus</a>
                <a href="<?= site_url('risiko'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
