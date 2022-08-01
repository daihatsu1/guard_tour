<?php

class Mst_Event extends CI_Controller
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
            'link'          => $this->uri->segment(2),
            'event'         => $this->M_admin->ambilData("admisecsgp_mstevent", ['status' => 1])
        ];
        // $this->template->load("template/template", "mst_event", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_event", $data);
        $this->load->view("template/admin/footer");
    }

    public function show_kategori(Type $var = null)
    {
        $idzona = $this->input->post("zone_id");
        $kategori    = $this->db->query("SELECT id ,kategori_name from admisecsgp_mstkobj WHERE admisecsgp_mstzone_id = '" . $idzona . "'   and  status = 1 ");
        echo json_encode($kategori->result_array());
    }

    public function form_add(Type $var = null)
    {
        $id_wil_user = $this->session->userdata("site_id");
        $data = [
            'link'          => $this->uri->segment(2),
            'plant'         => $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $id_wil_user])
        ];
        // $this->template->load("template/template", "add_mst_event", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_event", $data);
        $this->load->view("template/admin/footer");
    }


    public function input()
    {
        $status            = $this->input->post("status");
        $event_name        = $this->input->post("event_name");

        $data = [
            'status'          => $status,
            'event_name'      => strtoupper($event_name),
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => $this->session->userdata('id_token'),
        ];

        $cek = $this->db->get_where("admisecsgp_mstevent", ['event_name' => $event_name])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> nama ' . $event_name . ' sudah digunakan');
            redirect('Admin/Mst_Event');
        } else {
            $input = $this->M_admin->inputData($data, "admisecsgp_mstevent");
            if ($input) {
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
                redirect('Admin/Mst_Event');
            } else {
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
                redirect('Admin/Mst_Event');
            }
        }
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_admin->delete("admisecsgp_mstevent", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Event');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Admin/Mst_Event');
        }
    }

    public function edit()
    {
        $id_wil_user    = $this->session->userdata("site_id");
        $id             =  $this->input->get('event_id');
        $zona_id        =  $this->input->get('zona_id');
        $plant_id       =  $this->input->get('plant_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_admin->ambilData("admisecsgp_mstevent", ['id' => $id])->row(),
            'plant'      => $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $id_wil_user]),
            'zone'       => $this->M_admin->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_id' => $plant_id]),
            'kategori_objek'       => $this->M_admin->ambilData("admisecsgp_mstkobj", ['admisecsgp_mstzone_id' => $zona_id]),
        ];
        // $this->template->load("template/template", "edit_mst_event", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_event", $data);
        $this->load->view("template/admin/footer");
    }


    public function update()
    {
        $id                 = $this->input->post("id");
        $event_name         = $this->input->post("event_name");
        $status             = $this->input->post("status");
        // $kategori_id       = $this->input->post("kategori_id");
        $data = [
            'event_name'            => strtoupper($event_name),
            'status'                => $status,
            // 'admisecsgp_mstkobj_id' => $kategori_id,
            'updated_at'            => date('Y-m-d H:i:s'),
            'updated_by'            => $this->session->userdata('id_token'),
        ];

        $where = ['id' => $id];
        $update = $this->M_admin->update("admisecsgp_mstevent", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Event');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Event');
        }
    }
}
