<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('Domain') ?>::<?php echo __('New') ?>
    </div>
</div>

<form action="<?php echo url_for('domain/new') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="cn" class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
<p id="cn-message" class="ym-message">Error: invalid value!</p>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@domains') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '".url_for('domain/check/')."';
");?>
