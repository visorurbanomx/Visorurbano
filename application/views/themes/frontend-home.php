<!DOCTYPE html>
<html lang="es-mx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favivcon -->
    <link rel="icon" type="image/x-icon" href="http://visorurbano.guadalajara.gob.mx/favicon.ico">
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
    <!-- Bootstrap core CSS -->
    <link href="<?=base_url()?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <script src="https://use.fontawesome.com/6096b91680.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Exo:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url()?>assets/css/front.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-111338188-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-111338188-1');
    </script>
</head>

<body id="page-top">
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/img/logo.png" alt="Visor Urbano" width="130"></a>
        <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/img/guadalajara.png" alt="Visor Urbano" width="60"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger active" href="<?=base_url()?>">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="http://visorurbano.guadalajara.gob.mx/mapa/">Mapa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="url_pago_en_linea_refrendo_licencia">Renueva tu licencia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" id="AcercaDe" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Acerca de
                    </a>

                    <div class="dropdown-menu" aria-labelledby="AcercaDe">
                        <a class="dropdown-item" href="<?=base_url()?>manuales">¿Cómo usar Visor Urbano?</a>
                        <a class="dropdown-item" href="<?=base_url()?>normatividad">Normatividad</a>
                        <a class="dropdown-item" href="<?=base_url()?>tramites1">Trámites ( Etapa 1)</a>
                        <a class="dropdown-item" href="<?=base_url()?>preguntasfrecuentes">Preguntas Frecuentes</a>
                        <a class="dropdown-item" href="<?=base_url()?>#lidar">Datos abiertos</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="<?=base_url()?>contacto">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-success btn-round" href="<?=base_url()?>ingresar">Iniciar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<?php echo $output;?>

<!-- footer Start -->
<footer>
    <div class="container">
        <ul class="list-inline list-social">
            <li class="list-inline-item social-twitter">
                <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/img/vu-black.png" alt="Visor Urbano" width="150"></a>
            </li>
            <li class="list-inline-item social-google-plus">
                <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/img/bloomberg-black.png" alt="Visor Urbano" width="150"></a>
            </li>
            <li class="list-inline-item social-facebook">
                <a class="navbar-brand" href="<?=base_url()?>"><img src="<?=base_url()?>assets/img/guadalajara-black.png" alt="Visor Urbano" width="90"></a>
            </li>
        </ul>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="<?=base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="<?=base_url()?>assets/vendor/jssor.slider.min.js"></script>
<script src="<?=base_url()?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for this template -->
<script src="<?=base_url()?>assets/js/visor-urbano.js"></script>


<!-- Custom scripts -->
<script src="<?php echo base_url(); ?>assets/js/visor_urbano-min.js"></script><?php
foreach($js as $file){
    echo "\n\t\t";
    ?><script src="<?php echo $file; ?>"></script><?php
} echo "\n\t";
?>

</body>
</html>
