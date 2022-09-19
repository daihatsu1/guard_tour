<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require_once(APPPATH . './libraries/RestController.php');

use chriskacerguis\RestServer\RestController;

class AuthController extends RestController
{

	public function __construct()
	{
		parent::__construct();

		// Load the user model
		$this->load->model('M_restAuth');
	}

	public function login_post()
	{
		// Get the post data
		$npk = $this->post('npk');
		$password = $this->post('password');
		// Validate the post data
		if (!empty($npk) && !empty($password)) {

			// Check if any user exists with the given credentials
			$con['npk'] =  $npk;
			$con['returnType'] = 'single';
			$con['conditions'] = array(
				'npk' => $npk,
				'password' => md5($password),
				'status' => 1
			);
			$user = $this->M_restAuth->getRows($con);
			if ($user) {
				// Set the response and exit
				//				var_dump($user['npk']);
				$key = $this->_regenerate_key($user['npk']);
				if ($key) {
					$this->response([
						'status'  => TRUE,
						'message' => 'User login successful.',
						'data' 	  => $user,
						'key'	  => $key
					], RestController::HTTP_OK);
				}
				$this->response("Failed Generate API KEY.", RestController::HTTP_BAD_REQUEST);
			} else {
				// Set the response and exit
				//BAD_REQUEST (400) being the HTTP response code
				$this->response("Wrong npk or password.", RestController::HTTP_BAD_REQUEST);
			}
		} else {
			// Set the response and exit
			$this->response("Provide npk and password.", RestController::HTTP_BAD_REQUEST);
		}
	}

	public function registration_post()
	{
		// Get the post data
		$first_name = strip_tags($this->post('first_name'));
		$last_name = strip_tags($this->post('last_name'));
		$npk = strip_tags($this->post('email'));
		$password = $this->post('password');
		$phone = strip_tags($this->post('phone'));

		// Validate the post data
		if (!empty($first_name) && !empty($last_name) && !empty($npk) && !empty($password)) {

			// Check if the given email already exists
			$con['returnType'] = 'count';
			$con['conditions'] = array(
				'email' => $npk,
			);
			$userCount = $this->M_restAuth->getRows($con);

			if ($userCount > 0) {
				// Set the response and exit
				$this->response("The given email already exists.", RestController::HTTP_BAD_REQUEST);
			} else {
				// Insert user data
				$userData = array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $npk,
					'password' => md5($password),
					'phone' => $phone
				);
				$insert = $this->M_restAuth->insert($userData);

				// Check if the user data is inserted
				if ($insert) {
					// Set the response and exit
					$this->response([
						'status' => TRUE,
						'message' => 'The user has been added successfully.',
						'data' => $insert
					], RestController::HTTP_OK);
				} else {
					// Set the response and exit
					$this->response("Some problems occurred, please try again.", RestController::HTTP_BAD_REQUEST);
				}
			}
		} else {
			// Set the response and exit
			$this->response("Provide complete user info to add.", RestController::HTTP_BAD_REQUEST);
		}
	}

	public function user_get($id = 0)
	{
		// Returns all the users data if the id not specified,
		// Otherwise, a single user will be returned.
		$con = $id ? array('npk' => $id) : '';
		$users = $this->M_restAuth->getRows($con);

		// Check if the user data exists
		if (!empty($users)) {
			// Set the response and exit
			//OK (200) being the HTTP response code
			$this->response($users, RestController::HTTP_OK);
		} else {
			// Set the response and exit
			//NOT_FOUND (404) being the HTTP response code
			$this->response([
				'status' => FALSE,
				'message' => 'No user was found.'
			], RestController::HTTP_NOT_FOUND);
		}
	}

	public function user_put()
	{
		$id = $this->put('npk');

		// Get the post data
		$first_name = strip_tags($this->put('first_name'));
		$last_name = strip_tags($this->put('last_name'));
		$npk = strip_tags($this->put('email'));
		$password = $this->put('password');
		$phone = strip_tags($this->put('phone'));

		// Validate the post data
		if (!empty($id) && (!empty($first_name) || !empty($last_name) || !empty($npk) || !empty($password) || !empty($phone))) {
			// Update user's account data
			$userData = array();
			if (!empty($first_name)) {
				$userData['first_name'] = $first_name;
			}
			if (!empty($last_name)) {
				$userData['last_name'] = $last_name;
			}
			if (!empty($npk)) {
				$userData['email'] = $npk;
			}
			if (!empty($password)) {
				$userData['password'] = md5($password);
			}
			if (!empty($phone)) {
				$userData['phone'] = $phone;
			}
			$update = $this->M_restAuth->update($userData, $id);

			// Check if the user data is updated
			if ($update) {
				// Set the response and exit
				$this->response([
					'status' => TRUE,
					'message' => 'The user info has been updated successfully.'
				], RestController::HTTP_OK);
			} else {
				// Set the response and exit
				$this->response("Some problems occurred, please try again.", RestController::HTTP_BAD_REQUEST);
			}
		} else {
			// Set the response and exit
			$this->response("Provide at least one user info to update.", RestController::HTTP_BAD_REQUEST);
		}
	}

	/* Helper Methods */

	private function _generate_key()
	{
		do {
			// Generate a random salt
			$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
			// If an error occurred, then fall back to the previous method
			if ($salt === false) {
				$salt = hash('sha256', time() . mt_rand());
			}

			$new_key = substr($salt, 0, config_item('rest_key_length'));
		} while ($this->_key_exists($new_key));

		return $new_key;
	}

	/* Private Data Methods */

	private function _regenerate_key($user_id)
	{
		$this->_delete_key_user($user_id);

		$key =  $this->_generate_key();
		$this->_insert_key($key, ['level' => 1, 'user_id' => $user_id]);
		return $key;
	}

	private function _delete_key_user($user_id)
	{
		$this->rest->db
			->where('user_id', $user_id)
			->delete(config_item('rest_keys_table'));
	}

	private function _get_key($key)
	{
		return $this->rest->db
			->where(config_item('rest_key_column'), $key)
			->get(config_item('rest_keys_table'))
			->row();
	}

	private function _key_exists($key)
	{
		return $this->rest->db
			->where(config_item('rest_key_column'), $key)
			->count_all_results(config_item('rest_keys_table')) > 0;
	}

	private function _insert_key($key, $data)
	{
		$data[config_item('rest_key_column')] = $key;
		$data['date_created'] = date("Y-m-d H:i:s");

		return $this->rest->db
			->set($data)
			->insert(config_item('rest_keys_table'));
	}

	private function _update_key($key, $data)
	{
		return $this->rest->db
			->where(config_item('rest_key_column'), $key)
			->update(config_item('rest_keys_table'), $data);
	}

	private function _delete_key($key)
	{
		return $this->rest->db
			->where(config_item('rest_key_column'), $key)
			->delete(config_item('rest_keys_table'));
	}
}
