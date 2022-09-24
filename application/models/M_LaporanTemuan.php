<?php

class M_LaporanTemuan extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = 'admisecsgp_trans_header';
		$this->load->helper('date_time');
	}

	function getJadwal($dateTime, $user_id, $plant_id)
	{
		$date = $dateTime->format('Y-m-d');

		$sql = "select s.nama_shift as shift,
       				s.shift_id, 
       				s.jam_masuk, 
       				s.jam_pulang, 
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
				  and ko.kategori_id = ob.admisecsgp_mstkobj_kategori_id
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

	public function getDetailDataTemuan($id)
	{
		$sql = "SELECT TOP 1  * from admisecsgp_trans_headers where trans_header_id ='" . $id . "'";
		$data = $this->db->query($sql)->row();
		$sqlDetail = "select * from admisecsgp_trans_details where admisecsgp_trans_headers_trans_headers_id ='" . $id . "'";
		$dataDetail = $this->db->query($sqlDetail)->result();;
		$data->detail_temuan = $dataDetail;
		return $data;
	}

	public function getTotalTemuan()
	{
		$sql = "select (select count(*) from admisecsgp_trans_details)                         as total_temuan,
			   (select count(*) from admisecsgp_trans_details where status_temuan = 1) as temuan_selesai,
			   (select count(*) from admisecsgp_trans_details where status_temuan = 0) as temuan_belum_selesai,
			   (select count(*)
				from admisecsgp_trans_details td
						 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
				where date_patroli = cast(getdate() as date))                          as temuan_hari_ini,
			   (select count(*) from admisecsgp_trans_details where laporkan_pic = 1) as laporkan_pic,
			   (select count(*) from admisecsgp_trans_details where is_tindakan_cepat = 1) as tindakan_cepat";
		return$this->db->query($sql)->row();
	}

	public function getDataTemuan()
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
		$dataDetail = $this->db->query($sqlDetail)->result();
		return $dataDetail;
	}

	public function getTemuanPlant()
	{
		$sql = "select distinct plant_name,
								plant_id,
								ath.date_patroli,
								count(distinct td.admisecsgp_mstobj_objek_id) as total_temuan
				from admisecsgp_mstplant pl
						 left join admisecsgp_mstzone mz on pl.plant_id = mz.admisecsgp_mstplant_plant_id
						 left join admisecsgp_trans_headers ath on mz.zone_id = ath.admisecsgp_mstzone_zone_id
						 inner join admisecsgp_trans_details td on td.admisecsgp_trans_headers_trans_headers_id = ath.trans_header_id
				group by plant_id, plant_name, ath.date_patroli";
		return $this->db->query($sql)->result();;

	}


}
