<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Produk Otomatis - Usahain</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/dashboard-shared.css'); ?>">
    <style>
        :root {
            --primary: #1C6494;
            --primary-dark: #144d73;
            --primary-light: #EAF3FB;
            --accent: #ff9800;
            --success: #2ecc71;
            --danger: #e74c3c;
            --warning: #f39c12;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --border: #e1e8ed;
            --surface: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Inter, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6f8fb 0%, #eef4f8 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--text);
            line-height: 1.5;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
            padding: 16px 24px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            border: 1px solid var(--border);
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            color: var(--primary);
            font-size: 22px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .navbar h2 i,
        .navbar h2 svg {
            width: 20px;
            height: 20px;
        }

        .navbar a {
            color: var(--primary);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .navbar a i,
        .navbar a svg {
            width: 16px;
            height: 16px;
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
            margin-bottom: 30px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--surface);
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border);
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
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
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
            width: 50px;
            height: 50px;
            border-radius: var(--ds-icon-radius, 12px);
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-light);
            color: var(--primary);
            margin-bottom: 15px;
        }

        .stat-icon i,
        .stat-icon svg {
            width: 22px;
            height: 22px;
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
            background: var(--surface);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .trend-section h3 {
            font-size: var(--ds-section-title-size, 16px);
            line-height: var(--ds-heading-line-height, 1.3);
            letter-spacing: var(--ds-section-title-letter-spacing, 0.3px);
            color: var(--ds-section-title-color, #1a1a2e);
            margin-bottom: 25px;
            font-weight: var(--ds-section-title-weight, 600);
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 3px solid var(--ds-section-title-accent, #1E6FBA);
            padding-left: var(--ds-section-title-padding-left, 12px);
        }

        .trend-section h3 i,
        .trend-section h3 svg,
        .recommendations h3 i,
        .recommendations h3 svg {
            width: 18px;
            height: 18px;
            color: var(--primary);
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
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.2px;
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
            background: var(--surface);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }

        .recommendations h3 {
            font-size: var(--ds-section-title-size, 16px);
            line-height: var(--ds-heading-line-height, 1.3);
            letter-spacing: var(--ds-section-title-letter-spacing, 0.3px);
            color: var(--ds-section-title-color, #1a1a2e);
            margin-bottom: 25px;
            font-weight: var(--ds-section-title-weight, 600);
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 3px solid var(--ds-section-title-accent, #1E6FBA);
            padding-left: var(--ds-section-title-padding-left, 12px);
        }

        .recommendations ul {
            list-style: none;
            padding: 0;
        }

        .recommendations li {
            padding: 18px 20px 18px 50px;
            position: relative;
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
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
            content: '';
            position: absolute;
            left: 20px;
            top: 26px;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--primary);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 26px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            line-height: 1.3;
        }

        .btn i,
        .btn svg {
            width: 16px;
            height: 16px;
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
                margin-bottom: 24px;
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
        <h2><i data-lucide="rocket"></i>Analisis Produk Otomatis</h2>
        <a href="<?= site_url('auth/dashboard'); ?>"><i data-lucide="arrow-left"></i>Kembali ke Dashboard</a>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header ds-hero">
            <div class="ds-hero-main">
                <p class="ds-hero-greeting">Selamat datang kembali, <?= htmlspecialchars($user['nama'] ?? 'User'); ?>.</p>
                <h1 class="ds-hero-title">Analisis Produk Cerdas</h1>
                <p class="ds-hero-subtitle">Pantau performa produk dan peluang peningkatan margin secara terukur.</p>
                <div class="ds-hero-badges">
                    <span class="ds-hero-badge">ANALISIS</span>
                    <span class="ds-hero-badge">PRODUK AKTIF</span>
                </div>
            </div>
            <div class="ds-hero-right">
                <div class="ds-hero-stat">
                    <span class="ds-hero-stat-label">Insight Tersedia:</span>
                    <span class="ds-hero-stat-value">3 kategori</span>
                </div>
                <div class="ds-hero-stat">
                    <span class="ds-hero-stat-label">Status Modul:</span>
                    <span class="ds-hero-stat-value">Aktif</span>
                </div>
            </div>
            <div class="ds-hero-decor" aria-hidden="true">
                <i data-lucide="chart-line"></i>
                <i data-lucide="trending-up"></i>
                <i data-lucide="package"></i>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card terlaris">
                <div class="stat-icon"><i data-lucide="trophy"></i></div>
                <div class="stat-label">Produk Terlaris</div>
                <div class="stat-value">Nasi Ayam Geprek</div>
                <div class="stat-meta">150 terjual bulan ini</div>
            </div>

            <div class="stat-card profit">
                <div class="stat-icon"><i data-lucide="circle-dollar-sign"></i></div>
                <div class="stat-label">Profit Tertinggi</div>
                <div class="stat-value">Es Teh Manis</div>
                <div class="stat-meta highlight">Margin 70%</div>
            </div>

            <div class="stat-card perhatian">
                <div class="stat-icon"><i data-lucide="triangle-alert"></i></div>
                <div class="stat-label">Perlu Perhatian</div>
                <div class="stat-value">Gado-gado</div>
                <div class="stat-meta">Penjualan menurun</div>
            </div>
        </div>

        <!-- Trend Section -->
        <div class="trend-section">
            <h3><i data-lucide="trending-up"></i>Tren Penjualan (7 hari terakhir)</h3>
            
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
            <h3><i data-lucide="target"></i>Rekomendasi Aksi</h3>
            <ul>
                <li>Tingkatkan stok Nasi Ayam Geprek karena permintaan tinggi dan tren positif</li>
                <li>Promosikan Es Teh Manis lebih gencar karena margin keuntungan sangat tinggi (70%)</li>
                <li>Evaluasi resep atau harga Gado-gado untuk mengatasi penurunan penjualan</li>
                <li>Pertimbangkan bundle promo untuk produk slow-moving agar meningkatkan perputaran stok</li>
                <li>Lakukan survei pelanggan untuk memahami preferensi dan feedback produk</li>
            </ul>
            <div style="margin-top:18px;">
                <a href="<?= site_url('info'); ?>" class="btn btn-info" style="background:#1C6494;color:#fff;padding:10px 22px;border-radius:7px;text-decoration:none;font-weight:600;"><i data-lucide="info"></i>Lihat Informasi Bisnis</a>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="<?= site_url('analisis'); ?>" class="btn btn-primary">
                <i data-lucide="clipboard-list"></i>Lihat Detail Lengkap
            </a>
            <a href="<?= site_url('analisis/create'); ?>" class="btn btn-secondary">
                <i data-lucide="plus"></i>Tambah Analisis Baru
            </a>
            <a href="<?= site_url('auth/dashboard'); ?>" class="btn btn-secondary">
                <i data-lucide="house"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"></script>

    <script>
        if (window.lucide) {
            window.lucide.createIcons();
        }

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