<?php $this->load->view('admin/layouts/main');?>
	
<form action="<?php echo site_url('research/store');?>" method="post" enctype="multipart/form-data">
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
			<a href="#development" class="nav-link" id="development-tab" data-toggle="tab">Desarrollo</a>
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
					<input 
						type="text" 
						class="form-control" 
						id="title" 
						name="title" 
						value="<?php echo set_value('title') ;?>">
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

				<div id="subject-cloud" class="form-group rpm-api-cloud"></div>

				<div class="form-group">
					<label for="abstract">Síntesis:</label>
					<textarea name="abstract" id="abstract" cols="30" rows="3" class="form-control" placeholder="Descripción breve del proyecto"><?php echo set_value('abstract');?></textarea>
				</div>
				
				<div class="form-group">
					<label for="featured_image">Imagen de portada:</label>
					<input type="file" id="featured_image" class="form-control-file single-file" name="featured_image" ariadescribedby="featured-image-help">
					<img class="thumb thumb-featured-image" src="">
					<small id="featured-image-help" class="form-text text-muted">Elige una imagen de portada para tu investigación.</small>
				</div>

			</fieldset>
		</div>
		<div class="tab-pane fade" id="requirements">
			<fieldset>
				<legend>Requisitos y Equipamiento</legend>
				<?php 
					$len = (is_array(set_value('requirement_title'))) ? sizeof(set_value('requirement_title')) : 0;
				?>
				<?php for ( $i = 0; $i < $len; $i++ ) : ?>
					<?php if ( 
							( set_value('requirement_delete')[$i] < 0 ) 
							&& ( 
								( strlen(set_value('requirement_title')[$i]) > 0 ) 
								|| ( strlen(set_value('requirement_description')[$i]) > 0 ) 
							)
						) : ?>
					<div class="form-inline rpm-dynamic-list-item">
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
				<?php $len = (is_array(set_value('goal_title'))) ? sizeof(set_value('goal_title')) : 0 ?>
				<?php for ( $i = 0; $i < $len; $i++ ) : ?>
					<?php if ( 
							( set_value('goal_delete')[$i] < 0 )
							&& ( 
								( strlen(set_value('goal_title')[$i]) > 0 ) 
								|| ( strlen(set_value('goal_description')[$i]) > 0 )  
							)
						) : ?>
					<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="goal">
						<input class="delete" type="hidden" name="goal_delete[]" value="<?php echo set_value('goal_delete')[$i] ;?>">
						<input class="id" type="hidden" name="goal_id[]" value="<?php echo set_value('goal_id')[$i] ;?>">
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="goal_title[]" placeholder="Título" value="<?php echo set_value('goal_title')[$i] ;?>">
						</div>
						<div class="form-group col-md-6">
							<textarea name="goal_description[]" class="form-control" cols="30" rows="3" placeholder="Descripción"><?php echo set_value('goal_description')[$i] ;?></textarea>
						</div>
						<div class="form-group col-md-1">
							<input class="btn btn-primary minus" type="button" value="-">
						</div>
					</div>
					<?php endif ?>
				<?php endfor ?>
				<div class="form-inline rpm-dynamic-list-item" rpm-dynamic-list-prefix="goal">
					<input class="delete" type="hidden" name="goal_delete[]" value="-1">
					<input class="id" type="hidden" name="goal_id[]" value="-1">
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
				
				<div id="researchers-cloud" class="form-group rpm-api-cloud"></div>
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
				
				<div id="participants-cloud" class="form-group rpm-api-cloud"></div>
			</fieldset>
		</div>
		
		<div class="tab-pane fade" id="development" role="tabpanel">
			<fieldset>
				<legend>Desarrollo</legend>

				<div class="form-group">
					<label for="description">Descripción detallada:</label>
					<textarea name="description" id="description" cols="30" rows="20" class="form-control" placeholder="Descripción detallada del proyecto"><?php echo set_value('description');?></textarea>
				</div>

				<div class="form-group">
					<label for="extra_info">Notas al pie:</label>
					<textarea name="extra_info" id="extra_info" cols="30" rows="3" class="form-control" placeholder="Comentarios adicionales"><?php echo set_value('extra_info');?></textarea>
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

					<div class="multi-file-gallery"></div>

					<small id="gallery-help" class="form-text text-muted">Agrega imágenes para la galería del proyecto.</small>
				</div>

			</fieldset>
		</div>

		<div class="tab-pane fade rpm-citations-tab" id="citations" role="tabpanel">
			<fieldset>
				<legend>Publicaciones</legend>
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