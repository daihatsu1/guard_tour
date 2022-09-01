<?php

class M_restPatrol extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'admisecsgp_trans_jadwal_patroli';
		$this->load->helper('date_time');
	}

	function getJadwal($dateTime, $user_id, $plant_id)
	{
		$date = $dateTime->format('d-m-Y');

		$sql = "select s.nama_shift as shift, s.shift_id, p.plant_name, p.plant_id as plant_id
					from admisecsgp_trans_jadwal_patroli,         
					admisecsgp_mstplant p ,
					admisecsgp_mstshift s
				where          
				admisecsgp_mstplant_plant_id = p.plant_id
				and admisecsgp_mstshift_shift_id  = s.shift_id
				AND date_patroli = '".$date."'
				AND admisecsgp_mstplant_plant_id = '" . $plant_id . "'
				AND admisecsgp_mstusr_npk = '" . $user_id . "'";

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
				$objects = $this->getObjek($cp->id);
				foreach ($objects as $object) {
					$event = $this->getEvent($object->id)->result();
					$object->event = $event;;
				}
				$checkpointObject[] = $cp;
				$cp->objects = $objects;
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
				  and jp.admisecsgp_mstplant_plant_id = pl.id 
				  and sh.id = jp.admisecsgp_mstshift_id  
				  and jp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'  
				  and $kolom_stat_zona  = 1 
				  and jp.bulan = '" . $bulan . "' 
				  and jp.tahun = '" . $tahun . "' 
				  and sh.nama_shift = '" . $shift_id . "'";
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

	public function getEvent($objek)
	{
		$query = $this->db->query("SELECT ed.id, o.id as object_id, ed.admisecsgp_mstevent_id as event_id, e.event_name  from admisecsgp_msteventdtls ed,  admisecsgp_mstevent e, admisecsgp_mstobj o where ed.admisecsgp_mstobj_id = '" . $objek . "' and ed.admisecsgp_mstobj_id = o.id and ed.admisecsgp_mstevent_id = e.id   and ed.status=1 ");
		return $query;
	}

	public function saveData($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function getDataTemuan($id)
	{
		$sql = "select * from admisecsgp_tr_headers where id ='" . $id . "' limit 1";
		$data = $this->db->query($sql)->row();
		$sqlDetail = "select * from admisecsg_tr_details where tr_dpg_headers_id ='" . $id . "'";
		$dataDetail = $this->db->query($sqlDetail)->result();;
		$data->detail_temuan = $dataDetail;
		return $data;
	}

}
