<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/images/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>

<div class="wrapper">

    <div class="header">
        <?php echo image_tag('zacacia.png') ?><br />
    </div>
    <!-- end .header -->

    <div class="topnav">
    <?php if (has_slot('topnav')): ?>
        <?php include_slot('topnav') ?>
    <?php endif; ?>
    </div>
    <!-- end .topnav -->

    <div class="content">
        <?php echo $sf_content ?>
    </div>
    <!-- end .content -->

    <div class="footer">
        <p>hugues-at-lepesant-dot-com</p>
    </div>
    <!-- end .footer -->

</div>
<!-- end .wrapper -->
</body>
</html>
