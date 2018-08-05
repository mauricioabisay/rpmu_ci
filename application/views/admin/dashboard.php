<?php $this->load->view('admin/layouts/main');?>

<div class="row">
	<div class="col">
		<p>Bienvenido <?php //echo ($this->session->user) ? $this->session->user->name : '' ?></p>
		<?php print_r($this->session->user);?>
		<hr>
	</div>
</div>

<?php $this->load->view('admin/layouts/footer');?>