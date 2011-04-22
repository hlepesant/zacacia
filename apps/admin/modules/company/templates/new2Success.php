<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;<?php echo __('New Company') ;?> : <?php echo __('Step 2/3') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('company/new2') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <?php echo $form['zarafaCompanyServer']->renderRow() ?>
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>

<?php
/* 
 * echo $form['zarafaSystemAdmin']->renderRow();
 * echo $form['zarafaQuotaCompanyWarningRecipients']->renderRow();
 * echo $form['zarafaAccount']->renderRow();
 * echo $form['zarafaHidden']->renderRow();
 * echo $form['zarafaAdminPrivilege']->renderRow();
 * echo $form['zarafaQuotaUserWarningRecipients']->renderRow();
 * echo $form['zarafaUserDefaultQuotaOverride']->renderRow();
 * echo $form['zarafaUserDefaultQuotaHard']->renderRow();
 * echo $form['zarafaUserDefaultQuotaSoft']->renderRow();
 * echo $form['zarafaUserDefaultQuotaWarn']->renderRow();
 * echo $form['zarafaViewPrivilege']->renderRow()
 */
?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel"  />
        <input type="submit" value="<?php echo __('Next') ?>" disabled="true" id="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('company/index') ?>" method="POST" id="button_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
