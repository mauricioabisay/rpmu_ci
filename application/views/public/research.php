<?php $this->load->view('public/layouts/main');?>

<div class="rpm-research">
	<div class="header">
		<h1><?php echo $research->title ;?></h1>
		<?php if ( file_exists('./uploads/researches/'.$research->id.'/image.jpg') ) : ?>
		<div class="thumbnail jarallax" data-jarallax data-speed="0.2">
			<img class="jarallax-img" src="<?php echo base_url('uploads/researches/'.$research->id.'/image.jpg');?>">
		</div>
		<?php endif ?>
	</div>
<div class="container">
	
	<div class="row faculty">
		<div class="col">
			<h2>Facultad:</h2>
			<h3><?php echo $research->faculty->title;?></h3>
		</div>
	</div>

	<div class="row degrees">
		<div class="col">
			<h2>Carreas:</h2>
			<p class="list">
			<?php foreach( $research->degrees as $degree ) : ?>
				<span><a href="<?php echo site_url('welcome/degree/'.$degree->slug);?>"><?php echo $degree->title ;?></a></span>
			<?php endforeach ?>
			</p>
		</div>
	</div>

	<div class="row subjects">
		<div class="col">
			<h2>Temas:</h2>
			<h3>
				<?php foreach ( $research->subjects as $s ) : ?>
					<span><?php echo $s->title ;?></span>
				<?php endforeach ?>
			</h3>
		</div>
	</div>

	<div class="row abstract">
		<div class="col">
			<h2>Síntesis:</h2>
			<p><?php echo $research->abstract ;?></p>
		</div>
	</div>
	
	<div class="rpm-leader rpm-participants">
		<div class="row">
			<div class="col">
				<h4>Director</h4>
			</div>
		</div>
		<div class="row">
		
			<div class="col-4 rpm-participant">
				<a href="<?php echo site_url('welcome/researcher/'.$research->leader->participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$research->leader->participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$research->leader->participant->id.'.jpg)') : '';?>"></div></a>
				<h5><a href="<?php echo site_url('welcome/researcher/'.$research->leader->participant->slug);?>"><?php echo $research->leader->participant->name ;?></a></h5>
				<h6><?php echo $research->faculty->title ;?></h6>
			</div>
		</div>
	</div>
	
	<?php if ( count($research->researchers) > 0 ) : ?>
	<div class="rpm-researchers rpm-participants">
		<div class="row">
			<div class="col">
				<h4>Investigadores</h4>
			</div>
		</div>
		<div class="row"> 
		<?php foreach ( $research->researchers as $participant ) : ?>
			<div class="col-4 rpm-participant">
				<a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$participant->id.'.jpg)') : '';?>"></div></a>
				<h5><a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><?php echo $participant->name ;?></a></h5>
				<h6><?php echo $participant->school->title ;?></h6>
			</div>
		<?php endforeach ?>
		</div>
	</div>
	<?php endif ?>
	
	<?php if ( count($research->students) > 0 ) : ?>
	<div class="rpm-participants rpm-students">
		<div class="row">
			<div class="col">
				<h4>Estudiantes</h4>
			</div>
		</div>
		<div class="row"> 
		<?php foreach ( $research->students as $participant ) : ?>
			<div class="col-4 rpm-participant">
				<a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$participant->id.'.jpg)') : '';?>"></div></a>
				<h5><a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><?php echo $participant->name ;?></a></h5>
				<h6><?php echo $participant->school->title ;?></h6>
			</div>
		<?php endforeach ?>
		</div>
	</div>
	<?php endif ?>
	
	<?php if ( $research->description ) : ?>
	<div class="row">
		<div class="col">
			<h2>Contenido</h2>
			<p><?php echo $research->description ;?></p>
		</div>
	</div>
	<?php endif ?>
	
	<div class="rpm-research-carousel">
		<?php $items = directory_map('./uploads/researches/'.$research->id.'/gallery/', 1);?>
		<?php if(is_array($items)) : ?>
		<?php foreach ($items as $item) : ?>
			<div>
				<img src="<?php echo base_url().'/uploads/researches/'.$research->id.'/gallery/'.$item;?>">
			</div>
		<?php endforeach ?>
		<?php endif ?>
	</div>

	<div class="rpm-share row">
		<div class="col">
			<div><a target="_blank" href="https://twitter.com/share?url=<?php echo current_url();?>&hashtags=<?php echo $meta->keywords;?>"><span class="tw">&nbsp;</span></a></div>
			<div><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url();?>"><span class="fb">&nbsp;</span></a></div>
		</div>
	</div>

	<?php if ( count($research->citations) > 0 ) : ?>
	<div class="row">
		<div class="col">
			<h2>Publicaciones</h2>
			<ul>
				<?php foreach ( $research->citations as $citation ) : ?>
					<li><?php echo $citation->description ;?> <a target="_blank" href="<?php echo (strpos($citation->link, 'http') === FALSE) ? base_url().$citation->link : $citation->link ;?>"><?php echo $citation->link ;?></a></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<?php endif ?>
	
	<?php if ( $research->extra_info ) : ?>
	<div class="row">
		<div class="col">
			<h2>Comentarios</h2>
			<p><?php echo $research->extra_info ;?></p>
		</div>
	</div>
	<?php endif ?>
</div>
</div>
<script src="https://unpkg.com/jarallax@1.10/dist/jarallax.min.js"></script>
<script type="text/javascript">
	window.onload = function() {
		jQuery('.rpm-research-carousel').slick({dots: true});
	};
</script>

<?php $this->load->view('public/layouts/footer');?>