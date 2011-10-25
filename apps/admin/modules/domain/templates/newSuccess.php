<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo $company->getCn() ?></strong> &raquo; 
<strong><?php echo __('Domains') ;?></strong>
<?php end_slot() ?>

<div id="form_box">
<form action="<?php echo url_for('domain/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Create a domain') ?></h1>
    </div>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" class="button_cancel"  />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit"/>
    </div>
    <!-- end #form_submit -->
</form>
</div>

<form action="<?php echo url_for('@domain') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('domain/check/')."';
");?>
