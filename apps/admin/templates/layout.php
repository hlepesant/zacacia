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
<div id="header_band">
    <div id="header">
        <h1><?php echo sfConfig::get('projetctName'); ?></h1>
        <p><?php echo sfConfig::get('projetctDesc'); ?></p>
    </div>
    <!-- end #header -->
</div>
<!-- end #header_band -->
<?php /*
<div id="menu">
    <ul>
        <li class="current_page_item"><a href="#" class="active">Platform</a></li>
        <li><a href="#" class="first">Company</a></li>
        <li><a href="#" class="first">Domain</a></li>
        <li><a href="#" class="first">User</a></li>
        <li><a href="#" class="first">Group</a></li>
        <li><a href="#" class="first">Forward</a></li>
    </ul>
</div>
<!-- end #menu -->
*/ ?>
<div id="content_band">
    <div id="content">
        <?php echo $sf_content ?>
    </div>
    <!-- end #content -->
</div>
<!-- end #content_band -->
<div id="footer_band">
    <div id="footer">
        <div id="footer-content">
            <p>hugues-at-lepesant-dot-com</p>
        </div>
        <!-- end #footer-content -->
    </div>
    <!-- end #footer -->
</div>
<!-- end #footer_band -->
</body>
</html>
