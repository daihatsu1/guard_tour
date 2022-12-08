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
		if ($this->_apiuser) {
			$this->user = $this->M_restAuth->getRows(['npk' => $this->_apiuser->user_id]);
		}
		$this->zero_clock = new DateTime('00:00:00', new DateTimeZone('Asia/Jakarta'));
		$this->six_clock = new DateTime('06:30:00', new DateTimeZone('Asia/Jakarta'));
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
		$shift = $this->M_restPatrol->getCurrentShift($this->dateNow);
		if ($shift != null) {
			$data = $this->M_restPatrol->getDataPatroli($this->dateNow, $shift->shift_id, $this->user['admisecsgp_mstplant_plant_id']);
			$this->response($data, 200);
		}
		$this->response([], 200);

	}

	public function getdataTemuan_get()
	{
		$dataTemuan = $this->M_restPatrol->getAllDataTemuan();
		$this->response($dataTemuan, 200);
	}

	public function dataTemuan_post()
	{
		$syncToken = $this->post('sync_token');
		$data = array(
			'admisecsgp_mstusr_npk' => $this->user['npk'],
			'admisecsgp_mstckp_checkpoint_id' => $this->post('admisecsgp_mstckp_checkpoint_id'),
			'admisecsgp_mstshift_shift_id' => $this->post('admisecsgp_mstshift_shift_id'),
			'admisecsgp_mstzone_zone_id' => $this->post('admisecsgp_mstzone_zone_id'),
			'date_patroli' => $this->dateNow->format('Y-m-d'),
			'checkin_checkpoint' => $this->post('checkin_checkpoint'),
			'checkout_checkpoint' => $this->post('checkout_checkpoint'),
			'type_patrol' => $this->post('type_patrol'),
			'status' => $this->post('status'),
			'sync_token' => $syncToken,
			'created_at' => $this->dateNow->format('Y-m-d H:i:s'),
			'created_by' => $this->user['npk'],
		);

		$header = $this->db->get_where('admisecsgp_trans_headers', array(
			'sync_token' => $syncToken
		), 1, 0);
		$count = $header->num_rows();

		if ($count > 0) {
			$dataHeader = $header->row();
			$id = $dataHeader->trans_header_id;
			$this->M_restPatrol->updateData('admisecsgp_trans_headers', $data, 'trans_header_id', $id);
		} else {
			$id = $this->M_restPatrol->saveData('admisecsgp_trans_headers', $data);
		}

		$details = $this->post('detail_temuan');
		if ($details) {
			foreach ($details as $k => $detail) {
				$dataDetail = array(
					//detail
					'admisecsgp_trans_headers_trans_headers_id' => $id,
					'admisecsgp_mstobj_objek_id' => $detail['admisecsgp_mstobj_objek_id'],
					'conditions' => $detail['conditions'],
					'description' => $detail['description'],

					'is_laporan_kejadian' => $detail['is_laporan_kejadian'],
					'laporkan_pic' => $detail['laporkan_pic'],
					'is_tindakan_cepat' => $detail['is_tindakan_cepat'],
					'status_temuan' => $detail['status_temuan'],
					'deskripsi_tindakan' => $detail['deskripsi_tindakan'],
					'note_tindakan_cepat' => $detail['note_tindakan_cepat'],
					'status' => $detail['status'],
					'created_at' => $this->dateNow->format('Y-m-d H:i:s'),
					'sync_token' => $detail['sync_token'],
					'created_by' => $this->user['npk'],
				);
				if (array_key_exists('admisecsgp_mstevent_event_id', $detail)) {
					$dataDetail['admisecsgp_mstevent_event_id'] = $detail['admisecsgp_mstevent_event_id'];
				}
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
										error_log($this->upload->display_errors());
									} else {
										$data = $this->upload->data();
										$upload_result[$field] = 'assets/temuan/' . $data['file_name'];
									}
								} else {
									$upload_result[$field] = null;
								}
							} else {
								$upload_result[$field] = null;
							}
						}
					}
					$dataDetail['image_1'] = $upload_result['image_1'];
					$dataDetail['image_2'] = $upload_result['image_2'];
					$dataDetail['image_3'] = $upload_result['image_3'];
				} else {
					if (array_key_exists('image_1', $detail)) {
						$dataDetail['image_1'] = str_replace(base_url(),"", $detail['image_1']);
					}
					if (array_key_exists('image_2', $detail)) {
						$dataDetail['image_2'] = str_replace(base_url(),"", $detail['image_2']);
					}
					if (array_key_exists('image_3', $detail)) {
						$dataDetail['image_3'] = str_replace(base_url(),"", $detail['image_3']);
					}
				}

				$headerDetail = $this->db->get_where('admisecsgp_trans_details', array(
					'sync_token' => $detail['sync_token']
				), 1, 0);
				$countDetail = $headerDetail->num_rows();
				if ($countDetail > 0) {
					$existingDataDetail = $headerDetail->row();
					$idDetail = $existingDataDetail->trans_detail_id;
					$this->M_restPatrol->updateData('admisecsgp_trans_details', $dataDetail, 'trans_detail_id', $idDetail);
				} else {
					$this->M_restPatrol->saveData('admisecsgp_trans_details', $dataDetail);

				}

			}
		}

		$result = $this->M_restPatrol->getDataTemuan($id);
		$this->response($result, 200);
	}

	public function setPatrolActivity_post()
	{
		$idJadwalPatroli = $this->post('id_jadwal_patroli');
		$data = array(
			'admisecsgp_trans_jadwal_patroli_id_jadwal_patroli' => $this->post('id_jadwal_patroli'),
			'status' => $this->post('status'),
			'start_at' => $this->post('start_at'),
		);

		if ($this->input->post('end_at')) {
			$data['end_at'] = $this->post('end_at');
			$this->M_restPatrol->sendEmailPIC($idJadwalPatroli);
		}

		$activity = $this->db->get_where('admisecsgp_patrol_activity', array(
			'admisecsgp_trans_jadwal_patroli_id_jadwal_patroli' => $this->post('id_jadwal_patroli')
		), 1, 0);
		$count = $activity->num_rows();

		if ($count > 0) {
			$existingData = $activity->row();
			$id = $existingData->activity_id;
			$this->M_restPatrol->updateData('admisecsgp_patrol_activity', $data, 'activity_id', $id);
		} else {
			$id = $this->M_restPatrol->saveData('admisecsgp_patrol_activity', $data);
		}

		$activity = $this->db->get_where('admisecsgp_patrol_activity', array(
			'activity_id' => $id
		), 1, 0);
		$existingData = $activity->row();
		$this->response($existingData, 200);

	}



	public function getPatrolActivity_get()
	{
		$activity = $this->db->order_by("activity_id", "desc")->get_where('admisecsgp_patrol_activity', array(
			'admisecsgp_trans_jadwal_patroli_id_jadwal_patroli' => $this->get('id_jadwal_patroli')
		), 1, 0);
		$count = $activity->num_rows();
		if ($count > 0) {
			$data = $activity->row();
		} else {
			$data = new stdClass();

		}
		$this->response($data, 200);

	}
}
