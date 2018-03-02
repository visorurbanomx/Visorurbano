<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <link href="//cdn.muicss.com/mui-0.9.30/css/mui.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/auth.css" rel="stylesheet">



</head>
<body>

<?php echo $output;?>


<!-- Js -->

<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.min.js"></script>
<script src="//cdn.muicss.com/mui-0.9.30/js/mui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/base-min.js"></script>
<?php
foreach($js as $file){
    echo "\n\t\t";
    ?><script src="<?php echo $file; ?>"></script><?php
} echo "\n\t";
?>
<!-- Custom scripts -->
<script src="<?php echo base_url(); ?>assets/js/forms-min.js"></script>


</body>
</html>