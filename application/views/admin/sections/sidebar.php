<div class="page-content d-flex align-items-stretch">
    <!-- Side Navbar -->
    <nav class="side-navbar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            <?php if ($this->session->userdata('level') == 2): ?>
                <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/ventanilla.png" alt="..." class="img-fluid rounded-circle"></div>
            <?php elseif($this->session->userdata('level') == 1): ?>
                <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/default.png" alt="..." class="img-fluid rounded-circle"></div>
            <?php else: ?>
                <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/default.png" alt="..." class="img-fluid rounded-circle"></div>
            <?php endif; ?>

            <div class="title">
                <h1 class="h4" id="contUserName"><?php echo $this->session->userdata('nombre');?></h1>
                <small><a href="<?=base_url();?>admin/usuario"><i class="fa fa-pencil" aria-hidden="true"></i>Editar mi perfil</a></small>
            </div>
        </div>
        <!-- Sidebar Navidation Menus-->
        <ul class="list-unstyled">
            <?php if ($this->session->userdata('level') != 3): ?>
                <li> <a href="<?=base_url()?>admin"><i class="fa fa-list" aria-hidden="true"></i> Mis Trámites</a></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('level') == 1 && $this->session->userdata('level') != 3): ?>
                <li> <a href="<?=base_url()?>admin/mis-licencias"><i class="fa fa-file-text-o" aria-hidden="true"></i> Mis Licencias</a></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('level') > 1 && $this->session->userdata('level') != 3): ?>
                <li> <a href="<?=base_url()?>admin/impresion"><i class="fa fa-print" aria-hidden="true"></i> Impresión de Licencias</a></li>
            <?php endif; ?>
            <li> <a href="<?=base_url()?>admin/mis-mensajes"><i class="fa fa-envelope-o" aria-hidden="true"></i> Mis Mensajes</a></li>
            <?php if ($this->session->userdata('level') != 3): ?>
                <li><a href="#tramites" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-file" aria-hidden="true"></i> Nuevo Trámite </a>
                    <ul id="tramites" class="collapse list-unstyled">
                        <li><a href="<?=base_url()?>nueva-licencia"><i class="fa fa-file-text-o" aria-hidden="true"></i> Licencia de giro tipo A</a></li>
                        <?php if($this->session->userdata('level') == 1): ?>
                        <li><a href="url_construccion"><i class="fa fa-file-text-o" aria-hidden="true"></i> Licencia de construcción</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if ($this->session->userdata('level') == 3): ?>
                <li> <a href="<?=base_url()?>revision"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Revisión</a></li>
            <?php endif; ?>
            <?php $pws = "";//api recuperar la contraseña
            <?php if ($this->session->userdata('level') == 1): ?>
                <li> <a href="url_pago_en_linea"><i class="fa fa-retweet" aria-hidden="true"></i> Renueva tu Licencia</a></li>
            <?php endif; ?>

        </ul>
    </nav>
