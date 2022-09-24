<?php


class Laporan_Temuan extends CI_Controller
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
		$this->load->model(['M_LaporanTemuan']);

	}

	public function index()
	{
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan();
		$data = [
			'link' => $this->uri->segment(1),
		];
		$this->load->view("template/sidebar", $data);
		$this->load->view("laporan/laporan_temuan", $dataTemuan);
		$this->load->view("template/footer");
	}

	public function list_temuan()
	{
		$data = $this->M_LaporanTemuan->getDataTemuan();
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function temuan_plant()
	{
		$data = $this->M_LaporanTemuan->getTemuanPlant();
		$result = array();
		foreach ($data as $item) {
			$result[$item->plant_name][] = [
				"x" => $item->date_patroli,
				"y" => $item->total_temuan
			];
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($result));
	}

}
