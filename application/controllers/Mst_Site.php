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
        if ($role != "SUPERADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'           => $this->uri->segment(1),
            'wilayah'        => $this->M_patrol->showWilayah(),
        ];
        // $this->template->load("template/template", "mst_site", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_site", $data);
        $this->load->view("template/footer");
    }


    public function form_add()
    {
        $data = [
            'link'           => $this->uri->segment(1),
            "company"        => $this->M_patrol->ambilData("admisecsgp_mstcmp", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_site", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_site", $data);
        $this->load->view("template/footer");
    }


    public function input()
    {
        $comp_id        = $this->input->post("comp_id");
        $site_name      = $this->input->post("site_name");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");

        $data = [
            'site_id'                           => 'ADMWIL' . substr(uniqid(rand(), true), 4, 4),
            'admisecsgp_mstcmp_company_id'      => $comp_id,
            'site_name'                         => strtoupper($site_name),
            'others'                            => $others,
            'created_at'                        => date('Y-m-d H:i:s'),
            'created_by'                        => $this->session->userdata('id_token'),
            'status'                            => $status
        ];
        $cekname = $this->db->get_where("admisecsgp_mstsite", ['site_name' => $site_name]);
        if ($cekname->num_rows() > 0) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> nama ' . $site_name . ' sudah ada di database ');
            redirect('Mst_Site');
        } else {

            $save = $this->M_patrol->inputData($data, "admisecsgp_mstsite");
            if ($save) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Mst_Site');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal tambah data');
                redirect('Mst_Site');
            }
        }
    }

    public function edit()
    {
        $id =  $this->input->get('site_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailWilayah($id)->row(),
            "company"    => $this->M_patrol->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "edit_mst_site", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_site", $data);
        $this->load->view("template/footer");
    }


    public function hapus($id)
    {
        $where = ['site_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstsite", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Site');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Site');
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
            'admisecsgp_mstcmp_company_id'      => $comp_id,
            'site_name'                         => strtoupper($site_name),
            'others'                            => $others,
            'updated_at'                        => date('Y-m-d H:i:s'),
            'updated_by'                        => $this->session->userdata('id_token'),
            'status'                            => $status
        ];

        $where = ['site_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstsite", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Site');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Site');
        }
    }
}
