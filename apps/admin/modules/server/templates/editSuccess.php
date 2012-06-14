<?php slot('menu_top') ?>
<div class="z-menu">
<div class="z-menu-line">
    <strong><?php echo __('Platforms') ;?></strong> :
    <?php echo $platform->getCn() ?>
</div>
<div class="z-menu-line">
    <strong><?php echo __('Servers') ;?></strong> :
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

<form action="<?php echo url_for('server/edit') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
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

<div id="zarafa-settings" style="display: <?php echo $zarafa_settings_display ?>;">
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
