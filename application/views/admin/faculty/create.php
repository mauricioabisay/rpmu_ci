<?php $this->load->view('admin/layouts/main'); ?>

	<form method="post" action="<?php echo site_url('faculty/store') ;?>">
		<fieldset>
			<legend>Nueva Facultad</legend>
			<div class="form-group">
				<label for="title">Facultad:</label>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title');?>">
			</div>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Guardar">
	</form>

<?php $this->load->view('admin/layouts/footer'); ?>