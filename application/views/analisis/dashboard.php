<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Produk Otomatis - Usahain</title>
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
            max-width: 1000px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 40px 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .header-icon {
            font-size: 56px;
            margin-bottom: 15px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .header h1 {
            font-size: 32px;
            color: var(--primary-dark);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-card.terlaris::before {
            background: linear-gradient(90deg, #f39c12 0%, #e67e22 100%);
        }

        .stat-card.profit::before {
            background: linear-gradient(90deg, var(--success) 0%, #27ae60 100%);
        }

        .stat-card.perhatian::before {
            background: linear-gradient(90deg, var(--danger) 0%, #c0392b 100%);
        }

        .stat-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 8px;
        }

        .stat-meta {
            font-size: 14px;
            color: var(--text-light);
        }

        .stat-meta.highlight {
            color: var(--success);
            font-weight: 600;
        }

        /* Trend Section */
        .trend-section {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .trend-section h3 {
            font-size: 20px;
            color: var(--primary-dark);
            margin-bottom: 25px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .trend-item {
            margin-bottom: 25px;
            padding: 20px;
            background: var(--bg-light);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .trend-item:hover {
            background: var(--primary-light);
            transform: translateX(5px);
        }

        .trend-item:last-child {
            margin-bottom: 0;
        }

        .trend-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .trend-name {
            font-size: 16px;
            color: var(--text);
            font-weight: 600;
        }

        .trend-percentage {
            font-size: 16px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .trend-percentage.positive {
            background: #d4edda;
            color: var(--success);
        }

        .trend-percentage.negative {
            background: #f8d7da;
            color: var(--danger);
        }

        .trend-bar-container {
            width: 100%;
            height: 12px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .trend-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 1.5s ease;
            position: relative;
        }

        .trend-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
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
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .recommendations h3 {
            font-size: 20px;
            color: var(--primary-dark);
            margin-bottom: 25px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recommendations ul {
            list-style: none;
            padding: 0;
        }

        .recommendations li {
            padding: 18px 20px 18px 50px;
            position: relative;
            color: var(--text);
            font-size: 15px;
            line-height: 1.7;
            border-left: 4px solid var(--primary);
            margin-bottom: 15px;
            background: var(--bg-light);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .recommendations li:hover {
            background: var(--primary-light);
            transform: translateX(5px);
        }

        .recommendations li::before {
            content: '💡';
            position: absolute;
            left: 18px;
            font-size: 20px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 32px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(28, 100, 148, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .header {
                padding: 30px 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .trend-section,
            .recommendations {
                padding: 25px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card,
        .trend-section,
        .recommendations {
            animation: fadeIn 0.6s ease;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .trend-section { animation-delay: 0.4s; }
        .recommendations { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>🚀 Analisis Produk Otomatis</h2>
        <a href="<?= site_url('auth/dashboard'); ?>">← Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-icon">📊</div>
            <h1>Analisis Produk Cerdas</h1>
            <p>Insight mendalam dari data penjualan produk Anda</p>
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
            <h3>📈 Tren Penjualan (7 hari terakhir)</h3>
            
            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Nasi Ayam Geprek</span>
                    <span class="trend-percentage positive">↑ +15%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar green" style="width: 75%;"></div>
                </div>
            </div>

            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Es Teh Manis</span>
                    <span class="trend-percentage positive">↑ +8%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar blue" style="width: 58%;"></div>
                </div>
            </div>

            <div class="trend-item">
                <div class="trend-label">
                    <span class="trend-name">Gado-gado</span>
                    <span class="trend-percentage negative">↓ -12%</span>
                </div>
                <div class="trend-bar-container">
                    <div class="trend-bar red" style="width: 38%;"></div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="recommendations">
            <h3>🎯 Rekomendasi Aksi</h3>
            <ul>
                <li>Tingkatkan stok Nasi Ayam Geprek karena permintaan tinggi dan tren positif</li>
                <li>Promosikan Es Teh Manis lebih gencar karena margin keuntungan sangat tinggi (70%)</li>
                <li>Evaluasi resep atau harga Gado-gado untuk mengatasi penurunan penjualan</li>
                <li>Pertimbangkan bundle promo untuk produk slow-moving agar meningkatkan perputaran stok</li>
                <li>Lakukan survei pelanggan untuk memahami preferensi dan feedback produk</li>
            </ul>
            <div style="margin-top:18px;">
                <a href="<?= site_url('info'); ?>" class="btn btn-info" style="background:#1C6494;color:#fff;padding:10px 22px;border-radius:7px;text-decoration:none;font-weight:600;">ℹ️ Lihat Informasi Bisnis</a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= site_url('analisis'); ?>" class="btn btn-primary">
                📋 Lihat Detail Lengkap
            </a>
            <a href="<?= site_url('analisis/create'); ?>" class="btn btn-secondary">
                ➕ Tambah Analisis Baru
            </a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="btn btn-secondary">
                🏠 Kembali ke Dashboard
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