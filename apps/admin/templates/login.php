<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<content>
  <?php echo $sf_content ?>
</content>

</body>
</html>
