<?php


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH . 'vendor/autoload.php';

class Mst_Jadwal_Produksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $id = $this->session->userdata('id_token');
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('convertbulan');
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

        $data['bulan'] = "";
        $data['tahun'] = "";
        $data['plant_id'] = "";
        $id_wil_user = $this->session->userdata('site_id');
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];
        if (isset($_POST['lihat'])) {
            $plant_id             = $this->input->post("plant");
            $tahun                = $this->input->post("tahun");
            $bulan                = $this->input->post("bulan");
            $data['bulan']        = $bulan;
            $data['tahun']        = $tahun;
            $data['month']        = convert_bulan($bulan);
            $data['plant_id']     = $plant_id;
            $data['jadwal']       = $this->M_patrol->headerjadwalProduksi($plant_id, $tahun . '-' . convert_bulan($bulan));
        }
        $data['link']          = $this->uri->segment(2);
        $data['plant']         = $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user]);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_jadwal_produksi", $data);
        $this->load->view("template/admin/footer");
    }

    public function showZone(Type $var = null)
    {
        $id = $this->input->post('id');
        $data = [
            'zona'  =>  $this->M_patrol->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_plant_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_zone', $data);
    }


    //form koreksi jadwal petugas patroli
    public function form_rubah_jadwal_produksi(Type $var = null)
    {
        $data['session_plant'] = "";
        $data['session_date'] = "";
        $date = "";
        $id_wil_user = $this->session->userdata('site_id');
        if (isset($_POST['lihat'])) {
            //param dari user 
            $plant_id               = $this->input->post("plant_id");
            $date                   = $this->input->post("date");
            $data['session_plant']  = $plant_id;
            $data['session_date']   = $date;
            //load data produksi
            $data['produksi']       = $this->M_patrol->produksiPerTanggal($date, $plant_id);
            //data pencarian
            $data['session_plant']          = $plant_id;
        }
        $data['link']                = $this->uri->segment(2);
        $data['plant']               = $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user]);
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        // variabel untuk tambah zona 
        $data['mst_produksi'] = $this->M_patrol->ambilData("admisecsgp_mstproduction", ['status' => 1]);
        $data['mst_shift'] = $this->db->query("select * from admisecsgp_mstshift where status = 1  ");
        // 
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/form_edit_jadwal_produksi", $data);
        $this->load->view("template/admin/footer");
    }



    public function load_data_produksi(Type $var = null)
    {
        $id = $this->input->post("id");
        $zona = $this->input->post("zona");
        $shift = $this->input->post("shift");
        $date = $this->input->post("date");
        $status_zona = $this->input->post("status_zona");
        $statusProduksi = $this->input->post("stat_produksi");

        $data =  [
            'id'                         => $id,
            'zona'                       => $zona,
            'shift'                      => $shift,
            'date'                       => $date,
            'produksi_id'                => $statusProduksi,
            'status_zona'                => $status_zona,
            'data_produksi'              => $this->M_patrol->ambilData("admisecsgp_mstproduction"),
            'data_shift'                 => $this->db->query("select * from admisecsgp_mstshift where nama_shift != 'LIBUR' and status = 1  "),
        ];
        $this->load->view("ajax/detail_produksi2", $data);
    }

    //update jadwal patroli per tanggal
    public function update_jadwal_produksi(Type $var = null)
    {

        $id               = $this->input->post("id_update");
        $idProduksi       = $this->input->post("status_produksi");
        $statusZona       = $this->input->post("status_zona");
        $data = [
            'admisecsgp_mstproduction_produksi_id'  => $idProduksi,
            'status_zona'     => $statusZona,
            'updated_by'      => $this->session->userdata('id_token'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        $update = $this->M_patrol->update("admisecsgp_trans_zona_patroli", $data, ['id_zona_patroli' => $id]);
        if ($update) {
            echo "1";
        } else {
            echo "terjadi kesalahan update data";
        }
    }



    //form upload ulang jadwal patroli
    public function form_revisi_upload_jadwal(Type $var = null)
    {

        $id_wil_user = $this->session->userdata('site_id');
        $filename = "rev_upload_jadwal_" . $this->session->userdata("id_token");
        $data['plant_3'] = "";
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
        $data['plant_master']  = $this->M_patrol->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_site_id' => $id_wil_user]);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/form_revisi_upload_jadwal", $data);
        $this->load->view("template/admin/footer");
    }




    //function revisi 
    public function revisi_upload_jadwal(Type $var = null)
    {
        // $filename = "upload_jadwal-format";
        $filename = "rev_upload_jadwal_" . $this->session->userdata("id_token");
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
            for ($p = 2; $p <= count($datajadwal[7]) - 2; $p += 2) {
                $produksi = $this->db->query("select produksi_id from admisecsgp_mstproduction where name='" . $jdl[$p] . "' ")->row();
                $d = new DateTime();
                $uniq = $d->format("dmyHisv");
                $id                 = uniqid($uniq);
                $gen = 'ADMZP' . substr($id, 0, 6) . substr($id, 22, 10) . random_string('alnum', 3);;
                $data =  [
                    'id_zona_patroli'                        => $gen,
                    'date_patroli'                           => $date . "-" . $prt,
                    'admisecsgp_mstplant_plant_id'           => $plant->plant_id,
                    'admisecsgp_mstshift_shift_id'           => $var_shift->shift_id,
                    'admisecsgp_mstzone_zone_id'             => $var_zona->zone_id,
                    'admisecsgp_mstproduction_produksi_id'   => $produksi->produksi_id,
                    'status_zona'                            => $jdl[$var] == 'on' ? 1 : 0,
                    'status'                                 => 1,
                    'created_at'                             => date('Y-m-d H:i:s'),
                    'created_by'                             => $this->session->userdata("id_token")
                ];

                array_push($dataprd, $data);
                $var += 2;
                $prt++;
            }
        }


        $this->db->query("DELETE FROM admisecsgp_trans_zona_patroli WHERE admisecsgp_mstplant_plant_id='" . $plant->plant_id . "' AND format(date_patroli,'yyyy-MM','en-US') = '" . $date . "' ");
        // $this->db->delete("admisecsgp_trans_zona_patroli");
        if ($this->db->affected_rows() > 0) {
            $this->db->insert_batch('admisecsgp_trans_zona_patroli', $dataprd);
            if ($this->db->affected_rows() > 0) {
                $this->db->trans_commit();
                $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload revisi jadwal');
                redirect('Admin/Mst_Jadwal_Produksi/form_revisi_upload_jadwal');
            } else {
                $this->db->trans_rollback();
                $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data s');
                redirect('Admin/Mst_Jadwal_Produksi/form_revisi_upload_jadwal');
            }
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Admin/Mst_Jadwal_Produksi/form_revisi_upload_jadwal');
        }
    }
}
