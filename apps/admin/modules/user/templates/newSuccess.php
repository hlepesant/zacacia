<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;
            <u><?php echo $company->getCn();?></u>&nbsp;&rarr;&nbsp;
            <?php echo __('New User') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('user/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <?php echo $form['sn']->renderRow() ?>
    
    <div id="form_item">
        <div class="_name"><?php echo $form['givenName']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['givenName']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->
    
    <div id="form_item">
        <div class="_name"><?php echo $form['displayName']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['displayName']->render() ?></div>
        <div class="_ajaxSwitch" id="imgSwitch">
            <?php echo image_tag('famfam/arrow_rotate_anticlockwise.png', array('title' => __('Switch'), 'id' => 'switch')) ?>
        </div>
    </div>

    <!-- end #form_item -->
    <div id="form_item">
        <div class="_name"><?php echo $form['uid']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['uid']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkUid_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"><?php echo $form['userPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['userPassword']->render() ?></div>
        <div class="_ajaxCheck"><div id="pmeter"></div></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"><?php echo $form['confirmPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['confirmPassword']->render() ?></div>
        <div class="_ajaxCheck"><div id="pequality"></div></div>
    </div>
    <!-- end #form_item -->

<?php /*
    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>


    <div id="form_sub_section">
        <div class="_title"><?php echo $form['zarafaAccount']->renderLabel() ?></div>
    </div>
    <!-- end #form_section -->

*/ ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __('Cancel') ?>" id="button_cancel" />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="button_submit" />
        <!-- input type="submit" value="<?php echo __('Create') ?>" id="button_submit" / -->
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('user/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_checkcn_url = '".url_for('user/checkcn/')."';
var json_checkuid_url = '".url_for('user/checkuid/')."';
var password_i18n = new Array();
password_i18n[1] = '".__('Too weak')."'; 
password_i18n[2] = '".__('Weak')."'; 
password_i18n[3] = '".__('Medium')."'; 
password_i18n[4] = '".__('Strong')."'; 
password_i18n[5] = '".__('Very strong')."'; 
");?>

<?php /* echo javascript_tag("
function updateUsername()
{
    var givenName = substr( strtolower( $('minidata_givenName').value ), 0, 1);
    var sn = strtolower( $('minidata_sn').value );

    if ( strlen( givenName ) && strlen( sn ) )
    {
        $('minidata_uid').value = sprintf('".sfConfig::get('username_format')."', givenName, sn);
    }
}
") */ ?>

<?php /* echo observe_field('minidata_uid', array(
  'update' => 'checkUid',
  'url' => url_for('user/checkuid/'),
  'method' => 'get',
//  'with' => "'&platformDn='+$('minidata_platformDn').value+'&companyDn='+$('minidata_companyDn').value+'&uid='+$('minidata_uid').value",
  'with' => "'&companyDn='+$('minidata_companyDn').value+'&uid='+$('minidata_uid').value",
  'frequency' => '1',
  'script' => 1
))
*/ ?>

<?php /* echo observe_field('veegasdata_cn', array(
  'update' => 'checkName',
  'url' => url_for('user/check/'),
  'method' => 'get',
  'with' => "'&holdingDn=".$holding['dn']."&companyDn=".$company['dn']."&name='+getName()",
  'frequency' => '1',
  'script' => 1
))
*/ ?>

<?php /* echo javascript_tag("
function getUserName()
{
    var givenName = $('minidata_givenName').value;
    var sn = $('minidata_sn').value;
}
") */ ?>
