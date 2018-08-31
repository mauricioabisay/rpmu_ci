<?php $this->load->view('admin/layouts/main');?>

<form method="POST" action="<?php echo site_url('user/update');?>" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
    <input type="hidden" name="participant_id" value="<?php echo $user->participant->id;?>">
    <fieldset>
        <legend>Datos de acceso</legend>
        <p><small>Los campos con <span style="color: red">*</span> son obligatorios.</small></p>
        <div class="form-group">
            <label for="name" class="required">Nombre:</label>
            <input 
                id="name" name="name" 
                value="<?php echo set_value('name', $user->participant->name);?>"
                type="text" class="form-control" placeholder="Nombre completo" required autofocus>
        </div>

        <div class="form-group">
            <label for="email" class="required">Email:</label>
            <input 
                id="email" name="email" 
                value="<?php echo set_value('email', $user->email);?>" 
                type="email" class="form-control" placeholder="nombre@email.com" required>
        </div>

        <div class="form-group">
            <label for="role" class="required">Rol:</label>
            <select name="role" id="role" class="role form-control">
                <option value="admin" <?php echo set_select('role', 'admin', ($user->role=='admin'));?>>Administrador</option>
                <option value="director" <?php echo set_select('role', 'director', ($user->role=='director'));?>>Director</option>
                <option value="professor" <?php echo set_select('role', 'professor', ($user->role=='professor'));?>>Profesor</option>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos de departamento</legend>
        
        <div class="form-group">
            <label for="id" class="required">ID/Matricula:</label>
            <input 
                id="id" name="id" 
                value="<?php echo set_value('id', $user->participant->id);?>" 
                type="text" class="form-control">
        </div>

        <div class="form-group">
            <label for="faculty_slug" class="required">Facultad:</label>
            <select name="faculty_slug" id="faculty_slug" class="form-control">
                <?php foreach ( $faculties as $faculty ) : ?>
                    <option 
                        value="<?php echo $faculty->slug ;?>" 
                        <?php echo set_select('faculty_slug', $faculty->slug, ($faculty->slug == $user->faculty_slug) );?>><?php echo $faculty->title ;?></option>
                <?php endforeach ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="profile_photo">Foto de perfil:</label>
            <input type="file" class="form-control-file single-file" id="profile_photo" name="profile_photo" aria-describedby="profile-photo-help">
            <div class="thumb" style="background-image:url('<?php echo base_url('uploads/participants/'.$user->participant->id.'.jpg') ;?>');"></div>
            <small id="profile-photo-help" class="form-text text-muted">Inserta una imagen de perfil, esta se mostrará cuando seas mencionado en la plataforma.</small>
        </div>

        <div class="form-group">
            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php echo set_value('bio', $user->participant->bio);?></textarea>
        </div>
        
        <div class="form-group">
            <label for="link">Link:</label>
            <input type="text" class="form-control" 
                id="link" name="link" 
                value="<?php echo set_value('link', $user->participant->link);?>">
        </div>
    </fieldset>
    
    <input class="btn btn-primary" type="submit" value="Guardar">
</form>

<?php $this->load->view('admin/layouts/footer');?>
