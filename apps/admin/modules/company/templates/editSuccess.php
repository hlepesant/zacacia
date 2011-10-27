<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo __('Companies') ;?></strong>
<?php end_slot() ?>


<div id="form_box">
<form action="<?php echo url_for('company/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Edit Company') ;?> : <?php echo $company->getCn(); ?></h1>
    </div>

    <?php echo $form['status']->renderRow() ?>

    <div id="form_sub_section">
        <h1><?php echo $form['zarafaAccount']->renderLabel() ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->

    <div id="zarafa_settings" style="display: <?php echo $zarafa_settings_display ?>;">
        <?php /* echo $form['zarafaCompanyServer']->renderRow() */ ?>
        <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
        <div id="zarafaQuota" style="display: <?php echo $zarafa_company_settings_display ?>;">
        <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
        </div>

        <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
        <div id="zarafaUserDefaultQuota" style="display: <?php echo $zarafa_users_settings_display ?>;">
        <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
        <?php /* echo $form['zarafaUserDefaultQuotaSoft']->renderRow() */ ?>
        <?php /* echo $form['zarafaUserDefaultQuotaWarn']->renderRow() */ ?>
        </div>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Save') ?>" class="button_submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('company/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
