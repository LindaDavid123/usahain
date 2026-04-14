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
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="theme-color" content="#1C6494">
<title>Informasi Bisnis - <?= htmlspecialchars($user['nama']); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>

<style>
:root {
    --primary: #1c6494;
    --primary-dark: #175379;
    --text: #111827;
    --text-secondary: #6b7280;
    --bg: #f1f5f9;
    --card: #ffffff;
    --border: #e5e7eb;
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Inter', Arial, sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
    display: flex;
}

.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    width: 260px;
    background: #fff;
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    z-index: 999;
    transition: all 0.3s;
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar.collapsed {
    width: 80px;
}

.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
}

.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: #1f6b99;
    font-size: 16px;
    font-weight: 800;
    white-space: nowrap;
    min-width: 40px;
}

.sidebar-logo img {
    width: 40px;
    height: 40px;
    border-radius: 8px;
}

.sidebar-menu {
    flex: 1;
    overflow-y: auto;
    padding: 14px 12px;
    list-style: none;
}

.sidebar-menu-item {
    margin-bottom: 8px;
}

.sidebar-menu-link {
    display: flex;
    align-items: center;
    gap: 0;
    padding: 12px 16px;
    border-radius: 10px;
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
}

.sidebar-menu-link:hover {
    background: #f8fafc;
    color: #1f6b99;
    transform: translateX(4px);
}

.sidebar-menu-link.active {
    background: linear-gradient(135deg, #1f6b99 0%, #3a88ba 100%);
    color: #fff;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(31, 107, 153, 0.25);
}

.sidebar-menu-icon {
    display: none;
    width: 18px;
    height: 18px;
}

.sidebar-menu-icon i,
.sidebar-menu-icon svg {
    width: 18px;
    height: 18px;
}

.sidebar-menu-badge {
    margin-left: auto;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    background: rgba(31, 107, 153, 0.1);
    color: #1f6b99;
}

.sidebar-menu-link.active .sidebar-menu-badge {
    background: #1c6494;
    color: #fff;
}

body.sidebar-collapsed .sidebar-menu-text,
body.sidebar-collapsed .sidebar-menu-badge,
body.sidebar-collapsed .sidebar-logo-text {
    display: none;
}

.main-wrapper {
    margin-left: 260px;
    width: calc(100% - 260px);
    transition: margin-left 0.3s ease, width 0.3s ease;
}

body.sidebar-collapsed .main-wrapper {
    margin-left: 84px;
    width: calc(100% - 84px);
}

.top-header {
    height: 70px;
    background: #fff;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 22px;
}

.header-title {
    font-size: 15px;
    font-weight: 600;
    color: #111827;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.header-user {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: inherit;
}

.header-user-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #dbeafe;
    color: #1c6494;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
}

.header-user-info {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.header-user-name {
    font-size: 12px;
    font-weight: 600;
    color: #111827;
}

.header-user-email {
    font-size: 11px;
    color: #6b7280;
}

.container {
    max-width: 1200px;
    margin: 28px auto;
    padding: 0 18px;
}

.page-header {
    margin-bottom: 22px;
}

.page-header h1 {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 6px;
}

.page-header p {
    font-size: 13px;
    color: #6b7280;
}

.controls-wrapper {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.content-panel {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px;
}

.search-box {
    flex: 1;
    min-width: 240px;
}

.search-box input {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(28, 100, 148, 0.1);
}

.filter-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 8px 12px;
    border: 1px solid var(--border);
    background: #fff;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #4b5563;
    cursor: pointer;
}

.filter-btn.active,
.filter-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin: 0 0 8px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
}

.info-section {
    margin-bottom: 20px;
}

.info-section:last-of-type {
    margin-bottom: 0;
}

.cards-grid {
    display: block;
}

.info-card {
    position: relative;
    display: block;
    background: transparent;
    border: none;
    border-bottom: 1px solid #f3f4f6;
    border-radius: 0;
    padding: 12px 68px 12px 0;
    min-height: 0;
}

