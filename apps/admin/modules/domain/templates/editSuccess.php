<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo $company->getCn() ?></strong> &raquo; 
<strong><?php echo __('Domains') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('domain/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php printf("%s : %s", __('Edit domain'), $domain->getCn( ))?></h1>
    </div>

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Save') ?>" class="button_submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('domain/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
