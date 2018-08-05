<?php

/**
 * 
 */
class Participant_model extends CI_Model
{
	
	public $table = 'participants';

	function __construct() {
		$this->load->database();
	}

	public function get( $start = false, $end  = false ) {
		if ( $start && $end ) {
			$query = $this->db->get( $this->table, $start, $end );
		} else {
			$query = $this->db->get( $this->table );	
		}
		return $query->result();
	}

	public function insert($data) {
		$this->db->insert( $this->table, $data );
	}

	public function find($id) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->table);
		if ( $query->num_rows() > 0 ) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function findBySlug($slug) {
		$this->db->where('slug', $slug);
		$query = $this->db->get($this->table);
		if ( $query->num_rows() > 0 ) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update($data, $id = false) {
		if ( $id ) {
			$this->db->update( $this->table, $data, array('id' => $id) );
		} else {
			$this->db->update( $this->table, $data, array('id' => $data['id']) );
		}
	}

	public function delete($id) {
		$this->db->delete( $this->table, array('id' => $id) );
	}


}