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
		if ($role != "ADMIN") {
			redirect('Login');
		}
		$this->load->model(['M_LaporanTemuan']);
	}

	public function index()
	{
		$dataTemuan = $this->M_LaporanTemuan->getTotalTemuan();
		$byKategoriObjek = $this->M_LaporanTemuan->getTotalTemuanByKategoriObject($this->session->userdata('plant_id'), date('m'), date('Y'));

		$sidebarData = [
			'link' => $this->uri->segment(2),
		];
		$data = [
			'by_kategori_objek' => $byKategoriObjek,
			'data_temuan' => $dataTemuan
		];
		$this->load->view("template/admin/sidebar", $sidebarData);
		$this->load->view("Admin/laporan/laporan_abnormal", $data);
		$this->load->view("template/admin/footer");
	}

	public function list_temuan()
	{
		$plant_id = $this->session->userdata("site_id");
		$data = $this->M_LaporanTemuan->getDataTemuan($plant_id, 'open');
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function total_temuan()
	{
		$plant_id = $this->session->userdata("site_id");
		$data['total_temuan'] = count($this->M_LaporanTemuan->getDataTemuan($plant_id, 'open'));
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
	}

	public function list_temuan_tindakan_cepat()
	{
		$plant_id = $this->session->userdata("site_id");
		$data = $this->M_LaporanTemuan->getDataTemuanTindakanCepat($plant_id);
		return $this->output
			->set_content_type('application/json')
			->set_status_header(200)
			->set_output(json_encode($data));
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
		redirect('Admin/Laporan_Abnormal');
	}
}
