<?php
require_once(APPPATH . './libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

/**
 * @property $M_restAuth
 * @property $M_restJadwal
 */
class PatroliController extends RestController
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
		$this->zero_clock = new DateTime('00:00:00', new DateTimeZone('Asia/Jakarta'));
		$this->six_clock = new DateTime('06:00:00', new DateTimeZone('Asia/Jakarta'));
		$this->accessTime = $this->dateNow;
		// uncomment to test
		// $this->accessTime = new DateTime('06:00:01', new DateTimeZone('Asia/Jakarta'));
		if ($this->accessTime > $this->zero_clock && $this->accessTime < $this->six_clock) {
			$this->dateNow = new DateTimeImmutable('- 1 day', new DateTimeZone('Asia/Jakarta'));
			$this->dateTomorrow = $this->dateNow->add(new DateInterval('P1D'));
		}

	}

	public function jadwalUser_get()
	{

		$jadwalHariIni = $this->M_restJadwal->getJadwal($this->dateNow, $this->user['id'], $this->user['admisecsgp_mstusr']);
		$jadwalSelanjutnya = $this->M_restJadwal->getJadwal($this->dateTomorrow, $this->user['id'], $this->user['admisecsgp_mstusr']);

		$response = [
			'status' => 'ok',
			'result' => [
				$jadwalHariIni,
				$jadwalSelanjutnya
			]
		];
		$this->response($response, 200);
	}

	/**
	 * Get zone, checkpoint, object by user
	 * @return void
	 *
	 */
	public function dataPatroli_get(){
		$jadwalHariIni = $this->M_restJadwal->getJadwal($this->dateNow, $this->user['id'], $this->user['admisecsgp_mstplant_id']);
		$data = $this->M_restJadwal->getDataPatroli($this->dateNow, $jadwalHariIni->shift, $this->user['admisecsgp_mstplant_id']);

		$this->response($data, 200);
	}

}
