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
    <title>Panduan Riset Pasar</title>
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
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('dashboard/perencanaan'); ?>" class="back-button">← Kembali ke Dashboard</a>

        <div class="guide-header">
            <h1>🔍 Panduan Riset Pasar</h1>
            <p>Memahami pasar adalah kunci kesuksesan bisnis Anda</p>
        </div>

        <div class="guide-content">
            <div class="guide-sections-wrapper">
            <div class="guide-section">
                <div class="section-header">
                    <div class="section-number">1</div>
                    <h2>Pengertian Riset Pasar</h2>
                </div>
                <p>Riset pasar adalah proses investigasi sistematis untuk mengumpulkan, menganalisis, dan menginterpretasikan informasi tentang pasar, kompetitor, dan konsumen. Riset pasar membantu Anda membuat keputusan bisnis yang lebih baik dan mengurangi risiko.</p>

                <h3>Mengapa Riset Pasar Penting?</h3>
                <ul>
                    <li><strong>Mengidentifikasi Peluang:</strong> Menemukan celah pasar yang belum terlayani</li>
                    <li><strong>Mengurangi Risiko:</strong> Membuat keputusan berdasarkan data, bukan asumsi</li>
                    <li><strong>Memahami Pelanggan:</strong> Mengerti kebutuhan, keinginan, dan perilaku konsumen</li>
                    <li><strong>Menganalisis Kompetitor:</strong> Melihat kekuatan dan kelemahan kompetitor</li>
                    <li><strong>Strategi Harga:</strong> Menetapkan harga yang kompetitif dan menguntungkan</li>
                </ul>
            </div>

            <div class="guide-section">
                <div class="section-header">
                    <div class="section-number">2</div>
                    <h2>Jenis-Jenis Riset Pasar</h2>
                </div>
                <h3>A. Riset Kualitatif</h3>
                <p>Fokus pada pemahaman mendalam tentang motivasi, perasaan, dan perilaku konsumen:</p>
                <ul>
                    <li><strong>Focus Group Discussion (FGD):</strong> Diskusi kelompok mendalam dengan calon pelanggan</li>
                    <li><strong>In-depth Interview:</strong> Wawancara mendalam dengan individu</li>
                    <li><strong>Observasi:</strong> Mengamati perilaku konsumen secara langsung</li>
                </ul>

                <h3>B. Riset Kuantitatif</h3>
                <p>Menggunakan angka dan statistik untuk mengukur dan menganalisis data pasar:</p>
                <ul>
                    <li><strong>Survey:</strong> Mengumpulkan data dari sampel besar dengan kuesioner</li>
                    <li><strong>Statistik Pasar:</strong> Menganalisis data pasar yang sudah tersedia</li>
                    <li><strong>Eksperimen:</strong> Melakukan test untuk mengukur reaksi pasar</li>
                </ul>
            </divdiv class="section-header">
                    <div class="section-number">3</div>
                    <h2>Langkah-Langkah Melakukan Riset Pasar</h2>
                </div

            <div class="guide-section">
                <h2>3. Langkah-Langkah Melakukan Riset Pasar</h2>
                <h3>Langkah 1: Menentukan Tujuan Riset</h3>
                <p>Pastikan Anda tahu apa yang ingin ditemukan:</p>
                <ul>
                    <li>Apakah ada permintaan untuk produk/layanan saya?</li>
                    <li>Siapa target pelanggan ideal saya?</li>
                    <li>Berapa harga yang ingin dibayar pelanggan?</li>
                    <li>Apa yang menjadi keunggulan kompetitif saya?</li>
                </ul>

                <h3>Langkah 2: Mengidentifikasi Target Pasar</h3>
                <p>Tentukan siapa yang akan menjadi pelanggan Anda:</p>
                <ul>
                    <li>Demografi: usia, jenis kelamin, pendapatan, pendidikan</li>
                    <li>Geografi: lokasi, daerah urban/rural</li>
                    <li>Psikografi: gaya hidup, nilai, kepribadian</li>
                    <li>Behavior: perilaku pembelian, loyalitas brand</li>
                </ul>

                <h3>Langkah 3: Mengumpulkan Data</h3>
                <p>Pilih metode yang sesuai untuk mengumpulkan data:</p>
                <ul>
                    <li>Survei online atau offline</li>
                    <li>Wawancara dengan calon pelanggan</li>
                    <li>Observasi di lokasi target</li>
                    <li>Menganalisis data sekunder (statistik pemerintah, laporan industri)</li>
                </ul>

                <h3>Langkah 4: Analisis Data</h3>
                <p>Proses data yang telah dikumpulkan untuk mendapatkan insight:</p>
                <ul>
                    <li>Identifikasi pola dan tren</li>
                    <li>Bandingkan dengan kompetitor</li>
                    <li>Hitung permintaan dan potensi pasar</li>
                    <li>Buat proyeksi penjualan</li>
                </ul>

                <h3>Langkah 5: Buat Kesimpulan dan Rekomendasi</h3>
                <p>Tuliskan hasil riset dan rekomendasi untuk strategi bisnis:</p>
                <ul>
                    <li>Ringkasan temuan utama</li>
                    <li>Peluang dan ancaman pasar</li>
                    <li>Rekomendasi strategi bisnis</li>
                    <li>Rencana tindak lanjut</li>
                </ul>
            </divdiv class="section-header">
                    <div class="section-number">4</div>
                    <h2>Analisis Kompetitor</h2>
                </div

            <div class="guide-section">
                <h2>4. Analisis Kompetitor</h2>
                <h3>Mengapa Penting Menganalisis Kompetitor?</h3>
                <p>Memahami kompetitor membantu Anda:</p>
                <ul>
                    <li>Mengidentifikasi keunggulan dan kelemahan mereka</li>
                    <li>Menciptakan strategi yang lebih baik</li>
                    <li>Memprediksi tindakan kompetitor</li>
                    <li>Menemukan diferensiasi yang unik</li>
                </ul>

                <h3>Aspek yang Perlu Dianalisis</h3>
                <ul>
                    <li><strong>Produk/Layanan:</strong> Fitur, kualitas, harga</li>
                    <li><strong>Pemasaran:</strong> Strategi promosi, channels, positioning</li>
                    <li><strong>Kekuatan Finansial:</strong> Harga, margin, profitabilitas</li>
                 div class="section-header">
                    <div class="section-number">5</div>
                    <h2>Segmentasi Pasar dan Positioning</h2>
                </divteknologi, lokasi</li>
                    <li><strong>Keunggulan Kompetitif:</strong> Apa yang membuat mereka berbeda</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>5. Segmentasi Pasar dan Positioning</h2>
                <h3>Segmentasi Pasar</h3>
                <p>Bagi pasar menjadi segmen-segmen yang lebih kecil dan terukur:</p>
                <ul>
                    <li>Identifikasi berbagai kelompok pelanggan dengan kebutuhan berbeda</li>
                    <li>Evaluasi daya tarik setiap segmen</li>
                    <li>Pilih segmen mana yang ingin Anda targetkan</li>
                </ul>

                <h3>Positioning</h3>
                <div class="section-header">
                    <div class="section-number">6</div>
                    <h2>Tools dan Resources untuk Riset Pasar</h2>
                </divsumen:</p>
                <ul>
                    <li>Apa yang membuat produk Anda berbeda?</li>
                    <li>Apa nilai utama yang Anda tawarkan?</li>
                    <li>Bagaimana Anda ingin dipersepsikan oleh konsumen?</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>6. Tools dan Resources untuk Riset Pasar</h2>
                <h3>Tools Online Gratis</h3>
                <ul>
                    <li><strong>Google Trends:</strong> Melihat tren pencarian dan interest konsumen</li>
                    <li><strong>Google Consumer Survey:</strong> Survei cepat kepada konsumen</li>
                    <li><strong>Social Media:</strong> Memahami percakapan dan preferensi konsumen</li>
                    <li><strong>Statista:</strong> Data dan statistik pasar (ada fitur gratis)</li>
                </ul>

                <h3>Data Sekunder</h3>
                <div class="section-header">
                    <div class="section-number">✓</div>
                    <h2>Kesimpulan</h2>
                </div
                    <li>Statistik dari Badan Pusat Statistik (BPS)</li>
                    <li>Laporan industri dari asosiasi industri</li>
                    <li>Artikel berita dan publikasi</li>
                    <li>Database dari platform e-commerce</li>
                </ul>
            </div>
    </div>
        
            <div class="guide-section">
                <h2>Kesimpulan</h2>
                <p>Riset pasar adalah investasi penting untuk kesuksesan bisnis jangka panjang. Dengan memahami pasar, pelanggan, dan kompetitor, Anda dapat membuat keputusan yang lebih baik dan strategi yang lebih efektif.</p>

                <div class="highlight-box">
                    <strong>💡 Ingat:</strong> Riset pasar bukan satu kali selesai, tetapi proses berkelanjutan. Terus monitor pasar dan sesuaikan strategi Anda seiring dengan perubahan pasar.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
