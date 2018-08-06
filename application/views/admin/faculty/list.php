<?php $this->load->view('admin/layouts/main'); ?>
	<a href="<?php echo  site_url('faculty/create') ;?>" class="btn btn-info rpm-create-new">Nueva Facultad</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Facultad</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $faculties as $faculty ) : ?>
				<tr>
					<td><?php echo  $faculty->title ;?></td>
					<td class="rpm-row-options">
						<form action="<?php echo  site_url('faculty/destroy/');?>" method="post">
							<input type="hidden" name="slug" value="<?php echo $faculty->slug;?>">
							<button type="submit" class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="rpm-pagination">
		<?php echo $this->pagination->create_links();?>
	</div>
<?php $this->load->view('admin/layouts/footer'); ?>