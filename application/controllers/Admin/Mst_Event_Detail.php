<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require FCPATH . 'vendor/autoload.php';
class Mst_Event_Detail extends CI_Controller
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
        $id_wil_user  = $this->session->userdata("site_id");
        $data = [
            'link'          => $this->uri->segment(2),
            'event'         => $this->M_admin->showEvent($id_wil_user)
        ];
        // $this->template->load("template/template", "mst_event_Detail", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_event_detail", $data);
        $this->load->view("template/admin/footer");
    }


    public function show_checkpoint(Type $var = null)
    {
        $idzona             = $this->input->post("zone_id");
        $checkpoint         = $this->db->query("SELECT id ,check_name from admisecsgp_mstckp WHERE admisecsgp_mstzone_id = '" . $idzona . "'   and  status = 1 ");
        echo json_encode($checkpoint->result_array());
    }

    public function show_objek(Type $var = null)
    {
        $idckp             = $this->input->post("check_id");
        $objek         = $this->db->query("SELECT id ,nama_objek from admisecsgp_mstobj WHERE admisecsgp_mstckp_id = '" . $idckp . "'   and  status = 1 ");
        echo json_encode($objek->result_array());
    }

    public function form_add(Type $var = null)
    {
        $id_wil_user  = $this->session->userdata("site_id");
        $data = [
            'link'          => $this->uri->segment(2),
            'plant'         => $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $id_wil_user]),
            'event'         => $this->M_admin->ambilData("admisecsgp_mstevent", ['status' => 1]),
        ];
        // $this->template->load("template/template", "add_mst_event_Detail", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/add_mst_event_detail", $data);
        $this->load->view("template/admin/footer");
    }


    public function input()
    {
        $status            = $this->input->post("status");
        $event             = $this->input->post("event_id");
        $objek             = $this->input->post("objek_id");


        $data = array();
        for ($i = 0; $i < count($event); $i++) {
            // echo $event[$i] . "<br>";
            $data_params = [
                'status'                    => $status,
                'admisecsgp_mstobj_id'      => $objek,
                'admisecsgp_mstevent_id'    => $event[$i],
                'created_at'                => date('Y-m-d H:i:s'),
                'created_by'                => $this->session->userdata('id_token'),
            ];

            array_push($data, $data_params);
        }

        $input = $this->M_admin->mulitple_upload("admisecsgp_msteventdtls", $data);

        if ($input) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Admin/Mst_Event_Detail');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
            redirect('Admin/Mst_Event_Detail');
        }
    }


    public function hapus($id)
    {
        $where = ['id' => $id];
        $del = $this->M_admin->delete("admisecsgp_msteventdtls", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Event_Detail');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Admin/Mst_Event_Detail');
        }
    }

    public function edit()
    {
        $id_wil_user    = $this->session->userdata("site_id");
        $id             =  $this->input->get('event_id');
        $zona_id        =  $this->input->get('zona_id');
        $plant_id       =  $this->input->get('plant_id');
        $check_id       =  $this->input->get('check_id');
        $data = [
            'link'       => $this->uri->segment(2),
            'data'       => $this->M_admin->detailEvent($id)->row(),
            'plant'      => $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1]),
            'zona'       => $this->M_admin->ambilData("admisecsgp_mstzone", ['status' => 1, 'admisecsgp_mstplant_id' => $plant_id]),
            'check'      => $this->M_admin->ambilData("admisecsgp_mstckp", ['status' => 1, 'admisecsgp_mstzone_id' => $zona_id]),
            'objek'      => $this->M_admin->ambilData("admisecsgp_mstobj", ['status' => 1, 'admisecsgp_mstckp_id' => $check_id]),
            'event'      => $this->M_admin->ambilData("admisecsgp_mstevent", ['status' => 1]),
            'zona_id'    => $zona_id,
            'plant_id'   => $plant_id,
            'check_id'   => $check_id
        ];
        // $this->template->load("template/template", "edit_mst_event_Detail", $data);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/edit_mst_event_detail", $data);
        $this->load->view("template/admin/footer");
    }


    public function update()
    {
        $id                 = $this->input->post("id");
        $event              = $this->input->post("event_id");
        $objek              = $this->input->post("objek_id");
        $status             = $this->input->post("status");
        $data = [
            'status'                    => $status,
            'admisecsgp_mstobj_id'      => $objek,
            'admisecsgp_mstevent_id'    => $event,
            'updated_at'                => date('Y-m-d H:i:s'),
            'updated_by'                => $this->session->userdata('id_token'),
        ];

        $where = ['id' => $id];
        $update = $this->M_admin->update("admisecsgp_msteventdtls", $data, $where);
        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Admin/Mst_Event_Detail');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Admin/Mst_Event_Detail');
        }
    }

    public function form_upload_event_detail()
    {
        $filename = "upload_event_detail_" . $this->session->flashdata('id_token');
        $data['plant_kode_input'] = "";
        if (isset($_POST['view'])) {
            $upload = $this->M_admin->uploadCheckpoint($filename);
            if ($upload['result'] == "success") {
                $path_xlsx = "./assets/path_upload/" . $filename . ".xlsx";
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path_xlsx);
                $d = $spreadsheet->getSheet(0)->toArray();
                unset($d[0]);
                $data['sheet'] = $d;
                $data['plant_kode_input'] = $this->input->post("plant_id");
            } else {
                $e = $upload['error'];
                $data['upload_error'] = $e;
            }
        }

        $data['link'] = $this->uri->segment(2);
        $data["plant"]      = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $this->session->userdata('site_id')]);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/upload_mst_event_detail", $data);
        $this->load->view("template/admin/footer");
    }

    public function upload_event()
    {
        $filename = "upload_event_detail_" . $this->session->flashdata('id_token');
        $path_xlsx = "./assets/path_upload/" . $filename . ".xlsx";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path_xlsx);
        $d = $spreadsheet->getSheet(0)->toArray();
        unset($d[0]);
        $datas = array();
        foreach ($d as $t) {
            $cek_event_id = $this->db->query("select id from admisecsgp_mstevent where event_name='" . $t[6] . "'   ")->row();
            $cek_zona  = $this->db->query("select id from admisecsgp_mstzone where kode_zona='" . $t[1] . "'   ")->row();
            $cekpoint  = $this->db->query("select id from admisecsgp_mstckp where check_name='" . $t[3] . "' and admisecsgp_mstzone_id ='" . $cek_zona->id . "'  ")->row();
            $cek_objek_id = $this->db->query("select id from admisecsgp_mstobj where nama_objek='" . $t[5] . "' and admisecsgp_mstckp_id = '" . $cekpoint->id . "'  ")->row();
            $params = [
                'admisecsgp_mstobj_id'       => $cek_objek_id->id,
                'admisecsgp_mstevent_id'     => $cek_event_id->id,
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
            ];

            array_push($datas, $params);
        }
        $table = "admisecsgp_msteventdtls";
        $upload  = $this->M_admin->mulitple_upload($table, $datas);
        if ($upload) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Admin/Mst_Event_Detail');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Admin/Mst_Event_Detail/form_upload_event_detail');
        }
    }


    //multiple delete
    public function multipleDelete()
    {
        $id_event = $this->input->post("id_event", true);
        $delete = $this->M_admin->multiple_delete("admisecsgp_msteventdtls", $id_event);

        if ($delete) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Admin/Mst_Event_Detail');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Admin/Mst_Event_Detail/form_upload_event_detail');
        }
    }
}
