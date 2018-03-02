<div class="content-inner">
    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Perfil de usuario</h2>
        </div>
    </header>
    <!-- Projects Section-->
    <section class="projects">
        <div class="container-fluid">
            <form id="frmPerfilUsuario" class="frmAdmin">
               <div class="row">
                   <div class="col-md-4 col-sm-12">
                       <div class="mui-textfield mui-textfield--float-label">
                           <input id="txtNombre" type="text" name="nombre"  class="input-material" value="<?= $this->session->userdata('nombre') ?>" required>
                           <label for="txtNombre">*Nombre(s)</label>
                       </div>
                   </div>
                   <div class="col-md-4 col-sm-12">
                       <div class="mui-textfield mui-textfield--float-label">
                           <input id="txtApepat" type="text" name="ape_pat"  class="input-material" value="<?= $this->session->userdata('primer_apellido') ?>" required>
                           <label for="txtApepat">*Primer Apellido</label>
                       </div>
                   </div>
                   <div class="col-md-4 col-sm-12">
                       <div class="mui-textfield mui-textfield--float-label">
                           <input id="txtApemat" type="text" name="ape_mat"  class="input-material" value="<?= $this->session->userdata('segundo_apellido') ?>" required>
                           <label for="txtApemat" class="label-material active">*Segundo Apellido</label>
                       </div>
                   </div>
               </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mui-textfield mui-textfield--float-label">
                            <input id="txtEmail" type="text" name="email" disabled  class="input-material" value="<?= $this->session->userdata('email') ?>" required>
                            <label for="txtEmail" class="label-material active">*Correo Electrónico</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mui-textfield mui-textfield--float-label">
                            <input id="txtCelular" type="text" name="celular" class="input-material" value="<?= $this->session->userdata('celular') ?>" required>
                            <label for="txtCelular" class="label-material active">*Número Celular</label>
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12 messagePerfil"></div>
                    <br>
                    <button type="button" id="btnActualizarPerfil" class="mui-btn mui-btn--primary">Actualizar mis datos</button>
                    &nbsp
                    <a href="<?=base_url()?>admin" class="mui-btn mui-btn--danger">Cancelar</a>
                </div>
            </form>
            <hr>
            <h2>Cambiar contraseña</h2>
            <br>
            <form id="frmContrasena" class="frmAdmin mui-form">
                <input type="hidden" id="txtEmailPass" value="<?= $this->session->userdata('email') ?>">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="mui-textfield mui-textfield--float-label">
                            <input id="txtPassActual" type="password" name="passActual" class="input-material" required>
                            <label for="txtPassActual">*Contraseña actual</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mui-textfield mui-textfield--float-label">
                            <input id="txtNuevoPass" type="password" name="nuevoPass" class="input-material" required>
                            <label for="txtNuevoPass" class="label-material">*Nueva contraseña</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="mui-textfield mui-textfield--float-label">
                            <input id="txtConfirmarNuevoPass" type="password" name="confirmaNuevoPass" class="input-material" required>
                            <label for="txtConfirmarNuevoPass" class="label-material">*Confirmar nueva contraseña</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 message"></div>
                </div>
                <br><br>
                <div class="row">
                    <button type="button" id="btnCambiarPass" class="mui-btn mui-btn--primary">Cambiar Contraseña</button>
                    &nbsp
                    <a href="<?=base_url()?>admin" class="mui-btn mui-btn--danger">Cancelar</a>
                </div>
            </form>
        </div>
    </section>
</div>
</div>
</div>