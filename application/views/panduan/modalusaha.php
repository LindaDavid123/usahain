<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'usaha'=> 'Bisnis Anda',
    'type' => 'Calon Pemilik UMKM'
], (array)($user ?? []));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Modal Usaha</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1F6B99;
            --primary-dark: #154A6F;
            --primary-light: #3A88BA;
            --primary-very-light: #E8F4FB;
            --secondary: #7EC8E3;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --bg: #F5F7FA;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --border: #E2E8F0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Inter', Segoe UI, Arial; 
            background: linear-gradient(135deg, #F5F7FA 0%, #E8F4FB 100%);
            color: var(--text-primary); 
            min-height: 100vh;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(31, 107, 153, 0.2);
        }

        .back-button:hover {
            background: var(--primary-dark);
            transform: translateX(-4px);
            box-shadow: 0 4px 12px rgba(31, 107, 153, 0.3);
        }

        .guide-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 50px 40px;
            border-radius: 16px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(31, 107, 153, 0.25);
            position: relative;
            overflow: hidden;
        }

        .guide-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .guide-header h1 {
            font-size: 2.8em;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
            font-weight: 800;
        }

        .guide-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.1em;
            position: relative;
            z-index: 1;
        }

        .guide-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .guide-sections-wrapper {
            padding: 50px 40px;
        }

        .guide-section {
            margin-bottom: 45px;
            padding-bottom: 45px;
            border-bottom: 1px solid var(--border);
        }

        .guide-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .section-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: white;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.4em;
            flex-shrink: 0;
        }

        .guide-section h2 {
            color: var(--primary);
            font-size: 1.9em;
            margin: 0;
            font-weight: 700;
        }

        .guide-section h3 {
            color: var(--primary-dark);
            font-size: 1.2em;
            margin: 25px 0 12px 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .guide-section h3::before {
            content: '▸';
            color: var(--primary);
            font-size: 1.3em;
        }

        .guide-section p {
            margin-bottom: 15px;
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.05em;
        }

        .guide-section ul, .guide-section ol {
            margin: 15px 0 20px 30px;
        }

        .guide-section li {
            margin-bottom: 12px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .guide-section li strong {
            color: var(--primary-dark);
            font-weight: 600;
        }

        .highlight-box {
            background: linear-gradient(135deg, rgba(30, 107, 153, 0.05), rgba(62, 136, 186, 0.05));
            border-left: 5px solid var(--primary);
            padding: 24px;
            border-radius: 12px;
            margin: 25px 0;
            border-right: 1px solid var(--border);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .highlight-box strong {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .comparison-table th {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: white;
            border: none;
        }

        .comparison-table td {
            padding: 13px 15px;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }

        .comparison-table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .comparison-table tr:hover {
            background: var(--primary-very-light);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .guide-header {
                padding: 35px 20px;
            }

            .guide-header h1 {
                font-size: 2em;
            }

            .guide-sections-wrapper {
                padding: 30px 20px;
            }

            .section-number {
                width: 40px;
                height: 40px;
                font-size: 1.1em;
            }

            .guide-section h2 {
                font-size: 1.5em;
            }

            .guide-section h3 {
                font-size: 1.1em;
            }

            .comparison-table {
                font-size: 0.9em;
            }

            .comparison-table th,
            .comparison-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('auth/dashboard'); ?>" class="back-button">← Kembali ke Dashboard</a>

        <div class="guide-header">
            <h1>💰 Panduan Modal Usaha</h1>
            <p>Panduan lengkap untuk merencanakan dan mengamankan modal bisnis Anda</p>
        </div>

        <div class="guide-content">
            <div class="guide-sections-wrapper">
            <div class="guide-section">
                <div class="section-header">
                    <div class="section-number">1</div>
                    <h2>Pengertian Modal Usaha</h2>
                </div>
                <p>Modal usaha adalah aset finansial atau sumber daya yang digunakan untuk memulai, mengembangkan, dan menjalankan bisnis. Modal dapat berupa uang tunai, peralatan, tanah, atau aset lainnya yang dimiliki oleh pengusaha.</p>

                <h3>Jenis-Jenis Modal</h3>
                <ul>
                    <li><strong>Modal Awal (Fixed Capital):</strong> Investasi dalam aset tetap seperti bangunan, mesin, peralatan</li>
                    <li><strong>Modal Kerja (Working Capital):</strong> Dana untuk operasional sehari-hari seperti pembelian bahan baku, gaji karyawan, biaya operasional</li>
                    <li><strong>Modal Cadangan (Reserve Capital):</strong> Dana tambahan untuk menghadapi kebutuhan atau kesulitan yang tidak terduga</li>
                <div class="section-header">
                    <div class="section-number">2</div>
                    <h2>Menghitung Kebutuhan Modal</h2>
                </div
            </div>

            <div class="guide-section">
                <h2>2. Menghitung Kebutuhan Modal</h2>
                <h3>Tahap 1: Identifikasi Kebutuhan Aset Tetap</h3>
                <p>Buat daftar semua aset yang diperlukan untuk operasional bisnis:</p>
                <ul>
                    <li>Tempat usaha (sewa/beli)</li>
                    <li>Peralatan produksi</li>
                    <li>Perlengkapan kantor</li>
                    <li>Teknologi dan software</li>
                    <li>Kendaraan (jika diperlukan)</li>
                </ul>

                <h3>Tahap 2: Hitung Modal Kerja</h3>
                <p>Perkirakan kebutuhan dana untuk operasional 3-6 bulan pertama:</p>
                <ul>
                    <li>Bahan baku dan persediaan</li>
                    <li>Gaji dan upah karyawan</li>
                    <li>Biaya listrik dan air</li>
                    <li>Biaya transportasi dan logistik</li>
                    <li>Biaya pemasaran dan promosi</li>
                    <li>Biaya administrasi dan lainnya</li>
                </ul>

                <h3>Tahap 3: Sediakan Modal Cadangan</h3>
                <p>Tambahkan 10-20% dari total modal sebagai cadangan untuk:</p>
                <ul>
                    <li>Perbaikan dan perawatan aset</li>
                    <li>Hambatan yang tidak terduga</li>
                    <li>Peluang bisnis yang muncul</li>
                </ul>

                <div class="highlight-box">
                    <strong>📊 Contoh:</strong> Jika modal awal Rp 50 juta dan modal kerja Rp 30 juta, total kebutuhan adalah Rp 80 juta + cadangan 10-20% = Rp 88-96 juta.
                </div>
            </divdiv class="section-header">
                    <div class="section-number">3</div>
                    <h2>Sumber-Sumber Modal</h2>
                </div

            <div class="guide-section">
                <h2>3. Sumber-Sumber Modal</h2>
                <h3>A. Modal Pribadi</h3>
                <p><strong>Kelebihan:</strong></p>
                <ul>
                    <li>Tidak ada bunga atau kewajiban pembayaran</li>
                    <li>Kontrol penuh atas bisnis</li>
                    <li>Keputusan lebih cepat</li>
                </ul>
                <p><strong>Kekurangan:</strong></p>
                <ul>
                    <li>Sumber dana terbatas</li>
                    <li>Risiko pribadi tinggi</li>
                </ul>

                <h3>B. Pinjaman Bank dan Lembaga Keuangan</h3>
                <p><strong>Kredit Usaha Rakyat (KUR) - Kredit dengan Jaminan</strong></p>
                <ul>
                    <li>Bunga kompetitif (biasanya 6-12% per tahun)</li>
                    <li>Tenor hingga 5 tahun</li>
                    <li>Memerlukan jaminan (aset/tanah)</li>
                </ul>

                <p><strong>Kredit Tanpa Jaminan</strong></p>
                <ul>
                    <li>Proses lebih cepat</li>
                    <li>Bunga lebih tinggi (12-24% per tahun)</li>
                    <li>Plafon terbatas</li>
                </ul>

                <p><strong>Persyaratan umum:</strong></p>
                <ul>
                    <li>Memiliki usaha minimal 2-3 tahun (untuk yang sudah berjalan)</li>
                    <li>Laporan keuangan atau catatan keuangan</li>
                    <li>Rencana penggunaan dana yang jelas</li>
                    <li>Jaminan (untuk KUR dengan jaminan)</li>
                </ul>

                <h3>C. Investor Swasta / Venture Capital</h3>
                <p><strong>Kelebihan:</strong></p>
                <ul>
                    <li>Dana besar tanpa beban utang</li>
                    <li>Mentoring dan jaringan bisnis</li>
                    <li>Reputasi yang meningkat</li>
                </ul>
                <p><strong>Kekurangan:</strong></p>
                <ul>
                    <li>Harus berbagi kepemilikan dan keuntungan</li>
                    <li>Kontrol bisnis berkurang</li>
                    <li>Proses yang panjang</li>
                </ul>

                <h3>D. Program Pemerintah</h3>
                <p>Indonesia memiliki berbagai program dukungan:</p>
                <ul>
                    <li><strong>Kredit Usaha Rakyat (KUR):</strong> Kredit bergulir untuk UMKM dengan bunga rendah</li>
                    <li><strong>Subsidi Bunga:</strong> Pemerintah menanggung sebagian bunga kredit</li>
                    <li><strong>Pelatihan Gratis:</strong> Program pengembangan kapasitas UMKM</li>
                    <li><strong>Akses Pasar:</strong> Bantuan untuk memasuki pasar baru</li>
                </ul>

                <h3>E. Sumber Modal Lainnya</h3>
                <ul>
                    <li><strong>Crowdfunding:</strong> Mengumpulkan dana dari banyak orang melalui platform online</li>
                    <li><strong>Koperasi:</strong> Meminjam dari koperasi simpan pinjam dengan bunga lebih rendah</li>
                    <li><strong>Microfinance:</strong> Lembaga keuangan mikro untuk usaha kecil</li>
                    <li><strong>Family & Friends:</strong> Meminjam dari keluarga atau teman dengan perjanjian jelas</li>
                </ul>
            </divdiv class="section-header">
                    <div class="section-number">4</div>
                    <h2>Perbandingan Sumber Modal</h2>
                </div

            <div class="guide-section">
                <h2>4. Perbandingan Sumber Modal</h2>
                <table class="comparison-table">
                    <tr>
                        <th>Sumber Modal</th>
                        <th>Keuntungan</th>
                        <th>Kerugian</th>
                        <th>Biaya</th>
                    </tr>
                    <tr>
                        <td><strong>Modal Pribadi</strong></td>
                        <td>Tidak ada bunga, kontrol penuh</td>
                        <td>Dana terbatas, risiko tinggi</td>
                        <td>Gratis</td>
                    </tr>
                    <tr>
                        <td><strong>KUR Bank</strong></td>
                        <td>Bunga rendah, dana besar</td>
                        <td>Butuh jaminan, proses lama</td>
                        <td>6-12% per tahun</td>
                    </tr>
                    <tr>
                        <td><strong>Investor</strong></td>
                        <td>Dana besar, mentoring</td>
                        <td>Berbagi kepemilikan, kontrol berkurang</td>
                        <td>Equity share</td>
                    </tr>
                    <tr>
                        <td><strong>Koperasi</strong></td>
                        <td>Bunga rendah, syarat mudah</td>
                        <td>Dana terbatas, proses lambat</td>
                        <td>8-20% per tahun</td>
                    </tr>
                    <tr>
                        <td><strong>Microfinance</strong></td>
                        <td>Syarat mudah, cepat</td>
                        <td>Bunga tinggi, dana terbatas</td>
                        <td>20-36% per tahun</td>
                    </tr>
                </table>
            </divdiv class="section-header">
                    <div class="section-number">5</div>
                    <h2>Strategi Mengamankan Modal</h2>
                </div

            <div class="guide-section">
                <h2>5. Strategi Mengamankan Modal</h2>
                <h3>Persiapan yang Matang</h3>
                <ul>
                    <li>Buat business plan yang detail dan realistis</li>
                    <li>Proyeksikan cash flow minimal 12 bulan</li>
                    <li>Analisis break even point</li>
                </ul>

                <h3>Diversifikasi Sumber Modal</h3>
                <ul>
                    <li>Jangan terlalu bergantung pada satu sumber modal</li>
                    <li>Kombinasikan modal pribadi dengan kredit atau investor</li>
                    <li>Manfaatkan program pemerintah jika tersedia</li>
                </ul>

                <h3>Pengelolaan Kas yang Baik</h3>
                <ul>
                    <li>Pisahkan rekening pribadi dan bisnis</li>
                    <li>Catat setiap transaksi dengan jelas</li>
                    <li>Monitor arus kas secara rutin</li>
                    <li>Jangan gunakan modal kerja untuk kebutuhan pribadi</li>
                </ul>

                <h3>Menjaga Likuiditas</h3>
                <ul>
                    <li>Pastikan selalu ada kas untuk operasional</li>
                    <li>Kelola piutang dengan baik agar cepat tertagih</li>
                 div class="section-header">
                    <div class="section-number">6</div>
                    <h2>Tips Saat Mengajukan Pinjaman</h2>
                </div</li>
                    <li>Negosiasikan jangka waktu pembayaran dengan supplier</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>6. Tips Saat Mengajukan Pinjaman</h2>
                <ul>
                    <li><strong>Persiapkan dokumen:</strong> KTP, NPWP, laporan keuangan, business plan</li>
                    <li><strong>Buktikan kepercayaan:</strong> Rekam jejak finansial yang baik</li>
                    <li><strong>Jelas tujuan penggunaan:</strong> Bank ingin tahu persis digunakan untuk apa</li>
                    <li><strong>Realistis dengan proyeksi:</strong> Jangan membuat proyeksi yang terlalu berlebihan</li>
                    <li><strong>Bandingkan penawaran:</strong> Jangan langsung setuju, bandingkan dengan lembaga lain</li>
                 div class="section-header">
                    <div class="section-number">7</div>
                    <h2>Pengelolaan Modal Jangka Panjang</h2>
                </divama:</strong> Pahami semua syarat dan ketentuan</li>
                    <li><strong>Diskusikan tenor yang tepat:</strong> Sesuaikan dengan cash flow proyeksi Anda</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>7. Pengelolaan Modal Jangka Panjang</h2>
                <h3>Reinvestasi Keuntungan</h3>
                <ul>
                    <li>Alokasikan sebagian keuntungan untuk ekspansi bisnis</li>
                    <li>Tingkatkan kapasitas produksi</li>
                    <li>Diversifikasi produk atau layanan</li>
                </ul>

                <h3>Pembayaran Utang Tepat Waktu</h3>
                <ul>
                    <li>Prioritaskan pembayaran utang sesuai jadwal</li>
                    <li>Bangun reputasi kredit yang baik untuk pinjaman di masa depan</li>
                    <li>Pertimbangkan pelunasan awal jika ada kemampuan</li>
                </ul>

                <h3>Cadangan Keuangan</h3>
                <ul>
                    <li>Sisihkan 10-15% keuntungan sebagai cadangan</li>
                 div class="section-header">
                    <div class="section-number">✓</div>
                    <h2>Kesimpulan</h2>
                </divtuk menghadapi periode sulit</li>
                    <li>Dana untuk peluang investasi baru</li>
                </ul>
            </div>
    </div>
        
            <div class="guide-section">
                <h2>Kesimpulan</h2>
                <p>Modal adalah salah satu faktor kunci dalam memulai dan mengembangkan bisnis. Dengan persiapan yang matang, pemilihan sumber modal yang tepat, dan pengelolaan yang baik, Anda dapat memastikan bisnis memiliki fondasi finansial yang kuat untuk berkembang.</p>

                <div class="highlight-box">
                    <strong>🎯 Kunci Sukses:</strong> Modal yang cukup adalah penting, tetapi lebih penting lagi adalah bagaimana Anda mengelola modal tersebut. Fokus pada pertumbuhan yang berkelanjutan dan manajemen keuangan yang sehat.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
