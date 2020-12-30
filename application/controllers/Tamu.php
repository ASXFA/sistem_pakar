<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tamu extends CI_Controller {

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
        $this->load->model('model_daftar_tamu');
    }

	public function listTamu()
	{
		$this->twig->display('back/tamu.html',$this->content);
    }

    public function tamuLists()
    {
        $this->load->model('model_analisis');
        $tamu = $this->model_daftar_tamu->make_datatables();
        $data = array();
        if (!empty($tamu)) {
            $no = 1;
            foreach($tamu as $row){
                if ($this->id != $row->id) {
                    $sub_data = array();
                    $sub_data[] = $no;
                    $sub_data[] = $row->nama;
                    $sub_data[] = $row->jenis_kelamin;
                    $sub_data[] = $row->no_hp;
                    $sub_data[] = date('d F Y H:i:s',strtotime($row->created_at));
                    $analisis = $this->model_analisis->getByIdTamu($row->id);
                    if($analisis->num_rows()>0){
                        $sub_data[] = "<span class='badge badge-success p-2'>SELESAI</span>";
                        $sub_data[] = "<a target='_blank' href='".base_url()."lihatHasilBack/".$row->id."' class='btn btn-primary btn-sm mr-2 lihatHasil' id='".$row->id."' title='lihat hasil'><i class='fa fa-file'></i></a>";
                    }else{
                        $sub_data[] = "<span class='badge badge-danger p-2'>TIDAK SELESAI</span>";
                        $sub_data[] = "-";
                    }
                    $data[] = $sub_data;
                    $no++;
                }
            }
        }else{
            $data[] = "Data Belum Tersedia !";
        }
        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
            'data' => $data
        );

        echo json_encode($output);
    }
}
