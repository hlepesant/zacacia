<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo __('Companies') ;?></strong>
<?php end_slot() ?>


<div id="form_box">
<form action="<?php echo url_for('company/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Create a company') ?></h1>
    </div>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>

    <div id="form_sub_section">
        <h1><?php echo $form['zarafaAccount']->renderLabel() ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->

    <div id="zarafa_settings" style="display: none;">
        <?php /* echo $form['zarafaCompanyServer']->renderRow() */ ?>
        <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
        <div id="zarafaQuota" style="display: none;">
        <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
        </div>

        <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
        <div id="zarafaUserDefaultQuota" style="display: none;">
        <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
        <?php /* echo $form['zarafaUserDefaultQuotaSoft']->renderRow() */ ?>
        <?php /* echo $form['zarafaUserDefaultQuotaWarn']->renderRow() */ ?>
        </div>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __('Cancel') ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('company/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_check_url = '".url_for('company/check/')."';
");?>
