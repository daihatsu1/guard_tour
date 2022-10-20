<?php


class Dashboard extends CI_Controller
{

	public function __construct(Type $var = null)
	{
		parent::__construct();
		$id = $this->session->userdata('id_token');
		if ($id == null || $id == "") {
			$this->session->set_flashdata('info_login', 'anda harus login dulu');
			redirect('Login');
		}

		$role = $this->session->userdata('role');
		if ($role != "SUPERADMIN") {
			redirect('Login');
		}
		$this->load->model(['M_LaporanTemuan', 'M_LaporanPatroli']);
		$this->dateNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));
		$this->load->helper('convertbulanina');

	}

	public function index()
	{
		$year = $this->dateNow->format('Y');
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan();
		$byKategoriObjek = $this->M_LaporanTemuan->getTotalTemuanByKategoriObject();

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
			'by_kategori_objek' => $byKategoriObjek,
			'data_temuan' => $dataTemuan,
			'year' => $year
		];
		$this->load->view("template/sidebar", $sidebarData);
		$this->load->view("dashboard", $data);
		$this->load->view("template/footer");
	}

	public function temuan_plant()
	{
		$result = array();
		$year = $this->dateNow->format('Y');
		$data = $this->M_LaporanTemuan->getTemuanPlant($year);

		foreach ($data as $item) {
			$result[$item->plant_name][] = [
				"x" => substr(convertbulanina($item->month), 0, 3),
				"y" => $item->total_temuan
			];
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($result));
	}

	public function patroli_plant()
	{
		$result = array();

		$data = $this->M_LaporanPatroli->getPatroliPlant();

		foreach ($data as $item) {
			$result[$item->plant_name][] = [
				"x" => substr(convertbulanina($item->month), 0, 3),
				"y" => $item->total_patroli
			];
		}
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($result));
	}

	public function listPatroliByUser()
	{
		$group = array("GROUP A", "GROUP B", "GROUP C", "GROUP D", "GROUP E", "GROUP F", "GROUP G", "GROUP H",);
		$result = array();
		$dataTemuan = $this->M_LaporanTemuan->getTemuanByUser();
		$groupNPK = array();
		foreach ($dataTemuan as $item) {
			$data = [];
			foreach (range(1, 12) as $key => $month) {
				if (!array_key_exists($item->plant_id, $groupNPK)) {
					$groupNPK[$item->plant_id] = [];
				}
				if (!array_key_exists($item->npk, $groupNPK[$item->plant_id])) {
					$groupNPK[$item->plant_id][$item->npk] = $group[count($groupNPK[$item->plant_id])];
				}
				$l = $groupNPK[$item->plant_id][$item->npk];
				$label = $item->plant_name . " - " . $l;
				if ($item->month == $month) {
					$data[$key] = $item->total_temuan;
				} else {
					$data[$key] = 0;
				}
			}
			$data = [
				'label' => $label,
				'type' => "bar",
				'stack' => $item->plant_name,
				'data' => $data
			];

			$result['datasets'][] = $data;
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($result));
	}
}
