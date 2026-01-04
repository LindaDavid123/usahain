<?php
$user = array_merge([
    'nama'  => 'User',
    'email' => '-',
    'role'  => '-',
    'usaha' => 'Bisnis Anda',
    'type'  => 'UMKM'
], $user ?? []);
?>

<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=5,user-scalable=yes">
<meta name="theme-color" content="#1C6494">
<title>Rekomendasi Informasi Bisnis - <?= htmlspecialchars($user['nama']); ?></title>

<style>
:root {
    --primary-color: #4A90E2;
    --primary-dark: #357ABD;
    --primary-light: #6BA4EC;
    --secondary-color: #7EC8E3;
    --secondary-light: #A8DCE8;
    --accent-color: #52D79A;
    --accent-dark: #2ecc71;
    --background: #F5F8FA;
    --card-bg: #ffffff;
    --text-primary: #2D3748;
    --text-secondary: #718096;
    --shadow-sm: 0 2px 8px rgba(74,144,226,0.08);
    --shadow-md: 0 4px 16px rgba(74,144,226,0.12);
    --shadow-lg: 0 8px 24px rgba(74,144,226,0.16);
}

*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Inter,Segoe UI,Arial;background:var(--background);color:var(--text-primary)}

/* HEADER / NAVBAR */
.header{
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    padding:20px 32px;
    color:#fff;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:var(--shadow-md);
    position:sticky;
    top:0;
    z-index:100
}

.header h3{font-size:20px;font-weight:700}
.header small{opacity:.9}

.header-right{
    display:flex;
    align-items:center;
    gap:14px
}

.avatar{
    width:46px;height:46px;border-radius:50%;
    background:var(--card-bg);
    color:var(--primary-color);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;
    box-shadow:var(--shadow-sm);
    border:2px solid rgba(255,255,255,0.3)
}

.logout-btn{
    background:rgba(255,255,255,.18);
    color:#fff;
    padding:9px 18px;
    border-radius:24px;
    font-size:13px;
    text-decoration:none;
    font-weight:600;
    transition:.3s ease;
    border:1.5px solid rgba(255,255,255,0.3)
}
.logout-btn:hover{
    background:rgba(255,255,255,.3);
    border-color:rgba(255,255,255,0.5);
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(0,0,0,0.15)
}

/* CONTAINER */
.container{max-width:1200px;margin:0 auto;padding:0 24px}

/* BANNER SECTION */
.info-banner{
    background:linear-gradient(135deg, var(--secondary-light) 0%, var(--secondary-color) 100%);
    color:#fff;
    padding:40px 32px;
    border-radius:16px;
    margin:30px 0;
    text-align:center;
    box-shadow:var(--shadow-md)
}

.info-banner h1{
    font-size:28px;
    font-weight:700;
    margin-bottom:10px
}

.info-banner p{
    font-size:14px;
    opacity:.95;
    max-width:600px;
    margin:0 auto
}

/* SECTION TITLE */
.section-title{
    font-size:22px;
    font-weight:700;
    margin:40px 0 24px;
    color:var(--primary-color);
    text-align:center;
    padding:20px 0;
    border-bottom:3px solid var(--secondary-light);
    display:inline-block;
    width:100%
}

/* CARDS GRID */
.cards-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:20px;
    margin-bottom:40px
}

.info-card{
    background:var(--card-bg);
    border-radius:12px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    border:2px solid transparent;
    border-left:4px solid var(--primary-color);
    position:relative;
    overflow:hidden;
    display:flex;
    flex-direction:column
}

.info-card:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-lg);
    border-color:var(--secondary-light)
}

.info-card .icon{
    font-size:40px;
    margin-bottom:12px;
    display:block
}

.info-card h3{
    font-size:16px;
    font-weight:700;
    margin-bottom:12px;
    color:var(--text-primary);
    line-height:1.3
}

.info-card p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.6;
    margin-bottom:16px;
    flex:1
}

.info-card ul{
    font-size:12px;
    color:var(--text-secondary);
    margin:16px 0;
    padding-left:20px;
}

.info-card ul li{
    margin-bottom:8px;
    line-height:1.5
}

.info-card .btn-info{
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    color:#fff;
    padding:10px 18px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
    border:none;
    cursor:pointer;
    transition:.3s ease;
    display:inline-block;
    width:fit-content
}

.info-card .btn-info:hover{
    transform:translateY(-2px);
    box-shadow:var(--shadow-md)
}

