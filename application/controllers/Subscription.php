<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

    // Midtrans Snap token generator for AJAX
    public function get_snap_token()
    {
        header('Content-Type: application/json');
        $json = json_decode(file_get_contents('php://input'), true);
        $paket = isset($json['paket']) ? $json['paket'] : null;
        if (!$paket) {
            echo json_encode(['error' => 'Paket tidak valid']);
            return;
        }

        // Paket & harga (hardcoded, sesuaikan dengan kebutuhan)
        $paketList = [
            'essential' => 18000,
            'growth' => 45000,
            'elite' => 85000
        ];
        if (!isset($paketList[$paket])) {
            echo json_encode(['error' => 'Paket tidak ditemukan']);
            return;
        }
        $harga = $paketList[$paket];

        // Midtrans config
        require_once APPPATH . 'third_party/midtrans/Midtrans.php';
        \Midtrans\Config::$serverKey = 'Mid-server-bfrJB66Sbo1p4kFT2P3GxHP3'; // Ganti dengan server key Anda
        \Midtrans\Config::$isProduction = false; // true jika live
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $user_id = $this->session->userdata('id_user') ?: 'guest';
        $order_id = 'SUBS-' . $user_id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $harga
            ],
            'item_details' => [[
                'id' => $paket,
                'price' => $harga,
                'quantity' => 1,
                'name' => ucfirst($paket) . ' Subscription'
            ]],
            'customer_details' => [
                'first_name' => $this->session->userdata('nama') ?: 'User',
                'email' => $this->session->userdata('email') ?: 'user@example.com',
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            echo json_encode(['snapToken' => $snapToken]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Show subscription pricing page
    public function pricing()
    {
        $this->load->view('subscription/pricing');
    }

    public function __construct()
    {
        parent::__construct();
        // Allow public access (no login required)
        $this->load->model('Subscription_model');
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    // List subscription (hanya milik user yang login)
    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $data['subscriptions'] = $this->db->get_where('subscription', ['id_user' => $id_user])->result();
        $this->load->view('subscription/index', $data);
    }

    // View single subscription
    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $sub = $this->db->get_where('subscription', ['id_subs' => $id, 'id_user' => $id_user])->row();
        if (!$sub) { show_404(); return; }
        
        $data['subscription'] = $sub;
        $this->load->view('subscription/view', $data);
    }

    // Create subscription
    public function create()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('paket', 'Paket', 'required|in_list[basic,pro,enterprise]');
            $this->form_validation->set_rules('tgl_aktif', 'Tanggal Aktif', 'required|valid_date[Y-m-d]');
            $this->form_validation->set_rules('tgl_expired', 'Tanggal Kadaluarsa', 'required|valid_date[Y-m-d]');

            if ($this->form_validation->run() === TRUE) {
                $id_user = $this->session->userdata('id_user');
                $data = [
                    'id_user' => $id_user,
                    'paket' => $this->input->post('paket'),
                    'status' => 'active',
                    'tgl_aktif' => $this->input->post('tgl_aktif'),
                    'tgl_expired' => $this->input->post('tgl_expired'),
                ];
                $this->db->insert('subscription', $data);
                redirect('subscription');
                return;
            }
        }

        $this->load->view('subscription/form');
    }

    // Edit subscription
    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $sub = $this->db->get_where('subscription', ['id_subs' => $id, 'id_user' => $id_user])->row();
        if (!$sub) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('paket', 'Paket', 'required|in_list[basic,pro,enterprise]');
            $this->form_validation->set_rules('status', 'Status', 'required|in_list[active,inactive,expired]');
            $this->form_validation->set_rules('tgl_aktif', 'Tanggal Aktif', 'required|valid_date[Y-m-d]');
            $this->form_validation->set_rules('tgl_expired', 'Tanggal Kadaluarsa', 'required|valid_date[Y-m-d]');

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'paket' => $this->input->post('paket'),
                    'status' => $this->input->post('status'),
                    'tgl_aktif' => $this->input->post('tgl_aktif'),
                    'tgl_expired' => $this->input->post('tgl_expired'),
                ];
                $this->db->where('id_subs', $id)->update('subscription', $update_data);
                redirect('subscription');
                return;
            }
        }

        $data['subscription'] = $sub;
        $this->load->view('subscription/form', $data);
    }

    // Delete subscription
    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $sub = $this->db->get_where('subscription', ['id_subs' => $id, 'id_user' => $id_user])->row();
        if (!$sub) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            $data['subscription'] = $sub;
            $this->load->view('subscription/delete', $data);
            return;
        }

        $this->db->where('id_subs', $id)->delete('subscription');
        redirect('subscription');
    }
}

