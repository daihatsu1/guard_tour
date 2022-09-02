<?php

class M_restJadwal extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'admisecsgp_mstjadwalpatroli';
		$this->load->helper('date_time');
	}

	function getJadwal($dateTime, $user_id, $plant_id)
	{
		$tanggal = $dateTime->format('j');
		$bulan = get_bulan($dateTime->format('m'));
		$tahun = $dateTime->format('Y');

		$sql = "select tanggal_" . $tanggal . " as shift, p.plant_name, p.id as plant_id
					from admisecsgp_mstjadwalpatroli,         
					admisecsgp_mstplant p 
				where          
				admisecsgp_mstplant_id = p.id
				AND bulan = '" . $bulan . "' 
					AND tahun = '" . $tahun . "'
					AND admisecsgp_mstplant_id = '" . $plant_id . "'
  					AND admisecsgp_mstusr_id = '" . $user_id . "'";
		$result = $this->db->query($sql)->row();
		if ($result) {
			$result->date = $dateTime->format('d-m-Y');
		}
		return $result;

	}

	function getDataPatroli($dateTime, $shift_id, $plant_id)
	{
		$dataPatroli = [];
		$zones = $this->getZones($dateTime, $shift_id, $plant_id);

		foreach ($zones as $zone) {
			$checkpoint = $this->getCheckPoint($zone->id);
			$checkpointObject = [];
			foreach ($checkpoint as $cp) {
				$cp->objects = $this->getObjek($cp->id);
				$checkpointObject[] = $cp;
			}
			$zone->checkpoints = $checkpointObject;
			$dataPatroli[] = $zone;
		}
		return $dataPatroli;
	}

	function getZones($dateTime, $shift_id, $plant_id)
	{
		$tanggal = $dateTime->format('j');
		$bulan = get_bulan($dateTime->format('m'));
		$tahun = $dateTime->format('Y');

		$kolom_tgl_zona = "jp.tanggal_" . $tanggal;
		$kolom_stat_zona = "jp.ss_" . $tanggal;

		$sql = "SELECT 	jp.id as production_detail_id, 
        				zn.id as id,
       					pl.id as plant_id,
						pl.plant_name, zn.zone_name ,
						jp.admisecsgp_mstzone_id as zona_id, 
						jp.bulan,
						$kolom_tgl_zona,
						sh.nama_shift, 
						jp.status
				FROM admisecsgp_mstproductiondtls jp ,
					 admisecsgp_mstplant pl, 
					 admisecsgp_mstzone zn, 
					 admisecsgp_mstshift sh 
				WHERE jp.status = 1  
				  and zn.id = jp.admisecsgp_mstzone_id  
				  and jp.admisecsgp_mstplant_id = pl.id 
				  and sh.id = jp.admisecsgp_mstshift_id  
				  and jp.admisecsgp_mstplant_id = '" . $plant_id . "'  
				  and $kolom_stat_zona  = 1 
				  and jp.bulan = '" . $bulan . "' 
				  and jp.tahun = '" . $tahun . "' 
				  and sh.nama_shift = '" . $shift_id . "'";
//		var_dump($sql);
		return $this->db->query($sql)->result();
	}

	public function getCheckPoint($zone_id)
	{
		return $this->db->query("
				SELECT id,
					   check_name,
					   check_no as no_nfc,
					   admisecsgp_mstzone_id as zone_id,
					   IF(status=1,'AKTIF', 'INACTIVE') as status_checkpoint 
				from admisecsgp_mstckp 
				where 	status=1 
				and		admisecsgp_mstzone_id ='" . $zone_id . "' ")->result();
	}

	public function getObjek($check)
	{
		return $this->db->query("
				select id,
				       admisecsgp_mstckp_id as checkpoint_id,
					   nama_objek,
					   status  
				from admisecsgp_mstobj 
				where status='1'
				  and admisecsgp_mstckp_id  ='" . $check . "'")->result();
	}

	public function ambilEvent($objek)
	{
		$query = $this->db->query("SELECT ed.id, ed.admisecsgp_mstevent_id as event_id, e.event_name  from admisecsgp_msteventdtls ed,  admisecsgp_mstevent e, admisecsgp_mstobj o where ed.admisecsgp_mstobj_id = '" . $objek . "' and ed.admisecsgp_mstobj_id = o.id and ed.admisecsgp_mstevent_id = e.id   and ed.status=1 ");
		return $query;
	}


}
