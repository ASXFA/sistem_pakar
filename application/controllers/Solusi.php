<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solusi extends CI_Controller {

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
        $this->load->model('model_solusi');
    }

	public function listSolusi()
	{
		$this->twig->display('back/solusi.html',$this->content);
    }
    
    public function solusiLists()
    {
        $this->load->model('model_penyakit');
        $solusi = $this->model_solusi->make_datatables();
        $data = array();
        if (!empty($solusi)) {
            foreach($solusi as $row){
                $sub_data = array();
                $sub_data[] = $row->kode_solusi;
                $penyakit = $this->model_penyakit->getById($row->id_penyakit);
                $sub_data[] = $penyakit->nama_penyakit;
                $sub_data[] = $row->nama_solusi;
                $sub_data[] = "<button class='btn btn-warning btn-sm mr-2 editSolusi' id='".$row->id."' title='Edit solusi'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteSolusi' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
                $data[] = $sub_data;
            }
        }
        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_solusi->get_all_data(),
            'recordsFiltered' => $this->model_solusi->get_filtered_data(),
            'data' => $data
        );

        echo json_encode($output);
    }

    public function solusiById()
    {
        $id = $this->input->post('id');
        $solusi = $this->model_solusi->getById($id);
        $output = array(
            'kode_solusi' => $solusi->kode_solusi,
            'id_penyakit' => $solusi->id_penyakit,
            'nama_solusi' => $solusi->nama_solusi
        );
        echo json_encode($output);
    }

    public function doSolusi()
    {
        $operation = $this->input->post('operation');
        if ($operation == "Tambah") {
            $data = array(
                'kode_solusi' => $this->input->post('kode_solusi'),
                'id_penyakit' => $this->input->post('id_penyakit'),
                'nama_solusi' => $this->input->post('nama_solusi')
            );
            $process = $this->model_solusi->tambahSolusi($data);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_solusi');
            $data = array(
                'kode_solusi' => $this->input->post('kode_solusi'),
                'id_penyakit' => $this->input->post('id_penyakit'),
                'nama_solusi' => $this->input->post('nama_solusi')
            );
            $process = $this->model_solusi->editSolusi($id,$data);
        }
        echo json_encode($process);
    }

    public function getKodeSolusi()
    {
        $kode = $this->model_solusi->getKode()->row();
        $kodeConv = (int)$kode->total_solusi;
        $jmlh = 0;
        $jmlh += $kodeConv+1;
        if ($jmlh <= 9) {
            $output = array('kode' => 'S0'.$jmlh);
        }else{
            $output = array('kode' => 'S'.$jmlh);
        }
        echo json_encode($output);
    }

    public function deleteSolusi()
    {
        $id = $this->input->post('id');
        $process = $this->model_solusi->deleteSolusi($id);
        echo json_encode($process);
    }
}
