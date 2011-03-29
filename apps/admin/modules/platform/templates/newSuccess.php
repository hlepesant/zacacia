<?php use_helper('Javascript') ?>

<div id="form_box">

<div id="form_header">
<?php echo __('New Platform') ;?>
</div>

<div id="form_content">

<form action="<?php echo url_for('platform/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <div id="form_line">
        <div id="form_line" class="item"><?php echo $form['cn']->renderLabel() ?></div>
        <div id="form_line" class="field"><?php echo $form['cn']->render() ?></div>
        <div id="form_line" class="check">
            <div id="checkName"></div>
        </div>
    </div>
    <!-- end #form_line -->

    <?php echo $form['undeletable']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>

    <div id="form_submit">
        <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "@platform") ?>
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form-submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_content -->

</div>
<!-- end #form_box -->

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
