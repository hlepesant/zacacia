<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('User') ?> : <?php echo $userAccount->getCn() ?>::<?php echo __('Edit') ?>
    </div>
</div>

<form action="<?php echo url_for('user/edit') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
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

</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa-settings" style="display: <?php echo $showZarafaSetting ?>;">

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

    <div id="zarafa-settings-zarafaquotawarn" style="display: <?php echo $showZarafaQuotaSetting ?>;">
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
<input type="submit" value="<?php echo __('Update') ?>" class="button_submit" />
</div>


</form>

<form action="<?php echo url_for('user/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_checkemail_url = '".url_for('user/checkemailforupdate/')."';

var full_user_quota_check = ".sfConfig::get('full_user_quota_setting').";
var quota_hard = ".$userAccount->getZarafaQuotaHard().";
var quota_soft = ".$userAccount->getZarafaQuotaSoft().";
var quota_warn = ".$userAccount->getZarafaQuotaWarn().";
");?>
