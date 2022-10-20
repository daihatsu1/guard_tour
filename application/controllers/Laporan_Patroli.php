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
		$this->load->model(['M_LaporanPatroli', 'M_patrol']);

	}

	public function index()
	{
		$data = [
			'link' => $this->uri->segment(1),
			'plant' => $this->M_patrol->ambilData("admisecsgp_mstplant")
		];

		$this->load->view("template/sidebar", $data);
		$this->load->view("laporan/laporan_patroli", $data);
		$this->load->view("template/footer");
	}

	public function detail()
	{
		$idJadawal = $this->input->get("idJadwal");
		$npk = $this->input->get("npk");
		$type = $this->input->get('type');

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
			'detail' => $this->M_LaporanPatroli->getDataDetailPatroli($idJadawal, $npk, $type),
			'timeline' => $this->M_LaporanPatroli->timelineDetail($idJadawal, $npk, $type),
		];
		$this->load->view("template/sidebar", $sidebarData);
		$this->load->view("laporan/laporan_detail_patroli", $data);
		$this->load->view("template/footer");
	}
	public function list_patroli()
	{
		$plantId = $this->input->get('plantId');
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$type = $this->input->get('type');

		$data = [];
		if ($plantId != '') {
			$data = $this->M_LaporanPatroli->getDataPatroli($plantId, $start, $end, $type);
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}


}
