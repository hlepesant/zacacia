<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title" id="back-link">
        <?php echo __('Platform : '); echo link_to($platform->getCn(), '@platforms'); ?> &rarr;
        <?php echo __('Server') ?>::<?php echo __('New') ?>
    </div>
</div>

<?php echo form_tag('@server_new?platform='.$platform->getCn(), array('id' => 'form_new', 'class' => 'ym-form ym-columnar') ); ?>
<?php echo $form->renderHiddenFields() ?>

<div id="cn" class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
<p id="cn-message" class="ym-message">Error: invalid value!</p>
</div>

<div class="ym-fbox-text">
<?php echo $form['ip']->renderRow() ?>
<p class="ym-message">Error: invalid value!</p>
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
<?php echo button_to('Cancel', '@servers?platform='.$platform->getCn(), array('class' => 'button-cancel')) ?>
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@servers?platform='.$platform->getCn()) ?>" method="POST" id="form-cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '".url_for('server/check/')."';
var json_resolvhost_url = '".url_for('server/resolvehost/')."';
var json_checkip_url = '".url_for('server/checkip/')."';
");?>
