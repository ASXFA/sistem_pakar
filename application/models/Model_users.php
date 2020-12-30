<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_users extends CI_Model {
    var $table = 'users';
    var $select_column = array('id','nama','username','status','created_by');
    var $order_column = array(null,'nip','nama','username','status',null);

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from($this->table);
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('nama',$_POST['search']['value']);
            $this->db->or_like('username',$_POST['search']['value']);
            $this->db->or_like('status',$_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('id','DESC');
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

    public function getByUname($uname)
    {
        $this->db->where('username',$uname);
        $query = $this->db->get($this->table);
        return $query;
    }

    public function getById($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    public function tambahUsers($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editUsers($id,$data)
    {
        $this->db->where('id',$id);
        $query = $this->db->update($this->table,$data);
        return $query;
    }

    public function deleteUsers($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

}
