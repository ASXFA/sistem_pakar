<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_konsultasi extends CI_Model {
    
    var $table = 'temp_konsultasi';

    public function getByIdTamu($id_tamu)
    {
        $this->db->where('id_daftar_tamu',$id_tamu);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function tambahKonsul($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }
    

}
