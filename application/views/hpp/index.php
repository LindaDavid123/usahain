<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>HPP Calculator</title>
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
        .currency { text-align: right; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; }
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
            <div class="header">
                <h2>HPP Calculator - Perhitungan Biaya Produksi</h2>
                <a href="<?= site_url('hpp/create'); ?>" class="btn btn-success">+ Tambah HPP</a>
            </div>
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php endif; ?>
            <?php if (empty($hpp_list)) : ?>
                <p style="padding: 20px; text-align: center; color: #7f8c8d;">Belum ada data HPP. <a href="<?= site_url('hpp/create'); ?>">Buat yang baru</a></p>
            <?php else : ?>
                <table>
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
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="currency">Rp <?= number_format($hpp->bahan, 0, ',', '.'); ?></td>
                            <td class="currency">Rp <?= number_format($hpp->tenaga_kerja, 0, ',', '.'); ?></td>
                            <td class="currency"><strong>Rp <?= number_format($hpp->total_biaya, 0, ',', '.'); ?></strong></td>
                            <td class="currency">Rp <?= number_format($hpp->harga_jual, 0, ',', '.'); ?></td>
                            <td class="currency" style="color: <?= ($hpp->harga_jual - $hpp->total_biaya) > 0 ? '#27ae60' : '#e74c3c'; ?>;">
                                Rp <?= number_format($hpp->harga_jual - $hpp->total_biaya, 0, ',', '.'); ?>
                            </td>
                            <td>
                                <a href="<?= site_url('hpp/view/'.$hpp->id_hpp); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Lihat</a>
                                <a href="<?= site_url('hpp/edit/'.$hpp->id_hpp); ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #f39c12;">Edit</a>
                                <a href="<?= site_url('hpp/delete/'.$hpp->id_hpp); ?>" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Hapus</a>
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
