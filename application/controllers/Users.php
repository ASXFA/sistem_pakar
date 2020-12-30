<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
        $this->load->model('model_users');
    }

	public function listUsers()
	{
		$this->twig->display('back/users.html',$this->content);
    }

    public function userLists()
    {
        $users = $this->model_users->make_datatables();
        $data = array();
        if (!empty($users)) {
            $no = 1;
            foreach($users as $row){
                if ($this->id != $row->id) {
                    $sub_data = array();
                    $sub_data[] = $no;
                    $sub_data[] = $row->nama;
                    $sub_data[] = $row->username;
                    if ($row->status == 0) {
                        $sub_data[] = "<span class='badge badge-danger p-2'>TIDAK AKTIF</span>";
                        $sub_data[] = "<button class='btn btn-success btn-sm mr-2 gantiStatus' id='".$row->id."' data-status='1' title='Ganti Status'><i class='fa fa-check'></i></button><button class='btn btn-warning btn-sm mr-2 editUsers' id='".$row->id."' title='Edit User'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteUsers' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
                    }else{
                        $sub_data[] = "<span class='badge badge-success p-2'>AKTIF</span>";
                        $sub_data[] = "<button class='btn btn-danger btn-sm mr-2 gantiStatus' id='".$row->id."' data-status='0' title='Ganti Status'><i class='fa fa-check'></i></button><button class='btn btn-warning btn-sm mr-2 editUsers' id='".$row->id."' title='Edit User'><i class='fa fa-edit'></i></button><button class='btn btn-danger btn-sm mr-2 deleteUsers' id='".$row->id."' title='Delete User'><i class='fa fa-trash'></i></button>";
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

    public function usersById()
    {
        $id = $this->input->post('id');
        $user = $this->model_users->getById($id);
        $output = array(
            'nama' => $user->nama,
            'username' => $user->username
        );
        echo json_encode($output);
    }

    public function gantiStatusUsers()
    {
        $id = $this->input->post('id');
        $data = array('status' => $this->input->post('status'));
        $process = $this->model_users->editUsers($id,$data);
        echo json_encode($process);
    }

    public function doUsers()
    {
        $operation = $this->input->post('operation');
        if ($operation == "Tambah") {
            $data = array(
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('username'),PASSWORD_DEFAULT),
                'created_by' => $this->nama
            );
            $process = $this->model_users->tambahUsers($data);
        }else if($operation == "Edit"){
            $id = $this->input->post('id_users');
            $data = array(
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->nama
            );
            $process = $this->model_users->editUsers($id,$data);
        }
        echo json_encode($process);
    }

    public function deleteUsers()
    {
        $id = $this->input->post('id');
        $process = $this->model_users->deleteUsers($id);
        echo json_encode($process);
    }

    public function editProfil()
    {
        $user = $this->model_users->getById($this->id);
        $this->content['user'] = $user;
        $this->twig->display('back/editProfil.html',$this->content);
    }

    public function cekUsername()
    {
        $username = $this->input->post('username');
        $cek = $this->model_users->getByUname($username);
        $pesan = array();
        if ($cek->num_rows() > 0 && $username != $this->uname) {
            $pesan['cond'] = 0;
        }else{
            $pesan['cond'] = 1;
        }
        echo json_encode($pesan);
    }

    public function aksi_editProfil()
    {
        $nama = $this->input->post('nama');
        $username = $this->input->post('username');
        $data = array(
            'nama' => $nama,
            'username' => $username
        );
        $process = $this->model_users->editUsers($this->id,$data);
        echo json_encode($process);
    }

    public function editPassword()
    {
        $cek = $this->model_users->getByUname($this->uname);
        $pesan = array();
        if ($cek->num_rows() > 0) {
            $user = $cek->row();
            $pass_lama = $this->input->post('pass_lama');
            if (password_verify($pass_lama,$user->password)) {
                $pass_baru = $this->input->post('pass_baru');
                $data = array('password'=>password_hash($pass_baru,PASSWORD_DEFAULT));
                $process = $this->model_users->editUsers($this->id,$data);
                $pesan['cond'] = 1;
            }else{
                $pesan['cond'] = 0;
            }
        }
        echo json_encode($pesan);
    }
}
