<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('Group') ?>::<?php echo __('New') ?>
    </div>
</div>

<form action="<?php echo url_for('group/new') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="cn" class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
<p id="cn-message" class="ym-message">Error: invalid value!</p>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa-settings" style="display: none;">

    <div id="zarafa-email">
        <div class="ym-grid">
            <div class="ym-g30 ym-gl">
                <div id="maillabel" class="ym-fbox-text">
                <?php echo $form['mail']->renderLabel() ?>
                </div>
            </div>
            <div class="ym-g35 ym-gl">
                <div id="mail" class="ym-fbox-text z-text">
                <?php echo $form['mail']->render() ?>
                </div>
            </div>
            <div class="ym-g30 ym-gl">
                <div id="domain" class="ym-fbox-select z-select">
                <?php echo $form['domain']->render() ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaHidden']->renderRow() ?>
    </div>

</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
</div>

</form>

<form action="<?php echo url_for('@users') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_checkcn_url = '".url_for('user/checkcn/')."';
var json_checkuid_url = '".url_for('user/checkuid/')."';
var json_checkemail_url = '".url_for('user/checkemail/')."';

var full_user_quota_check = ".sfConfig::get('full_user_quota_setting').";
var quota_hard = ".sfConfig::get('quota_hard').";
var quota_soft = ".sfConfig::get('quota_soft').";
var quota_warn = ".sfConfig::get('quota_warn').";
");
?>
