<?php $this->load->view('public/layouts/main');?>

<div class="container">
	<div class="row">
	<?php foreach ( $faculties as $faculty ) : ?>
		<div class="col-sm-12 col-md-4 rpm-faculty">
			<a href="<?php echo site_url('welcome/faculty/'.$faculty->slug);?>"><h2><?php echo $faculty->title;?></h2></a>
			<?php foreach ( $faculty->degrees as $degree ) : ?>
				<a href="<?php echo site_url('welcome/degree/'.$degree->slug);?>"><h3><span class="title"><?php echo $degree->title;?></span><span class="counter">(<?php echo $degree->researches_count;?>)</span></h3></a>
			<?php endforeach ?>
		</div>
	<?php endforeach ?>
	</div>
</div>

<?php $this->load->view('public/layouts/footer');?>