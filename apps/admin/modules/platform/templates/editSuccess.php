<?php slot(
    'title',
    __("Platform"."::"."Edit")
);
?>

<form action="<?php echo url_for('platform/edit?platform='.$platform->getCn()) ?>" method="POST" id="form_edit" class="form-horizontal" role="form">
<?php echo $form->renderHiddenFields() ?>

<?php echo $form->render() ?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <button type="submit" class="btn btn-primary"><?php echo __("Update") ?></button>
        <button type="cancel" class="btn btn-cancel"><?php echo __("Cancel") ?></button>
    </div>
</div>

</form>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('platform/check/')."';
");?>
