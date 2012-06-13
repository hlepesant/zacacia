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

<header>
  <div class="ym-column">
    <div class="ym-col1">
    </div>
    
    <div class="ym-col2">
    </div>

    <div class="ym-col3 z-logo">
    <?php echo image_tag('zacacia_logo_w.png') ?>
    </div>

  </div>
</header>

<content>
  <div class="ym-column">
    <div class="ym-col1">
      <?php if (has_slot('menu_top')): ?>
          <?php include_slot('menu_top') ?>
      <?php endif; ?>
      <?php /* if (has_slot('menu_content')): ?>
          <?php include_slot('menu_content') ?>
      <?php endif; ?>
      <?php if (has_slot('menu_bottom')): ?>
          <?php include_slot('menu_bottom') ?>
      <?php endif; */ ?>
    </div>
    
    <div class="ym-col3 z-content">
      <?php echo $sf_content ?>
    </div>
  </div>
</content>

<footer>
  <div class="ym-column">
    <div class="ym-col1">
    </div>
    
    <div class="ym-col2">
    </div>

    <div class="ym-col3 z-footer">
      hugues-at-lepesant-dot-com
    </div>

  </div>
</footer>

<?php echo javascript_tag("
var _js_msg_logout = '".__("Quit Zacacia ?")."';
") ?>



</body>
</html>
