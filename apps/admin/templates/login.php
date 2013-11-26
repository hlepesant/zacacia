<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<?php include_http_metas() ?>
<?php include_title() ?>
<?php include_metas() ?>
<link rel="shortcut icon" href="/images/favicon.ico" />

<?php echo stylesheet_tag('bootstrap/bootstrap.css', array('type'=>'text/css')); ?>
<?php include_stylesheets() ?>
<?php echo stylesheet_tag('bootstrap/bootstrap-responsive.css', array('type'=>'text/css')); ?>

</head>

<body>

<div class="container">
    <?php echo $sf_content ?>
</div> <!-- /container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php /*
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/bootstrap-transition.js"></script>
<script src="../assets/js/bootstrap-alert.js"></script>
<script src="../assets/js/bootstrap-modal.js"></script>
<script src="../assets/js/bootstrap-dropdown.js"></script>
<script src="../assets/js/bootstrap-scrollspy.js"></script>
<script src="../assets/js/bootstrap-tab.js"></script>
<script src="../assets/js/bootstrap-tooltip.js"></script>
<script src="../assets/js/bootstrap-popover.js"></script>
<script src="../assets/js/bootstrap-button.js"></script>
<script src="../assets/js/bootstrap-collapse.js"></script>
<script src="../assets/js/bootstrap-carousel.js"></script>
<script src="../assets/js/bootstrap-typeahead.js"></script>
*/ ?>

</body>
</html>
