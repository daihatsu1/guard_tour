<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_bulan')) {

	function get_bulan($bulan)
	{
		switch ($bulan) {
			case '01':
				return 'JANUARI';
			case '02':
				return 'FEBRUARI';
			case '03':
				return 'MARET';
			case '04':
				return 'APRIL';
			case '05':
				return 'MEI';
			case '06':
				return 'JUNI';
			case '07':
				return 'JULI';
			case '08':
				return 'AGUSTUS';
			case '09':
				return 'SEPTEMBER';
			case '10':
				return 'OKTOBER';
			case '11':
				return 'NOVEMBER';
			case '12':
				return 'DESEMBER';
			default:;
				break;
		}

		return '';
	}


}

