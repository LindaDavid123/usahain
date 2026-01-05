<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Produk - Usahain</title>
    <style>
        :root {
            --primary: #1C6494;
            --primary-dark: #144d73;
            --primary-light: #E3F2FD;
            --accent: #ff9800;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --border: #e1e8ed;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--text);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            color: var(--primary);
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-links {
            display: flex;
            gap: 15px;
        }

        .navbar a {
            color: var(--primary);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .navbar a:hover {
            background: var(--primary);
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--bg-light);
        }

        h1 {
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(28, 100, 148, 0.3);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 100, 148, 0.4);
        }

        .btn-small {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-edit {
            background: linear-gradient(135deg, var(--success) 0%, #27ae60 100%);
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-edit:hover {
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger) 0%, #c0392b 100%);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-delete:hover {
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        .btn-view {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
        }

        .btn-view:hover {
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary-light) 0%, #fff 100%);
            padding: 25px;
            border-radius: 15px;
            border-left: 4px solid var(--primary);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            color: var(--text-light);
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stat-card .value {
            color: var(--primary);
            font-size: 32px;
            font-weight: 700;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            background: #fff;
        }

        th, td {
            padding: 16px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: var(--primary-light);
            transform: scale(1.01);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .profit-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .profit-positive {
            background: #d4edda;
            color: #155724;
        }

        .profit-negative {
            background: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 20px;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .navbar-links {
                width: 100%;
                justify-content: center;
            }

            .header-section {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            h1 {
                font-size: 22px;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 13px;
            }

            th, td {
                padding: 10px 8px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-small {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>📊 Analisis Produk - Usahain</h2>
        <div class="navbar-links">
            <a href="<?php echo site_url('auth/dashboard'); ?>">🏠 Dashboard</a>
            <a href="<?php echo site_url('auth/logout'); ?>">🚪 Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="header-section">
            <h1>💼 Data Analisis Produk</h1>
            <a href="<?php echo site_url('analisis/create'); ?>" class="btn">
                ➕ Tambah Analisis Baru
            </a>
        </div>

        <?php if (!empty($produk_list)): ?>
            <div class="stats-cards">
                <div class="stat-card">
                    <h3>Total Produk</h3>
                    <div class="value"><?php echo count($produk_list); ?></div>
                </div>
                <div class="stat-card">
                    <h3>Total Penjualan</h3>
                    <div class="value">
                        Rp <?php 
                            $total_penjualan = array_sum(array_column($produk_list, 'penjualan'));
                            echo number_format($total_penjualan, 0, ',', '.'); 
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Total Biaya</h3>
                    <div class="value">
                        Rp <?php 
                            $total_biaya = array_sum(array_column($produk_list, 'biaya_produksi'));
                            echo number_format($total_biaya, 0, ',', '.'); 
                        ?>
                    </div>
                </div>
                <div class="stat-card">
                    <h3>Total Profit</h3>
                    <div class="value" style="color: <?php echo ($total_penjualan - $total_biaya) > 0 ? 'var(--success)' : 'var(--danger)'; ?>">
                        Rp <?php echo number_format($total_penjualan - $total_biaya, 0, ',', '.'); ?>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Produk</th>
                            <th>Penjualan</th>
                            <th>Biaya Produksi</th>
                            <th>Margin</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produk_list as $p): ?>
                            <?php 
                                $margin = $p->penjualan - $p->biaya_produksi;
                                $is_profit = $margin > 0;
                            ?>
                            <tr>
                                <td><strong><?php echo $p->id_produk; ?></strong></td>
                                <td><?php echo htmlspecialchars($p->nama_produk); ?></td>
                                <td><strong>Rp <?php echo number_format($p->penjualan, 0, ',', '.'); ?></strong></td>
                                <td>Rp <?php echo number_format($p->biaya_produksi, 0, ',', '.'); ?></td>
                                <td style="color: <?php echo $is_profit ? 'var(--success)' : 'var(--danger)'; ?>; font-weight: 600;">
                                    Rp <?php echo number_format($margin, 0, ',', '.'); ?>
                                </td>
                                <td>
                                    <span class="profit-badge <?php echo $is_profit ? 'profit-positive' : 'profit-negative'; ?>">
                                        <?php echo $is_profit ? '✓ Untung' : '✗ Rugi'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d M Y', strtotime($p->created_at)); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo site_url('analisis/view/' . $p->id_produk); ?>" class="btn btn-view btn-small">👁️ Lihat</a>
                                        <a href="<?php echo site_url('analisis/edit/' . $p->id_produk); ?>" class="btn btn-edit btn-small">✏️ Edit</a>
                                        <a href="<?php echo site_url('analisis/delete/' . $p->id_produk); ?>" class="btn btn-delete btn-small" onclick="return confirm('Yakin ingin menghapus produk ini?');">🗑️ Hapus</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty">
                <div class="empty-icon">📦</div>
                <p><strong>Belum ada data analisis produk</strong></p>
                <p>Mulai analisis produk pertama Anda untuk mengembangkan bisnis UMKM</p>
                <a href="<?php echo site_url('analisis/create'); ?>" class="btn">
                    ➕ Buat Analisis Pertama
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>