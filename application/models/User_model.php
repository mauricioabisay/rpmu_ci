<?php

/**
 * 
 */
class User_model extends CI_Model
{
	
	public $table = 'users';

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

	public function findParticipant($user_id) {
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('participants');

		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function findByEmail($email) {
		$this->db->where('email', $email);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('id' => $data['id']) );

	}

	public function delete($id) {
		$this->db->delete('participants', array('user_id' => $id));
		$this->db->delete( $this->table, array('id' => $id) );
	}


}