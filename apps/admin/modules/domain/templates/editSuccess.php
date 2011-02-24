<?php use_helper('Javascript') ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('Edit Domain') ;?>
    </div>
</div>

<div id="form-inner">

<form action="<?php echo url_for('domain/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

    <div id="form-line">
        <div id="form-line" class="item"><?php echo __('Name'); ?></div>
        <div id="form-line" class="field"><?php echo $cn; ?></div>
    </div>
    
  <?php echo $form['undeletable']->renderRow() ?>
  <?php echo $form['status']->renderRow() ?>

    <div id="form-submitline">
        <?php echo link_to_function( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "$('domain_cancel').submit()") ?>
        <input type="submit" value="<?php echo __('Update') ?>" id="form-submit" />
    </div>

</form>
</div>

<form action="<?php echo url_for('domain/index') ?>" method="POST" id="domain_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>
