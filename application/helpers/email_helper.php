<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('sendMail')) {

	function sendMail($to, $subject, $body)
	{
		$ci = get_instance();
		$ci->load->helper('db_settings');
		$settings = get_setting('email_config');
		$emailConfig = json_decode($settings->nilai_setting, true);
		$ci->load->library('email', $emailConfig);
		$ci->email->from($emailConfig['from'], $emailConfig['from_alias']);
		$ci->email->to($to);
		$ci->email->subject($subject);
		$ci->email->message($body);
		if (!$ci->email->send()) {
			log_message('error', $ci->email->print_debugger());
			return false;
		} else {
			log_message("info", "mail was sent successfully to ".$to." !!!");
			return true;
		}

	}

}
