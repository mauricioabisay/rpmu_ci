<?php

/**
 * 
 */
class Requirement_model extends CI_Model
{
	
	public $table = 'requirements';

	function __construct() {
		$this->load->database();
	}

	public function insert($data) {
		$this->db->insert( $this->table, $data );
		return $this->db->insert_id();
	}

	public function find($id) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function findByResearch($id) {
		$this->db->where('research_id', $id);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('id' => $data['id']) );

	}

	public function delete($id) {
		$this->db->delete( $this->table, array('id' => $id) );
	}


}