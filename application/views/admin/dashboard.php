<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - UMKM Management</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #ecf0f1; }
        nav { background-color: #2c3e50; color: white; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        .nav-right { display: flex; align-items: center; }
        .container { max-width: 1400px; margin: 20px auto; padding: 0 20px; }
        h1 { margin-bottom: 30px; color: #2c3e50; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 4px solid #3498db; }
        .stat-card.revenue { border-left-color: #27ae60; }
        .stat-card.income { border-left-color: #f39c12; }
        .stat-card.expenses { border-left-color: #e74c3c; }
        .stat-label { color: #7f8c8d; font-size: 14px; margin-bottom: 8px; }
        .stat-value { font-size: 28px; font-weight: bold; color: #2c3e50; }
        .stat-subtext { color: #95a5a6; font-size: 12px; margin-top: 5px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; }
        .card-title { font-size: 18px; font-weight: bold; color: #2c3e50; margin-bottom: 15px; border-bottom: 2px solid #ecf0f1; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background-color: #f8f9fa; font-weight: bold; color: #2c3e50; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .btn-primary { background-color: #3498db; color: white; }
        .btn-info { background-color: #17a2b8; color: white; }
        .btn-success { background-color: #27ae60; color: white; }
        .btn:hover { opacity: 0.8; }
        .menu { margin-bottom: 20px; }
        .menu a { display: inline-block; padding: 10px 15px; margin-right: 10px; background-color: #34495e; color: white; text-decoration: none; border-radius: 4px; }
        .menu a:hover { background-color: #2c3e50; }
        .admin-badge { background-color: #f39c12; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; }
    </style>
</head>
<body>
    <nav>
        <div>
            <a href="<?= site_url('admin/dashboard'); ?>">📊 Dashboard</a>
            <a href="<?= site_url('admin/users'); ?>">👥 Users</a>
            <a href="<?= site_url('admin/subscriptions'); ?>">💳 Subscriptions</a>
            <a href="<?= site_url('admin/reports'); ?>">📈 Reports</a>
        </div>
        <div class="nav-right">
            <span class="admin-badge">ADMIN</span>
            <a href="<?= site_url('auth/logout'); ?>" style="margin-right: 0;">Logout (<?= $this->session->userdata('nama'); ?>)</a>
        </div>
    </nav>

    <div class="container">
        <h1>📊 Admin Dashboard - Pusat Kontrol UMKM</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Pengguna</div>
                <div class="stat-value"><?= $total_users; ?></div>
                <div class="stat-subtext">+<?= $new_users_this_month; ?> bulan ini</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Langganan Aktif</div>
                <div class="stat-value"><?= $active_subscriptions; ?></div>
                <div class="stat-subtext">dari <?= $total_subscriptions; ?> total</div>
            </div>

            <div class="stat-card revenue">
                <div class="stat-label">Estimasi Revenue Bulanan</div>
                <div class="stat-value">Rp <?= number_format($estimated_revenue, 0, ',', '.'); ?></div>
                <div class="stat-subtext">dari langganan aktif</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Total Produk Teranalisis</div>
                <div class="stat-value"><?= $total_products; ?></div>
                <div class="stat-subtext">di semua akun</div>
            </div>

            <div class="stat-card income">
                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value">Rp <?= number_format($total_income, 0, ',', '.'); ?></div>
                <div class="stat-subtext">semua pengguna</div>
            </div>

            <div class="stat-card expenses">
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value">Rp <?= number_format($total_expenses, 0, ',', '.'); ?></div>
                <div class="stat-subtext">semua pengguna</div>
            </div>
        </div>

        <div class="card">
            <div class="card-title">💰 Ringkasan Keuangan Keseluruhan</div>
            <table>
                <tr>
                    <th>Metrik</th>
                    <th>Nilai</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>Total Pemasukan</td>
                    <td><strong>Rp <?= number_format($total_income, 0, ',', '.'); ?></strong></td>
                    <td><span class="btn btn-success">✓ Aktif</span></td>
                </tr>
                <tr>
                    <td>Total Pengeluaran</td>
                    <td><strong>Rp <?= number_format($total_expenses, 0, ',', '.'); ?></strong></td>
                    <td><span class="btn btn-primary">💾 Tercatat</span></td>
                </tr>
                <tr>
                    <td>Net Balance (Profit/Loss)</td>
                    <td><strong style="color: <?= $net_balance >= 0 ? '#27ae60' : '#e74c3c'; ?>;">Rp <?= number_format($net_balance, 0, ',', '.'); ?></strong></td>
                    <td><span class="btn btn-info">📊 Analisis</span></td>
                </tr>
                <tr>
                    <td>Total Transaksi Tercatat</td>
                    <td><strong><?= $total_transactions; ?></strong></td>
                    <td><span class="btn btn-success">✓ Update</span></td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-title">📋 Transaksi Keuangan Terbaru (10 Terakhir)</div>
            <?php if (empty($recent_transactions)) : ?>
                <p style="text-align: center; color: #7f8c8d; padding: 20px;">Belum ada transaksi tercatat.</p>
            <?php else : ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>ID User</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_transactions as $trans) : ?>
                        <tr>
                            <td><?= $trans->id_transaksi; ?></td>
                            <td><?= $trans->id_user; ?></td>
                            <td><?= ucfirst($trans->kategori); ?></td>
                            <td>
                                <span class="btn <?= $trans->jenis === 'pemasukan' ? 'btn-success' : 'btn-primary'; ?>" style="font-size: 11px;">
                                    <?= ucfirst($trans->jenis); ?>
                                </span>
                            </td>
                            <td><strong>Rp <?= number_format($trans->nominal, 0, ',', '.'); ?></strong></td>
                            <td><?= date('d M Y', strtotime($trans->tanggal)); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 20px; text-align: center; color: #7f8c8d; font-size: 12px;">
            <p>Dashboard diperbarui pada: <?= date('d M Y H:i:s'); ?></p>
            <p>Akses menu di atas untuk melihat detail pengguna, langganan, dan laporan lengkap.</p>
        </div>
    </div>
</body>
</html>
