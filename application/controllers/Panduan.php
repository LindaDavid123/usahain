<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panduan extends CI_Controller {
    
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
     * Panduan UMKM
     */
    public function umkm()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->User_model->get($id_user);
        
        $data = [
            'user' => $user,
            'title' => 'Panduan Memulai Bisnis UMKM'
        ];
        
        $this->load->view('panduan/umkm', $data);
    }
    
    /**
     * Panduan Riset Pasar
     */
    public function risetpasar()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->User_model->get($id_user);
        
        $data = [
            'user' => $user,
            'title' => 'Panduan Riset Pasar'
        ];
        
        $this->load->view('panduan/risetpasar', $data);
    }
    
    /**
     * Panduan Modal Usaha
     */
    public function modalusaha()
    {
        $id_user = $this->session->userdata('id_user');
        $user = $this->User_model->get($id_user);
        
        $data = [
            'user' => $user,
            'title' => 'Panduan Modal Usaha'
        ];
        
        $this->load->view('panduan/modalusaha', $data);
    }
}
