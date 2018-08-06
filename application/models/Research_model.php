<?php

/**
 * 
 */
class Research_model extends CI_Model
{
	
	public $table = 'researches';

	function __construct() {
		$this->load->database();
	}

	public function get( $start = -1, $items_per_page = false ) {
		if ( $start >= 0 ) {
			if ( $items_per_page ) {
				$this->db->limit( $items_per_page, $start );
			} else {
				$this->db->limit( $this->config->item('public_items_per_page'), $start );
			}
			
			$query = $this->db->get( $this->table );
		} else {
			$query = $this->db->get( $this->table );
		}
		return $query->result();
	}

	public function getCount() {
		$query = $this->db->get( $this->table );
		return $query->num_rows();
	}

	public function getByParticipant($participant_id) {
		$researches = array();
		$sql = 'SELECT research_id FROM research_participant ';
		$sql.= 'WHERE participant_id='.$participant_id.' ';

		$query = $this->db->query($sql);
		if ( $query->num_rows() > 0 ) {
			foreach ($query->result() as $r) {
				$researches[] = $this->db->get_where('researches', array('id' => $r->research_id))->row();
			}
		}
		return $researches;
	}

	public function getByFaculty($slug, $start = -1) {
		$researches = array();
		$sql = 'SELECT research_id FROM research_participant, ';
		$sql.= '( (SELECT participants.id as id ';
		$sql.= 'FROM participants, users ';
		$sql.= 'WHERE users.id=participants.user_id ';
		$sql.= 'AND participants.user_id is not null ';
		$sql.= 'AND faculty_slug="'.$slug.'") ';
		$sql.= 'UNION ';
		$sql.= '(SELECT participants.id as id ';
		$sql.= 'FROM participants, degrees ';
		$sql.= 'WHERE degree_slug=degrees.slug ';
		$sql.= 'AND faculty_slug="'.$slug.'") ) as c ';
		$sql.= 'WHERE participant_id=id ';
		$sql.= 'GROUP BY research_id ';

		if ( $start >= 0 ) {
			$sql.= 'LIMIT '.$start.','.$this->config->item('public_items_per_page');
		}

		$query = $this->db->query($sql);
		if ( $query->num_rows() > 0 ) {
			foreach ($query->result() as $r) {
				$researches[] = $this->db->get_where('researches', array('id' => $r->research_id))->row();
			}
		}
		return $researches;		
	}

	public function getByFacultyCount($slug) {
		$researches = array();
		$sql = 'SELECT research_id FROM research_participant, ';
		$sql.= '( (SELECT participants.id as id ';
		$sql.= 'FROM participants, users ';
		$sql.= 'WHERE users.id=participants.user_id ';
		$sql.= 'AND participants.user_id is not null ';
		$sql.= 'AND faculty_slug="'.$slug.'") ';
		$sql.= 'UNION ';
		$sql.= '(SELECT participants.id as id ';
		$sql.= 'FROM participants, degrees ';
		$sql.= 'WHERE degree_slug=degrees.slug ';
		$sql.= 'AND faculty_slug="'.$slug.'") ) as c ';
		$sql.= 'WHERE participant_id=id ';
		$sql.= 'GROUP BY research_id ';

		$query = $this->db->query($sql);
		
		return $query->num_rows();		
	}

	public function getByDegree($slug, $start = -1) {
		$researches = array();
		$sql = 'SELECT research_id as id FROM research_participant, participants ';
		$sql.= 'WHERE participant_id = participants.id ';
		$sql.= 'AND degree_slug = "'.$slug.'" ';

		if ( $start >= 0 ) {
			$sql.= 'LIMIT '.$start.','.$this->config->item('public_items_per_page');
		}

		$query = $this->db->query($sql);
		if ( $query->num_rows() > 0 ) {
			foreach ($query->result() as $r) {
				$researches[] = $this->db->get_where('researches', array('id' => $r->id))->row();
			}
		}
		return $researches;
	}

	public function getByDegreeCount($slug) {
		$researches = array();
		$sql = 'SELECT research_id as id FROM research_participant, participants ';
		$sql.= 'WHERE participant_id = participants.id ';
		$sql.= 'AND degree_slug = "'.$slug.'" ';

		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function countByDegree($slug) {
		$sql = 'SELECT research_id as id FROM research_participant, participants ';
		$sql.= 'WHERE participant_id = participants.id ';
		$sql.= 'AND degree_slug = "'.$slug.'" ';

		$query = $this->db->query($sql);
		return $query->num_rows();	
	}

	public function findSubjects($subjects_string) {
		$subjects = array();
		$subjects_array = explode(',', $subjects_string);
		foreach ($subjects_array as $s) {
			$query = $this->db->get_where('subjects', array('slug' => $s));
			$subjects[] = $query->row();
		}
		return $subjects;
	}

	public function insert($data) {
		$this->db->insert( $this->table, $data );
		return $this->db->insert_id();
	}

	public function findDegrees($research_id) {
		$degrees = array();
		$sql = 'SELECT degree_slug FROM research_participant, participants ';
		$sql.= 'WHERE participants.id = research_participant.participant_id ';
		$sql.= 'AND research_id ='.$research_id.' ';
		$sql.= 'AND degree_slug is not null';

		$query = $this->db->query($sql);

		foreach ($query->result() as $d) {
			$aux = $this->db->get_where('degrees', array('slug' => $d->degree_slug));
			$degrees[] = $aux->row();
		}
		return $degrees;
	}

	public function insertParticipant($research_id, $participant_id, $role = false, $assigment = '') {
		if ( $role ) {
			$this->db->insert('research_participant', array(
				'research_id' => $research_id,
				'participant_id' => $participant_id,
				'role' => $role,
				'assigment' => $assigment
			));
		} else {
			$this->db->insert('research_participant', array(
				'research_id' => $research_id,
				'participant_id' => $participant_id,
				'assigment' => $assigment
			));
		}
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

	public function findBySlug($slug) {
		$this->db->where('slug', $slug);
		$query = $this->db->get($this->table);

		if($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	public function findParticipants($research_id, $role = false) {
		$participants = array();
		if ( $role ) {
			$query = $this->db->get_where(
				'research_participant', 
				array(
					'research_id' => $research_id,
					'role' => $role
				)
			);
			if ( $query->num_rows() > 0 ) {
				$result = $query->result();
				foreach ($result as $p) {
					$query = $this->db->get_where('participants', array('id' => $p->participant_id));
					$participants[] = $query->row();
				}
			}
		} else {
			$query = $this->db->get_where(
				'research_participant', 
				array(
					'research_id' => $research_id
				)
			);
			if ( $query->num_rows() > 0 ) {
				$result = $query->result();
				foreach ($result as $p) {
					$query = $this->db->get_where('participants', array('id' => $p->participant_id));
					$participants[] = $query->row();
				}
			}
		}
		return $participants;
	}

	public function leader($research_id) {
		$query = $this->db->get_where(
			'research_participant', 
			array(
				'research_id' => $research_id,
				'role' => 'leader'
			)
		);

		if($query->num_rows() > 0) {
			$leader_id = $query->row()->participant_id;
			$this->db->reset_query();
			$query = $this->db->get_where(
				'participants',
				array(
					'id' => $leader_id
				)
			);
			if($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function update($data) {
		$this->db->update( $this->table, $data, array('id' => $data['id']) );

	}

	public function delete($id) {
		$this->db->delete( $this->table, array('id' => $id) );
	}

	public function clearParticipants($research_id) {
		$this->db->where('role != "leader"');
		$this->db->where('research_id', $research_id);
		$this->db->delete('research_participant');
	}


}