<?php
date_default_timezone_set('Asia/Jakarta');
class Mst_Plant extends CI_Controller
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
            'link'          => $this->uri->segment(2),
            'company'       => $this->M_admin->ambilData("admisecsgp_mstcmp"),
            'wilayah'       => $this->M_admin->ambilData("admisecsgp_mstsite"),
            'plant'         => $this->M_admin->showPlant($id_wil_user),
        ];
        // $this->template->load("template/template", "mst_plant", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_plant", $data);
        $this->load->view("template/admin/footer");
    }

    public function form_add()
    {

        $data = [
            'link'       => $this->uri->segment(2),
            "company"        => $this->M_admin->ambilData("admisecsgp_mstcmp", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_plant", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_plant", $data);
        $this->load->view("template/admin/footer");
    }


    public function showWilayah()
    {
        $id = $this->input->post('id');
        $data = [
            'wilayah'  =>  $this->M_admin->ambilData("admisecsgp_mstsite", ['admisecsgp_mstcmp_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_wilayah', $data);
    }

    public function edit()
    {
        $id =  $this->input->get('plant_id');
        $data = [
            'link'       => $this->uri->segment(2),
            'data'       => $this->M_admin->detailPlant($id)->row(),
            "company"    => $this->M_admin->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "edit_mst_plant", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_plant", $data);
        $this->load->view("template/admin/footer");
    }

    public function input()
    {
        $site_id         = $this->input->post("site_id");
        $plant_name      = $this->input->post("plant_name");
        $status          = $this->input->post("status");
        $kodeplant       = $this->input->post("kodeplant");
        $others          = $this->input->post("others");

        $data = [
            'admisecsgp_mstsite_id'       => $site_id,
            'plant_name'                  => strtoupper($plant_name),
            'kode_plant'                  => strtoupper($kodeplant),
            'created_at'                  => date('Y-m-d H:i:s'),
            'created_by'                  => $this->session->userdata('id_token'),
            'status'                      => $status,
            'others'                      => $others,
        ];
        $cekid = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $kodeplant]);
        if ($cekid->num_rows() > 0) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Kode ' . $kodeplant . ' sudah di gunakan ');
        } else {

            $save =  $this->M_admin->inputData($data, "admisecsgp_mstplant");
            if ($save) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil menambah data');
                redirect('Admin/Mst_Plant');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menambah data');
                redirect('Admin/Mst_Plant');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_admin->delete("admisecsgp_mstplant", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Plant');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i>  Gagal hapus plant');
            redirect('Admin/Mst_Plant');
        }
    }


    public function update()
    {
        $id              = $this->input->post("plant_id");
        $site_id         = $this->input->post("site_id");
        $plant_name      = $this->input->post("plant_name");
        $status          = $this->input->post("status");
        $kodeplant       = $this->input->post("kodeplant");
        $others          = $this->input->post("others");
        $data = [
            'admisecsgp_mstsite_id'        => $site_id,
            'plant_name'                   => strtoupper($plant_name),
            'kode_plant'                   => strtoupper($kodeplant),
            'updated_at'                   => date('Y-m-d H:i:s'),
            'updated_by'                   => $this->session->userdata('id_token'),
            'status'                       => $status,
            'others'                       => $others,
        ];

        $where = ['id' => $id];
        $update = $this->M_admin->update("admisecsgp_mstplant", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Plant');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Plant');
        }
    }
}
