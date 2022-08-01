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
        $data['bulan'] = "";
        $data['tahun'] = "";
        $data['plant_id'] = "";
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];
        if (isset($_POST['lihat'])) {
            $plant_id             = $this->input->post("plant");
            $tahun                = $this->input->post("tahun");
            $bulan                = $this->input->post("bulan");
            $data['bulan']        = $bulan;
            $data['tahun']        = $tahun;
            $data['plant_id']     = $plant_id;
            $data['jadwal']       = $this->M_admin->showProduksi($tahun, $bulan, $plant_id);
        }
        $data['link']          = $this->uri->segment(2);
        $data['plant']         = $this->M_admin->ambilData("admisecsgp_mstplant", ['admisecsgp_mstsite_id' => $id_wil_user, 'status' => 1]);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/mst_jadwal_produksi", $data);
        $this->load->view("template/admin/footer");
    }

    public function showZone(Type $var = null)
    {
        $id = $this->input->post('id');
        $data = [
            'zona'  =>  $this->M_admin->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_id' => $id, 'status' => 1])
        ];
        $this->load->view('ajax/list_zone', $data);
    }


    //form koreksi jadwal petugas patroli
    public function form_rubah_jadwal_produksi(Type $var = null)
    {
        $data['session_plant'] = "";
        $data['tahun_pilih'] = "";
        $data['bulan_pilih'] = "";
        $data['tanggal_pilih'] = "";
        $id_wil_user = $this->session->userdata("site_id");
        if (isset($_POST['lihat'])) {
            //param dari user 
            $tahun            = $this->input->post("tahun");
            $bulan            = $this->input->post("bulan");
            $tanggal          = $this->input->post("tanggal");
            $plant_id         = $this->input->post("plant_id");
            $colom_stat_zona  = "ss_" . $tanggal;
            $col_tanggal      = "prd.tanggal_" . $tanggal;
            $colom_select_tgl = "tanggal_" . $tanggal;

            //load data produksi
            $data['produksi'] = $this->M_admin->produksiPerTanggal($colom_stat_zona, $tahun, $bulan,  $col_tanggal, $plant_id, $colom_select_tgl);

            //data pencarian
            $data['session_plant']          = $plant_id;
            $data['tahun_pilih']            = $tahun;
            $data['bulan_pilih']            = $bulan;
            $data['tanggal_pilih']          = $tanggal;
            $data['kolom_update_tgl']       = $colom_select_tgl;
            $data['kolom_update_stat_zona'] = $colom_stat_zona;
            $data['date']                   = $tanggal . ' ' . $bulan . ' ' . $tahun;
        }
        $data['link']                = $this->uri->segment(2);
        $data['plant']               = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $id_wil_user]);
        $data['daftar_bulan'] = [
            'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI', 'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
        ];

        // variabel untuk tambah zona 
        $data['mst_produksi'] = $this->M_admin->ambilData("admisecsgp_mstproduction", ['status' => 1]);
        $data['mst_shift'] = $this->db->query("select * from admisecsgp_mstshift where nama_shift != 'LIBUR' and status = 1  ");

        // 

        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/form_edit_jadwal_produksi", $data);
        $this->load->view("template/admin/footer");
    }

    // input zona tambahan
    public function input()
    {
        $tahun              = $this->input->post("tahun_2");
        $bulan              = $this->input->post("bulan_2");
        $tanggal            = $this->input->post("tanggal_2");
        $status_zona        = $this->input->post("tahun_2");
        $kolom_tanggal      = "tanggal_" . $tanggal;
        $kolom_stat_zona    = "ss_" . $tanggal;
        $shift_id           = $this->input->post("shift_2");
        $produksi_id        = $this->input->post("status_produksi_2");
        $zona_id            = $this->input->post("zone_id");
        $plant_id           = $this->input->post("plant_id3");

        //cari data zona di bulan itu 
        $cekzona = $this->M_admin->ambilData("admisecsgp_mstproductiondtls", [
            'admisecsgp_mstzone_id'     => $zona_id,
            'admisecsgp_mstshift_id'    => $shift_id,
            'bulan'                     => $bulan,
            'tahun'                     => $tahun
        ]);

        if ($cekzona->num_rows() > 0) {
            echo "zona sudah ada jadwal di bulan ini";
        } else {
            echo "tambah zona";
        }
    }

    public function load_data_produksi(Type $var = null)
    {
        $plant_id                   = $this->input->post("plant_id");
        $zona_id                    = $this->input->post("zona_id");
        $shift_id                   = $this->input->post("shift_id");
        $id_produksi                = $this->input->post("produksi_id");
        $status_zona                = $this->input->post("status_zona");
        $colom_update_pertanggal    = $this->input->post("colom_update_produksi");
        $colom_update_status_zona   = $this->input->post("colom_update_status_zona");
        $tgl_produksi               = $this->input->post("tanggal_produksi");
        $id_update                  = $this->input->post("id_update");
        $data =  [
            'id'                         => $id_update,
            'zone_id'                    => $zona_id,
            'shift_id'                   => $shift_id,
            'produksi_id'                => $id_produksi,
            'status_zona'                => $status_zona,
            'kolom_tanggal_produksi'     => $colom_update_pertanggal,
            'kolom_status_zona'          => $colom_update_status_zona,
            'tanggal_produksi'           => $tgl_produksi,
            'data_zona'                  => $this->M_admin->ambilData("admisecsgp_mstzone", ['admisecsgp_mstplant_id'    => $plant_id]),
            'data_produksi'              => $this->M_admin->ambilData("admisecsgp_mstproduction"),
            'data_shift'                 => $this->db->query("select * from admisecsgp_mstshift where nama_shift != 'LIBUR' and status = 1  "),
        ];
        $this->load->view("ajax/detail_produksi2", $data);
    }

    //update jadwal patroli
    public function update_jadwal_produksi(Type $var = null)
    {
        $colom_tanggal_update      = $this->input->post("kolom_tanggal_update");
        $kolom_status_zona         = $this->input->post("kolom_status_zona");
        $id                        = $this->input->post("id_update");
        $idzone                    = $this->input->post("zona_produksi");
        $idshift                   = $this->input->post("shift_produksi");
        $statusProduksi            = $this->input->post("status_produksi");
        $statusZona                = $this->input->post("status_zona");

        $data = [
            'admisecsgp_mstzone_id'          => $idzone,
            'admisecsgp_mstshift_id'         => $idshift,
            $colom_tanggal_update            => $statusProduksi,
            $kolom_status_zona               => $statusZona,
            'updated_by'                     => $this->session->userdata('id_token'),
            'updated_at'                     => date('Y-m-d H:i:s')
        ];


        $update = $this->M_admin->update("admisecsgp_mstproductiondtls", $data, ['id' => $id]);
        if ($update) {
            echo "1";
        } else {
            echo "terjadi kesalahan update data";
        }
    }

    //form upload ulang jadwal patroli
    public function form_revisi_upload_jadwal(Type $var = null)
    {

        $filename = "upload_jadwal_" . $this->session->userdata("id_token");
        if (isset($_POST['view'])) {
            $upload = $this->M_patrol->uploadJadwal($filename);
            if ($upload['result'] == "success") {
                $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
                $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet      = $reader->load($path_xlsx);
                $dataproduction   = $spreadsheet->getSheet(0)->toArray();
                unset($dataproduction[0]);
                unset($dataproduction[1]);
                unset($dataproduction[2]);
                unset($dataproduction[3]);
                unset($dataproduction[4]);
                unset($dataproduction[5]);
                unset($dataproduction[6]);


                //sheet 1 jadwal patroli
                $sheet1 = $spreadsheet->getSheet(0);
                //waktu patroli
                $kode_plant            = $sheet1->getCell('B4');
                $nama_plant            = $sheet1->getCell('B5');
                //waktu produksi
                $bulan_jadwal_produksi    = strtoupper($sheet1->getCell('B2'));
                $tahun_jadwal_produksi    = $sheet1->getCell('B3');
                $data['produksi']         = $dataproduction;
                $data['bulan_produksi']   = $bulan_jadwal_produksi;
                $data['tahun_produksi']   = $tahun_jadwal_produksi;
                $data['plant']            = $kode_plant;
                $data['plant_name']       = $nama_plant;
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
        $data['plant_master']  = $this->M_admin->ambilData("admisecsgp_mstplant", ['status' => 1, 'admisecsgp_mstsite_id' => $this->session->userdata("site_id")]);
        $this->load->view("template/admin/sidebar", $data);
        $this->load->view("admin/form_revisi_upload_jadwal", $data);
        $this->load->view("template/admin/footer");
    }



    //function revisi 
    public function revisi_upload_jadwal(Type $var = null)
    {
        // $filename = "upload_jadwal-format";
        $filename = "upload_jadwal_" . $this->session->userdata("id_token");
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $dataproduction   = $spreadsheet->getSheet(0)->toArray();

        //sheet 1 jadwal patroli
        $sheet1 = $spreadsheet->getSheet(0);


        //kode plant diambil dari sheet jadwal patroli
        $kode_plant     = $sheet1->getCell('B4');
        $dataPlant      = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $kode_plant])->row();
        //waktu periode jadwal patroli
        $bulan_jadwal_produksi  = strtoupper($sheet1->getCell('B2'));
        $tahun_jadwal_produksi  = $sheet1->getCell('B3');



        // data produksi
        $data_prod = array();
        unset($dataproduction[0]);
        unset($dataproduction[1]);
        unset($dataproduction[2]);
        unset($dataproduction[3]);
        unset($dataproduction[4]);
        unset($dataproduction[5]);
        unset($dataproduction[6]);
        foreach ($dataproduction as $prd) {
            $cekzona = $this->db->get_where("admisecsgp_mstzone", ['zone_name' => $prd[0], 'admisecsgp_mstplant_id' => $dataPlant->id])->row();
            $cekshift = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $prd[1]])->row();
            $cekprod1  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[2]])->row();
            $cekprod2  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[4]])->row();
            $cekprod3  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[6]])->row();
            $cekprod4  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[8]])->row();
            $cekprod5  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[10]])->row();
            $cekprod6  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[12]])->row();
            $cekprod7  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[14]])->row();
            $cekprod8  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[16]])->row();
            $cekprod9 = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[18]])->row();
            $cekprod10  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[20]])->row();
            $cekprod11  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[22]])->row();
            $cekprod12  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[24]])->row();
            $cekprod13  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[26]])->row();
            $cekprod14  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[28]])->row();
            $cekprod15  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[30]])->row();
            $cekprod16  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[32]])->row();
            $cekprod17  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[34]])->row();
            $cekprod18  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[36]])->row();
            $cekprod19  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[38]])->row();
            $cekprod20  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[40]])->row();
            $cekprod21  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[42]])->row();
            $cekprod22  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[44]])->row();
            $cekprod23  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[46]])->row();
            $cekprod24  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[48]])->row();
            $cekprod25  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[50]])->row();
            $cekprod26  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[52]])->row();
            $cekprod27  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[54]])->row();
            $cekprod28  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[56]])->row();
            $cekprod29  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[58]])->row();
            $cekprod30  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[60]])->row();
            $cekprod31  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[62]])->row();
            $params_prod = [
                'bulan'                       => $bulan_jadwal_produksi,
                'tahun'                       => $tahun_jadwal_produksi,
                'admisecsgp_mstplant_id'      => $dataPlant->id,
                'admisecsgp_mstzone_id'       => $cekzona->id,
                'admisecsgp_mstshift_id'      => $cekshift->id,
                'tanggal_1'                   => $cekprod1->id,
                'ss_1'                        => $prd[3] == 'on' ? '1' : '0',
                'tanggal_2'                   => $cekprod2->id,
                'ss_2'                        => $prd[5] == 'on' ? '1' : '0',
                'tanggal_3'                   => $cekprod3->id,
                'ss_3'                        => $prd[7] == 'on' ? '1' : '0',
                'tanggal_4'                   => $cekprod4->id,
                'ss_4'                        => $prd[9] == 'on' ? '1' : '0',
                'tanggal_5'                   => $cekprod5->id,
                'ss_5'                        => $prd[11] == 'on' ? '1' : '0',
                'tanggal_6'                   => $cekprod6->id,
                'ss_6'                        => $prd[13] == 'on' ? '1' : '0',
                'tanggal_7'                   => $cekprod7->id,
                'ss_7'                        => $prd[15] == 'on' ? '1' : '0',
                'tanggal_8'                   => $cekprod8->id,
                'ss_8'                        => $prd[17] == 'on' ? '1' : '0',
                'tanggal_9'                   => $cekprod9->id,
                'ss_9'                        => $prd[19] == 'on' ? '1' : '0',
                'tanggal_10'                  => $cekprod10->id,
                'ss_10'                       => $prd[21] == 'on' ? '1' : '0',
                'tanggal_11'                  => $cekprod11->id,
                'ss_11'                       => $prd[23] == 'on' ? '1' : '0',
                'tanggal_12'                  => $cekprod12->id,
                'ss_12'                       => $prd[25] == 'on' ? '1' : '0',
                'tanggal_13'                  => $cekprod13->id,
                'ss_13'                       => $prd[27] == 'on' ? '1' : '0',
                'tanggal_14'                  => $cekprod14->id,
                'ss_14'                       => $prd[29] == 'on' ? '1' : '0',
                'tanggal_15'                  => $cekprod15->id,
                'ss_15'                       => $prd[31] == 'on' ? '1' : '0',
                'tanggal_16'                  => $cekprod16->id,
                'ss_16'                       => $prd[33] == 'on' ? '1' : '0',
                'tanggal_17'                  => $cekprod17->id,
                'ss_17'                       => $prd[35] == 'on' ? '1' : '0',
                'tanggal_18'                  => $cekprod18->id,
                'ss_18'                       => $prd[37] == 'on' ? '1' : '0',
                'tanggal_19'                  => $cekprod19->id,
                'ss_19'                       => $prd[39] == 'on' ? '1' : '0',
                'tanggal_20'                  => $cekprod20->id,
                'ss_20'                       => $prd[41] == 'on' ? '1' : '0',
                'tanggal_21'                  => $cekprod21->id,
                'ss_21'                       => $prd[43] == 'on' ? '1' : '0',
                'tanggal_22'                  => $cekprod22->id,
                'ss_22'                       => $prd[45] == 'on' ? '1' : '0',
                'tanggal_23'                  => $cekprod23->id,
                'ss_23'                       => $prd[47] == 'on' ? '1' : '0',
                'tanggal_24'                  => $cekprod24->id,
                'ss_24'                       => $prd[49] == 'on' ? '1' : '0',
                'tanggal_25'                  => $cekprod25->id,
                'ss_25'                       => $prd[51] == 'on' ? '1' : '0',
                'tanggal_26'                  => $cekprod26->id,
                'ss_26'                       => $prd[53] == 'on' ? '1' : '0',
                'tanggal_27'                  => $cekprod27->id,
                'ss_27'                       => $prd[55] == 'on' ? '1' : '0',
                'tanggal_28'                  => $cekprod28->id,
                'ss_28'                       => $prd[57] == 'on' ? '1' : '0',
                'tanggal_29'                  => $cekprod29->id,
                'ss_29'                       => $prd[59] == 'on' ? '1' : '0',
                'tanggal_30'                  => $cekprod30->id,
                'ss_30'                       => $prd[61] == 'on' ? '1' : '0',
                'tanggal_31'                  => $cekprod31->id,
                'ss_31'                       => $prd[63] == 'on' ? '1' : '0',
                'status'                      =>  1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
            ];
            array_push($data_prod, $params_prod);
        }



        $update_production = $this->M_admin->update(
            "admisecsgp_mstproductiondtls",
            ['status' => 0, 'updated_by' => $this->session->userdata('id_token'), 'updated_at' => date('Y-m-d H:i:s')],
            ['tahun' => $tahun_jadwal_produksi, 'bulan' => $bulan_jadwal_produksi, 'admisecsgp_mstplant_id' =>  $dataPlant->id]
        );
        if ($update_production) {
            $this->M_admin->mulitple_upload("admisecsgp_mstproductiondtls", $data_prod);
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Admin/Mst_Jadwal_Produksi');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Admin/Mst_Jadwal_Produksi/form_revisi_upload_jadwal');
        }
    }
}
