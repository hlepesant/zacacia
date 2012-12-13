<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('User') ?> : <?php echo $userAccount->getCn() ?> &rarr;
        <?php echo __('Aliases') ?>
    </div>
</div>



<?php
$id = 0;
foreach ($aliases as $alias) {
    include_partial('alias', array('alias' => $alias, 'id' => $id, 'form' => $forms[$alias]));
    $id++;
}
?>
<!-- end #collection -->


<form action="<?php echo url_for('user/aliases') ?>" method="POST" id="form_aliases" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="userPassword" class="ym-fbox-text">
<?php echo $form['userPassword']->renderRow() ?>
<p id="userPassword-message" class="ym-message">Error: invalid value!</p>
</div>

<div id="confirmPassword" class="ym-fbox-text">
<?php echo $form['confirmPassword']->renderRow() ?>
<p id="confirmPassword-message" class="ym-message">Error: invalid value!</p>
</div>

<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __("Update") ?>" disabled="true" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@users') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>
