<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Company: Step 3/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('company/new3') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>
    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaSoft']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaWarn']->renderRow() ?>

    <?php /* echo $form['zarafaAccount']->renderRow() */ ?>
    <?php /* echo $form['zarafaHidden']->renderRow() */ ?>
    <?php /* echo $form['zarafaAdminPrivilege']->renderRow() */ ?>
    <?php /* echo $form['zarafaCompanyServer']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaCompanyWarningRecipients']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaOverride']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaUserWarningRecipients']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaWarn']->renderRow() */ ?>
    <?php /* echo $form['zarafaSystemAdmin']->renderRow() */ ?>
    <?php /* echo $form['zarafaViewPrivilege']->renderRow() */ ?>

    <div id="form-submitline">
        <?php echo link_to_function("<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />", "miniCancel()") ?>
        <input type="submit" value="<?php echo __('Create') ?>" id="form-submit" />
    </div>

</form>
</div>

<form action="<?php echo url_for('company/index') ?>" method="POST" id="company_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
function showUserQuotaFields()
{
  if ( $('minidata_zarafaUserDefaultQuotaOverride').checked )
  {
    $('minidata_zarafaUserDefaultQuotaHard').disabled = false;
    $('minidata_zarafaUserDefaultQuotaSoft').disabled = false;
    $('minidata_zarafaUserDefaultQuotaWarn').disabled = false;
  }
  else
  {
    $('minidata_zarafaUserDefaultQuotaHard').disabled = true;
    $('minidata_zarafaUserDefaultQuotaHard').value = null;

    $('minidata_zarafaUserDefaultQuotaSoft').disabled = true;
    $('minidata_zarafaUserDefaultQuotaSoft').value = null;

    $('minidata_zarafaUserDefaultQuotaWarn').disabled = true;
    $('minidata_zarafaUserDefaultQuotaWarn').value = null;
  }
}
") ?>

<?php echo javascript_tag("
function miniCancel()
{
    $('company_cancel').submit();
}
") ?>
