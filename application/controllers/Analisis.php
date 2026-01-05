xx<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analisis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow public access (no login required)
        $this->load->model('Analisis_produk_model');
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    // List analisis produk (hanya milik user yang login)
    public function index()
    {
        $id_user = $this->session->userdata('id_user');
        $data['produk_list'] = $this->db->get_where('analisis_produk', ['id_user' => $id_user])->result();
        $this->load->view('analisis/index', $data);
    }

    // View single analisis
    public function view($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $produk = $this->db->get_where('analisis_produk', ['id_produk' => $id, 'id_user' => $id_user])->row();
        if (!$produk) { show_404(); return; }
        
        $data['produk'] = $produk;
        $this->load->view('analisis/view', $data);
    }

    // Create analisis
    public function create()
    {
        $success_message = null;
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|max_length[250]');
            $this->form_validation->set_rules('analisis', 'Analisis', 'required');
            $this->form_validation->set_rules('penjualan', 'Penjualan', 'required|numeric');
            $this->form_validation->set_rules('biaya_produksi', 'Biaya Produksi', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $id_user = $this->session->userdata('id_user');
                $data = [
                    'id_user' => $id_user,
                    'nama_produk' => $this->input->post('nama_produk'),
                    'analisis' => $this->input->post('analisis'),
                    'penjualan' => $this->input->post('penjualan'),
                    'biaya_produksi' => $this->input->post('biaya_produksi'),
                ];
                $this->db->insert('analisis_produk', $data);
                $success_message = 'Data analisis produk berhasil disimpan!';
                // Kosongkan value form setelah sukses
                $_POST = [];
            }
        }

        $this->load->view('analisis/form', isset($success_message) ? ['success_message' => $success_message] : []);
    }

    // Edit analisis
    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $produk = $this->db->get_where('analisis_produk', ['id_produk' => $id, 'id_user' => $id_user])->row();
        if (!$produk) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|max_length[250]');
            $this->form_validation->set_rules('analisis', 'Analisis', 'required');
            $this->form_validation->set_rules('penjualan', 'Penjualan', 'required|numeric');
            $this->form_validation->set_rules('biaya_produksi', 'Biaya Produksi', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'nama_produk' => $this->input->post('nama_produk'),
                    'analisis' => $this->input->post('analisis'),
                    'penjualan' => $this->input->post('penjualan'),
                    'biaya_produksi' => $this->input->post('biaya_produksi'),
                ];
                $this->db->where('id_produk', $id)->update('analisis_produk', $update_data);
                redirect('analisis');
                return;
            }
        }

        $data['produk'] = $produk;
        $this->load->view('analisis/form', $data);
    }

    // Delete analisis
    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $produk = $this->db->get_where('analisis_produk', ['id_produk' => $id, 'id_user' => $id_user])->row();
        if (!$produk) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            $data['produk'] = $produk;
            $this->load->view('analisis/delete', $data);
            return;
        }

        $this->db->where('id_produk', $id)->delete('analisis_produk');
        redirect('analisis');
    }
}

