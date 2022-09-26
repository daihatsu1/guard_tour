<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

require FCPATH . 'vendor/autoload.php';
class Mst_objek extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('generate');
        if ($id = null || $id = "") {
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
            'objek'         => $this->M_patrol->showObject(),
            'cp'            => $this->M_patrol->showCheckpoint(),
            'checkpoint1'   => $this->M_patrol->showCheckpoint(),
            'kategori_obj'  => $this->db->get("admisecsgp_mstkobj"),
            'plant'         => $this->db->get("admisecsgp_mstplant"),
            'zone'          => $this->M_patrol->showZona()
        ];
        // $this->template->load("template/template", "mst_objek", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("mst_objek", $data);
        $this->load->view("template/footer");
    }

    public function form_add()
    {
        $data = [
            'link'       => $this->uri->segment(1),
            'plant'     => $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1]),
            "kategori"  => $this->M_patrol->ambilData("admisecsgp_mstkobj", ['status' => 1])
        ];
        // $this->template->load("template/template", "add_mst_objek", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("add_mst_objek", $data);
        $this->load->view("template/footer");
    }


    public function show_zona(Type $var = null)
    {
        $idplant = $this->input->post("plant_id");
        $zona    = $this->M_patrol->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $idplant, 'status' => 1]);
        if ($zona->num_rows() > 0) {
            echo json_encode($zona->result_array());
        } else {
            echo "tidak ada zona";
        }
    }


    public function show_kategori(Type $var = null)
    {
        $idzona = $this->input->post("zone_id");
        $checkpoint    = $this->db->query("SELECT checkpoint_id ,check_name from admisecsgp_mstckp WHERE admisecsgp_mstzone_zone_id =  '" . $idzona . "'  and  status = 1 ");
        if ($checkpoint->num_rows() > 0) {
            echo json_encode($checkpoint->result_array());
        } else {
            echo "tidak ada checkpoint";
        }
    }

    public function input()
    {
        $nama_objek         = $this->input->post("nama_objek");
        $check_id           = $this->input->post("check_id");
        $kategori_id        = $this->input->post("kategori_id");
        $status             = $this->input->post("status");
        $others             = $this->input->post("others");
        $id                 = 'ADMO' . substr(uniqid(rand(), true), 4, 4);
        $data = [
            'objek_id'                          => $id,
            'nama_objek'                        => strtoupper($nama_objek),
            'admisecsgp_mstckp_checkpoint_id'   => $check_id,
            'admisecsgp_mstkobj_kategori_id'    => $kategori_id,
            'status'                            => $status,
            'others'                            => $others,
            'created_at'                        => date('Y-m-d H:i:s'),
            'created_by'                        => $this->session->userdata('id_token'),
        ];
        $input = $this->M_patrol->inputData($data, "admisecsgp_mstobj");
        if ($input) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil input data');
            redirect('Mst_objek');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal input data');
            redirect('Mst_objek');
        }
    }


    public function form_upload()
    {
        $filename = "upload_objek_" . $this->session->userdata('id_token');
        $data['plant_name_id'] = "";
        if (isset($_POST['view'])) {
            $upload = $this->M_patrol->uploadObjek($filename);
            if ($upload['result'] == "success") {
                $path_xlsx = "./assets/path_upload/" . $filename . ".xlsx";
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path_xlsx);
                $d = $spreadsheet->getSheet(0)->toArray();
                unset($d[0]);
                $data['sheet'] = $d;
                $data['plant_name_id'] = $this->input->post("plant_id");
            } else {
                $e = $upload['error'];
                $data['upload_error'] = $e;
            }
        }

        $data['link'] = $this->uri->segment(1);
        $data["plant"]      = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1]);
        // $this->template->load("template/template", "upload_mst_objek", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("upload_mst_objek", $data);
        $this->load->view("template/footer");
    }



    public function upload()
    {
        $filename = "upload_objek_" . $this->session->userdata('id_token');
        $path_xlsx = "./assets/path_upload/" . $filename . ".xlsx";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($path_xlsx);
        $d = $spreadsheet->getSheet(0)->toArray();
        unset($d[0]);
        $datas = array();
        $m = 1;
        foreach ($d as $t) {
            $query = $this->db->query('SELECT CAST(RAND()*1100 AS INT) AS random')->row();

            $datazona  = $this->db->get_where("admisecsgp_mstzone", ['kode_zona' => $t[1]])->row();
            $datackp   = $this->db->get_where("admisecsgp_mstckp", ['check_name' => $t[3], 'admisecsgp_mstzone_zone_id' => $datazona->zone_id])->row();
            $dataKategori = $this->db->get_where("admisecsgp_mstkobj", ['kategori_name' => $t[4]])->row();

            $id                 = 'ADMO' . $query->random . $m;
            $params = [
                'objek_id'                              => $id,
                'nama_objek'                            => strtoupper($t[5]),
                'status'                                => 1,
                'admisecsgp_mstkobj_kategori_id'        => $dataKategori->kategori_id,
                'admisecsgp_mstckp_checkpoint_id'       => $datackp->checkpoint_id,
                'created_at'                            => date('Y-m-d H:i:s'),
                'created_by'                            => $this->session->userdata('id_token'),
            ];
            $m++;
            array_push($datas, $params);
        }
        $table = "admisecsgp_mstobj";
        $upload  = $this->M_patrol->mulitple_upload($table, $datas);
        if ($upload) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Mst_objek');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Mst_objek/form_upload');
        }
    }



    public function hapus($id)
    {
        $where = ['objek_id' => $id];
        $del = $this->M_patrol->delete("admisecsgp_mstobj", $where);
        if ($del) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus objek');
            redirect('Mst_objek');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal hapus data');
            redirect('Mst_objek');
        }
    }

    //multiple delete
    public function multipleDelete()
    {
        $id_objek = $this->input->post("id_objek", true);
        $delete = $this->M_patrol->multiple_delete("admisecsgp_mstobj", $id_objek, "objek_id");

        if ($delete) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil hapus data');
            redirect('Mst_objek');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal menghapus data');
            redirect('Mst_objek');
        }
    }

    public function edit()
    {
        $id         =  $this->input->get('check_id');
        $zona_id    = $this->input->get("zona_id");
        $plant_id   = $this->input->get("plant_id");
        $data = [
            'link'              => $this->uri->segment(1),
            'data'              => $this->M_patrol->detailObjek($id)->row(),
            "plant"             => $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1]),
            'zone'              => $this->M_patrol->ambilData("admisecsgp_mstzone", ['status' => 1, 'admisecsgp_mstplant_plant_id' => $plant_id]),
            'checkpoint'        => $this->M_patrol->ambilData("admisecsgp_mstckp", ['status' => 1, 'admisecsgp_mstzone_zone_id' => $zona_id]),
            'kategori_objek'    => $this->M_patrol->ambilData("admisecsgp_mstkobj", ['status' => 1])
        ];
        $this->load->view("template/sidebar", $data);
        $this->load->view("edit_mst_objek", $data);
        $this->load->view("template/footer");
    }



    public function update()
    {
        $id                 = $this->input->post("id_object");
        $nama_objek         = $this->input->post("nama_objek");
        $check_id           = $this->input->post("check_id");
        $kategori_id        = $this->input->post("kategori_id");
        $status             = $this->input->post("status");
        $others             = $this->input->post("others");

        $data = [
            'nama_objek'                        => strtoupper($nama_objek),
            'admisecsgp_mstckp_checkpoint_id'   => $check_id,
            'admisecsgp_mstkobj_kategori_id'    => $kategori_id,
            'status'                            => $status,
            'others'                            => $others,
            'updated_at'                        => date('Y-m-d H:i:s'),
            'updated_by'                        => $this->session->userdata('id_token'),
        ];

        $where = ['objek_id' => $id];
        $update = $this->M_patrol->update("admisecsgp_mstobj", $data, $where);

        if ($update) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil update data ');
            redirect('Mst_objek');
        } else {
            $this->session->set_flashdata('info', '<i class="icon fas fa-exclamation-triangle"></i> Gagal update data');
            redirect('Mst_objek');
        }
    }


    //ambil data zona
    public function getZona()
    {

        $id = $this->input->post("plant_no");
        $data = [
            'data'  => $this->db->get_where("admisecsgp_mstzone", ['plant_no' => $id])
        ];
        $this->load->view("pilihZona", $data);
    }


    //ambil data checkpoint
    public function getCheck()
    {

        $id = $this->input->post("id");
        $data = [
            'data'  => $this->db->get_where("admisecsgp_mstckp", ['admisecsgp_mstzone_zone_id' => $id, 'status' => 1])
        ];
        $this->load->view("ajax/list_check", $data);
    }
}
