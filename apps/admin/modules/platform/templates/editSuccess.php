<?php /* use_helper('Javascript') */ ?>

<div id="form-header">
    <div id="form-header" class="section">
        <?php echo __('Edit Platform : ') ;?><?php echo $cn ?>
    </div>
</div>

<div id="form-inner">
<form action="<?php echo url_for('platform/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

<?php if ($form->hasGlobalErrors()): ?>
<ul class="form-error">
  <?php foreach ($form->getGlobalErrors() as $name => $error): ?>
    <li><?php echo $name.': '.$error ?></li>
  <?php endforeach; ?>
</ul>
<?php endif; ?>

  <?php echo $form['undeletable']->renderRow() ?>
  <?php echo $form['status']->renderRow() ?>

  <div id="form-submitline">
    <?php echo link_to( "<input type=\"button\" value=\"". __("Cancel") ."\" id=\"form-button\"  />" , "@platform") ?>
    <input type="submit" value="<?php echo __('Update') ?>" id="form-submit" />
  </div>

</form>
</div>
