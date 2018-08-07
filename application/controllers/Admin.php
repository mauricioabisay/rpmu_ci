<?php

/**
 * 
 */
class Admin extends CI_Controller
{
	
	public function index() {
		if ( $this->session->user ) {
			$this->load->model('research_model');

			switch ($this->session->user->role) {
			    case 'admin': {
			    	$this->load->model('faculty_model');

			        $researches = $this->research_model->getByStatus();
			        $researches_by_status = array();
			        foreach($researches as $r) {
			        	$researches_by_status[] = $r->counter;
			        }

			        $faculties = $this->faculty_model->get();
			        $researches_by_faculty = array();
			        $researches_by_faculty['labels'] = array();
			        $researches_by_faculty['created'] = array();
			        $researches_by_faculty['started'] = array();
			        $researches_by_faculty['completed'] = array();
			        foreach ($faculties as $f) {
			        	$researches_by_faculty['labels'][] = $f->title;
			        	$researches_by_faculty['created'][] = "".$this->research_model->getByStatusAndFacultyCount('created', $f->slug);
			        	$researches_by_faculty['started'][] = "".$this->research_model->getByStatusAndFacultyCount('started', $f->slug);
			        	$researches_by_faculty['completed'][] = "".$this->research_model->getByStatusAndFacultyCount('completed', $f->slug);
			        }
			        
			        $researches_by_status = json_encode($researches_by_status);

			        $researches_by_faculty['labels'] = json_encode($researches_by_faculty['labels']);
			        $researches_by_faculty['created'] = json_encode($researches_by_faculty['created']);
			        $researches_by_faculty['started'] = json_encode($researches_by_faculty['started']);
			        $researches_by_faculty['completed'] = json_encode($researches_by_faculty['completed']);

			        $researches = $this->research_model->getResearchersPerformanceBoolean();
			        $researchers_performance = json_encode( array( $researches['without_researches'], $researches['with_researches'] ) );

			        $this->load->view(
			        	'admin/dashboard/admin', 
			        	compact(
			        		'researches_by_status',
			        		'researches_by_faculty',
			        		'researchers_performance'
			        	)
			        );
			        break;
			    }
			    case 'director': {
			    	$researches_by_status = array();
			    	$researches_by_status[] = $this->research_model->getByStatusAndFacultyCount( 'created', $this->session->user->faculty_slug );
			    	$researches_by_status[] = $this->research_model->getByStatusAndFacultyCount( 'started', $this->session->user->faculty_slug );
			    	$researches_by_status[] = $this->research_model->getByStatusAndFacultyCount( 'completed', $this->session->user->faculty_slug );
			    	
			    	/*
			    	$this->load->model('degree_model');
			    	$degrees = $this->degree_model->findByFaculty($this->session->user->faculty_slug);
			    	$researches_by_degree = array();
			    	$researches_by_degree['labels'] = array();
			    	$researches_by_degree['created'] = array();
			    	$researches_by_degree['started'] = array();
			    	$researches_by_degree['completed'] = array();
			    	foreach ($degrees as $d) {
			    		$researches_by_degree['labels'][] = $d->title;
			    		$researches_by_degree['created'][] = "".$this->research_model->getByStatusAndDegree('created', $d->slug);
			    		$researches_by_degree['started'][] = "".$this->research_model->getByStatusAndDegree('started', $d->slug);
			    		$researches_by_degree['completed'][] = "".$this->research_model->getByStatusAndDegree('completed', $d->slug);
			    	}

			    	$researches_by_degree['labels'] = json_encode($researches_by_degree['labels']);
			    	$researches_by_degree['created'] = json_encode($researches_by_degree['created']);
			    	$researches_by_degree['started'] = json_encode($researches_by_degree'started']);
			    	$researches_by_degree'completed'] = json_encode($researches_by_degree['completed']);
			    	*/

			    	$researches_by_status = json_encode($researches_by_status);
			    	
			    	$researches = $this->research_model->getResearchersPerformanceBoolean($this->session->user->faculty_slug);
			    	$researchers_performance = json_encode( array( $researches['without_researches'], $researches['with_researches'] ) );

			    	$this->load->view(
			    		'admin/dashboard/director', 
			    		compact(
			    			'researches_by_status',
			    			'researchers_performance'
			    		)
			    	);
			    	break;
			    }
			    case 'professor': {
			    	$researches_by_status = array();
			    	$researches_by_status[] = $this->research_model->getByStatusAndParticipantCount('created', $this->session->user->participant->id);
			    	$researches_by_status[] = $this->research_model->getByStatusAndParticipantCount('started', $this->session->user->participant->id);
			    	$researches_by_status[] = $this->research_model->getByStatusAndParticipantCount('completed', $this->session->user->participant->id);

			    	$researches = $this->research_model->getByParticipant($this->session->user->participant->id);

			    	$researches_goals = array();
			    	$researches_goals['labels'] = array();
			    	$researches_goals['pending'] = array();
			    	$researches_goals['achieved'] = array();
			    	$this->load->model('goal_model');
			    	foreach ( $researches as $r ) {
			    		$researches_goals['labels'][] = $r->title;
			    		$researches_goals['pending'][] = $this->goal_model->findByResearchCount($r->id, 0);
			    		$researches_goals['achieved'][] = $this->goal_model->findByResearchCount($r->id, 1); 
			    	}


			    	$researches_by_status = json_encode($researches_by_status);

			    	$researches_goals['labels'] = json_encode($researches_goals['labels']);
			    	$researches_goals['pending'] = json_encode($researches_goals['pending']);
			    	$researches_goals['achieved'] = json_encode($researches_goals['achieved']);

			    	$this->load->view(
			    		'admin/dashboard/professor',
			    		compact(
			    			'researches_by_status',
			    			'researches_goals'
			    		)
			    	);
			    	break;

			    }
			    
			}
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
					redirect('admin');
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