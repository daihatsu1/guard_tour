<?php

class Mst_Shift extends CI_Controller
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
            'link'          => $this->uri->segment(1),
            'shift'         => $this->M_patrol->showShift()
            // 'shift'         => $this->M_patrol->ambilData("admisecsgp_mstshift")
        ];
        // $this->template->load("template/template", "mst_shift", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_shift", $data);
        $this->load->view("template/footer");
    }

    public function form_add(Type $var = null)
    {
        $data = [
            'link'          => $this->uri->segment(1),
        ];
        // $this->template->load("template/template", "add_mst_shift", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_shift", $data);
        $this->load->view("template/footer");
    }


    public function input()
    {
        $status            = $this->input->post("status");
        $shift             = $this->input->post("shift");
        $jam_masuk         = $this->input->post("jam_masuk");
        $jam_pulang        = $this->input->post("jam_pulang");
        $id                   = 'ADMSH' . substr(uniqid(rand(), true), 4, 4);

        $data = [
            'shift_id'         => $id,
            'status'           => $status,
            'nama_shift'       => $shift,
            'jam_masuk'        => $jam_masuk,
            'jam_pulang'       => $jam_pulang,
            'created_at'       => date('Y-m-d H:i:s'),
            'created_by'       => $this->session->userdata('id_token'),
        ];

        $cek = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $shift])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> shift ' . $shift . ' sudah ada');
            redirect('Mst_Shift');
        } else {
            $input = $this->M_patrol->inputData($data, "admisecsgp_mstshift");
            if ($input) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Mst_Shift');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
                redirect('Mst_Shift');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['shift_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstshift", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Shift');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Shift');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('shift_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->showShiftDetail($id)->row()

        ];
        // $this->template->load("template/template", "edit_mst_shift", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_shift", $data);
        $this->load->view("template/footer");
    }


    public function update()
    {
        $id                = $this->input->post("id");
        $status            = $this->input->post("status");
        $shift             = $this->input->post("shift");
        $jam_masuk         = $this->input->post("jam_masuk");
        $jam_pulang        = $this->input->post("jam_pulang");
        $data = [
            'status'             => $status,
            'nama_shift'         => $shift,
            'jam_masuk'          => $jam_masuk,
            'jam_pulang'         => $jam_pulang,
            'updated_at'         => date('Y-m-d H:i:s'),
            'updated_by'         => $this->session->userdata('id_token'),
        ];

        $where = ['shift_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstshift", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Shift');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Shift');
        }
    }
}
