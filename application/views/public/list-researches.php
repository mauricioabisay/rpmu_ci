<div class="row rpm-researches-list">
<?php foreach ( $researches as $r ) : ?>
	<div class="col-sm-12 col-md-4 rpm-research-item">
		<h3><?php echo $r->title ;?></h3>
		<h4><?php echo $r->faculty->title;?></h4>
		<?php if ( file_exists('./uploads/researches/'.$r->id.'/image.jpg') ) : ?>
			<a href="<?php echo site_url('welcome/research/'.$r->id);?>">
				<img src="<?php echo base_url('uploads/researches/'.$r->id.'/image.jpg');?>">
			</a>
		<?php endif ?>
		<p class="abstract"><?php echo $r->abstract ;?></p>
		<p class="link"><a href="<?php echo site_url('welcome/research/'.$r->slug);?>">Ver más</a></p>
	</div>
<?php endforeach ?>
</div>