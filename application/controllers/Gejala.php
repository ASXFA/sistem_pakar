<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gejala extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->isLogin = $this->session->userdata('isLogin');
        if ($this->isLogin == 0) {
            rediret(base_url());
        }
        $this->id = $this->session->userdata('id');
        $this->nama = $this->session->userdata('nama');
        $this->uname = $this->session->userdata('uname');
        $this->content = array(
            'base_url'=>base_url(),
            'id_user_login' => $this->id,
            'nama_user_login' => $this->nama,
            'uname_user_login' => $this->uname
        );
        $this->load->model('model_gejala');
    }

	public function listGejala()
	{
		$this->twig->display('back/gejala.html',$this->content);
    }
    
    public function gejalaLists()
    {
        $gejala = $this->model_gejala->make_datatables();
        $data = array();
        if (!empty($gejala)) {
            foreach($gejala as $row){
                $sub_data = array();
                $sub_data[] = $row->kode_gejala;
                $sub_data[] = $row->nama_gejala;
                $sub_data[] = "<button class='btn btn-warning btn-sm mr-2 editGejala' id='".$row->id."' title='Edit gejala'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteGejala' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
                $data[] = $sub_data;
            }
        }
        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_gejala->get_all_data(),
            'recordsFiltered' => $this->model_gejala->get_filtered_data(),
            'data' => $data
        );

        echo json_encode($output);
    }

    public function getAllGejala()
    {
        $gejala = $this->model_gejala->getAll();
        echo json_encode($gejala);
    }

    public function gejalaById()
    {
        $id = $this->input->post('id');
        $gejala = $this->model_gejala->getById($id);
        $output = array(
            'kode_gejala' => $gejala->kode_gejala,
            'nama_gejala' => $gejala->nama_gejala
        );
        echo json_encode($output);
    }

    public function doGejala()
    {
        $operation = $this->input->post('operation');
        if ($operation == "Tambah") {
            $data = array(
                'kode_gejala' => $this->input->post('kode_gejala'),
                'nama_gejala' => $this->input->post('nama_gejala')
            );
            $process = $this->model_gejala->tambahGejala($data);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_gejala');
            $data = array(
                'kode_gejala' => $this->input->post('kode_gejala'),
                'nama_gejala' => $this->input->post('nama_gejala')
            );
            $process = $this->model_gejala->editGejala($id,$data);
        }
        echo json_encode($process);
    }

    public function getKodeGejala()
    {
        $kode = $this->model_gejala->getKode()->row();
        $kodeConv = (int)$kode->total_gejala;
        $jmlh = 0;
        $jmlh += $kodeConv+1;
        if ($jmlh <= 9) {
            $output = array('kode' => 'G0'.$jmlh);
        }else{
            $output = array('kode' => 'G'.$jmlh);
        }
        echo json_encode($output);
    }

    public function deleteGejala()
    {
        $id = $this->input->post('id');
        $process = $this->model_gejala->deleteGejala($id);
        echo json_encode($process);
    }
}
