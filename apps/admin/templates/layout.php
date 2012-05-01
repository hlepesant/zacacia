<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />
<?php echo stylesheet_tag('blueprint/screen.css', array('type'=>'text/css', 'media' => 'screen, projection')); ?>
<?php echo stylesheet_tag('blueprint/print.css', array('type'=>'text/css', 'media' => 'print')); ?>
<!--[if IE]>
<?php echo stylesheet_tag('/css/blueprint/ie.css', array('type'=>'text/css', 'media' => 'screen, projection')) ?>
<![endif]-->
<?php include_stylesheets() ?>

<?php include_javascripts() ?>
</head>
<body>

<div class="container header">
    <div class="span-24 top header-top"></div>
    <div class="span-20 header-content">
        <?php echo image_tag('zacacia_logo_w.png') ?>
    </div>
    <div class="span-4 last header-logo"></div>
    <div class="span-24 spacer"></div>
</div>

<div class="container content">
    <div class="span-6 menu">
    <?php /*
        <div class="menu-top">
        <?php if (has_slot('menu_top')): ?>
            <?php include_slot('menu_top') ?>
        <?php endif; ?>
        </div>
        */ ?>
        <div class="menu-content">
        <?php if (has_slot('menu_content')): ?>
            <?php include_slot('menu_content') ?>
        <?php endif; ?>
        </div>
        <div class="last menu-bottom">
        <?php if (has_slot('menu_bottom')): ?>
            <?php include_slot('menu_bottom') ?>
        <?php endif; ?>
        </div>
    </div>

    <div class="span-18 last">
        <?php echo $sf_content ?>
    </div>
</div>

<div class="container footer">
    <div class="span-24 spacer"></div>
    <div class="span-24 bottom loud footer-content">hugues-at-lepesant-dot-com </div>
</div>

<?php /*
<div id="wrapper">

	<div id="top">
        <div id="header">
            <div class="col-full">
                <div id="title">
                    <?php echo image_tag('zacacia_logo_w.png') ?><br />
                </div><!-- /#logo -->
                <div id="logo">
                    <?php echo image_tag('zacacia_w.png') ?><br />
                </div><!-- /#logo -->
            </div><!-- /.col-full -->
        </div><!-- /#header -->

        <div id="breadcrumb">
            <div class="col-full">
            <?php if (has_slot('topnav')): ?>
                <?php include_slot('topnav') ?>
            <?php endif; ?>
            </div><!-- /.col-full -->
        </div><!-- /#breadcrumb -->
	</div><!-- /#top -->
       
    <div id="content">
        <?php echo $sf_content ?>
    </div><!-- /#content -->
        
	<div id="footer">
        <div class="col-full">
            <p>hugues-at-lepesant-dot-com</p>
        </div><!-- /.col-full -->
	</div><!-- /#footer  -->

</div><!-- /#wrapper -->
*/?>

</body>
</html>
