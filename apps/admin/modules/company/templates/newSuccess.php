<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New Company') ;?>
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

    <div id="form-line">
        <div id="form-line" class="item"><?php echo $form['cn']->renderLabel() ?></div>
        <div id="form-line" class="field"><?php echo $form['cn']->render() ?></div>
        <div id="form-line" class="check">
            <div id="checkName"></div>
        </div>
    </div>
    
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

    <?php echo $form['undeletable']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>

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
