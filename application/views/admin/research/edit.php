<?php $this->load->view('admin/layouts/main');?>
	
<form action="<?php echo site_url('research/update');?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="research_id" value="<?php echo $research->id;?>">
	
	<ul class="nav nav-tabs" id="rpm-research-tab" role="tablist">
		<li class="nav-item">
			<a href="#general-info" class="nav-link active" id="general-info-tab" data-toggle="tab">General</a>
		</li>
		<li class="nav-item">
			<a href="#requirements" class="nav-link" id="requirements-tab" data-toggle="tab">Requisitos</a>
		</li>
		<li class="nav-item">
			<a href="#goals" class="nav-link" id="goals-tab" data-toggle="tab">Metas</a>
		</li>
		<li class="nav-item">
			<a href="#participants" class="nav-link" id="participants-tab" data-toggle="tab">Participantes</a>
		</li>
		<li class="nav-item">
			<a href="#gallery" class="nav-link" id="gallery-tab" data-toggle="tab">Galería</a>
		</li>
		<li class="nav-item">
			<a href="#citations" class="nav-link" id="citations-tab" data-toggle="tab">Publicaciones</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade show active" id="general-info" role="tabpanel">
			<fieldset>
				<legend>Información General</legend>
				<div class="form-group">
					<label for="title">Título:</label>
					<input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', $research->title) ;?>">
				</div>
				
				<div class="form-group">
					<label for="subject">Tema:</label>
					
					<input 
						type="text" 
						placeholder="Buscar tema..."  
						class="form-control rpm-api-search-slug-cloud" 
						rpm-api="<?php echo site_url('api/subjects') ;?>" 
						rpm-api-list="subject-list"
						rpm-api-result-id="slug"
						rpm-api-result-human="title"
						rpm-api-input="subject"
						rpm-api-cloud="subject-cloud">

					<ul id="subject-list" class="rpm-api-list"></ul>
				</div>

				<div id="subject-cloud" class="form-group rpm-api-cloud">
					<?php foreach ( $research->subjects as $subject ) : ?>
						<button class="btn btn-primary rpm-badge" type="button" rpm-input="<?php echo $subject->slug ;?>"><span><?php echo $subject->title ;?></span></button>
						<input type="hidden" name="subject[]" id="<?php echo $subject->slug ;?>" value="<?php echo $subject->slug ;?>">
					<?php endforeach ?>
				</div>

				<div class="form-group">
					<label for="abstract">Síntesis:</label>
					<textarea name="abstract" id="abstract" cols="30" rows="3" class="form-control"><?php echo set_value('abstract', $research->abstract) ;?></textarea>
				</div>
				
				<div class="form-group">
					<label for="featured-image">Imagen de portada:</label>
					<input type="file" id="featured_image" class="form-control-file single-file" name="featured_image" aria-describedby="featured-image-help">
					<img class="thumb thumb-featured-image" src="<?php echo base_url('uploads/researches/'.$research->id.'/image.jpg');?>">
					<small id="featured-image-help" class="form-text text-muted">Elige una imagen de portada para tu investigación.</small>
				</div>

			</fieldset>
		</div>
		<div class="tab-pane fade" id="requirements">
			<fieldset>
				<legend>Requisitos y Equipamiento</legend>
				<?php 
					$len = (is_array(set_value('requirement_title[]'))) ? count(set_value('requirement_title[]')) : 0;
				?>
				<?php if ( $len > 0 ) : ?>
					<?php for ( $i = 0; $i < $len; $i++ ) : ?>
						<?php if ( (strlen(set_value('requirement_title')[$i]) > 0) || (strlen(set_value('requirement_description')[$i]) > 0) ) : ?>
						<div class="form-inline rpm-dynamic-list-item" <?php echo ( set_value('requirement_delete')[$i] > 0 ) ? 'style=display:none' : '' ;?>>
							<input type="hidden" class="delete" name="requirement_delete[]" value="<?php echo set_value('requirement_delete')[$i] ;?>">
							<input type="hidden" class="id" name="requirement_id[]" value="<?php echo set_value('requirement_id')[$i] ;?>">
							<div class="form-group col-md-4">
								<input type="text" class="form-control" name="requirement_title[]" placeholder="Título" value="<?php echo set_value('requirement_title')[$i] ;?>">
							</div>
							<div class="form-group col-md-6">
								<textarea name="requirement_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo set_value('requirement_description')[$i] ;?></textarea>
							</div>
							<div class="form-group col-md-1">
								<input class="btn btn-primary minus" type="button" value="-">
							</div>
						</div>
						<?php endif ?>
					<?php endfor ?>
				<?php else : ?>
					<?php foreach ( $research->requirements as $requirement ) : ?>
						<div class="form-inline rpm-dynamic-list-item">
							<input type="hidden" class="delete" name="requirement_delete[]" value="-1">
							<input type="hidden" class="id" name="requirement_id[]" value="<?php echo $requirement->id ;?>">
							<div class="form-group col-md-4">
								<input type="text" class="form-control" name="requirement_title[]" placeholder="Título" value="<?php echo $requirement->title ;?>">
							</div>
							<div class="form-group col-md-6">
								<textarea name="requirement_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo $requirement->description ;?></textarea>
							</div>
							<div class="form-group col-md-1">
								<input class="btn btn-primary minus" type="button" value="-">
							</div>
						</div>	
					<?php endforeach ?>
				<?php endif ?>
				<div class="form-inline rpm-dynamic-list-item">
					<input type="hidden" class="delete" name="requirement_delete[]" value="-1">
					<input type="hidden" class="id" name="requirement_id[]" value="-1">
					<div class="form-group col-md-4">
						<input type="text" class="form-control" name="requirement_title[]" placeholder="Título">
					</div>
					<div class="form-group col-md-6">
						<textarea name="requirement_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"></textarea>
					</div>
					<div class="form-group col-md-1">
						<input class="btn btn-primary plus" type="button" value="+">
					</div>
				</div>
			</fieldset>
		</div>
		<div class="tab-pane fade" id="goals">
			<fieldset>
				<legend>Metas</legend>
				<?php 
					$len = (is_array(set_value('goal_title'))) ? count(set_value('goal_title')) : 0;
				?>
				<?php if ( $len > 0 ) : ?>
					<?php for ( $i = 0; $i < $len; $i++ ) : ?>
						<?php if ( (strlen(set_value('goal_title')[$i]) > 0) || (strlen(set_value('goal_description')[$i]) > 0) ) : ?>
						<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="goal" <?php echo ( set_value('goal_delete')[$i] > 0 ) ? 'style=display:none' : '' ;?>>
							<input class="delete" type="hidden" name="goal_delete[]" value="<?php echo set_value('goal_delete')[$i] ;?>">
							<input class="id" type="hidden" name="goal_id[]" value="<?php echo set_value('goal_id')[$i] ;?>">
							<div class="form-group col-md-4">
								<input type="text" class="form-control" name="goal_title[]" placeholder="Título" value="<?php echo set_value('goal_title')[$i] ;?>">
							</div>
							<div class="form-group col-md-5">
								<textarea name="goal_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo set_value('goal_description')[$i] ;?></textarea>
							</div>
							<div class="form-group col-md-2">
								<label>Estado:</label>
								<select class="form-control" name="goal_achieve[]">
									<option value="0" <?php echo ( set_value('goal_achieve')[$i] == 0 ) ? 'selected="selected"' : '' ;?>>Pendiente</option>
									<option value="1" <?php echo ( set_value('goal_achieve')[$i] > 0 ) ? 'selected="selected"' : '' ;?>>Completada</option>
								</select>
							</div>
							<div class="form-group col-md-1">
								<input class="btn btn-primary minus" type="button" value="-">
							</div>
						</div>
						<?php endif ?>
					<?php endfor ?>
				<?php else : ?>
					<?php foreach ( $research->goals as $goal ) : ?>
						<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="goal">
							<input class="delete" type="hidden" name="goal_delete[]" value="-1">
							<input class="id" type="hidden" name="goal_id[]" value="<?php echo $goal->id ;?>">
							<div class="form-group col-md-4">
								<input type="text" class="form-control" name="goal_title[]" placeholder="Título" value="<?php echo $goal->title ;?>">
							</div>
							<div class="form-group col-md-5">
								<textarea name="goal_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo $goal->description ;?></textarea>
							</div>
							<div class="form-group col-md-2">
								<label>Estado:</label>
								<select class="form-control" name="goal_achieve[]">
									<option value="0" <?php echo ( $goal->achieve == 0 ) ? 'selected="selected"' : '';?>>Pendiente</option>
									<option value="1" <?php echo ( $goal->achieve > 0 ) ? 'selected="selected"' : '';?>>Completada</option>
								</select>
							</div>
							<div class="form-group col-md-1">
								<input class="btn btn-primary minus" type="button" value="-">
							</div>
						</div>
					<?php endforeach ?>
				<?php endif ?>
				<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="goal">
					<input class="delete" type="hidden" name="goal_delete[]" value="-1">
					<input class="id" type="hidden" name="goal_id[]" value="-1">
					<input type="hidden" name="goal_achieve[]" value="0">
					<div class="form-group col-md-4">
						<input type="text" class="form-control" name="goal_title[]" placeholder="Título">
					</div>
					<div class="form-group col-md-6">
						<textarea name="goal_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"></textarea>
					</div>
					<div class="form-group col-md-1">
						<input class="btn btn-primary plus" type="button" value="+">
					</div>
				</div>
			</fieldset>
		</div>
		<div class="tab-pane fade" id="participants">
			<fieldset>
				<legend>Investigadores</legend>
				<div class="form-group">
					<input 
						type="text" 
						placeholder="ID/Nombre"  
						class="form-control rpm-api-search-slug-cloud" 
						rpm-api="<?php echo site_url('api/participants') ;?>" 
						rpm-api-list="researchers-list"
						rpm-api-result-id="id" 
						rpm-api-result-human="name"
						rpm-api-input="researchers"
						rpm-api-cloud="researchers-cloud">

					<ul id="researchers-list" class="rpm-api-list"></ul>
				</div>
				
				<div id="researchers-cloud" class="form-group rpm-api-cloud">
					<?php foreach ( $research->researchers as $researcher ) : ?>
						<button class="btn btn-primary rpm-badge" type="button" rpm-input="<?php echo $researcher->id ;?>" rpm-delete="researchers_delete[]"><span><?php echo $researcher->name ;?></span></button>
						<input type="hidden" name="researchers[]" id="<?php echo $researcher->id ;?>" value="<?php echo $researcher->id ;?>">
					<?php endforeach ?>
				</div>
			</fieldset>
			<fieldset>
				<legend>Estudiantes</legend>
				<div class="form-group">
					<input 
						type="text" 
						placeholder="ID/Nombre"  
						class="form-control rpm-api-search-slug-cloud" 
						rpm-api="<?php echo site_url('api/participants') ;?>" 
						rpm-api-list="participants-list"
						rpm-api-result-id="id" 
						rpm-api-result-human="name"
						rpm-api-input="participants"
						rpm-api-cloud="participants-cloud">

					<ul id="participants-list" class="rpm-api-list"></ul>
				</div>
				
				<div id="participants-cloud" class="form-group rpm-api-cloud">
					<?php foreach ( $research->students as $participant ) : ?>
						<button class="btn btn-primary rpm-badge" type="button" rpm-input="<?php echo $participant->id ;?>" rpm-delete="participants_delete[]"><span><?php echo $participant->name ;?></span></button>
						<input type="hidden" name="participants[]" id="<?php echo $participant->id ;?>" value="<?php echo $participant->id ;?>">
					<?php endforeach ?>
				</div>
			</fieldset>
		</div>
		<div class="tab-pane fade" id="gallery" role="tabpanel">
			<fieldset>
				<legend>Galería</legend>
				
				<div class="form-group rpm-multi-file-container">
					<label>Imágenes:</label>
					
					<div class="rpm-multi-file-item">
						<input type="file" class="form-control-file multi-file" name="gallery[]" ariadescribedby="gallery-help" rpm-prefix="gallery" multiple>
					</div>

					<div class="multi-file-gallery">
						<?php $items = directory_map('./uploads/researches/'.$research->id.'/gallery/', 1);?>
						<?php foreach ($items as $item) : ?>
							<div class="col-3 rpm-multi-file-thumb">
								<div class="rpm-multi-file-thumb-delete">X</div>
								<img src="<?php echo base_url().'/uploads/researches/'.$research->id.'/gallery/'.$item;?>">
								<input type="hidden" class="delete" name="gallery_delete_from_storage[]" value="-1">
							</div>
						<?php endforeach ?>
					</div>

					<small id="gallery-help" class="form-text text-muted">Agrega imágenes para la galería del proyecto.</small>
				</div>

			</fieldset>
		</div>
		<div class="tab-pane fade rpm-citations-tab" id="citations" role="tabpanel">
			<fieldset>
				<legend>Publicaciones</legend>
				<?php foreach ( $research->citations as $citation ) : ?>
					<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="citation">
						<input class="delete" type="hidden" name="citation_delete[]" value="-1">
						<input class="id" type="hidden" name="citation_id[]" value="<?php echo $citation->id ;?>">
						<div class="form-group col-md-6">
							<textarea name="citation_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo $citation->description ;?></textarea>
						</div>
						<input type="hidden" name="citation_type[]" value="-1">
						<input type="hidden" name="citation_link[]" value="<?php echo $citation->link;?>">
						<input type="file" name="citation_file[]" style="display: none;">
						<div class="col-md-5">
							<a 
								href="<?php echo (strpos($citation->link, 'http') === FALSE) ? base_url().$citation->link : $citation->link;?>" 
								target="_blank">Ver referencia</a>
						</div>
						<div class="form-group col-md-1">
							<input class="btn btn-primary minus" type="button" value="-">
						</div>
					</div>
				<?php endforeach ?>
				<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="citation">
					<input class="delete" type="hidden" name="citation_delete[]" value="-1">
					<input class="id" type="hidden" name="citation_id[]" value="-1">
					<div class="form-group col-md-4">
						<textarea name="citation_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"></textarea>
					</div>
					<div class="form-group col-md-3 type">
						<p>
							Tipo:
							<select name="citation_type[]">
								<option>Selecione...</option>
								<option value="link">Link</option>
								<option value="file">Archivo</option>
							</select>
						</p>
					</div>
					<div class="form-group col-md-4">
						<input type="text" class="rpm-citation-link" name="citation_link[]" placeholder="http://google.com">
						<input type="file" class="rpm-citation-file form-control-file" name="citation_file[]" multiple>
					</div>
					<div class="form-group col-md-1">
						<input class="btn btn-primary plus" type="button" value="+">
					</div>
				</div>
			</fieldset>
		</div>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" value="Guardar">
	</div>
</form>

<?php $this->load->view('admin/layouts/footer');?>