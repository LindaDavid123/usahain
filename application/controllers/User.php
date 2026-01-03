<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    // List users (HTML)
    public function index()
    {
        $data['users'] = $this->User_model->get();
        $this->load->view('user/index', $data);
    }

    // User dashboard (visual summary)
    public function dashboard()
{
    if (!$this->session->userdata('id_user')) {
        redirect('auth/login');
    }

    // ambil data user dari session
    $data['user'] = [
        'nama'  => $this->session->userdata('nama'),
        'email' => $this->session->userdata('email'),
        'role'  => $this->session->userdata('role'),
        'usaha' => $this->session->userdata('nama_usaha') ?? 'Bisnis Anda',
        'type'  => 'UMKM'
    ];

    // dummy data (nanti bisa dari DB)
    $data['summary'] = [
        'today_sales'   => 150000,
        'today_expense' => 75000,
        'today_profit'  => 75000
    ];

    $data['transactions'] = [
        [
            'title' => 'Penjualan 10 porsi',
            'time'  => 'Hari ini',
            'amount'=> 150000
        ],
        [
            'title' => 'Beli bahan baku',
            'time'  => 'Hari ini',
            'amount'=> -75000
        ]
    ];

    $this->load->view('user/dashboard', $data);
}


    // Show single user (HTML)
    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $data['user'] = $this->User_model->get($id);
        if (!$data['user']) { show_404(); return; }
        $this->load->view('user/view', $data);
    }

    // Create user (form GET, submit POST)
    public function create()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[200]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[250]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'nama' => $this->input->post('nama'),
                    'role' => $this->input->post('role') ?: 'user',
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'nama_usaha' => $this->input->post('nama_usaha'),
                ];
                $this->User_model->insert($data);
                redirect('user');
                return;
            }
        }

        $this->load->view('user/form');
    }

    // Edit user (form GET, submit POST)
    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $user = $this->User_model->get($id);
        if (!$user) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[200]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[250]');
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');

            if ($this->form_validation->run() === TRUE) {
                $data = [
                    'nama' => $this->input->post('nama'),
                    'role' => $this->input->post('role'),
                    'email' => $this->input->post('email'),
                    'nama_usaha' => $this->input->post('nama_usaha'),
                ];
                $pwd = $this->input->post('password');
                if ($pwd) {
                    $data['password'] = password_hash($pwd, PASSWORD_BCRYPT);
                }
                $this->User_model->update($id, $data);
                redirect('user');
                return;
            }
        }

        $data['user'] = $user;
        $this->load->view('user/form', $data);
    }

    // Delete user (show confirmation on GET, delete on POST)
    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        if ($this->input->method() !== 'post') {
            $data['user'] = $this->User_model->get($id);
            if (!$data['user']) { show_404(); return; }
            $this->load->view('user/delete', $data);
            return;
        }
        $this->User_model->delete($id);
        redirect('user');
    }
}

