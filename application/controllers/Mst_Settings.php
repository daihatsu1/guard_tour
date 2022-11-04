<?php

class Mst_Settings extends CI_Controller
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
			'link' => $this->uri->segment(1),
			'settings' => $this->M_patrol->ambilData('admisecsgp_setting')
		];
		$this->load->view("template/sidebar", $data);
		$this->load->view("settings/view", $data);
		$this->load->view("template/footer");
	}


	public function edit()
	{
		$id = $this->input->get('id_setting');
		$data = [
			'link' => $this->uri->segment(1),
			'data' => $this->M_patrol->ambilData('admisecsgp_setting', 'id_setting=' . $id)->row()
		];
		$this->load->view("template/sidebar", $data);
		$this->load->view("settings/edit", $data);
		$this->load->view("template/footer");
	}


	public function update()
	{
		$id = $this->input->post("id");
		$namaSetting = $this->input->post("nama_setting");
		$nilaiSetting = $this->input->post("nilai_setting");
		$type = $this->input->post("type");
		$unit = $this->input->post("unit");
		$data = [
			'nama_setting' => $namaSetting,
			'nilai_setting' => $nilaiSetting,
			'type' => $type,
			'unit' => $unit,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id_token'),
		];

		$where = ['id_setting' => $id];
		$update = $this->M_patrol->update("admisecsgp_setting", $data, $where);
		if ($update) {
			$this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
			redirect('Mst_Settings');
		} else {
			$this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
			redirect('Mst_Settings');
		}
	}



}
