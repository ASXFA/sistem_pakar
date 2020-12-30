<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_temp_penyakit extends CI_Model {
    var $table = 'temp_penyakit';

    public function deleteByIdTamu($id_tamu)
    {
        $this->db->where('id_tamu',$id_tamu);
        $this->db->delete($this->table);
    }

    public function deleteByPenyakitTamu($id_tamu,$id_penyakit)
    {
        $this->db->where('id_tamu',$id_tamu);
        $this->db->where('id_penyakit',$id_penyakit);
        $this->db->delete($this->table);
    }

    public function getByIdTamu($id_tamu)
    {
        $this->db->where('id_tamu',$id_tamu);
        return $this->db->get($this->table);
    }

    public function tambah($data)
    {
        $this->db->insert($this->table,$data);
    }

}