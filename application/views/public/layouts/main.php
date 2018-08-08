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
	<style type="text/css">
		body * {
			font-family: 'Roboto', sans-serif;
			font-weight: 300;
		}
		body pre {
			font-size: 1.1rem;
			margin: 0.5em 0;
		}
		h1, h2, h3, h4, h5, h6 {
			font-weight: 400;
		}
		.rpm-research .header {
			margin: 2em 0;
		}
		.rpm-research .header .thumbnail {
			width: 100%;
			height: 55vh;
			z-index: 0;
			position: relative;
		}
		.rpm-research .header .thumbnail img {
			position: absolute;
			object-fit: contain !important;
			object-position: 50% 25% !important;
			top: 0;
			left: 0;
			width: 100%;
			height: auto;
			z-index: -1;
		}
		.rpm-research .header h1 {
			text-align: center;
		}
		.rpm-research h2 {
			font-size: 1.5rem;
		}
		.rpm-research h3 {
			font-weight: 300;
		}
		
		.rpm-research .degrees .list span a {
			color: #b61b1b;
		}
		.rpm-research .degrees .list span:after {
			content: ',';
			margin: 0 0.25em 0 0;
		}
		.rpm-research .degrees .list span:last-child::after {
			content: '';
		}
		/****/
		.rpm-participants {
			margin: 2em 0;
		}
		.rpm-participant {
			text-align: center;
		}
		.rpm-participant .thumb {
			width: 10vh;
			height: 10vh;
			background: lightgray;
			background-image: url('<?php echo base_url('uploads/logo.svg');?>');
			background-size: cover !important;
			background-repeat: no-repeat !important;
			background-position: center !important;
			border-radius: 100%;
			margin: 1em auto;
		}
		.rpm-participant a {
			text-decoration: none;
		} 
		/***/
		.rpm-research-carousel img {
			width: auto;
			height: 80vh;
			margin: 0 auto;
		}
		.slick-prev.slick-arrow, .slick-next.slick-arrow {
			background-color: #b61b1b;
			border-radius: 100%;
		}
		/**Menu**/		
		.rpm-menu {
			position: fixed;
			top: 0;
			left: 0;
			height: 1em;
			width: 100%;
			z-index: 100;
		}

		.rpm-menu-toggle {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			height: 100vh;
			width: 45vw;
			z-index: 101;
		}

		.rpm-menu-toggle:before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			background-color: white;
			opacity: .95;
			height: 100%;
			width: 100%;
			z-index: 105;
		}
		.rpm-menu-toggle .toggle, .rpm-menu .content {
			position: absolute;
			top: 5em;
			left: 0;
			width: 100%;
			text-align: right;
			padding-right: 2em;
			z-index: 110;
		}
		.rpm-menu-toggle h5 {
			font-weight: 300;
		}
		/*a,*/
		.rpm-menu a,
		.rpm-faculty a {
			text-decoration: none;
			color: #4d4d4d;
		}
		/**a:hover, a:focus, a:active, **/
		.rpm-menu a:hover, .rpm-menu a:focus, .rpm-menu a:active,
		.rpm-faculty a:hover, .rpm-faculty a:focus, .rpm-faculty a:active {
			color: #b61b1b;
		}
		.rpm-menu .toggle {
			top: 0;
			padding-top: 1em;
			padding-right: 1em;
			cursor: pointer;
		}
		.rpm-menu .toggle.rpm-menu-close:before {
			content: '\03a7';
			color: #b61b1b;
		}
		.rpm-menu-logo {
			padding: 1em 2em;
			background: white;
		}
		.rpm-menu-open {
			
		}
		.rpm-menu-open h5 {
			font-weight: 400;
			padding-bottom: 0.5em;
			padding-left: 0.5em;
			border-bottom: 2px solid #b61b1b;
		}
		.rpm-content {
			margin-top: 5em;
		}
		/**/
		.rpm-faculty {
			margin: 1em 0em;
		}
		.rpm-faculty h2 a, 
		.rpm-faculty h3 a {
			width: 100%;
		}
		.rpm-faculty h2 {
			padding-bottom: 0.25em;
			border-bottom: 2px solid #b61b1b;
			font-size: 1.2em;
		}
		.rpm-faculty h3 {
			font-size: 1em;
			border-bottom: 1px dashed black;
		}
		.rpm-faculty h3 span {
			background-color: white;
			padding-bottom: 3px;
		}
		.rpm-faculty h3 span.counter {
			float: right;
		}
		/**/
		.rpm-participant-researches .header,
		.rpm-faculty-researches .header {
			margin: 0 0 2em;
		}
		/***/
		.rpm-researches-list .rpm-research-item h3 {
			font-size: 1.2em;
			font-weight: 400;
		}
		.rpm-researches-list .rpm-research-item h4 {
			font-size: 1em;
			font-weight: lighter;
		}

		.rpm-researches-list .rpm-research-item h4:before,
		.rpm-researches-list .rpm-research-item .abstract:before {
			display: block;
			margin: 0.5em 0;
			color: #b61b1b;
		}

		.rpm-researches-list .rpm-research-item h4:before {
			content: 'Facultad';
		}
		.rpm-researches-list .rpm-research-item img {
			width: 100%;
			height: auto;
		}
		.rpm-researches-list .rpm-research-item p {
			font-size: .9em;
		}
		.rpm-researches-list .rpm-research-item .abstract:before {
			content: 'Síntesis';
		}
		.rpm-researches-list .rpm-research-item .link {
			border-bottom: 1px solid #b61b1b;
		}
		.rpm-pagination .pagination {
			margin: 1em 0;
			justify-content: center;
		}
		.rpm-pagination .pagination li.active span {
			background-color: #b61b1b;
			border-color: #b61b1b;
		}
		/***/
		.rpm-participant-researches .header .rpm-participant h1 {
			font-size: 1.5em;
		}
		.rpm-participant-researches .header .rpm-participant h2 {
			font-size: 1.2em;
		}
		.rpm-participant-researches .header .rpm-participant h3 {
			font-size: 1.1em;
		}
		.rpm-participant-researches .researches-header h3{
			margin: 1em 0;
		}
		/****/
		.rpm-share {
			margin: 4em 0 1em;
		}
		.rpm-share div {
			display: inline-block;
		}
		.rpm-share a {
			text-decoration: none;
		}
		.rpm-share .tw:before, .rpm-share .fb:before {
			content: '';
			display: inline-block;
			width: 2em;
			height: 2em;
			border-radius: 100%;
			padding: 0.25em;
			border: 1px solid #b61b1b;
			background-repeat: no-repeat !important;
			background-size: contain !important;
			background-position: center !important;
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
				<a href="<?php echo site_url('welcome/research') ;?>"><h5>Investigaciones</h5></a>
				<a href="<?php echo site_url('welcome/faculty') ;?>"><h5>Facultades</h5></a>
				<a href="<?php echo site_url('welcome/researcher') ;?>"><h5>Investigadores</h5></a>
				<hr>
				<a href="<?php echo site_url('admin') ;?>"><h5>Acceder</h5></a>
			</div>
		</div>
	</div>
	<div class="rpm-content">
