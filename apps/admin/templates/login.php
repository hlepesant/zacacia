<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />
<?php echo stylesheet_tag('yaml/core/base.css', array('type'=>'text/css')); ?>
<?php echo stylesheet_tag('yaml/forms/gray-theme.css', array('type'=>'text/css')); ?>
<!--[if lte IE 7]>
<link rel="stylesheet" href="/css/yaml/core/iehacks.css" type="text/css"/>
<![endif]-->
<?php include_stylesheets() ?>

<?php include_javascripts() ?>
</head>
<body>

<div id="header">
</div>
<div id="wrap">
  <?php echo $sf_content ?>
</div>
<div id="footer">
</div>

</body>
</html>
