<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rekomendasi AI Advisor</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 800px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: #2c3e50; }
        .detail-section { margin-bottom: 30px; }
        .section-title { font-weight: bold; color: #34495e; margin-bottom: 10px; font-size: 16px; border-bottom: 2px solid #3498db; padding-bottom: 8px; }
        .detail-group { margin-bottom: 15px; }
        .detail-label { font-weight: bold; color: #34495e; }
        .detail-value { color: #7f8c8d; margin-top: 5px; }
        .recommendation-box { background-color: #d4edda; border-left: 4px solid #27ae60; padding: 20px; border-radius: 4px; margin-top: 20px; }
        .recommendation-box h3 { color: #155724; margin-bottom: 12px; font-size: 16px; }
        .recommendation-box p { color: #155724; line-height: 1.6; margin-bottom: 10px; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn:hover { opacity: 0.8; }
        .info-card { background-color: #e8f4f8; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= site_url('dashboard'); ?>">Dashboard</a>
        <a href="<?= site_url('advisor'); ?>">AI Advisor</a>
        <a href="<?= site_url('auth/logout'); ?>" style="float: right;">Logout (<?= $this->session->userdata('nama'); ?>)</a>
    </nav>
    <div class="container">
        <div class="card">
            <h2>💡 Rekomendasi Konsultasi Bisnis</h2>

            <div class="detail-section">
                <div class="section-title">Informasi Bisnis Anda</div>
                
                <div class="detail-group">
                    <div class="detail-label">ID Konsultasi</div>
                    <div class="detail-value"><?= $advisor->id_ide; ?></div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Modal Awal</div>
                    <div class="detail-value"><strong>Rp <?= number_format($advisor->modal, 0, ',', '.'); ?></strong></div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Lokasi Usaha</div>
                    <div class="detail-value"><?= $advisor->lokasi; ?></div>
                </div>

                <div class="detail-group">
                    <div class="detail-label">Jenis Usaha / Minat</div>
                    <div class="detail-value"><?= $advisor->minat; ?></div>
                </div>
            </div>

            <div class="detail-section">
                <div class="recommendation-box">
                    <h3>🎯 Rekomendasi Sistem kami:</h3>
                    <?php 
                        $recommendations = explode("\n\n", $advisor->rekomendasi);
                        foreach ($recommendations as $rec) {
                            if (!empty(trim($rec))) {
                                echo '<p>✓ ' . trim($rec) . '</p>';
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="info-card">
                <strong>💬 Tips Tambahan:</strong>
                <p style="margin-top: 10px; color: #34495e;">Rekomendasi ini didasarkan pada analisis modal awal, lokasi geografis, dan jenis usaha yang Anda pilih. Untuk hasil terbaik, gunakan fitur Pencatatan Keuangan dan HPP Calculator untuk memantau performa bisnis Anda.</p>
            </div>

            <div class="btn-group">
                <a href="<?= site_url('advisor/edit/'.$advisor->id_ide); ?>" class="btn btn-primary">Edit Konsultasi</a>
                <a href="<?= site_url('advisor/delete/'.$advisor->id_ide); ?>" class="btn btn-danger">Hapus</a>
                <a href="<?= site_url('advisor/chat/'.$advisor->id_ide); ?>" class="btn btn-primary">Chat</a>
                <a href="<?= site_url('advisor'); ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>
</html>
