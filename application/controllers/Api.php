<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function subjects() {
		$this->load->database();
		$this->db->where("title LIKE '%".$this->input->get('string')."%' ");
		$query = $this->db->get('subjects');
		print_r(json_encode($query->result()));
		exit();
	}

	public function participants() {
		$this->load->database();
		$this->db->where("name LIKE '%".$this->input->get('string')."%' OR id LIKE '".$this->input->get('string')."%'");
		$query = $this->db->get('participants');
		print_r(json_encode($query->result()));
		exit();
	}
}
