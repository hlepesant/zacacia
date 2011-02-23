<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Company: Step 2/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('company/new2') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <?php echo $form['zarafaCompanyServer']->renderRow() ?>
    <?php /* echo $form['zarafaSystemAdmin']->renderRow() */ ?>
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>

    <?php /* echo $form['zarafaQuotaCompanyWarningRecipients']->renderRow() */ ?>
    <?php /* echo $form['zarafaAccount']->renderRow() */ ?>
    <?php /* echo $form['zarafaHidden']->renderRow() */ ?>
    <?php /* echo $form['zarafaAdminPrivilege']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaUserWarningRecipients']->renderRow() */ ?>
    <?php /* echo $form['zarafaUserDefaultQuotaOverride']->renderRow() */ ?>
    <?php /* echo $form['zarafaUserDefaultQuotaHard']->renderRow() */ ?>
    <?php /* echo $form['zarafaUserDefaultQuotaSoft']->renderRow() */ ?>
    <?php /* echo $form['zarafaUserDefaultQuotaWarn']->renderRow() */ ?>
    <?php /* echo $form['zarafaViewPrivilege']->renderRow() */ ?>

    <div id="form-submitline">
        <?php echo link_to_function("<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />", "miniCancel()") ?>
        <input type="submit" value="<?php echo __('Next') ?>" id="form-submit" />
    </div>

</form>
</div>

<form action="<?php echo url_for('company/index') ?>" method="POST" id="company_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
function showCompanyQuotaFields()
{
  if ( $('minidata_zarafaQuotaOverride').checked )
  {
    $('minidata_zarafaQuotaWarn').disabled = false;
    $('minidata_zarafaQuotaWarn').focus();
  }
  else
  {
    $('minidata_zarafaQuotaWarn').disabled = true;
    $('minidata_zarafaQuotaWarn').value = null;
  }
}

showCompanyQuotaFields();
") ?>

<?php echo javascript_tag("
function miniCancel()
{
    $('company_cancel').submit();
}
") ?>
