<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function subjects() {
		
		$this->load->database();
		
		$current = '';
		foreach (explode(',', $this->input->get('current')) as $slug) {
			$current.= 'AND slug != "'.$slug.'" ';
		}

		$this->db->where("title LIKE '%".$this->input->get('string')."%' ".$current);
		$query = $this->db->get('subjects');
		print_r(json_encode($query->result()));
		exit();
	}

	public function participants() {
		
		$this->load->database();

		$current = '';
		foreach (explode(',', $this->input->get('current')) as $id) {
			$current.= 'AND id != '.$id.' ';
		}
		
		$this->db->where("(name LIKE '%".$this->input->get('string')."%' OR id LIKE '".$this->input->get('string')."%') ".$current);
		$query = $this->db->get('participants');
		
		if ( $query->num_rows() > 0 ) {
			print_r(json_encode($query->result()));
		} else {
			$this->db->where("id = ".$this->input->get('string').' '.$current);
			$this->db->where_not_in('id', explode(',', $this->input->get('current')));
			$query = $this->db->get('participants');
			print_r(json_encode($query->result()));
		}
		exit();
	}
}
