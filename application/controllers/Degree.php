<?php

/**
 * 
 */
class Degree extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		if(is_null($this->session->user)) {
			redirect('admin/login', 'refresh');
		}
		$this->load->model('faculty_model');
		$this->load->model('degree_model');
	}

	public function index() {
		$total_rows = $this->degree_model->getCount();
		$pag_config = array(
			'per_page' => $this->config->item('admin_items_per_page'),
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
			'last_tag_close' => '</span></li>',
			'base_url' => site_url('/degree/index/'),
			'total_rows' => $total_rows,
			'num_links' => ceil( $total_rows/$this->config->item('admin_items_per_page') )
		);
		$this->pagination->initialize($pag_config);

		$start_at = $this->uri->segment(3) ? $this->uri->segment(3) : 0 ;
		$degrees = $this->degree_model->get($start_at, $pag_config['per_page']);
		
		$this->load->view('admin/degree/list', compact('degrees'));
	}

	public function create() {
		$faculties = $this->faculty_model->get();
		$this->load->view('admin/degree/create', compact('faculties'));
	}

	public function store() {
		if($this->input->post()) {
			$this->form_validation->set_rules('title', 'Carrera', 'trim|required|max_length[190]');
			$this->form_validation->set_rules('faculty_slug', 'Facultad', 'required');

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
				$data['faculty_slug'] = $this->input->post('faculty_slug');
				
				$this->degree_model->insert($data);
				
				redirect('/degree/', 'refresh');
			} else {
				$faculties = $this->faculty_model->get();
				$this->load->view('admin/degree/create', compact('faculties'));
			}
		}
	}

	public function destroy() {
		if ( $this->input->post('slug') ) {
			$this->degree_model->delete($this->input->post('slug'));
			redirect('/degree/', 'refresh');
		}
	}
}