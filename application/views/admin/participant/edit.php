<?php $this->load->view('admin/layouts/main'); ?>

	<form action="<?php echo site_url( 'participant/update') ;?>" method="post">
		<input type="hidden" name="legacy_id" value="<?php echo $participant->id;?>">
		<fieldset>
			<legend>Editar Participante</legend>
			
			<div class="form-group">
				<label for="id">ID/Matricula:</label>
				<input type="text" class="form-control" id="id" name="id" value="<?php echo set_value('id', $participant->id);?>">
			</div>

			<div class="form-group">
				<label for="name">Nombre:</label>
				<input type="text" class="form-control" name="name" id="name"  value="<?php echo set_value('name', $participant->name);?>">
			</div>
			
			<div class="form-group">
				<label for="bio">Bio:</label>
				<textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php echo set_value('bio', $participant->bio);?></textarea>
			</div>
			
			<div class="form-group">
				<label for="link">Link:</label>
				<input type="text" class="form-control" id="link" name="link" value="<?php echo set_value('link', $participant->link);?>">
			</div>

			<div class="form-group">
				<label for="degree_slug">Licenciatura:</label>
				<select name="degree_slug" id="degree_slug" class="form-control">
					<?php foreach ( $degrees as $degree ) : ?>
						<option value="<?php echo $degree->slug ;?>" <?php echo set_select('degree_slug', $degree->slug, ($degree->slug === $participant->degree_slug) );?>>
							<?php echo $degree->title ;?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Actualizar">
	</form>

<?php $this->load->view('admin/layouts/footer'); ?>