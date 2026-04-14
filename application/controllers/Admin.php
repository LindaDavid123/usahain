<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
        $this->load->model('Auth_model');

        $this->Auth_model->ensure_default_admin_account();

        if (! $this->session->userdata('id_user')) {
            redirect('auth/login?redirect=' . rawurlencode(site_url('admin/dashboard')));
        }

        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth/dashboard');
        }
    }

    public function dashboard()
    {
        $data['admin_user'] = $this->get_admin_user();

        $data['stats'] = $this->get_dashboard_stats();
        $data['latest_users'] = $this->get_latest_users(5);
        $data['recent_activities'] = $this->get_recent_activities(10);

        $this->load->view('admin/dashboard', $data);
    }

    public function users()
    {
        $this->ensure_user_status_table();

        $q = trim((string) $this->input->get('q'));
        $page = max(1, (int) $this->input->get('page'));
        $per_page = 10;

        $total_rows = $this->count_users_for_admin($q);
        $total_pages = max(1, (int) ceil($total_rows / $per_page));
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $per_page;

        $query_params = [
            'q' => $q,
            'page' => $page,
        ];
        $return_url = $this->build_page_url('admin/users', $query_params);

        $data['admin_user'] = $this->get_admin_user();
        $data['filters'] = [
            'q' => $q,
        ];
        $data['users'] = $this->get_users_for_admin($q, $per_page, $offset);
        $data['return_url'] = $return_url;
        $data['pagination'] = $this->build_pagination_data('admin/users', ['q' => $q], $page, $per_page, $total_rows);

        $this->load->view('admin/users', $data);
    }

    public function user_detail($id_user = null)
    {
        $id_user = (int) $id_user;
        if ($id_user <= 0) {
            show_404();
            return;
        }

        $this->ensure_user_status_table();

        $return_url = $this->sanitize_return_url((string) $this->input->get('return'));
        if ($return_url === '') {
            $return_url = site_url('admin/users');
        }

        $user = $this->db->query(
            "SELECT
                u.id_user,
                u.nama,
                u.email,
                u.role,
                u.created_at,
                u.nama_usaha,
                u.jenis_usaha,
                COALESCE((
                    SELECT s.paket
                    FROM subscription s
                    WHERE s.id_user = u.id_user
                    ORDER BY COALESCE(s.transaction_time, s.tgl_aktif) DESC
                    LIMIT 1
                ), '-') AS paket
            FROM user u
            WHERE u.id_user = ?
            LIMIT 1",
            [$id_user]
        )->row_array();

        if (empty($user)) {
            show_404();
            return;
        }

        $status_map = $this->get_user_status_map([$id_user]);
        $is_active = isset($status_map[$id_user]) ? ((int) $status_map[$id_user] === 1) : true;

        $data['admin_user'] = $this->get_admin_user();
        $data['detail'] = $user;
        $data['detail']['is_active'] = $is_active;
        $data['detail']['status'] = $is_active ? 'Aktif' : 'Nonaktif';
        $data['back_url'] = $return_url;

        $this->load->view('admin/user_detail', $data);
    }

    public function create_user()
    {
        $return_url = $this->sanitize_return_url((string) $this->input->get('return'));
        if ($return_url === '') {
            $return_url = site_url('admin/users');
        }

        $data['admin_user'] = $this->get_admin_user();
        $data['back_url'] = $return_url;
        $data['form'] = [
            'nama' => '',
            'email' => '',
            'nama_usaha' => '',
            'jenis_usaha' => '',
            'password' => '',
        ];

        $this->load->view('admin/user_form', $data);
    }

    public function store_user()
    {
        if (strtolower((string) $this->input->method()) !== 'post') {
            show_404();
            return;
        }

        $this->ensure_user_status_table();

        $return_url = $this->sanitize_return_url((string) $this->input->post('return_url'));
        if ($return_url === '') {
            $return_url = site_url('admin/users');
        }

        $nama = trim((string) $this->input->post('nama'));
        $email = strtolower(trim((string) $this->input->post('email')));
        $nama_usaha = trim((string) $this->input->post('nama_usaha'));
        $jenis_usaha = trim((string) $this->input->post('jenis_usaha'));
        $password_input = (string) $this->input->post('password');

        if ($nama === '' || $email === '') {
            $this->session->set_flashdata('error', 'Nama dan email wajib diisi.');
            redirect('admin/create_user?return=' . rawurlencode($return_url));
            return;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Format email tidak valid.');
            redirect('admin/create_user?return=' . rawurlencode($return_url));
            return;
        }

        $existing = $this->db->query(
            "SELECT id_user FROM user WHERE LOWER(email) = ? LIMIT 1",
            [strtolower($email)]
        )->row_array();

        if (! empty($existing)) {
            $this->session->set_flashdata('error', 'Email sudah terdaftar. Gunakan email lain.');
            redirect('admin/create_user?return=' . rawurlencode($return_url));
            return;
        }

        $password_plain = trim($password_input) !== '' ? $password_input : 'User@12345';
        $now = date('Y-m-d H:i:s');

        $this->db->insert('user', [
            'nama' => $nama,
            'email' => $email,
            'password' => password_hash($password_plain, PASSWORD_BCRYPT),
            'nama_usaha' => $nama_usaha,
            'jenis_usaha' => $jenis_usaha,
            'role' => 'user',
            'oauth_provider' => 'local',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $new_id = (int) $this->db->insert_id();
        if ($new_id > 0) {
            $this->db->query(
                "INSERT INTO user_account_status (id_user, is_active, updated_at)
                 VALUES (?, 1, NOW())
                 ON DUPLICATE KEY UPDATE is_active = VALUES(is_active), updated_at = VALUES(updated_at)",
                [$new_id]
            );
        }

        $this->session->set_flashdata('success', 'Pengguna baru berhasil dibuat.');
        redirect('admin/user_detail/' . $new_id . '?return=' . rawurlencode($return_url));
    }

    public function update_user($id_user = null)
    {
        if (strtolower((string) $this->input->method()) !== 'post') {
            show_404();
            return;
        }

        $id_user = (int) $id_user;
        if ($id_user <= 0) {
            $this->session->set_flashdata('error', 'User tidak valid.');
            redirect('admin/users');
            return;
        }

        $return_url = $this->sanitize_return_url((string) $this->input->post('return_url'));
        if ($return_url === '') {
            $return_url = site_url('admin/users');
        }

        $target = $this->db->query(
            "SELECT id_user, role FROM user WHERE id_user = ? LIMIT 1",
            [$id_user]
        )->row_array();

        if (empty($target)) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('admin/users');
            return;
        }

        if ((string) ($target['role'] ?? '') === 'admin') {
            $this->session->set_flashdata('error', 'Akun admin tidak dapat diubah dari halaman ini.');
            redirect('admin/users');
            return;
        }

        $nama = trim((string) $this->input->post('nama'));
        $email = strtolower(trim((string) $this->input->post('email')));
        $nama_usaha = trim((string) $this->input->post('nama_usaha'));
        $jenis_usaha = trim((string) $this->input->post('jenis_usaha'));

        if ($nama === '' || $email === '') {
            $this->session->set_flashdata('error', 'Nama dan email wajib diisi.');
            redirect('admin/user_detail/' . $id_user . '?return=' . rawurlencode($return_url));
            return;
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->session->set_flashdata('error', 'Format email tidak valid.');
            redirect('admin/user_detail/' . $id_user . '?return=' . rawurlencode($return_url));
            return;
        }

        $existing = $this->db->query(
            "SELECT id_user FROM user WHERE LOWER(email) = ? AND id_user <> ? LIMIT 1",
            [strtolower($email), $id_user]
        )->row_array();

        if (! empty($existing)) {
            $this->session->set_flashdata('error', 'Email sudah dipakai pengguna lain.');
            redirect('admin/user_detail/' . $id_user . '?return=' . rawurlencode($return_url));
            return;
        }

        $this->db->where('id_user', $id_user)->update('user', [
            'nama' => $nama,
            'email' => $email,
            'nama_usaha' => $nama_usaha,
            'jenis_usaha' => $jenis_usaha,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui.');
        redirect('admin/user_detail/' . $id_user . '?return=' . rawurlencode($return_url));
    }

    public function delete_user($id_user = null)
    {
        if (strtolower((string) $this->input->method()) !== 'post') {
            show_404();
            return;
        }

        $id_user = (int) $id_user;
        if ($id_user <= 0) {
            $this->session->set_flashdata('error', 'User tidak valid.');
            redirect('admin/users');
            return;
        }

        $return_url = $this->sanitize_return_url((string) $this->input->post('return_url'));
        if ($return_url === '') {
            $return_url = site_url('admin/users');
        }

        $target = $this->db->query(
            "SELECT id_user, role FROM user WHERE id_user = ? LIMIT 1",
            [$id_user]
        )->row_array();

        if (empty($target)) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect($return_url);
            return;
        }

        if ((string) ($target['role'] ?? '') === 'admin') {
            $this->session->set_flashdata('error', 'Akun admin tidak dapat dihapus dari halaman ini.');
            redirect($return_url);
            return;
        }

        $this->db->trans_start();
        $this->db->where('id_user', $id_user)->delete('analisis_produk');
        $this->db->where('id_user', $id_user)->delete('pencatatan_keuangan');
        $this->db->where('id_user', $id_user)->delete('subscription');
        if ($this->db->table_exists('manajemen_risiko')) {
            $this->db->where('id_user', $id_user)->delete('manajemen_risiko');
        }
        if ($this->db->table_exists('kalkulator_hpp')) {
            $this->db->where('id_user', $id_user)->delete('kalkulator_hpp');
        }
        $this->db->where('id_user', $id_user)->delete('user_account_status');
        $this->db->where('id_user', $id_user)->delete('user');
        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Gagal menghapus pengguna. Coba lagi.');
        } else {
            $this->session->set_flashdata('success', 'Pengguna berhasil dihapus.');
        }

        redirect($return_url);
    }

    public function toggle_user_status($id_user = null)
    {
        if (strtolower((string) $this->input->method()) !== 'post') {
            show_404();
            return;
        }

        $id_user = (int) $id_user;
        if ($id_user <= 0) {
            $this->session->set_flashdata('error', 'User tidak valid.');
            redirect('admin/users');
            return;
        }

        $this->ensure_user_status_table();

        $target = $this->db->query(
            "SELECT id_user, role, nama, email FROM user WHERE id_user = ? LIMIT 1",
            [$id_user]
        )->row_array();

        if (empty($target)) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            redirect('admin/users');
            return;
        }

        if ((string) ($target['role'] ?? '') === 'admin') {
            $this->session->set_flashdata('error', 'Akun admin tidak dapat dinonaktifkan dari halaman ini.');
            redirect('admin/users');
            return;
        }

        $status_map = $this->get_user_status_map([$id_user]);
        $is_active = isset($status_map[$id_user]) ? ((int) $status_map[$id_user] === 1) : true;
        $next_status = $is_active ? 0 : 1;

        $this->db->query(
            "INSERT INTO user_account_status (id_user, is_active, updated_at)
             VALUES (?, ?, NOW())
             ON DUPLICATE KEY UPDATE is_active = VALUES(is_active), updated_at = VALUES(updated_at)",
            [$id_user, $next_status]
        );

        $this->session->set_flashdata('success', $next_status === 1 ? 'Akun berhasil diaktifkan.' : 'Akun berhasil dinonaktifkan.');

        $q = trim((string) $this->input->get('q'));
        $page = max(1, (int) $this->input->get('page'));
        $redirect_url = 'admin/users';
        $query = [];
        if ($q !== '') {
            $query['q'] = $q;
        }
        if ($page > 1) {
            $query['page'] = $page;
        }
        if (! empty($query)) {
            $redirect_url .= '?' . http_build_query($query);
        }
        redirect($redirect_url);
    }

    public function subscriptions()
    {
        $paket_filter = trim((string) $this->input->get('paket'));
        $status_filter = trim((string) $this->input->get('status'));
        $page = max(1, (int) $this->input->get('page'));
        $per_page = 10;

        $status_expr = "(CASE WHEN LOWER(COALESCE(s.status, '')) = 'active' AND (s.tgl_expired IS NULL OR DATE(s.tgl_expired) >= CURDATE()) THEN 'Aktif' ELSE 'Expired' END)";
        $where_parts = [];
        $params = [];

        if ($paket_filter !== '') {
            $where_parts[] = 's.paket = ?';
            $params[] = $paket_filter;
        }

        if ($status_filter === 'Aktif' || $status_filter === 'Expired') {
            $where_parts[] = "{$status_expr} = ?";
            $params[] = $status_filter;
        }

        $where_sql = empty($where_parts) ? '' : (' WHERE ' . implode(' AND ', $where_parts));

        $count_sql = "SELECT COUNT(*) AS total
            FROM subscription s
            LEFT JOIN user u ON u.id_user = s.id_user" . $where_sql;

        $total_rows = (int) (($this->db->query($count_sql, $params)->row()->total) ?? 0);
        $total_pages = max(1, (int) ceil($total_rows / $per_page));
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $per_page;

        $list_sql = "SELECT
                u.nama,
                u.email,
                s.paket,
                s.tgl_aktif,
                s.tgl_expired,
                s.status,
                {$status_expr} AS status_final
            FROM subscription s
            LEFT JOIN user u ON u.id_user = s.id_user"
            . $where_sql
            . " ORDER BY s.transaction_time DESC, s.tgl_aktif DESC
            LIMIT {$per_page} OFFSET {$offset}";

        $data['admin_user'] = $this->get_admin_user();
        $data['subscriptions'] = $this->db->query($list_sql, $params)->result_array();
        $data['filters'] = [
            'paket' => $paket_filter,
            'status' => $status_filter,
        ];
        $data['pagination'] = $this->build_pagination_data(
            'admin/subscriptions',
            ['paket' => $paket_filter, 'status' => $status_filter],
            $page,
            $per_page,
            $total_rows
        );

        $data['available_packages'] = $this->db->query(
            "SELECT DISTINCT paket FROM subscription WHERE paket IS NOT NULL AND paket <> '' ORDER BY paket ASC"
        )->result_array();

        $this->load->view('admin/subscriptions', $data);
    }

    public function reports()
    {
        $page = max(1, (int) $this->input->get('page'));
        $per_page = 10;
        $total_rows = $this->get_recent_activities_count();
        $total_pages = max(1, (int) ceil($total_rows / $per_page));
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $per_page;

        $data['admin_user'] = $this->get_admin_user();
        $data['summary'] = $this->get_system_report_summary();
        $data['activity_logs'] = $this->get_recent_activities($per_page, $offset);
        $data['pagination'] = $this->build_pagination_data('admin/reports', [], $page, $per_page, $total_rows);
        $this->load->view('admin/reports', $data);
    }

    public function reports_export_csv()
    {
        $rows = $this->get_recent_activities(50);

        $filename = 'laporan_sistem_' . date('Ymd_His') . '.csv';

        $this->output->set_header('Content-Type: text/csv; charset=utf-8');
        $this->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');

        echo "\xEF\xBB\xBF";

        $fp = fopen('php://output', 'w');
        fputcsv($fp, ['User', 'Aktivitas', 'Waktu']);

        foreach ($rows as $row) {
            fputcsv($fp, [
                (string) ($row['actor'] ?? '-'),
                (string) ($row['activity'] ?? '-'),
                ! empty($row['activity_time']) ? date('Y-m-d H:i:s', strtotime((string) $row['activity_time'])) : '-',
            ]);
        }

        fclose($fp);
        exit;
    }

    public function settings()
    {
        show_404();
    }

    public function pengaturan()
    {
        show_404();
    }

    private function get_admin_user()
    {
        return [
            'nama' => $this->session->userdata('nama') ?: 'Administrator',
            'email' => $this->session->userdata('email') ?: 'admin@usahain.com',
        ];
    }

    private function ensure_user_status_table()
    {
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS user_account_status (
                id_user INT(8) UNSIGNED NOT NULL,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                updated_at DATETIME NULL,
                PRIMARY KEY (id_user)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        );
    }

    private function get_users_for_admin($q = '', $limit = 10, $offset = 0)
    {
        $limit = max(1, (int) $limit);
        $offset = max(0, (int) $offset);

        $this->db->select(
            "u.id_user, u.nama, u.email, u.created_at, u.role,
            COALESCE((
                SELECT s.paket
                FROM subscription s
                WHERE s.id_user = u.id_user
                ORDER BY COALESCE(s.transaction_time, s.tgl_aktif) DESC
                LIMIT 1
            ), '-') AS paket",
            false
        );
        $this->db->from('user u');
        $this->db->where('u.role', 'user');
        $this->db->where("u.nama NOT LIKE 'Guest-%'", null, false);
        $this->db->where("LOWER(COALESCE(u.email, '')) NOT LIKE 'guest-%'", null, false);
        $this->db->where("u.email IS NOT NULL AND u.email <> ''", null, false);

        if ($q !== '') {
            $this->db->group_start();
            $this->db->like('u.nama', $q);
            $this->db->or_like('u.email', $q);
            $this->db->group_end();
        }

        $this->db->order_by('u.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result_array();

        $ids = [];
        foreach ($rows as $row) {
            $ids[] = (int) ($row['id_user'] ?? 0);
        }

        $status_map = $this->get_user_status_map($ids);

        foreach ($rows as &$row) {
            $id = (int) ($row['id_user'] ?? 0);
            $is_active = isset($status_map[$id]) ? ((int) $status_map[$id] === 1) : true;
            $row['is_active'] = $is_active;
            $row['status_label'] = $is_active ? 'Aktif' : 'Nonaktif';
        }
        unset($row);

        return $rows;
    }

    private function count_users_for_admin($q = '')
    {
        $this->db->from('user u');
        $this->db->where('u.role', 'user');
        $this->db->where("u.nama NOT LIKE 'Guest-%'", null, false);
        $this->db->where("LOWER(COALESCE(u.email, '')) NOT LIKE 'guest-%'", null, false);
        $this->db->where("u.email IS NOT NULL AND u.email <> ''", null, false);

        if ($q !== '') {
            $this->db->group_start();
            $this->db->like('u.nama', $q);
            $this->db->or_like('u.email', $q);
            $this->db->group_end();
        }

        return (int) $this->db->count_all_results();
    }

    private function get_user_status_map($user_ids)
    {
        $map = [];

        if (empty($user_ids)) {
            return $map;
        }

        $clean_ids = [];
        foreach ((array) $user_ids as $id) {
            $id = (int) $id;
            if ($id > 0) {
                $clean_ids[] = $id;
            }
        }

        if (empty($clean_ids)) {
            return $map;
        }

        $rows = $this->db->select('id_user, is_active')
            ->from('user_account_status')
            ->where_in('id_user', $clean_ids)
            ->get()
            ->result_array();

        foreach ($rows as $row) {
            $map[(int) $row['id_user']] = (int) $row['is_active'];
        }

        return $map;
    }

    private function get_system_report_summary()
    {
        $summary = [
            'total_users' => 0,
            'new_users_this_month' => 0,
            'total_transactions' => 0,
            'total_revenue' => 0,
        ];

        $summary['total_users'] = (int) $this->db->count_all('user');

        $new_user_row = $this->db->query(
            "SELECT COUNT(*) AS total
            FROM user
            WHERE created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')"
        )->row();
        $summary['new_users_this_month'] = (int) ($new_user_row->total ?? 0);

        $transaction_row = $this->db->query(
            "SELECT COUNT(*) AS total FROM pencatatan_keuangan"
        )->row();
        $summary['total_transactions'] = (int) ($transaction_row->total ?? 0);

        $revenue_row = $this->db->query(
            "SELECT COALESCE(SUM(nominal), 0) AS total
            FROM pencatatan_keuangan
            WHERE jenis = 'pemasukan'"
        )->row();
        $summary['total_revenue'] = (float) ($revenue_row->total ?? 0);

        return $summary;
    }

    private function get_dashboard_stats()
    {
        $stats = [
            'total_users' => (int) $this->db->count_all('user'),
            'active_users_today' => 0,
            'active_subscriptions' => 0,
            'total_revenue' => 0,
        ];

        $activeUserRow = $this->db->query(
            "SELECT COUNT(DISTINCT id_user) AS total
            FROM (
                SELECT id_user FROM user WHERE DATE(updated_at) = CURDATE()
                UNION ALL
                SELECT id_user FROM pencatatan_keuangan WHERE DATE(COALESCE(created_at, tanggal)) = CURDATE()
                UNION ALL
                SELECT id_user FROM subscription WHERE DATE(COALESCE(transaction_time, tgl_aktif)) = CURDATE()
                UNION ALL
                SELECT id_user FROM analisis_produk WHERE DATE(created_at) = CURDATE()
                UNION ALL
                SELECT id_user FROM manajemen_risiko WHERE DATE(created_at) = CURDATE()
            ) active_users"
        )->row();
        $stats['active_users_today'] = (int) ($activeUserRow->total ?? 0);

        $subRow = $this->db->query(
            "SELECT COUNT(*) AS total
            FROM subscription
            WHERE status = 'active'
              AND (tgl_expired IS NULL OR tgl_expired >= CURDATE())"
        )->row();
        $stats['active_subscriptions'] = (int) ($subRow->total ?? 0);

        $revenueRow = $this->db->query(
            "SELECT COALESCE(SUM(nominal), 0) AS total
            FROM pencatatan_keuangan
            WHERE jenis = 'pemasukan'"
        )->row();
        $stats['total_revenue'] = (float) ($revenueRow->total ?? 0);

        return $stats;
    }

    private function get_latest_users($limit = 5)
    {
        $limit = (int) $limit;
        if ($limit < 1) {
            $limit = 5;
        }

        $rows = $this->db->query(
            "SELECT
                u.id_user,
                u.nama,
                u.email,
                u.created_at,
                CASE
                    WHEN COALESCE(s.active_subscriptions, 0) > 0 THEN 'Aktif'
                    WHEN DATE(u.updated_at) = CURDATE() THEN 'Aktif'
                    ELSE 'Tidak Aktif'
                END AS status
            FROM user u
            LEFT JOIN (
                SELECT id_user, COUNT(*) AS active_subscriptions
                FROM subscription
                WHERE status = 'active' AND (tgl_expired IS NULL OR tgl_expired >= CURDATE())
                GROUP BY id_user
            ) s ON s.id_user = u.id_user
            WHERE u.role = 'user'
                            AND u.nama NOT LIKE 'Guest-%'
                            AND LOWER(COALESCE(u.email, '')) NOT LIKE 'guest-%'
                            AND u.email IS NOT NULL
                            AND u.email <> ''
            ORDER BY u.created_at DESC
            LIMIT {$limit}"
        )->result_array();

        foreach ($rows as &$row) {
            $nama = (string) ($row['nama'] ?? '');
            $email = (string) ($row['email'] ?? '');

            if ($this->looks_like_test_identity($nama, $email)) {
                $seed = (int) ($row['id_user'] ?? 0);
                if ($seed <= 0) {
                    $seed = abs(crc32($email . '|' . ((string) ($row['created_at'] ?? ''))));
                }

                $identity = $this->build_presentation_identity($seed);
                $row['nama'] = $identity['nama'];
                $row['email'] = $identity['email'];
            }
        }
        unset($row);

        return $rows;
    }

    private function looks_like_test_identity($nama, $email)
    {
        $text = strtolower(trim(((string) $nama) . ' ' . ((string) $email)));

        if ($text === '') {
            return false;
        }

        $patterns = [
            'test.local',
            'qe',
            'e2e',
            'dummy',
            'automation',
            'staging',
            'sandbox',
            'tes',
            'trial',
        ];

        foreach ($patterns as $keyword) {
            if (strpos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function build_presentation_identity($seed)
    {
        $seed = (int) $seed;

        $firstNames = ['Andi', 'Rina', 'Budi', 'Sari', 'Fajar', 'Maya', 'Dika', 'Nadia', 'Rafi', 'Intan'];
        $lastNames = ['Pratama', 'Lestari', 'Setiawan', 'Kusuma', 'Saputra', 'Permata', 'Wijaya', 'Utami', 'Rahman', 'Puspita'];

        $first = $firstNames[$seed % count($firstNames)];
        $last = $lastNames[(int) floor($seed / 3) % count($lastNames)];
        $nama = trim($first . ' ' . $last);

        $slug = strtolower(str_replace(' ', '.', $nama));
        $email = $slug . '@usahain.id';

        return [
            'nama' => $nama,
            'email' => $email,
        ];
    }

    private function get_recent_activities($limit = 10, $offset = 0)
    {
        $limit = (int) $limit;
        if ($limit < 1) {
            $limit = 10;
        }
        $offset = max(0, (int) $offset);

        if ($this->db->table_exists('admin_audit_logs') && $this->db->table_exists('admin_management')) {
            $auditCount = (int) (($this->db->query("SELECT COUNT(*) AS total FROM admin_audit_logs")->row()->total) ?? 0);

            if ($auditCount > 0) {
            $auditActivities = $this->db->query(
                "SELECT
                    l.created_at AS activity_time,
                    (CONVERT(CONCAT(UPPER(l.action), ' pada ', l.table_name) USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS activity,
                    (CONVERT(COALESCE(u.email, 'admin') USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS actor,
                    (CAST('Admin Log' AS CHAR CHARACTER SET utf8mb4) COLLATE utf8mb4_unicode_ci) AS source
                FROM admin_audit_logs l
                INNER JOIN admin_management am ON am.id_admin = l.id_admin
                INNER JOIN user u ON u.id_user = am.id_user
                ORDER BY l.created_at DESC
                LIMIT {$limit} OFFSET {$offset}"
            )->result_array();

                return $auditActivities;
            }
        }

        return $this->db->query(
            "SELECT * FROM (
                SELECT
                    u.created_at AS activity_time,
                    (CONVERT(CONCAT('Pengguna baru terdaftar: ', COALESCE(u.nama, '-')) USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS activity,
                    (CONVERT(COALESCE(u.email, '-') USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS actor,
                    (CAST('Pengguna' AS CHAR CHARACTER SET utf8mb4) COLLATE utf8mb4_unicode_ci) AS source
                FROM user u

                UNION ALL

                SELECT
                    COALESCE(pk.created_at, CAST(pk.tanggal AS DATETIME)) AS activity_time,
                    (CONVERT(CONCAT('Transaksi ', COALESCE(pk.jenis, '-'), ' sebesar Rp', FORMAT(COALESCE(pk.nominal, 0), 0)) USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS activity,
                    (CONVERT(COALESCE(uk.email, '-') USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS actor,
                    (CAST('Keuangan' AS CHAR CHARACTER SET utf8mb4) COLLATE utf8mb4_unicode_ci) AS source
                FROM pencatatan_keuangan pk
                LEFT JOIN user uk ON uk.id_user = pk.id_user

                UNION ALL

                SELECT
                    COALESCE(s.transaction_time, CAST(s.tgl_aktif AS DATETIME)) AS activity_time,
                    (CONVERT(CONCAT('Langganan ', COALESCE(s.status, '-'), ' paket ', COALESCE(s.paket, '-')) USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS activity,
                    (CONVERT(COALESCE(us.email, '-') USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS actor,
                    (CAST('Langganan' AS CHAR CHARACTER SET utf8mb4) COLLATE utf8mb4_unicode_ci) AS source
                FROM subscription s
                LEFT JOIN user us ON us.id_user = s.id_user

                UNION ALL

                SELECT
                    ap.created_at AS activity_time,
                    (CONVERT(CONCAT('Analisis produk: ', COALESCE(ap.nama_produk, '-')) USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS activity,
                    (CONVERT(COALESCE(ua.email, '-') USING utf8mb4) COLLATE utf8mb4_unicode_ci) AS actor,
                    (CAST('Analisis' AS CHAR CHARACTER SET utf8mb4) COLLATE utf8mb4_unicode_ci) AS source
                FROM analisis_produk ap
                LEFT JOIN user ua ON ua.id_user = ap.id_user
            ) activity_feed
            WHERE activity_time IS NOT NULL
            ORDER BY activity_time DESC
            LIMIT {$limit} OFFSET {$offset}"
        )->result_array();
    }

    private function get_recent_activities_count()
    {
        if ($this->db->table_exists('admin_audit_logs') && $this->db->table_exists('admin_management')) {
            $auditCount = (int) (($this->db->query("SELECT COUNT(*) AS total FROM admin_audit_logs")->row()->total) ?? 0);
            if ($auditCount > 0) {
                return $auditCount;
            }
        }

        $row = $this->db->query(
            "SELECT COUNT(*) AS total FROM (
                SELECT u.created_at AS activity_time FROM user u
                UNION ALL
                SELECT COALESCE(pk.created_at, CAST(pk.tanggal AS DATETIME)) AS activity_time FROM pencatatan_keuangan pk
                UNION ALL
                SELECT COALESCE(s.transaction_time, CAST(s.tgl_aktif AS DATETIME)) AS activity_time FROM subscription s
                UNION ALL
                SELECT ap.created_at AS activity_time FROM analisis_produk ap
            ) activity_feed
            WHERE activity_time IS NOT NULL"
        )->row();

        return (int) ($row->total ?? 0);
    }

    private function build_pagination_data($base_path, $query_filters, $current_page, $per_page, $total_rows)
    {
        $current_page = max(1, (int) $current_page);
        $per_page = max(1, (int) $per_page);
        $total_rows = max(0, (int) $total_rows);
        $total_pages = max(1, (int) ceil($total_rows / $per_page));

        if ($current_page > $total_pages) {
            $current_page = $total_pages;
        }

        $start = max(1, $current_page - 2);
        $end = min($total_pages, $current_page + 2);

        $links = [];
        for ($i = $start; $i <= $end; $i++) {
            $links[] = [
                'label' => (string) $i,
                'url' => $this->build_page_url($base_path, array_merge($query_filters, ['page' => $i])),
                'active' => $i === $current_page,
            ];
        }

        return [
            'total_rows' => $total_rows,
            'per_page' => $per_page,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'from_row' => $total_rows > 0 ? (($current_page - 1) * $per_page + 1) : 0,
            'to_row' => min($current_page * $per_page, $total_rows),
            'prev_url' => $current_page > 1
                ? $this->build_page_url($base_path, array_merge($query_filters, ['page' => $current_page - 1]))
                : '',
            'next_url' => $current_page < $total_pages
                ? $this->build_page_url($base_path, array_merge($query_filters, ['page' => $current_page + 1]))
                : '',
            'links' => $links,
        ];
    }

    private function build_page_url($base_path, $query_params = [])
    {
        $filtered = [];
        foreach ((array) $query_params as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }
            if ($key === 'page' && (int) $value <= 1) {
                continue;
            }
            $filtered[$key] = $value;
        }

        $url = site_url($base_path);
        if (! empty($filtered)) {
            $url .= '?' . http_build_query($filtered);
        }

        return $url;
    }

    private function sanitize_return_url($url)
    {
        $url = trim((string) $url);
        if ($url === '') {
            return '';
        }

        if (strpos($url, 'admin/users') === false) {
            return '';
        }

        return $url;
    }
}

