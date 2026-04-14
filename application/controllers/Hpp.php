<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hpp extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
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

    private function buildAnalysisPayload($idUser)
    {
        $hppRows = $this->db
            ->select('id_hpp, nama_produk, jumlah_produksi, total_biaya, harga_jual, created_at')
            ->from('kalkulator_hpp')
            ->where('id_user', $idUser)
            ->order_by('created_at', 'ASC')
            ->order_by('id_hpp', 'ASC')
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

        $produkComparison = [];
        foreach ($productMap as $item) {
            $margin = $item['total_penjualan'] - $item['biaya_produksi'];
            $trend = $this->computeTrend($item['history']);

            $produkComparison[] = [
                'nama_produk' => $item['nama_produk'],
                'total_penjualan' => $item['total_penjualan'],
                'biaya_produksi' => $item['biaya_produksi'],
                'margin' => $margin,
                'status' => $margin >= 0 ? 'Untung' : 'Rugi',
                'trend_label' => $trend['label'],
                'trend_direction' => $trend['direction'],
                'trend_percentage' => $trend['percentage'],
                'sumber_data_label' => 'Data HPP saja',
                'sumber_data_type' => 'hpp',
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

        return [
            'has_hpp_data' => !empty($hppRows),
            'produk_comparison' => $produkComparison,
            'summary' => [
                'total_produk_aktif' => count($produkComparison),
                'produk_terlaris' => $produkTerlaris,
                'produk_paling_menguntungkan' => $produkPalingMenguntungkan,
                'produk_perlu_perhatian' => $produkPerluPerhatian,
            ],
            'chart' => [
                'labels' => array_map(function ($item) {
                    return $item['nama_produk'];
                }, $produkComparison),
                'values' => array_map(function ($item) {
                    return (float) $item['total_penjualan'];
                }, $produkComparison),
            ],
            'rekomendasi' => $rekomendasi,
        ];
    }

    private function getCurrentUserId()
    {
        return (int) ($this->session->userdata('id_user') ?: 0);
    }

    private function sendJson($payload, $statusCode = 200)
    {
        $this->output
            ->set_status_header($statusCode)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($payload));
    }

    private function normalizeHppRow($row)
    {
        $totalBiaya = (float) ($row->total_biaya ?? 0);
        $hargaJual = (float) ($row->harga_jual ?? 0);
        $margin = $hargaJual - $totalBiaya;
        $marginPercentage = $hargaJual > 0 ? round(($margin / $hargaJual) * 100, 1) : 0;

        return [
            'id_hpp' => (int) $row->id_hpp,
            'nama_produk' => trim((string) ($row->nama_produk ?? '')) !== '' ? $row->nama_produk : ('Produk #' . $row->id_hpp),
            'kategori' => trim((string) ($row->kategori ?? '')) !== '' ? $row->kategori : 'Lainnya',
            'jumlah_produksi' => (int) ($row->jumlah_produksi ?: 1),
            'bahan' => (float) ($row->bahan ?? 0),
            'tenaga_kerja' => (float) ($row->tenaga_kerja ?? 0),
            'total_biaya' => $totalBiaya,
            'harga_jual' => $hargaJual,
            'margin' => $margin,
            'margin_percentage' => $marginPercentage,
            'margin_bucket' => $margin >= 0 ? 'tinggi' : 'rendah',
            'created_at' => $row->created_at ?? null,
        ];
    }

    private function getUserRows($idUser)
    {
        return $this->db
            ->select('id_hpp, id_user, nama_produk, kategori, jumlah_produksi, bahan, tenaga_kerja, total_biaya, harga_jual, created_at')
            ->from('kalkulator_hpp')
            ->where('id_user', $idUser)
            ->order_by('id_hpp', 'DESC')
            ->get()
            ->result();
    }

    private function buildPayload($idUser)
    {
        $rows = $this->getUserRows($idUser);
        $items = array_map([$this, 'normalizeHppRow'], $rows);
        $analysisPayload = $this->buildAnalysisPayload($idUser);

        $totalProduk = count($items);
        $totalPenjualan = 0;
        $totalBiaya = 0;
        $totalBahan = 0;
        $totalTenagaKerja = 0;
        $totalMargin = 0;
        $positiveCount = 0;
        $negativeCount = 0;
        $margins = [];
        $marginPercentages = [];

        foreach ($items as $item) {
            $totalPenjualan += $item['harga_jual'];
            $totalBiaya += $item['total_biaya'];
            $totalBahan += $item['bahan'];
            $totalTenagaKerja += $item['tenaga_kerja'];
            $totalMargin += $item['margin'];

            $margins[] = $item['margin'];
            $marginPercentages[] = $item['margin_percentage'];

            if ($item['margin'] > 0) {
                $positiveCount++;
            }
            if ($item['margin'] < 0) {
                $negativeCount++;
            }
        }

        $avgMargin = $totalProduk > 0 ? round($totalMargin / $totalProduk, 2) : 0;
        $avgMarginPercentage = $totalProduk > 0 ? round(array_sum($marginPercentages) / $totalProduk, 1) : 0;

        return [
            'items' => $items,
            'stats' => [
                'total_produk' => $totalProduk,
                'total_penjualan' => $totalPenjualan,
                'total_biaya' => $totalBiaya,
            ],
            'margin_cards' => [
                'avg_margin' => $avgMargin,
                'avg_margin_percentage' => $avgMarginPercentage,
                'max_margin' => $totalProduk > 0 ? max($margins) : 0,
                'min_margin' => $totalProduk > 0 ? min($margins) : 0,
                'positive_count' => $positiveCount,
                'negative_count' => $negativeCount,
                'total_count' => $totalProduk,
            ],
            'charts' => [
                'margin' => [
                    'labels' => array_map(function ($item) {
                        return $item['nama_produk'];
                    }, $items),
                    'values' => array_map(function ($item) {
                        return $item['margin'];
                    }, $items),
                ],
                'cost' => [
                    'bahan' => $totalBahan,
                    'tenaga_kerja' => $totalTenagaKerja,
                    'margin' => $totalMargin,
                ],
            ],
            'analysis' => $analysisPayload,
        ];
    }

    public function index()
    {
        $id_user = $this->getCurrentUserId();
        $data['hpp_list'] = $this->db->get_where('kalkulator_hpp', ['id_user' => $id_user])->result();
        $this->load->view('hpp/index', $data);
    }

    public function list_json()
    {
        $idUser = $this->getCurrentUserId();
        if ($idUser <= 0) {
            $this->sendJson([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
            return;
        }

        $this->sendJson([
            'status' => 'success',
            'payload' => $this->buildPayload($idUser)
        ]);
    }

    public function detail_json($id = null)
    {
        if (!$id) {
            $this->sendJson([
                'status' => 'error',
                'message' => 'ID HPP tidak valid.'
            ], 400);
            return;
        }

        $idUser = $this->getCurrentUserId();
        if ($idUser <= 0) {
            $this->sendJson([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
            return;
        }

        $row = $this->db
            ->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $idUser])
            ->row();

        if (!$row) {
            $this->sendJson([
                'status' => 'error',
                'message' => 'Data tidak ditemukan.'
            ], 404);
            return;
        }

        $this->sendJson([
            'status' => 'success',
            'item' => $this->normalizeHppRow($row)
        ]);
    }

    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $hpp = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $id_user])->row();
        if (!$hpp) { show_404(); return; }
        $data['hpp'] = $hpp;
        $this->load->view('hpp/view', $data);
    }

    public function create()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim|max_length[250]');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('total_biaya_produksi', 'Total Biaya Produksi', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            $this->form_validation->set_rules('jumlah_produksi', 'Jumlah Produksi', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() === TRUE) {
                $id_user = $this->getCurrentUserId();
                $totalBiayaProduksi = (float) $this->input->post('total_biaya_produksi');
                $hargaJual = (float) $this->input->post('harga_jual');
                $jumlahProduksi = (int) $this->input->post('jumlah_produksi');

                $data = [
                    'id_user' => $id_user,
                    'nama_produk' => trim((string) $this->input->post('nama_produk')),
                    'kategori' => trim((string) $this->input->post('kategori')),
                    'jumlah_produksi' => $jumlahProduksi,
                    'bahan' => $totalBiayaProduksi,
                    'tenaga_kerja' => 0,
                    'total_biaya' => $totalBiayaProduksi,
                    'harga_jual' => $hargaJual,
                ];
                $insert_result = $this->db->insert('kalkulator_hpp', $data);
                
                if ($this->input->is_ajax_request()) {
                    if ($insert_result) {
                        $insertId = (int) $this->db->insert_id();
                        $insertedRow = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $insertId])->row();
                        $this->sendJson([
                            'status' => 'success',
                            'message' => 'Data HPP berhasil ditambahkan!',
                            'item' => $this->normalizeHppRow($insertedRow),
                            'payload' => $this->buildPayload($id_user)
                        ], 200);
                    } else {
                        $this->sendJson([
                            'status' => 'error',
                            'message' => 'Gagal menyimpan data ke database'
                        ], 500);
                    }
                    return;
                }
                redirect('hpp');
                return;
            } else {
                if ($this->input->is_ajax_request()) {
                    $this->sendJson([
                        'status' => 'error',
                        'message' => 'Validasi gagal: ' . validation_errors()
                    ], 400);
                    return;
                }
            }
        }
        $this->load->view('hpp/form');
    }

    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->getCurrentUserId();
        $hpp = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $id_user])->row();
        if (!$hpp) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|trim|max_length[250]');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|trim|max_length[100]');
            $this->form_validation->set_rules('total_biaya_produksi', 'Total Biaya Produksi', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
            $this->form_validation->set_rules('jumlah_produksi', 'Jumlah Produksi', 'required|integer|greater_than[0]');

            if ($this->form_validation->run() === TRUE) {
                $totalBiayaProduksi = (float) $this->input->post('total_biaya_produksi');
                $hargaJual = (float) $this->input->post('harga_jual');
                $jumlahProduksi = (int) $this->input->post('jumlah_produksi');

                $update_data = [
                    'nama_produk' => trim((string) $this->input->post('nama_produk')),
                    'kategori' => trim((string) $this->input->post('kategori')),
                    'jumlah_produksi' => $jumlahProduksi,
                    'bahan' => $totalBiayaProduksi,
                    'tenaga_kerja' => 0,
                    'total_biaya' => $totalBiayaProduksi,
                    'harga_jual' => $hargaJual,
                ];
                $update_result = $this->db->where('id_hpp', $id)->update('kalkulator_hpp', $update_data);
                
                if ($this->input->is_ajax_request()) {
                    if ($update_result) {
                        $updatedRow = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id])->row();
                        $this->sendJson([
                            'status' => 'success',
                            'message' => 'Data HPP berhasil diupdate!',
                            'item' => $this->normalizeHppRow($updatedRow),
                            'payload' => $this->buildPayload($id_user)
                        ], 200);
                    } else {
                        $this->sendJson([
                            'status' => 'error',
                            'message' => 'Gagal mengupdate data ke database'
                        ], 500);
                    }
                    return;
                }
                redirect('hpp');
                return;
            } else if ($this->input->is_ajax_request()) {
                $this->sendJson([
                    'status' => 'error',
                    'message' => 'Validasi gagal: ' . validation_errors()
                ], 400);
                return;
            }
        }

        $data['hpp'] = $hpp;
        $this->load->view('hpp/form', $data);
    }

    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->getCurrentUserId();
        $hpp = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $id_user])->row();
        if (!$hpp) {
            if ($this->input->is_ajax_request()) {
                $this->sendJson([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan.'
                ], 404);
                return;
            }
            show_404();
            return;
        }

        if ($this->input->method() !== 'post' && !$this->input->is_ajax_request()) {
            $data['hpp'] = $hpp;
            $this->load->view('hpp/delete', $data);
            return;
        }

        $deleteResult = $this->db->where('id_hpp', $id)->delete('kalkulator_hpp');

        if ($this->input->is_ajax_request()) {
            if ($deleteResult) {
                $this->sendJson([
                    'status' => 'success',
                    'message' => 'Data HPP berhasil dihapus.',
                    'payload' => $this->buildPayload($id_user)
                ], 200);
            } else {
                $this->sendJson([
                    'status' => 'error',
                    'message' => 'Gagal menghapus data HPP.'
                ], 500);
            }
            return;
        }

        redirect('hpp');
    }

    public function recalculate()
    {
        $idUser = $this->getCurrentUserId();
        if ($idUser <= 0) {
            $this->sendJson([
                'status' => 'error',
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
            return;
        }

        $this->db
            ->set('total_biaya', 'COALESCE(bahan, 0) + COALESCE(tenaga_kerja, 0)', false)
            ->where('id_user', $idUser)
            ->update('kalkulator_hpp');

        $this->sendJson([
            'status' => 'success',
            'message' => 'Perhitungan margin berhasil diperbarui dari database.',
            'payload' => $this->buildPayload($idUser)
        ], 200);
    }
}

