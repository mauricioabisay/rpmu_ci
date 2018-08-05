<?php $this->load->view('admin/layouts/main'); ?>

	<form method="post" action="<?php echo site_url('subject/store') ;?>">
		<fieldset>
			<legend>Nuevo Tema</legend>
			<div class="form-group">
				<label for="title">Tema:</label>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title');?>">
			</div>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Guardar">
	</form>
	
<?php $this->load->view('admin/layouts/footer'); ?>