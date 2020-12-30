<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_daftar_tamu extends CI_Model {
    var $table = 'daftar_tamu';
    var $select_column = array('id','nama','jenis_kelamin','no_hp','created_at');
    var $order_column = array(null,'nama','jenis_kelamin','no_hp',NULL);

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('nama',$_POST['search']['value']);
            $this->db->or_like('jenis_kelamin',$_POST['search']['value']);
            $this->db->or_like('no_hp',$_POST['search']['value']);
            $this->db->or_like('created_at',$_POST['search']['value']);
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

    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function tambahTamu($data)
    {
        $this->db->insert($this->table,$data);
        return $this->db->insert_id();
    }

    public function editTamu($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query;
    }

    public function deleteTamu($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }
}
