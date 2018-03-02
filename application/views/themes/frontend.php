<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favivcon -->
    <link rel="icon" type="image/x-icon" href="<?=base_url()?>favicon.ico">
    <!--------------->
    <title>Visor Urbano</title>
    <?php
    if(!empty($meta))
        foreach($meta as $name=>$content){
            echo "\n\t\t";
            ?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
        }
    echo "\n";

    if(!empty($canonical))
    {
        echo "\n\t\t";
        ?><link rel="canonical" href="<?php echo $canonical?>" /><?php

    }
    echo "\n\t";

    foreach($css as $file){
        echo "\n\t\t";
        ?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
    } echo "\n\t";
    ?>
    <!-- CSS -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/freelancer.css" rel="stylesheet">


</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Visor Urbano" width="130"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#acercade">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#tramites">Trámites y Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>mapa">Mapa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url();?>ingresar">Iniciar Sesion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php echo $output;?>

<!-- footer Start -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-manu">
                    <ul>
                        <li><img src="<?php echo base_url(); ?>assets/img/logo-blanco.png" alt="Visor Urbano" width="120"></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/bloomberg-blanco.png" alt="Visor Urbano" width="120"></li>
                        <li><img src="<?php echo base_url(); ?>assets/img/gobiernoGuadalajara-blanco.png" alt="Visor Urbano" width="70"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Js -->

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>


<script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts -->
<script src="<?php echo base_url(); ?>assets/js/visor_urbano-min.js"></script><?php
foreach($js as $file){
    echo "\n\t\t";
    ?><script src="<?php echo $file; ?>"></script><?php
} echo "\n\t";
?>

</body>
</html>