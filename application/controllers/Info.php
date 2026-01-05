<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('warning', 'Silakan login terlebih dahulu untuk mengakses halaman Informasi Bisnis');
            redirect('auth/login');
        }

        $user = $this->session->userdata();
        
        // Prepare business information data
        $data = [
            'title' => 'Rekomendasi Informasi Bisnis',
            'user' => $user,
            'articles' => $this->get_articles(),
            'tips' => $this->get_business_tips(),
            'resources' => $this->get_resources()
        ];

        $this->load->view('info/index', $data);
    }

    private function get_articles() {
        return [
            [
                'id' => 1,
                'title' => 'Surat Izin Tempat Kerja (SIUP)',
                'category' => 'Legalisitas',
                'icon' => '📄',
                'excerpt' => 'Izin dasar untuk operasional tempat usaha',
                'content' => 'Surat Izin Tempat Kerja (SIUP) adalah izin dasar yang diperlukan untuk menjalankan usaha di suatu tempat tertentu. SIUP diterbitkan oleh Dinas Perindustrian dan Perdagangan Kabupaten/Kota setempat. Persyaratan: KTP, surat keterangan dari kelurahan, dan fotokopi identitas diri. Proses permohonan ke DPMPTSP setempat biasanya memakan waktu 1-2 minggu. Masa berlaku SIUP adalah 5 tahun dan dapat diperpanjang. Biaya admin relatif terjangkau dan cukup penting untuk legalitas usaha Anda.'
            ],
            [
                'id' => 2,
                'title' => 'Surat Izin Edar Bermasalah (SIER)',
                'category' => 'Legalisitas',
                'icon' => '📋',
                'excerpt' => 'Izin khusus untuk produk yang dijual',
                'content' => 'Surat Izin Edar Bermasalah (SIER) adalah izin yang diperlukan khususnya untuk produk makanan, minuman, kosmetik, dan produk sejenis. SIER memastikan bahwa produk Anda aman untuk dikonsumsi dan telah melewati uji laboratorium. Proses permohonan melibatkan uji lab, dokumentasi produksi lengkap, dan review dokumen dari BPOM. Durasi proses biasanya 2-4 minggu. Kelengkapan yang diperlukan: sertifikat lab, formula produk, dan riwayat supplier bahan baku.'
            ],
            [
                'id' => 3,
                'title' => 'Sertifikat Industri Rumah Tangga',
                'category' => 'Legalisitas',
                'icon' => '🏭',
                'excerpt' => 'Sertifikat untuk usaha mikro di rumah',
                'content' => 'Sertifikat Industri Rumah Tangga adalah sertifikat khusus untuk UMKM dengan produksi di rumah. Sertifikat ini mempermudah distribusi produk dan meningkatkan kredibilitas usaha Anda di mata konsumen. Persyaratan permohonan relatif sederhana, hanya perlu permohonan tertulis dan verifikasi lokasi usaha. Manfaat utama: legalitas bisnis dan akses pasar yang lebih luas. Proses pendaftaran dapat dilakukan di kelurahan atau kantor dinas setempat.'
            ],
            [
                'id' => 4,
                'title' => 'Sertifikasi Halal',
                'category' => 'Legalisitas',
                'icon' => '✨',
                'excerpt' => 'Sertifikasi halal untuk produk halal',
                'content' => 'Sertifikasi Halal adalah sertifikasi wajib untuk produk makanan dan minuman di Indonesia. Sertifikasi ini diterbitkan oleh Badan Pengawas Obat dan Makanan (BPJPH) yang merupakan bagian dari Kementerian Agama. Proses permohonan melibatkan audit dokumen, verifikasi supplier, dan proses produksi yang terjamin halal. Masa berlaku sertifikasi halal adalah 4 tahun dan dapat diperpanjang. Dokumen yang diperlukan: resep lengkap, daftar supplier, dan proses produksi yang tertulis.'
            ],
            [
                'id' => 5,
                'title' => 'Pendaftaran Merek Dagang',
                'category' => 'Legalisitas',
                'icon' => '™️',
                'excerpt' => 'Perlindungan hukum untuk brand Anda',
                'content' => 'Pendaftaran Merek Dagang memberikan perlindungan hukum untuk brand dan identitas bisnis Anda. Merek dagang dapat berupa nama, logo, atau kombinasi keduanya. Proses permohonan dilakukan ke Direktorat Jenderal Hak Kekayaan Intelektual (HKI) Kementerian Hukum dan Hak Asasi Manusia. Durasi proses pendaftaran biasanya 1-2 tahun. Berlaku selama 10 tahun dan dapat diperpanjang seumur hidup. Tujuan: proteksi dari peniruan merek oleh kompetitor.'
            ],
            [
                'id' => 6,
                'title' => 'Izin BPOM',
                'category' => 'Legalisitas',
                'icon' => '🏥',
                'excerpt' => 'Izin dari Badan POM untuk produk obat/suplemen',
                'content' => 'Izin BPOM (Badan Pengawas Obat dan Makanan) diperlukan untuk produk obat tradisional, suplemen, dan kosmetik. BPOM memastikan keamanan dan kualitas produk kesehatan Anda sebelum beredar di pasaran. Persyaratan meliputi: dokumen teknis lengkap, label produk yang sesuai standar, dan uji lab BPOM. Proses review dokumen ketat dan memakan waktu beberapa bulan. Validitas izin adalah 5 tahun. Kepatuhan terhadap regulasi BPOM adalah kunci untuk menghindari masalah hukum.'
            ]
        ];
    }

    private function get_business_tips() {
        return [
            [
                'icon' => '🎯',
                'title' => 'Kelola Manajemen Usaha Anda',
                'description' => 'Terapkan sistem manajemen yang terstruktur untuk meningkatkan efisiensi operasional dan profitabilitas bisnis Anda secara berkelanjutan.'
            ],
            [
                'icon' => '📱',
                'title' => 'Manfaatkan Digital Marketing',
                'description' => 'Gunakan media sosial, website, dan email marketing untuk menjangkau audiens lebih luas dengan biaya yang lebih efisien dan terukur.'
            ],
            [
                'icon' => '⭐',
                'title' => 'Fokus pada Kualitas Produk',
                'description' => 'Kualitas adalah kunci loyalitas pelanggan. Jaga standar produk, dengarkan feedback, dan terus improve berdasarkan kebutuhan pasar.'
            ],
            [
                'icon' => '🔍',
                'title' => 'Analisis Kompetitor',
                'description' => 'Pelajari strategi kompetitor, identifikasi keunggulan mereka, dan cari celah pasar untuk diferensiasi produk atau layanan Anda.'
            ],
            [
                'icon' => '🤝',
                'title' => 'Bangun Jaringan & Kemitraan',
                'description' => 'Networking adalah aset berharga. Bergabunglah dengan komunitas bisnis, bangun kemitraan strategis, dan perluas jaringan supplier.'
            ],
            [
                'icon' => '💰',
                'title' => 'Tata Kelola & Keuangan',
                'description' => 'Kelola keuangan dengan disiplin, pisahkan dana pribadi dan bisnis, buat laporan keuangan berkala, dan rencanakan cash flow dengan baik.'
            ]
        ];
    }

    private function get_resources() {
        return [
            [
                'title' => 'Pemberdayaan UMKM',
                'description' => 'Program pemerintah untuk UMKM dengan pelatihan gratis dan pendampingan bisnis',
                'icon' => '👥',
                'content' => '<p><strong>Program Pemerintah untuk UMKM:</strong></p>
                    <ul>
                        <li><strong>CUKIL (Cepat Usaha Kecil Indonesia Luar Biasa)</strong> - Program pemberdayaan UMKM dengan pelatihan gratis dan pendampingan bisnis</li>
                        <li><strong>Kartu Prakerja</strong> - Dukungan finansial untuk pelatihan dan pengembangan keterampilan</li>
                        <li><strong>LPDB-KUMKM</strong> - Lembaga pembiayaan khusus untuk UMKM dengan bunga kompetitif</li>
                        <li><strong>Kredit Usaha Rakyat (KUR)</strong> - Pinjaman hingga Rp 500 juta dengan bunga rendah dari bank</li>
                    </ul>'
            ],
            [
                'title' => 'Panduan Pendaftaran UMKM',
                'description' => 'Langkah-langkah pendaftaran UMKM yang mudah dan terstruktur',
                'icon' => '📝',
                'content' => '<p><strong>Langkah-langkah Pendaftaran UMKM:</strong></p>
                    <ul>
                        <li><strong>Langkah 1:</strong> Daftar NPSN (Nomor Pokok Statistik Nasional) di BPS online</li>
                        <li><strong>Langkah 2:</strong> Ajukan permohonan NPWP ke KPP terdekat</li>
                        <li><strong>Langkah 3:</strong> Daftar BPJS Ketenagakerjaan jika memiliki karyawan</li>
                        <li><strong>Langkah 4:</strong> Buat akun di OSS (Online Single Submission) untuk perizinan terpadu</li>
                        <li><strong>Langkah 5:</strong> Sesuaikan dokumen spesifik sesuai jenis usaha Anda</li>
                    </ul>'
            ],
            [
                'title' => 'Go Digital & Expert',
                'description' => 'Program digitalisasi untuk transformasi bisnis Anda ke era digital',
                'icon' => '💻',
                'content' => '<p><strong>Program Digitalisasi untuk UMKM:</strong></p>
                    <ul>
                        <li><strong>Gerakan Nasional 1 Juta UMKM Digital</strong> - Program gratis untuk transformasi digital UMKM</li>
                        <li><strong>Platform E-Commerce Gratis</strong> - Manfaatkan Tokopedia, Shopee, Lazada untuk menjual online</li>
                        <li><strong>Pelatihan Digital Marketing</strong> - Workshop dan webinar gratis tentang SEO, social media, email marketing</li>
                        <li><strong>Akses ke Pasar Global</strong> - Platform ekspor seperti Global Trade Atlas dan Trade Information Portal</li>
                    </ul>'
            ]
        ];
    }
}
