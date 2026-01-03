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
            background: var(--bg-light);
            padding: 20px;
            color: var(--text);
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .header-icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 28px;
            color: var(--text);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .header p {
            color: var(--text-light);
            font-size: 14px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            text-align: center;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.12);
        }

        .stat-card.terlaris {
            background: linear-gradient(135deg, #fffbea 0%, #fff3cd 100%);
        }

        .stat-card.profit {
            background: linear-gradient(135deg, #fff8e6 0%, #ffe9b3 100%);
        }

        .stat-card.perhatian {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0e0 100%);
        }

        .stat-icon {
            font-size: 40px;
            margin-bottom: 12px;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .stat-meta {
            font-size: 13px;
            color: var(--text-light);
        }

        .stat-meta.highlight {
            color: var(--warning);
            font-weight: 600;
        }

        /* Trend Section */
        .trend-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .trend-section h3 {
            font-size: 18px;
            color: var(--text);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .trend-item {
            margin-bottom: 20px;
        }

        .trend-item:last-child {
            margin-bottom: 0;
        }

        .trend-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .trend-name {
            font-size: 14px;
            color: var(--text);
            font-weight: 500;
        }

        .trend-percentage {
            font-size: 14px;
            font-weight: 700;
        }

        .trend-percentage.positive {
            color: var(--success);
        }

        .trend-percentage.negative {
            color: var(--danger);
        }

        .trend-bar-container {
            width: 100%;
            height: 10px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .trend-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease;
        }

        .trend-bar.green {
            background: linear-gradient(90deg, var(--success) 0%, #27ae60 100%);
        }

        .trend-bar.blue {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .trend-bar.red {
            background: linear-gradient(90deg, var(--danger) 0%, #c0392b 100%);
        }

        /* Recommendations */
        .recommendations {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        .recommendations h3 {
            font-size: 18px;
            color: var(--text);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .recommendations ul {
            list-style: none;
            padding: 0;
        }

        .recommendations li {
            padding: 12px 0 12px 35px;
            position: relative;
            color: var(--primary);
            font-size: 14px;
            line-height: 1.6;
            border-bottom: 1px solid var(--border);
        }

        .recommendations li:last-child {
            border-bottom: none;
        }

        .recommendations li::before {
            content: '→';
            position: absolute;
            left: 10px;
            color: var(--primary);
            font-weight: 700;
            font-size: 16px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(28, 100, 148, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 100, 148, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--text);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-light);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .trend-section,
        .recommendations {
            animation: fadeIn 0.5s ease;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .trend-section { animation-delay: 0.4s; }
        .recommendations { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">📊</div>
            <h1>Analisis Produk</h1>
            <p>Analisis performa produk berdasarkan data penjualan</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card terlaris">
                <div class="stat-icon">🏆</div>
                <div class="stat-label">Produk Terlaris</div>
                <div class="stat-value">Nasi Ayam Geprek</div>
                <div class="stat-meta">150 terjual bulan ini</div>
            </div>

            <div class="stat-card profit">
                <div class="stat-icon">💰</div>
                <div class="stat-label">Profit Tertinggi</div>
                <div class="stat-value">Es Teh Manis</div>
                <div class="stat-meta highlight">Margin 70%</div>
            </div>

            <div class="stat-card perhatian">
                <div class="stat-icon">⚠️</div>
                <div class="stat-label">Perlu Perhatian</div>
                <div class="stat-value">Gado-gado</div>
                <div class="stat-meta">Penjualan menurun</div>
            </div>
        </div>

        <!-- Trend Section -->
        <div class="trend-section">
            <h3>Tren Penjualan (7 hari terakhir)</h3>
            
            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Nasi Ayam Geprek</span>
                    <span class="trend-percentage positive">+15%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar green" style="width: 75%;"></div>
                </div>
            </div>

            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Es Teh Manis</span>
                    <span class="trend-percentage positive">+8%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar blue" style="width: 58%;"></div>
                </div>
            </div>

            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Gado-gado</span>
                    <span class="trend-percentage negative">-12%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar red" style="width: 38%;"></div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="recommendations">
            <h3>Rekomendasi Aksi:</h3>
            <ul>
                <li>Tingkatkan stok Nasi Ayam Geprek karena permintaan tinggi</li>
                <li>Promosikan Es Teh Manis lebih gencar (margin tinggi)</li>
                <li>Evaluasi resep atau harga Gado-gado</li>
                <li>Pertimbangkan bundle promo untuk produk slow-moving</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= site_url('analisis'); ?>" class="btn btn-secondary">
                📋 Lihat Detail
            </a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="btn btn-primary">
                Tutup analisis
            </a>
        </div>
    </div>

    <script>
        // Animate progress bars on load
        window.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.trend-bar');
            bars.forEach((bar, index) => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100 + (index * 200));
            });
        });
    </script>
</body>
</html>
