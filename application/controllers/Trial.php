<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require FCPATH . 'vendor/autoload.php';
class Trial extends CI_Controller
{
    public function index(Type $var = null)
    {
        $filename = "upload_jadwal-format";
        // $filename = "upload_jadwal";
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $datajadwal       = $spreadsheet->getSheet(0)->toArray();
        $dataproduction   = $spreadsheet->getSheet(1)->toArray();



        //sheet 1 jadwal patroli
        $sheet1 = $spreadsheet->getSheet(0);
        //sheet 2 jadwal produksi
        $sheet2 = $spreadsheet->getSheet(1);


        //kode plant diambil dari sheet jadwal patroli
        $kode_plant     = $sheet1->getCell('A6');
        $dataPlant = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $kode_plant])->row();
        //waktu periode jadwal patroli
        $bulan_jadwal_patroli  = $sheet1->getCell('B2');
        $tahun_jadwal_patroli  = $sheet1->getCell('B3');


        unset($datajadwal[0]);
        unset($datajadwal[1]);
        unset($datajadwal[2]);
        unset($datajadwal[3]);
        unset($datajadwal[4]);
        $data_jadwal = array();
        foreach ($datajadwal as $jdl) {
            $dataUser = $this->db->get_where("admisecsgp_mstusr", ['npk' => $jdl[2]])->row();
            $params_jadwal = [
                'bulan'                      => strtoupper($bulan_jadwal_patroli),
                'tahun'                      => $tahun_jadwal_patroli,
                'admisecsgp_mstusr_id'       => $dataUser->id,
                'admisecsgp_mstplant_id'     => $dataPlant->id,
                'tanggal_1'                  => strval($jdl[4]),
                'tanggal_2'                  => strval($jdl[5]),
                'tanggal_3'                  => strval($jdl[6]),
                'tanggal_4'                  => strval($jdl[7]),
                'tanggal_5'                  => strval($jdl[8]),
                'tanggal_6'                  => strval($jdl[9]),
                'tanggal_7'                  => strval($jdl[10]),
                'tanggal_8'                  => strval($jdl[11]),
                'tanggal_9'                  => strval($jdl[12]),
                'tanggal_10'                 => strval($jdl[13]),
                'tanggal_11'                 => strval($jdl[14]),
                'tanggal_12'                 => strval($jdl[15]),
                'tanggal_13'                 => strval($jdl[16]),
                'tanggal_14'                 => strval($jdl[17]),
                'tanggal_15'                 => strval($jdl[18]),
                'tanggal_16'                 => strval($jdl[19]),
                'tanggal_17'                 => strval($jdl[20]),
                'tanggal_18'                 => strval($jdl[21]),
                'tanggal_19'                 => strval($jdl[22]),
                'tanggal_20'                 => strval($jdl[23]),
                'tanggal_21'                 => strval($jdl[24]),
                'tanggal_22'                 => strval($jdl[25]),
                'tanggal_23'                 => strval($jdl[27]),
                'tanggal_24'                 => strval($jdl[28]),
                'tanggal_25'                 => strval($jdl[29]),
                'tanggal_26'                 => strval($jdl[30]),
                'tanggal_27'                 => strval($jdl[31]),
                'tanggal_28'                 => strval($jdl[32]),
                'tanggal_29'                 => strval($jdl[32]),
                'tanggal_30'                 => strval($jdl[33]),
                'tanggal_31'                 => strval($jdl[34]),
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),

            ];

            array_push($data_jadwal, $params_jadwal);
        }



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
                'bulan'                       => $bulan_jadwal_patroli,
                'tahun'                       => $tahun_jadwal_patroli,
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

        $save_production = $this->M_patrol->mulitple_upload("admisecsgp_mstproductiondtls", $data_prod);
        $save_patroli    =  $this->M_patrol->mulitple_upload("admisecsgp_mstjadwalpatroli", $data_jadwal);

        if ($save_patroli && $save_production) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            // redirect('Mst_Jadwal');
            echo "Upload jadwal patroli dan produksi berhasil";
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            // redirect('Mst_Jadwal/form_upload_jadwal');
        }
    }


    public function upload()
    {
        $filename = "upload_jadwal";
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $datajadwal       = $spreadsheet->getSheet(0)->toArray();
        $dataproduction   = $spreadsheet->getSheet(1)->toArray();

        //sheet 1 jadwal patroli
        $sheet1 = $spreadsheet->getSheet(0);
        //sheet 2 jadwal produksi
        $sheet2 = $spreadsheet->getSheet(1);

        //waktu patroli
        $bulan_jadwal_patroli  = $sheet1->getCell('B2');
        $tahun_jadwal_patroli  = $sheet1->getCell('B3');
        $kode_plant            = $sheet1->getCell('A6');

        //waktu produksi
        $bulan_jadwal_produksi = $sheet2->getCell('B2');
        $tahun_jadwal_produksi = $sheet2->getCell('B3');

        $data_jadwal = array();
        $data_production = array();

        $dataPlant = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $kode_plant])->row();
        unset($datajadwal[0]);
        unset($datajadwal[1]);
        unset($datajadwal[2]);
        unset($datajadwal[3]);
        unset($datajadwal[4]);

        foreach ($datajadwal as $jdl) {
            $dataUser = $this->db->get_where("admisecsgp_mstusr", ['npk' => $jdl[2]])->row();
            $params_jadwal = [
                'bulan'                      => strtoupper($bulan_jadwal_patroli),
                'tahun'                      => $tahun_jadwal_patroli,
                'admisecsgp_mstusr_id'       => $dataUser->id,
                'admisecsgp_mstplant_id'     => $dataPlant->id,
                'tanggal_1'                  => strval($jdl[4]),
                'tanggal_2'                  => strval($jdl[5]),
                'tanggal_3'                  => strval($jdl[6]),
                'tanggal_4'                  => strval($jdl[7]),
                'tanggal_5'                  => strval($jdl[8]),
                'tanggal_6'                  => strval($jdl[9]),
                'tanggal_7'                  => strval($jdl[10]),
                'tanggal_8'                  => strval($jdl[11]),
                'tanggal_9'                  => strval($jdl[12]),
                'tanggal_10'                 => strval($jdl[13]),
                'tanggal_11'                 => strval($jdl[14]),
                'tanggal_12'                 => strval($jdl[15]),
                'tanggal_13'                 => strval($jdl[16]),
                'tanggal_14'                 => strval($jdl[17]),
                'tanggal_15'                 => strval($jdl[18]),
                'tanggal_16'                 => strval($jdl[19]),
                'tanggal_17'                 => strval($jdl[20]),
                'tanggal_18'                 => strval($jdl[21]),
                'tanggal_19'                 => strval($jdl[22]),
                'tanggal_20'                 => strval($jdl[23]),
                'tanggal_21'                 => strval($jdl[24]),
                'tanggal_22'                 => strval($jdl[25]),
                'tanggal_23'                 => strval($jdl[27]),
                'tanggal_24'                 => strval($jdl[28]),
                'tanggal_25'                 => strval($jdl[29]),
                'tanggal_26'                 => strval($jdl[30]),
                'tanggal_27'                 => strval($jdl[31]),
                'tanggal_28'                 => strval($jdl[32]),
                'tanggal_29'                 => strval($jdl[32]),
                'tanggal_30'                 => strval($jdl[33]),
                'tanggal_31'                 => strval($jdl[34]),
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),

            ];

            array_push($data_jadwal, $params_jadwal);
        }


        unset($dataproduction[0]);
        unset($dataproduction[1]);
        unset($dataproduction[2]);
        unset($dataproduction[3]);
        unset($dataproduction[4]);
        // //
        foreach ($dataproduction as $prd) {
            $cekshift  = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $prd[0]])->row();
            $cekprod1  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[1]])->row();
            $cekprod2  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[2]])->row();
            $cekprod3  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[3]])->row();
            $cekprod4  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[4]])->row();
            $cekprod5  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[5]])->row();
            $cekprod6  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[6]])->row();
            $cekprod7  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[7]])->row();
            $cekprod8  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[8]])->row();
            $cekprod9   = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[9]])->row();
            $cekprod10  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[10]])->row();
            $cekprod11  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[11]])->row();
            $cekprod12  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[12]])->row();
            $cekprod13  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[13]])->row();
            $cekprod14  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[14]])->row();
            $cekprod15  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[15]])->row();
            $cekprod16  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[16]])->row();
            $cekprod17  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[17]])->row();
            $cekprod18  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[18]])->row();
            $cekprod19  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[19]])->row();
            $cekprod20  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[20]])->row();
            $cekprod21  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[21]])->row();
            $cekprod22  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[22]])->row();
            $cekprod23  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[23]])->row();
            $cekprod24  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[24]])->row();
            $cekprod25  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[25]])->row();
            $cekprod26  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[26]])->row();
            $cekprod27  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[27]])->row();
            $cekprod28  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[28]])->row();
            $cekprod29  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[29]])->row();
            $cekprod30  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[30]])->row();
            $cekprod31  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[31]])->row();
            $params_prod = [
                'bulan'                      => strtoupper($bulan_jadwal_patroli),
                'tahun'                      => $tahun_jadwal_patroli,
                'admisecsgp_mstplant_id'     => $dataPlant->id,
                'admisecsgp_mstshift_id'     => $cekshift->id,
                'tanggal_1'                  => $cekprod1->id,
                'tanggal_2'                  => $cekprod2->id,
                'tanggal_3'                  => $cekprod3->id,
                'tanggal_4'                  => $cekprod4->id,
                'tanggal_5'                  => $cekprod5->id,
                'tanggal_6'                  => $cekprod6->id,
                'tanggal_7'                  => $cekprod7->id,
                'tanggal_8'                  => $cekprod8->id,
                'tanggal_9'                  => $cekprod9->id,
                'tanggal_10'                 => $cekprod10->id,
                'tanggal_11'                 => $cekprod11->id,
                'tanggal_12'                 => $cekprod12->id,
                'tanggal_13'                 => $cekprod13->id,
                'tanggal_14'                 => $cekprod14->id,
                'tanggal_15'                 => $cekprod15->id,
                'tanggal_16'                 => $cekprod16->id,
                'tanggal_17'                 => $cekprod17->id,
                'tanggal_18'                 => $cekprod18->id,
                'tanggal_19'                 => $cekprod19->id,
                'tanggal_20'                 => $cekprod20->id,
                'tanggal_21'                 => $cekprod21->id,
                'tanggal_22'                 => $cekprod22->id,
                'tanggal_23'                 => $cekprod23->id,
                'tanggal_24'                 => $cekprod24->id,
                'tanggal_25'                 => $cekprod25->id,
                'tanggal_26'                 => $cekprod26->id,
                'tanggal_27'                 => $cekprod27->id,
                'tanggal_28'                 => $cekprod28->id,
                'tanggal_29'                 => $cekprod29->id,
                'tanggal_30'                 => $cekprod30->id,
                'tanggal_31'                 => $cekprod31->id,
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
            ];
            array_push($data_production, $params_prod);
        }

        $save_jadwal = $this->M_patrol->mulitple_upload("admisecsgp_mstjadwalpatroli", $data_jadwal);
        $save_prod = $this->M_patrol->mulitple_upload("admisecsgp_mstproductiondtls", $data_production);

        if ($save_jadwal && $save_prod) {
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload data');
            redirect('Mst_Jadwal');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data');
            redirect('Mst_Jadwal/form_upload_jadwal');
        }
    }

    public function form_koreksi_jadwal()
    {
        $filename = "upload_jadwal";
        if (isset($_POST['view'])) {
            $upload = $this->M_patrol->uploadJadwal($filename);
            if ($upload['result'] == "success") {
                $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
                $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet      = $reader->load($path_xlsx);
                $datajadwal       = $spreadsheet->getSheet(0)->toArray();
                $dataproduction   = $spreadsheet->getSheet(1)->toArray();
                unset($datajadwal[0]);
                unset($datajadwal[1]);
                unset($datajadwal[2]);
                unset($datajadwal[3]);
                unset($datajadwal[4]);
                unset($dataproduction[0]);
                unset($dataproduction[1]);
                unset($dataproduction[2]);
                unset($dataproduction[3]);
                unset($dataproduction[4]);


                //sheet 1 jadwal patroli
                $sheet1 = $spreadsheet->getSheet(0);
                //sheet 2 jadwal produksi
                $sheet2 = $spreadsheet->getSheet(1);
                //waktu patroli
                $bulan_jadwal_patroli  = $sheet1->getCell('B2');
                $tahun_jadwal_patroli  = $sheet1->getCell('B3');
                $kode_plant            = $sheet1->getCell('A6');

                //waktu produksi
                $bulan_jadwal_produksi    = $sheet2->getCell('B2');
                $tahun_jadwal_produksi    = $sheet2->getCell('B3');
                $data['jadwal']           = $datajadwal;
                $data['produksi']         = $dataproduction;
                $data['bulan_patroli']    = $bulan_jadwal_patroli;
                $data['tahun_patroli']    = $tahun_jadwal_patroli;
                $data['plant']            = $kode_plant;
            } else {
                $e                    = $upload['error'];
                $data['upload_error'] = $e;
            }
        }
        $data['link'] =  $this->uri->segment(1);
        // $this->template->load("template/template", "koreksi_jadwal", $data);
        $this->load->view("template/sidebar", $data);
        $this->load->view("koreksi_jadwal", $data);
        $this->load->view("template/footer");
    }



    //upload koreksi 
    public function upload_koreksi()
    {
        $filename = "upload_jadwal";
        $path_xlsx        = "./assets/path_upload/" . $filename . ".xlsx";
        $reader           = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet      = $reader->load($path_xlsx);
        $datajadwal       = $spreadsheet->getSheet(0)->toArray();
        $dataproduction   = $spreadsheet->getSheet(1)->toArray();



        //sheet 1 jadwal patroli
        $sheet1 = $spreadsheet->getSheet(0);
        //sheet 2 jadwal produksi
        $sheet2 = $spreadsheet->getSheet(1);

        //waktu patroli
        $bulan_jadwal_patroli  = $sheet1->getCell('B2');
        $tahun_jadwal_patroli  = $sheet1->getCell('B3');
        $kode_plant            = $sheet1->getCell('A6');

        //waktu produksi
        $bulan_jadwal_produksi = $sheet2->getCell('B2');
        $tahun_jadwal_produksi = $sheet2->getCell('B3');


        $data_jadwal = array();
        $data_production = array();


        $dataPlant = $this->db->get_where("admisecsgp_mstplant", ['kode_plant' => $kode_plant])->row();
        unset($datajadwal[0]);
        unset($datajadwal[1]);
        unset($datajadwal[2]);
        unset($datajadwal[3]);
        unset($datajadwal[4]);



        foreach ($datajadwal as $jdl) {
            $dataUser = $this->db->get_where("admisecsgp_mstusr", ['npk' => $jdl[2]])->row();
            $params_jadwal = [
                'bulan'                      => strtoupper($bulan_jadwal_patroli),
                'tahun'                      => $tahun_jadwal_patroli,
                'admisecsgp_mstusr_id'       => $dataUser->id,
                'admisecsgp_mstplant_id'     => $dataPlant->id,
                'tanggal_1'                  => strval($jdl[4]),
                'tanggal_2'                  => strval($jdl[5]),
                'tanggal_3'                  => strval($jdl[6]),
                'tanggal_4'                  => strval($jdl[7]),
                'tanggal_5'                  => strval($jdl[8]),
                'tanggal_6'                  => strval($jdl[9]),
                'tanggal_7'                  => strval($jdl[10]),
                'tanggal_8'                  => strval($jdl[11]),
                'tanggal_9'                  => strval($jdl[12]),
                'tanggal_10'                 => strval($jdl[13]),
                'tanggal_11'                 => strval($jdl[14]),
                'tanggal_12'                 => strval($jdl[15]),
                'tanggal_13'                 => strval($jdl[16]),
                'tanggal_14'                 => strval($jdl[17]),
                'tanggal_15'                 => strval($jdl[18]),
                'tanggal_16'                 => strval($jdl[19]),
                'tanggal_17'                 => strval($jdl[20]),
                'tanggal_18'                 => strval($jdl[21]),
                'tanggal_19'                 => strval($jdl[22]),
                'tanggal_20'                 => strval($jdl[23]),
                'tanggal_21'                 => strval($jdl[24]),
                'tanggal_22'                 => strval($jdl[25]),
                'tanggal_23'                 => strval($jdl[27]),
                'tanggal_24'                 => strval($jdl[28]),
                'tanggal_25'                 => strval($jdl[29]),
                'tanggal_26'                 => strval($jdl[30]),
                'tanggal_27'                 => strval($jdl[31]),
                'tanggal_28'                 => strval($jdl[32]),
                'tanggal_29'                 => strval($jdl[32]),
                'tanggal_30'                 => strval($jdl[33]),
                'tanggal_31'                 => strval($jdl[34]),
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),

            ];

            array_push($data_jadwal, $params_jadwal);
        }


        unset($dataproduction[0]);
        unset($dataproduction[1]);
        unset($dataproduction[2]);
        unset($dataproduction[3]);
        unset($dataproduction[4]);
        // //
        foreach ($dataproduction as $prd) {
            $cekshift = $this->db->get_where("admisecsgp_mstshift", ['nama_shift' => $prd[0]])->row();
            $cekprod1  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[1]])->row();
            $cekprod2  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[2]])->row();
            $cekprod3  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[3]])->row();
            $cekprod4  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[4]])->row();
            $cekprod5  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[5]])->row();
            $cekprod6  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[6]])->row();
            $cekprod7  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[7]])->row();
            $cekprod8  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[8]])->row();
            $cekprod9 = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[9]])->row();
            $cekprod10  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[10]])->row();
            $cekprod11  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[11]])->row();
            $cekprod12  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[12]])->row();
            $cekprod13  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[13]])->row();
            $cekprod14  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[14]])->row();
            $cekprod15  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[15]])->row();
            $cekprod16  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[16]])->row();
            $cekprod17  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[17]])->row();
            $cekprod18  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[18]])->row();
            $cekprod19  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[19]])->row();
            $cekprod20  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[20]])->row();
            $cekprod21  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[21]])->row();
            $cekprod22  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[22]])->row();
            $cekprod23  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[23]])->row();
            $cekprod24  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[24]])->row();
            $cekprod25  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[25]])->row();
            $cekprod26  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[26]])->row();
            $cekprod27  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[27]])->row();
            $cekprod28  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[28]])->row();
            $cekprod29  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[29]])->row();
            $cekprod30  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[30]])->row();
            $cekprod31  = $this->db->get_where("admisecsgp_mstproduction", ['name' => $prd[31]])->row();
            $params_prod = [
                'bulan'                      => strtoupper($bulan_jadwal_patroli),
                'tahun'                      => $tahun_jadwal_patroli,
                'admisecsgp_mstplant_id'     => $dataPlant->id,
                'admisecsgp_mstshift_id'     => $cekshift->id,
                'tanggal_1'                  => $cekprod1->id,
                'tanggal_2'                  => $cekprod2->id,
                'tanggal_3'                  => $cekprod3->id,
                'tanggal_4'                  => $cekprod4->id,
                'tanggal_5'                  => $cekprod5->id,
                'tanggal_6'                  => $cekprod6->id,
                'tanggal_7'                  => $cekprod7->id,
                'tanggal_8'                  => $cekprod8->id,
                'tanggal_9'                  => $cekprod9->id,
                'tanggal_10'                 => $cekprod10->id,
                'tanggal_11'                 => $cekprod11->id,
                'tanggal_12'                 => $cekprod12->id,
                'tanggal_13'                 => $cekprod13->id,
                'tanggal_14'                 => $cekprod14->id,
                'tanggal_15'                 => $cekprod15->id,
                'tanggal_16'                 => $cekprod16->id,
                'tanggal_17'                 => $cekprod17->id,
                'tanggal_18'                 => $cekprod18->id,
                'tanggal_19'                 => $cekprod19->id,
                'tanggal_20'                 => $cekprod20->id,
                'tanggal_21'                 => $cekprod21->id,
                'tanggal_22'                 => $cekprod22->id,
                'tanggal_23'                 => $cekprod23->id,
                'tanggal_24'                 => $cekprod24->id,
                'tanggal_25'                 => $cekprod25->id,
                'tanggal_26'                 => $cekprod26->id,
                'tanggal_27'                 => $cekprod27->id,
                'tanggal_28'                 => $cekprod28->id,
                'tanggal_29'                 => $cekprod29->id,
                'tanggal_30'                 => $cekprod30->id,
                'tanggal_31'                 => $cekprod31->id,
                'status'                     => 1,
                'created_at'                 => date('Y-m-d H:i:s'),
                'created_by'                 => $this->session->userdata('id_token'),
            ];
            array_push($data_production, $params_prod);
        }


        $update_patroli = $this->M_patrol->update("admisecsgp_mstjadwalpatroli", ['status' => 0], [
            'bulan'                      => strtoupper($bulan_jadwal_patroli),
            'tahun'                      => $tahun_jadwal_patroli,
            'admisecsgp_mstplant_id'     => $dataPlant->id,
        ]);
        $update_produksi = $this->M_patrol->update("admisecsgp_mstproductiondtls", [
            'status'             => 0,
            'updated_at'         => date('Y-m-d H:i:s'),
            'updated_by'         => $this->session->userdata('id_token'),
        ], [
            'bulan'                      => strtoupper($bulan_jadwal_patroli),
            'tahun'                      => $tahun_jadwal_patroli,
            'admisecsgp_mstplant_id'     => $dataPlant->id,
        ]);

        if ($update_patroli && $update_produksi) {
            $save_jadwal = $this->M_patrol->mulitple_upload("admisecsgp_mstjadwalpatroli", $data_jadwal);
            $save_prod = $this->M_patrol->mulitple_upload("admisecsgp_mstproductiondtls", $data_production);
            $save_jadwal;
            $save_prod;
            $this->session->set_flashdata('info', '<i class="icon fas fa-check"></i> Berhasil upload  , jadwal telah di perbaharui');
            redirect('Mst_Jadwal');
        } else {
            $this->session->set_flashdata('fail', '<i class="icon fas fa-exclamation-triangle"></i> Gagal upload data jadwal');
            redirect('Mst_Jadwal/form_upload_jadwal');
        }
    }
}
