<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_penyakit extends CI_Model {
    var $table = 'penyakit';
    var $select_column = array('id','kode_penyakit','nama_penyakit');
    var $order_column = array(null,'kode_penyakit','nama_penyakit');

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('nama_penyakit',$_POST['search']['value']);
            $this->db->or_like('kode_penyakit',$_POST['search']['value']);
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

    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function getKode()
    {
        $this->db->select("COUNT(id) AS total_penyakit");
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query;
    }

    public function tambahPenyakit($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editPenyakit($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query;
    }

    public function deletePenyakit($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}