.info-card:last-child {
    border-bottom: none;
}

.card-head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 2px;
}

.card-icon {
    width: 16px;
    height: 16px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #1c6494;
    flex-shrink: 0;
}

.card-icon i,
.card-icon svg {
    width: 16px;
    height: 16px;
    stroke-width: 2;
}

.info-card h3 {
    font-size: 14px;
    font-weight: 500;
    color: #111827;
    line-height: 1.4;
}

.info-card p {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.45;
    margin: 0 0 0 26px;
}

.card-actions {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    margin-top: 0;
}

.btn-learn {
    padding: 0;
    border: none;
    background: transparent;
    color: #1c6494;
    font-size: 12px;
    font-weight: 500;
    border-radius: 0;
    cursor: pointer;
    text-decoration: none;
}

.btn-learn:hover {
    text-decoration: underline;
}

.modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    z-index: 2000;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

.modal.active {
    display: flex;
}

.modal-content {
    width: 100%;
    max-width: 560px;
    background: #fff;
    border-radius: 12px;
    border: 1px solid var(--border);
    overflow: hidden;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
}

.modal-header h2 {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
}

.modal-close {
    border: none;
    background: #f3f4f6;
    color: #4b5563;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
}

.modal-body {
    padding: 16px;
}

.modal-body p {
    font-size: 13px;
    color: #374151;
    line-height: 1.55;
    margin-bottom: 8px;
}

.modal-body p:last-child {
    margin-bottom: 0;
}

.no-results {
    display: none;
    margin-top: 18px;
    padding: 12px 0 0;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
    font-size: 12px;
    color: #6b7280;
    text-align: center;
    background: transparent;
}

.no-results.show {
    display: block;
}

@media (max-width: 1024px) {
    .main-wrapper {
        margin-left: 0;
        width: 100%;
    }

    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        border-right: none;
        border-bottom: 1px solid var(--border);
    }

    body.sidebar-collapsed .main-wrapper {
        margin-left: 0;
        width: 100%;
    }

    body.sidebar-collapsed .sidebar-menu-text,
    body.sidebar-collapsed .sidebar-menu-badge,
    body.sidebar-collapsed .sidebar-logo-text {
        display: inline;
    }
}

@media (max-width: 768px) {
    .top-header {
        padding: 0 14px;
    }

    .header-user-email {
        display: none;
    }

    .container {
        padding: 0 12px;
    }

    .content-panel {
        padding: 16px;
    }

    .info-card {
        padding-right: 0;
    }

    .card-actions {
        position: static;
        transform: none;
        margin: 4px 0 0 26px;
    }
}
</style>
</head>

