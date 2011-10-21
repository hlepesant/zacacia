<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo __('Servers') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('server/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Create a server') ?></h1>
    </div>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"><?php echo $form['ip']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['ip']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkIpAddress_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_sub_section">
        <h1><?php echo $form['zarafaAccount']->renderLabel() ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->

    <div id="zarafa_settings" style="display: none;">
    <?php echo $form['zarafaQuotaHard']->renderRow() ?>
    <?php echo $form['zarafaHttpPort']->renderRow() ?>
    <?php echo $form['zarafaSslPort']->renderRow() ?>
    <?php echo $form['multitenant']->renderRow() ?>
    <?php echo $form['zarafaContainsPublic']->renderRow() ?>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel"  />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('@server') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_check_url = '".url_for('server/check/')."';
var json_resolvhost_url = '".url_for('server/resolvehost/')."';
var json_checkip_url = '".url_for('server/checkip/')."';
");?>
