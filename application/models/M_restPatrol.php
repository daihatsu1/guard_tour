<?php

class M_restPatrol extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'admisecsgp_trans_jadwal_patroli';
		$ci = get_instance();
		$ci->load->helper(['date_time', 'db_settings']);
	}

	function getJadwal($dateTime, $user_id, $plant_id)
	{
		$date = $dateTime->format('Y-m-d');
		$settings = get_setting('end_patrol_time_threshold');
		$sql = "select s.nama_shift                                                                 as shift,
					   s.shift_id,
					   CONVERT(varchar,s.jam_masuk, 24) as jam_masuk,
						IIF(s.nama_shift = 'LIBUR', CONVERT(varchar, s.jam_pulang, 24),
						   CONVERT(varchar, DATEADD(MINUTE, -29, s.jam_pulang), 24)) as jam_pulang,
					   p.plant_name,
					   p.plant_id                                                                   as plant_id
				from admisecsgp_trans_jadwal_patroli,
					 admisecsgp_mstplant p,
					 admisecsgp_mstshift s
				where admisecsgp_mstplant_plant_id = p.plant_id
				  	and admisecsgp_mstshift_shift_id = s.shift_id
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
		$date = $dateTime->format('Y-m-d');
		$sql = "select z.zone_id   as id,
					   am.plant_id as plant_id,
					   am.plant_name,
					   z.zone_name
				from admisecsgp_trans_zona_patroli zp
						 left join admisecsgp_mstplant am on am.plant_id = zp.admisecsgp_mstplant_plant_id
						 left join admisecsgp_mstzone z on zp.admisecsgp_mstzone_zone_id = z.zone_id and
														   zp.admisecsgp_mstplant_plant_id = z.admisecsgp_mstplant_plant_id
						 left join admisecsgp_mstshift ams on zp.admisecsgp_mstshift_shift_id = ams.shift_id
				where z.status = 1
				  and zp.status_zona = 1
				  and am.plant_id = '" . $plant_id . "'
				  and ams.nama_shift = '" . $shift_id . "'
				and date_patroli ='" . $date . "'";

		return $this->db->query($sql)->result();
	}

	public function getCheckPoint($zone_id)
	{
		return $this->db->query("
				SELECT checkpoint_id as id,
					   check_name,
					   check_no as no_nfc,
					   admisecsgp_mstzone_zone_id as zone_id,
					   IIF(status=1,'AKTIF', 'INACTIVE') as status_checkpoint 
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
				from admisecsgp_mstevent ev
						 join admisecsgp_mstkobj ko on ev.admisecsgp_mstkobj_kategori_id = ko.kategori_id
						 join admisecsgp_mstobj ob on ko.kategori_id = ob.admisecsgp_mstkobj_kategori_id
				where ob.objek_id = '" . $objek . "'
				  and ko.status = 1");
	}

	public function saveData($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function updateData($table, $data, $whereColumn, $where)
	{
		$this->db->where($whereColumn, $where);
		return $this->db->update($table, $data);
	}

	public function getDataTemuan($id)
	{
		$sql = "SELECT TOP 1  * from admisecsgp_trans_headers where trans_header_id ='" . $id . "'";
		$data = $this->db->query($sql)->row();
		$sqlDetail = "select * from admisecsgp_trans_details where admisecsgp_trans_headers_trans_headers_id ='" . $id . "'";
		$dataDetail = $this->db->query($sqlDetail)->result();
		$data->detail_temuan = $dataDetail;
		return $data;
	}

	public function getAllDataTemuan()
	{
		$sqlDetail = "select sh.shift_id,
						   sh.nama_shift,
						   admisecsgp_mstobj_objek_id as object_id,
						   am.nama_objek,
						   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
						   description,
						   image_1 as image,
						   ath.date_patroli
						from admisecsgp_trans_details
							 left join admisecsgp_trans_headers ath
									   on ath.trans_header_id = admisecsgp_trans_details.admisecsgp_trans_headers_trans_headers_id
							 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
							 left join admisecsgp_mstobj am on admisecsgp_trans_details.admisecsgp_mstobj_objek_id = am.objek_id
					where status_temuan = 0";
		$dataDetail = $this->db->query($sqlDetail)->result();;
		return $dataDetail;

	}

}
