<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Risiko extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        $this->load->model('Manajemen_risiko_model', 'risiko_model');
    }

    public function index()
    {
        $this->require_login();
        $this->risiko_model->ensure_schema();

        $id_user = (int) $this->session->userdata('id_user');
        $edit_risiko = null;
        $analyze_requested = (string) $this->input->get('auto_analyze') === '1';

        if ($this->input->method() === 'post') {
            $this->set_form_rules();

            $id_risiko = (int) $this->input->post('id_risiko');

            if ($this->form_validation->run()) {
                $payload = $this->build_payload_from_input();

                if ($id_risiko > 0) {
                    $existing = $this->risiko_model->get_by_id_for_user($id_risiko, $id_user);
                    if (! $existing) {
                        $this->session->set_flashdata('error', 'Data risiko tidak ditemukan.');
                    } else {
                        if (empty($payload['tanggal'])) {
                            $payload['tanggal'] = $existing->tanggal ?: date('Y-m-d');
                        }
                        $this->risiko_model->update_for_user($id_risiko, $id_user, $payload);
                        $this->session->set_flashdata('success', 'Risiko berhasil diperbarui.');
                    }
                } else {
                    if (empty($payload['tanggal'])) {
                        $payload['tanggal'] = date('Y-m-d');
                    }
                    $this->risiko_model->insert_for_user($id_user, $payload);
                    $this->session->set_flashdata('success', 'Risiko berhasil ditambahkan.');
                }

                redirect('risiko');
                return;
            }

            $id_risiko_post = (int) $this->input->post('id_risiko');
            if ($id_risiko_post > 0) {
                $edit_risiko = $this->risiko_model->get_by_id_for_user($id_risiko_post, $id_user);
            }
        }

        $edit_id = (int) $this->input->get('edit');
        if ($edit_id > 0 && ! $edit_risiko) {
            $edit_risiko = $this->risiko_model->get_by_id_for_user($edit_id, $id_user);
            if (! $edit_risiko) {
                $this->session->set_flashdata('error', 'Data risiko tidak ditemukan.');
                redirect('risiko');
                return;
            }
        }

        $data = [
            'user' => $this->get_user_data(),
            'summary' => $this->risiko_model->get_summary_by_user($id_user),
            'risiko_list' => $this->risiko_model->get_by_user($id_user),
            'edit_risiko' => $edit_risiko,
            'analyze_requested' => $analyze_requested,
            'auto_analysis' => $analyze_requested ? $this->build_automatic_financial_analysis($id_user) : null,
        ];

        $this->load->view('risiko/index', $data);
    }

    public function add_auto_risk()
    {
        $this->require_login();
        $this->risiko_model->ensure_schema();

        if ($this->input->method() !== 'post') {
            redirect('risiko?auto_analyze=1');
            return;
        }

        $id_user = (int) $this->session->userdata('id_user');
        $nama_risiko = trim((string) $this->input->post('nama_risiko'));
        $tingkat = trim((string) $this->input->post('tingkat'));
        $keterangan = trim((string) $this->input->post('keterangan'));

        if ($nama_risiko === '' || $keterangan === '' || ! in_array($tingkat, ['Tinggi', 'Sedang', 'Rendah'], true)) {
            $this->session->set_flashdata('error', 'Risiko otomatis tidak valid untuk disimpan.');
            redirect('risiko?auto_analyze=1');
            return;
        }

        $this->risiko_model->insert_for_user($id_user, [
            'nama_risiko' => $nama_risiko,
            'tingkat' => $tingkat,
            'tindakan_mitigasi' => $keterangan,
            'status_penanganan' => 'Belum Ditangani',
            'tanggal' => date('Y-m-d'),
        ]);

        $this->session->set_flashdata('success', 'Risiko otomatis berhasil ditambahkan ke daftar risiko.');
        redirect('risiko?auto_analyze=1');
    }

    public function auto_analysis_data()
    {
        if (! $this->session->userdata('id_user')) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Unauthorized',
                ]));
            return;
        }

        $id_user = (int) $this->session->userdata('id_user');
        $analysis = $this->build_automatic_financial_analysis($id_user);

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode([
                'success' => true,
                'analysis' => $analysis,
            ]));
    }

    public function list_risiko()
    {
        redirect('risiko');
    }

    public function dashboard()
    {
        redirect('risiko');
    }

    public function view($id = null)
    {
        if (! $id) {
            redirect('risiko');
            return;
        }

        redirect('risiko?edit=' . (int) $id);
    }

    public function create()
    {
        redirect('risiko');
    }

    public function edit($id = null)
    {
        if (! $id) {
            redirect('risiko');
            return;
        }

        redirect('risiko?edit=' . (int) $id);
    }

    public function delete($id = null)
    {
        $this->require_login();
        $this->risiko_model->ensure_schema();

        if (! $id) {
            show_404();
            return;
        }

        if ($this->input->method() !== 'post') {
            redirect('risiko');
            return;
        }

        $id_user = (int) $this->session->userdata('id_user');
        $deleted = $this->risiko_model->delete_for_user((int) $id, $id_user);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Risiko berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data risiko.');
        }

        redirect('risiko');
    }

    private function require_login()
    {
        if (! $this->session->userdata('id_user')) {
            redirect('auth/login');
        }
    }

    private function set_form_rules()
    {
        $this->form_validation->set_rules('nama_risiko', 'Nama Risiko', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('tingkat', 'Tingkat', 'required|in_list[Tinggi,Sedang,Rendah]');
        $this->form_validation->set_rules('tindakan_mitigasi', 'Tindakan Mitigasi', 'required|trim');
        $this->form_validation->set_rules('status_penanganan', 'Status', 'required|in_list[Belum Ditangani,Dalam Proses,Sudah Ditangani]');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim');
    }

    private function build_payload_from_input()
    {
        return [
            'nama_risiko' => trim((string) $this->input->post('nama_risiko')),
            'tingkat' => (string) $this->input->post('tingkat'),
            'tindakan_mitigasi' => trim((string) $this->input->post('tindakan_mitigasi')),
            'status_penanganan' => (string) $this->input->post('status_penanganan'),
            'tanggal' => trim((string) $this->input->post('tanggal')),
        ];
    }

    private function get_user_data()
    {
        return [
            'nama'  => $this->session->userdata('nama') ?: 'User',
            'email' => $this->session->userdata('email') ?: '-',
            'role'  => $this->session->userdata('role') ?: '-',
            'usaha' => $this->session->userdata('nama_usaha') ?: 'Bisnis Anda',
            'type'  => 'UMKM',
        ];
    }

    private function build_automatic_financial_analysis($id_user)
    {
        $transactions = $this->db
            ->select('jenis, nominal, tanggal, kategori, catatan')
            ->from('pencatatan_keuangan')
            ->where('id_user', (int) $id_user)
            ->order_by('tanggal', 'ASC')
            ->get()
            ->result_array();

        if (empty($transactions)) {
            return [
                'has_financial_data' => false,
                'empty_message' => 'Belum ada data keuangan. Mulai catat transaksi di Pencatatan Keuangan untuk mendapatkan analisis risiko otomatis.',
                'detected_risks' => [],
                'projections' => [],
                'suggestions' => [],
            ];
        }

        $month_now = date('Y-m');
        $month_prev = date('Y-m', strtotime('first day of last month'));
        $month_prev2 = date('Y-m', strtotime('first day of -2 month'));

        $monthly = [];
        $total_income = 0.0;
        $total_expense = 0.0;

        foreach ($transactions as $tx) {
            $month_key = date('Y-m', strtotime((string) $tx['tanggal']));
            if (! isset($monthly[$month_key])) {
                $monthly[$month_key] = [
                    'income' => 0.0,
                    'expense' => 0.0,
                ];
            }

            $jenis = strtolower((string) $tx['jenis']);
            $amount = (float) $tx['nominal'];

            if ($jenis === 'pemasukan') {
                $monthly[$month_key]['income'] += $amount;
                $total_income += $amount;
            } elseif ($jenis === 'pengeluaran') {
                $monthly[$month_key]['expense'] += $amount;
                $total_expense += $amount;
            }
        }

        $monthly3 = [
            $month_prev2 => $monthly[$month_prev2] ?? ['income' => 0.0, 'expense' => 0.0],
            $month_prev => $monthly[$month_prev] ?? ['income' => 0.0, 'expense' => 0.0],
            $month_now => $monthly[$month_now] ?? ['income' => 0.0, 'expense' => 0.0],
        ];

        $income_now = (float) $monthly3[$month_now]['income'];
        $expense_now = (float) $monthly3[$month_now]['expense'];
        $income_prev = (float) $monthly3[$month_prev]['income'];
        $expense_prev2 = (float) $monthly3[$month_prev2]['expense'];
        $expense_prev = (float) $monthly3[$month_prev]['expense'];
        $balance_now = $total_income - $total_expense;
        $balance_3months = (
            ((float) $monthly3[$month_prev2]['income'] + (float) $monthly3[$month_prev]['income'] + (float) $monthly3[$month_now]['income']) -
            ((float) $monthly3[$month_prev2]['expense'] + (float) $monthly3[$month_prev]['expense'] + (float) $monthly3[$month_now]['expense'])
        );

        $has_activity_prev2 = ((float) $monthly3[$month_prev2]['income'] + (float) $monthly3[$month_prev2]['expense']) > 0;
        $has_activity_prev = ((float) $monthly3[$month_prev]['income'] + (float) $monthly3[$month_prev]['expense']) > 0;
        $has_activity_now = ((float) $monthly3[$month_now]['income'] + (float) $monthly3[$month_now]['expense']) > 0;
        $has_complete_3month_window = $has_activity_prev2 && $has_activity_prev && $has_activity_now;

        $avg_income_3months = (
            (float) $monthly3[$month_prev2]['income'] +
            (float) $monthly3[$month_prev]['income'] +
            (float) $monthly3[$month_now]['income']
        ) / 3;

        $avg_expense_3months = (
            (float) $monthly3[$month_prev2]['expense'] +
            (float) $monthly3[$month_prev]['expense'] +
            (float) $monthly3[$month_now]['expense']
        ) / 3;

        $income_last_7_days = 0.0;
        $date_7_days_ago = date('Y-m-d', strtotime('-6 days'));
        foreach ($transactions as $tx) {
            if (
                strtolower((string) $tx['jenis']) === 'pemasukan' &&
                (string) $tx['tanggal'] >= $date_7_days_ago
            ) {
                $income_last_7_days += (float) $tx['nominal'];
            }
        }

        $detected_risks = [];

        if ($income_now > 0 && $expense_now > ($income_now * 0.8)) {
            $ratio = ($expense_now / $income_now) * 100;
            $detected_risks[] = [
                'nama_risiko' => 'Pengeluaran mendekati batas aman',
                'tingkat' => 'Tinggi',
                'keterangan' => 'Pengeluaran bulan ini mencapai ' . number_format($ratio, 1, ',', '.') . '% dari pemasukan.',
            ];
        }

        if ($has_complete_3month_window && $expense_prev2 > 0 && $expense_prev > $expense_prev2 && $expense_now > $expense_prev) {
            $detected_risks[] = [
                'nama_risiko' => 'Tren pengeluaran meningkat',
                'tingkat' => 'Sedang',
                'keterangan' => 'Pengeluaran meningkat selama 3 bulan berturut-turut.',
            ];
        }

        if ($income_prev > 0 && $income_now < ($income_prev * 0.8)) {
            $drop_percent = (1 - ($income_now / $income_prev)) * 100;
            $detected_risks[] = [
                'nama_risiko' => 'Penurunan pemasukan signifikan',
                'tingkat' => 'Tinggi',
                'keterangan' => 'Pemasukan bulan ini turun ' . number_format($drop_percent, 1, ',', '.') . '% dibanding bulan lalu.',
            ];
        }

        if ($income_last_7_days <= 0) {
            $detected_risks[] = [
                'nama_risiko' => 'Tidak ada pemasukan minggu ini',
                'tingkat' => 'Sedang',
                'keterangan' => 'Tidak tercatat pemasukan dalam 7 hari terakhir.',
            ];
        }

        if ($avg_income_3months > 0 && $balance_3months < ($avg_income_3months * 0.1)) {
            $detected_risks[] = [
                'nama_risiko' => 'Saldo kritis',
                'tingkat' => 'Tinggi',
                'keterangan' => 'Saldo bersih periode 3 bulan terakhir di bawah 10% dari rata-rata pemasukan bulanan.',
            ];
        }

        $projections = [];
        $labels = ['Bulan depan', '2 bulan lagi', '3 bulan lagi'];
        $running_balance = $balance_3months;

        foreach ($labels as $label) {
            $est_income = $avg_income_3months;
            $est_expense = $avg_expense_3months;
            $running_balance += ($est_income - $est_expense);

            if ($running_balance < 0) {
                $status_label = 'Berbahaya';
                $status_class = 'danger';
            } else {
                if ($est_income <= 0) {
                    $status_label = 'Waspada';
                    $status_class = 'warning';
                } else {
                    $ratio = $running_balance / $est_income;
                    if ($ratio > 0.2) {
                        $status_label = 'Aman';
                        $status_class = 'safe';
                    } else {
                        $status_label = 'Waspada';
                        $status_class = 'warning';
                    }
                }
            }

            $projections[] = [
                'periode' => $label,
                'estimasi_pemasukan' => $est_income,
                'estimasi_pengeluaran' => $est_expense,
                'estimasi_saldo' => $running_balance,
                'status_label' => $status_label,
                'status_class' => $status_class,
            ];
        }

        $suggestions = [];

        if ($income_now > 0) {
            $expense_ratio = ($expense_now / $income_now) * 100;
            if ($expense_ratio >= 70) {
                $suggestions[] = 'Pengeluaran operasional Anda mencapai ' . number_format($expense_ratio, 1, ',', '.') . '% dari pemasukan. Targetkan maksimal 70%.';
            }
        }

        if ($avg_income_3months > 0 && $balance_3months < ($avg_income_3months * 0.1)) {
            $suggestions[] = 'Tidak ada dana darurat terdeteksi. Sisihkan minimal 10% dari pemasukan setiap bulan.';
        }

        $top_product_name = $this->get_top_hpp_product_name($id_user);
        if ($top_product_name !== null) {
            $suggestions[] = 'Pemasukan dari produk ' . $top_product_name . ' stabil. Pertahankan stok.';
        }

        if (empty($suggestions)) {
            $suggestions[] = 'Arus kas Anda cenderung stabil. Tetap pertahankan disiplin pencatatan keuangan dan evaluasi mingguan.';
        }

        return [
            'has_financial_data' => true,
            'empty_message' => '',
            'detected_risks' => $detected_risks,
            'projections' => $projections,
            'suggestions' => $suggestions,
        ];
    }

    private function get_top_hpp_product_name($id_user)
    {
        if (! $this->db->table_exists('kalkulator_hpp')) {
            return null;
        }

        if (! $this->db->field_exists('nama_produk', 'kalkulator_hpp')) {
            return null;
        }

        $row = $this->db
            ->select('nama_produk')
            ->from('kalkulator_hpp')
            ->where('id_user', (int) $id_user)
            ->where('nama_produk IS NOT NULL', null, false)
            ->where('nama_produk !=', '')
            ->order_by('harga_jual', 'DESC')
            ->order_by('id_hpp', 'DESC')
            ->limit(1)
            ->get()
            ->row();

        if (! $row) {
            return null;
        }

        return trim((string) $row->nama_produk) !== '' ? trim((string) $row->nama_produk) : null;
    }
}

