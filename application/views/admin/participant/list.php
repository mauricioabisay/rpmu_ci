<?php $this->load->view('admin/layouts/main'); ?>

	<a href="<?php echo site_url('participant/create') ;?>" class="btn btn-info rpm-create-new">Nuevo Participante</a>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Licenciatura</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $participants as $participant ) : ?>
				<tr>
					<td><?php echo $participant->name ;?></td>
					<td><?php echo ($participant->user_id > 0) ? strtoupper($participant->user->role) : $participant->degree->title ;?></td>
					<td class="rpm-row-options">
						<?php if ( $participant->user_id > 0 ) : ?>
							<a class="btn btn-info" href="<?php echo site_url( 'user/edit/'.$participant->user->id ) ;?>"><span class="octicon octicon-pencil"></span></a>
							<form action="<?php echo site_url('user/destroy/') ;?>" method="post">
								<input type="hidden" name="id" value="<?php echo $participant->user->id;?>">
								<button class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
							</form>
						<?php else : ?>
							<a class="btn btn-info" href="<?php echo site_url('participant/edit/'.$participant->id);?>"><span class="octicon octicon-pencil"></span></a>
							<form action="<?php echo site_url('participant/destroy') ;?>" method="post">
								<input type="hidden" name="id" value="<?php echo $participant->id;?>">
								<button class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
							</form>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php $this->load->view('admin/layouts/footer'); ?>