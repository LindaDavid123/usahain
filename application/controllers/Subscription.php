<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends CI_Controller
{

    // Midtrans Snap token generator for AJAX
    public function get_snap_token()
    {
        // Clear any output buffering to prevent BOM issues
        if (ob_get_level()) {
            ob_clean();
        }

        header('Content-Type: application/json');
        $json  = json_decode(file_get_contents('php://input'), true);
        $paket = isset($json['paket']) ? $json['paket'] : null;
        if (! $paket) {
            echo json_encode(['error' => 'Paket tidak valid']);
            return;
        }

        // Paket & harga (hardcoded, sesuaikan dengan kebutuhan)
        $paketList = [
            'essential' => 18000,
            'growth'    => 45000,
            'elite'     => 85000,
        ];
        if (! isset($paketList[$paket])) {
            echo json_encode(['error' => 'Paket tidak ditemukan']);
            return;
        }
        $harga = $paketList[$paket];

        // Midtrans config
        $this->config->load('midtrans');
        require_once APPPATH . 'third_party/Midtrans.php';
        \Midtrans\Config::$serverKey    = $this->config->item('midtrans_server_key');
        \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');
        \Midtrans\Config::$isSanitized  = $this->config->item('midtrans_is_sanitized');
        \Midtrans\Config::$is3ds        = $this->config->item('midtrans_is_3ds');

        $user_id  = $this->session->userdata('id_user') ?: 'guest';
        $order_id = 'SUBS-' . $user_id . '-' . time();

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $harga,
            ],
            'item_details'        => [[
                'id'       => $paket,
                'price'    => $harga,
                'quantity' => 1,
                'name'     => ucfirst($paket) . ' Subscription',
            ]],
            'customer_details'    => [
                'first_name' => $this->session->userdata('nama') ?: 'User',
                'email'      => $this->session->userdata('email') ?: 'user@example.com',
            ],
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
        $this->config->load('midtrans');
        $data['midtrans_client_key'] = $this->config->item('midtrans_client_key');
        $this->load->view('subscription/pricing', $data);
    }

    public function __construct()
    {
        parent::__construct();
        // Allow public access (no login required)
        $this->load->model('Subscription_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // List subscription (hanya milik user yang login)
    public function index()
    {
        $id_user               = $this->session->userdata('id_user');
        $data['subscriptions'] = $this->db->get_where('subscription', ['id_user' => $id_user])->result();
        $this->load->view('subscription/index', $data);
    }

    // View single subscription
    public function view($id = null)
    {
        if (! $id) {show_404();return;}
        $id_user = $this->session->userdata('id_user');
        $sub     = $this->db->get_where('subscription', ['id_subs' => $id, 'id_user' => $id_user])->row();
        if (! $sub) {show_404();return;}

        $data['subscription'] = $sub;
        $this->load->view('subscription/view', $data);
    }

    // Create subscription - DISABLED for payment system
    public function create()
    {
        // Redirect to pricing page instead
        $this->session->set_flashdata('info', 'Silakan pilih paket langganan melalui sistem pembayaran.');
        redirect('subscription/pricing');
    }

    // Edit subscription - DISABLED for payment system
    public function edit($id = null)
    {
        // Not allowed to edit paid subscriptions
        $this->session->set_flashdata('error', 'Langganan berbayar tidak dapat diedit secara manual.');
        redirect('subscription');
    }

    // Delete subscription - DISABLED for payment system
    public function delete($id = null)
    {
        // Not allowed to delete paid subscriptions
        $this->session->set_flashdata('error', 'Langganan berbayar tidak dapat dihapus. Silakan tunggu hingga masa aktif berakhir atau hubungi admin.');
        redirect('subscription');
    }

    // Handle payment success from frontend
    public function payment_success()
    {
        header('Content-Type: application/json');

        if (ob_get_level()) {
            ob_clean();
        }

        $json = json_decode(file_get_contents('php://input'), true);

        if (! $json || ! isset($json['order_id'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $id_user = $this->session->userdata('id_user');
        if (! $id_user) {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            return;
        }

        // Extract paket from order_id (format: SUBS-{user_id}-{timestamp})
        $order_parts = explode('-', $json['order_id']);

        // Determine paket from order_id or result
        $paket = isset($json['paket']) ? $json['paket'] : 'essential';

        // Calculate dates
        $tgl_aktif   = date('Y-m-d');
        $tgl_expired = date('Y-m-d', strtotime('+30 days'));

        // Insert subscription to database
        $data = [
            'id_user'     => $id_user,
            'paket'       => $paket,
            'status'      => 'active',
            'tgl_aktif'   => $tgl_aktif,
            'tgl_expired' => $tgl_expired,
        ];

        $this->db->insert('subscription', $data);

        echo json_encode(['success' => true, 'message' => 'Subscription activated']);
    }

    // Midtrans callback/notification handler
    public function notification()
    {
        // Load Midtrans
        $this->config->load('midtrans');
        require_once APPPATH . 'third_party/Midtrans.php';

        \Midtrans\Config::$serverKey    = $this->config->item('midtrans_server_key');
        \Midtrans\Config::$isProduction = $this->config->item('midtrans_is_production');

        try {
            $notification = new \Midtrans\Notification();

            $transaction_status = $notification->transaction_status;
            $order_id           = $notification->order_id;
            $fraud_status       = isset($notification->fraud_status) ? $notification->fraud_status : '';

            // Extract user_id from order_id
            $order_parts = explode('-', $order_id);
            $user_id     = isset($order_parts[1]) ? $order_parts[1] : null;

            if (! $user_id) {
                log_message('error', 'Invalid order_id format: ' . $order_id);
                return;
            }

            // Handle based on transaction status
            if ($transaction_status == 'capture') {
                if ($fraud_status == 'accept') {
                    $this->_activate_subscription($user_id, $order_id);
                }
            } elseif ($transaction_status == 'settlement') {
                $this->_activate_subscription($user_id, $order_id);
            } elseif ($transaction_status == 'cancel' || $transaction_status == 'deny' || $transaction_status == 'expire') {
                // Update to inactive/cancelled
                $this->db->where('id_user', $user_id)
                    ->where('status', 'pending')
                    ->update('subscription', ['status' => 'cancelled']);
            }

            log_message('info', 'Midtrans notification handled: ' . $order_id . ' - ' . $transaction_status);

        } catch (Exception $e) {
            log_message('error', 'Midtrans notification error: ' . $e->getMessage());
        }
    }

    // Private method to activate subscription
    private function _activate_subscription($user_id, $order_id)
    {
                              // Extract paket info if stored, or default
        $paket = 'essential'; // Default, could be parsed from order details

        $tgl_aktif   = date('Y-m-d');
        $tgl_expired = date('Y-m-d', strtotime('+30 days'));

        $data = [
            'id_user'     => $user_id,
            'paket'       => $paket,
            'status'      => 'active',
            'tgl_aktif'   => $tgl_aktif,
            'tgl_expired' => $tgl_expired,
        ];

        // Check if already exists
        $existing = $this->db->get_where('subscription', [
            'id_user' => $user_id,
            'paket'   => $paket,
            'status'  => 'active',
        ])->row();

        if (! $existing) {
            $this->db->insert('subscription', $data);
        }
    }
}
