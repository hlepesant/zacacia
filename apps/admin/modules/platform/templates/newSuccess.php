<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Create a platform') ?>
    </div>
    <div class="ym-g30 ym-gr">
        <input type="button" value="<?php echo __("Cancel") ?>" class="ym-button z-button-cancel" />
    </div>
</div>


<form action="<?php echo url_for('platform/new') ?>" method="POST" id="form_new" class="ym-form">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['multitenant']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['multiserver']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

</div>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('platform/check/')."';
");?>
