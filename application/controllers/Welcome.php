<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public $pag_config;

	public function __construct() {
		parent::__construct();

		$this->load->helper('directory');

		$this->load->model('research_model');
		$this->load->model('requirement_model');
		$this->load->model('goal_model');
		$this->load->model('participant_model');
		$this->load->model('citation_model');

		$this->load->model('user_model');
		$this->load->model('faculty_model');
		$this->load->model('degree_model');

		$this->pag_config = array(
			'per_page' => $this->config->item('public_items_per_page'),
			'full_tag_open' => '<ul class="pagination">',
			'full_tag_close' => '</ul>',
			'num_tag_open' => '<li class="page-item"><span class="page-link">',
			'num_tag_close' => '</span></li>',
			'prev_tag_open' => '<li class="page-item"><span class="page-link">',
			'prev_tag_close' => '</span></li>',
			'next_tag_open' => '<li class="page-item"><span class="page-link">',
			'next_tag_close' => '</span></li>',
			'cur_tag_open' => '<li class="page-item active"><span class="page-link">',
			'cur_tag_close' => '</span></li>',
			'first_link' => 'Inicio',
			'first_tag_open' => '<li class="page-item"><span class="page-link">',
			'first_tag_close' => '</span></li>',
			'last_link' => 'Fin',
			'last_tag_open' => '<li class="page-item"><span class="page-link">',
			'last_tag_close' => '</span></li>'
		);
	}

	public function index() {
		
		$start_at = $this->uri->segment(3) ? $this->uri->segment(3) : 0 ;
		$researches = $this->research_model->get( $start_at );
		
		foreach ($researches as $r) {
			$leader = $this->research_model->leader($r->id);
			$r->leader = $this->user_model->find($leader->user_id);
			$r->leader->participant = $leader;
			$r->faculty = $this->faculty_model->find($r->leader->faculty_slug);
		}

		$this->pag_config['base_url'] = site_url('/welcome/index/');
		$this->pag_config['total_rows'] = $this->research_model->getCount();
		$this->pagination->initialize($this->pag_config);

		$this->load->view('public/home', compact('researches'));
	}

	public function faculty($slug = false) {
		if(!$slug) {
			$faculties = $this->faculty_model->get();
			foreach ($faculties as $f) {
				$f->degrees = $this->degree_model->findByFaculty($f->slug);
				foreach ($f->degrees as $d) {
					$d->researches_count = $this->research_model->countByDegree($d->slug);
				}
			}
			$this->load->view('public/faculty-list', compact('faculties'));
		} else {
			$faculty = $this->faculty_model->find($slug);

			$start_at = $this->uri->segment(4) ? $this->uri->segment(4) : 0 ;
			$researches = $this->research_model->getByFaculty($slug, $start_at);

			foreach ($researches as $r) {
				$leader = $this->research_model->leader($r->id);
				$r->leader = $this->user_model->find($leader->user_id);
				$r->leader->participant = $leader;
				$r->faculty = $this->faculty_model->find($r->leader->faculty_slug);
			}

			$this->pag_config['base_url'] = site_url('/welcome/faculty/'.$slug.'/');
			$this->pag_config['total_rows'] = $this->research_model->getByFacultyCount($slug);
			$this->pagination->initialize($this->pag_config);

			$this->load->view('public/faculty', compact('faculty', 'researches'));
		}
	}

	public function degree($slug) {
		$degree = $this->degree_model->find($slug);

		$start_at = $this->uri->segment(4) ? $this->uri->segment(4) : 0;
		$researches = $this->research_model->getByDegree($slug, $start_at);

		foreach ($researches as $r) {
			$leader = $this->research_model->leader($r->id);
			$r->leader = $this->user_model->find($leader->user_id);
			$r->leader->participant = $leader;
			$r->faculty = $this->faculty_model->find($r->leader->faculty_slug);
		}

		$this->pag_config['base_url'] = site_url('/welcome/degree/'.$slug.'/');
		$this->pag_config['total_rows'] = $this->research_model->getByDegreeCount($slug);
		$this->pagination->initialize($this->pag_config);

		$this->load->view('public/degree', compact('degree', 'researches'));
	}

	public function researcher($slug = false) {
		if(!$slug) {
			$participants = $this->participant_model->get();
			foreach ($participants as $p) {
				$p->user = $this->user_model->find($p->user_id);
				if ( $p->user ) {
					$p->faculty = $this->faculty_model->find($p->user->faculty_slug);
					$p->degree = false;
				} else {
					$p->degree = $this->degree_model->find($p->degree_slug);
					$p->faculty = $this->faculty_model->findByDegree($p->degree_slug);
				}
			}
			$this->load->view('public/researcher-list', compact('participants'));
		} else {
			$researcher = $this->participant_model->findBySlug($slug);
			if($researcher) {
				$researcher->user = $this->user_model->find($researcher->user_id);
				if ( $researcher->user ) {
					$researcher->faculty = $this->faculty_model->find($researcher->user->faculty_slug);
					$researcher->degree = false;
				} else {
					$researcher->degree = $this->degree_model->find($researcher->degree_slug);
					$researcher->faculty = $this->faculty_model->findByDegree($researcher->degree_slug);
				}
				$researches = $this->research_model->getByParticipant($researcher->id);
				foreach ($researches as $r) {
					$leader = $this->research_model->leader($r->id);
					$r->leader = $this->user_model->find($leader->user_id);
					$r->leader->participant = $leader;
					$r->faculty = $this->faculty_model->find($r->leader->faculty_slug);
				}
				$this->load->view('public/researcher', compact('researcher', 'researches'));	
			} else {
				redirect('welcome/researcher');
			}
		}
	}


	public function research($slug = false) {
		if(!$slug) {
			redirect('welcome');
		}
		$research = $this->research_model->findBySlug($slug);
		if ( $research ) {
			$leader = $this->research_model->leader($research->id);
			$research->leader = $this->user_model->find($leader->user_id);
			$research->leader->participant = $leader;
			$research->faculty = $this->faculty_model->find($research->leader->faculty_slug);

			$research->subjects = $this->research_model->findSubjects($research->subject);
			$research->requirements = $this->requirement_model->findByResearch($research->id);
			$research->goals = $this->goal_model->findByResearch($research->id);
			$research->citations = $this->citation_model->findByResearch($research->id);
			
			$research->researchers = $this->research_model->findParticipants($research->id, 'researcher');
			
			foreach ($research->researchers as $p) {
				if ($p->user_id > 0) {
					$user = $this->user_model->find($p->user_id);
					$p->school = $this->faculty_model->find($user->faculty_slug);
				} else {
					$p->school = $this->degree_model->find($p->degree_slug);
				}
			}

			$research->students = $this->research_model->findParticipants($research->id, 'student');

			foreach ($research->students as $p) {
				if ($p->user_id > 0) {
					$user = $this->user_model->find($p->user_id);
					$p->school = $this->faculty_model->find($user->faculty_slug);
				} else {
					$p->school = $this->degree_model->find($p->degree_slug);
				}
			}

			$research->degrees = $this->research_model->findDegrees($research->id);

			$this->load->view('public/research', compact('research'));
		} else {
			redirect('welcome');
		}
	}
}
