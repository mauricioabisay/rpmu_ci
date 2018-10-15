<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/startbootstrap/css/sb-admin.min.css');?>">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/octicons/4.4.0/font/octicons.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="google-signin-client_id" content="<?php echo $this->config->item('google_oauth');?>">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('resources/admin.css');?>">
	<style type="text/css">
		.thumb {
			background-image: url(<?php echo base_url('uploads/logo.svg');?>);
		}
	</style>
</head>

<body class="fixed-nav bg-light">	
	<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		<?php if ( isset($this->session->user) ) : ?>
			<a class="navbar-brand" href="<?php echo site_url('admin') ?>">R.P.M.</a>
		<?php else : ?>
			<a class="navbar-brand" href="<?php echo site_url('welcome');?>">R.P.M.</a>
		<?php endif; ?>
		
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span></button>

	    <div class="collapse navbar-collapse" id="navbar-content">
	    <ul class="navbar-nav mr-auto">
	    	<li class="nav-item">
	    		<a class="nav-link" href="<?php echo site_url('research'); ?>">Investigaciones</a>
	    	</li>
	    	<li class="nav-item">
	    		<a class="nav-link" href="<?php echo site_url('participant'); ?>">Participantes</a>
	    	</li>
	    	<?php if ( isset($this->session->user) ) : ?>
	    		<li class="nav-item dropdown">
	    			<a class="nav-link dropdown-toggle" href="#" id="utilities-menu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Utilidades</a>

	    			<div class="dropdown-menu" aria-labelledby="utilities-menu">
	    				<a class="dropdown-item" href="<?php echo site_url('subject'); ?>">Temas</a>
	    				<a class="dropdown-item" href="<?php echo site_url('degree'); ?>">Licenciaturas</a>
	    				<a class="dropdown-item" href="<?php echo site_url('faculty'); ?>">Facultades</a>
	    			</div>
	    		</li>
	    		<li class="nav-item">
	    			<a class="nav-link" href="<?php echo site_url('user'); ?>">Usuarios</a>
	    		</li>

				<li class="nav-item">
					<a id="g-logout-btn" class="nav-link" href="#">Salir</a>
					<form id="logout" action="<?php echo site_url('admin/logout') ?>" method="post"></form>
				</li>
			<?php else : ?>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo site_url('admin') ?>">Admin</a>
				</li>
			<?php endif; ?>
		</div>
	</nav>
	<div class="container" style="margin-top:60px">
		<?if ( 
			( $this->session->flashdata('msg.type') !== null ) 
			&& ( $this->session->flashdata('msg.text') !== null ) 
		) : ?>
			<div class="alert <?php echo $this->session()->flashdata('msg.type') ?>">
				<?php echo $this->session()->flashdata('msg.text') ?>
			</div>
		<?php endif; ?>
		<?php if ( validation_errors() ) : ?>
			<div class="alert alert-danger">
				<?php echo validation_errors();?>
			</div>
		<?php endif; ?>