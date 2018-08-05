<?php

/**
 * 
 */
class Admin extends CI_Controller
{
	
	public function index() {
		if ( $this->session->user ) {
			$this->load->view('admin/dashboard');
		} else {
			$this->load->view('admin/login');
		}
	}

	public function login() {
		if ($this->input->post()) {
			date_default_timezone_set('America/Mexico_City');
			require_once 'vendor/autoload.php';

			$client = new Google_Client(['client_id' => $this->config->item('google_oauth')]);
			$payload = $client->verifyIdToken($this->input->post('token'));

			if ( $payload ) {
				$this->load->model('user_model');
				$user = $this->user_model->findByEmail($payload['email']);
				if ( $user ) {
					$this->session->user = $user;
					$this->session->user->participant = $this->user_model->findParticipant($user->id);
					$this->load->view('admin/dashboard');
				} else {
					//User not found
					$this->load->view('admin/login');
				}
			} else {
				//Error connecting with Google API
				$this->load->view('admin/login');
			}
		} else {
			$this->load->view('admin/login');
		}
	}

	public function logout() {
		$this->session->unset_userdata('user');
		$this->session->sess_destroy();
		redirect('admin');
	}
}