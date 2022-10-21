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
		if ($role != "ADMIN") {
			redirect('Login');
		}
		$this->load->model(['M_LaporanTemuan', 'M_LaporanPatroli']);
		$this->dateNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));
		$this->load->helper('convertbulanina');

	}

	public function index()
	{
		$plant_id = $this->session->userdata("plant_id");

		$year = $this->dateNow->format('Y');
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan($plant_id);
		$byKategoriObjek = $this->M_LaporanTemuan->getTotalTemuanByKategoriObject($plant_id);

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
			'by_kategori_objek' => $byKategoriObjek,
			'data_temuan' => $dataTemuan,
			'year' => $year
		];
		$this->load->view("template/admin/sidebar", $sidebarData);
		$this->load->view("Admin/dashboard", $data);
		$this->load->view("template/footer");
	}

	public function temuan_plant()
	{
		$plant_id = $this->session->userdata("plant_id");

		$result = array();
		$year = $this->dateNow->format('Y');
		$data = $this->M_LaporanTemuan->getTemuanPlant($year, $plant_id);

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
		$plant_id = $this->session->userdata("plant_id");
		$result = array();
		$data = $this->M_LaporanPatroli->getPatroliPlant($plant_id);

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
		$plant_id = $this->session->userdata("plant_id");
		$group = array("GROUP A", "GROUP B", "GROUP C", "GROUP D", "GROUP E", "GROUP F", "GROUP G", "GROUP H",);
		$result = array();
		$dataTemuan = $this->M_LaporanTemuan->getTemuanByUser($plant_id);
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
