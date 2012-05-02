<h1><?php echo __('Create a platform') ?></h1>

<div class='form-block'>
<form action="<?php echo url_for('platform/new') ?>" method="POST" id="new_item">
<?php echo $form->renderHiddenFields() ?>

<div class='span-14 last form-item'>
<div class='span-6 form-item-label'><?php echo $form['cn']->renderLabel() ?></div>
<div class='span-6 form-item-field'><?php echo $form['cn']->render() ?></div>
<div class='span-1 last form-item-check' id='checkName_msg'></div>
</div>

<?php echo $form['multitenant']->renderRow() ?>
<?php echo $form['multiserver']->renderRow() ?>
<?php echo $form['status']->renderRow() ?>

<div class='span-14 last form-button'>
<input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
</div>
</form>

</div>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('platform/check/')."';
");?>
