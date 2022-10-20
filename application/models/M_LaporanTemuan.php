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
		$sql = "select (select count(*) from admisecsgp_trans_details td where td.status = 0)               as total_temuan,
			   (select count(*) from admisecsgp_trans_details td where status_temuan = 1 and td.status = 0) as temuan_selesai,
			   (select count(*) from admisecsgp_trans_details td where status_temuan = 0 and td.status = 0) as temuan_belum_selesai,
			   (select count(*) from admisecsgp_trans_details td
			 	join admisecsgp_trans_headers ath on ath.trans_header_id = td.admisecsgp_trans_headers_trans_headers_id
				where td.status = 0 and date_patroli = cast(getdate() as date))                         	as temuan_hari_ini,
			   (select count(*) from admisecsgp_trans_details td where laporkan_pic = 1 and td.status = 0) 	as laporkan_pic,
			   (select count(*) from admisecsgp_trans_details td where is_tindakan_cepat = 1 and td.status = 0) as tindakan_cepat";
		return $this->db->query($sql)->row();
	}

	public function getDataTemuan()
	{
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
							   atd.status_temuan
						from admisecsgp_trans_details atd
								 left join admisecsgp_trans_headers ath
										   on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
								 left join admisecsgp_mstshift sh on sh.shift_id = ath.admisecsgp_mstshift_shift_id
								 left join admisecsgp_mstobj am on atd.admisecsgp_mstobj_objek_id = am.objek_id
								 left join admisecsgp_mstckp ckp on ath.admisecsgp_mstckp_checkpoint_id = ckp.checkpoint_id
								 left join admisecsgp_mstzone zn on ath.admisecsgp_mstzone_zone_id = zn.zone_id
								 left join admisecsgp_mstplant pl on zn.admisecsgp_mstplant_plant_id = pl.plant_id
								 left join admisecsgp_mstusr usr on usr.npk = ath.admisecsgp_mstusr_npk
						where atd.status = 0
						order by atd.status_temuan, atd.created_at desc;";
		return $this->db->query($sqlDetail)->result();
	}

	public function getTemuanPlant($year)
	{
		$sql = "select distinct plant_name,
								plant_id,
								FORMAT(ath.date_patroli, 'MM')                as month,
								count(distinct td.admisecsgp_mstobj_objek_id) as total_temuan
				from admisecsgp_mstplant pl
						 left join admisecsgp_mstzone mz on pl.plant_id = mz.admisecsgp_mstplant_plant_id
						 left join admisecsgp_trans_headers ath on mz.zone_id = ath.admisecsgp_mstzone_zone_id
						 inner join admisecsgp_trans_details td on td.admisecsgp_trans_headers_trans_headers_id = ath.trans_header_id
				where td.status = 0
				  and DATEPART(YEAR, ath.date_patroli) = '".$year."'
				group by plant_id, plant_name, FORMAT(ath.date_patroli, 'MM')";
		return $this->db->query($sql)->result();
	}

	public function getTotalTemuanByKategoriObject()
	{
		$sql = "select top 10 *, total_temuan*100/total_objek as 'percentage'
				from (select count(distinct atd.trans_detail_id)       total_temuan,
							 (select count(distinct objek_id) total_obj
							  from admisecsgp_mstobj mobj
									   join admisecsgp_mstckp ckp on ckp.checkpoint_id = mobj.admisecsgp_mstckp_checkpoint_id
									   join admisecsgp_mstzone a on a.zone_id = ckp.admisecsgp_mstzone_zone_id
									   join admisecsgp_mstplant mp on a.admisecsgp_mstplant_plant_id = mp.plant_id
							  where mp.plant_id = m.plant_id
								and mobj.admisecsgp_mstkobj_kategori_id = kobj.kategori_id
							  group by a.admisecsgp_mstplant_plant_id) total_objek,
							 kobj.kategori_name,
							 kobj.kategori_id,
							 m.plant_name,
							 m.plant_id
					  from admisecsgp_mstkobj kobj
							   join admisecsgp_mstevent am on kobj.kategori_id = am.admisecsgp_mstkobj_kategori_id
							   join admisecsgp_trans_details atd on am.event_id = atd.admisecsgp_mstevent_event_id
							   join admisecsgp_trans_headers ath on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
							   join admisecsgp_mstzone az on ath.admisecsgp_mstzone_zone_id = az.zone_id
							   join admisecsgp_mstplant m on az.admisecsgp_mstplant_plant_id = m.plant_id
					  group by kobj.kategori_id, kobj.kategori_name, m.plant_name, m.plant_id) as ax
				order by total_temuan desc";
		return $this->db->query($sql)->result();
	}

	public function getTemuanByUser(){
		$sql = "select count(distinct atd.trans_detail_id) as total_temuan,
					   usr.npk                             as npk,
					   m.plant_name                        as plant_name,
					   m.plant_id                          as plant_id,
					   FORMAT(ath.date_patroli, 'MM')      as month
				from admisecsgp_mstusr usr
						 join admisecsgp_trans_headers ath on ath.admisecsgp_mstusr_npk = usr.npk
						 join admisecsgp_trans_details atd on ath.trans_header_id = atd.admisecsgp_trans_headers_trans_headers_id
						 join admisecsgp_mstzone az on ath.admisecsgp_mstzone_zone_id = az.zone_id
						 join admisecsgp_mstplant m on az.admisecsgp_mstplant_plant_id = m.plant_id
				where status_temuan = 0
				  and ath.status = 1
				group by usr.npk, m.plant_name, m.plant_id, FORMAT(ath.date_patroli, 'MM')
				order by m.plant_name, npk";
		return $this->db->query($sql)->result();

	}


}
