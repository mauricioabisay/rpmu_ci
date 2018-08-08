<?php

/**
 * 
 */
class Participant extends CI_Controller
{
	public function __construct() {
		parent::__construct();
		if(is_null($this->session->user)) {
			redirect('admin/login', 'refresh');
		}

		$this->load->library('upload');

		$this->load->model('degree_model');
		$this->load->model('participant_model');
		$this->load->model('user_model');
	}

	public function index() {
		$total_rows = $this->participant_model->getCount();
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
			'base_url' => site_url('/participant/index/'),
			'total_rows' => $total_rows,
			'num_links' => ceil( $total_rows/$this->config->item('admin_items_per_page') )
		);
		$this->pagination->initialize($pag_config);

		$start_at = $this->uri->segment(3) ? $this->uri->segment(3) : 0 ;
		$participants = $this->participant_model->get($start_at, $pag_config['per_page']);

		foreach ($participants as $p) {
			$p->user = $this->user_model->find($p->user_id);
			if($p->user_id <= 0) {
				$p->degree = $this->degree_model->find($p->degree_slug);
			}
		}
		$this->load->view('admin/participant/list', compact('participants'));
	}

	public function create() {
		$degrees = $this->degree_model->get();
		$this->load->view('admin/participant/create', compact('degrees'));
	}

	public function store() {
		if ( $this->input->post() ) {
			$this->form_validation->set_rules('id', 'Matrícula', 'trim|required|integer|max_length[10]|is_unique[participants.id]');
			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('bio', 'Bio', 'trim');
			$this->form_validation->set_rules('link', 'Link', 'trim|valid_url');
			$this->form_validation->set_rules('degree_slug', 'Licenciatura', 'required');

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

				$data['id'] = $this->input->post('id');
				$data['name'] = $this->input->post('name');
				$data['slug'] = strtolower( strtr( $this->input->post('name'), $unwanted_array ) );
				$data['bio'] = $this->input->post('bio');
				$data['link'] = $this->input->post('link');
				$data['degree_slug'] = $this->input->post('degree_slug');
				
				$this->participant_model->insert($data);

				$path = './uploads/participants';
				if ( !is_dir($path) ) {
					mkdir($path, 0777);
				}

				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				$upload_config['upload_path'] = $path;
				$upload_config['encrypt_name'] = FALSE;
				$upload_config['file_name'] = $data['id'].'.jpg';
				
				$this->upload->initialize($upload_config);

				if ( !$this->upload->do_upload('profile_photo') ) {

				}
				
				redirect('/participant/', 'refresh');
			} else {
				$degrees = $this->degree_model->get();
				$this->load->view('admin/participant/create', compact('degrees'));
			}
		}
	}

	public function edit($id) {
		$participant = $this->participant_model->find($id);
		$degrees = $this->degree_model->get();
		$this->load->view('admin/participant/edit', compact('participant','degrees'));
	}

	public function update() {
		if ( $this->input->post() ) {
			
			if ( $this->input->post('legacy_id') === $this->input->post('id') ) {
				//Trying to update other data but not the participant's id
				$this->form_validation->set_rules('id', 'Matrícula', 'trim|required|integer|max_length[10]');
			} else {
				//Trying to update the participant's id
				$this->form_validation->set_rules('id', 'Matrícula', 'trim|required|integer|max_length[10]|is_unique[participants.id]');
			}

			$this->form_validation->set_rules('name', 'Nombre', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('bio', 'Bio', 'trim');
			$this->form_validation->set_rules('link', 'Link', 'trim|valid_url');
			$this->form_validation->set_rules('degree_slug', 'Licenciatura', 'required');

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

				$data['id'] = $this->input->post('id');
				$data['name'] = $this->input->post('name');
				$data['slug'] = strtolower( strtr( $this->input->post('name'), $unwanted_array ) );
				$data['bio'] = $this->input->post('bio');
				$data['link'] = $this->input->post('link');
				$data['degree_slug'] = $this->input->post('degree_slug');
				
				$this->participant_model->update($data, $this->input->post('legacy_id'));
				
				$path = './uploads/participants';
				if ( !is_dir($path) ) {
					mkdir($path, 0777);
				}

				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				$upload_config['upload_path'] = $path;
				$upload_config['encrypt_name'] = FALSE;
				$upload_config['file_name'] = $data['id'].'.jpg';
				
				$this->upload->initialize($upload_config);

				if ( !$this->upload->do_upload('profile_photo') ) {

				}

				redirect('/participant/', 'refresh');
			} else {
				$degrees = $this->degree_model->get();
				$this->load->view('admin/participant/create', compact('degrees'));
			}
		}
	}

	public function destroy() {
		if ( $this->input->post('id') ) {
			$this->participant_model->delete($this->input->post('id'));
			redirect('/participant/', 'refresh');
		}
	}
}