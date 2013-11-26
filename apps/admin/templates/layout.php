<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />
<?php /* echo stylesheet_tag('yaml/core/base.css', array('type'=>'text/css')); */ ?>
<?php /* echo stylesheet_tag('yaml/forms/gray-theme.css', array('type'=>'text/css')); */ ?>
<?php echo stylesheet_tag('bootstrap/bootstrap-responsive.css', array('type'=>'text/css')); ?>
<?php /*
<!--[if lte IE 7]>
<link rel="stylesheet" href="/css/yaml/core/iehacks.css" type="text/css"/>
<![endif]-->
*/ ?>

<?php include_stylesheets() ?>

<?php include_javascripts() ?>
</head>
<body>

<div id="header">
  <div class="ym-column">
    <div class="ym-col1"></div>
    <div class="ym-col2"></div>
    <div class="ym-col3 z-logo">
    <?php echo image_tag('zacacia_logo_w.png') ?>
    </div>

  </div>
</div>

<div id="wrap">
    <div class="ym-column">
        <div class="ym-col1">
            <?php if (has_slot('menu_top')): ?>
                <?php include_slot('menu_top') ?>
            <?php endif; ?>
        </div>
        
        <div class="ym-col3 z-content">
            <?php echo $sf_content ?>
        </div>
    </div>

    <div class="ym-column">
        <div class="ym-col1"></div>
        <div class="ym-col3 z-content-footer">
            <?php echo link_to(image_tag('famfam/door_out.png'), array(), array('id' => 'logout-link', 'confirm' => __('Quit Zacacia ?'))); ?>
        </div>
    </div>
</div>
        

<?php /*
<div id="footer">
  <div class="ym-column">
    <div class="ym-col1"></div>
    <div class="ym-col2"></div>
    <div class="ym-col3 z-footer">
      hugues-at-lepesant-dot-com
    </div>
  </div>
</div>
*/ ?>
</body>
</html>
