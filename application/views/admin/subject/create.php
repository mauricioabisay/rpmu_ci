<?php $this->load->view('admin/layouts/main'); ?>

	<form method="post" action="<?php echo site_url('subject/store') ;?>">
		<fieldset>
			<legend>Nuevo Tema</legend>
			<p><small>Los campos con <span style="color: red">*</span> son obligatorios.</small></p>
			<div class="form-group">
				<label class="required" for="title">Tema:</label>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo set_value('title');?>">
			</div>
		</fieldset>
		<input type="submit" class="btn btn-primary" value="Guardar">
	</form>
	
<?php $this->load->view('admin/layouts/footer'); ?>