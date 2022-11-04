<?php


/**
 * @property DateTimeImmutable $dateNow
 */
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
		$this->dateNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));

		$role = $this->session->userdata('role');
		if ($role != "SUPERADMIN") {
			redirect('Login');
		}
		$this->load->model(['M_LaporanTemuan']);

	}

	public function index()
	{
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan();
//		$byKategoriObjek = $this->M_LaporanTemuan->getTotalTemuanByKategoriObject();

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
//			'by_kategori_objek' => $byKategoriObjek,
			'data_temuan' => $dataTemuan
		];
		$this->load->view("template/sidebar", $sidebarData);
		$this->load->view("laporan/laporan_temuan", $data);
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
		$result = array();

		$data = $this->M_LaporanTemuan->getTemuanPlant();

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

	function sendEmailPIC(){
		$this->load->model(['M_restPatrol']);
		$result = $this->M_restPatrol->sendEmailPIC('ADMJP0610225cd4adNme');
		var_dump($result);
	}

}
