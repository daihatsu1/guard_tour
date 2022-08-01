<?php

class Mst_Site extends CI_Controller
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
    }

    public function index()
    {
        $id_wil_user = $this->session->userdata("site_id");
        $data = [
            'link'           => $this->uri->segment(2),
            'wilayah'        => $this->M_admin->showWilayah($id_wil_user),
        ];
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_site", $data);
        $this->load->view("template/admin/footer");
    }


    public function form_add()
    {
        $data = [
            'link'           => $this->uri->segment(1),
            "company"        => $this->M_admin->ambilData("admisecsgp_mstcmp", ['status' => 1])
        ];
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_site", $data);
        $this->load->view("template/admin/footer");
    }


    public function input()
    {
        $comp_id        = $this->input->post("comp_id");
        $site_name      = $this->input->post("site_name");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");

        $data = [
            'admisecsgp_mstcmp_id'       => $comp_id,
            'site_name'                  => strtoupper($site_name),
            'others'                     => $others,
            'created_at'                 => date('Y-m-d H:i:s'),
            'created_by'                 => $this->session->userdata('id_token'),
            'status'                     => $status
        ];
        $cekname = $this->db->get_where("admisecsgp_mstsite", ['site_name' => $site_name]);
        if ($cekname->num_rows() > 0) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> nama ' . $site_name . ' sudah ada di database ');
            redirect('Mst_Site');
        } else {

            $save = $this->M_admin->inputData($data, "admisecsgp_mstsite");
            if ($save) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Admin/Mst_Site');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal tambah data');
                redirect('Admin/Mst_Site');
            }
        }
    }

    public function edit()
    {
        $id =  $this->input->get('site_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_admin->detailWilayah($id)->row(),
            "company"    => $this->M_admin->ambilData("admisecsgp_mstcmp")
        ];
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_site", $data);
        $this->load->view("template/admin/footer");
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_admin->delete("admisecsgp_mstsite", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Site');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Admin/Mst_Site');
        }
    }


    public function update()
    {
        $id             = $this->input->post("id");
        $comp_id        = $this->input->post("comp_id");
        $site_name      = $this->input->post("site_name");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");
        $data = [
            'admisecsgp_mstcmp_id'      => $comp_id,
            'site_name'                 => strtoupper($site_name),
            'others'                    => $others,
            'updated_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => $this->session->userdata('id_token'),
            'status'                    => $status
        ];

        $where = ['id' => $id];
        $update = $this->M_admin->update("admisecsgp_mstsite", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Site');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Site');
        }
    }
}
