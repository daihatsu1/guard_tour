<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH . 'vendor/autoload.php';


class Upload_Jadwal_Patroli extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $id = $this->session->userdata('id_token');
        $this->load->helper('ConvertBulan');
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

        $filename = "upload_jadwal_patroli_" . $this->session->userdata("id_token");
        $data['plant_3'] = "";
        // $filename = "upload_jadwal-format";
        if (isset($_POST['view'])) {
            $upload = $this->M_patrol->uploadJadwal($filename);

            if ($upload['result'] == "success") {
                $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
                $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet      = $reader->load($path_xlsx);
                $datajadwal       = $spreadsheet->getSheet(0)->toArray();
                $sheet = $spreadsheet->getSheet(0);
                $bulan_jadwal_patroli  = $sheet->getCell('B2');
                $tahun_jadwal_patroli  = $sheet->getCell('B3');
                $kode_plant            = $sheet->getCell('B4');
                $nama_plant            = $sheet->getCell('B5');
                unset($datajadwal[0]);
                unset($datajadwal[1]);
                unset($datajadwal[2]);
                unset($datajadwal[3]);
                unset($datajadwal[4]);
                unset($datajadwal[5]);
                unset($datajadwal[6]);
                $data['jadwal']           = $datajadwal;
                $data['plant']            = $kode_plant;
                $data['plant_name']       = $nama_plant;
                $data['bulan_patroli']    = strtoupper($bulan_jadwal_patroli);
                $data['tahun_patroli']    = $tahun_jadwal_patroli;
                $data['date']             = $tahun_jadwal_patroli . '-' . convert_bulan($bulan_jadwal_patroli);
                $data['bulan_input']      = strtoupper($this->input->post("bulan_input"));
                $data['tahun_input']      = strtoupper($this->input->post("tahun_input"));

                // plant inputan sistem
                $data['plant_3']          = $this->input->post("plant_3");
            } else {
                $e                    = $upload['error'];
                $data['upload_error'] = $e;
            }
        }
        $data['link'] =  $this->uri->segment(1);
        $data['plant_master']  = $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1]);

        $this->load->view("template/sidebar", $data);
        $this->load->view("upload_jadwal_patroli", $data);
        $this->load->view("template/footer");
    }


    public function uploadjadwalPatroli()
    {
        # code...
        $filename = "upload_jadwal_patroli_" . $this->session->userdata("id_token");
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $datajadwal       = $spreadsheet->getSheet(0)->toArray();

        $sheet1 = $spreadsheet->getSheet(0);
        $data_jadwal = array();
        // echo "<pre>";
        unset($datajadwal[0]);
        unset($datajadwal[1]);
        unset($datajadwal[2]);
        unset($datajadwal[3]);
        unset($datajadwal[4]);
        unset($datajadwal[5]);
        unset($datajadwal[6]);
        $bulan_jadwal_patroli  = $sheet1->getCell('B2');
        $tahun_jadwal_patroli  = $sheet1->getCell('B3');

        $date_patroli =  $tahun_jadwal_patroli . '-' . convert_bulan($bulan_jadwal_patroli) . '-';
        foreach ($datajadwal as $jdl) {
            $kodePlant = $jdl[0];
            $plantName = $jdl[1];
            $npk       = $jdl[2];
            $nama      = $jdl[3];
            $plant = $this->db->query("select plant_id from admisecsgp_mstplant where kode_plant = '" . $kodePlant . "' AND plant_name='" . $plantName . "' ")->row();
            $k = 4;
            $shift = array();
            for ($i = 1; $i <= (count($datajadwal[7]) - 4); $i++) {
                $sh = [
                    'tanggal_' . $i => $jdl[$k]
                ];
                array_push($shift, $sh);
                $k++;
            }

            $o = 1;
            $l = 1;
            for ($t = 0; $t < count($shift); $t++) {
                $d = time();
                $gen = uniqid("ADMJP".rand());
                $Shift = $this->db->query("select shift_id from admisecsgp_mstshift where nama_shift='" . $shift[$t]['tanggal_' . $o] . "' ")->row();
                $User = $this->db->query("select npk from admisecsgp_mstusr where npk ='" . $npk .  "' and name='" . $nama . "' and admisecsgp_mstplant_plant_id = '" . $plant->plant_id . "' ")->row();
                $var = [
                    'id_jadwal_patroli'                 => $gen,
                    'admisecsgp_mstusr_npk'             => $User->npk,
                    'admisecsgp_mstplant_plant_id'      => $plant->plant_id,
                    'admisecsgp_mstshift_shift_id'      => $Shift->shift_id,
                    'status'                            => 1,
                    'date_patroli'                      => $date_patroli . $o,
                    'created_at'                        => date('Y-m-d H:i:s'),
                    'created_by'                        => $this->session->userdata('id_token')
                ];
                array_push($data_jadwal, $var);
                $o++;
                $l++;
            }
        }

        // var_dump($data_jadwal);


        $this->db->insert_batch('admisecsgp_trans_jadwal_patroli', $data_jadwal);
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Upload_Jadwal_Patroli');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Upload_Jadwal_Patroli');
        }
    }
}
