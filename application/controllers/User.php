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

        // Legacy endpoint: route create diarahkan ke halaman registrasi aktif.
        redirect('auth/register');
    }

    // Edit profile user (dedicated page)
    public function edit($id = null)
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id = $id ?: $this->session->userdata('id_user');

        $user = $this->User_model->get($id);
        if (!$user) { show_404(); return; }

        $data['user'] = $user;
        $data['success'] = $this->session->flashdata('success_message');
        $data['errors'] = $this->session->flashdata('error_messages') ?: [];

        $this->load->view('user/edit_profile', $data);
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

    /**
     * Simpan informasi bisnis dari form perencanaan (AJAX)
     * Endpoint: POST /user/save_bisnis_info
     * IMPORTANT: Must return ONLY JSON, no HTML or other output
     */
    public function save_bisnis_info()
    {
        // Disable output buffering - return JSON ONLY
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        // ===== CRITICAL: Set JSON header FIRST =====
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // ===== STEP 1: CHECK SESSION =====
        if (!$this->session->userdata('id_user')) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'code' => 'UNAUTHORIZED',
                'message' => 'Anda harus login terlebih dahulu'
            ]);
            exit;
        }
        
        $id_user = $this->session->userdata('id_user');
        
        // ===== STEP 2: GET INPUT (JSON or Form) =====
        $input = [];
        $content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : '';
        
        if (strpos($content_type, 'application/json') !== false) {
            // JSON input (from fetch/AJAX)
            $input = json_decode(file_get_contents('php://input'), true) ?: [];
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Form data (fallback)
            $input = $_POST;
        }
        
        // ===== STEP 3: EXTRACT & TRIM DATA =====
        $nama_usaha = isset($input['nama_usaha']) ? trim($input['nama_usaha']) : '';
        $jenis_usaha = isset($input['jenis_usaha']) ? trim($input['jenis_usaha']) : '';
        
        // ===== STEP 4: VALIDATION =====
        $errors = [];
        
        // Check if at least one field is provided
        if (empty($nama_usaha) && empty($jenis_usaha)) {
            $errors[] = 'Minimal salah satu field harus diisi';
        }
        
        // Validate nama_usaha
        if (!empty($nama_usaha)) {
            if (strlen($nama_usaha) < 3) {
                $errors[] = 'Nama usaha minimal 3 karakter';
            }
            if (strlen($nama_usaha) > 100) {
                $errors[] = 'Nama usaha maksimal 100 karakter';
            }
        }
        
        // Validate jenis_usaha
        if (!empty($jenis_usaha)) {
            if (strlen($jenis_usaha) < 3) {
                $errors[] = 'Jenis usaha minimal 3 karakter';
            }
            if (strlen($jenis_usaha) > 100) {
                $errors[] = 'Jenis usaha maksimal 100 karakter';
            }
        }
        
        // Return validation errors
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'code' => 'VALIDATION_ERROR',
                'message' => implode(', ', $errors)
            ]);
            exit;
        }
        
        // ===== STEP 5: UPDATE DATABASE (Using CodeIgniter Query Builder) =====
        try {
            $updated_at = date('Y-m-d H:i:s');
            
            // Prepare update data
            $update_data = [];
            
            if (!empty($nama_usaha)) {
                $update_data['nama_usaha'] = $nama_usaha;
            }
            
            if (!empty($jenis_usaha)) {
                $update_data['jenis_usaha'] = $jenis_usaha;
            }
            
            // Always update timestamp
            $update_data['updated_at'] = $updated_at;
            
            // Update using CodeIgniter Query Builder
            $this->db->where('id_user', $id_user);
            $update_result = $this->db->update('user', $update_data);
            
            if (!$update_result) {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'code' => 'UPDATE_ERROR',
                    'message' => 'Gagal mengupdate database',
                    'debug' => $this->db->error()
                ]);
                exit;
            }
            
            // ===== STEP 6: VERIFY DATA =====
            $user = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
            
            if (!$user) {
                http_response_code(500);
                echo json_encode([
                    'status' => 'error',
                    'code' => 'VERIFY_ERROR',
                    'message' => 'Data gagal tersimpan atau user tidak ditemukan'
                ]);
                exit;
            }
            
            // ===== STEP 7: UPDATE SESSION =====
            if (!empty($nama_usaha)) {
                $this->session->set_userdata('nama_usaha', $nama_usaha);
            }
            if (!empty($jenis_usaha)) {
                $this->session->set_userdata('jenis_usaha', $jenis_usaha);
            }
            $this->session->set_userdata('updated_at', $updated_at);
            
            // ===== STEP 8: SUCCESS RESPONSE =====
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'code' => 'OK',
                'message' => 'Data berhasil disimpan',
                'data' => [
                    'id_user' => $id_user,
                    'nama_usaha' => $user['nama_usaha'] ?? '',
                    'jenis_usaha' => $user['jenis_usaha'] ?? '',
                    'updated_at' => $updated_at
                ]
            ]);
            exit;
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'code' => 'EXCEPTION',
                'message' => 'Terjadi kesalahan server',
                'debug' => $e->getMessage()
            ]);
            exit;
        }
    }

    /**
     * Halaman Profile Pengguna
     */
    public function profile($id = null)
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id = $id ?: $this->session->userdata('id_user');
        $user = $this->User_model->get($id);
        
        if (!$user) {
            show_404();
            return;
        }

        $data['user'] = $user;
        
        // Get activity data
        $this->load->model('Al_advisor_model');
        $data['advisor_count'] = $this->db->where('id_user', $id)->count_all_results('al_advisor');
        $data['transaksi_count'] = $this->db->where('id_user', $id)->count_all_results('pencatatan_keuangan');
        $data['analisis_count'] = $this->db->where('id_user', $id)->count_all_results('analisis_produk');
        
        // Get recent activities
        $activities = [];
        if ($data['advisor_count'] > 0) {
            $activities[] = [
                'title' => 'Konsultasi AI Advisor',
                'description' => 'Anda telah melakukan ' . $data['advisor_count'] . ' kali konsultasi dengan AI Advisor',
                'date' => date('Y-m-d H:i:s')
            ];
        }
        
        $data['activities'] = $activities;

        $this->load->view('user/profile', $data);
    }

    /**
     * Halaman Settings/Pengaturan
     */
    public function settings()
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id_user = $this->session->userdata('id_user');
        $user = $this->User_model->get($id_user);
        
        if (!$user) {
            show_404();
            return;
        }

        $data['user'] = $user;
        $data['success'] = $this->session->flashdata('success_message');
        $data['errors'] = $this->session->flashdata('error_messages') ?: [];

        $this->load->view('user/settings', $data);
    }

    /**
     * Update Profile User
     */
    public function update_profile($id = null)
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id = $id ?: $this->session->userdata('id_user');
        
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|max_length[200]');
            $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'max_length[255]');
            $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'max_length[100]');
            if ($this->has_advisor_profile_columns()) {
                $this->form_validation->set_rules('advisor_modal', 'Modal Bisnis', 'trim|numeric');
                $this->form_validation->set_rules('advisor_minat', 'Minat Bisnis', 'trim|max_length[100]');
                $this->form_validation->set_rules('advisor_lokasi', 'Lokasi Bisnis', 'trim|max_length[100]');
                $this->form_validation->set_rules('advisor_tujuan', 'Tujuan Bisnis', 'trim|max_length[150]');
            }

            if ($this->form_validation->run() === TRUE) {
                $update_data = [
                    'nama' => $this->input->post('nama'),
                    'nama_usaha' => $this->input->post('nama_usaha') ?: null,
                    'jenis_usaha' => $this->input->post('jenis_usaha') ?: null,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->has_advisor_profile_columns()) {
                    $advisor_modal = trim((string) $this->input->post('advisor_modal'));
                    $update_data['advisor_modal'] = $advisor_modal !== '' ? (float) $advisor_modal : null;
                    $update_data['advisor_minat'] = trim((string) $this->input->post('advisor_minat')) ?: null;
                    $update_data['advisor_lokasi'] = trim((string) $this->input->post('advisor_lokasi')) ?: null;
                    $update_data['advisor_tujuan'] = trim((string) $this->input->post('advisor_tujuan')) ?: null;
                }

                if ($this->User_model->update($id, $update_data)) {
                    // Update session
                    $this->session->set_userdata('nama', $this->input->post('nama'));
                    $this->session->set_userdata('nama_usaha', $this->input->post('nama_usaha'));
                    
                    $this->session->set_flashdata('success_message', 'Profil berhasil diperbarui!');
                    redirect('user/edit/' . $id);
                } else {
                    $this->session->set_flashdata('error_messages', ['Gagal memperbarui profil']);
                    redirect('user/edit/' . $id);
                }
            } else {
                $this->session->set_flashdata('error_messages', $this->form_validation->error_array());
                redirect('user/edit/' . $id);
            }
        }

        redirect('user/edit/' . $id);
    }

    public function update_business_profile()
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id_user = $this->session->userdata('id_user');
        $redirect_url = 'user/profile/' . $id_user . '?tab=settings#data-bisnis-section';

        if (!$this->has_advisor_profile_columns()) {
            $this->session->set_flashdata('error', 'Kolom data bisnis advisor belum tersedia di database.');
            redirect($redirect_url);
            return;
        }

        if ($this->input->method() !== 'post') {
            redirect($redirect_url);
            return;
        }

        $this->form_validation->set_rules('advisor_modal', 'Modal', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('advisor_minat', 'Minat', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('advisor_lokasi', 'Lokasi', 'required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('advisor_tujuan', 'Tujuan', 'required|min_length[2]|max_length[150]');

        if ($this->form_validation->run() !== TRUE) {
            $errors = $this->form_validation->error_array();
            $first_error = reset($errors);
            $this->session->set_flashdata('error', $first_error ?: 'Validasi data bisnis gagal.');
            redirect($redirect_url);
            return;
        }

        $update_data = [
            'advisor_modal' => (float) $this->input->post('advisor_modal'),
            'advisor_minat' => trim((string) $this->input->post('advisor_minat')),
            'advisor_lokasi' => trim((string) $this->input->post('advisor_lokasi')),
            'advisor_tujuan' => trim((string) $this->input->post('advisor_tujuan')),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->User_model->update($id_user, $update_data)) {
            $this->session->set_flashdata('success', 'Data bisnis untuk AI Advisor berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data bisnis AI Advisor.');
        }

        redirect($redirect_url);
    }

    private function has_advisor_profile_columns()
    {
        return $this->db->field_exists('advisor_modal', 'user')
            && $this->db->field_exists('advisor_minat', 'user')
            && $this->db->field_exists('advisor_lokasi', 'user')
            && $this->db->field_exists('advisor_tujuan', 'user');
    }

    /**
     * Ubah Password User
     */
    public function change_password()
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        if ($this->input->method() === 'post') {
            $id_user = $this->session->userdata('id_user');
            $user = $this->User_model->get($id_user);

            $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|min_length[6]');
            $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|min_length[6]');
            $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password_baru]');

            if ($this->form_validation->run() === TRUE) {
                $password_lama = $this->input->post('password_lama');
                $password_baru = $this->input->post('password_baru');

                // Verify old password
                if (password_verify($password_lama, $user->password)) {
                    $update_data = [
                        'password' => password_hash($password_baru, PASSWORD_BCRYPT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    if ($this->User_model->update($id_user, $update_data)) {
                        $this->session->set_flashdata('success_message', 'Password berhasil diubah!');
                        redirect('user/settings');
                    } else {
                        $this->session->set_flashdata('error_messages', ['Gagal mengubah password']);
                        redirect('user/settings');
                    }
                } else {
                    $this->session->set_flashdata('error_messages', ['Password lama tidak sesuai']);
                    redirect('user/settings');
                }
            } else {
                $this->session->set_flashdata('error_messages', $this->form_validation->error_array());
                redirect('user/settings');
            }
        }

        redirect('user/settings');
    }

    /**
     * Hapus Akun User
     */
    public function delete_account($id = null)
    {
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }

        $id = $id ?: $this->session->userdata('id_user');

        if ($this->input->method() === 'post') {
            if ($this->User_model->delete($id)) {
                $this->session->sess_destroy();
                $this->session->set_flashdata('success', 'Akun berhasil dihapus.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus akun');
                redirect('user/settings');
            }
        }

        redirect('user/settings');
    }
}

