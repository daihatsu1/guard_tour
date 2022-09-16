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

		$this->user = $this->M_restAuth->getRows(['npk' => $this->_apiuser->user_id]);
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

		$jadwalHariIni = $this->M_restPatrol->getJadwal($this->dateNow, $this->user['npk'], $this->user['admisecsgp_mstusr']);
		$jadwalSelanjutnya = $this->M_restPatrol->getJadwal($this->dateTomorrow, $this->user['npk'], $this->user['admisecsgp_mstusr']);

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
		$jadwalHariIni = $this->M_restPatrol->getJadwal($this->dateNow, $this->user['npk'], $this->user['admisecsgp_mstplant_plant_id']);
		$data = $this->M_restPatrol->getDataPatroli($this->dateNow, $jadwalHariIni->shift, $this->user['admisecsgp_mstplant_plant_id']);

		$this->response($data, 200);
	}

	public function dataTemuan_post()
	{
		$syncToken = $this->post('sync_token');
		$data = array(
			'admisecsgp_mstusr_npk' => $this->user['npk'],
			'admisecsgp_mstckp_checkpoint_id' => $this->post('admisecsgp_mstckp_checkpoint_id'),
			'admisecsgp_mstshift_shift_id' => $this->post('admisecsgp_mstshift_shift_id'),
			'admisecsgp_mstzone_zone_id' => $this->post('admisecsgp_mstzone_zone_id'),
			'date_patroli' => $this->post('date_patroli'),
			'checkin_checkpoint' => $this->post('checkin_checkpoint'),
			'checkout_checkpoint' => $this->post('checkout_checkpoint'),
			'status' => $this->post('status'),
			'sync_token' => $syncToken,
			'created_at' => $this->dateNow->format('Y-m-d H:i:s'),
			'created_by' => $this->user['npk'],
		);

		if ($this->input->post('trans_header_id')) {
			$data['trans_header_id'] = $this->input->post('trans_header_id');
		}

		$id = $this->M_restPatrol->upsertHeader('admisecsgp_trans_headers', $data);

		$details = $this->post('detail_temuan');
		if ($details) {
			foreach ($details as $k => $detail) {
				if ($_FILES != null) {
					$files = array_key_exists('detail_temuan', $_FILES) ? $_FILES['detail_temuan'] : null;
					$upload_result = array('image_1' => null, 'image_2' => null, 'image_3' => null,);
					if ($files != null) {
						$image_field = array('image_1', 'image_2', 'image_3');
						foreach ($image_field as $key => $field) {
							if (array_key_exists($k, $files['name'])) {
								if (array_key_exists($field, $files['name'][$k])) {
									$date = new DateTimeImmutable();
									$filename = $date->getTimestamp() . '_' . $files['name'][$k][$field];
									$_FILES[$field]['name'] = $files['name'][$k][$field];
									$_FILES[$field]['type'] = $files['type'][$k][$field];
									$_FILES[$field]['tmp_name'] = $files['tmp_name'][$k][$field];
									$_FILES[$field]['error'] = $files['error'][$k][$field];
									$_FILES[$field]['size'] = $files['size'][$k][$field];

									$config['upload_path'] = realpath(APPPATH . '../assets/temuan');
									$config['file_name'] = $filename;

									$this->load->library('upload', $config);
									$this->upload->initialize($config);
									$this->upload->set_allowed_types('*');

									if (!$this->upload->do_upload($field)) {
										$upload_result[$field] = null;
									} else {
										$data = $this->upload->data();
										$upload_result[$field] = base_url() . 'assets/temuan/' . $data['file_name'];
									}
								} else {
									$upload_result[$field] = null;
								}
							} else {
								$upload_result[$field] = null;
							}

						}
					}
				}

				$dataDetail = array(
					//detail
					'admisecsgp_trans_headers_trans_headers_id' => $id,
					'admisecsgp_mstobj_objek_id' => $detail['admisecsgp_mstobj_objek_id'],
					'conditions' => $detail['conditions'],
					'admisecsgp_mstevent_event_id' => $detail['admisecsgp_mstevent_event_id'],
					'description' => $detail['description'],
					'image_1' => $upload_result['image_1'],
					'image_2' => $upload_result['image_2'],
					'image_3' => $upload_result['image_3'],
					'is_laporan_kejadian' => $detail['is_laporan_kejadian'],
					'laporkan_pic' => $detail['laporkan_pic'],
					'is_tindakan_cepat' => $detail['is_tindakan_cepat'],
					'status_temuan' => $detail['status'],
					'deskripsi_tindakan' => $detail['deskripsi_tindakan'],
					'note_tindakan_cepat' => $detail['note_tindakan_cepat'],
					'status' => $detail['status'],
					'created_at' => $this->dateNow->format('Y-m-d H:i:s'),
					'sync_token' => $detail['sync_token'],
					'created_by' => $this->user['npk'],


				);
				$this->M_restPatrol->saveData('admisecsgp_trans_details', $dataDetail);

			}
		}

		$result = $this->M_restPatrol->getDataTemuan($id);
		$this->response($result, 200);
	}

}
