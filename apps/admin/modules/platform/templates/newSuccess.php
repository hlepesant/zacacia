<?php slot(
    'title',
    __("Platform"."::"."New")
);
?>

<form action="<?php echo url_for('platform/new') ?>" method="POST" id="form_new" class="form-horizontal" role="form">
<?php echo $form->renderHiddenFields() ?>

<?php echo $form->render() ?>
<?php // echo $form['cn']->renderRow() ?>
<?php // echo $form['multitenant']->renderRow() ?>
<?php // echo $form['multiserver']->renderRow() ?>
<?php // echo $form['status']->renderRow() ?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <button type="submit" class="btn btn-primary"><?php echo __("Create") ?></button>
        <!-- button type="cancel" class="btn btn-cancel"><?php echo __("Cancel") ?></button -->
        <?php echo button_to('Cancel', '@platforms', array('class' => 'btn btn-cancel')) ?>
    </div>
</div>

</form>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('@platform_check_cn')."';
");?>
