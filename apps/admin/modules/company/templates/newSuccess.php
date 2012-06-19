<?php slot('menu_top') ?>
<div class="z-menu">
    <div class="z-menu-line">
        <strong><?php echo __('Platform') ;?></strong> :
        <?php echo $platform->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Companies') ;?></strong> :
        <?php echo __('New') ;?>
    </div>
    <div class="ym-grid z-menu-line">
        <div class="ym-g40 ym-gl z-logout">
            <?php echo link_to(__('Logout'), 'security/logout', array('id' => 'logout-link')) ?>
        </div>
    </div>
</div>
<?php end_slot() ?>



<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Create a company') ?>
    </div>
</div>

<form action="<?php echo url_for('company/new') ?>" method="POST" id="form_new" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-fbox-text">
<?php echo $form['cn']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['zarafaAccount']->renderRow() ?>
</div>

<div id="zarafa-settings" style="display: block;">

<?php /*
    <div class="ym-fbox-select">
    <?php echo $form['zarafaCompanyServer']->renderRow() ?>
    </div>
*/ ?>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    </div>

    <div class="ym-fbox-text">
    <?php echo $form['zarafaQuotaWarn']->renderRow() ?>
    </div>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    </div>

    <div class="ym-fbox-select">
    <?php echo $form['zarafaUserDefaultQuotaOverride']->renderRow() ?>
    </div>

    <div id="zarafa-userdefaultquota" style="display: block;">
        <div class="ym-fbox-text">
        <?php echo $form['zarafaUserDefaultQuotaHard']->renderRow() ?>
        </div>
        <div class="ym-fbox-text">
        <?php echo $form['zarafaUserDefaultQuotaSoft']->renderRow() ?>
        </div>
        <div class="ym-fbox-text">
        <?php echo $form['zarafaUserDefaultQuotaWarn']->renderRow() ?>
        </div>
    </div>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@company') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('company/check/')."';
");?>
