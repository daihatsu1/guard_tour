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
		$date = $dateTime->format('Y-m-d');

		$sql = "select s.nama_shift as shift,
       				s.shift_id, 
					convert(varchar,s.jam_masuk,120) as jam_masuk,
					convert(varchar,s.jam_masuk,120) as jam_masuk,
       				p.plant_name, 
       				p.plant_id as plant_id
				from admisecsgp_trans_jadwal_patroli,         
					admisecsgp_mstplant p ,
					admisecsgp_mstshift s
				where          
				admisecsgp_mstplant_plant_id = p.plant_id
				and admisecsgp_mstshift_shift_id  = s.shift_id
				AND date_patroli = '" . $date . "'
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
		//		$tanggal = $dateTime->format('j');
		//		$bulan = get_bulan($dateTime->format('m'));
		//		$tahun = $dateTime->format('Y');

		//		$kolom_tgl_zona = "jp.tanggal_" . $tanggal;
		//		$kolom_stat_zona = "jp.ss_" . $tanggal;
		$date = $dateTime->format('Y-m-d');


		$sql = "SELECT zn.zone_id as id,
       					pl.plant_id as plant_id,
						pl.plant_name, 
						zn.zone_name
				FROM admisecsgp_mstzone zn, 
					 admisecsgp_mstplant pl
				WHERE zn.status = 1  
				  and zn.admisecsgp_mstplant_plant_id = '" . $plant_id . "' ";
		return $this->db->query($sql)->result();
	}

	public function getCheckPoint($zone_id)
	{
		return $this->db->query("
				SELECT checkpoint_id as id,
					   check_name,
					   check_no as no_nfc,
					   admisecsgp_mstzone_zone_id as zone_id,
					   CAST(
						CASE
						  WHEN status=1 THEN 'AKTIF'
						ELSE 'INACTIVE'
						END
						as varchar
					) as status_checkpoint 
				from admisecsgp_mstckp 
				where 	status=1 
				and		admisecsgp_mstzone_zone_id ='" . $zone_id . "' ")->result();
	}

	public function getObjek($check)
	{
		return $this->db->query("
				select objek_id as id,
				       admisecsgp_mstckp_checkpoint_id as checkpoint_id,
					   nama_objek,
					   status  
				from admisecsgp_mstobj 
				where status='1'
				  and admisecsgp_mstckp_checkpoint_id  ='" . $check . "'")->result();
	}

	public function getEvent($objek)
	{
		return $this->db->query("
				SELECT ev.event_id as id, 
				       ob.objek_id as object_id, 
				       ev.event_name  
				from admisecsgp_mstevent ev,  
				     admisecsgp_mstkobj ko, 
				     admisecsgp_mstobj ob 
				where ob.objek_id = '" . $objek . "' 
				and ko.kategori_id = ob.admisecsgp_mstkobj_kategori_id
				and ko.status=1;
				");
	}

	public function saveData($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function getDataTemuan($id)
	{
		$sql = "select TOP 1 * from admisecsgp_trans_headers where trans_header_id ='" . $id . "' ";
		$data = $this->db->query($sql)->row();
		$sqlDetail = "select * from admisecsgp_trans_details where admisecsgp_trans_headers_trans_headers_id ='" . $id . "'";
		$dataDetail = $this->db->query($sqlDetail)->result();;
		$data->detail_temuan = $dataDetail;
		return $data;
	}
}