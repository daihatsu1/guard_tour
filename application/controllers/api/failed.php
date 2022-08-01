<?php


class Failed extends CI_Controller
{

    public function fail(Type $var = null)
    {
        $bln   = date('m');
        $tahun = date('Y');
        $hari_besok      = date('Y-m-D', strtotime("+1 day", strtotime(date("Y-m-d"))));
        $hari_sekarang   = date('Y-m-D');
        $split_besok     = explode('-', $hari_besok);
        $split_sekarang  = explode('-', $hari_sekarang);
        $hasil_split_besok = $split_besok[2];
        $hasil_split_sekarang = $split_sekarang[2];
        $day_now     = $this->hari($hasil_split_sekarang);
        $day_esok    = $this->hari($hasil_split_besok);

        $now             = date('Y-m-d');
        $idUser          = $this->get("id_user");
        $plant_id        = $this->get("id_plant");

        $date_besok      = date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))));
        $date_kemarin    = date('Y-m-d', strtotime("-1 day", strtotime(date("Y-m-d"))));
        $today           = date('Y-m-d');
        $var_besok       = explode('-', $date_besok);
        $var_kemarin     = explode('-', $date_kemarin);

        $besok           = $var_besok[2];
        $kemarin         = $var_kemarin[2];
        $hari_ini_       = date('d');
        $hari_ini        = date('d');
        $bulan           = $this->bulan($bln);
        $bln_            = strtolower($bulan);

        if ($hari_ini_ <= '09') {
            $v = explode('0', $hari_ini_);
            $hari_ini_ = $v[1];
            // echo "Hari ini Tanggal " . $hari_ini . "\n";
        } else {
            $hari_ini_ = $hari_ini_;
            // echo "Hari ini Tanggal " . $hari_ini . "\n";
        }

        if ($hari_ini <= '09') {
            $v = explode('0', $hari_ini);
            $hari_ini = $v[1];
            // echo "Hari ini Tanggal " . $hari_ini . "\n";
        } else {
            $hari_ini = $hari_ini;
            // echo "Hari ini Tanggal " . $hari_ini . "\n";
        }

        if ($besok <= '09') {
            $v = explode('0', $besok);
            $besok = $v[1];
            // echo "Besok Tanggal " . $besok . "\n";
        } else {
            // echo "Besok Tanggal " . $besok . "\n";
            $besok = $besok;
        }

        if ($kemarin <= '09') {
            $v = explode('0',  $kemarin);
            $kemarin = $v[1];
            // echo "Kemarin Tanggal " .  $kemarin . "\n";
        } else {
            // echo "Kemarin Tanggal " .  $kemarin . "\n";
            $kemarin = $kemarin;
        }

        $hari_lengkap_sekarang   = $day_now  . ' ' . $hari_ini_ . ' ' . ucfirst($bln_) . ' ' . date('Y');
        $hari_lengkap_besok      = $day_esok  . ' ' . $besok . ' ' . ucfirst($bln_) . ' ' . date('Y');
        $cari_data   = $this->M_api->jadwalPatroli($idUser, $plant_id, $tahun, $bulan, $hari_ini, $besok, $kemarin);

        if ($cari_data->num_rows() > 0) {
            $this->response(
                [
                    'status'            => 'ok',
                    'tanggal_sekarang'  => $hari_lengkap_sekarang,
                    'tanggal_besok'     => $hari_lengkap_besok,
                    'tanggal_get_zona'  => $hari_ini,
                    'result'            => $cari_data->row()
                ],
                200
            );
        } else {
            $this->response(
                [
                    'status'    => 'nok',
                    'result'    =>  'tidak ada jadwal patroli untuk anda'
                ],
                400
            );
        }
    }


    public function showZonaPatroli_get()
    {
        $bulan    = $this->get("bulan");
        $idplant  = $this->get("idplant");
        $shift    = $this->get("shift");
        $tanggal  = $this->get("tanggal");
        $tahun    = $this->get("tahun");
        $data_shift = $this->db->query("SELECT * From admisecsgp_mstshift WHERE nama_shift='" . $shift . "'");

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

            $data_zona  = $this->db->query("SELECT jp.id , pl.plant_name , zn.zone_name , jp.admisecsgp_mstzone_id as zona_id  ,  jp.bulan , jp.tanggal_8 , sh.nama_shift , jp.status  FROM admisecsgp_mstproductiondtls jp ,admisecsgp_mstplant pl , admisecsgp_mstzone zn , admisecsgp_mstshift sh 
            WHERE jp.status = 1  and zn.id = jp.admisecsgp_mstzone_id  and jp.admisecsgp_mstplant_id = pl.id and sh.id = jp.admisecsgp_mstshift_id  and jp.admisecsgp_mstplant_id = '" . $idplant . "'  and jp.ss_8 = 1 and jp.bulan = '" . $bulan . "' and jp.tahun = '" . $tahun . "' and jp.admisecsgp_mstshift_id = '" . $rinci_shift->id . "' ");
            $this->response(
                [
                    'status'    => 'ok',
                    'result'    => $data_zona->result()
                ],
                200
            );
        }
    }
}
