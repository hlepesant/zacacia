<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('User') ?> : <?php echo $userAccount->getCn() ?>::<?php echo __('Password') ?>
    </div>
</div>

<form action="<?php echo url_for('user/password') ?>" method="POST" id="form_password" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="userPassword" class="ym-fbox-text">
<?php echo $form['userPassword']->renderRow() ?>
<p id="userPassword-message" class="ym-message">Error: invalid value!</p>
</div>

<div id="confirmPassword" class="ym-fbox-text">
<?php echo $form['confirmPassword']->renderRow() ?>
<p id="confirmPassword-message" class="ym-message">Error: invalid value!</p>
</div>

<?php /*
    <div id="form_item">
        <div class="_name"></div>
        <div class="_field"><span id="zStrength"></span></div>
    </div>
*/ ?>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __("Update") ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@users') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php /*
echo javascript_tag("
var password_i18n = new Array();
password_i18n[1] = '".__('Too weak')."'; 
password_i18n[2] = '".__('Weak')."'; 
password_i18n[3] = '".__('Medium')."'; 
password_i18n[4] = '".__('Strong')."'; 
password_i18n[5] = '".__('Very strong')."'; 
"); */?>
