<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Check session
        if (!$this->session->userdata('id_user')) {
            redirect('auth/login');
        }
        $this->load->model('User_model');
    }
    
    /**
     * Dashboard Perencanaan (untuk calon pemilik usaha)
     */
    public function perencanaan()
    {
        $id_user = $this->session->userdata('id_user');
        
        // Get user data
        $user = $this->User_model->get($id_user);
        
        $data = [
            'user' => $user,
            'summary' => [
                'today_sales' => 0,
                'today_expense' => 0,
                'today_profit' => 0
            ],
            'transactions' => []
        ];
        
        $this->load->view('auth/dashboard_planning', $data);
    }
    
    /**
     * Dashboard Operasional (untuk pemilik usaha aktif)
     */
    public function operasional()
    {
        $id_user = $this->session->userdata('id_user');
        
        // Get user data
        $user = $this->User_model->get($id_user);
        
        $data = [
            'user' => $user,
            'summary' => [
                'today_sales' => 0,
                'today_expense' => 0,
                'today_profit' => 0
            ],
            'transactions' => []
        ];
        
        $this->load->view('auth/dashboard_operasional', $data);
    }
}
?>
