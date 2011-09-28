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

<nav class="topnav">
<ul>
<li id="home-nav">
<a href="/">Max Design home</a>
</li>
</ul>
</nav>
<div class="container">

    <header role="banner">
        <hgroup>
            <h1><?php echo sfConfig::get('projetctName'); ?></h1>
            <h2><?php echo sfConfig::get('projetctDesc'); ?></h2>
        </hgroup>
    </header>

  </div>
  <!-- end #header_band -->
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
</div>
<!-- end .container -->
</body>
</html>
