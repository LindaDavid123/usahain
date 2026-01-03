<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription extends CI_Controller {

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

