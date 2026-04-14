<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    protected $table = 'user';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Register user baru
     */
    public function register($nama, $email, $password, $nama_usaha = null)
    {
        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'nama_usaha' => $nama_usaha,
            'jenis_usaha' => 'Umum',
            'role' => 'user',
            'oauth_provider' => 'local'
        ];
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Login user dengan email dan password
     */
    public function login($email, $password)
    {
        $user = $this->db->get_where($this->table, ['email' => $email])->row();
        
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    /**
     * Cek apakah email sudah terdaftar
     */
    public function email_exists($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->num_rows() > 0;
    }

    /**
     * Get user by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_user' => $id])->row();
    }

    /**
     * Get user by Google ID
     */
    public function get_user_by_google_id($google_id)
    {
        return $this->db->get_where($this->table, ['google_id' => $google_id])->row();
    }

    /**
     * Get user by email
     */
    public function get_user_by_email($email)
    {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    /**
     * Get user by ID (alias for OAuth usage)
     */
    public function get_user_by_id($id)
    {
        return $this->get_by_id($id);
    }

    /**
     * Create new user (for OAuth)
     */
    public function create_user($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update user data
     */
    public function update_user($id, $data)
    {
        return $this->db->where('id_user', $id)->update($this->table, $data);
    }

    /**
     * Ensure default admin account exists and is usable.
     */
    public function ensure_default_admin_account()
    {
        $email = 'admin@usahain.com';
        $now = date('Y-m-d H:i:s');
        $passwordHash = password_hash('Admin@2025', PASSWORD_BCRYPT);

        $existing = $this->db->get_where($this->table, ['email' => $email])->row_array();

        if ($existing) {
            $update = [
                'role' => 'admin',
                'oauth_provider' => 'local',
                'password' => $passwordHash,
            ];

            if (empty($existing['nama'])) {
                $update['nama'] = 'Administrator';
            }
            if (empty($existing['nama_usaha'])) {
                $update['nama_usaha'] = 'Usahain Admin';
            }
            if (empty($existing['jenis_usaha'])) {
                $update['jenis_usaha'] = 'Sistem';
            }

            $this->db->where('id_user', (int) $existing['id_user'])->update($this->table, $update);
            $adminUserId = (int) $existing['id_user'];
        } else {
            $insert = [
                'nama' => 'Administrator',
                'email' => $email,
                'password' => $passwordHash,
                'nama_usaha' => 'Usahain Admin',
                'jenis_usaha' => 'Sistem',
                'role' => 'admin',
                'oauth_provider' => 'local',
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $this->db->insert($this->table, $insert);
            $adminUserId = (int) $this->db->insert_id();
        }

        if ($adminUserId > 0 && $this->db->table_exists('admin_management')) {
            $adminRecord = $this->db->get_where('admin_management', ['id_user' => $adminUserId])->row_array();

            if (! $adminRecord) {
                $permissions = [
                    'manage_users' => true,
                    'manage_content' => true,
                    'manage_reports' => true,
                    'manage_subscriptions' => true,
                    'export_data' => true,
                ];

                $this->db->insert('admin_management', [
                    'id_user' => $adminUserId,
                    'admin_level' => 'admin',
                    'permissions' => json_encode($permissions),
                    'status' => 'active',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        return $adminUserId;
    }
}

