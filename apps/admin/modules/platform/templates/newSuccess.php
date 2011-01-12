<?php use_helper('Javascript') ?>

<h3><?php echo __('New Platform') ;?></h3>

<div id="form_inner">
<form action="<?php echo url_for('platform/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="error_list">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

  <div id="form_line">
    <div class="item"><?php echo $form['cn']->renderLabel() ?></div>
    <div class="field"><?php echo $form['cn']->render() ?></div>
    <div id="checkName"></div>
  </div>

  <?php echo $form['undeletable']->renderRow() ?>
  <?php echo $form['status']->renderRow() ?>

  <div id="form_submitline">
    <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />" , "@platform") ?>
    <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form_submit"  class="form_submit"/>
  </div>
</form>
</div>

<?php echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('platform/check/'),
  'method' => 'get',
  'with' => "'&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo javascript_tag("
function getName()
{
  var cn = document.getElementById('minidata_cn');
  return cn.value;
}
") ?>
