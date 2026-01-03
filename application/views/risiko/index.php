<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Risiko</title>
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
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #ecf0f1; font-weight: bold; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 4px; background-color: #d4edda; color: #155724; }
        .no-data { padding: 20px; text-align: center; color: #7f8c8d; }
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
            <div class="header">
                <h2>Manajemen Risiko Usaha</h2>
                <a href="<?= site_url('risiko/create'); ?>" class="btn btn-success">+ Tambah Risiko</a>
            </div>
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if (empty($risiko_list)) : ?>
                <div class="no-data">Belum ada data risiko. <a href="<?= site_url('risiko/create'); ?>">Buat yang baru</a></div>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Usaha</th>
                            <th>Daftar Risiko</th>
                            <th>Rekomendasi Mitigasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($risiko_list as $risiko) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= substr($risiko->jenis_usaha, 0, 30); ?></strong></td>
                            <td><?= substr($risiko->daftar_risiko, 0, 40); ?>...</td>
                            <td><?= substr($risiko->rekomendasi_mitigasi, 0, 40); ?>...</td>
                            <td>
                                <a href="<?= site_url('risiko/view/'.$risiko->id_risiko); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Lihat</a>
                                <a href="<?= site_url('risiko/edit/'.$risiko->id_risiko); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #f39c12;">Edit</a>
                                <a href="<?= site_url('risiko/delete/'.$risiko->id_risiko); ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
