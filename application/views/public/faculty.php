<?php $this->load->view('public/layouts/main');?>

<div class="container rpm-faculty-researches">
	<div class="row header">
		<div class="col">
			<h1 style="text-align: center;">Investigaciones Facultad</h1>
			<h1 style="text-align: center;"><?php echo $faculty->title;?></h1>
		</div>
	</div>
	<?php $this->load->view('public/list-researches');?>
</div>

<?php $this->load->view('public/layouts/footer');?>