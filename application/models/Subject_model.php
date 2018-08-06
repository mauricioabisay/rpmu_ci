<?php

/**
 * 
 */
class Subject_model extends CI_Model
{
	
	public $table = 'subjects';

	function __construct() {
		$this->load->database();
	}

	public function get( $start = -1, $items_per_page  = false ) {
		if ( $start >= 0 && $items_per_page ) {
			$this->db->limit( $items_per_page, $start );
		}
		
		$query = $this->db->get( $this->table );	

		return $query->result();
	}

	public function getCount() {
		$query = $this->db->get( $this->table );
		return $query->num_rows();
	}

	public function insert($data) {
		$this->db->insert( $this->table, $data );
	}

	public function find($id) {
		$this->db->where('slug', $id);
		$query = $this->db->get($this->table);
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('slug' => $data['slug']) );

	}

	public function delete($id) {
		$this->db->delete( $this->table, array('slug' => $id) );
	}


}