<body>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="#" onclick="toggleSidebar(); return false;" class="sidebar-logo" title="Klik untuk buka atau tutup sidebar">
            <img src="<?= base_url('assets/logo.png'); ?>" alt="Usahain">
            <span class="sidebar-logo-text">Usahain</span>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li class="sidebar-menu-item">
            <a href="<?= site_url('auth/dashboard'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="layout-grid"></i></span>
                <span class="sidebar-menu-text">Dashboard</span>
                <span class="sidebar-menu-badge">Home</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('advisor'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="sparkles"></i></span>
                <span class="sidebar-menu-text">AI Advisor</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('hpp'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="calculator"></i></span>
                <span class="sidebar-menu-text">Kalkulator HPP</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('keuangan'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="wallet"></i></span>
                <span class="sidebar-menu-text">Pencatatan Keuangan</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('risiko'); ?>" class="sidebar-menu-link">
                <span class="sidebar-menu-icon"><i data-lucide="shield-alert"></i></span>
                <span class="sidebar-menu-text">Manajemen Risiko</span>
            </a>
        </li>
        <li class="sidebar-menu-item">
            <a href="<?= site_url('auth/info_bisnis'); ?>" class="sidebar-menu-link active">
                <span class="sidebar-menu-icon"><i data-lucide="book-open"></i></span>
                <span class="sidebar-menu-text">Informasi Bisnis</span>
            </a>
        </li>
    </ul>
</aside>

<div class="main-wrapper">
    <header class="top-header">
        <div class="header-title">Informasi Bisnis</div>
        <div class="header-right">
            <a href="<?= site_url('user/profile'); ?>" class="header-user">
                <div class="header-user-avatar"><?= strtoupper(substr($user['nama'], 0, 1)); ?></div>
                <div class="header-user-info">
                    <div class="header-user-name"><?= htmlspecialchars($user['nama']); ?></div>
                    <div class="header-user-email"><?= htmlspecialchars($user['email']); ?></div>
                </div>
            </a>
        </div>
    </header>

    <main class="container">
        <div class="page-header">
            <h1>Informasi Bisnis</h1>
            <p>Referensi ringkas legalitas dan praktik terbaik untuk mengembangkan UMKM Anda.</p>
        </div>

        <div class="controls-wrapper">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari informasi bisnis..." onkeyup="applyFilters()">
            </div>
            <div class="filter-group">
                <button class="filter-btn active" data-category="semua" onclick="filterByCategory('semua')">Semua</button>
                <button class="filter-btn" data-category="izin" onclick="filterByCategory('izin')">Legalitas &amp; Perizinan</button>
                <button class="filter-btn" data-category="tips" onclick="filterByCategory('tips')">Tips Sukses UMKM</button>
            </div>
        </div>

        <div class="content-panel">
            <section class="info-section" data-section="izin">
                <h2 class="section-title">Legalitas &amp; Perizinan</h2>
                <div class="cards-grid">
                <article class="info-card" data-category="izin" data-keywords="siup izin tempat kerja operasional">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="file-text"></i></span>
                        <h3>Surat Izin Tempat Usaha (SIUP)</h3>
                    </div>
                    <p>Izin dasar untuk operasional tempat usaha.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://oss.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="izin" data-keywords="pirt izin edar produk makanan">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="clipboard-list"></i></span>
                        <h3>PIRT (Pangan Industri Rumah Tangga)</h3>
                    </div>
                    <p>Izin khusus untuk produk makanan atau minuman.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://oss.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="izin" data-keywords="sertifikat industri rumah tangga irt">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="factory"></i></span>
                        <h3>Sertifikat Industri Rumah Tangga</h3>
                    </div>
                    <p>Sertifikat legal untuk usaha mikro berbasis rumah.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://oss.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="izin" data-keywords="halal sertifikasi bpjph">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="badge-check"></i></span>
                        <h3>Sertifikasi Halal</h3>
                    </div>
                    <p>Sertifikasi halal untuk produk konsumsi masyarakat.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://ptsp.halal.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="izin" data-keywords="merek dagang hki trademark">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="badge-plus"></i></span>
                        <h3>Pendaftaran Merek Dagang</h3>
                    </div>
                    <p>Perlindungan hukum untuk identitas brand usaha.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://merek.dgip.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="izin" data-keywords="bpom obat suplemen kosmetik">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="shield-check"></i></span>
                        <h3>Izin BPOM</h3>
                    </div>
                    <p>Izin BPOM untuk produk kesehatan dan kosmetik.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://e-reg.pom.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>
                </div>
            </section>

            <section class="info-section" data-section="tips">
                <h2 class="section-title">Tips Sukses UMKM</h2>
                <div class="cards-grid">
                <article class="info-card" data-category="tips" data-keywords="manajemen operasional efisiensi">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="settings"></i></span>
                        <h3>Kelola Manajemen Usaha Anda</h3>
                    </div>
                    <p>Terapkan manajemen terstruktur untuk efisiensi operasional bisnis.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://www.depkop.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="tips" data-keywords="digital marketing media sosial online">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="smartphone"></i></span>
                        <h3>Manfaatkan Digital Marketing</h3>
                    </div>
                    <p>Gunakan kanal digital untuk memperluas pasar secara terukur.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://kemendag.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="tips" data-keywords="kualitas produk pelanggan standar">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="star"></i></span>
                        <h3>Fokus pada Kualitas Produk</h3>
                    </div>
                    <p>Jaga kualitas agar pelanggan loyal dan rekomendasi meningkat.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://www.depkop.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="tips" data-keywords="kompetitor analisis strategi">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="search"></i></span>
                        <h3>Analisis Kompetitor</h3>
                    </div>
                    <p>Pelajari pesaing untuk menemukan celah diferensiasi bisnis.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://www.depkop.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="tips" data-keywords="networking kemitraan jaringan">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="handshake"></i></span>
                        <h3>Bangun Jaringan &amp; Kemitraan</h3>
                    </div>
                    <p>Perluas jejaring untuk dukungan supplier dan kolaborasi usaha.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://kemitraan.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>

                <article class="info-card" data-category="tips" data-keywords="keuangan cash flow laporan">
                    <div class="card-head">
                        <span class="card-icon"><i data-lucide="wallet"></i></span>
                        <h3>Kelola Keuangan dengan Baik</h3>
                    </div>
                    <p>Pisahkan dana bisnis dan pantau arus kas rutin.</p>
                    <div class="card-actions">
                        <a class="btn-learn" href="https://www.ojk.go.id" target="_blank" rel="noopener noreferrer">Pelajari</a>
                    </div>
                </article>
                </div>
            </section>

            <div class="no-results" id="noResults">Tidak ada card yang cocok dengan pencarian atau filter.</div>
        </div>
    </main>
</div>

<div class="modal" id="detailModal" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="detailTitle">Detail Informasi</h2>
            <button class="modal-close" onclick="closeDetail()" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body" id="detailBody"></div>
    </div>
</div>

<script>
const detailContent = {
    siup: {
        title: 'Surat Izin Tempat Usaha (SIUP)',
        paragraphs: [
            'Persyaratan: KTP, surat keterangan dari kelurahan.',
            'Proses: permohonan ke DPMPTSP setempat.',
            'Masa berlaku: 5 tahun.'
        ]
    },
    pirt: {
        title: 'PIRT (Pangan Industri Rumah Tangga)',
        paragraphs: [
            'Untuk: produk makanan dan minuman.',
            'Proses: uji lab dan dokumentasi produksi.',
            'Durasi: 2 sampai 4 minggu.'
        ]
    },
    irt: {
        title: 'Sertifikat Industri Rumah Tangga',
        paragraphs: [
            'Untuk: UMKM dengan produksi di rumah.',
            'Persyaratan: permohonan sederhana dan verifikasi.',
            'Manfaat: legalitas serta akses pasar lebih luas.'
        ]
    },
    halal: {
        title: 'Sertifikasi Halal',
        paragraphs: [
            'Wajib untuk: produk makanan dan minuman.',
            'Proses: permohonan ke BPJPH dan audit dokumen.',
            'Masa berlaku: 4 tahun.'
        ]
    },
    merek: {
        title: 'Pendaftaran Merek Dagang',
        paragraphs: [
            'Fungsi: proteksi dari peniruan merek.',
            'Proses: permohonan ke Ditjen HKI Kemenkumham.',
            'Durasi: 1 sampai 2 tahun.'
        ]
    },
    bpom: {
        title: 'Izin BPOM',
        paragraphs: [
            'Untuk: obat tradisional, suplemen, dan kosmetik.',
            'Persyaratan: dokumen teknis dan uji lab BPOM.',
            'Validitas: 5 tahun.'
        ]
    },
    manajemen: {
        title: 'Kelola Manajemen Usaha Anda',
        paragraphs: [
            'Terapkan sistem manajemen yang terstruktur untuk meningkatkan efisiensi operasional.',
            'Langkah ini membantu profitabilitas bisnis lebih terjaga secara berkelanjutan.'
        ]
    },
    digital: {
        title: 'Manfaatkan Digital Marketing',
        paragraphs: [
            'Gunakan media sosial, website, dan email marketing untuk menjangkau audiens lebih luas.',
            'Strategi digital membantu biaya promosi lebih efisien dan terukur.'
        ]
    },
    kualitas: {
        title: 'Fokus pada Kualitas Produk',
        paragraphs: [
            'Kualitas adalah kunci loyalitas pelanggan dalam jangka panjang.',
            'Jaga standar produk, dengarkan masukan, dan terus tingkatkan kualitas.'
        ]
    },
    kompetitor: {
        title: 'Analisis Kompetitor',
        paragraphs: [
            'Pelajari strategi kompetitor dan identifikasi keunggulan mereka.',
            'Cari celah pasar untuk diferensiasi produk atau layanan usaha Anda.'
        ]
    },
    jaringan: {
        title: 'Bangun Jaringan dan Kemitraan',
        paragraphs: [
            'Networking adalah aset penting untuk pertumbuhan bisnis UMKM.',
            'Bergabunglah dengan komunitas dan bangun kemitraan strategis dengan supplier.'
        ]
    },
    keuangan: {
        title: 'Kelola Keuangan dengan Baik',
        paragraphs: [
            'Kelola keuangan dengan disiplin dan pisahkan dana pribadi serta bisnis.',
            'Pantau arus kas rutin agar keputusan bisnis lebih tepat.'
        ]
    }
};

let currentCategory = 'semua';

function renderLucideIcons() {
    if (window.lucide) {
        lucide.createIcons();
    }
}

function toggleSidebar() {
    if (window.innerWidth <= 1024) {
        return;
    }

    document.body.classList.toggle('sidebar-collapsed');
    document.getElementById('sidebar').classList.toggle('collapsed');
}

function filterByCategory(category) {
    currentCategory = category;

    document.querySelectorAll('.filter-btn').forEach(btn => {
        if (btn.dataset.category === category) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    applyFilters();
}

function applyFilters() {
    const keyword = document.getElementById('searchInput').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.info-card');
    const sectionCounts = { izin: 0, tips: 0 };
    let visibleCardCount = 0;

    cards.forEach(card => {
        const cardCategory = card.dataset.category;
        const cardText = (card.innerText + ' ' + (card.dataset.keywords || '')).toLowerCase();

        const passCategory = currentCategory === 'semua' || cardCategory === currentCategory;
        const passKeyword = keyword === '' || cardText.includes(keyword);

        if (passCategory && passKeyword) {
            card.style.display = '';
            visibleCardCount += 1;
            sectionCounts[cardCategory] += 1;
        } else {
            card.style.display = 'none';
        }
    });

    document.querySelectorAll('.info-section').forEach(section => {
        const sectionKey = section.dataset.section;
        section.style.display = sectionCounts[sectionKey] > 0 ? '' : 'none';
    });

    document.getElementById('noResults').classList.toggle('show', visibleCardCount === 0);
}

function openDetail(key) {
    const data = detailContent[key];
    if (!data) {
        return;
    }

    const modal = document.getElementById('detailModal');
    const title = document.getElementById('detailTitle');
    const body = document.getElementById('detailBody');

    title.textContent = data.title;
    body.innerHTML = data.paragraphs.map(text => '<p>' + text + '</p>').join('');

    modal.classList.add('active');
    modal.setAttribute('aria-hidden', 'false');
}

function closeDetail() {
    const modal = document.getElementById('detailModal');
    modal.classList.remove('active');
    modal.setAttribute('aria-hidden', 'true');
}

window.addEventListener('click', function (event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeDetail();
    }
});

document.addEventListener('DOMContentLoaded', function () {
    renderLucideIcons();
    applyFilters();
});
</script>
</body>
</html>
