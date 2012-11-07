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
