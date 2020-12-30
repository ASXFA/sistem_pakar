<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->isLogin = $this->session->userdata('isLogin');
        if ($this->isLogin == 0) {
            redirect(base_url());
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
        $this->load->model('model_penyakit');
    }

	public function listPenyakit()
	{
		$this->twig->display('back/penyakit.html',$this->content);
    }
    
    public function penyakitLists()
    {
        $penyakit = $this->model_penyakit->make_datatables();
        $data = array();
        if (!empty($penyakit)) {
            foreach($penyakit as $row){
                $sub_data = array();
                $sub_data[] = $row->kode_penyakit;
                $sub_data[] = $row->nama_penyakit;
                $sub_data[] = "<button class='btn btn-warning btn-sm mr-2 editPenyakit' id='".$row->id."' title='Edit Penyakit'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deletePenyakit' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
                $data[] = $sub_data;
            }
        }
        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_penyakit->get_all_data(),
            'recordsFiltered' => $this->model_penyakit->get_filtered_data(),
            'data' => $data
        );

        echo json_encode($output);
    }

    public function getAllPenyakit()
    {
        $penyakit = $this->model_penyakit->getAll();
        echo json_encode($penyakit);
    }

    public function penyakitById()
    {
        $id = $this->input->post('id');
        $penyakit = $this->model_penyakit->getById($id);
        $output = array(
            'kode_penyakit' => $penyakit->kode_penyakit,
            'nama_penyakit' => $penyakit->nama_penyakit
        );
        echo json_encode($output);
    }

    public function doPenyakit()
    {
        $operation = $this->input->post('operation');
        if ($operation == "Tambah") {
            $data = array(
                'kode_penyakit' => $this->input->post('kode_penyakit'),
                'nama_penyakit' => $this->input->post('nama_penyakit')
            );
            $process = $this->model_penyakit->tambahPenyakit($data);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_penyakit');
            $data = array(
                'kode_penyakit' => $this->input->post('kode_penyakit'),
                'nama_penyakit' => $this->input->post('nama_penyakit')
            );
            $process = $this->model_penyakit->editPenyakit($id,$data);
        }
        echo json_encode($process);
    }

    public function getKodePenyakit()
    {
        $kode = $this->model_penyakit->getKode()->row();
        $kodeConv = (int)$kode->total_penyakit;
        $jmlh = 0;
        $jmlh += $kodeConv+1;
        if ($jmlh <= 9) {
            $output = array('kode' => 'P0'.$jmlh);
        }else{
            $output = array('kode' => 'P'.$jmlh);
        }
        echo json_encode($output);
    }

    public function deletePenyakit()
    {
        $id = $this->input->post('id');
        $process = $this->model_penyakit->deletePenyakit($id);
        echo json_encode($process);
    }
}
