<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow public access (no login required)
        $this->load->helper(['url','form']);
        $this->load->library('form_validation');
    }

    public function dashboard()
    {
        // Get statistics for admin dashboard
        $data['total_users'] = $this->db->count_all('user');
        
        $data['active_subscriptions'] = $this->db->where('status', 'active')
                                                   ->count_all_results('subscription');
        
        $data['total_subscriptions'] = $this->db->count_all('subscription');
        
        $data['total_products'] = $this->db->count_all('analisis_produk');
        
        $data['total_transactions'] = $this->db->count_all('pencatatan_keuangan');
        
        // Get recent transactions
        $data['recent_transactions'] = $this->db->order_by('tanggal', 'DESC')
                                                  ->limit(10)
                                                  ->get('pencatatan_keuangan')
                                                  ->result();
        
        // Get user growth (this month)
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $data['new_users_this_month'] = $this->db->count_all_results('user');
        
        // Get subscription revenue
        $query = $this->db->query("
            SELECT SUM(CASE 
                WHEN paket = 'basic' THEN 99000
                WHEN paket = 'pro' THEN 199000
                WHEN paket = 'enterprise' THEN 499000
                ELSE 0 
            END) as total_revenue
            FROM subscription 
            WHERE status = 'active'
        ");
        $data['estimated_revenue'] = $query->row()->total_revenue ?? 0;
        
        // Get financial summary
        $pemasukan = $this->db->query("SELECT SUM(nominal) as total FROM pencatatan_keuangan WHERE jenis = 'pemasukan'")->row();
        $pengeluaran = $this->db->query("SELECT SUM(nominal) as total FROM pencatatan_keuangan WHERE jenis = 'pengeluaran'")->row();
        
        $data['total_income'] = $pemasukan->total ?? 0;
        $data['total_expenses'] = $pengeluaran->total ?? 0;
        $data['net_balance'] = $data['total_income'] - $data['total_expenses'];
        
        $this->load->view('admin/dashboard', $data);
    }

    public function users()
    {
        $data['users'] = $this->db->get('user')->result();
        $this->load->view('admin/users', $data);
    }

    public function subscriptions()
    {
        $data['subscriptions'] = $this->db->get('subscription')->result();
        $this->load->view('admin/subscriptions', $data);
    }

    public function reports()
    {
        // Financial report
        $data['financial_summary'] = $this->db->query("
            SELECT 
                kategori,
                jenis,
                COUNT(*) as count,
                SUM(nominal) as total
            FROM pencatatan_keuangan
            GROUP BY kategori, jenis
            ORDER BY jenis DESC
        ")->result();

        // User activity
        $data['user_activity'] = $this->db->query("
            SELECT 
                u.nama,
                u.email,
                COUNT(DISTINCT a.id_produk) as products,
                COUNT(DISTINCT s.id_subs) as subscriptions,
                COUNT(DISTINCT k.id_transaksi) as transactions
            FROM user u
            LEFT JOIN analisis_produk a ON u.id_user = a.id_user
            LEFT JOIN subscription s ON u.id_user = s.id_user
            LEFT JOIN pencatatan_keuangan k ON u.id_user = k.id_user
            GROUP BY u.id_user
            ORDER BY u.created_at DESC
        ")->result();

        $this->load->view('admin/reports', $data);
    }
}

