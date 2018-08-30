<?php $this->load->view('public/layouts/main');?>

<div class="container">
	<?php foreach ( $faculties as $f ) : ?>
		<?php if ( count($f->researchers) > 0 ) : ?>
		<div class="row rpm-faculty-researchers">
			<div class="col-12 faculty-title">
				<a href="<?php echo site_url('welcome/faculty/'.$f->slug.'/researchers');?>"><h2><?php echo $f->title;?></h2></a>
			</div>
			<div class="col-12">
				<p>Algunos investigadores de la facultad</p>
			</div>
		<?php foreach ($f->researchers as $researcher) : ?>
			<div class="col-4 rpm-participant">
				<a href="<?php echo site_url('welcome/researcher/'.$researcher->participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$researcher->participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$researcher->participant->id.'.jpg)') : '';?>"></div></a>
				<a href="<?php echo site_url('welcome/researcher/'.$researcher->participant->slug);?>"><h3><span><?php echo $researcher->participant->name;?></span></h3></a>
			</div>
		<?php endforeach ?>
			<div class="col-12"><a href="<?php echo site_url('welcome/faculty/'.$f->slug.'/researchers');?>">Ver todos los investigadores de la facultad</a></div>
		</div>
		<?php endif ?>
	<?php endforeach ?>
</div>

<?php $this->load->view('public/layouts/footer');?>