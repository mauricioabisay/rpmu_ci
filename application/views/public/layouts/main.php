<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<?php if(isset($meta)) : ?>
		<title>Investigaciones UPAEP - <?php echo $meta->title;?></title>
		<meta name="description" content="<?php echo $meta->description;?>"/>
		<meta name="keywords" content="<?php echo $meta->keywords;?>">
		<meta property="og:url" content="<?php echo current_url();?>">
		<meta property="og:image" content="<?php echo $meta->image;?>">
		<meta property="og:image:width" content="<?php echo $meta->image_width;?>" />
		<meta property="og:image:height" content="<?php echo $meta->image_height;?>" />
		<meta property="og:title" content="<?php echo $meta->title;?>">
		<meta property="og:description" content="<?php echo $meta->description;?>">

		<meta name="twitter:card" content="summary">
	<?php else : ?>
		<title>Investigaciones UPAEP</title>
		<meta name="description" content="Catálogo de investigaciones y proyectos técnicos realizados por profesores y alumnos de la Universidad Popular Autónoma del Estado de Puebla"/>
		<meta name="keywords" content="universidad, popular, autónoma, puebla, investigación, licenciatura, méxico, talento, mexicano, poblano">
		<meta property="og:url" content="<?php echo site_url();?>">
		<meta property="og:image" content="<?php echo base_url('uploads/image.png');?>">
		<meta property="og:image:width" content="600" />
		<meta property="og:image:height" content="600" />
		<meta property="og:title" content="Investigaciones UPAEP">
		<meta property="og:description" content="Catálogo de investigaciones y proyectos técnicos realizados por profesores y alumnos de la Universidad Popular Autónoma del Estado de Puebla">

		<meta name="twitter:card" content="summary">
	<?php endif ?>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('resources/public.css');?>">
	<style type="text/css">
		.rpm-participant .thumb {
			background-image: url('<?php echo base_url('uploads/logo.svg');?>');
		}
		.rpm-share .tw:before {
			background-image: url(<?php echo base_url('uploads/tw.svg');?>);
		}
		.rpm-share .fb:before {
			background-image: url(<?php echo base_url('uploads/fb.svg');?>);
		}
	</style>
</head>
<body>
	<div class="rpm-menu">
		<div class="rpm-menu-logo">
			<a class="rpm-menu-open" href="javascript:void(0)"><h5>MENÚ</h5></a>
		</div>
		<div class="rpm-menu-toggle">
			<div class="toggle rpm-menu-close"></div>
			<div class="content">
				<a href="<?php echo site_url('welcome') ;?>"><h5>Inicio</h5></a>
				<a href="<?php echo site_url('welcome/faculty') ;?>"><h5>Facultades</h5></a>
				<a href="<?php echo site_url('welcome/researcher') ;?>"><h5>Investigadores</h5></a>
				<hr>
				<a href="<?php echo site_url('admin') ;?>"><h5>Acceder</h5></a>
			</div>
		</div>
	</div>
	<div class="rpm-content">
