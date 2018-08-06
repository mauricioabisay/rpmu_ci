<?php $this->load->view('admin/layouts/main'); ?>

	<a href="<?php echo site_url('subject/create');?>" class="btn btn-info rpm-create-new">Nuevo Tema</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Tema</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $subjects as $subject ) : ?>
				<tr>
					<td><?php echo $subject->title;?></td>
					<td class="rpm-row-options">
						<form action="<?php echo site_url('subject/destroy');?>" method="post">
							<input type="hidden" name="slug" value="<?php echo $subject->slug;?>">
							<button class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
						</form>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<div class="rpm-pagination">
		<?php echo $this->pagination->create_links();?>
	</div>

<?php $this->load->view('admin/layouts/footer'); ?>