<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_gejala extends CI_Model {
    var $table = 'gejala';
    var $select_column = array('id','kode_gejala','nama_gejala');
    var $order_column = array(null,'kode_gejala','nama_gejala');

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('nama_gejala',$_POST['search']['value']);
            $this->db->or_like('kode_gejala',$_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id','ASC');
        }
    }

    public function make_datatables()
    {
        $this->make_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'],$_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function get_filtered_data()
    {
        $this->make_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getAll()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByLimit()
    {
        $this->db->limit(1);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getByKonsul($id)
    {
        $query = $this->db->query("SELECT * FROM gejala WHERE NOT id IN(SELECT id_gejala FROM temp_konsultasi WHERE id_daftar_tamu='$id') LIMIT 1");
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getKode()
    {
        $this->db->select("COUNT(id) AS total_gejala");
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

    public function tambahGejala($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editGejala($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query;
    }

    public function deleteGejala($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}
