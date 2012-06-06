<div class="ym-wbox">

  <div class="z-logo">
    <?php echo image_tag('zacacia_logo_w.png', array('class' => 'z-logo-img')) ?>
  </div>

<form class="ym-form ym-full" method="post">
<?php echo $form->renderHiddenFields() ?>

<div class="ym-fbox-text">
  <?php echo $form['username']->renderRow() ?>
</div>

<div class="ym-fbox-text">
  <?php echo $form['password']->renderRow() ?>
</div>

<div class="ym-fbox-button">
  <input type="submit" class="ym-button" value="submit" id="submit" name="submit" />
</div>

</form>

</div>
