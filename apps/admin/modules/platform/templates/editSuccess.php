<?php
/*
<?php slot('topnav') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo __('Platforms') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('platform/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Edit Platform') ;?> : <?php echo $platform->getCn(); ?></h1>
    </div>

    <?php echo $form['multitenant']->renderRow() ?>
    <?php echo $form['multiserver']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel"  />
        <input type="submit" value="<?php echo __('Update') ?>" class="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
*/
?>

<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Edit platform') ?>
    </div>
    <div class="ym-g30 ym-gr">
        <input type="button" value="<?php echo __("Cancel") ?>" class="ym-button z-button-cancel" />
    </div>
</div>


<form action="<?php echo url_for('platform/edit') ?>" method="POST" id="form_edit" class="ym-form">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-fbox-select">
<?php echo $form['multitenant']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['multiserver']->renderRow() ?>
</div>

<div class="ym-fbox-select">
<?php echo $form['status']->renderRow() ?>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>

</div>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('platform/check/')."';
");?>
