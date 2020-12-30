<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_temp_gejala extends CI_Model {

    var $table = 'temp_gejala';

    public function tambah($data)
    {
        $this->db->insert($this->table,$data);
    }

}