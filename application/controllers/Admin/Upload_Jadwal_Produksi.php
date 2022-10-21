<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH . 'vendor/autoload.php';
class Upload_Jadwal_Produksi extends CI_Controller
{

    public function __construct(Type $var = null)
    {
        parent::__construct();

        date_default_timezone_set('Asia/Jakarta');
        $id = $this->session->userdata('id_token');
        $this->load->helper('ConvertBulan');
        $this->load->helper('string');
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
        $filename = "upload_jadwal_produksi_" . $this->session->userdata("id_token");
        $id_wil_user = $this->session->userdata('site_id');
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
                $data['date']             = $tahun_jadwal_patroli  . '-' . convert_bulan($bulan_jadwal_patroli);
                $data['bulan_input']      = strtoupper($this->input->post("bulan_input"));
                $data['tahun_input']      = strtoupper($this->input->post("tahun_input"));

                // plant inputan sistem
                $data['plant_3']          = $this->input->post("plant_3");
            } else {
                $e                    = $upload['error'];
                $data['upload_error'] = $e;
            }
        }
        $data['link'] =  $this->uri->segment(2);
        $data['plant_master']  = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user]);

        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/upload_jadwal_produksi", $data);
        $this->load->view("template/admin/footer");
    }



    public function upload(Type $var = null)
    {
        $filename = "upload_jadwal_produksi_" . $this->session->userdata("id_token");
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $datajadwal       = $spreadsheet->getSheet(0)->toArray();
        //sheet 1 jadwal produksi
        $sheet1         = $spreadsheet->getSheet(0);
        $kodePlant     = $sheet1->getCell('B4');
        $plantName     = $sheet1->getCell('B5');
        $bulan_jadwal_patroli  = $sheet1->getCell('B2');
        $tahun_jadwal_patroli  = $sheet1->getCell('B3');
        unset($datajadwal[0]);
        unset($datajadwal[1]);
        unset($datajadwal[2]);
        unset($datajadwal[3]);
        unset($datajadwal[4]);
        unset($datajadwal[5]);
        unset($datajadwal[6]);
        $date  = $tahun_jadwal_patroli . '-' . convert_bulan($bulan_jadwal_patroli);

        $plant = $this->db->query("select plant_id from admisecsgp_mstplant where kode_plant = '" . $kodePlant . "' AND plant_name='" . $plantName . "' ")->row();
        $dataprd = array();
        foreach ($datajadwal as $jdl) {
            $prt   = 1;
            $var   = 3;
            $zona  = $jdl[0];
            $shift = $jdl[1];
            $var_zona  = $this->db->query("select zone_id from admisecsgp_mstzone where zone_name='" . $zona . "' and admisecsgp_mstplant_plant_id = '" . $plant->plant_id . "' ")->row();
            $var_shift = $this->db->query("select shift_id from admisecsgp_mstshift where nama_shift='" . $shift . "' ")->row();
            $l = 1;
            for ($p = 2; $p <= count($datajadwal[7]) - 2; $p += 2) {
                $produksi = $this->db->query("select produksi_id from admisecsgp_mstproduction where name='" . $jdl[$p] . "' ")->row();
                $d = new DateTime();
                $uniq = $d->format("dmyHisv");
                $id                 = uniqid($uniq);
                $gen = 'ADMZP' . substr($id, 0, 6) . substr($id, 22, 10) . random_string('alnum', 3);;
                $data =  [
                    'id_zona_patroli'                    => $gen,
                    'date_patroli'                       => $date . "-" . $prt,
                    'admisecsgp_mstplant_plant_id'       => $plant->plant_id,
                    'admisecsgp_mstshift_shift_id'       => $var_shift->shift_id,
                    'admisecsgp_mstzone_zone_id'         => $var_zona->zone_id,
                    'admisecsgp_mstproduction_produksi_id' => $produksi->produksi_id,
                    'status_zona'                        => $jdl[$var] == 'on' ? 1 : 0,
                    'status'                             => 1,
                    'created_at'                         => date('Y-m-d H:i:s'),
                    'created_by'                         => $this->session->userdata("id_token")
                ];
                array_push($dataprd, $data);
                $var += 2;
                $prt++;
            }
            $l++;
        }


        $this->db->insert_batch('admisecsgp_trans_zona_patroli', $dataprd);
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Admin/Upload_Jadwal_Produksi');
        } else {
            $this->db->trans_rollback();
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Admin/Upload_Jadwal_Produksi');
        }
    }
}
