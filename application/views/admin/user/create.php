<?php $this->load->view('admin/layouts/main');?>

<form method="POST" action="<?php echo site_url('user/store');?>" enctype="multipart/form-data">
    <fieldset>
        <legend>Datos de acceso</legend>
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input id="name" name="name" type="text" class="form-control" placeholder="Nombre completo" required autofocus value="<?php echo set_value('name');?>">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input id="email" name="email" type="email" class="form-control" placeholder="nombre@email.com" required value="<?php echo set_value('email');?>">
        </div>

        <div class="form-group">
            <label for="role">Rol:</label>
            <select name="role" id="role" class="role form-control">
                <option value="admin" <?php echo set_select('role', 'admin');?>>Administrador</option>
                <option value="director" <?php echo set_select('role', 'director');?>>Director</option>
                <option value="professor" <?php echo set_select('role', 'professor');?>>Profesor</option>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos de departamento</legend>
        
        <div class="form-group">
            <label for="id">ID/Matricula:</label>
            <input type="text" class="form-control" id="id" name="id" value="<?php echo set_value('id');?>">
        </div>

        <div class="form-group">
            <label for="profile_photo">Foto de perfil:</label>
            <input type="file" class="form-control-file single-file" id="profile_photo" name="profile_photo" aria-describedby="profile-photo-help">
            <div class="thumb"></div>
            <small id="profile-photo-help" class="form-text text-muted">Inserta una imagen de perfil, esta se mostrará cuando seas mencionado en la plataforma.</small>
        </div>
        
        <div class="form-group">
            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio" cols="30" rows="10" class="form-control"><?php echo set_value('bio');?></textarea>
        </div>
        
        <div class="form-group">
            <label for="link">Link:</label>
            <input type="text" class="form-control" id="link" name="link" value="<?php echo set_value('link');?>">
        </div>

        <div class="form-group">
            <label for="faculty_slug">Facultad:</label>
            <select name="faculty_slug" id="faculty_slug" class="form-control">
                <?php foreach ( $faculties as $faculty ) : ?>
                    <option 
                        value="<?php echo $faculty->slug ;?>"
                        <?php echo set_select('faculty_slug', $faculty->slug);?>>
                        <?php echo $faculty->title ;?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </fieldset>
    
    <input class="btn btn-primary" type="submit" value="Guardar">
</form>

<?php $this->load->view('admin/layouts/footer');?>
