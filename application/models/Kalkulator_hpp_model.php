<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalkulator_hpp_model extends CI_Model {
    protected $table = 'kalkulator_hpp';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($id = null)
    {
        if ($id) {
            return $this->db->get_where($this->table, ['id_hpp' => $id])->row();
        }
        return $this->db->get($this->table)->result();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        return $this->db->where('id_hpp', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id_hpp', $id)->delete($this->table);
    }
}

