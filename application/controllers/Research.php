<?php
class Research extends CI_Controller
{

	public function __construct() {
		parent::__construct();

		if(is_null($this->session->user)) {
			redirect('admin/login', 'refresh');
		}

		$this->load->library('upload');

		$this->load->helper('directory');

		$this->load->model('research_model');
		$this->load->model('requirement_model');
		$this->load->model('goal_model');
		$this->load->model('citation_model');
		$this->load->model('user_model');
	}

	public function index() {
		$total_rows = $this->research_model->getCount();
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
			'base_url' => site_url('/research/index/'),
			'total_rows' => $total_rows,
			'num_links' => ceil( $total_rows/$this->config->item('admin_items_per_page') )
		);
		$this->pagination->initialize($pag_config);

		$start_at = $this->uri->segment(3) ? $this->uri->segment(3) : 0 ;
		$researches = $this->research_model->get($start_at, $pag_config['per_page']);

		foreach ($researches as $r) {
			$leader = $this->research_model->leader($r->id);
			$r->leader = $this->user_model->find($leader->user_id);
			$r->leader->participant = $leader;
		}
		$this->load->view('admin/research/list', compact('researches'));
	}

	public function create() {
		$this->load->view('admin/research/create');
	}

	public function store() {
		if ( $this->input->post() ) {
			$this->form_validation->set_rules('title', 'Título', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('subject[]', 'Tema', 'trim');
			$this->form_validation->set_rules('abstract', 'Síntesis', 'trim|required');

			$this->form_validation->set_rules('requirement_delete[]', 'Req.Borrar', 'trim');
			$this->form_validation->set_rules('requirement_id[]', 'Req.Id', 'trim');
			$this->form_validation->set_rules('requirement_title[]', 'Req.Título', 'trim');
			$this->form_validation->set_rules('requirement_description[]', 'Req.Desc.', 'trim');

			$this->form_validation->set_rules('goal_delete[]', 'Meta Borrar', 'trim');
			$this->form_validation->set_rules('goal_id[]', 'Meta Id', 'trim');
			$this->form_validation->set_rules('goal_title[]', 'Meta Título', 'trim');
			$this->form_validation->set_rules('goal_description[]', 'Meta Desc.', 'trim');			
			
			$this->form_validation->set_rules('researchers[]', 'Investigadores', 'trim');
			$this->form_validation->set_rules('participants[]', 'Estudiantes', 'trim');

			$this->form_validation->set_rules('citation_delete[]', 'Pub.Borrar', 'trim');
			$this->form_validation->set_rules('citation_id[]', 'Pub.Id', 'trim');
			$this->form_validation->set_rules('citation_description[]', 'Pub.Desc.', 'trim');
			$this->form_validation->set_rules('citation_type[]', 'Pub.Tipo', 'trim');
			$this->form_validation->set_rules('citation_link[]', 'Pub.Link', 'trim');

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

				//Research
				$research['slug'] = strtolower( strtr( $this->input->post('title'), $unwanted_array ) );
				$research['title'] = $this->input->post('title');
				$research['abstract'] = $this->input->post('abstract');
				$research['subject'] = implode(',', $this->input->post('subject'));
				$research['description'] = '';
				$research['extra_info'] = '';
				
				$research_id = $this->research_model->insert($research);

				//Leader
				$this->research_model->insertParticipant($research_id, $this->session->user->participant->id, 'leader');
				//Researchers
				$len = count($this->input->post('researchers[]'));
				$ids = $this->input->post('researchers[]');
				for( $i= 0; $i < $len; $i++ ) {
					$this->research_model->insertParticipant($research_id, $ids[$i], 'researcher');
				}
				//Students
				$len = count($this->input->post('participants[]'));
				$ids = $this->input->post('participants[]');
				for( $i= 0; $i < $len; $i++ ) {
					$this->research_model->insertParticipant($research_id, $ids[$i], 'student');
				}
				//Create research directory structure
				$research_path = './uploads/researches/'.$research_id;
				$gallery_path = $research_path.'/gallery';
				$publications_path = $research_path.'/publications';
				if ( !is_dir('./uploads/researches') ) {
					mkdir('./uploads/researches', 0777);
				}
				if ( !is_dir($research_path) ) {
					mkdir($research_path, 0777);
				}
				if ( !is_dir($gallery_path) ) {
					mkdir($gallery_path, 0777);
				}
				if ( !is_dir($publications_path) ) {
					mkdir($publications_path, 0777);
				}

				//Requirements
				$len = count($this->input->post('requirement_id[]'));
				$ids = $this->input->post('requirement_id[]');
				$deletes = $this->input->post('requirement_delete[]');
				$titles = $this->input->post('requirement_title[]');
				$descriptions = $this->input->post('requirement_description[]');
				
				$requirement['research_id'] = $research_id;
				for( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				        if ( strlen($titles[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update requirement
				            } else {
				                //Create new requirement
				                $requirement['title'] = $titles[$i];
				                $requirement['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $this->requirement_model->insert($requirement);
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete requirement
				    }
				}
				
				//Goals
				$len = count($this->input->post('goal_id[]'));
				$ids = $this->input->post('goal_id[]');
				$deletes = $this->input->post('goal_delete[]');
				$titles = $this->input->post('goal_title[]');
				$descriptions = $this->input->post('goal_description[]');
				
				$goal['research_id'] = $research_id;
				for ( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				        if ( strlen($titles[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update goal
				            } else {
				                //Create new goal
				                $goal['title'] = $titles[$i];
				                $goal['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $this->goal_model->insert($goal);
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete goal
				    }
				}

				//Publications
				$len = count($this->input->post('citation_id[]'));
				$ids = $this->input->post('citation_id[]');
				$deletes = $this->input->post('citation_delete[]');
				$descriptions = $this->input->post('citation_description[]');
				$types = $this->input->post('citation_type[]');
				$links = $this->input->post('citation_link[]');
				
				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|odt|xls|xlsx|ods|ppt|pptx';
				$upload_config['upload_path'] = $publications_path;
				$upload_config['encrypt_name'] = TRUE;

				$this->upload->initialize($upload_config);

				$citation['research_id'] = $research_id;
				for ( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				        if ( strlen($descriptions[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update Citation
				            } else {
				                //Create new Citation
				                $citation['description'] = $descriptions[$i];

				                if ( $types[$i] === 'file' ) {
				                	//Upload file
				                	if ( $_FILES['citation_file']['name'][$i] ) {
				                		$_FILES['file']['name'] = $_FILES['citation_file']['name'][$i];
				                		$_FILES['file']['type'] = $_FILES['citation_file']['type'][$i];
				                		$_FILES['file']['tmp_name'] = $_FILES['citation_file']['tmp_name'][$i];
				                		$_FILES['file']['error'] = $_FILES['citation_file']['error'][$i];
				                		$_FILES['file']['size'] = $_FILES['citation_file']['size'][$i];

				                		if ( !$this->upload->do_upload('file') ) {
				                			//Error while uploading
				                			//print_r($this->upload->display_errors());
				                			$citation['link'] = false;
				                		} else {
				                			$citation['link'] = 'uploads/researches/'.$research_id.'/publications/'.$this->upload->data('file_name');
				                		}
				                	}
				                } else {
				                    $citation['link'] = ( stristr($links[$i], 'http://') || (stristr($links[$i], 'https://')) ) ? $links[$i] : 'http://'.$links[$i];
				                }
				                if($citation['link']) {
				                	$this->citation_model->insert($citation);
				                }
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete goal
				    }
				}				


				//Upload gallery
				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				$upload_config['upload_path'] = $gallery_path;
				$upload_config['encrypt_name'] = TRUE;

				$this->upload->initialize($upload_config);

				$len = count($_FILES['gallery']['name']);
				for( $i = 0; $i < $len; $i++ ) {
					if ( $_FILES['gallery']['name'][$i] ) {
						$_FILES['item']['name'] = $_FILES['gallery']['name'][$i];
						$_FILES['item']['type'] = $_FILES['gallery']['type'][$i];
						$_FILES['item']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
						$_FILES['item']['error'] = $_FILES['gallery']['error'][$i];
						$_FILES['item']['size'] = $_FILES['gallery']['size'][$i];

						if ( !$this->upload->do_upload('item') ) {
							//Error while uploading
							//print_r($this->upload->display_errors());
						}
					}
				}

				//Upload featured image
				$upload_config['upload_path'] = $research_path;
				$upload_config['encrypt_name'] = FALSE;
				$upload_config['file_name'] = 'image.jpg';

				$this->upload->initialize($upload_config);

				if( !$this->upload->do_upload('featured_image') ) {
					//print_r($this->upload->display_errors());
				}

				redirect('/research/', 'refresh');
			} else {
				$this->load->view('admin/research/create');
			}
		}
	}

	public function edit($id) {
		$research = $this->research_model->find($id);
		
		$research->subjects = $this->research_model->findSubjects($research->subject);

		$research->requirements = $this->requirement_model->findByResearch($id);

		$research->goals = $this->goal_model->findByResearch($id);

		$research->citations = $this->citation_model->findByResearch($id);

		$research->researchers = $this->research_model->findParticipants($id, 'researcher');
		$research->students = $this->research_model->findParticipants($id, 'student');

		$this->load->view('admin/research/edit', compact('research'));
	}

	public function update() {
		if ( $this->input->post() ) {
			$this->form_validation->set_rules('research_id', '', 'trim|required|numeric');
			$this->form_validation->set_rules('title', 'Título', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('subject[]', 'Tema', 'trim');
			$this->form_validation->set_rules('abstract', 'Síntesis', 'trim|required');

			$this->form_validation->set_rules('requirement_delete[]', 'Req.Borrar', 'trim');
			$this->form_validation->set_rules('requirement_id[]', 'Req.Id', 'trim');
			$this->form_validation->set_rules('requirement_title[]', 'Req.Título', 'trim');
			$this->form_validation->set_rules('requirement_description[]', 'Req.Desc.', 'trim');

			$this->form_validation->set_rules('goal_delete[]', 'Meta Borrar', 'trim');
			$this->form_validation->set_rules('goal_id[]', 'Meta Id', 'trim');
			$this->form_validation->set_rules('goal_title[]', 'Meta Título', 'trim');
			$this->form_validation->set_rules('goal_description[]', 'Meta Desc.', 'trim');
			$this->form_validation->set_rules('goal_achieve[]', 'Meta Status', 'trim|numeric');		
			
			$this->form_validation->set_rules('researchers[]', 'Investigadores', 'trim');
			$this->form_validation->set_rules('participants[]', 'Estudiantes', 'trim');

			$this->form_validation->set_rules('citation_delete[]', 'Pub.Borrar', 'trim');
			$this->form_validation->set_rules('citation_id[]', 'Pub.Id', 'trim');
			$this->form_validation->set_rules('citation_description[]', 'Pub.Desc.', 'trim');
			$this->form_validation->set_rules('citation_type[]', 'Pub.Tipo', 'trim');
			$this->form_validation->set_rules('citation_link[]', 'Pub.Link', 'trim');

			$this->form_validation->set_rules('gallery_delete_from_storage[]', 'Galeria Borrar', 'trim');

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

				//Research
				$research_id = $research['id'] = $this->input->post('research_id');
				$research['slug'] = strtolower( strtr( $this->input->post('title'), $unwanted_array ) );
				$research['title'] = $this->input->post('title');
				$research['abstract'] = $this->input->post('abstract');
				$research['subject'] = implode(',', $this->input->post('subject'));
				$research['description'] = '';
				$research['extra_info'] = '';
				
				$this->research_model->update($research);

				$this->research_model->clearParticipants($research_id);
				//Researchers
				$len = count($this->input->post('researchers[]'));
				$ids = $this->input->post('researchers[]');
				for( $i= 0; $i < $len; $i++ ) {
					$this->research_model->insertParticipant($research_id, $ids[$i], 'researcher');
				}
				//Students
				$len = count($this->input->post('participants[]'));
				$ids = $this->input->post('participants[]');
				for( $i= 0; $i < $len; $i++ ) {
					$this->research_model->insertParticipant($research_id, $ids[$i], 'student');
				}
				//Create research directory structure
				$research_path = './uploads/researches/'.$research_id;
				$gallery_path = $research_path.'/gallery';
				$publications_path = $research_path.'/publications';
				if ( !is_dir('./uploads/researches') ) {
					mkdir('./uploads/researches', 0777);
				}
				if ( !is_dir($research_path) ) {
					mkdir($research_path, 0777);
				}
				if ( !is_dir($gallery_path) ) {
					mkdir($gallery_path, 0777);
				}
				if ( !is_dir($publications_path) ) {
					mkdir($publications_path, 0777);
				}

				//Requirements
				$len = count($this->input->post('requirement_id[]'));
				$ids = $this->input->post('requirement_id[]');
				$deletes = $this->input->post('requirement_delete[]');
				$titles = $this->input->post('requirement_title[]');
				$descriptions = $this->input->post('requirement_description[]');
				
				
				for( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				    	$requirement = array('research_id' => $research_id);
				        if ( strlen($titles[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update requirement
				                $requirement['id'] = $ids[$i];
				                $requirement['title'] = $titles[$i];
				                $requirement['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $this->requirement_model->update($requirement);
				            } else {
				                //Create new requirement
				                $requirement['title'] = $titles[$i];
				                $requirement['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $this->requirement_model->insert($requirement);
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete requirement
				        $this->requirement_model->delete($ids[$i]);
				    }
				}
				
				//Goals
				$len = count($this->input->post('goal_id[]'));
				$ids = $this->input->post('goal_id[]');
				$deletes = $this->input->post('goal_delete[]');
				$titles = $this->input->post('goal_title[]');
				$descriptions = $this->input->post('goal_description[]');
				$status = $this->input->post('goal_achieve[]');
				
				for ( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				    	$goal = array('research_id' => $research_id);
				        if ( strlen($titles[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update goal
				                $goal['id'] = $ids[$i];
				                $goal['title'] = $titles[$i];
				                $goal['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $goal['achieve'] = $status[$i];
				                $this->goal_model->update($goal);
				            } else {
				                //Create new goal
				                $goal['title'] = $titles[$i];
				                $goal['description'] = ( strlen($descriptions[$i]) > 0 ) ? $descriptions[$i] : '';
				                $goal['achieve'] = $status[$i];
				                $this->goal_model->insert($goal);
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete goal
				        $this->goal_model->delete($ids[$i]);
				    }
				}

				//Publications
				$len = count($this->input->post('citation_id[]'));
				$ids = $this->input->post('citation_id[]');
				$deletes = $this->input->post('citation_delete[]');
				$descriptions = $this->input->post('citation_description[]');
				$types = $this->input->post('citation_type[]');
				$links = $this->input->post('citation_link[]');
				
				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|odt|xls|xlsx|ods|ppt|pptx';
				$upload_config['upload_path'] = $publications_path;
				$upload_config['encrypt_name'] = TRUE;

				$this->upload->initialize($upload_config);

				for ( $i = 0; $i < $len; $i++ ) {
				    if ( $deletes[$i] < 0 ) {
				    	$citation = array('research_id' => $research_id);
				        if ( strlen($descriptions[$i]) > 0 ) {
				            if ( $ids[$i] >= 0 ) {
				                //Update Citation
				                $citation['id'] = $ids[$i];
				                $citation['description'] = $descriptions[$i];

				                $this->citation_model->update($citation);
				            } else {
				                //Create new Citation
				                $citation['description'] = $descriptions[$i];

				                if ( $types[$i] === 'file' ) {
				                	//Upload file
				                	if ( $_FILES['citation_file']['name'][$i] ) {
				                		$_FILES['file']['name'] = $_FILES['citation_file']['name'][$i];
				                		$_FILES['file']['type'] = $_FILES['citation_file']['type'][$i];
				                		$_FILES['file']['tmp_name'] = $_FILES['citation_file']['tmp_name'][$i];
				                		$_FILES['file']['error'] = $_FILES['citation_file']['error'][$i];
				                		$_FILES['file']['size'] = $_FILES['citation_file']['size'][$i];

				                		if ( !$this->upload->do_upload('file') ) {
				                			//Error while uploading
				                			//print_r($this->upload->display_errors());
				                			$citation['link'] = false;
				                		} else {
				                			$citation['link'] = 'uploads/researches/'.$research_id.'/publications/'.$this->upload->data('file_name');
				                		}
				                	}
				                } else {
				                    $citation['link'] = ( stristr($links[$i], 'http://') || (stristr($links[$i], 'https://')) ) ? $links[$i] : 'http://'.$links[$i];
				                }
				                if($citation['link']) {
				                	$this->citation_model->insert($citation);
				                }
				            }
				        }
				    } elseif ( $ids[$i] >= 0 ) {
				        //Delete citation
				        if ( strpos($links[$i], 'http') === FALSE ) {
				        	unlink('./'.$links[$i]);
				        }
				        $this->citation_model->delete($ids[$i]);
				    }
				}				


				//Delete gallery marked items
				$items = directory_map($gallery_path, 1);
				$len = count($items);
				$delete_images = $this->input->post('gallery_delete_from_storage[]');
				for ( $i=0;  $i < $len ;  $i++) {
					if ( $delete_images[$i] >= 0 ) {
						unlink($gallery_path.'/'.$items[$i]);
					}
				}

				//Upload gallery
				$upload_config['overwrite'] = TRUE;
				$upload_config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
				$upload_config['upload_path'] = $gallery_path;
				$upload_config['encrypt_name'] = TRUE;

				$this->upload->initialize($upload_config);

				$len = count($_FILES['gallery']['name']);
				for( $i = 0; $i < $len; $i++ ) {
					if ( $_FILES['gallery']['name'][$i] ) {
						$_FILES['item']['name'] = $_FILES['gallery']['name'][$i];
						$_FILES['item']['type'] = $_FILES['gallery']['type'][$i];
						$_FILES['item']['tmp_name'] = $_FILES['gallery']['tmp_name'][$i];
						$_FILES['item']['error'] = $_FILES['gallery']['error'][$i];
						$_FILES['item']['size'] = $_FILES['gallery']['size'][$i];

						if ( !$this->upload->do_upload('item') ) {
							//Error while uploading
							//print_r($this->upload->display_errors());
						}
					}
				}

				//Upload featured image
				$upload_config['upload_path'] = $research_path;
				$upload_config['encrypt_name'] = FALSE;
				$upload_config['file_name'] = 'image.jpg';

				$this->upload->initialize($upload_config);

				if( !$this->upload->do_upload('featured_image') ) {
					//print_r($this->upload->display_errors());
				}

				$goals_total = count( $this->goal_model->findByResearch($research_id) );
				$goals_achieved = count( $this->goal_model->findByResearch($research_id, 1) );
				$research = array();
				$research['id'] = $research_id;
				if ( $goals_total > 0 ) {
				    if ( $goals_total === $goals_achieved ) {
				        $research['status'] = 'completed';
				    } elseif ( $goals_achieved > 0 ) {
				        $research['status'] = 'started';
				    } else {
				        $research['status'] = 'created';
				    }
				} else {
				    $research['status'] = 'created';
				}

				$this->research_model->update($research);

				redirect('/research/', 'refresh');
			} else {
				$this->load->view('admin/research/create');
			}
		}
	}

	public function destroy() {
		if ( $this->input->post('id') ) {
			$this->research_model->delete($this->input->post('id'));
			redirect('/research/', 'refresh');
		}
	}
}