<?php $this->load->view('public/layouts/main');?>

<div class="container rpm-participant-researches">
	<div class="row header">
		<div class="col rpm-participant">
			<div class="thumb"></div>
			<h1><?php echo $researcher->name;?></h1>
			<?php if ( $researcher->degree ) : ?>
				<h3><?php echo $researcher->degree->title;?></h3>
			<?php endif ?>
				<h2><?php echo $researcher->faculty->title;?></h2>
		</div>
	</div>
	<div class="row desc">
		<p><?php echo $researcher->bio;?></p>
		<p>Link: <a href="<?php echo $researcher->link;?>"><?php echo $researcher->link;?></a></p>
	</div>
	<div class="row researches-header">
		<h3>Proyectos</h3>
	</div>
	<?php $this->load->view('public/list-researches');?>
</div>

<?php $this->load->view('public/layouts/footer');?>