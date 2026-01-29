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
    <title>Panduan Memulai Bisnis UMKM</title>
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

        .subsection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .subsection-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .subsection-card:hover {
            border-color: var(--primary-light);
            box-shadow: 0 6px 20px rgba(31, 107, 153, 0.15);
            transform: translateY(-2px);
        }

        .subsection-card strong {
            color: var(--primary);
            display: block;
            margin-bottom: 10px;
            font-size: 1.05em;
        }

        .subsection-card p {
            margin: 0;
            font-size: 0.95em;
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

            .subsection-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="<?= site_url('dashboard/perencanaan'); ?>" class="back-button">← Kembali ke Dashboard</a>

        <div class="guide-header">
            <h1>📚 Panduan Memulai Bisnis UMKM</h1>
            <p>Panduan lengkap untuk pemula yang ingin memulai usaha dari nol</p>
        </div>

        <div class="guide-content">
            <div class="guide-sections-wrapper">
            <div class="guide-section">
                <div class="section-header">
                    <div class="section-number">1</div>
                    <h2>Persiapan Awal</h2>
                </div>
                <h3>Menentukan Ide Bisnis</h3>
                <p>Langkah pertama dalam memulai bisnis UMKM adalah menentukan ide bisnis yang ingin Anda jalankan. Pertimbangkan hal-hal berikut:</p>
                <ul>
                    <li><strong>Passion Anda:</strong> Pilih bisnis yang sesuai dengan minat dan keahlian Anda</li>
                    <li><strong>Permintaan Pasar:</strong> Pastikan ada permintaan dari calon pelanggan</li>
                    <li><strong>Kompetisi:</strong> Analisis kompetitor yang sudah ada</li>
                    <li><strong>Modal Awal:</strong> Pertimbangkan modal yang diperlukan</li>
                </ul>

                <h3>Riset Pasar</h3>
                <p>Melakukan riset pasar adalah kunci untuk memahami peluang bisnis Anda:</p>
                <ul>
                    <li>Identifikasi target pelanggan Anda</li>
                    <li>Analisis kebutuhan dan keinginan pelanggan</li>
                    <li>Pelajari perilaku pembelian konsumen</li>
                    <li>Tentukan harga yang kompetitif</li>
                <div class="section-header">
                    <div class="section-number">2</div>
                    <h2>Perencanaan Bisnis</h2>
                </div
            </div>

            <div class="guide-section">
                <h2>2. Perencanaan Bisnis</h2>
                <h3>Membuat Business Plan</h3>
                <p>Setiap bisnis yang sukses dimulai dengan perencanaan yang matang. Business plan Anda harus mencakup:</p>
                <ul>
                    <li>Deskripsi bisnis dan visi misi</li>
                    <li>Analisis pasar dan kompetitor</li>
                    <li>Strategi pemasaran dan penjualan</li>
                    <li>Proyeksi keuangan dan arus kas</li>
                    <li>Rencana operasional</li>
                </ul>

                <div class="highlight-box">
                    <strong>💡 Tips:</strong> Gunakan tools seperti platform Usahain untuk membantu Anda merencanakan dan mengelola bisnis dengan lebih mudah.
                </div>

                <h3>Menentukan Struktur Organisasi</h3>
                <p>Tentukan bagaimana struktur organisasi bisnis Anda, termasuk:</p>
                <ul>
                    <li>Peran dan tanggung jawab setiap posisi</li>
                    <li>Siapa saja yang akan bergabung dalam tim Anda</li>
                    <li>Sistem komunikasi internal</li>
                </ul>
            </divdiv class="section-header">
                    <div class="section-number">3</div>
                    <h2>Aspek Hukum dan Perizinan</h2>
                </div

            <div class="guide-section">
                <h2>3. Aspek Hukum dan Perizinan</h2>
                <h3>Legalitas Bisnis</h3>
                <p>Pastikan bisnis Anda berjalan secara legal dengan melakukan:</p>
                <ul>
                    <li><strong>Pendaftaran UMKM:</strong> Daftar bisnis Anda ke dinas terkait</li>
                    <li><strong>Nomor Identitas Berusaha (NIB):</strong> Dapatkan NIB dari Kementerian Koordinasi Bidang Perekonomian</li>
                    <li><strong>Surat Izin Usaha Mikro dan Kecil (IUMK):</strong> Persyaratan untuk UMKM tertentu</li>
                    <li><strong>Izin Lokal:</strong> Sesuaikan dengan peraturan daerah Anda</li>
                </ul>

                <h3>Akuntansi dan Perpajakan</h3>
                <p>Kelola keuangan bisnis Anda dengan baik:</p>
                <ul>
                    <li>Pisahkan keuangan pribadi dan bisnis</li>
                    <li>Catat semua transaksi dengan jelas</li>
                    <li>Pahami kewajiban pajak Anda (PPh dan PPN)</li>
                    <li>Pertahankan catatan selama minimal 3 tahun</li>
                </ul>
            </divdiv class="section-header">
                    <div class="section-number">4</div>
                    <h2>Modal dan Pendanaan</h2>
                </div

            <div class="guide-section">
                <h2>4. Modal dan Pendanaan</h2>
                <h3>Menentukan Modal Awal</h3>
                <p>Hitung kebutuhan modal Anda untuk operasional awal:</p>
                <ul>
                    <li>Investasi aset tetap (peralatan, tempat usaha, dll)</li>
                    <li>Modal kerja untuk operasional awal</li>
                    <li>Cadangan untuk kebutuhan mendadak</li>
                </ul>

                <h3>Sumber Modal</h3>
                <p>Anda memiliki beberapa pilihan sumber pendanaan:</p>
                <ul>
                    <li><strong>Modal Pribadi:</strong> Menggunakan tabungan sendiri</li>
                    <li><strong>Pinjaman Bank:</strong> Kredit usaha dari lembaga keuangan</li>
                 div class="section-header">
                    <div class="section-number">5</div>
                    <h2>Strategi Pemasaran</h2>
                </divrong> Mencari investor yang tertarik dengan bisnis Anda</li>
                    <li><strong>Program Pemerintah:</strong> Berbagai program subsidi dan bantuan modal dari pemerintah</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>5. Strategi Pemasaran</h2>
                <h3>Strategi Pemasaran Digital</h3>
                <p>Manfaatkan digital untuk menjangkau lebih banyak pelanggan:</p>
                <ul>
                    <li>Buat website atau toko online</li>
                    <li>Gunakan media sosial (Instagram, Facebook, TikTok, dll)</li>
                    <li>Manfaatkan marketplace (Tokopedia, Shopee, Lazada, dll)</li>
                    <li>Email marketing untuk komunikasi dengan pelanggan</li>
                </ul>

                <h3>Strategi Pemasaran Tradisional</h3>
                <p>Jangan lupakan cara-cara tradisional yang masih efektif:</p>
                <ul>
                    <li>Word of mouth dan referral dari pelanggan</li>
                    <li>Networking dan membangun hubungan bisnis</li>
                 div class="section-header">
                    <div class="section-number">6</div>
                    <h2>Operasional Bisnis</h2>
                </divspanduk, iklan di media lokal)</li>
                    <li>Event dan aktivasi di komunitas</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>6. Operasional Bisnis</h2>
                <h3>Sistem Operasional</h3>
                <p>Buat sistem yang jelas untuk operasional bisnis sehari-hari:</p>
                <ul>
                    <li>Standar operasional prosedur (SOP)</li>
                    <li>Sistem inventori dan supply chain</li>
                    <li>Manajemen kualitas produk/layanan</li>
                    <li>Customer service yang baik</li>
                </ul>

                <h3>Manajemen Keuangan</h3>
                <p>Kelola keuangan operasional dengan baik:</p>
                <ul>
                    <li>Kelola kas dan likuiditas</li>
                    <li>Monitor pendapatan dan pengeluaran</li>
                 div class="section-header">
                    <div class="section-number">7</div>
                    <h2>Pertumbuhan dan Pengembangan</h2>
                </divi>
                    <li>Lakukan evaluasi kinerja keuangan secara berkala</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>7. Pertumbuhan dan Pengembangan</h2>
                <h3>Strategi Pertumbuhan</h3>
                <p>Setelah bisnis mulai berjalan, fokus pada pertumbuhan:</p>
                <ul>
                    <li>Tingkatkan kualitas produk/layanan</li>
                    <li>Ekspansi ke pasar baru</li>
                    <li>Diversifikasi produk/layanan</li>
                    <li>Tingkatkan kapasitas produksi</li>
                </ul>

                <h3>Investasi dalam Sumber Daya Manusia</h3>
                <p>Tim yang baik adalah aset terbesar bisnis Anda:</p>
                <ul>
                    <li>Rekrut orang-orang berkualitas</li>
                    <li>Berikan pelatihan dan pengembangan</li>
                 div class="section-header">
                    <div class="section-number">✓</div>
                    <h2>Kesimpulan</h2>
                </divaya kerja yang positif</li>
                    <li>Motivasi dan apresiasi karyawan</li>
                </ul>
            </div>

            <div class="guide-section">
                <h2>Kesimpulan</h2>
            </div>
                <p>Memulai bisnis UMKM memang memerlukan persiapan yang matang dan kerja keras. Namun dengan perencanaan yang baik, tekad yang kuat, dan pembelajaran berkelanjutan, Anda dapat membangun bisnis yang sukses dan berkelanjutan.</p>
                
                <div class="highlight-box">
                    <strong>🚀 Semangat!</strong> Ingat bahwa setiap pengusaha sukses dimulai dari nol. Jangan takut untuk memulai, dan terus belajar dari pengalaman Anda.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
