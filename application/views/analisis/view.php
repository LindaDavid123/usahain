<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Analisis Produk - Usahain</title>
    <style>
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
            color: #667eea;
            font-size: 24px;
            font-weight: 600;
        }

        .navbar a {
            color: #667eea;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .navbar a:hover {
            background: #667eea;
            color: white;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .header-section {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header-section h1 {
            color: #2d3748;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .product-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            border-left: 4px solid #667eea;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
        }

        .info-label {
            font-size: 13px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .info-value {
            font-size: 20px;
            color: #2d3748;
            font-weight: 700;
        }

        .profit-positive {
            color: #48bb78;
        }

        .profit-negative {
            color: #f56565;
        }

        .analysis-section {
            margin: 40px 0;
        }

        .analysis-section h3 {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .analysis-section h3:before {
            content: "📊";
            font-size: 24px;
        }

        .analysis-box {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            padding: 25px;
            border-radius: 12px;
            border: 2px solid #667eea30;
            line-height: 1.8;
            color: #4a5568;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 14px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-edit {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        }

        .btn-delete {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(245, 101, 101, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
            color: #2d3748;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(160, 174, 192, 0.4);
        }

        .stats-highlight {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .stats-row {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        .stat-item {
            flex: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .stats-row {
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🚀 Usahain - Platform UMKM</h2>
        <a href="<?php echo site_url('analisis'); ?>">
            ← Kembali ke Dashboard
        </a>
    </div>

    <div class="container">
        <div class="header-section">
            <h1>Detail Analisis Produk</h1>
            <div class="product-badge">ID: <?php echo $produk->id_produk; ?></div>
        </div>

        <div class="stats-highlight">
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-value">Rp <?php echo number_format($produk->penjualan, 0, ',', '.'); ?></div>
                    <div class="stat-label">Total Penjualan</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">Rp <?php echo number_format($produk->biaya_produksi, 0, ',', '.'); ?></div>
                    <div class="stat-label">Biaya Produksi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value <?php echo ($produk->penjualan - $produk->biaya_produksi) > 0 ? 'profit-positive' : 'profit-negative'; ?>">
                        Rp <?php echo number_format($produk->penjualan - $produk->biaya_produksi, 0, ',', '.'); ?>
                    </div>
                    <div class="stat-label">Margin Keuntungan</div>
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Nama Produk</div>
                <div class="info-value"><?php echo htmlspecialchars($produk->nama_produk); ?></div>
            </div>

            <div class="info-card">
                <div class="info-label">Tanggal Dibuat</div>
                <div class="info-value"><?php echo date('d M Y', strtotime($produk->created_at)); ?></div>
            </div>

            <div class="info-card">
                <div class="info-label">Persentase Margin</div>
                <div class="info-value <?php echo ($produk->penjualan - $produk->biaya_produksi) > 0 ? 'profit-positive' : 'profit-negative'; ?>">
                    <?php 
                        $margin_persen = $produk->biaya_produksi > 0 ? (($produk->penjualan - $produk->biaya_produksi) / $produk->biaya_produksi * 100) : 0;
                        echo number_format($margin_persen, 1);
                    ?>%
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Status Produk</div>
                <div class="info-value" style="color: <?php echo ($produk->penjualan - $produk->biaya_produksi) > 0 ? '#48bb78' : '#f56565'; ?>;">
                    <?php echo ($produk->penjualan - $produk->biaya_produksi) > 0 ? '✓ Menguntungkan' : '✗ Rugi'; ?>
                </div>
            </div>
        </div>

        <div class="analysis-section">
            <h3>Analisis Produk</h3>
            <div class="analysis-box">
                <?php echo nl2br(htmlspecialchars($produk->analisis)); ?>
            </div>
        </div>

        <div class="action-buttons">
            <a href="<?php echo site_url('analisis'); ?>" class="btn btn-back">
                🏠 Kembali
            </a>
            <a href="<?php echo site_url('analisis/edit/' . $produk->id_produk); ?>" class="btn btn-edit">
                ✏️ Edit Data
            </a>
            <a href="<?php echo site_url('analisis/delete/' . $produk->id_produk); ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                🗑️ Hapus
            </a>
        </div>
    </div>
</body>
</html>