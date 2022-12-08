<?php

class Mst_user_ga extends CI_Controller
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
			'userGa' => $this->M_patrol->ambilData("admisecsgp_mstusr_ga"),
		];
		// $this->template->load("template/template", "mst_user", $data);
		$this->load->view("template/sidebar", $data);
		$this->load->view("mst_user_ga", $data);
		$this->load->view("template/footer");
	}

	public function form_add()
	{
		$data = [
			'link' => $this->uri->segment(1),
			'plants' => $this->M_patrol->ambilData("admisecsgp_mstplant"),
		];
		$this->load->view("template/sidebar", $data);
		$this->load->view("add_mst_user_ga", $data);
		$this->load->view("template/footer");
	}

	public function input()
	{
		$name = strtoupper($this->input->post("nama"));
		$email = $this->input->post("email");
		$type = $this->input->post("type");
		$id_plant = $this->input->post("plant_id");
		$status = $this->input->post("status");

		$data = [
			'name' => $name,
			'email' => $email,
			'type' => $type,
			'admisecsgp_mstplant_plant_id' => $id_plant,
			'status' => $status,
			'created_at' => date('Y-m-d H:i:s'),
			'created_by' => $this->session->userdata('id_token')
		];
		$this->M_patrol->inputData($data, "admisecsgp_mstusr_ga");
		$this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
		redirect('Mst_user_ga');
	}

	public function hapus($id)
	{
		$where = ['id' => $id];
		$del = $this->M_patrol->delete("admisecsgp_mstusr", $where);
		if ($del) {
			$this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
			redirect('Mst_user_ga');
		} else {
			$this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
			redirect('Mst_user_ga');
		}
	}

	public function edit()
	{
		$id = $this->input->get('id');
		$data = [
			'link' => $this->uri->segment(1),
			'data' => $this->M_patrol->ambilData('admisecsgp_mstusr_ga', ['id' => $id])->row(),
			"plants" => $this->M_patrol->ambilData("admisecsgp_mstplant"),
		];
		$this->load->view("template/sidebar", $data);
		$this->load->view("edit_mst_user_ga", $data);
		$this->load->view("template/footer");
	}


	public function update()
	{
		$id = $this->input->post("id");
		$name = strtoupper($this->input->post("nama"));
		$type = $this->input->post("type");
		$email = $this->input->post("email");
		$id_plant = $this->input->post("plant_id");
		$status = $this->input->post("status");

		$data = [
			'name' => $name,
			'email' => $email,
			'type' => $type,
			'admisecsgp_mstplant_plant_id' => $id_plant,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id_token'),
			'status' => $status
		];

		$where = ['id' => $id];
		$update = $this->M_patrol->update("admisecsgp_mstusr_ga", $data, $where);
		if ($update) {
			$this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
			redirect('Mst_user_ga');
		} else {
			$this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
			redirect('Mst_user_ga');
		}
	}

}
