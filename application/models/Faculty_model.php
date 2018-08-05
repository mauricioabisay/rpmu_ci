<?php

/**
 * 
 */
class Faculty_model extends CI_Model
{
	
	public $table = 'faculties';

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
		$this->db->where('slug', $id);
		$query = $this->db->get($this->table);
		if ( $query->num_rows() >0 ) {
			return $query->row();
		} else {
			return array();
		}
	}

	public function findByDegree($degree_slug) {
		$sql = 'SELECT faculties.slug as slug, faculties.title as title ';
		$sql.= 'FROM faculties, degrees ';
		$sql.= 'WHERE faculties.slug=degrees.faculty_slug ';
		$sql.= 'AND degrees.slug="'.$degree_slug.'" ';

		$query = $this->db->query($sql);
		if($query->num_rows()>0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('slug' => $data['slug']) );

	}

	public function delete($id) {
		$this->db->delete( $this->table, array('slug' => $id) );
	}


}