<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include_http_metas() ?>
<?php include_metas() ?>
<?php include_title() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />
<?php include_stylesheets() ?>
<?php include_javascripts() ?>
</head>
<body>
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

</body>
</html>
