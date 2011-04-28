<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;<?php echo __('New Company') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('company/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>


    <div id="form_sub_section">
        <div class="_title"><?php echo $form['zarafaAccount']->renderLabel() ?></div>
    </div>
    <!-- end #form_section -->
    <?php /* echo $form['zarafaCompanyServer']->renderRow() */ ?>
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <div id="zarafaQuota" style="display: none;">
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
    </div>

    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
    <div id="zarafaUserDefaultQuota" style="display: none;">
    <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaSoft']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaWarn']->renderRow() ?>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel" />
        <input type="submit" value="<?php echo __('Next') ?>" disabled="true" id="button_submit" />
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
