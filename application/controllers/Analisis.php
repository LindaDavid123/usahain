<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url']);
        $this->load->database();
        $this->ensureHppSchema();
    }

    private function ensureHppSchema()
    {
        $this->addColumnIfMissing('kalkulator_hpp', 'nama_produk', 'VARCHAR(250) NULL', 'id_user');
        $this->addColumnIfMissing('kalkulator_hpp', 'kategori', 'VARCHAR(100) NULL', 'nama_produk');
        $this->addColumnIfMissing('kalkulator_hpp', 'jumlah_produksi', 'INT NULL', 'kategori');
    }

    private function addColumnIfMissing($table, $column, $definition, $afterColumn = null)
    {
        if ($this->db->field_exists($column, $table)) {
            return;
        }

        $afterClause = '';
        if ($afterColumn && $this->db->field_exists($afterColumn, $table)) {
            $afterClause = ' AFTER `' . $afterColumn . '`';
        }

        $sql = 'ALTER TABLE `' . $table . '` ADD COLUMN `' . $column . '` ' . $definition . $afterClause;
        $this->db->query($sql);
    }

    private function normalizeKey($text)
    {
        $value = trim((string) $text);
        $value = preg_replace('/\s+/', ' ', $value);
        return strtolower($value);
    }

    private function resolveProductKeyFromTransaction($sourceText, $productMap)
    {
        if (empty($productMap)) {
            return null;
        }

        $needle = $this->normalizeKey($sourceText);
        if ($needle === '') {
            return null;
        }

        if (isset($productMap[$needle])) {
            return $needle;
        }

        foreach ($productMap as $key => $item) {
            if (strpos($needle, $key) !== false || strpos($key, $needle) !== false) {
                return $key;
            }
        }

        return null;
    }

    private function computeTrend($history)
    {
        if (empty($history)) {
            return [
                'label' => 'Stabil',
                'direction' => 'stable',
                'percentage' => 0,
            ];
        }

        ksort($history);
        $values = array_values($history);
        $lastValue = (float) end($values);

        if (count($values) < 2) {
            return [
                'label' => 'Data belum cukup',
                'direction' => 'stable',
                'percentage' => 0,
            ];
        }

        $previousValue = (float) $values[count($values) - 2];
        if ($previousValue <= 0) {
            if ($lastValue > 0) {
                return [
                    'label' => 'Naik',
                    'direction' => 'up',
                    'percentage' => 100,
                ];
            }

            return [
                'label' => 'Stabil',
                'direction' => 'stable',
                'percentage' => 0,
            ];
        }

        $change = (($lastValue - $previousValue) / $previousValue) * 100;
        if ($change > 5) {
            return [
                'label' => 'Naik',
                'direction' => 'up',
                'percentage' => round($change, 1),
            ];
        }

        if ($change < -5) {
            return [
                'label' => 'Turun',
                'direction' => 'down',
                'percentage' => round(abs($change), 1),
            ];
        }

        return [
            'label' => 'Stabil',
            'direction' => 'stable',
            'percentage' => round(abs($change), 1),
        ];
    }

    private function disabledActionRedirect()
    {
        $this->session->set_flashdata(
            'analisis_info',
            'Input manual Analisis Produk sudah dinonaktifkan. Data analisis sekarang otomatis dari Kalkulator HPP dan Pencatatan Keuangan.'
        );
        redirect('hpp#analisis-produk');
    }

    public function index()
    {
        redirect('hpp#analisis-produk');
        return;

        $idUser = (int) ($this->session->userdata('id_user') ?: 0);

        $hppRows = $this->db
            ->select('id_hpp, nama_produk, jumlah_produksi, total_biaya, harga_jual, created_at')
            ->from('kalkulator_hpp')
            ->where('id_user', $idUser)
            ->order_by('created_at', 'ASC')
            ->order_by('id_hpp', 'ASC')
            ->get()
            ->result();

        $keuanganRows = $this->db
            ->select('kategori, catatan, jenis, nominal, tanggal, created_at')
            ->from('pencatatan_keuangan')
            ->where('id_user', $idUser)
            ->where('jenis', 'pemasukan')
            ->order_by('tanggal', 'ASC')
            ->order_by('id_transaksi', 'ASC')
            ->get()
            ->result();

        $productMap = [];
        foreach ($hppRows as $row) {
            $rawName = trim((string) ($row->nama_produk ?? ''));
            $displayName = $rawName !== '' ? $rawName : ('Produk #' . (int) $row->id_hpp);
            $key = $this->normalizeKey($displayName);

            if (!isset($productMap[$key])) {
                $productMap[$key] = [
                    'nama_produk' => $displayName,
                    'total_penjualan' => 0,
                    'biaya_produksi' => 0,
                    'history' => [],
                    'records' => 0,
                    'keuangan_pemasukan' => 0,
                ];
            }

            $hargaJual = (float) ($row->harga_jual ?? 0);
            $totalBiaya = (float) ($row->total_biaya ?? 0);
            $totalPenjualan = $hargaJual;

            $monthSource = !empty($row->created_at) ? $row->created_at : date('Y-m-d');
            $monthTimestamp = strtotime($monthSource);
            $monthKey = $monthTimestamp ? date('Y-m', $monthTimestamp) : date('Y-m');

            $productMap[$key]['total_penjualan'] += $totalPenjualan;
            $productMap[$key]['biaya_produksi'] += $totalBiaya;
            $productMap[$key]['records']++;

            if (!isset($productMap[$key]['history'][$monthKey])) {
                $productMap[$key]['history'][$monthKey] = 0;
            }
            $productMap[$key]['history'][$monthKey] += $totalPenjualan;
        }

        foreach ($keuanganRows as $trx) {
            $source = trim((string) ($trx->catatan ?: $trx->kategori));
            $productKey = $this->resolveProductKeyFromTransaction($source, $productMap);
            if ($productKey === null) {
                continue;
            }

            $nominal = (float) ($trx->nominal ?? 0);
            if ($nominal <= 0) {
                continue;
            }

            $dateSource = !empty($trx->tanggal) ? $trx->tanggal : (!empty($trx->created_at) ? $trx->created_at : date('Y-m-d'));
            $dateTimestamp = strtotime($dateSource);
            $monthKey = $dateTimestamp ? date('Y-m', $dateTimestamp) : date('Y-m');

            $productMap[$productKey]['keuangan_pemasukan'] += $nominal;
            if (!isset($productMap[$productKey]['history'][$monthKey])) {
                $productMap[$productKey]['history'][$monthKey] = 0;
            }
            $productMap[$productKey]['history'][$monthKey] += $nominal;
        }

        $produkComparison = [];
        foreach ($productMap as $item) {
            $margin = $item['total_penjualan'] - $item['biaya_produksi'];
            $trend = $this->computeTrend($item['history']);
            $hasKeuanganData = (float) $item['keuangan_pemasukan'] > 0;

            $produkComparison[] = [
                'nama_produk' => $item['nama_produk'],
                'total_penjualan' => $item['total_penjualan'],
                'biaya_produksi' => $item['biaya_produksi'],
                'margin' => $margin,
                'status' => $margin >= 0 ? 'Untung' : 'Rugi',
                'trend_label' => $trend['label'],
                'trend_direction' => $trend['direction'],
                'trend_percentage' => $trend['percentage'],
                'keuangan_pemasukan' => $item['keuangan_pemasukan'],
                'sumber_data_label' => $hasKeuanganData ? 'Data gabungan' : 'Data HPP saja',
                'sumber_data_type' => $hasKeuanganData ? 'mix' : 'hpp',
            ];
        }

        usort($produkComparison, function ($a, $b) {
            return $b['total_penjualan'] <=> $a['total_penjualan'];
        });

        $produkTerlaris = !empty($produkComparison) ? $produkComparison[0] : null;

        $produkPalingMenguntungkan = null;
        $produkPerluPerhatian = null;
        foreach ($produkComparison as $product) {
            if ($produkPalingMenguntungkan === null || $product['margin'] > $produkPalingMenguntungkan['margin']) {
                $produkPalingMenguntungkan = $product;
            }
            if ($produkPerluPerhatian === null || $product['margin'] < $produkPerluPerhatian['margin']) {
                $produkPerluPerhatian = $product;
            }
        }

        $rekomendasi = [];
        if ($produkTerlaris) {
            $rekomendasi[] = 'Pertahankan ketersediaan stok untuk ' . $produkTerlaris['nama_produk'] . ' karena saat ini menjadi produk dengan penjualan tertinggi.';
        }

        if ($produkPalingMenguntungkan && $produkPalingMenguntungkan['margin'] > 0) {
            $rekomendasi[] = 'Gunakan strategi produk ' . $produkPalingMenguntungkan['nama_produk'] . ' sebagai acuan margin untuk produk lain.';
        }

        if ($produkPerluPerhatian && $produkPerluPerhatian['margin'] < 0) {
            $rekomendasi[] = 'Produk ' . $produkPerluPerhatian['nama_produk'] . ' mengalami margin negatif. Evaluasi harga jual, biaya produksi, atau pertimbangkan menghentikan produk ini.';
        } else {
            $rekomendasi[] = 'Semua produk masih mencatat margin positif. Fokuskan optimasi pada produk dengan tren turun.';
        }

        $data['has_hpp_data'] = !empty($hppRows);
        $data['produk_comparison'] = $produkComparison;
        $data['summary'] = [
            'total_produk_aktif' => count($produkComparison),
            'produk_terlaris' => $produkTerlaris,
            'produk_paling_menguntungkan' => $produkPalingMenguntungkan,
            'produk_perlu_perhatian' => $produkPerluPerhatian,
        ];
        $data['chart'] = [
            'labels' => array_map(function ($item) {
                return $item['nama_produk'];
            }, $produkComparison),
            'values' => array_map(function ($item) {
                return (float) $item['total_penjualan'];
            }, $produkComparison),
        ];
        $data['rekomendasi'] = $rekomendasi;
        $data['toast_success'] = (string) ($this->session->flashdata('analisis_success') ?: '');
        $data['toast_info'] = (string) ($this->session->flashdata('analisis_info') ?: '');

        $this->load->view('analisis/index', $data);
    }

    public function view($id = null)
    {
        $this->disabledActionRedirect();
    }

    public function create()
    {
        $this->disabledActionRedirect();
    }

    public function edit($id = null)
    {
        $this->disabledActionRedirect();
    }

    public function delete($id = null)
    {
        $this->disabledActionRedirect();
    }
}

