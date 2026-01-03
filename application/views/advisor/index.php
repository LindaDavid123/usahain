<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>AI Advisor - Konsultasi Bisnis</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: bold; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-danger { background-color: #e74c3c; color: white; }
        .btn-success { background-color: #27ae60; color: white; }
        .btn:hover { opacity: 0.8; }
        .advisor-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 20px; margin-top: 20px; }
        .advisor-card { background: #f8f9fa; border-left: 5px solid #3498db; padding: 20px; border-radius: 4px; }
        .advisor-title { font-weight: bold; color: #2c3e50; margin-bottom: 10px; font-size: 16px; }
        .advisor-info { font-size: 14px; color: #7f8c8d; margin: 8px 0; }
        .advisor-actions { margin-top: 15px; display: flex; gap: 10px; }
        .advisor-actions a { font-size: 12px; padding: 6px 12px; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 4px; background-color: #d4edda; color: #155724; }
        .no-data { text-align: center; padding: 40px; color: #7f8c8d; }
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
            <div class="header">
                <h2>AI Advisor - Konsultasi Bisnis Cerdas</h2>
                <a href="<?= site_url('advisor/create'); ?>" class="btn btn-success">+ Minta Rekomendasi</a>
            </div>
            
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>

            <?php if (empty($advisor_list)) : ?>
                <div class="no-data">
                    <p style="margin-bottom: 15px;">Belum ada rekomendasi bisnis. Mulai dengan <a href="<?= site_url('advisor/create'); ?>">membuat konsultasi baru</a>.</p>
                </div>
            <?php else : ?>
                <div class="advisor-grid">
                    <?php foreach ($advisor_list as $advisor) : ?>
                    <div class="advisor-card">
                        <div class="advisor-title">💡 <?= ucfirst(substr($advisor->minat, 0, 20)); ?></div>
                        <div class="advisor-info">
                            <strong>Modal:</strong> Rp <?= number_format($advisor->modal, 0, ',', '.'); ?>
                        </div>
                        <div class="advisor-info">
                            <strong>Lokasi:</strong> <?= $advisor->lokasi; ?>
                        </div>
                        <div class="advisor-info">
                            <strong>Jenis Usaha:</strong> <?= $advisor->minat; ?>
                        </div>
                        <div class="advisor-actions">
                            <a href="<?= site_url('advisor/view/'.$advisor->id_ide); ?>" class="btn btn-primary">Lihat Rekomendasi</a>
                            <a href="<?= site_url('advisor/edit/'.$advisor->id_ide); ?>" class="btn btn-primary" style="background-color: #f39c12;">Edit</a>
                            <a href="<?= site_url('advisor/delete/'.$advisor->id_ide); ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
