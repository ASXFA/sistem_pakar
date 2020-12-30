<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_rule extends CI_Model {
    var $table = 'rule';
    var $select_column = array('*');
    var $order_column = array(null,'nama_penyakit','nama_gejala');

    function make_query()
    {
        $this->db->select($this->select_column);
        $this->db->from('rule');
        $this->db->join('penyakit','penyakit.id = rule.id_penyakit','left');
        $this->db->join('gejala','gejala.id = rule.id_gejala','left');
        if (isset($_POST['search']['value'])) {
            $this->db->or_like('nama_penyakit',$_POST['search']['value']);
            $this->db->or_like('nama_gejala',$_POST['search']['value']);
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_column[$_POST['order']['0']['column']],$_POST['order']['0']['dir']);
        }else{
            $this->db->order_by('rule.id_penyakit','ASC');
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
        $this->db->order_by('id_penyakit','ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function getAllCard()
    {
        $this->db->select($this->select_column);
        $this->db->from('rule');
        $this->db->join('penyakit','penyakit.id = rule.id_penyakit','left');
        $this->db->join('gejala','gejala.id = rule.id_gejala','left');
        $query = $this->db->get();
        return $query->result();
    }

    public function getById($id)
    {
        $this->db->where('id_rule',$id);
        $query = $this->db->get($this->table);
        return $query->row();
    }

    // public function getKode()
    // {
    //     $this->db->select("COUNT(id) AS total_rule");
    //     $this->db->from($this->table);
    //     $query = $this->db->get();
    //     return $query;
    // }

    public function tambahRule($data)
    {
        $query = $this->db->insert($this->table,$data);
        return $query;
    }

    public function editRule($id,$data)
    {
        $this->db->where('id_rule',$id);
        $query = $this->db->update($this->table,$data);
        return $query;
    }

    public function deleteRule($id)
    {
        $this->db->where('id_rule',$id);
        $query = $this->db->delete($this->table);
        return $query;
    }

    public function forAnalisa($id_tamu)
    {
        $query = $this->db->query("SELECT * FROM rule,temp_penyakit WHERE rule.id_penyakit = temp_penyakit.id_penyakit AND id_tamu = '$id_tamu' ORDER BY rule.id_penyakit,rule.id_gejala");
        return $query->result();
    }

    public function getByPenyakit($id_penyakit)
    {
        $this->db->where('id_penyakit',$id_penyakit);
        return $this->db->get($this->table)->result();
    }

    public function getByGejala($id_gejala)
    {
        $this->db->where('id_gejala',$id_gejala);
        return $this->db->get($this->table)->result();
    }

}
