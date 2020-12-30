<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rule extends CI_Controller {

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
        $this->load->model('model_rule');
    }

	public function listrule()
	{
		$this->twig->display('back/rule.html',$this->content);
    }
    
    public function ruleLists()
    {
        $rule = $this->model_rule->make_datatables();
        $data = array();
        if (!empty($rule)) {
            $no = 1;
            foreach($rule as $row){
                $sub_data = array();
                $sub_data[] = $no;
                $sub_data[] = $row->nama_penyakit;
                $sub_data[] = $row->nama_gejala;
                $sub_data[] = "<button class='btn btn-warning btn-sm mr-2 editRule' id='".$row->id_rule."' title='Edit rule'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteRule' id='".$row->id_rule."' title='Delete Rule'><i class='fa fa-trash'></i></button>";
                $data[] = $sub_data;
                $no++;
            }
        }
        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->model_rule->get_all_data(),
            'recordsFiltered' => $this->model_rule->get_filtered_data(),
            'data' => $data
        );

        echo json_encode($output);
    }

    public function aturanRincian()
    {
        $this->load->model('model_penyakit');
        $penyakit = $this->model_penyakit->getAll();
        $rules = $this->model_rule->getAllCard();
        $output = array(
            'penyakit'=>$penyakit,
            'rules'=>$rules
        );
        echo json_encode($output);
    }

    public function ruleById()
    {
        $id = $this->input->post('id');
        $rule = $this->model_rule->getById($id);
        $output = array(
            'id_penyakit' => $rule->id_penyakit,
            'id_gejala' => $rule->id_gejala
        );
        echo json_encode($output);
    }

    public function doRule()
    {
        $operation = $this->input->post('operation');
        if ($operation == "Tambah") {
            $data = array(
                'id_penyakit' => $this->input->post('id_penyakit'),
                'id_gejala' => $this->input->post('id_gejala')
            );
            $process = $this->model_rule->tambahRule($data);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_rule');
            $data = array(
                'id_penyakit' => $this->input->post('id_penyakit'),
                'id_gejala' => $this->input->post('id_gejala')
            );
            $process = $this->model_rule->editRule($id,$data);
        }
        echo json_encode($process);
    }

    // public function getKodeRule()
    // {
    //     $kode = $this->model_rule->getKode()->row();
    //     $kodeConv = (int)$kode->total_rule;
    //     $jmlh = 0;
    //     $jmlh += $kodeConv+1;
    //     if ($jmlh <= 9) {
    //         $output = array('kode' => 'G0'.$jmlh);
    //     }else{
    //         $output = array('kode' => 'G'.$jmlh);
    //     }
    //     echo json_encode($output);
    // }

    public function deleteRule()
    {
        $id = $this->input->post('id');
        $process = $this->model_rule->deleteRule($id);
        echo json_encode($process);
    }
}
