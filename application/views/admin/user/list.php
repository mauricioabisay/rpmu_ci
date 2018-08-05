<?php $this->load->view('admin/layouts/main');?>

	<?php if ( $this->session->user->role === 'admin' || $this->session->user->role === 'director' ) : ?>
		<a href="<?php echo site_url('user/create') ;?>" class="btn btn-info rpm-create-new">Nuevo Usuario</a>
	<?php endif ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Email</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $users as $user ) : ?>
				<tr>
					<td><?php echo ($user->participant) ? $user->participant->name : '' ;?></td>
					<td><?php echo $user->email ;?></td>
					<td class="rpm-row-options">
						<?php if ( $this->session->user->role === 'admin' || $this->session->user->role === 'director' || $this->session->user->id === $user->id ) : ?>
							<a class="btn btn-info" href="<?php echo site_url('user/edit/'.$user->id) ;?>"><span class="octicon octicon-pencil"></span></a>
						<?php endif ?>
						<?php if ( $this->session->user->role === 'admin' || $this->session->user->role === 'director' ) : ?>
							<form action="<?php echo site_url('user/destroy');?>" method="post">
								<input type="hidden" name="id" value="<?php echo $user->id;?>">
								<button class="btn btn-danger"><span class="octicon octicon-trashcan"></span></button>
							</form>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php $this->load->view('admin/layouts/footer');?>