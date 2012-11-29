<?php slot('menu_top') ?>
<div class="z-menu">
    <div class="z-menu-line">
        <strong><?php echo __('Platform') ;?></strong> :
        <?php echo $platform->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Company') ;?></strong> :
        <?php echo $company->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Users') ;?></strong> :
        <?php echo __('New') ;?>
    </div>
    <div class="ym-grid z-menu-line">
        <div class="ym-g40 ym-gl z-logout">
            <?php echo link_to(__('Logout'), 'security/logout', array('id' => 'logout-link', 'confirm' => __('Quit Zacacia ?'))) ?>
        </div>
    </div>
</div>
<?php end_slot() ?>

<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Add an user') ?>
    </div>
</div>

<form action="<?php echo url_for('user/new') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-grid">

    <div class="ym-g50 ym-gl">
        <div id="sn" class="ym-fbox-text">
        <?php echo $form['sn']->renderRow() ?>
        <p id="sn-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

    <div class="ym-g50 ym-gr">
        <div id="givenName" class="ym-fbox-text">
        <?php echo $form['givenName']->renderRow() ?>
        <p id="givenName-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

    <div class="ym-g50 ym-gl">
        <div id="displayName" class="ym-fbox-text">
        <?php echo $form['displayName']->renderRow() ?>
        <p id="displayName-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

    <div class="ym-g50 ym-gr">
        <div id="uid" class="ym-fbox-text">
        <?php echo $form['uid']->renderRow() ?>
        <p id="uid-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

    <div class="ym-g50 ym-gl">
        <div id="userPassword" class="ym-fbox-text">
        <?php echo $form['userPassword']->renderRow() ?>
        <p id="userPassword-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

    <div class="ym-g50 ym-gr">
        <div id="confirmPassword" class="ym-fbox-text">
        <?php echo $form['confirmPassword']->renderRow() ?>
        <p id="confirmPassword-message" class="ym-message">Error: invalid value!</p>
        </div>
    </div>

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
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    </div>

    <div id="zarafa-settings-zarafaquotawarn" style="display: none;">
        <div class="ym-grid">
            <div class="ym-g30 ym-gl ym-fbox-text z-label"> <?php echo __('Quotas') ?> </div>
            <div class="ym-g20 ym-gl"><?php echo $form['zarafaQuotaHard']->renderLabel() ?></div>
<?php if ( sfConfig::get('full_user_quota_setting') ): ?>
            <div class="ym-g20 ym-gl"><?php echo $form['zarafaQuotaSoft']->renderLabel() ?></div>
            <div class="ym-g20 ym-gl"><?php echo $form['zarafaQuotaWarn']->renderLabel() ?></div>
<?php endif; ?>
        </div>

        <div class="ym-grid">
            <div class="ym-g40 ym-gl z-label">&nbsp;</div>
            <div class="ym-g20 ym-gl">
                <div id="zarafa-quota-hard">
                    <div class="ym-fbox-text z-option">
                    <?php echo $form['zarafaQuotaHard']->render() ?>
                    </div>
                </div>
            </div>
<?php if ( sfConfig::get('full_user_quota_setting') ): ?>
            <div class="ym-g20 ym-gl">
                <div id="zarafa-quota-soft">
                    <div class="ym-fbox-text z-option">
                    <?php echo $form['zarafaQuotaSoft']->render() ?>
                    </div>
                </div>
            </div>
            <div class="ym-g20 ym-gl">
                <div id="zarafa-quota-warn">
                    <div class="ym-fbox-text z-option">
                    <?php echo $form['zarafaQuotaWarn']->render() ?>
                    </div>
                </div>
            </div>
<?php endif; ?>
        </div>
    </div>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaAdmin']->renderRow() ?>
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
