<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; <strong><?php echo __('Platforms') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('platform/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Edit Platform') ;?> : <?php echo $platform->getCn(); ?></h1>
    </div>

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['multitenant']->renderRow() ?>
    <?php /* echo $form['multiserver']->renderRow() */ ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel"  />
        <input type="submit" value="<?php echo __('Update') ?>" class="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('@platform') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
