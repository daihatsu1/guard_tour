<?php

class Mst_Kategori_Object extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $id = $this->session->userdata('id_token');
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
            'link'          => $this->uri->segment(2),
            // 'kategori_obj'  => $this->M_admin->kategoriObjek($id_wil_user)
            'kategori_obj'  => $this->M_admin->ambilData("admisecsgp_mstkobj")
        ];
        // $this->template->load("template/template", "mst_kategori_object", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_kategori_object", $data);
        $this->load->view("template/admin/footer");
    }

    public function form_add()
    {
        $id_wil_user = $this->session->userdata("site_id");
        $data = [
            'link'       => $this->uri->segment(2),
            'plant'      => $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user])
        ];
        // $this->template->load("template/template", "add_mst_kategori_objek", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_kategori_objek", $data);
        $this->load->view("template/admin/footer");
    }


    public function input()
    {
        $status               = $this->input->post("status");
        $others               = $this->input->post("others");
        $kategori_name        = $this->input->post("kategori_name");

        $id                   = 'ADMKO' . substr(uniqid(rand(), true), 4, 4);
        $data = [
            'kategori_id'                 => $id,
            'status'                      => $status,
            'others'                      => $others,
            'kategori_name'               => strtoupper($kategori_name),
            'created_at'                  => date('Y-m-d H:i:s'),
            'created_by'                  => $this->session->userdata('id_token'),
        ];

        $cek = $this->db->get_where("admisecsgp_mstkobj", ['kategori_name' => $kategori_name])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', 'nama ' . $kategori_name . ' sudah ada');
            redirect('Admin/Mst_Kategori_Object');
        } else {
            $input = $this->M_admin->inputData($data, "admisecsgp_mstkobj");
            if ($input) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Admin/Mst_Kategori_Object');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
                redirect('Admin/Mst_Kategori_Object');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['kategori_id' => $id];
        $del = $this->M_admin->delete("admisecsgp_mstkobj", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Kategori_Object');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Admin/Mst_Kategori_Object');
        }
    }

    //multiple delete
    public function multipleDelete()
    {
        $id_kategori = $this->input->post("id_kategori", true);
        $delete = $this->M_admin->multiple_delete("admisecsgp_mstkobj", $id_kategori);

        if ($delete) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Kategori_Object');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Admin/Mst_Kategori_Object');
        }
    }

    public function edit()
    {
        $id         =  $this->input->get('kategori_id');
        $zona_id    = $this->input->get('zona_id');
        $plant_id   = $this->input->get('plant_id');
        $id_wil_user = $this->session->userdata("site_id");
        $data = [
            'link'       => $this->uri->segment(2),
            'data'       => $this->M_admin->detailkategoriObjek($id)->row(),
            'zone'       => $this->M_admin->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $plant_id]),
            'plant'      => $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user]),
            'zona_id'    => $zona_id,
            'plant_id'   => $plant_id
        ];
        // $this->template->load("template/template", "edit_mst_kategori_objek", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_kategori_objek", $data);
        $this->load->view("template/admin/footer");
    }

    public function update()
    {
        $id                   = $this->input->post("id");
        $status               = $this->input->post("status");
        $others               = $this->input->post("others");
        $kategori_name        = $this->input->post("kategori_name");
        $data = [
            'kategori_name'             => strtoupper($kategori_name),
            'updated_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => $this->session->userdata('id_token'),
            'status'                    => $status,
            'others'                    => $others,
        ];

        $where  = ['kategori_id' => $id];
        $update = $this->M_admin->update("admisecsgp_mstkobj", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Kategori_Object');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Kategori_Object');
        }
    }
}