/* TIP CARDS - Different styling */
.tip-card{
    background:var(--card-bg);
    border-radius:12px;
    padding:28px;
    box-shadow:var(--shadow-sm);
    transition:.3s ease;
    border:2px solid transparent;
    text-align:center;
    position:relative;
}

.tip-card:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-md);
    border-color:var(--secondary-light)
}

.tip-card .icon{
    font-size:48px;
    margin-bottom:12px;
    display:block
}

.tip-card h3{
    font-size:16px;
    font-weight:700;
    margin-bottom:12px;
    color:var(--text-primary)
}

.tip-card p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.6
}

/* RESOURCE SECTION - Accordion */
.resources-section{
    margin-bottom:40px
}

.resource-item{
    background:var(--card-bg);
    border-radius:12px;
    margin-bottom:12px;
    box-shadow:var(--shadow-sm);
    overflow:hidden;
    transition:.3s ease
}

.resource-header{
    padding:20px 24px;
    cursor:pointer;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg, var(--primary-light) 0%, var(--primary-color) 100%);
    color:#fff;
    font-weight:600;
    user-select:none;
    transition:.3s ease
}

.resource-header:hover{
    box-shadow:var(--shadow-md)
}

.resource-header .icon{
    margin-right:12px;
    font-size:24px
}

.resource-header .toggle{
    font-size:20px;
    transition:.3s ease
}

.resource-header.active .toggle{
    transform:rotate(180deg)
}

.resource-content{
    padding:0;
    max-height:0;
    overflow:hidden;
    transition:max-height 0.3s ease;
}

.resource-content.active{
    padding:20px 24px;
    max-height:1000px
}

.resource-content p{
    font-size:13px;
    color:var(--text-secondary);
    line-height:1.7;
    margin-bottom:12px
}

.resource-content ul{
    font-size:13px;
    color:var(--text-secondary);
    margin-left:20px;
    margin-bottom:12px
}

.resource-content ul li{
    margin-bottom:8px;
    line-height:1.6
}

/* FOOTER */
.footer-simple {
    width: 100%;
    background: #f8fbfd;
    border-top: 1px solid #e6eef5;
    padding: 12px 0;
    font-size: 13px;
    color: #6c757d;
    margin-top:60px
}

.footer-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .header{padding:16px 20px}
    .header h3{font-size:18px}
    .avatar{width:38px;height:38px}
    
    .container{padding:0 16px}
    
    .info-banner{padding:30px 20px;margin:20px 0}
    .info-banner h1{font-size:22px}
    .info-banner p{font-size:13px}
    
    .section-title{font-size:18px;margin:30px 0 16px}
    
    .cards-grid{grid-template-columns:1fr;gap:16px}
    
    .footer-inner{flex-direction:column;text-align:center}
}

