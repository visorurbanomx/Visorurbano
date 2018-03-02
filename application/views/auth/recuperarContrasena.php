<div class="auth">
    <div class="logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Visor Urbano" width="200"></a>
    </div>
    <div class="messages"></div>
    <small>Se enviara un correo a la cuenta especificada con las instrucciones para recuperar la contraseña.</small>

    <form id="frmRecuperarContrasena">
        <div class="form-group">
            <input id="txtEmail" type="email" name="email" required="" class="input-material" required>
            <label for="txtEmail" class="label-material">Correo Electrónico</label>
        </div>
        <button id="btnRecuperarContrasena" class="btn btn-success" type="button">Enviar Correo</button>
        <a href="<?=base_url()?>ingresar" class="btn btn-danger">Regresar</a>
    </form>
</div>