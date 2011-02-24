<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Domain') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('domain/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <div id="form-line">
        <div id="form-line" class="item"><?php echo $form['cn']->renderLabel() ?></div>
        <div id="form-line" class="field"><?php echo $form['cn']->render() ?></div>
        <div id="form-line" class="check">
            <div id="checkName"></div>
        </div>
    </div>
    
  <?php echo $form['undeletable']->renderRow() ?>
  <?php echo $form['status']->renderRow() ?>

    <div id="form-submitline">
        <?php echo link_to_function( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "$('domain_cancel').submit()") ?>
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form-submit" />
    </div>

</form>
</div>

<form action="<?php echo url_for('domain/index') ?>" method="POST" id="domain_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('domain/check/'),
  'method' => 'get',
  'with' => "'&name='+$('minidata_cn').value",
  'frequency' => '1',
  'script' => 1
))
?>
