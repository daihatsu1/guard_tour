<?php


/**
 * @property array|mixed|
 */
class Dashboard extends CI_Controller
{

	/**
	 * @var array|mixed|null
	 */
	private $plant_id;

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
		$this->load->model(['M_LaporanTemuan', 'M_LaporanPatroli', 'M_patrol']);
		$this->dateNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));
		$this->load->helper(['convertbulanina', 'db_settings']);
		$this->plant_id = $this->session->userdata('plant_id');
	}

	public function index()
	{
		$monthYear = $this->dateNow->format('F Y');
		$year = $this->dateNow->format('Y');
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan($this->plant_id);

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
			'data_temuan' => $dataTemuan,
			'year' => $year,
			'monthYear' => $monthYear,
			'plants' => $this->M_patrol->ambilData("admisecsgp_mstplant")
		];

		$this->load->view("template/admin/sidebar", $sidebarData);
		$this->load->view("admin/dashboard", $data);
		$this->load->view("template/admin/footer");
	}

	public function temuan_kategori()
	{
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$byKategoriObjek = $this->M_LaporanTemuan->getTotalTemuanByKategoriObject($this->plant_id, $month, $year);
		$labels = array();
		$dataTemuan = array();
		$dataTotal = array();
		foreach ($byKategoriObjek as $item) {
			$labels[] = $item->kategori_name;
			$dataTemuan[] = $item->total_temuan;
			$dataTotal[] = $item->total_object;
		}
		$result = [
			'labels' => $labels,
			'datasets' => [
				[
					'type' => 'line',
					'label' => 'Total Temuan',
					'data' => $dataTemuan
				], [
					'type' => 'line',
					'label' => 'Total Objek',
					'data' => $dataTotal,
				]
			],
		];
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($result));
	}

	public function temuan_plant()
	{
		$result = array();
		$year = $this->dateNow->format('Y');
		$data = $this->M_LaporanTemuan->getTemuanPlant($year, $this->plant_id);

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
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$dataPatroli = $this->M_LaporanPatroli->getPatroliPlantByUser($year, $month);
		$plants = $this->M_LaporanTemuan->list_plants($this->plant_id);
		$patrol_groups = explode(',', get_setting('patrol_group')->nilai_setting);
		$datasets = [];
		foreach ($patrol_groups as $i => $group) {
			foreach ($dataPatroli as $k => $patroli) {
				if (!array_key_exists($i, $datasets)) {
					$datasets[$i] = [
						'label' => $group,
						'type' => "bar",
						'data' => array(),
						'barPercentage' => 0.2,
						'minBarLength' => 2
					];
				}

				foreach ($plants as $key => $plant) {
					if ($plant == $patroli->plant_name and $group == $patroli->patrol_group) {
						$datasets[$i]['data'][$key] = $patroli->total_patroli == null ? 0 : $patroli->total_patroli;
					} else {
						if (!array_key_exists($key, $datasets[$i]['data'])) {
							$datasets[$i]['data'][$key] = 0;
						}
					}
				}
			}
		}

		$data = [
			'labels' => ['REGU PATROLI'],
			'datasets' => $datasets,
		];

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function temuanTindakanPlant()
	{
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$temuan = $this->M_LaporanTemuan->getTemuanByPlant($year, $month);
		$tindakan = $this->M_LaporanTemuan->getTindakanByPlant($year, $month);
		$plants = $this->M_LaporanTemuan->list_plants($this->plant_id);
		$dataTemuan = [];
		$dataTindakan = [];

		foreach ($plants as $i => $plant) {
			$dataTemuan[$i] = 0;
			$dataTindakan[$i] = 0;
			foreach ($temuan as $t) {
				if ($t->plant_name == $plant) {
					$dataTemuan[$i] = $t->total_temuan;
				}
			}
			foreach ($tindakan as $td) {
				if ($td->plant_name == $plant) {
					$dataTindakan[$i] = $td->total_tindakan;
				}
			}
		}
		$datasets = [
			[
				'label' => "Total Temuan",
				'type' => "bar",
				'fill' => false,
				'data' => $dataTemuan,
				'barPercentage' => 0.2,
				'minBarLength' => 2,
			], [
				'label' => "Total Tindakan",
				'type' => "bar",
				'fill' => false,
				'barPercentage' => 0.2,
				'data' => $dataTindakan,
				'minBarLength' => 2,
			]
		];
		$data = [
			'labels' => ['REGU PATROLI'],
			'datasets' => $datasets,
		];
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function listTemuanByUser()
	{
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$dataTemuan = $this->M_LaporanTemuan->getTemuanByUser($year, $month);
		$plants = $this->M_LaporanTemuan->list_plants($this->plant_id);
		$patrol_groups = explode(',', get_setting('patrol_group')->nilai_setting);

		$datasets = [];
		foreach ($patrol_groups as $i => $group) {
			foreach ($dataTemuan as $k => $temuan) {
				if (!array_key_exists($i, $datasets)) {
					$datasets[$i] = [
						'label' => $group,
						'type' => "bar",
						'data' => array(),
						'barPercentage' => 0.2,
						'minBarLength' => 2,
					];
				}

				foreach ($plants as $key => $plant) {
					if ($plant == $temuan->plant_name and $group == $temuan->patrol_group) {
						$datasets[$i]['data'][$key] = $temuan->total_temuan == null ? 0 : $temuan->total_temuan;
					} elseif ($group == $temuan->patrol_group) {
						if (!array_key_exists($key, $datasets[$i]['data'])) {
							$datasets[$i]['data'][$key] = 0;
						}
					}
				}
			}
		}

		$data = [
			'labels' => ['REGU PATROLI'],
			'datasets' => $datasets,
		];

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function temuan_zone()
	{
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$plants = $this->M_LaporanTemuan->getData('admisecsgp_mstplant', ['status' => 1, 'plant_id' => $this->plant_id])->result();
		$zones = $this->M_LaporanTemuan->list_zones();
		$datasets = [];
		$labels = [];
		foreach ($plants as $key => $plant) {
			$labels[] = $plant->plant_name;
			$dataTemuan = $this->M_LaporanTemuan->getTemuanZone($year, $month, $plant->plant_id);
			foreach ($zones as $z => $zone) {
				if (!array_key_exists($z, $datasets)) {
					$datasets[$z] = [
						'label' => $zone,
						'type' => "bar",
						'data' => [],
						'minBarLength' => 2,
					];
				}
				foreach ($dataTemuan as $i => $temuan) {
					if ($temuan->plant_name == $plant->plant_name and $zone == $temuan->zone_name) {
						$datasets[$z]['data'][$key] = $temuan->total_temuan;
					} elseif ($zone == $temuan->zone_name) {
						if (!array_key_exists($key, $datasets[$z]['data'])) {
							$datasets[$z]['data'][$key] = 0;
						}
					}
				}
			}
		}
		$data = [
			'labels' => ['ZONA PATROLI'],
			'datasets' => $datasets,
		];

		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function tren_temuan()
	{
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$plantId = $this->plant_id;
		$temuan = $this->M_LaporanTemuan->getDataTemuanByMonth($year, $month, $plantId);
		$tindakan = $this->M_LaporanTemuan->getDataTindakanByMonth($year, $month, $plantId);
		$tindakanPic = $this->M_LaporanTemuan->getDataTemuanTindakanPICByMonth($year, $month, $plantId);
		$tindakanCepat = $this->M_LaporanTemuan->getDataTemuanTindakanCepatByMonth($year, $month, $plantId);
		$dayCount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$dateslabels = array();
		$datesTemuan = array();
		$datesTindakan = array();
		$datesTindakanPIC = array();
		$datesTindakanCepat = array();

		foreach (range(1, $dayCount) as $d) {
			$dateslabels[] = $d;
			$datesTemuan[] = 0;
			$datesTindakan[] = 0;
			$datesTindakanPIC[] = 0;
			$datesTindakanCepat[] = 0;
		}


		foreach ($temuan as $item) {
			$day = $item->day;
			$datesTemuan[$day] = $item->total_temuan;
		}

		foreach ($tindakan as $item) {
			$day = $item->day;
			$datesTindakan[$day] = $item->total_tindakan;
		}

		foreach ($tindakanCepat as $item) {
			$day = $item->day;
			$datesTindakanCepat[$day] = $item->total_tindakan;
		}

		foreach ($tindakanPic as $item) {
			$day = $item->day;
			$datesTindakanPIC[$day] = $item->total_tindakan;
		}
		$datasets = [
			[
				'label' => "Total Temuan",
				'type' => "line",
				'fill' => false,
				'data' => $datesTemuan,
				'minBarLength' => 2,
			], [
				'label' => "Total Tindakan",
				'type' => "line",
				'fill' => false,
				'data' => $datesTindakan,
				'minBarLength' => 2,
			],
			[
				'label' => "Tindakan PIC",
				'type' => "line",
				'data' => $datesTindakanPIC,
				'fill' => false,
				'minBarLength' => 2,
			],
			[
				'label' => "Tindakan Cepat",
				'type' => "line",
				'fill' => false,
				'data' => $datesTindakanCepat,
				'minBarLength' => 2,
			]
		];
		$data = [
			'labels' => $dateslabels,
			'datasets' => $datasets,
		];
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function tren_patroli()
	{
		$result = array();
		$month = $this->input->get('month');
		$year = $this->input->get('year');
		$plantId = $this->plant_id;
		$data = $this->M_LaporanPatroli->getDataPatroliByMonth($year, $month, $plantId);
		$dayCount = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$patrol_groups = explode(',', get_setting('patrol_group')->nilai_setting);
		$datasets = array();
		$dateslabels = array();
		$datesPatroli = array();
		foreach (range(1, $dayCount) as $d) {
			$dateslabels[] = $d;
			$datesPatroli[] = 0;
		}
		foreach ($patrol_groups as $group) {
			$datesPatroliGroup = array_merge(array(), $datesPatroli);
			foreach ($data as $item) {
				if ($item->patrol_group === $group) {
					$day = $item->day;
					$datesPatroliGroup[$day] = round(($item->chekpoint_patroli / $item->total_ckp) * 100);
				}
			}
			$datasets[] = [
				'label' => $group,
				'type' => "line",
				'fill' => false,
				'data' => $datesPatroliGroup,
				'minBarLength' => 2,

			];
		}

		$data = [
			'labels' => $dateslabels,
			'datasets' => $datasets,
		];
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}
}
