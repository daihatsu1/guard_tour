<?php


class Laporan_Patroli extends CI_Controller
{

	public function __construct(Type $var = null)
	{
		parent::__construct();
		$id = $this->session->userdata('id_token');
		date_default_timezone_set('Asia/Jakarta');
		if ($id == null || $id == "") {
			$this->session->set_flashdata('info_login', 'anda harus login dulu');
			redirect('Login');
		}
		$role = $this->session->userdata('role');
		if ($role != "SUPERADMIN") {
			redirect('Login');
		}
	}

	public function index()
	{
		$data = [
			'link'  => $this->uri->segment(1)
		];
		// $this->template->load("template/template", "dashboard", $data);

		$this->load->view("template/sidebar", $data);
		$this->load->view("laporan/laporan_temuan", $data);
		$this->load->view("template/footer");
	}


}
