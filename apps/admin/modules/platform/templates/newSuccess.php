<?php slot(
    'title',
    __("Platforms"."::"."New")
);
?>

<form action="<?php echo url_for('platform/new') ?>" method="POST" id="form_new" class="form-horizontal" role="form">
<?php echo $form->renderHiddenFields() ?>

    <?php /* echo $form->render() */ ?>

<?php /*
<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo __('Name') ?></label>
    <div class="col-sm-4">
        <?php echo $form['cn']->render() ?>
    </div>
</div>
 */ ?>

<?php /*
<div class="form-group">
    <?php echo $form['cn']->renderLabel( $form['cn']->getValue(), array('class' => 'col-sm-2 control-label')) ?>
    <div class="col-sm-4">
        <?php echo $form['cn']->render() ?>
    </div>
</div>
 */ ?>
<?php echo $form['cn']->renderRow() ?>

<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo __('Multitenant') ?></label>
    <div class="col-sm-4">
        <?php echo $form['multitenant']->render() ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo __('Multi Server') ?></label>
    <div class="col-sm-4">
        <?php echo $form['multiserver']->render() ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"><?php echo __('Status') ?></label>
    <div class="col-sm-4">
        <?php echo $form['status']->render() ?>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary"><?php echo __("Create") ?></button>
        <button type="cancel" class="btn btn-cancel"><?php echo __("Cancel") ?></button>
    </div>
</div>

</form>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('@platform_check_cn')."';
");?>
