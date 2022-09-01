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
        if ($role != "SUPERADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'          => $this->uri->segment(1),
            'company'       => $this->M_patrol->ambilData("admisecsgp_mstcmp"),
            'wilayah'       => $this->M_patrol->ambilData("admisecsgp_mstsite"),
            'plant'         => $this->M_patrol->showPlant(),
        ];
        // $this->template->load("template/template", "mst_plant", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_plant", $data);
        $this->load->view("template/footer");
    }

    public function form_add()
    {
        $data = [
            'link'       => $this->uri->segment(1),
            "company"        => $this->M_patrol->ambilData("admisecsgp_mstcmp", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_plant", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_plant", $data);
        $this->load->view("template/footer");
    }


    public function showWilayah()
    {
        $id = $this->input->post('id');
        $data = [
            'wilayah'  =>  $this->M_patrol->ambilData("admisecsgp_mstsite", ['admisecsgp_mstcmp_company_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_wilayah', $data);
    }

    public function edit()
    {
        $id =  $this->input->get('plant_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailPlant($id)->row(),
            "company"    => $this->M_patrol->ambilData("admisecsgp_mstcmp")
        ];
        // $this->template->load("template/template", "edit_mst_plant", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_plant", $data);
        $this->load->view("template/footer");
    }

    public function input()
    {
        $site_id         = $this->input->post("site_id");
        $plant_name      = $this->input->post("plant_name");
        $status          = $this->input->post("status");
        $kodeplant       = $this->input->post("kodeplant");
        $others          = $this->input->post("others");
        $id              = 'ADMP' . substr(uniqid(rand(), true), 4, 4);
        $data = [
            'plant_id'                    => $id,
            'admisecsgp_mstsite_site_id'  => $site_id,
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

            $save =  $this->M_patrol->inputData($data, "admisecsgp_mstplant");
            if ($save) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil menambah data');
                redirect('Mst_Plant');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menambah data');
                redirect('Mst_Plant');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['plant_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstplant", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Plant');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i>  Gagal hapus plant');
            redirect('Mst_Plant');
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
            'admisecsgp_mstsite_site_id'        => $site_id,
            'plant_name'                        => strtoupper($plant_name),
            'kode_plant'                        => strtoupper($kodeplant),
            'updated_at'                        => date('Y-m-d H:i:s'),
            'updated_by'                        => $this->session->userdata('id_token'),
            'status'                            => $status,
            'others'                            => $others,
        ];

        $where = ['plant_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstplant", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Plant');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Plant');
        }
    }
}
