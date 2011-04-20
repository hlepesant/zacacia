<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <?php echo __('Edit Platform') ;?> : <?php echo $platform->getCn(); ?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('platform/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['multitenant']->renderRow() ?>
    <?php echo $form['multiserver']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel"  />
        <input type="submit" value="<?php echo __('Update') ?>" id="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('@platform') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
