<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ?>::<?php echo __('New') ?>
    </div>
</div>

<form action="<?php echo url_for('company/new') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="cn" class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
<p id="cn-message" class="ym-message">Error: invalid value!</p>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa-settings" style="display: none;">

<?php /*
    <div class="ym-fbox-select">
    <?php echo $form['zarafaCompanyServer']->renderRow() ?>
    </div>
*/ ?>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    </div>

    <div id="zarafa-settings-zarafaquotawarn" style="display: none;">
        <div class="ym-fbox-text z-option">
        <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
        </div>
    </div>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
    </div>

    <div id="zarafa-settings-userdefaultquota" style="display: none;">
        <div class="ym-fbox-text z-option">
        <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
        </div>
        <div class="ym-fbox-text z-option">
        <?php echo $form['zarafaUserDefaultQuotaSoft']->renderRow() ?>
        </div>
        <div class="ym-fbox-text z-option">
        <?php echo $form['zarafaUserDefaultQuotaWarn']->renderRow() ?>
        </div>
    </div>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@companies') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('company/check/')."';
");?>
