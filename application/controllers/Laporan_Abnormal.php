<?php


class Laporan_Abnormal extends CI_Controller
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

		$sidebarData = [
			'link' => $this->uri->segment(1),
		];
		$data = [
			'data_temuan' => $dataTemuan
		];
		$this->load->view("template/sidebar", $sidebarData);
		$this->load->view("laporan/laporan_abnormal", $data);
		$this->load->view("template/footer");
	}

	public function list_temuan()
	{
		$data = $this->M_LaporanTemuan->getDataTemuan(null, 'open');
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function total_temuan()
	{
		$data['total_temuan'] = count($this->M_LaporanTemuan->getDataTemuan(null, 'open'));
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function list_temuan_tindakan_cepat()
	{
		$data = $this->M_LaporanTemuan->getDataTemuanTindakanCepat();
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

	public function update_status_temuan()
	{
		$trans_detail_id = $this->input->post("trans_detail_id");
		$catatan_tindakan = $this->input->post("catatan_tindakan");
		$data = [
			'deskripsi_tindakan' => $catatan_tindakan,
			'status_temuan' => 1,
			'updated_at' => $date = date('Y-m-d H:i:s'),
		];
		$update = $this->M_LaporanTemuan->updateData('admisecsgp_trans_details', $data, 'trans_detail_id', $trans_detail_id);
		if ($update) {
			$this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data temuan');
		} else {
			$this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data temuan');
		}
//		var_dump($update);
		redirect('Laporan_Abnormal');
	}


}
