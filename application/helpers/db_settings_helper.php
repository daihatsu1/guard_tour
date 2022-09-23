<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_setting')) {

	function get_setting($nama_setting)
	{
		$ci = get_instance();
		$ci->load->database();
		$ci->db->from('admisecsgp_setting');
		$ci->db->where("nama_setting", $nama_setting);

		return $ci->db->get()->row();

	}


}

