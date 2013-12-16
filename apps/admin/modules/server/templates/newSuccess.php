<?php slot(
    'title',
    __("Platform".":".$platform->getCn()."::"."New")
);
?>

<?php echo form_tag('@server_new?platform='.$platform->getCn(), array('id' => 'form_new', 'class' => 'form-horizontal', 'role' => 'form' )); ?>
<?php echo $form->renderHiddenFields() ?>

<?php echo $form->render() ?>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-5">
        <button type="submit" class="btn btn-primary"><?php echo __("Create") ?></button>
        <?php echo button_to('Cancel', '@servers?platform='.$platform->getCn(), array('class' => 'btn btn-cancel')) ?>
    </div>
</div>

</form>


<?php /*
    <?php echo $form['multitenant']->renderRow() ?>
    </div>
    <div class="ym-fbox-select">
    <?php echo $form['zarafaContainsPublic']->renderRow() ?>
    </div>
</div>

<div class="ym-fbox-button">
<?php echo button_to('Cancel', '@servers?platform='.$platform->getCn(), array('class' => 'button-cancel')) ?>
<input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button-submit" />
</div>

</form>
*/ ?>

<form action="<?php echo url_for('@servers?platform='.$platform->getCn()) ?>" method="POST" id="form-cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '".url_for('server/check/')."';
var json_resolvhost_url = '".url_for('server/resolvehost/')."';
var json_checkip_url = '".url_for('server/checkip/')."';
");?>
