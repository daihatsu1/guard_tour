<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require FCPATH . 'vendor/autoload.php';

class Mst_Checkpoint extends CI_Controller
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
            'checkpoint'    => $this->M_patrol->showCheckpoint(),
            'zone'          => $this->M_patrol->ambilData("admisecsgp_mstzone"),
        ];
        // $this->template->load("template/template", "mst_checkpoint", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_checkpoint", $data);
        $this->load->view("template/footer");
    }

    public function form_add()
    {
        $data = [
            'link'       => $this->uri->segment(1),
            "plant"      => $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_checkpoint", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_checkpoint", $data);
        $this->load->view("template/footer");
    }


    public function showZone(Type $var = null)
    {
        $id = $this->input->post('id');
        $data = [
            'zona'  =>  $this->M_patrol->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_zone', $data);
    }


    public function input()
    {
        $check_name     = $this->input->post("check_name");
        $check_no       = $this->input->post("check_no");
        $zone_id        = $this->input->post("zone_id");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");
        $durasi         = $this->input->post("durasi_batas_bawah");
        $durasi2        = $this->input->post("durasi_batas_atas");

        $cek = $this->db->get_where("admisecsgp_mstckp", ['check_no' => $check_no])->num_rows();
        if ($cek >= 1) {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input , no checkpoint ' . $check_no . ' sudah terdaftar di sistem');
            redirect('Mst_Checkpoint');
        } else {
            $data = [
                'checkpoint_id'                   => 'ADMC' . substr(uniqid(rand(), true), 4, 4),
                'admisecsgp_mstzone_zone_id'      => $zone_id,
                'check_name'                      => strtoupper($check_name),
                'check_no'                        => $check_no,
                'durasi_batas_atas'               => $durasi,
                'durasi_batas_bawah'              => $durasi2,
                'others'                          => $others,
                'status'                          => $status,
                'created_at'                      => date('Y-m-d H:i:s'),
                'created_by'                      => $this->session->userdata('id_token'),
            ];
            $this->M_patrol->inputData($data, "admisecsgp_mstckp");
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil  menambah data');
            redirect('Mst_Checkpoint');
        }
    }


    public function form_upload()
    {
        $filename = "upload_checkpoint_" . $this->session->flashdata('id_token');
        $data['plant_kode_input'] = "";
        if (isset($_POST['view'])) {
            $upload = $this->M_patrol->uploadCheckpoint($filename);
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

        $data['link'] = $this->uri->segment(1);
        $data["plant"]      = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1]);
        // $this->template->load("template/template", "upload_mst_checkpoint", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("upload_mst_checkpoint", $data);
        $this->load->view("template/footer");
    }


    public function upload()
    {
        $filename = "upload_checkpoint_" . $this->session->flashdata('id_token');
        $path_xlsx = "./assets/path_upload/" . $filename . ".xlsx";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path_xlsx);
        $d = $spreadsheet->getSheet(0)->toArray();
        unset($d[0]);
        $datas = array();
        foreach ($d as $t) {
            $cek_id = $this->db->query("select zone_id , zone_name , kode_zona from admisecsgp_mstzone where kode_zona='" . $t[1] . "' ")->row();
            $params = [
                'checkpoint_id'              => 'ADMC' . substr(uniqid(rand(), true), 4, 4),
                'check_no'                   => strval($t[3]),
                'check_name'                 => strtoupper($t[4]),
                'status'                     => 1,
                'durasi_batas_bawah'         => strval($t[6]),
                'durasi_batas_atas'          => strval($t[5]),
                'admisecsgp_mstzone_zone_id' => $cek_id->zone_id,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
            ];

            array_push($datas, $params);
        }
        $table = "admisecsgp_mstckp";
        $upload  = $this->M_patrol->mulitple_upload($table, $datas);
        if ($upload) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Mst_Checkpoint');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Mst_Checkpoint/form_upload');
        }
    }


    public function hapus($id)
    {
        $where = ['checkpoint_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstckp", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Checkpoint');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Mst_Checkpoint');
        }
    }

    //multiple delete
    public function multipleDelete()
    {
        $id_check = $this->input->post("id_check", true);
        $delete = $this->M_patrol->multiple_delete("admisecsgp_mstckp", $id_check, "checkpoint_id");

        if ($delete) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_Checkpoint');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Mst_Checkpoint');
        }
    }

    public function edit()
    {
        $id =  $this->input->get('check_id');
        $data = [
            'link'       => $this->uri->segment(1),
            'data'       => $this->M_patrol->detailCheckpoint($id)->row(),
            'zona_id'    => $this->input->get('id_zona'),
            "zone"       => $this->M_patrol->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $this->input->get('id_plant'), 'status' => 1]),
            'plant_id'   => $this->input->get('id_plant'),
            "plant"      => $this->M_patrol->ambilData("admisecsgp_mstplant"),
        ];
        // $this->template->load("template/template", "edit_mst_checkpoint", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_checkpoint", $data);
        $this->load->view("template/footer");
    }

    public function update()
    {
        $id             = $this->input->post("id");
        $check_name     = strtoupper($this->input->post("check_name"));
        $check_no       = $this->input->post("check_no");
        $zone_id        = $this->input->post("zone_id");
        $others         = $this->input->post("others");
        $status         = $this->input->post("status");
        $durasi         = $this->input->post("durasi");
        $durasi2         = $this->input->post("durasi2");
        $data = [
            'admisecsgp_mstzone_zone_id' => $zone_id,
            'check_name'                 => $check_name,
            'check_no'                   => $check_no,
            'durasi_batas_atas'          => $durasi,
            'durasi_batas_bawah'         => $durasi2,
            'others'                     => $others,
            'status'                     => $status,
            'updated_at'                 => date('Y-m-d H:i:s'),
            'updated_by'                 => $this->session->userdata('id_token'),
        ];

        $where = ['checkpoint_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstckp", $data, $where);

        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data');
            redirect('Mst_Checkpoint');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_Checkpoint');
        }
    }
}
