<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;<?php echo __('New Company') ;?> : <?php echo __('Step 3/3') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('company/new3') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>

    <div id="zarafaUserDefaultQuota" style="display: none;">
    <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaSoft']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaWarn']->renderRow() ?>
    </div>

<?php
/*
 * echo $form['zarafaAccount']->renderRow();
 * echo $form['zarafaHidden']->renderRow();
 * echo $form['zarafaAdminPrivilege']->renderRow();
 * echo $form['zarafaCompanyServer']->renderRow();
 * echo $form['zarafaQuotaCompanyWarningRecipients']->renderRow();
 * echo $form['zarafaQuotaOverride']->renderRow();
 * echo $form['zarafaQuotaUserWarningRecipients']->renderRow();
 * echo $form['zarafaQuotaWarn']->renderRow();
 * echo $form['zarafaSystemAdmin']->renderRow();
 * echo $form['zarafaViewPrivilege']->renderRow();
 */
?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel" />
        <input type="submit" value="<?php echo __('Next') ?>" id="button_submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('company/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
