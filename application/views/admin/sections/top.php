<?php
    $mensajesTop = $this->Mensajes->getMensajes($this->session->userdata('idU'), 5, true);
    $totalMensajesNuevos = count($mensajesTop);
?>
<div class="page home-page">
    <!-- Main Navbar-->
    <header class="header">
        <nav class="navbar">
            <!-- Search Box-->
            <div class="search-box">
                <button class="dismiss"><i class="icon-close"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="What are you looking for..." class="form-control">
                </form>
            </div>
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <!-- Navbar Header-->
                    <div class="navbar-header">
                        <!-- Navbar Brand -->
                        <center>
                        <a href="<?php echo base_url(); ?>" class="navbar-brand">
                            <div class="brand-text brand-big hidden-lg-down"><img src="<?php echo base_url(); ?>assets/img/logo-blanco.png" width="140" alt="Visor Urbano"></div>
                        </a>
                        </center>
                        <!-- Toggle Button-->
                    </div>
                    <!-- Navbar Menu -->
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                        <!-- Messages                        -->
                        <li class="nav-item dropdown">
                            <a id="messages" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
                                <i class="fa fa-envelope-o"></i>
                                <?php if($totalMensajesNuevos > 0): ?>
                                    <span class="badge bg-danger"><?=$totalMensajesNuevos;?></span>
                                <?php endif; ?>
                            </a>
                            <ul aria-labelledby="notifications" class="dropdown-menu">
                                <?php foreach ($mensajesTop as $msg): ?>
                                    <li>
                                        <a rel="nofollow" href="<?=base_url()?>admin/mis-mensajes/<?=$this->utils->encode($msg->id_mensaje) ?>" class="dropdown-item d-flex">
                                            <div class="msg-profile">
                                                <img src="<?php echo base_url(); ?>assets/img/default.png" alt="Visor Urbano" class="img-fluid rounded-circle"></div>
                                            <div class="msg-body">
                                                <h3 class="h5">
                                                    Nuevo mensaje de: <b>Visor Urbano</b>
                                                </h3>
                                                <span><?=$msg->mensaje?></span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                                <hr>
                                <li><a rel="nofollow" href="<?=base_url()?>admin/mis-mensajes" class="dropdown-item all-notifications text-center"> <strong><i class="fa fa-envelope-open-o" aria-hidden="true"></i> Ver todos mis mensajes</strong></a></li>
                            </ul>
                        </li>
                        <!-- Logout    -->
                        <li class="nav-item"><a href="javascript:logout()" class="nav-link logout">Cerrar Sesión<i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
