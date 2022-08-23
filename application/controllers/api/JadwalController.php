<?php
require_once(APPPATH . './libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

/**
 * @property $M_restAuth
 * @property $M_restJadwal
 */
class JadwalController extends RestController
{

	/**
	 * @var false|string
	 */
	private $dateNow;

	/**
	 * @var DateTime
	 */
	private $dateTomorrow;

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['M_restJadwal', 'M_restAuth']);
		$this->dateNow = new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta'));
		$this->dateTomorrow = $this->dateNow->add(new DateInterval('P1D'));
		$this->user = $this->M_restAuth->getRows(['id' => $this->_apiuser->user_id]);
	}

	public function jadwalUser_get()
	{
		$zero_clock = new DateTime('00:00:00', new DateTimeZone('Asia/Jakarta'));
		$six_clock = new DateTime('06:00:00', new DateTimeZone('Asia/Jakarta'));

		$accessTime = $this->dateNow;
		// uncomment to test
		// $accessTime = new DateTime('06:00:01', new DateTimeZone('Asia/Jakarta'));

		if ($accessTime > $zero_clock && $accessTime < $six_clock) {
			$this->dateNow = new DateTimeImmutable('- 1 day', new DateTimeZone('Asia/Jakarta'));
			$this->dateTomorrow = $this->dateNow->add(new DateInterval('P1D'));
		}
		$jadwalHariIni = $this->M_restJadwal->getJadwal($this->dateNow, $this->user['id'], $this->user['admisecsgp_mstplant_id']);
		$jadwalSelanjutnya = $this->M_restJadwal->getJadwal($this->dateTomorrow, $this->user['id'], $this->user['admisecsgp_mstplant_id']);

		$response = [
			$jadwalHariIni,
			$jadwalSelanjutnya
		];
		$this->response($response, 200);
	}
}
