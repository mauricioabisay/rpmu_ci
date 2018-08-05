<?php

/**
 * 
 */
class Faculty extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		if(is_null($this->session->user)) {
			redirect('admin/login', 'refresh');
		}
		$this->load->model('faculty_model');
	}

	public function index() {
		$faculties = $this->faculty_model->get();
		
		$this->load->view('admin/faculty/list', compact('faculties'));
	}

	public function create() {
		$this->load->view('admin/faculty/create');
	}

	public function store() {
		if($this->input->post()) {
			$this->form_validation->set_rules('title', 'Facultad', 'trim|required|max_length[190]');
			if( $this->form_validation->run() ) {
				$unwanted_array = array(
				' '=>'-',
				'À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a', 'Å'=>'a', 'Æ'=>'a', 
				'Ç'=>'c', 
				'È'=>'e', 'É'=>'e', 'Ê'=>'e', 'Ë'=>'e', 
				'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i', 
				'Ñ'=>'n', 
				'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o', 'Ø'=>'o', 
				'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u', 'Ü'=>'u',
				'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 
				'ç'=>'c',
				'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 
				'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 
				'ñ'=>'n', 
				'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o','ö'=>'o', 'ø'=>'o', 
				'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ü'=>'u', 
				);

				$data['title'] = $this->input->post('title');
				$data['slug'] = strtolower( strtr( $this->input->post('title'), $unwanted_array ) );
				$this->faculty_model->insert($data);
				
				redirect('/faculty/', 'refresh');
			} else {
				$this->load->view('admin/faculty/create');
			}
		}
	}

	public function destroy() {
		if ( $this->input->post('slug') ) {
			$this->faculty_model->delete($this->input->post('slug'));
			redirect('/faculty/', 'refresh');
		}
	}
}