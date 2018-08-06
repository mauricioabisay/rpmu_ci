<?php

/**
 * 
 */
class User extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		if(is_null($this->session->user)) {
			redirect('admin/login', 'refresh');
		}
		$this->load->model('faculty_model');
		$this->load->model('user_model');
		$this->load->model('participant_model');
	}

	public function index() {
		$total_rows = $this->user_model->getCount();
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
			'base_url' => site_url('/user/index/'),
			'total_rows' => $total_rows,
			'num_links' => ceil( $total_rows/$this->config->item('admin_items_per_page') )
		);
		$this->pagination->initialize($pag_config);

		$start_at = $this->uri->segment(3) ? $this->uri->segment(3) : 0 ;
		$users = $this->user_model->get($start_at, $pag_config['per_page']);
		foreach ($users as $u) {
			$u->participant = $this->user_model->findParticipant($u->id);
		}
		$this->load->view('admin/user/list', compact('users'));
	}

	public function create() {
		$faculties = $this->faculty_model->get();
		$this->load->view('admin/user/create', compact('faculties'));
	}

	public function store() {
		if ( $this->input->post() ) {
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('role', 'Rol', 'required');

			$this->form_validation->set_rules('id', 'Matrícula', 'trim|required|integer|max_length[10]');
			$this->form_validation->set_rules('bio', 'Bio', 'trim');
			$this->form_validation->set_rules('link', 'Link', 'trim|valid_url');
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

				$user['email'] = $this->input->post('email');
				$user['role'] = $this->input->post('role');
				$user['faculty_slug'] = $this->input->post('faculty_slug');

				$participant['user_id'] = $this->user_model->insert($user);

				$participant['id'] = $this->input->post('id');
				$participant['name'] = $this->input->post('name');
				$participant['slug'] = strtolower( strtr( $this->input->post('name'), $unwanted_array ) );
				$participant['bio'] = $this->input->post('bio');
				$participant['link'] = $this->input->post('link');
								
				$this->participant_model->insert($participant);
				
				redirect('/user/', 'refresh');
			} else {
				$faculties = $this->faculty_model->get();
				$this->load->view('admin/user/create', compact('faculties'));
			}
		}
	}

	public function edit($id) {
		$user = $this->user_model->find($id);
		$user->participant = $this->user_model->findParticipant($id);
		$faculties = $this->faculty_model->get();
		$this->load->view('admin/user/edit', compact('user','faculties'));
	}

	public function update() {
		if ( $this->input->post() ) {
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('role', 'Rol', 'required');

			$this->form_validation->set_rules('id', 'Matrícula', 'trim|required|integer|max_length[10]');
			$this->form_validation->set_rules('bio', 'Bio', 'trim|alpha_numeric_spaces');
			$this->form_validation->set_rules('link', 'Link', 'trim|valid_url');
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

				$user['id'] = $this->input->post('user_id');
				$user['email'] = $this->input->post('email');
				$user['role'] = $this->input->post('role');
				$user['faculty_slug'] = $this->input->post('faculty_slug');

				$this->user_model->update($user);

				$participant['id'] = $this->input->post('id');
				$participant['name'] = $this->input->post('name');
				$participant['slug'] = strtolower( strtr( $this->input->post('name'), $unwanted_array ) );
				$participant['bio'] = $this->input->post('bio');
				$participant['link'] = $this->input->post('link');
								
				$this->participant_model->update($participant, $this->input->post('participant_id'));
				
				redirect('/user/', 'refresh');
			} else {
				$faculties = $this->faculty_model->get();
				$this->load->view('admin/user/edit', compact('faculties'));
			}
		}
	}

	public function destroy() {
		if ( $this->input->post('id') ) {
			$this->user_model->delete($this->input->post('id'));
			redirect('/user/', 'refresh');
		}
	}
}