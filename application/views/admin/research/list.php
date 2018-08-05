<?php $this->load->view('admin/layouts/main');?>

	<a href="<?php echo site_url('research/create');?>" class="btn btn-info rpm-create-new">Nueva Investigación</a>
	<table class="table table-striped rpm-research-table">
		<thead>
			<tr>
				<th>Título</th>
				<th>Líder</th>
				<th>Estado</th>
				<th class="rpm-row-options">Opc.</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ( $researches as $research ) : ?>
				<tr>
					<td><?php echo $research->title ;?></td>
					<td><?php echo $research->leader->participant->name ;?> (<?php echo $research->leader->email ;?>)</td>
					<td><?php echo $research->status ;?></td>
					<td class="rpm-row-options">
						<?php
							if (
								($this->session->user->role == 'admin')
								|| (
									($this->session->user->role == 'director')
									&& ($research->leader->faculty_slug == $this->session->user->faculty_slug)
								)
								|| ($research->leader->id == $this->session->user->id)
							) :
						?>
							<a class="btn btn-info" href="<?php echo site_url('research/edit/'.$research->id);?>">
								<span class="octicon octicon-pencil"></span>
							</a>
						<?php endif ?>
						<?php
							if (
								($this->session->user->role == 'admin')
								|| (
									($this->session->user->role == 'director')
									&& ($research->leader->faculty_slug == $this->session->user->faculty_slug)
								)
								|| ($research->leader->id == $this->session->user->id)
							) :
						?>
							<form action="<?php echo site_url('research/destroy');?>" method="post">
								<input type="hidden" name="id" value="<?php echo $research->id?>">
								<button class="btn btn-danger">
									<span class="octicon octicon-trashcan"></span>
								</button>
							</form>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

<?php $this->load->view('admin/layouts/footer');?>