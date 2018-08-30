<?php $this->load->view('public/layouts/main');?>

<div class="container">
	<div class="row">
	<?php foreach ( $faculties as $faculty ) : ?>
		<div class="col-sm-12 col-md-4 rpm-faculty">
			<a href="<?php echo site_url('welcome/faculty/'.$faculty->slug);?>"><h2><?php echo $faculty->title;?></h2></a>
			<?php foreach ( $faculty->degrees as $degree ) : ?>
				<a href="<?php echo site_url('welcome/degree/'.$degree->slug);?>"><h3><span class="title"><?php echo $degree->title;?></span></h3></a>
			<?php endforeach ?>
			<hr>
			<p><a href="<?php echo site_url('welcome/faculty/'.$faculty->slug);?>"></a></p>
			<p><a href="<?php echo site_url('welcome/faculty/'.$faculty->slug.'/researchers');?>">Conóce a los investigadores</a></p>
		</div>
	<?php endforeach ?>
	</div>
</div>

<?php $this->load->view('public/layouts/footer');?>