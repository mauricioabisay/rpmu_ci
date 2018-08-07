<?php $this->load->view('public/layouts/main');?>

<div class="container">
	<div class="row">
	<?php foreach ( $participants as $participant ) : ?>
		<div class="col-4 rpm-participant">
			<a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><div class="thumb" style="<?php echo ( file_exists('./uploads/participants/'.$participant->id.'.jpg') ) ? 'background-image: url('.base_url('uploads/participants/'.$participant->id.'.jpg)') : '';?>"></div></a>
			<a href="<?php echo site_url('welcome/researcher/'.$participant->slug);?>"><h5><?php echo $participant->name;?></h5></a>
			<?php if ($participant->degree) : ?>
				<h6><?php echo $participant->degree->title;?></h6>
			<?php endif ?>
			<?php if ($participant->faculty) : ?>
				<h6><?php echo $participant->faculty->title;?></h6>
			<?php endif ?>
		</div>
	<?php endforeach ?>
	</div>
</div>

<?php $this->load->view('public/layouts/footer');?>