<?php $this->load->view('public/layouts/main');?>

<div class="container">
	<div class="row">
	<?php foreach ( $researchers as $researcher ) : ?>
		<div class="col-4 rpm-participant">
			<a href="<?php echo site_url('welcome/researcher/'.$researcher->participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$researcher->participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$researcher->participant->id.'.jpg)') : '';?>"></div></a>
			<a href="<?php echo site_url('welcome/researcher/'.$researcher->participant->slug);?>"><h5><?php echo $researcher->participant->name;?></h5></a>
		</div>
	<?php endforeach ?>
	</div>
</div>

<?php $this->load->view('public/layouts/footer');?>