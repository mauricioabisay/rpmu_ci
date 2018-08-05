<?php $this->load->view('admin/layouts/main'); ?>
	<a href="<?php echo site_url('degree/create') ;?>" class="btn btn-info rpm-create-new">Nueva Licenciatura</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Licenciatura</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $degrees as $degree ) : ?>
				<tr>
					<td><?php echo $degree->title ;?></td>
					<td class="rpm-row-options">
						<form action="<?php echo site_url('degree/destroy') ;?>" method="post">
							<input type="hidden" name="slug" value="<?php echo $degree->slug;?>">
							<button class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
						</form>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
<?php $this->load->view('admin/layouts/footer'); ?>