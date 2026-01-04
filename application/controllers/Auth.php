<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
    }

    /**
     * Show login form
     */
    public function login()
    {
        if ($this->session->userdata('id_user')) {
            redirect('auth/dashboard');
        }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user = $this->Auth_model->login($email, $password);

                if ($user) {
                    // Hapus dashboard_type lama agar user bisa pilih ulang
                    $this->session->unset_userdata('dashboard_type');
                    $this->session->set_userdata([
                        'id_user' => $user->id_user,
                        'nama' => $user->nama,
                        'email' => $user->email,
                        'role' => $user->role
                    ]);
                    redirect('auth/dashboard_selection');
                } else {
                    $data['error'] = 'Email atau password salah.';
                }
            }
        }

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

            if ($this->form_validation->run() === TRUE) {

                $email = $this->input->post('email');

                // jika email sudah terdaftar
                if ($this->Auth_model->email_exists($email)) {
                    $data['error'] = 'Email sudah terdaftar.';
                } else {

                    $nama = $this->input->post('nama');
                    $password = $this->input->post('password');
                    $nama_usaha = $this->input->post('nama_usaha');

                    // simpan user baru
                    $id = $this->Auth_model->register($nama, $email, $password, $nama_usaha);

                    if ($id) {
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
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        // Cek apakah user sudah memilih tipe dashboard
        $dashboard_type = $this->session->userdata('dashboard_type');
        
        if (!$dashboard_type) {
            // Jika belum memilih, tampilkan halaman pemilihan
            $data['user'] = $this->session->userdata();
            $this->load->view('auth/dashboard_selection', $data);
            return;
        }

        // Load dashboard sesuai tipe
        $data['user'] = $this->session->userdata();
        
        if ($dashboard_type === 'planning') {
            $this->load->view('auth/dashboard_planning', $data);
        } else {
            $this->load->view('auth/dashboard_operasional', $data);
        }
    }

    /**
     * Set Dashboard Type
     */
    public function set_dashboard_type($type = 'operational')
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        // Validasi tipe dashboard
        if (!in_array($type, ['planning', 'operational'])) {
            $type = 'operational';
        }

        // Set session
        $this->session->set_userdata('dashboard_type', $type);

        // Redirect ke dashboard
        redirect('auth/dashboard');
    }

    /**
     * Change Dashboard Type (untuk switch antar dashboard)
     */
    public function change_dashboard()
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        // Hapus session dashboard_type agar user bisa pilih ulang
        $this->session->unset_userdata('dashboard_type');
        redirect('auth/dashboard');
    }
}
