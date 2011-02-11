<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Company: Step 3/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('company/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <?php /* echo $form['zarafaAccount']->renderRow() */ ?>
    <?php /* echo $form['zarafaHidden']->renderRow() */ ?>
    <?php /* echo $form['zarafaAdminPrivilege']->renderRow() */ ?>
    <?php echo $form['zarafaCompanyServer']->renderRow() ?>
    <?php /* echo $form['zarafaQuotaCompanyWarningRecipients']->renderRow() */ ?>
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <?php /* echo $form['zarafaQuotaUserWarningRecipients']->renderRow() */ ?>
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
    <?php echo $form['zarafaSystemAdmin']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
    <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
    <?php /* echo $form['zarafaUserDefaultQuotaSoft']->renderRow() */ ?>
    <?php /* echo $form['zarafaUserDefaultQuotaWarn']->renderRow() */ ?>
    <?php /* echo $form['zarafaViewPrivilege']->renderRow() */ ?>

    <div id="form-submitline">
        <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "@platform") ?>
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="form-submit" />
    </div>

</form>
</div>

<?php echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('company/check/'),
  'method' => 'get',
  'with' => "'&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo javascript_tag("
function getName()
{
  return $('minidata_cn').value;
}
") ?>

<?php echo javascript_tag("
function setCompanyWarningQuota()
{
  if ( $('minidata_zarafaQuotaOverride').checked )
  {
    $('minidata_zarafaQuotaWarn').disabled = false;
    $('minidata_zarafaQuotaWarn').selectedIndex = 0;
  }
  else
  {
    $('minidata_zarafaQuotaWarn').disabled = true;
    $('minidata_zarafaQuotaWarn').selectedIndex = $('minidata_zarafaQuotaWarn').options.length - 1;
  }
}
") ?>

<?php echo javascript_tag("
function setUserHardQuota()
{
  if ( $('minidata_zarafaUserDefaultQuotaOverride').checked )
  {
    $('minidata_zarafaUserDefaultQuotaHard').disabled = false;
    $('minidata_zarafaUserDefaultQuotaHard').selectedIndex = 0;
  }
  else
  {
    $('minidata_zarafaUserDefaultQuotaHard').disabled = true;
    $('minidata_zarafaUserDefaultQuotaHard').selectedIndex = $('minidata_zarafaUserDefaultQuotaHard').options.length - 1;
  }
}
") ?>
