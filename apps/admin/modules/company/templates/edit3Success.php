<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('Edit'); echo $cn; echo (' : Step 3/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('company/edit3') ?>" method="POST">
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

    <div id="form-submitline">
        <?php echo link_to_function("<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />", "$('company_cancel').submit()") ?>
        <input type="submit" value="<?php echo __('Update') ?>" id="form-submit" />
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

showUserQuotaFields();
") ?>
