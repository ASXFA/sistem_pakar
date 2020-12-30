<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
    }

	public function index()
	{
        $this->load->model('model_daftar_tamu');
        $this->load->model('model_users');
        $this->load->model('model_gejala');
        $this->load->model('model_penyakit');
        $this->load->model('model_solusi');
        $this->load->model('model_rule');
        $tamu = $this->model_daftar_tamu->get_all_data();
        $users = $this->model_users->get_all_data();
        $gejala = $this->model_gejala->get_all_data();
        $penyakit = $this->model_penyakit->get_all_data();
        $solusi = $this->model_solusi->get_all_data();
        $rule = $this->model_rule->get_all_data();
        $this->content['tamu'] = $tamu;
        $this->content['users'] = $users;
        $this->content['gejala'] = $gejala;
        $this->content['penyakit'] = $penyakit;
        $this->content['solusi'] = $solusi;
        $this->content['rule'] = $rule;
		$this->twig->display('back/dashboard.html',$this->content);
	}
}
