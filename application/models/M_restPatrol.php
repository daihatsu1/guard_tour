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
		$ci->load->model(['M_LaporanTemuan']);

	}

	function getCurrentShift($dateTime)
	{
		$date = $dateTime->format('Y-m-d');
		$sql = "select *
				from (
						select shift_id,
							 nama_shift,
							 CAST('" . $date . "' AS DATETIME) + CAST(jam_masuk AS DATETIME)       as jam_masuk,
							 IIF(s.jam_masuk > s.jam_pulang,
								 DATEADD(day, 1, CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)),
								 CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)) as jam_pulang
					  	from admisecsgp_mstshift s
					  	where nama_shift != 'LIBUR') as shift
				WHERE getdate() between shift.jam_masuk and shift.jam_pulang";
		return $this->db->query($sql)->row();

	}

	function getShift($date)
	{
		$date = $date->format('Y-m-d');
		$settings = get_setting('end_patrol_time_threshold');
		$threshold = $settings->nilai_setting;
		$sql = "select shift_id, nama_shift, jam_masuk, DATEADD(MINUTE, ".$threshold.", shift.jam_pulang) as jam_pulang
				from (
						select shift_id,
							 nama_shift,
							 CAST('" . $date . "' AS DATETIME) + CAST(jam_masuk AS DATETIME)       as jam_masuk,
							 IIF(s.jam_masuk > s.jam_pulang,
								 DATEADD(day, 1, CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME)),
								 CAST('" . $date . "' AS DATETIME) + CAST(jam_pulang AS DATETIME))
								 as jam_pulang
					  	from admisecsgp_mstshift s
					  	where nama_shift != 'LIBUR') as shift";
		return $this->db->query($sql)->result();

	}

	function getJadwal($dateTime, $user_id, $plant_id)
	{
		$date = $dateTime->format('Y-m-d');
		$settings = get_setting('end_patrol_time_threshold');
		$threshold = $settings->nilai_setting;
		$sql = "select id_jadwal_patroli,
    					s.nama_shift                                                                 as shift,
					   	s.shift_id,
					   	CONVERT(varchar,s.jam_masuk, 24) as jam_masuk,
						IIF(s.nama_shift = 'LIBUR', CONVERT(varchar, s.jam_pulang, 24),
						   CONVERT(varchar, DATEADD(MINUTE, ".$threshold.", s.jam_pulang), 24)) as jam_pulang,
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
		$sql = "select z.zone_name, zp.admisecsgp_mstzone_zone_id as id, am.plant_name as plant_name, zp.admisecsgp_mstplant_plant_id as plant_name
				from admisecsgp_trans_zona_patroli zp
				left join admisecsgp_mstzone z on z.zone_id = zp.admisecsgp_mstzone_zone_id
				left join admisecsgp_mstplant am on am.plant_id = zp.admisecsgp_mstplant_plant_id
				where admisecsgp_mstshift_shift_id = '" . $shift_id . "'
				  and date_patroli = '" . $date . "'
				  and zp.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
				  and status_zona = 1";

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
		$sqlDetail = "select trans_detail_id,
					   admisecsgp_trans_headers_trans_headers_id,
					   admisecsgp_mstobj_objek_id,
					   conditions,
					   admisecsgp_mstevent_event_id,
					   description,
					   (CASE WHEN image_1 IS NOT NULL 
							 THEN concat('" . base_url() . "',image_1) 
							 ELSE NULL
						END) as image_1, 
					   (CASE WHEN image_2 IS NOT NULL 
							 THEN concat('" . base_url() . "',image_2) 
							 ELSE NULL
						END) as image_2,
					   (CASE WHEN image_3 IS NOT NULL 
							 THEN concat('" . base_url() . "',image_3) 
							 ELSE NULL
						END) as image_3,
					   is_laporan_kejadian,
					   laporkan_pic,
					   is_tindakan_cepat,
					   status_temuan,
					   deskripsi_tindakan,
					   note_tindakan_cepat,
					   status,
					   created_at,
					   created_by,
					   updated_at,
					   updated_by,
					   sync_token
				from admisecsgp_trans_details where admisecsgp_trans_headers_trans_headers_id ='" . $id . "'";
		$dataDetail = $this->db->query($sqlDetail)->result();
		$data->detail_temuan = $dataDetail;
		return $data;
	}

	public function getAllDataTemuan()
	{

		$sqlDetail = "select trans_detail_id, 
    					   sh.shift_id,
						   sh.nama_shift,
						   admisecsgp_mstobj_objek_id as object_id,
						   am.nama_objek,
						   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
						   description,
							(CASE WHEN image_1 IS NOT NULL
								 THEN concat('" . base_url() . "',image_1)
								 ELSE NULL
							END) as image_1,   
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

	public function sendEmailPIC($idJadwalPatroli)
	{
		$this->load->helper('email');
		$activity = $this->db->select('distinct (usr.email), pl.plant_name, pl.plant_id')->from('admisecsgp_trans_jadwal_patroli jp')
			->join('admisecsgp_mstusr_ga as usr', 'usr.admisecsgp_mstplant_plant_id = jp.admisecsgp_mstplant_plant_id')
			->join('admisecsgp_mstplant as pl', 'pl.plant_id = jp.admisecsgp_mstplant_plant_id')
			->join('admisecsgp_mstzone as zn', 'pl.plant_id = zn.admisecsgp_mstplant_plant_id')
			->join('admisecsgp_trans_headers ath ', 'zn.zone_id = ath.admisecsgp_mstzone_zone_id')
			->join('admisecsgp_trans_details atd ', 'ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id')
			->where("usr.status = 1")
			->where("usr.email IS NOT NULL")
			->where("atd.laporkan_pic =  1")
			->where('jp.id_jadwal_patroli',
				$idJadwalPatroli)->get();

		$dataTemuan = $this->M_LaporanTemuan->getDataTemuanPICByJadwal($idJadwalPatroli);

		$PICEmail = $activity->result_array();
		if (count($PICEmail) > 0) {
			$plantId = $PICEmail[0]['plant_id'];
			$sql = $this->db->select('email')
				->from('admisecsgp_mstusr_ga')
				->where('type', 0)
				->where('status', 1)
				->where('admisecsgp_mstplant_plant_id', $plantId)
				->get()
				->result_array();
			$cc = array_column($sql, "email");
			foreach ($PICEmail as $pic) {
				if ($pic['email'] != null) {
					$params = [
						'plant_name' => $pic['plant_name'],
						'dataTemuan' => $dataTemuan
					];
					$to = $pic['email'];
					$subject = 'TEMUAN PATROLI DI ' . strtoupper($pic['plant_name']);
					$body = $this->load->view('template/email/email_pic', $params, true);
					if (sendMail($to, $cc, $subject, $body)) {
						echo "Email sent successfully.";
					} else {
						echo "Failed sent email.";
					}
				} else {
					var_dump($pic);
					log_message('error', 'PIC Tidak memiliki email');

				}
			}
			return $PICEmail;
		}
		return 'Tidak ada tindakan pic';
	}
}
