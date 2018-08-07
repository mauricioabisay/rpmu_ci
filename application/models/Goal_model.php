<?php

/**
 * 
 */
class Goal_model extends CI_Model
{
	
	public $table = 'goals';

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

	public function findByResearch($id, $achieve = -1) {
		if ( $achieve >= 0 ) {
			$this->db->where('achieve', $achieve);
		}

		$this->db->where('research_id', $id);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return array();
		}
	}

	public function findByResearchCount($id, $achieve = -1) {
		if ( $achieve >= 0 ) {
			$this->db->where('achieve', $achieve);
		}

		$this->db->where('research_id', $id);
		$query = $this->db->get($this->table);

		return $query->num_rows();
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('id' => $data['id']) );

	}

	public function delete($id) {
		$this->db->delete( $this->table, array('id' => $id) );
	}


}