<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('Edit'); echo $cn; echo ('  : Step 2/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('company/edit2') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>

    <div id="form-submitline">
        <?php echo link_to_function("<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />", "$('company_cancel').submit()") ?>
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
