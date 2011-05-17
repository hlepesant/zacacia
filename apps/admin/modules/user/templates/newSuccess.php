<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('New User : Step 1/3') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('user/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <?php echo $form['givenName']->renderRow() ?>
    <?php echo $form['sn']->renderRow() ?>
    <?php echo $form['displayRender']->renderRow() ?>
    <?php echo $form['displayName']->renderRow() ?>

    <div id="form-line">
        <div id="form-line" class="item"><?php echo $form['uid']->renderLabel() ?></div>
        <div id="form-line" class="field"><?php echo $form['uid']->render() ?></div>
        <div id="form-line" class="check">
            <div id="checkUid"></div>
        </div>
    </div>
    
    <?php echo $form['userPassword']->renderRow() ?>
    <?php echo $form['confirmPassword']->renderRow() ?>
    
    <?php echo $form['undeletable']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>

    <div id="form-submitline">
        <?php echo link_to_function("<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form_button\"  />", "$('company_cancel').submit()") ?>
        <input type="submit" value="<?php echo __('Next') ?>" disabled="true" id="form-submit" />
    </div>

</form>
</div>

<form action="<?php echo url_for('company/index') ?>" method="POST" id="company_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
function updateUsername()
{
    var givenName = substr( strtolower( $('minidata_givenName').value ), 0, 1);
    var sn = strtolower( $('minidata_sn').value );

    if ( strlen( givenName ) && strlen( sn ) )
    {
        $('minidata_uid').value = sprintf('".sfConfig::get('username_format')."', givenName, sn);
    }
}
") ?>

<?php echo observe_field('minidata_uid', array(
  'update' => 'checkUid',
  'url' => url_for('user/checkuid/'),
  'method' => 'get',
//  'with' => "'&platformDn='+$('minidata_platformDn').value+'&companyDn='+$('minidata_companyDn').value+'&uid='+$('minidata_uid').value",
  'with' => "'&companyDn='+$('minidata_companyDn').value+'&uid='+$('minidata_uid').value",
  'frequency' => '1',
  'script' => 1
))
?>

<?php /* echo observe_field('veegasdata_cn', array(
  'update' => 'checkName',
  'url' => url_for('user/check/'),
  'method' => 'get',
  'with' => "'&holdingDn=".$holding['dn']."&companyDn=".$company['dn']."&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
*/
?>

<?php echo javascript_tag("
function getUserName()
{
    var givenName = $('minidata_givenName').value;
    var sn = $('minidata_sn').value;
}
") ?>
