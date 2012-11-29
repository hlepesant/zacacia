<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ?> : <?php echo $company->getCn() ?>::<?php echo __('Edit') ?>
    </div>
</div>

<form action="<?php echo url_for('company/edit') ?>" method="POST" id="form_edit" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>


<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa_settings" style="display: <?php echo $zarafa_settings_display ?>;">

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

    <div id="zarafa-settings-userdefaultquota" style="display: <?php echo $zarafa_users_settings_display ?>;">
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

<form action="<?php echo url_for('company/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
