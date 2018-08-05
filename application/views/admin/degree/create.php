<?php $this->load->view('admin/layouts/main'); ?>
	<form method="post" action="<?php echo site_url('degree/store');?>">
		<fieldset>
			<legend>Nueva Licenciatura</legend>
			<div class="form-group">
				<label for="title">Licenciatura:</label>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title');?>">
			</div>
			<div class="form-group">
				<label for="faculty_slug">Facultad:</label>
				<select name="faculty_slug" id="faculty_slug" class="form-control">
					<?php foreach ( $faculties as $faculty ) : ?>
						<option 
						value="<?php echo $faculty->slug ;?>"
						<?php echo set_select('faculty_slug', $faculty->slug);?>>
							<?php echo $faculty->title ;?>
						</option>
					<?php endforeach ?>
				</select>
			</div>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Guardar">
	</form>
<?php $this->load->view('admin/layouts/footer'); ?>