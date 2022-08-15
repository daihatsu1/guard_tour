<?php
defined('BASEPATH') or exit('No direct script access allowed');


require_once(APPPATH . './libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

class Patroli extends RestController
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('M_api');
    }

    public function Login_get(Type $var = null)
    {
        $npk        = $this->get("npk");
        $password   = md5($this->get("password"));
        $cari_data  = $this->M_api->Login($npk, $password);
        if ($cari_data->num_rows() > 0) {
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    =>  $cari_data->result()
                ],
                200
            );
        } else {
            $this->response(
                [
                    'status'    => 'nok',
                    'result'    =>  'user not found'
                ],
                400
            );
        }
    }

    public function hari($day)
    {
        switch ($day) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }
        return $hari_ini;
    }

    public function bulan($bln)
    {
        switch ($bln) {
            case '01':
                $bulan = 'JANUARI';
                break;
            case '02':
                $bulan = 'FEBRUARI';
                break;
            case '03':
                $bulan = 'MARET';
                break;
            case '04':
                $bulan = 'APRIL';
                break;
            case '05':
                $bulan = 'MEI';
                break;
            case '06':
                $bulan = 'JUNI';
                break;
            case '07':
                $bulan = 'JULI';
                break;
            case '08':
                $bulan = 'AGUSTUS';
                break;
            case '09':
                $bulan = 'SEPTEMBER';
                break;
            case '10':
                $bulan = 'OKTOBER';
                break;
            case '11':
                $bulan = 'NOVEMBER';
                break;
            case '12':
                $bulan = 'DESEMBER';
                break;
            default:
                '';
                break;
        }

        return $bulan;
    }


    //jadwal patroli per user
    public function jadwalPatroli_get()
    {

        //parameter yang digunakan ambil jadwal zona prooduksi
        $tahun           = date('Y');
        $idUser          = $this->get("id_user");
        $plant_id        = $this->get("id_plant");

        $time  = date('H:i:s');
        // $time  = date('05:00:01');

        //jika jam kurang dari jam 6 pagi dan lebih dari jam 12 malam , maka tanggal yang di pake tanggal h-1 
        if (strtotime($time) > strtotime('00:00:00') && strtotime($time) < strtotime('06:00:00')) {
            // echo "ambil tanggal kemarin";
            $get_tanggal             = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
            $split_get_tanggal       = explode('-', $get_tanggal);
            $tanggal_patroli         = $split_get_tanggal[2];
            if ($tanggal_patroli <= '09') {
                $v = explode('0',  $tanggal_patroli);
                $tanggal_patroli = $v[1];
                // echo "Kemarin Tanggal " .  $tanggal_patroli . "\n";
            }

            //day 
            $get_tanggal2            = date('Y-m-D', strtotime("-1 day", strtotime(date("Y-m-d"))));
            $split_get_tanggal       = explode('-',  $get_tanggal2);
            $hri_                    = $this->hari($split_get_tanggal[2]);


            //get tanggal selanjutnya 
            $get_next_day       = date('Y-m-d');
            $split_next_day     = explode('-', $get_next_day);
            $patroli_next_day   = $split_next_day[2];
            if ($patroli_next_day <= '09') {
                $v = explode('0',  $patroli_next_day);
                $patroli_next_day = $v[1];
            }

            //hari besok dalam satuan hari indonesia 
            $next_patroli    = date('Y-m-D');
            $np              = explode("-", $next_patroli);
            $day_esok        = $this->hari($np[2]);
            // bulan 
            $bulan           = $this->bulan($np[1]);
            $bln_            = strtolower($bulan);
        }
		else {
            // echo "ambil tanggal sekarang";
            $get_tanggal             = date('Y-m-d');
            $split_get_tanggal       = explode('-', $get_tanggal);
            $tanggal_patroli         = $split_get_tanggal[2];
            if ($tanggal_patroli <= '09') {
                $v = explode('0',  $tanggal_patroli);
                $tanggal_patroli = $v[1];
            }


            //get tanggal selanjutnya 
            $get_next_day       = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
            $split_next_day     = explode('-', $get_next_day);
            $patroli_next_day   = $split_next_day[2];
            if ($patroli_next_day <= '09') {
                $v = explode('0',  $patroli_next_day);
                $patroli_next_day = $v[1];
            }


            //hari besok dalam satuan hari indonesia 
            $next_patroli    = date('Y-m-D', strtotime("+1 day", strtotime(date("Y-m-d"))));
            $np              = explode("-", $next_patroli);
            $day_esok        = $this->hari($np[2]);
            $hri_            = $this->hari(date('D'));

            // bulan
            $bulan           = $this->bulan($np[1]);
            $bln_            = strtolower($bulan);
        }


        //query munculkan jadwal patroli 
        $today      = $tanggal_patroli;
        $next_day   = $patroli_next_day;

        //data dari model untuk show jadwal patroli anggota per 2 hari 
        $data_jadwal_patroli = $this->M_api->showJadwalPatroliAnggota($idUser, $plant_id, $tahun, $bulan, $today, $next_day);

        if ($data_jadwal_patroli->num_rows() > 0) {
            $this->response(
                [
                    'status'                    => 'ok',
                    'tanggal_patroli_sekarang'  =>  $hri_ . ' ' . $today . ' ' . ucfirst($bln_) . ' ' . $tahun,
                    'tanggal_patroli_selanjutnya'  =>  $day_esok  . ' ' . $next_day . ' ' . ucfirst($bln_) . ' ' . $tahun,
                    'tanggal'               => $today,
                    'result'           =>  $data_jadwal_patroli->result()
                ],
                200
            );
        } else {
            $this->response(
                [
                    'status'        => 'ok',
                    'result'        => "tidak ada jadwal"
                ],
                200
            );
        }
    }


    //tampilkan daftar zona berdasarkan jadwal patroli 
    public function showZonaPatroli_get()
    {
        $bulan    = $this->get("bulan");
        $idplant  = $this->get("idplant");
        $shift    = $this->get("shift");
        $tanggal  = $this->get("tanggal");
        $tahun    = $this->get("tahun");
        $data_shift = $this->db->query("SELECT * FROM admisecsgp_mstshift WHERE nama_shift='" . $shift . "' and status = 1 ");

        if ($shift == "LIBUR") {
            $this->response(
                [
                    'status'    => 'nok',
                    'result'    => 'anda sedang libur'
                ],
                200
            );
        } else if ($data_shift->num_rows() > 0) {
            $rinci_shift = $data_shift->row();
            $data_zona   = $this->M_api->ambilZonadiJadwal($idplant, $tahun, $bulan, $tanggal, $rinci_shift->id);
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    =>  $data_zona->result()
                ],
                404
            );
        } else {
            $this->response(
                [
                    'status'    => 'nok',
                    'result'    =>  'shift tidak diketahui'
                ],
                404
            );
        }
    }


    //tampilkan checkpoint berdasarkan zona 
    public function showCheckpoint_get()
    {
        $id = $this->get('id_zona');
        $chek = $this->M_api->ambilCheckPoint($id);
        if ($chek->num_rows() > 0) {
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    =>  $chek->result()
                ],
                200
            );
        } else {

            $this->response([
                'status'    => false,
                'message'   => 'checkpoint tidak ditemukan'
            ], 404);
        }
    }


    //tampilkan objek berdasarkan checkpoint
    public function showObjek_get()
    {
        $id = $this->get('id_check');
        $chek = $this->M_api->ambilObjek($id);
        if ($chek->num_rows() > 0) {
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    =>  $chek->result()
                ],
                200
            );
        } else {

            $this->response([
                'status'    => false,
                'message'   => 'objek tidak ditemukan'
            ], 404);
        }
    }


    //tampilkan event 
    public function showEvent_get()
    {
        $id = $this->get('id_objek');
        $event = $this->M_api->ambilEvent($id);
        if ($event->num_rows() > 0) {
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    =>  $event->result()
                ],
                200
            );
        } else {

            $this->response([
                'status'    => false,
                'message'   => 'event tidak ditemukan'
            ], 404);
        }
    }
}
