<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbcheck extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Load database using config in application/config/database.php
        $this->load->database();

        // Try a simple query to validate connection
        try {
            $query = $this->db->query('SELECT 1 AS val');
            if ($query && $query->num_rows() > 0) {
                $row = $query->row();
                echo "Database connection OK. Test value: {$row->val}";
            } else {
                echo 'Query executed but returned no rows â€” check DB configuration.';
            }
        } catch (Exception $e) {
            echo 'Database error: ' . $e->getMessage();
        }
    }
}

