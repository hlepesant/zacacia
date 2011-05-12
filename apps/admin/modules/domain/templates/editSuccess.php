<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;
            <u><?php echo $company->getCn();?></u>&nbsp;&rarr;&nbsp;
            <u><?php echo $domain->getCn();?></u>&nbsp;&rarr;&nbsp;
            <?php echo __('Edit') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('domain/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel" />
        <input type="submit" value="<?php echo __('Save') ?>" id="button_submit" />
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('domain/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
