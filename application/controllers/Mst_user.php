<?php

class Mst_user extends CI_Controller
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
            'user'          => $this->M_patrol->showUser(),
            'role'          => $this->M_patrol->ambilData("admisecsgp_mstroleusr"),
            'company'       => $this->M_patrol->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "mst_user", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_user", $data);
        $this->load->view("template/footer");
    }

    public function form_add()
    {
        $data = [
            'link'       => $this->uri->segment(1),
            "wilayah"    => $this->M_patrol->ambilData("admisecsgp_mstsite", ['status' => 1]),
            'role'       => $this->M_patrol->ambilData("admisecsgp_mstroleusr", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_user", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_user", $data);
        $this->load->view("template/footer");
    }

    public function input()
    {
        $npk            = $this->input->post("npk");
        $name           = $this->input->post("nama");
        $id_role        = $this->input->post("level");
        $id_site        = $this->input->post("site_id");
        $id_plant       = $this->input->post("plant_id");
        $status         = $this->input->post("status");
        $password       = md5($this->input->post("password"));


        $cek = $this->db->get_where("admisecsgp_mstusr", ['npk' => $npk])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> npk ' . $npk . ' sudah terdaftar ');
            redirect('Mst_user');
        } else {
            $cari_company   = $this->db->query("select id , admisecsgp_mstcmp_id from admisecsgp_mstsite where id='" . $id_site  . "'")->row();
            $id_comp = $cari_company->admisecsgp_mstcmp_id;
            $data = [
                'npk'                        => $npk,
                'name'                       => $name,
                'admisecsgp_mstroleusr_id'   => $id_role,
                'admisecsgp_mstsite_id'      => $id_site,
                'admisecsgp_mstplant_id'     => $id_plant,
                'admisecsgp_mstcmp_id'       => $id_comp,
                'password'                   => $password,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
                'status'                     => $status
            ];
            $this->M_patrol->inputData($data, "admisecsgp_mstusr");
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Mst_user');
        }
    }




    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstusr", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_user');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_user');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('user_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailUser($id)->row(),
            "plant"      => $this->M_patrol->ambilData("admisecsgp_mstplant"),
            "wilayah"    => $this->M_patrol->ambilData("admisecsgp_mstsite"),
            'role'          => $this->M_patrol->ambilData("admisecsgp_mstroleusr"),
        ];
        // $this->template->load("template/template", "edit_mst_user", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_user", $data);
        $this->load->view("template/footer");
    }


    public function update()
    {
        $id             = $this->input->post("id");
        $npk            = $this->input->post("npk");
        $name           = $this->input->post("nama");
        $id_role        = $this->input->post("level");
        $id_site        = $this->input->post("site_id");
        $id_plant       = $this->input->post("plant_id");
        $status         = $this->input->post("status");

        $cari_company   = $this->db->query("select id , admisecsgp_mstcmp_id from admisecsgp_mstsite where id='" .  $id_site . "'")->row();
        $id_comp = $cari_company->admisecsgp_mstcmp_id;
        $data = [
            'npk'                        => $npk,
            'name'                       => $name,
            'admisecsgp_mstroleusr_id'   => $id_role,
            'admisecsgp_mstsite_id'      => $id_site,
            'admisecsgp_mstplant_id'     => $id_plant,
            'admisecsgp_mstcmp_id'       => $id_comp,
            'updated_at'                 => date('Y-m-d H:i:s'),
            'updated_by'                 => $this->session->userdata('id_token'),
            'status'                     => $status
        ];

        $where = ['id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstusr", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_user');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_user');
        }
    }


    public function edit_pwd()
    {
        $id =  $this->input->get('user_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailUser($id)->row(),
        ];
        // $this->template->load("template/template", "edit_pwd_user", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_pwd_user", $data);
        $this->load->view("template/footer");
    }

    public function resetPasword()
    {
        $password   = md5($this->input->post("password"));
        $id         = $this->input->post("id");
        $data = [
            'password'    => $password,
        ];

        $where = ['id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstusr", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update password');
            redirect('Mst_user');
        } else {
            $this->session->set_flashdata('info', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update password');
            redirect('Mst_user');
        }
    }
}
