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

<?php /* echo observe_field('minidata_ip', array(
  'update' => 'checkIpAddress',
  'url' => url_for('server/checkip/'),
  'method' => 'get',
  'with' => "'&ip='+getIpAddress()",
  'frequency' => '1',
  'script' => 1
)) */
?>

<?php /* echo javascript_tag("
function getIpAddress()
{
  return document.getElementById('minidata_ip').value;
}
") */ ?>
