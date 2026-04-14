<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        $this->Auth_model->ensure_default_admin_account();
    }

    /**
     * Show login form
     */
    public function login()
    {
        if ($this->session->userdata('id_user')) {
            // Jika sudah login dan ada parameter redirect, arahkan kesana
            $redirect = $this->input->get('redirect');
            if ($redirect) {
                redirect($redirect);
            }
            $this->redirect_by_role($this->session->userdata('role'));
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === true) {
                $email    = $this->input->post('email');
                $password = $this->input->post('password');
                $user     = $this->Auth_model->login($email, $password);

                if ($user) {
                    $this->session->set_userdata([
                        'id_user' => $user->id_user,
                        'nama'    => $user->nama,
                        'email'   => $user->email,
                        'role'    => $user->role,
                        'usaha'   => $user->nama_usaha ?? 'Bisnis Anda',
                        'type'    => 'UMKM',
                    ]);

                    // Cek apakah ada parameter redirect
                    $redirect = $this->input->get('redirect') ?: $this->input->post('redirect');
                    if ($redirect) {
                        redirect($redirect);
                    }

                    $this->redirect_by_role($user->role);
                } else {
                    $data['error'] = 'Email atau password salah.';
                }
            }
        }

        // Pass redirect parameter ke view agar bisa di-post kembali
        $data['redirect'] = $this->input->get('redirect');
        $this->load->view('auth/login', isset($data) ? $data : []);
    }

    /**
     * Show register form
     */
    public function register()
    {
        if ($this->session->userdata('id_user')) {
            redirect('auth/dashboard');
        }

        if ($this->input->method() === 'post') {

            // ------------------------------
            // VALIDASI INPUT
            // ------------------------------
            $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[200]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[250]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            // FIX: Cocokkan dengan name="konfirmasi_password" di form HTML
            $this->form_validation->set_rules(
                'konfirmasi_password',
                'Konfirmasi Password',
                'required|matches[password]'
            );

            if ($this->form_validation->run() === true) {

                $email = $this->input->post('email');

                // jika email sudah terdaftar
                if ($this->Auth_model->email_exists($email)) {
                    $data['error'] = 'Email sudah terdaftar.';
                } else {

                    $nama       = $this->input->post('nama');
                    $password   = $this->input->post('password');
                    $nama_usaha = $this->input->post('nama_usaha');

                    // simpan user baru
                    $id = $this->Auth_model->register($nama, $email, $password, $nama_usaha);

                    // DEBUG (sementara, bisa dihapus nanti)
                    if (!$id) {
                        $data['error'] = 'Gagal insert ke database!';
                    } else {
                        // kalau berhasil
                        $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                        redirect('auth/login');
                    }
                }
            }
        }

        $this->load->view('auth/register', isset($data) ? $data : []);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    /**
     * Dashboard
     */
    public function dashboard()
    {
        if (! $this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        if ($this->session->userdata('role') === 'admin') {
            redirect('admin/dashboard');
        }

        // Dashboard tunggal: operasional
        $data['user'] = $this->session->userdata();

        // Load Dashboard Model untuk mendapatkan data
        $this->load->model('Dashboard_model');
        $id_user = $this->session->userdata('id_user');
        $periode = $this->input->get('periode') ?? 'hari';

        // Get summary data
        $data['summary'] = $this->Dashboard_model->getSummary($id_user, $periode);

        // Get recent transactions
        $data['transactions'] = $this->Dashboard_model->getTransactions($id_user, 10);

        // Convert transactions to correct format for view
        if (! empty($data['transactions'])) {
            foreach ($data['transactions'] as &$tx) {
                $tx['amount'] = $tx['jenis'] === 'pengeluaran' ? -$tx['nominal'] : $tx['nominal'];
                $tx['title']  = $tx['catatan'] ?? $tx['kategori'];
                $tx['type']   = ucfirst($tx['jenis']);
            }
        }

        $this->load->view('auth/dashboard_operasional', $data);
    }

    private function redirect_by_role($role)
    {
        if ($role === 'admin') {
            redirect('admin/dashboard');
        }

        redirect('auth/dashboard');
    }

    /**
     * Halaman pengisian informasi bisnis
     */
    public function bisnis_info()
    {
        if (! $this->session->userdata('id_user')) {
            redirect('auth/login');
        }
        $this->load->view('auth/bisnis_info');
    }

    /**
     * Halaman rekomendasi informasi bisnis
     */
    public function info_bisnis()
    {
        if (! $this->session->userdata('id_user')) {
            redirect('auth/login');
        }
        $data['user'] = $this->session->userdata();
        // Route legacy auth/info_bisnis sengaja diarahkan ke view info baru agar konsisten.
        $this->load->view('info/index', $data);
    }

}