@media(max-width:576px){
    .header{padding:14px 16px}
    .header h3{font-size:16px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .header small{display:none}
    
    .container{padding:0 12px}
    
    .info-banner{padding:24px 16px;border-radius:12px;margin:16px 0}
    .info-banner h1{font-size:20px}
    
    .section-title{font-size:16px;margin:24px 0 12px}
    
    .info-card,.tip-card{padding:20px}
    .info-card .icon,.tip-card .icon{font-size:32px}
    .info-card h3,.tip-card h3{font-size:14px}
    .info-card p,.tip-card p{font-size:12px}
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div>
        <h3>ℹ️ Rekomendasi Informasi Bisnis</h3>
    </div>

    <div class="header-right">
        <a href="<?= base_url('auth/logout'); ?>" 
           class="logout-btn"
           onclick="return confirm('Yakin ingin logout?')">
           Logout
        </a>
        <div class="avatar"><?= strtoupper(substr($user['nama'],0,1)); ?></div>
    </div>
</div>

<div class="container">

    <!-- BANNER -->
    <div class="info-banner">
        <h1>Rekomendasi Informasi Bisnis</h1>
        <p>Pelajari langkah-langkah penting, strategi, dan tips ayo sukses untuk UMKM Indonesia</p>
    </div>

    <!-- SECTION 1: LEGALISITAS & PERIZINAN -->
    <div class="section-title">📋 Legalisitas & Perizinan Usaha</div>
    <div class="cards-grid">
        <div class="info-card">
            <span class="icon">📄</span>
            <h3>Surat Izin Tempat Kerja (SIUP)</h3>
            <p>Izin dasar untuk operasional tempat usaha</p>
            <ul>
                <li>Persyaratan: KTP, surat keterangan dari kelurahan</li>
                <li>Proses: Permohonan ke DPMPTSP setempat</li>
                <li>Masa berlaku: 5 tahun</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: SIUP diterbitkan oleh Dinas Perindustrian dan Perdagangan Kabupaten/Kota. Biaya admin terjangkau dan cukup penting untuk legalitas usaha Anda.')">Pelajari</button>
        </div>

        <div class="info-card">
            <span class="icon">📋</span>
            <h3>Surat Izin Edar Bermasalah (SIER)</h3>
            <p>Izin khusus untuk produk yang dijual</p>
            <ul>
                <li>Untuk: Produk makanan, minuman, kosmetik</li>
                <li>Proses: Uji lab, dokumentasi produksi</li>
                <li>Durasi: 2-4 minggu</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: SIER memastikan produk Anda aman untuk dikonsumsi. Kelengkapan: sertifikat lab, formula produk, dan riwayat supplier.')">Pelajari</button>
        </div>

        <div class="info-card">
            <span class="icon">🏭</span>
            <h3>Sertifikat Industri Rumah Tangga</h3>
            <p>Sertifikat untuk usaha mikro di rumah</p>
            <ul>
                <li>Untuk: UMKM dengan produksi di rumah</li>
                <li>Persyaratan: Permohonan sederhana, verifikasi</li>
                <li>Manfaat: Legalitas + akses pasar lebih luas</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: Sertifikat ini mempermudah distribusi produk dan meningkatkan kredibilitas usaha Anda di mata konsumen.')">Pelajari</button>
        </div>

        <div class="info-card">
            <span class="icon">✨</span>
            <h3>Sertifikasi Halal</h3>
            <p>Sertifikasi halal untuk produk halal</p>
            <ul>
                <li>Wajib untuk: Produk makanan & minuman</li>
                <li>Proses: Permohonan ke BPJPH, audit dokumen</li>
                <li>Masa berlaku: 4 tahun</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: Sertifikasi halal meningkatkan kepercayaan konsumen. Dokumen: resep, supplier, dan proses produksi yang terjamin halal.')">Pelajari</button>
        </div>

        <div class="info-card">
            <span class="icon">™️</span>
            <h3>Pendaftaran Merek Dagang</h3>
            <p>Perlindungan hukum untuk brand Anda</p>
            <ul>
                <li>Fungsi: Proteksi dari peniruan merek</li>
                <li>Proses: Permohonan ke Ditjen HKI Kemenkumham</li>
                <li>Durasi: 1-2 tahun</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: Daftar merek di Kemenkumham agar merek Anda dilindungi secara hukum. Berlaku 10 tahun dan dapat diperpanjang.')">Pelajari</button>
        </div>

        <div class="info-card">
            <span class="icon">🏥</span>
            <h3>Izin BPOM</h3>
            <p>Izin dari Badan POM untuk produk obat/suplemen</p>
            <ul>
                <li>Untuk: Obat tradisional, suplemen, kosmetik</li>
                <li>Persyaratan: Dokumen teknis, uji lab BPOM</li>
                <li>Validitas: 5 tahun</li>
            </ul>
            <button class="btn-info" onclick="alert('Informasi selengkapnya: BPOM memastikan keamanan produk kesehatan. Proses melibatkan uji lab detail dan review dokumen ketat.')">Pelajari</button>
        </div>
    </div>

    <!-- SECTION 2: TIPS SUKSES MEMBANGUN UMKM -->
    <div class="section-title">💡 Tips Sukses Membangun UMKM</div>
    <div class="cards-grid">
        <div class="tip-card">
            <span class="icon">🎯</span>
            <h3>Kelola Manajemen Usaha Anda</h3>
            <p>Terapkan sistem manajemen yang terstruktur untuk meningkatkan efisiensi operasional dan profitabilitas bisnis Anda secara berkelanjutan.</p>
        </div>

        <div class="tip-card">
            <span class="icon">📱</span>
            <h3>Manfaatkan Digital Marketing</h3>
            <p>Gunakan media sosial, website, dan email marketing untuk menjangkau audiens lebih luas dengan biaya yang lebih efisien dan terukur.</p>
        </div>

        <div class="tip-card">
            <span class="icon">⭐</span>
            <h3>Fokus pada Kualitas Produk</h3>
            <p>Kualitas adalah kunci loyalitas pelanggan. Jaga standar produk, dengarkan feedback, dan terus improve berdasarkan kebutuhan pasar.</p>
        </div>

        <div class="tip-card">
            <span class="icon">🔍</span>
            <h3>Analisis Kompetitor</h3>
            <p>Pelajari strategi kompetitor, identifikasi keunggulan mereka, dan cari celah pasar untuk diferensiasi produk atau layanan Anda.</p>
        </div>

        <div class="tip-card">
            <span class="icon">🤝</span>
            <h3>Bangun Jaringan & Kemitraan</h3>
            <p>Networking adalah aset berharga. Bergabunglah dengan komunitas bisnis, bangun kemitraan strategis, dan perluas jaringan supplier.</p>
        </div>

        <div class="tip-card">
            <span class="icon">💰</span>
            <h3>Tata Kelola & Keuangan</h3>
            <p>Kelola keuangan dengan disiplin, pisahkan dana pribadi dan bisnis, buat laporan keuangan berkala, dan rencanakan cash flow dengan baik.</p>
        </div>
    </div>

    <!-- SECTION 3: SUMBER DAYA BERGUNA -->
    <div class="section-title">📚 Sumber Daya Berguna</div>
    <div class="resources-section">
        <div class="resource-item">
            <div class="resource-header" onclick="toggleResource(this)">
                <span><span class="icon">👥</span>Pemberdayaan UMKM</span>
                <span class="toggle">▼</span>
            </div>
            <div class="resource-content">
                <p><strong>Program Pemerintah untuk UMKM:</strong></p>
                <ul>
                    <li><strong>CUKIL (Cepat Usaha Kecil Indonesia Luar Biasa)</strong> - Program pemberdayaan UMKM dengan pelatihan gratis dan pendampingan bisnis</li>
                    <li><strong>Kartu Prakerja</strong> - Dukungan finansial untuk pelatihan dan pengembangan keterampilan</li>
                    <li><strong>LPDB-KUMKM</strong> - Lembaga pembiayaan khusus untuk UMKM dengan bunga kompetitif</li>
                    <li><strong>Kredit Usaha Rakyat (KUR)</strong> - Pinjaman hingga Rp 500 juta dengan bunga rendah dari bank</li>
                </ul>
            </div>
        </div>

        <div class="resource-item">
            <div class="resource-header" onclick="toggleResource(this)">
                <span><span class="icon">📝</span>Panduan Pendaftaran UMKM</span>
                <span class="toggle">▼</span>
            </div>
            <div class="resource-content">
                <p><strong>Langkah-langkah Pendaftaran UMKM:</strong></p>
                <ul>
                    <li><strong>Langkah 1:</strong> Daftar NPSN (Nomor Pokok Statistik Nasional) di BPS online</li>
                    <li><strong>Langkah 2:</strong> Ajukan permohonan NPWP ke KPP terdekat</li>
                    <li><strong>Langkah 3:</strong> Daftar BPJS Ketenagakerjaan jika memiliki karyawan</li>
                    <li><strong>Langkah 4:</strong> Buat akun di OSS (Online Single Submission) untuk perizinan terpadu</li>
                    <li><strong>Langkah 5:</strong> Sesuaikan dokumen spesifik sesuai jenis usaha Anda</li>
                </ul>
            </div>
        </div>

        <div class="resource-item">
            <div class="resource-header" onclick="toggleResource(this)">
                <span><span class="icon">💻</span>Go Digital & Expert</span>
                <span class="toggle">▼</span>
            </div>
            <div class="resource-content">
                <p><strong>Program Digitalisasi untuk UMKM:</strong></p>
                <ul>
                    <li><strong>Gerakan Nasional 1 Juta UMKM Digital</strong> - Program gratis untuk transformasi digital UMKM</li>
                    <li><strong>Platform E-Commerce Gratis</strong> - Manfaatkan Tokopedia, Shopee, Lazada untuk menjual online</li>
                    <li><strong>Pelatihan Digital Marketing</strong> - Workshop dan webinar gratis tentang SEO, social media, email marketing</li>
                    <li><strong>Akses ke Pasar Global</strong> - Platform ekspor seperti Global Trade Atlas dan Trade Information Portal</li>
                </ul>
            </div>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer class="footer-simple">
    <div class="footer-inner">
        <div class="footer-left">
            © 2025 <span class="brand">Usahain</span> · Platform Manajemen UMKM Terpadu
        </div>
        <div class="footer-right">
            <a href="#">Tentang</a>
            <span>•</span>
            <a href="#">Fitur</a>
            <span>•</span>
            <a href="#">Kebijakan Privasi</a>
            <span>•</span>
            <a href="#">Bantuan</a>
        </div>
    </div>
</footer>

<script>
function toggleResource(header) {
    header.classList.toggle('active');
    const content = header.nextElementSibling;
    content.classList.toggle('active');
}
</script>

</body>
</html>
