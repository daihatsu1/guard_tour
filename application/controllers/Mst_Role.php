<?php
class Mst_Role extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        if ($id = null || $id = "") {
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
            'role'          => $this->M_patrol->ambilData("admisecsgp_mstroleusr"),
        ];
        // $this->template->load("template/template", "mst_role", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_role", $data);
        $this->load->view("template/footer");
    }


    public function form_add()
    {
        $data = [
            'link'           => $this->uri->segment(1),
        ];
        // $this->template->load("template/template", "add_mst_role", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_role", $data);
        $this->load->view("template/footer");
    }

    public function input()
    {
        $id_role        = 'ADMRL' . substr(uniqid(rand(), true), 4, 4);
        $level          = strtoupper($this->input->post("level"));
        $status         = $this->input->post("status");

        $cek2 = $this->db->get_where("admisecsgp_mstroleusr", ['level' => $level])->num_rows();
        if ($cek2 >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> level ' . $level . ' sudah digunakan ');
            redirect('Mst_Role');
        } else {
            $data = [
                'role_id'            => $id_role,
                'level'              => $level,
                'status'             => $status,
                'created_at'         => date('Y-m-d H:i:s'),
                'created_by'         => $this->session->userdata('id_token'),
            ];
            $this->M_patrol->inputData($data, "admisecsgp_mstroleusr");
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Mst_Role');
        }
    }


    public function hapus($id)
    {
        $where = ['role_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstroleusr", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Role');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Role');
        }
    }
    public function edit()
    {
        $id =  $this->input->get('role_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->ambilData("admisecsgp_mstroleusr", ['role_id' => $id])->row(),
        ];
        // $this->template->load("template/template", "edit_mst_role", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_role", $data);
        $this->load->view("template/footer");
    }

    public function update()
    {
        $id             = $this->input->post("id");
        $level          = strtoupper($this->input->post("level"));
        $status         = $this->input->post("status");
        $data = [
            'status'             => $status,
            'level'              => $level
        ];

        $where = ['role_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstroleusr", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Role');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Role');
        }
    }
}
