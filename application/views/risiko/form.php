<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= isset($risiko) ? 'Edit Risiko' : 'Tambah Risiko'; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 20px; text-decoration: none; }
        .container { max-width: 600px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h2 { margin-bottom: 20px; color: #2c3e50; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #34495e; }
        input[type="text"], textarea, select { width: 100%; padding: 10px; border: 1px solid #bdc3c7; border-radius: 4px; font-size: 14px; }
        textarea { min-height: 100px; resize: vertical; }
        .btn-group { margin-top: 30px; display: flex; gap: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; text-decoration: none; display: inline-block; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn:hover { opacity: 0.8; }
        .error { color: #e74c3c; font-size: 12px; margin-top: 5px; }
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
            <h2><?= isset($risiko) ? 'Edit Manajemen Risiko' : 'Tambah Manajemen Risiko'; ?></h2>

            <form method="post">
                <div class="form-group">
                    <label for="jenis_usaha">Jenis Usaha *</label>
                    <input type="text" id="jenis_usaha" name="jenis_usaha" value="<?= isset($risiko) ? $risiko->jenis_usaha : set_value('jenis_usaha'); ?>" placeholder="Contoh: Warung Makan, Toko Elektronik" required>
                    <?= form_error('jenis_usaha', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="daftar_risiko">Daftar Risiko *</label>
                    <textarea id="daftar_risiko" name="daftar_risiko" placeholder="Tuliskan risiko yang mungkin dihadapi usaha Anda (pisahkan dengan baris baru)" required><?= isset($risiko) ? $risiko->daftar_risiko : set_value('daftar_risiko'); ?></textarea>
                    <?= form_error('daftar_risiko', '<div class="error">', '</div>'); ?>
                </div>

                <div class="form-group">
                    <label for="rekomendasi_mitigasi">Rekomendasi Mitigasi (Pengurangan Risiko) *</label>
                    <textarea id="rekomendasi_mitigasi" name="rekomendasi_mitigasi" placeholder="Tuliskan langkah-langkah untuk mengurangi risiko yang telah diidentifikasi" required><?= isset($risiko) ? $risiko->rekomendasi_mitigasi : set_value('rekomendasi_mitigasi'); ?></textarea>
                    <?= form_error('rekomendasi_mitigasi', '<div class="error">', '</div>'); ?>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= site_url('risiko'); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
