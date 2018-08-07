<?php $this->load->view('admin/layouts/main'); ?>

	<form method="post" action="<?php echo site_url( 'participant/store' ) ;?>" enctype="multipart/form-data">
		<fieldset>
			<legend>Nuevo Participante</legend>
			
			<div class="form-group">
				<label for="id">ID/Matricula:</label>
				<input type="text" class="form-control" id="id" name="id" value="<?php echo set_value('id');?>">
			</div>

			<div class="form-group">
				<label for="name">Nombre:</label>
				<input type="text" class="form-control" name="name" id="name" value="<?php echo set_value('name');?>">
			</div>

			<div class="form-group">
			    <label for="profile_photo">Foto de perfil:</label>
			    <input type="file" class="form-control-file single-file" id="profile_photo" name="profile_photo" aria-describedby="profile-photo-help">
			    <div class="thumb"></div>
			    <small id="profile-photo-help" class="form-text text-muted">Inserta una imagen de perfil, esta se mostrará cuando seas mencionado en la plataforma.</small>
			</div>
			
			<div class="form-group">
				<label for="bio">Bio:</label>
				<textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php echo set_value('bio');?></textarea>
			</div>
			
			<div class="form-group">
				<label for="link">Link:</label>
				<input type="text" class="form-control" id="link" name="link" value="<?php echo set_value('link');?>">
			</div>

			<div class="form-group">
				<label for="faculty_slug">Licenciatura:</label>
				<select name="degree_slug" id="degree_slug" class="form-control">
					<?php foreach ( $degrees as $degree ) : ?>
						<option 
							value="<?php echo $degree->slug ;?>"
							<?php echo set_select('degree_slug', $degree->slug);?>>
							<?php echo $degree->title ;?>
						</option>
					<?php endforeach ?>
				</select>
			</div>

		</fieldset>
		<input type="submit" class="btn btn-primary" value="Guardar">
	</form>

<?php $this->load->view('admin/layouts/footer'); ?>