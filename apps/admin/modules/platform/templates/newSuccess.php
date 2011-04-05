<?php /* use_helper('Javascript') */ ?>
<?php use_helper('jQuery') ?>

<div id="navigation">
    <div id="nav_title">
        <ul>
            <li><h1><?php echo __('New Platform') ?><h1></li>
        </ul>
    </div>
</div>
<!-- end #navigation -->

<div id="form_box">

<form action="<?php echo url_for('platform/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['undeletable']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>
<?php /*
    <div id="form_submit">
        <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "@platform") ?>
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form-submit" />
    </div>
*/ ?>
    <div id="form_submit">
      <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" class=\"_button\"  />" , "@platform") ?>
      <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="_submit"  class="form_submit"/>
    </div>

    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_content -->

</div>
<!-- end #form_box -->

<?php /* echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('platform/check/'),
  'method' => 'get',
  'with' => "'&name='+getName()",
  'frequency' => '1',
  'script' => 1
)) */
?>

<?php echo javascript_tag("
function getName()
{
  var cn = document.getElementById('minidata_cn');
  return cn.value;
}
") ?>
