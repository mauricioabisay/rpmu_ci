<?php $this->load->view('admin/layouts/main');?>

	<div class="row">
		<div class="col login-form">
			<p>Para acceder a esta sección necesitas ser registrado por el administrador con tu cuenta de correo institucional o una cuenta Gmail personal.</p>
			<p>Da clic para continuar.</p>
			<div id="g-custom-btn" class="btn g-btn">Sign in with Gmail</div>
			<form id="login" action="<?php echo site_url('admin/login') ;?>" method="post">
				<input type="hidden" name="token" id="token">
			</form>
		</div>
	</div>

<?php $this->load->view('admin/layouts/footer');?>