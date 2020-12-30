<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_analisis extends CI_Model {

    var $table='analisis';

    public function tambah($data)
    {
        $this->db->insert($this->table,$data);
    }

    public function getByTamu($id_tamu)
    {
        $this->db->where('id_tamu',$id_tamu);
        return $this->db->get($this->table)->row();
    }

    public function getByIdTamu($id_tamu)
    {
        $this->db->where('id_tamu',$id_tamu);
        return $this->db->get($this->table);
    }

}