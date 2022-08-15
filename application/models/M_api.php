<?php

class M_api extends CI_Model
{

    //cek login
    public function Login($npk, $password)
    {
        $query  = $this->db->query("
        SELECT u.id ,  u.name , u.npk , u.admisecsgp_mstplant_id as plant_id , p.plant_name 
         FROM admisecsgp_mstusr  u, admisecsgp_mstplant p
        WHERE u.admisecsgp_mstplant_id = p.id 
        AND u.npk = '" . $npk . "' 
        AND u.password = '" . $password . "'");
        return $query;
    }


    //ambil jadwal patroli per tanggal 
    public function jadwalPatroli($idUser, $plant_id, $tahun, $bulan, $hari_ini, $besok, $kemarin)
    {
        $tanggal1 = "jdl.tanggal_" . $hari_ini;
        $tanggal2 = "jdl.tanggal_" . $besok;
        $tanggal3 = "jdl.tanggal_" . $kemarin;
        $query =  $this->db->query("SELECT jdl.bulan , p.plant_name , usr.admisecsgp_mstplant_id AS plant_id , usr.name , usr.npk , $tanggal1 AS hari_ini , $tanggal2 AS besok 
        FROM 
        `admisecsgp_mstjadwalpatroli` jdl  ,
        `admisecsgp_mstusr` usr ,
        admisecsgp_mstplant p 
        WHERE 
        jdl.admisecsgp_mstusr_id = usr.id 
        AND admisecsgp_mstusr_id = '" . $idUser . "' 
        AND usr.admisecsgp_mstplant_id = p.id
        AND usr.admisecsgp_mstplant_id = '" . $plant_id . "'
        AND bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");
        return $query;
    }

    //show jadwal patroli per 2 hari anggota untuk dashboard 
    public function showJadwalPatroliAnggota($idUser, $plant_id, $tahun, $bulan, $today, $next_day)
    {
        $kolom_tanggal_today = "jdl.tanggal_" . $today;
        $kolom_tanggal_next = "jdl.tanggal_" . $next_day;
        $query = $this->db->query("SELECT jdl.bulan , p.plant_name , usr.admisecsgp_mstplant_id AS plant_id , usr.name , usr.npk , $kolom_tanggal_today AS shift_patroli_sekarang  , $kolom_tanggal_next as shift_patroli_selanjutnya 
        FROM 
        admisecsgp_mstjadwalpatroli jdl  ,
        admisecsgp_mstusr usr ,
        admisecsgp_mstplant p 
        WHERE 
        jdl.admisecsgp_mstusr_id = usr.id 
        AND admisecsgp_mstusr_id = '" . $idUser . "' 
        AND usr.admisecsgp_mstplant_id = p.id
        AND usr.admisecsgp_mstplant_id = '" . $plant_id . "'
        AND bulan = '" . $bulan . "' AND tahun = '" . $tahun . "'");

        return $query;
    }


    //tampilkan daftar zona yang aktif  per tanggal
    public function jadwalProduksi($tahun, $bulan, $tgl, $shift_id, $plant_id)
    {
        $col_tanggal = "tanggal_" . $tgl;
        $statu_zona_col = "ss_" . $tgl;

        $prdss = "prd.ss_" . $tgl;
        $prdtanggal = "prd.tanggal_" . $tgl;
        $query  = $this->db->query("SELECT prd.id , prd.tahun , prd.bulan , plt.plant_name , zn.zone_name , sh.nama_shift ,$col_tanggal , $statu_zona_col , pro.name AS status_produksi
        FROM `admisecsgp_mstproductiondtls` prd , `admisecsgp_mstplant` plt , `admisecsgp_mstzone` zn ,`admisecsgp_mstshift` sh ,
        `admisecsgp_mstproduction` pro
        WHERE
        prd.admisecsgp_mstshift_id  =  $shift_id 
        AND prd.admisecsgp_mstplant_id = $plant_id 
        AND prd.admisecsgp_mstshift_id = sh.id
        AND prd.admisecsgp_mstzone_id = zn.id 
        AND prd.admisecsgp_mstplant_id = plt.id 
        AND $prdtanggal = pro.id
        AND $prdss = 1
        AND prd.bulan = '" . $bulan . "'
        AND prd.tahun = '" . $tahun . "'
        AND prd.status = 1 ");
        return $query;
    }


    //tampilkan zona yang harus di patroli 
    public function ambilZonadiJadwal($idplant, $tahun, $bulan, $tanggal, $shift_id)
    {
        $kolom_tgl_zona = "jp.tanggal_" . $tanggal;
        $kolom_stat_zona = "jp.ss_" . $tanggal;
        $query  = $this->db->query("SELECT jp.id , pl.plant_name , zn.zone_name , jp.admisecsgp_mstzone_id as zona_id  ,  jp.bulan , $kolom_tgl_zona , sh.nama_shift , jp.status  FROM admisecsgp_mstproductiondtls jp ,admisecsgp_mstplant pl , admisecsgp_mstzone zn , admisecsgp_mstshift sh 
        WHERE jp.status = 1  and zn.id = jp.admisecsgp_mstzone_id  and jp.admisecsgp_mstplant_id = pl.id and sh.id = jp.admisecsgp_mstshift_id  and jp.admisecsgp_mstplant_id = '" . $idplant . "'  and $kolom_stat_zona  = 1 and jp.bulan = '" . $bulan . "' and jp.tahun = '" . $tahun . "' and jp.admisecsgp_mstshift_id = '" . $shift_id . "' ");
        return $query;
    }

    public function ambilCheckPoint($zone)
    {
        $query = $this->db->query("SELECT id  , check_name , check_no as no_nfc , IF(status=1,'AKTIF' , 'INACTIVE') as status_checkpoint from admisecsgp_mstckp where status=1 and admisecsgp_mstzone_id ='" . $zone . "' ");
        return $query;
    }

    public function ambilObjek($check)
    {
        $query = $this->db->query('select id , nama_objek , status  from admisecsgp_mstobj where status="1" and admisecsgp_mstckp_id  ="' . $check . '" ');
        return $query;
    }

    public function ambilEvent($objek)
    {
        $query = $this->db->query("SELECT ed.id  , ed.admisecsgp_mstevent_id as event_id , e.event_name  from admisecsgp_msteventdtls ed ,  admisecsgp_mstevent e , admisecsgp_mstobj o where ed.admisecsgp_mstobj_id = '" . $objek . "' and ed.admisecsgp_mstobj_id = o.id and ed.admisecsgp_mstevent_id = e.id   and ed.status=1 ");
        return $query;
    }

	function createAuthKey($id,$key){
		$data = array('user_id' => $id,
			'key'=>$key,
			'level'=>2,//isi terserah ynag penting angka karena tipe data int
			'date_created'=>date('Ymd'));
		return $this->db->insert('rest_keys', $data);
	}

	function verifyCreate($id,$key){
		$this->db->where('user_id', $id);
		$this->db->where('key', $key);
		$query = $this->db->get('rest_keys');
		return $query;
	}

	function getByUser($user){
		$this->db->where('user_id', $user);
		$this->db->limit('1');
		$query = $this->db->get('rest_keys');
		return $query;
	}
}
