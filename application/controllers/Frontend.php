<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Frontend extends CI_Controller {

    // public function __construct()
    // {
    //     parent::__construct();
        
    // }

	public function index()
	{
        $this->tamu = $this->session->userdata('id_tamu');
        if ($this->tamu) {
            redirect('konsultasi');
        }
		$this->twig->display('front/index.html');
    }

    public function tambahTamu()
    {
        $this->load->model('model_daftar_tamu');
        $nama = $this->input->post('nama_tamu');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $no_hp = $this->input->post('no_hp');
        $data = array(
            'nama'=>$nama,
            'jenis_kelamin'=>$jenis_kelamin,
            'no_hp'=>$no_hp
        );
        $process = $this->model_daftar_tamu->tambahTamu($data);
        $this->session->set_userdata('id_tamu',$process);
        echo json_encode($process);
    }
    
    public function konsultasi()
    {
        $this->tamu = $this->session->userdata('id_tamu');
        if (!$this->tamu) {
            redirect(base_url());
        }
        $this->content = array(
            'id_tamu'=>$this->session->userdata('id_tamu')
        );
        $this->load->model('model_temp_penyakit');
        $this->load->model('model_analisis');
        $penyakit = $this->model_temp_penyakit->getByIdTamu($this->tamu);
        if ($penyakit->num_rows() == 1) {
            $cek_hasil_analisis = $this->model_analisis->getByIdTamu($this->tamu);
            if ($cek_hasil_analisis->num_rows() == 0) {
                $arrPenyakit = $penyakit->row();
                $data = array(
                    'id_tamu'=>$this->content['id_tamu'],
                    'id_penyakit'=>$arrPenyakit->id_penyakit
                );
                $this->model_analisis->tambah($data);
            }
        }

        $this->load->model('model_gejala');
        $this->load->model('model_konsultasi');
        $konsul = $this->model_konsultasi->getByIdTamu($this->content['id_tamu']);
        if (empty($konsul)) {
            $this->content['gejala'] = $this->model_gejala->getByLimit();
        }else{
            $this->content['gejala'] = $this->model_gejala->getByKonsul($this->content['id_tamu']);
        }
		$this->twig->display('front/konsultasi.html',$this->content);
    }

    public function cancelKonsul()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function lihatHasil()
    {
        $id_tamu = $this->session->userdata('id_tamu');
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
        $mpdf->Output('laporan.pdf','I');
        
        // redirect('cancelKonsul');
    }
}
