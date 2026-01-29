<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuangan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow public access (no login required)
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $data['transaksi_list'] = $this->db->where('id_user', $id_user)
            ->order_by('tanggal', 'DESC')
            ->get('pencatatan_keuangan')
            ->result();
        $this->load->view('keuangan/index', $data);
    }

    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $transaksi = $this->db->get_where('pencatatan_keuangan', ['id_transaksi' => $id, 'id_user' => $id_user])->row();
        if (!$transaksi) { show_404(); return; }
        $data['transaksi'] = $transaksi;
        $this->load->view('keuangan/view', $data);
    }

    public function create()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|max_length[100]');
            $this->form_validation->set_rules('jenis', 'Jenis', 'required|in_list[pemasukan,pengeluaran]');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|valid_date[Y-m-d]');
            $this->form_validation->set_rules('catatan', 'Catatan', 'max_length[500]');

            if ($this->form_validation->run() === TRUE) {
                $id_user = $this->session->userdata('id_user');
                $data = [
                    'id_user' => $id_user,
                    'kategori' => $this->input->post('kategori'),
                    'jenis' => $this->input->post('jenis'),
                    'nominal' => $this->input->post('nominal'),
                    'tanggal' => $this->input->post('tanggal'),
                    'catatan' => $this->input->post('catatan'),
                ];
                $this->db->insert('pencatatan_keuangan', $data);
                redirect('keuangan');
                return;
            }
        }
        $this->load->view('keuangan/form');
    }

    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $transaksi = $this->db->get_where('pencatatan_keuangan', ['id_transaksi' => $id, 'id_user' => $id_user])->row();
        if (!$transaksi) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('kategori', 'Kategori', 'required|max_length[100]');
            $this->form_validation->set_rules('jenis', 'Jenis', 'required|in_list[pemasukan,pengeluaran]');
            $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');
            $this->form_validation->set_rules('tanggal', 'Tanggal', 'required|valid_date[Y-m-d]');
            $this->form_validation->set_rules('catatan', 'Catatan', 'max_length[500]');

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'kategori' => $this->input->post('kategori'),
                    'jenis' => $this->input->post('jenis'),
                    'nominal' => $this->input->post('nominal'),
                    'tanggal' => $this->input->post('tanggal'),
                    'catatan' => $this->input->post('catatan'),
                ];
                $this->db->where('id_transaksi', $id)->update('pencatatan_keuangan', $update_data);
                redirect('keuangan');
                return;
            }
        }

        $data['transaksi'] = $transaksi;
        $this->load->view('keuangan/form', $data);
    }

    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $transaksi = $this->db->get_where('pencatatan_keuangan', ['id_transaksi' => $id, 'id_user' => $id_user])->row();
        if (!$transaksi) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            $data['transaksi'] = $transaksi;
            $this->load->view('keuangan/delete', $data);
            return;
        }

        $this->db->where('id_transaksi', $id)->delete('pencatatan_keuangan');
        redirect('keuangan');
    }

    public function summary()
    {
        $id_user = $this->session->userdata('id_user');
        $pemasukan = $this->db->query("SELECT SUM(nominal) as total FROM pencatatan_keuangan 
                                      WHERE id_user = ? AND jenis = 'pemasukan'", [$id_user])->row();
        $pengeluaran = $this->db->query("SELECT SUM(nominal) as total FROM pencatatan_keuangan 
                                        WHERE id_user = ? AND jenis = 'pengeluaran'", [$id_user])->row();

        $data['total_pemasukan'] = $pemasukan->total ?? 0;
        $data['total_pengeluaran'] = $pengeluaran->total ?? 0;
        $data['net'] = $data['total_pemasukan'] - $data['total_pengeluaran'];

        $this->load->view('keuangan/summary', $data);
    }
    
    // API untuk get data transaksi (untuk frontend)
    public function get_data()
    {
        header('Content-Type: application/json');
        $id_user = $this->session->userdata('id_user');
        if (!$id_user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }
        
        $transaksi = $this->db->where('id_user', $id_user)
            ->order_by('tanggal', 'DESC')
            ->get('pencatatan_keuangan')
            ->result();
        
        // Format tanggal untuk frontend
        foreach ($transaksi as $tx) {
            $date = new DateTime($tx->tanggal);
            $tx->tanggal_display = $date->format('D, d F Y');
            $tx->tanggal = $tx->tanggal; // Keep original date for sorting
        }
        
        echo json_encode([
            'success' => true,
            'transaksi' => $transaksi
        ]);
    }
    
    // API untuk save transaksi dari frontend
    public function save_transaksi()
    {
        header('Content-Type: application/json');
        $id_user = $this->session->userdata('id_user');
        if (!$id_user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }
        
        $jenis = $this->input->post('jenis');
        $deskripsi = $this->input->post('deskripsi');
        $tanggal = $this->input->post('tanggal');
        $jumlah = (int) $this->input->post('jumlah');
        
        // Validasi
        if (!$jenis || !$deskripsi || !$tanggal || $jumlah <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }
        
        if (!in_array($jenis, ['masuk', 'keluar'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid jenis']);
            return;
        }
        
        // Map dari frontend (masuk/keluar) ke database (pemasukan/pengeluaran)
        $jenis_db = ($jenis === 'masuk') ? 'pemasukan' : 'pengeluaran';
        
        $data = [
            'id_user' => $id_user,
            'jenis' => $jenis_db,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'nominal' => $jumlah,
            'kategori' => $deskripsi, // Use deskripsi as kategori
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('pencatatan_keuangan', $data);
        $id_inserted = $this->db->insert_id();
        
        echo json_encode([
            'success' => true,
            'id_transaksi' => $id_inserted,
            'message' => 'Data saved successfully'
        ]);
    }
    
    // API untuk update transaksi
    public function update_transaksi($id = null)
    {
        header('Content-Type: application/json');
        $id_user = $this->session->userdata('id_user');
        if (!$id_user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID required']);
            return;
        }
        
        // Check if transaction belongs to user
        $check = $this->db->get_where('pencatatan_keuangan', 
            ['id_transaksi' => $id, 'id_user' => $id_user])->row();
        if (!$check) {
            echo json_encode(['success' => false, 'message' => 'Transaction not found']);
            return;
        }
        
        $jenis = $this->input->post('jenis');
        $deskripsi = $this->input->post('deskripsi');
        $tanggal = $this->input->post('tanggal');
        $jumlah = (int) $this->input->post('jumlah');
        
        // Validasi
        if (!$jenis || !$deskripsi || !$tanggal || $jumlah <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            return;
        }
        
        if (!in_array($jenis, ['masuk', 'keluar'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid jenis']);
            return;
        }
        
        $jenis_db = ($jenis === 'masuk') ? 'pemasukan' : 'pengeluaran';
        
        $update_data = [
            'jenis' => $jenis_db,
            'deskripsi' => $deskripsi,
            'tanggal' => $tanggal,
            'nominal' => $jumlah,
            'kategori' => $deskripsi
        ];
        
        $this->db->where('id_transaksi', $id)->update('pencatatan_keuangan', $update_data);
        
        echo json_encode([
            'success' => true,
            'message' => 'Data updated successfully'
        ]);
    }
    
    // API untuk delete transaksi
    public function delete_transaksi($id = null)
    {
        header('Content-Type: application/json');
        $id_user = $this->session->userdata('id_user');
        if (!$id_user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }
        
        if (!$id) {
            echo json_encode(['success' => false, 'message' => 'ID required']);
            return;
        }
        
        // Check if transaction belongs to user
        $check = $this->db->get_where('pencatatan_keuangan', 
            ['id_transaksi' => $id, 'id_user' => $id_user])->row();
        if (!$check) {
            echo json_encode(['success' => false, 'message' => 'Transaction not found']);
            return;
        }
        
        $this->db->delete('pencatatan_keuangan', ['id_transaksi' => $id]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }
}