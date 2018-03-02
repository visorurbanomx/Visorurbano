<!DOCTYPE html>
<html lang="es-mx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
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
    ?>
    <!-- CSS -->

    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/6096b91680.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/style.green.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/admin/admin.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url(); ?>assets/css/mui.css" rel="stylesheet" type="text/css" />
<?php
foreach($css as $file){
    echo "\n\t\t";
    ?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
} echo "\n\t";
?>


</head>
<body>
<?php echo $this->load->get_section('top'); ?>
<?php echo $this->load->get_section('sidebar'); ?>
<?php echo $output;?>

<!-- Javascript files-->
<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/mui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/base-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/utils-min.js"></script>
<!-- Custom scripts -->
<?php
foreach($js as $file){
    echo "\n\t\t";
    ?><script src="<?php echo $file; ?>"></script><?php
} echo "\n\t";
?>
<script src="<?php echo base_url(); ?>assets/js/admin-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/forms.admin-min.js"></script>



</body>
</html>
