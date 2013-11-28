<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<?php include_http_metas() ?>
<?php include_title() ?>
<?php include_metas() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<?php echo stylesheet_tag('bootstrap/bootstrap.css', array('type'=>'text/css')); ?>
<?php include_stylesheets() ?>
<?php echo stylesheet_tag('bootstrap/bootstrap-responsive.css', array('type'=>'text/css')); ?>
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <h1 style="font-family: 'Lobster', cursive; color: white;">Zacacia</h2>
        </div>
    </div>
</div>

<div class="page-header">
    <div class="container">
        <h2 style="font-family: 'Lobster', cursive;"><?php include_slot('title', 'no slot defined !!') ?></h2>
    </div>
</div>

<div class="container">
<?php echo $sf_content ?>
</div> <!-- /container -->


<?php include_javascripts() ?>
</body>
</html>
