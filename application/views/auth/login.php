<div class="auth">
    <div class="logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Visor Urbano" width="200"></a>
    </div>
    <form id="frmLogin" class="mui-form">
        <input type="hidden" id="txtRedirect" value="<?=$redirect?>">
        <div class="mui-textfield mui-textfield--float-label">
            <input id="txtEmail" type="email" name="email" required="" class="input-material" required tabindex="1">
            <label for="txtEmail">Correo Electrónico</label>
        </div>
        <div class="mui-textfield mui-textfield--float-label">
            <input id="txtPassword" type="password" name="password" required="" class="input-material" required tabindex="2">
            <label for="txtPassword">Contraseña</label>
        </div>
        <br>
        <button id="btnLogin" class="mui-btn mui-btn--primary" type="button">Ingresar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=base_url()?>recuperar-contrasena">¿Olvidaste tu contraseña?</a>
    </form>
    ¿No tienes cuenta? crea una <a href="<?php echo base_url(); ?>registro">aquí</a>
</div>
