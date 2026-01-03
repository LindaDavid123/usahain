<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hpp extends CI_Controller {

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
        $data['hpp_list'] = $this->db->get_where('kalkulator_hpp', ['id_user' => $id_user])->result();
        $this->load->view('hpp/index', $data);
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
            $this->form_validation->set_rules('bahan', 'Biaya Bahan', 'required|numeric');
            $this->form_validation->set_rules('tenaga_kerja', 'Biaya Tenaga Kerja', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $id_user = $this->session->userdata('id_user');
                $bahan = $this->input->post('bahan');
                $tenaga_kerja = $this->input->post('tenaga_kerja');
                $total_biaya = $bahan + $tenaga_kerja;
                $harga_jual = $this->input->post('harga_jual');

                $data = [
                    'id_user' => $id_user,
                    'bahan' => $bahan,
                    'tenaga_kerja' => $tenaga_kerja,
                    'total_biaya' => $total_biaya,
                    'harga_jual' => $harga_jual,
                ];
                $this->db->insert('kalkulator_hpp', $data);
                redirect('hpp');
                return;
            }
        }
        $this->load->view('hpp/form');
    }

    public function edit($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $hpp = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $id_user])->row();
        if (!$hpp) { show_404(); return; }

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('bahan', 'Biaya Bahan', 'required|numeric');
            $this->form_validation->set_rules('tenaga_kerja', 'Biaya Tenaga Kerja', 'required|numeric');
            $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');

            if ($this->form_validation->run() === TRUE) {
                $bahan = $this->input->post('bahan');
                $tenaga_kerja = $this->input->post('tenaga_kerja');
                $total_biaya = $bahan + $tenaga_kerja;

                $update_data = [
                    'bahan' => $bahan,
                    'tenaga_kerja' => $tenaga_kerja,
                    'total_biaya' => $total_biaya,
                    'harga_jual' => $this->input->post('harga_jual'),
                ];
                $this->db->where('id_hpp', $id)->update('kalkulator_hpp', $update_data);
                redirect('hpp');
                return;
            }
        }

        $data['hpp'] = $hpp;
        $this->load->view('hpp/form', $data);
    }

    public function delete($id = null)
    {
        if (!$id) { show_404(); return; }
        $id_user = $this->session->userdata('id_user');
        $hpp = $this->db->get_where('kalkulator_hpp', ['id_hpp' => $id, 'id_user' => $id_user])->row();
        if (!$hpp) { show_404(); return; }

        if ($this->input->method() !== 'post') {
            $data['hpp'] = $hpp;
            $this->load->view('hpp/delete', $data);
            return;
        }

        $this->db->where('id_hpp', $id)->delete('kalkulator_hpp');
        redirect('hpp');
    }
}

