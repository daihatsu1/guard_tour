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

	public function getData($table, $where)
	{
		return $this->db->get_where($table, $where);
	}

	public function updateData($table, $data, $whereColumn, $where)
	{
		$this->db->where($whereColumn, $where);
		return $this->db->update($table, $data);
	}

	public function list_plants()
	{
		$query = $this->db->query('select plant_name from admisecsgp_mstplant where status =1')->result_array();
		return array_column($query, "plant_name");
	}

	public function list_zones()
	{
		$query = $this->db->query('select distinct zone_name from admisecsgp_mstzone where status =1  order by zone_name')->result_array();
		return array_column($query, "zone_name");
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

	public function getTotalTemuan($plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and zn.admisecsgp_mstplant_plant_id ='" . $plant_id . "'";
		}

		$sql = "select (select count(*)
							from admisecsgp_trans_details td
									 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
									 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
							where td.status = 0 " . $where . " ) as total_temuan,
					   (select count(*)
						from admisecsgp_trans_details td
								 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
								 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
						where status_temuan = 1
						  and td.status = 0 " . $where . ")                                                  as temuan_selesai,
					   (select count(*)
						from admisecsgp_trans_details td
								 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
								 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
						where status_temuan = 0
						  and td.status = 0 " . $where . ")                                                  as temuan_belum_selesai,
					   (select count(*)
						from admisecsgp_trans_details td
								 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
								 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
						where td.status = 0
						  and date_patroli = cast(getdate() as date) " . $where . ")                         as temuan_hari_ini,
					   (select count(*)
						from admisecsgp_trans_details td
								 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
								 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
						where laporkan_pic = 1
						  and td.status = 0 " . $where . ")                                                  as laporkan_pic,
					   (select count(*)
						from admisecsgp_trans_details td
								 join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
								 join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
						where is_tindakan_cepat = 1
						  and td.status = 0 " . $where . ")                                                  as tindakan_cepat";
		return $this->db->query($sql)->row();
	}

	public function getDataTemuan($plant_id = null, $status_temuan = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.plant_id ='" . $plant_id . "' ";
		}
		if ($status_temuan != null) {
			if ($status_temuan == 'open') {
				$where .= "and atd.status_temuan !=1";
			} else {
				$where .= "and atd.status_temuan = 1";

			}
		}

		$sqlDetail = " select usr.name                            as pelaksana,
							   pl.plant_name,
							   pl.plant_id,
							   zn.zone_name,
							   zn.zone_id,
							   ckp.checkpoint_id,
							   ckp.check_name                      as checkpoint_name,
							   sh.shift_id,
							   sh.nama_shift,
							   admisecsgp_mstobj_objek_id          as object_id,
							   am.nama_objek,
							   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
							   description,
							   image_1,
							   image_2,
							   image_3,							   
							   atd.created_at                      as date_patroli,
							   atd.trans_detail_id,
							   atd.status,
							   atd.status_temuan,
							   atd.note_tindakan_cepat,
							   atd.deskripsi_tindakan,
							   atd.updated_at
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
								 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
								 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0  and atd.is_tindakan_cepat !=1 " . $where . "
						order by atd.status_temuan, atd.created_at desc;";
		return $this->db->query($sqlDetail)->result();
	}

	public function getDataTemuanTindakanCepat($plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and pl.plant_id ='" . $plant_id . "'";
		}


		$sqlDetail = "  select usr.name                            as pelaksana,
							   pl.plant_name,
							   pl.plant_id,
							   zn.zone_name,
							   zn.zone_id,
							   ckp.checkpoint_id,
							   ckp.check_name                      as checkpoint_name,
							   sh.shift_id,
							   sh.nama_shift,
							   admisecsgp_mstobj_objek_id          as object_id,
							   am.nama_objek,
							   ath.admisecsgp_mstckp_checkpoint_id as chekpoint_id,
							   description,
							   image_1,
							   image_2,
							   image_3,							   
							   atd.created_at                      as date_patroli,
							   atd.trans_detail_id,
							   atd.status,
							   atd.status_temuan,
  							   atd.note_tindakan_cepat
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
								 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
								 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0 and atd.is_tindakan_cepat=1 and atd.created_at BETWEEN GETDATE()-7 AND GETDATE() " . $where . " 
						order by atd.status_temuan, atd.created_at desc;";
		return $this->db->query($sqlDetail)->result();
	}

	public function getTemuanPlant($year, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and plant_id ='" . $plant_id . "'";
		}
		$sql = "select distinct plant_name,
								plant_id,
								FORMAT(ath.date_patroli, 'MM')                as month,
								count(distinct td.admisecsgp_mstobj_objek_id) as total_temuan
				from admisecsgp_mstplant pl
						 left join admisecsgp_mstzone mz on pl.plant_id = mz.admisecsgp_mstplant_plant_id
						 left join admisecsgp_trans_headers ath on mz.zone_id = ath.admisecsgp_mstzone_zone_id
						 inner join admisecsgp_trans_details td on td.admisecsgp_trans_headers_trans_headers_id = ath.trans_header_id
				where td.status = 0
				  and DATEPART(YEAR, ath.date_patroli) = '" . $year . "' " . $where . " 
				group by plant_id, plant_name, FORMAT(ath.date_patroli, 'MM')";
		return $this->db->query($sql)->result();
	}

	public function getTotalTemuanByKategoriObject($plant_id, $month, $year)
	{
		$sql = "select kategori_id,
					   kategori_name,
					   iif(total_objek is null, 0, total_objek) as total_object,
					   total_temuan
				from (select kategori_id,
							 kategori_name,
							 (select count(distinct objek_id) total_obj
							  from admisecsgp_mstobj mobj
									   join admisecsgp_mstckp ckp on ckp.checkpoint_id = mobj.admisecsgp_mstckp_checkpoint_id
									   join admisecsgp_mstzone a on a.zone_id = ckp.admisecsgp_mstzone_zone_id
									   join admisecsgp_mstplant mp on a.admisecsgp_mstplant_plant_id = mp.plant_id
							  where mobj.admisecsgp_mstkobj_kategori_id = kobj.kategori_id
								and plant_id = '" . $plant_id . "'
							  group by mobj.admisecsgp_mstkobj_kategori_id)               as total_objek,
							 (select count(distinct atd.trans_detail_id)
							  from admisecsgp_trans_details atd
									   join admisecsgp_mstevent ev on atd.admisecsgp_mstevent_event_id = ev.event_id
									   join admisecsgp_trans_headers ath
											on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
									   join admisecsgp_mstzone az on ath.admisecsgp_mstzone_zone_id = az.zone_id
							  where az.admisecsgp_mstplant_plant_id = '" . $plant_id . "'
								and atd.status = 0
								and MONTH(ath.date_patroli) = " . $month . " AND YEAR(ath.date_patroli) = " . $year . "
								and ev.admisecsgp_mstkobj_kategori_id = kobj.kategori_id) as total_temuan
					  from admisecsgp_mstkobj kobj
					  where status = 1) as k order by kategori_name";
		return $this->db->query($sql)->result();
	}

	public function getTemuanByUser($year, $month, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and m.plant_id ='" . $plant_id . "'";
		}
		$sql = "select pgroup.patrol_group, total_temuan, pgroup.plant_name, pgroup.plant_id
				from (select distinct patrol_group, m.plant_id, m.plant_name
					  from admisecsgp_mstusr usr
							   join admisecsgp_mstplant m on usr.admisecsgp_mstplant_plant_id = m.plant_id
					  where patrol_group is not null) pgroup
				left join (
				select count(distinct atd.trans_detail_id) as total_temuan,
					   usr.patrol_group                    as patrol_group,
					   m.plant_name                        as plant_name,
					   m.plant_id                          as plant_id,
					   FORMAT(ath.date_patroli, 'MM')      as month
				from admisecsgp_mstusr usr
						 join admisecsgp_trans_headers ath on ath.admisecsgp_mstusr_npk = usr.npk
						 join admisecsgp_trans_details atd
							  on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
						 join admisecsgp_mstzone az on ath.admisecsgp_mstzone_zone_id = az.zone_id
						 join admisecsgp_mstplant m on az.admisecsgp_mstplant_plant_id = m.plant_id
				where status_temuan = 0
				  and ath.status = 1 
				  and MONTH(ath.date_patroli) = " . $month . " 
				  and YEAR(ath.date_patroli) = " . $year . "
				      " . $where . "
				group by usr.patrol_group, m.plant_name, m.plant_id, FORMAT(ath.date_patroli, 'MM')) u
				on pgroup.patrol_group = u.patrol_group and pgroup.plant_id = u.plant_id
				order by pgroup.plant_id";
		return $this->db->query($sql)->result();

	}

	function getTemuanZone($year, $month, $plant_id)
	{
		$where = '';
		if ($plant_id != null) {
			$where = "and az.admisecsgp_mstplant_plant_id ='" . $plant_id . "'";
		}
		$sql = "select plant_name, zplant.plant_id, zplant.zone_id, zplant.zone_name, IIF(total_temuan is null, 0, total_temuan) as total_temuan
				from (select distinct z.zone_name, z.zone_id, m.plant_id, m.plant_name
					  from admisecsgp_mstzone as z
							   join admisecsgp_mstplant m on z.admisecsgp_mstplant_plant_id = m.plant_id
					  where m.status = 1) zplant
						 left join (select az.admisecsgp_mstplant_plant_id     as plant_id,
										   az.zone_name                        as zone_name,
										   az.zone_id                          as zone_id,
										   count(distinct atd.trans_detail_id) as total_temuan
									from admisecsgp_trans_headers ath
											 join admisecsgp_trans_details atd
												  on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
											 join admisecsgp_mstzone az on ath.admisecsgp_mstzone_zone_id = az.zone_id
									where status_temuan = 0
									  and ath.status = 1
									  and MONTH(ath.date_patroli) = " . $month . "
									  and YEAR(ath.date_patroli) = " . $year . " 
									  " . $where . "
									group by az.admisecsgp_mstplant_plant_id, zone_name, zone_id) u
								   on zplant.plant_id = u.plant_id and zplant.zone_id = u.zone_id
				order by plant_id, zone_name";
		return $this->db->query($sql)->result();

	}

	public function getDataTemuanByMonth($year, $month, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.plant_id ='" . $plant_id . "' ";
		}

		$sqlDetail = " select count(atd.trans_detail_id) as total_temuan, DAY(ath.date_patroli) as day
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0  " . $where . " 
						  and MONTH(ath.date_patroli) = " . $month . " and YEAR(ath.date_patroli) = " . $year . " group by ath.date_patroli  
						order by ath.date_patroli desc;";
		return $this->db->query($sqlDetail)->result();
	}

	public function getDataTindakanByMonth($year, $month, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.plant_id ='" . $plant_id . "' ";
		}

		$sqlDetail = "select count(trans_detail_id) as total_tindakan, day
						from (select atd.trans_detail_id, DAY(ath.updated_at) as day
							  from admisecsgp_trans_details atd
									   left join admisecsgp_trans_headers ath
												 on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
									   left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
									   left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
									   left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
							  where atd.status = 0
								and atd.status_temuan = 1
								 " . $where . " 
						  		and MONTH(ath.date_patroli) = " . $month . " 
						  		and YEAR(ath.date_patroli) = " . $year . " ) as d
						group by day
						order by day desc";
		return $this->db->query($sqlDetail)->result();
	}

	public function getDataTemuanTindakanCepatByMonth($year, $month, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.plant_id ='" . $plant_id . "' ";
		}

		$sqlDetail = " select count(atd.trans_detail_id) as total_tindakan, DAY(ath.date_patroli) as day
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0 and atd.status_temuan = 1 
						and atd.is_tindakan_cepat = 1   " . $where . " 
						  and MONTH(ath.date_patroli) = " . $month . " and YEAR(ath.date_patroli) = " . $year . " group by ath.date_patroli  
						order by ath.date_patroli desc;";
		return $this->db->query($sqlDetail)->result();
	}

	public function getDataTemuanTindakanPICByMonth($year, $month, $plant_id = null)
	{
		$where = '';
		if ($plant_id != null) {
			$where .= "and pl.plant_id ='" . $plant_id . "' ";
		}

		$sqlDetail = "select count(atd.trans_detail_id) as total_tindakan, DAY(ath.date_patroli) as day
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.laporkan_pic = 1   " . $where . " 
						  and MONTH(ath.date_patroli) = " . $month . " 
						  and YEAR(ath.date_patroli) = " . $year . " group by ath.date_patroli  
						order by ath.date_patroli desc;";
		return $this->db->query($sqlDetail)->result();
	}

}
