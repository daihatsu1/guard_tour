<?php
require_once(APPPATH . './libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

/**
 * @property $M_restAuth
 * @property $M_restPatrol
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
		$this->load->model(['M_restPatrol', 'M_restAuth', 'M_api']);
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

		$jadwalHariIni = $this->M_restPatrol->getJadwal($this->dateNow, $this->user['id'], $this->user['admisecsgp_mstusr']);
		$jadwalSelanjutnya = $this->M_restPatrol->getJadwal($this->dateTomorrow, $this->user['id'], $this->user['admisecsgp_mstusr']);

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
	public function dataPatroli_get()
	{
		$jadwalHariIni = $this->M_restPatrol->getJadwal($this->dateNow, $this->user['id'], $this->user['admisecsgp_mstplant_id']);
		$data = $this->M_restPatrol->getDataPatroli($this->dateNow, $jadwalHariIni->shift, $this->user['admisecsgp_mstplant_id']);

		$this->response($data, 200);
	}

	public function dataTemuan_post()
	{

		$data = array(
			'date' => $this->post('date'),
			'ms_user_id' => $this->user['id'],
			'ms_shift_id' => $this->post('ms_shift_id'),
			'is_matched_jpat' => $this->post('is_matched_jpat'),
			'is_matched_jpr' => $this->post('is_matched_jpr'),
			'is_diluar_jadwal' => $this->post('is_diluar_jadwal'),
			'status' => $this->post('status'),
			'uploaded_at' => $this->dateNow->format('Y-m-d H:i:s'),

//			'created_at' => $this->post('created_at'),
//			'created_by' => $this->post('created_by'),
//			'updated_at' => $this->post('updated_at'),
//			'updated_by' => $this->post('updated_by'),
		);

		$id = $this->M_restPatrol->saveData('admisecsgp_tr_headers', $data);

		$details = $this->post('detail_temuan');
		foreach ($details as $k => $detail) {
			$files = $_FILES['detail_temuan'];
			$image_field = array('image_1', 'image_2', 'image_3');
			$upload_result = array();
			foreach ($image_field as $key => $field) {
				if (array_key_exists($field, $files['name'][$k])) {
					$date = new DateTimeImmutable();
					$filename = $date->getTimestamp() . '_' . $files['name'][$k][$field];

					$_FILES[$field]['name'] = $files['name'][$k][$field];
					$_FILES[$field]['type'] = $files['type'][$k][$field];
					$_FILES[$field]['tmp_name'] = $files['tmp_name'][$k][$field];
					$_FILES[$field]['error'] = $files['error'][$k][$field];
					$_FILES[$field]['size'] = $files['size'][$k][$field];

					$config['upload_path'] = realpath(APPPATH . '../assets/temuan');
//					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					$config['file_name'] = $filename;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$this->upload->set_allowed_types('*');

					if (!$this->upload->do_upload($field)) {
						$upload_result[$field] = '';
					} else {
						$data = $this->upload->data();
						$upload_result[$field] = $data['file_name'];
					}
				} else {
					$upload_result[$field] = '';
				}
			}

			$dataDetail = array(
				//detail
				'tr_dpg_headers_id' => $id,
				'ms_ckp_id' => $detail['ms_ckp_id'],
				'rfid_is_matched' => $detail['rfid_is_matched'],
				'ms_objects_id' => $detail['ms_objects_id'],
				'conditions' => $detail['conditions'],
				'event' => $detail['event'],
				'description' => $detail['description'],
				'image_1' => $upload_result['image_1'],
				'image_2' => $upload_result['image_2'],
				'image_3' => $upload_result['image_3'],
				'is_laporan_kejadian' => $detail['is_laporan_kejadian'],
				'laporkan_pic' => $detail['laporkan_pic'],
				'is_tindakan_cepat' => $detail['is_tindakan_cepat'],
				'status' => $detail['status'],
				'uploaded_at' => $this->dateNow->format('Y-m-d H:i:s'),

//				'created_at' => $detail['created_at'],
//				'created_by' => $detail['created_by'],
//				'updated_at' => $detail['updated_at'],
//				'updated_by' => $detail['updated_by'],
			);
			$this->M_restPatrol->saveData('admisecsg_tr_details', $dataDetail);

		}
		$result = $this->M_restPatrol->getDataTemuan($id);
		$this->response($result, 200);
	}

}
