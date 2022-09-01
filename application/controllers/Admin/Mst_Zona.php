<?php

class Mst_Zona extends CI_Controller
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
        $id_plt_user = $this->session->userdata("plant_id");
        $data = [
            'link'   => $this->uri->segment(2),
            'zona'   => $this->M_admin->showZona($id_wil_user),
            'plant'  => $this->M_admin->ambilData("admisecsgp_mstplant"),
        ];
        // $this->template->load("template/template", "mst_zona", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_zona", $data);
        $this->load->view("template/admin/footer");
    }

    public function form_add()
    {
        $id_wil_user = $this->session->userdata("site_id");
        $id_plt_user = $this->session->userdata("plant_id");
        $data = [
            'link'       => $this->uri->segment(2),
            "wilayah"    => $this->M_admin->ambilData("admisecsgp_mstsite", ['status' => 1, 'site_id' => $id_wil_user])
        ];
        // $this->template->load("template/template", "add_mst_zone", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_zone", $data);
        $this->load->view("template/admin/footer");
    }


    public function showPlant(Type $var = null)
    {
        $id = $this->input->post('id');
        $data = [
            'plant'  =>  $this->M_admin->ambilData("admisecsgp_mstplant", ['admisecsgp_mstsite_site_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_plant', $data);
    }


    public function input()
    {
        $zone_name      = $this->input->post("zone_name");
        $kode_zona      = $this->input->post("kode_zona");
        $plant_id       = $this->input->post("plant_id");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");
        $id             = 'ADMZ' . substr(uniqid(rand(), true), 4, 4);
        $data = [
            'zone_id'                       => $id,
            'admisecsgp_mstplant_plant_id'  => $plant_id,
            'zone_name'                     => strtoupper($zone_name),
            'kode_zona'                     => strtoupper($kode_zona),
            'others'                        => $others,
            'status'                        => $status,
            'created_at'                    => date('Y-m-d H:i:s'),
            'created_by'                    => $this->session->userdata('id_token'),
        ];
        $cari = $this->db->get_where("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $plant_id, 'zone_name' => $zone_name]);
        $cariKode = $this->db->get_where("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $plant_id, 'kode_zona' => $kode_zona]);
        if ($cari->num_rows() > 0) {
            $plant = $this->db->get_where("admisecsgp_mstplant", ['plant_id' => $plant_id])->row();
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> ' . $zone_name . ' sudah ada di ' . $plant->plant_name . ' ');
            redirect('Admin/Mst_Zona');
        } else  if ($cariKode->num_rows() > 0) {
            $plant = $this->db->get_where("admisecsgp_mstplant", ['plant_id' => $plant_id])->row();
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> ' . $kode_zona . ' sudah ada di ' . $plant->plant_name . ' ');
            redirect('Admin/Mst_Zona');
        } else {
            $save = $this->M_admin->inputData($data, "admisecsgp_mstzone");
            if ($save) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil  menambah data');
                redirect('Admin/Mst_Zona');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menambah data');
                redirect('Admin/Mst_Zona');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['zone_id' => $id];
        $del = $this->M_admin->delete("admisecsgp_mstzone", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Zona');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Admin/Mst_Zona');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('zone_id');
        $id_wil_user = $this->session->userdata("site_id");
        $id_plt_user = $this->session->userdata("plant_id");
        $data = [
            'link'       => $this->uri->segment(2),
            'data'       => $this->M_admin->detailZona($id)->row(),
            "plant"      => $this->M_admin->ambilData("admisecsgp_mstplant"),
            "wilayah"    => $this->M_admin->ambilData("admisecsgp_mstsite", ['status' => 1, 'site_id' => $id_wil_user]),
        ];
        // $this->template->load("template/template", "edit_mst_zona", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_zona", $data);
        $this->load->view("template/admin/footer");
    }

    public function update()
    {
        $id          = $this->input->post("id");
        $plantid     = $this->input->post("plant_id");
        $zone_name   = strtoupper($this->input->post("zone_name"));
        $kode_zona   = strtoupper($this->input->post("kode_zona"));
        $others      = $this->input->post("others");
        $status      = $this->input->post("status");
        $data = [
            'admisecsgp_mstplant_plant_id'    => $plantid,
            'zone_name'                 => $zone_name,
            'kode_zona'                 => $kode_zona,
            'others'                    => $others,
            'status'                    => $status,
            'updated_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => $this->session->userdata('id_token'),
        ];

        $where = ['zone_id' => $id];
        $update = $this->M_admin->update("admisecsgp_mstzone", $data, $where);

        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Zona');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Zona');
        }
    }
}
