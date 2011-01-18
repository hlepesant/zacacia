<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
	
<div class="content">
	<div id="top">
      <div id="icons">
      	<a href="/index.html" title="Home page"><img src="/images/redbusiness/home.png" alt="Home" /></a>
      	<a href="/contact/" title="Contact us"><img src="/images/redbusiness/contact.png" alt="Contact" /></a>
      	<a href="/sitemap/" title="Sitemap"><img src="/images/redbusiness/sitemap.png" alt="Sitemap" /></a>
      	<a href="/logout/" title="Logout"><img src="/images/redbusiness/logout.png" alt="Logout" /></a>
      </div>
      <h1><?php echo sfConfig::get('projetctName'); ?></h1>
      <h2><?php echo sfConfig::get('projetctDesc'); ?></h2>
	</div>
</div>			

<div class="content">
	<div id="main">
    <?php echo $sf_content ?>
	</div>
</div>

<div class="content">
	<div id="footer">
	<div class="right">&copy; Copyright 2010, <a href="http://hugues.lepesant.com">Hugues Lepesant</a><br />Design: <a href="http://www.free-css-templates.com">David Herreman</a></div>
	<a href="http://validator.w3.org/check?uri=referer" title="Validate">XHTML</a> - <a href="http://jigsaw.w3.org/css-validator/check/referer" title="Validate">CSS</a>
	</div>
</div>

</body>
</html>
