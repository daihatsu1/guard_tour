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

	function getJadwal($dateTime, $user, $plant_id)
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
  					AND admisecsgp_mstusr_id = '" . $user . "'";
		$result = $this->db->query($sql)->row();
		$result->date = $dateTime->format('d-m-Y');
		return $result;

	}


}
