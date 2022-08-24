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
        if ($role != "SUPERADMIN") {
            redirect('Login');
        }
    }

    public function index()
    {
        $data = [
            'link'          => $this->uri->segment(1),
            'event'         => $this->M_patrol->showEvent(),
        ];
        // $this->template->load("template/template", "mst_event", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_event", $data);
        $this->load->view("template/footer");
    }


    public function show_kategori(Type $var = null)
    {
        $idzona = $this->input->post("zone_id");
        $kategori    = $this->db->query("SELECT id ,kategori_name from admisecsgp_mstkobj WHERE admisecsgp_mstzone_id = '" . $idzona . "'   and  status = 1 ");
        echo json_encode($kategori->result_array());
    }

    public function form_add(Type $var = null)
    {

        $data = [
            'link'          => $this->uri->segment(1),
            'kategori'      => $this->M_patrol->ambilData('admisecsgp_mstkobj', ['status'    => 1]),
            'plant'         => $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_event", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_event", $data);
        $this->load->view("template/footer");
    }


    public function input()
    {
        $status            = $this->input->post("status");
        $event_name        = $this->input->post("event_name");
        $kategori_id       = $this->input->post("kategori_id");


        $d = explode(";", $event_name);
        $params = array();
        for ($i = 0; $i < count($d) - 1; $i++) {
            $id                   = 'ADMEV' . substr(uniqid(rand(), true), 4, 4);
            $ev_name = $d[$i];
            $data = [
                'event_id'                       => $id,
                'status'                         => $status,
                'event_name'                     => strtoupper($ev_name),
                'admisecsgp_mstkobj_kategori_id' => $kategori_id,
                'created_at'                     => date('Y-m-d H:i:s'),
                'created_by'                     => $this->session->userdata('id_token'),
            ];
            array_push($params, $data);
        }

        $upload = $this->M_patrol->mulitple_upload("admisecsgp_mstevent", $params);
        if ($upload) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Mst_Event');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
            redirect('Mst_Event');
        }
        // $cek = $this->db->get_where("admisecsgp_mstevent", ['event_name' => $event_name])->num_rows();
        // if ($cek >= 1) {
        //     $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> nama ' . $event_name . ' ini sudah digunakan');
        //     redirect('Mst_Event');
        // } 
    }


    public function hapus($id)
    {
        $where = ['event_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstevent", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Event');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_Event');
        }
    }

    public function edit()
    {
        $id             =  $this->input->get('event_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailEvent($id)->row(),
            'kategori_objek'       => $this->M_patrol->ambilData("admisecsgp_mstkobj", ['status' => 1]),
        ];
        // $this->template->load("template/template", "edit_mst_event", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_event", $data);
        $this->load->view("template/footer");
    }


    public function update()
    {
        $id                 = $this->input->post("id");
        $event_name         = $this->input->post("event_name");
        $status             = $this->input->post("status");
        $kategori_id       = $this->input->post("kategori_id");
        $data = [
            'event_name'                     => strtoupper($event_name),
            'status'                         => $status,
            'admisecsgp_mstkobj_kategori_id' => $kategori_id,
            'updated_at'                     => date('Y-m-d H:i:s'),
            'updated_by'                     => $this->session->userdata('id_token'),
        ];

        $where = ['event_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstevent", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Event');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Event');
        }
    }
}
