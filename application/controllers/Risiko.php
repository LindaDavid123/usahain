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
        ];

        $this->load->view('risiko/index', $data);
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
}

