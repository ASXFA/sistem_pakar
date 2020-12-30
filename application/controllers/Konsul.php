<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Konsul extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // $this->isLogin = $this->session->userdata('isLogin');
        // if ($this->isLogin == 0) {
        //     rediret(base_url());
        // }
        // $this->id = $this->session->userdata('id');
        // $this->nama = $this->session->userdata('nama');
        // $this->uname = $this->session->userdata('uname');
        // $this->content = array(
        //     'base_url'=>base_url(),
        //     'id_user_login' => $this->id,
        //     'nama_user_login' => $this->nama,
        //     'uname_user_login' => $this->uname
        // );
        $this->load->model('model_rule');
        $this->load->model('model_konsultasi');
        $this->load->model('model_temp_analisa');
        $this->load->model('model_temp_penyakit');
        $this->load->model('model_temp_gejala');
    }

    function addTmpAnalisa($id_gejala, $id_tamu)
    {
        $penyakit = $this->model_rule->forAnalisa($id_tamu);
        foreach($penyakit as $p){
            $data = array(
                'id_tamu'=>$id_tamu,
                'id_penyakit'=>$p->id_penyakit,
                'id_gejala'=>$p->id_gejala
            );
            $insertTmpAnalisa = $this->model_temp_analisa->insertAnalisa($data);
        }
    }

    function addTmpGejala($id_gejala, $id_tamu)
    {
        $data = array(
            'id_tamu'=>$id_tamu,
            'id_gejala'=>$id_gejala
        );
        $gejala = $this->model_temp_gejala->tambah($data);
    }

    function delTmpPenyakit($id_tamu)
    {
        $penyakit = $this->model_temp_penyakit->deleteByIdTamu($id_tamu);
    }

    function delTmpAnalisa($id_tamu)
    {
        $analisa = $this->model_temp_analisa->deleteByIdTamu($id_tamu);
    }

    public function tambahKonsul()
    {
        $id_tamu = $this->input->post('id_tamu');
        $id_gejala = $this->input->post('id_gejala');
        $jawaban = $this->input->post('pilihan');

        if ($jawaban == 'YA') {
            $cek_temp_analisa = $this->model_temp_analisa->getByIdTamu($id_tamu);
            if (!empty($cek_temp_analisa)) {
                $this->delTmpPenyakit($id_tamu);
                $temp_analisa = $this->model_temp_analisa->getByGejalaIdTamu($id_tamu,$id_gejala);
                foreach($temp_analisa as $ta){
                    // $penyakit = $this->model_rule->getByPenyakit($ta->id_penyakit);
                    // foreach($penyakit as $p){
                    // }
                    $data = array(
                        'id_tamu'=>$id_tamu,
                        'id_penyakit'=>$ta->id_penyakit
                    );
                    $insertTempPenyakit = $this->model_temp_penyakit->tambah($data);
                }
                $this->delTmpAnalisa($id_tamu);
                $this->addTmpAnalisa($id_gejala,$id_tamu);
                $this->addTmpGejala($id_gejala,$id_tamu);
            }else{
                $rule = $this->model_rule->getByGejala($id_gejala);
                foreach($rule as $r){
                    // $penyakit = $this->model_rule->getByPenyakit($r->id_penyakit);
                    // foreach($penyakit as $p){
                        
                    // }
                    $data = array(
                        'id_tamu'=>$id_tamu,
                        'id_penyakit'=>$r->id_penyakit
                    );
                    $insertTempPenyakit = $this->model_temp_penyakit->tambah($data);
                }
                $this->addTmpAnalisa($id_gejala,$id_tamu);
                $this->addTmpGejala($id_gejala,$id_tamu);
            }
        } 
        
        if ($jawaban == 'TIDAK') {
            $cek_temp_analisa = $this->model_temp_analisa->getByIdTamu($id_tamu);
            if (!empty($cek_temp_analisa)) {
                $temp_analisa = $this->model_temp_analisa->getByGejalaIdTamu($id_tamu,$id_gejala);
                foreach($temp_analisa as $ta){
                    $deleteAnalisa = $this->model_temp_analisa->deleteByPenyakitTamu($id_tamu,$ta->id_penyakit);
                    $deletePenyakit = $this->model_temp_penyakit->deleteByPenyakitTamu($id_tamu,$ta->id_penyakit);
                }
            }else{
                $rule = $this->model_rule->getAll();
                foreach($rule as $ru){
                    $dataa = array(
                        'id_tamu'=>$id_tamu,
                        'id_penyakit'=>$ru->id_penyakit,
                        'id_gejala'=>$ru->id_gejala
                    );
                    $insertTmpAnalisa = $this->model_temp_analisa->insertAnalisa($dataa);
                    $data = array(
                        'id_tamu'=>$id_tamu,
                        'id_penyakit'=>$ru->id_penyakit
                    );
                    $insertPenyakit = $this->model_temp_penyakit->tambah($data);
                }
                $rules = $this->model_rule->getByGejala($id_gejala);
                foreach($rules as $r){
                    $deleteAnalisa = $this->model_temp_analisa->deleteByPenyakitTamu($id_tamu,$r->id_penyakit);
                    $deletePenyakit = $this->model_temp_penyakit->deleteByPenyakitTamu($id_tamu,$r->id_penyakit);
                }
            }
        }

        $data = array(
            'id_daftar_tamu'=>$id_tamu,
            'id_gejala'=>$id_gejala,
            'jawaban'=>$jawaban,
        );
        $process = $this->model_konsultasi->tambahKonsul($data);
        echo json_encode($process);
    }

    // function analisis()
    // {
    //     $this->load->model('model_penyakit');
    //     $this->load->model('model_rule');
    //     $penyakit = $this->model_penyakit->getAll();
    //     // $rule = $this->
    // }

    public function lihatHasilBack($id_tamu)
    {
        $this->load->model('model_analisis');
        $this->load->model('model_penyakit');
        $this->load->model('model_gejala');
        $this->load->model('model_konsultasi');
        $this->load->model('model_daftar_tamu');
        $this->load->model('model_solusi');
        $analisa = $this->model_analisis->getByTamu($id_tamu);
        $konsultasi = $this->model_konsultasi->getByIdTamu($id_tamu);
        $gejala = $this->model_gejala->getAll();
        $penyakit = $this->model_penyakit->getById($analisa->id_penyakit);
        $tamu = $this->model_daftar_tamu->getById($id_tamu);
        $solusi = $this->model_solusi->getByIdPenyakit($analisa->id_penyakit);
        $dataa = array(
            'konsultasi'=>$konsultasi,
            'gejala'=>$gejala,
            'penyakit'=>$penyakit,
            'tamu'=>$tamu,
            'solusi'=>$solusi
        );

        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
		// $data = $this->load->view('printKegiatan',$this->content,TRUE);
        $data = $this->load->view('print',$dataa,TRUE);
		$mpdf->WriteHTML($data);
        $mpdf->Output('hasil.pdf','I');
    }

	// public function listUsers()
	// {
	// 	$this->twig->display('back/users.html',$this->content);
    // }

    // public function userLists()
    // {
    //     $users = $this->model_users->make_datatables();
    //     $data = array();
    //     if (!empty($users)) {
    //         $no = 1;
    //         foreach($users as $row){
    //             if ($this->id != $row->id) {
    //                 $sub_data = array();
    //                 $sub_data[] = $no;
    //                 $sub_data[] = $row->nama;
    //                 $sub_data[] = $row->username;
    //                 if ($row->status == 0) {
    //                     $sub_data[] = "<span class='badge badge-danger p-2'>TIDAK AKTIF</span>";
    //                     $sub_data[] = "<button class='btn btn-success btn-sm mr-2 gantiStatus' id='".$row->id."' data-status='1' title='Ganti Status'><i class='fa fa-check'></i></button><button class='btn btn-warning btn-sm mr-2 editUsers' id='".$row->id."' title='Edit User'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteUsers' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
    //                 }else{
    //                     $sub_data[] = "<span class='badge badge-success p-2'>AKTIF</span>";
    //                     $sub_data[] = "<button class='btn btn-danger btn-sm mr-2 gantiStatus' id='".$row->id."' data-status='0' title='Ganti Status'><i class='fa fa-check'></i></button><button class='btn btn-warning btn-sm mr-2 editUsers' id='".$row->id."' title='Edit User'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteUsers' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
    //                 }
    //                 $data[] = $sub_data;
    //                 $no++;
    //             }
    //         }
    //     }else{
    //         $data[] = "Data Belum Tersedia !";
    //     }
    //     $output = array(
    //         'draw' => intval($_POST['draw']),
    //         'recordsTotal' => count($data),
    //         'recordsFiltered' => count($data),
    //         'data' => $data
    //     );

    //     echo json_encode($output);
    // }

    // public function usersById()
    // {
    //     $id = $this->input->post('id');
    //     $user = $this->model_users->getById($id);
    //     $output = array(
    //         'nama' => $user->nama,
    //         'username' => $user->username
    //     );
    //     echo json_encode($output);
    // }

    // public function gantiStatusUsers()
    // {
    //     $id = $this->input->post('id');
    //     $data = array('status' => $this->input->post('status'));
    //     $process = $this->model_users->editUsers($id,$data);
    //     echo json_encode($process);
    // }

    // public function doUsers()
    // {
    //     $operation = $this->input->post('operation');
    //     if ($operation == "Tambah") {
    //         $data = array(
    //             'nama' => $this->input->post('nama'),
    //             'username' => $this->input->post('username'),
    //             'password' => password_hash($this->input->post('username'),PASSWORD_DEFAULT),
    //             'created_by' => $this->nama
    //         );
    //         $process = $this->model_users->tambahUsers($data);
    //     }else if($operation == "Edit"){
    //         $id = $this->input->post('id_users');
    //         $data = array(
    //             'nama' => $this->input->post('nama'),
    //             'username' => $this->input->post('username'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'updated_by' => $this->nama
    //         );
    //         $process = $this->model_users->editUsers($id,$data);
    //     }
    //     echo json_encode($process);
    // }

    // public function deleteUsers()
    // {
    //     $id = $this->input->post('id');
    //     $process = $this->model_users->deleteUsers($id);
    //     echo json_encode($process);
    // }
}
