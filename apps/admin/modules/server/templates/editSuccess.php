<?php
/*
<?php slot('topnav') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo __('Servers') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('server/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Edit Server') ;?> : <?php echo $server->getCn(); ?></h1>
    </div>

    <div id="form_item">
        <div class="_name"><?php echo $form['ip']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['ip']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkIpAddress_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>

    <div id="form_sub_section">
        <h1><?php echo $form['zarafaAccount']->renderLabel() ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->

    <div id="zarafa_settings" style="display: <?php echo $zarafa_settings_display ?>;">
    <?php echo $form['zarafaQuotaHard']->renderRow() ?>
    <?php echo $form['zarafaHttpPort']->renderRow() ?>
    <?php echo $form['zarafaSslPort']->renderRow() ?>
    <?php echo $form['multitenant']->renderRow() ?>
    <?php echo $form['zarafaContainsPublic']->renderRow() ?>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel"  />
        <input type="submit" value="<?php echo __('Update') ?>" class="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('server/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_checkip_url = '".url_for('server/checkip/')."';
var _zarafaHttpPort = '".sfConfig::get('zarafaHttpPort')."';
var _zarafaSslPort = '".sfConfig::get('zarafaSslPort')."';
");?>

echo observe_field('minidata_ip', array(
  'update' => 'checkIpAddress',
  'url' => url_for('server/checkip/'),
  'method' => 'get',
  'with' => "'&ip='+getIpAddress()",
  'frequency' => '1',
  'script' => 1
));

echo javascript_tag("
function getIpAddress()
{
  return document.getElementById('minidata_ip').value;
}
");

*/
?>
<?php slot('menu_top') ?>
<div class="z-menu">
<div class="z-menu-line">
    <strong><?php echo __('Platforms') ;?> :</strong>
    <?php echo $platform->getCn() ?>
</div>
<div class="z-menu-line">
    <strong><?php echo __('Servers') ;?> :</strong>
    <?php echo $server->getCn() ?>
</div>
<div class="z-menu-line">
<?php echo link_to(__('Logout'), 'security/logout', array('id' => 'logount-link')) ?>
</div>
</div>
<?php end_slot() ?>

<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Edit server') ?>
    </div>
</div>

<form action="<?php echo url_for('server/edit') ?>" method="POST" id="form_new" class="ym-form">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-fbox-text">
<?php echo $form['ip']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa-settings" style="display: none;">
    <div class="ym-fbox-select">
    <?php echo $form['zarafaQuotaHard']->renderRow() ?>
    </div>
    <div class="ym-fbox-text">
    <?php echo $form['zarafaHttpPort']->renderRow() ?>
    </div>
    <div class="ym-fbox-text">
    <?php echo $form['zarafaSslPort']->renderRow() ?>
    </div>
    <div class="ym-fbox-select">
    <?php echo $form['multitenant']->renderRow() ?>
    </div>
    <div class="ym-fbox-select">
    <?php echo $form['zarafaContainsPublic']->renderRow() ?>
    </div>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Update') ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@servers') ?>" method="POST" id="form-cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '".url_for('server/check/')."';
var json_resolvhost_url = '".url_for('server/resolvehost/')."';
var json_checkip_url = '".url_for('server/checkip/')."';
");?>
