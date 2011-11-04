<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo $company->getCn() ?></strong> &raquo; 
<strong><?php echo __('Users') ;?></strong>
<?php end_slot() ?>


<div id="form_box">
<form action="<?php echo url_for('user/password') ?>" method="POST" id="passwordform">
<?php echo $form->renderHiddenFields() ?>

<div id="section_userinfo">

    <div id="form_header">
        <h1><?php echo __('User Password') ?></h1>
    </div>

    <div id="form_item">
        <div class="_name"><?php echo $form['userPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['userPassword']->render() ?></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"></div>
        <div class="_field"><span id="zStrength"></span></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"><?php echo $form['confirmPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['confirmPassword']->render() ?></div>
        <div class="_ajaxCheck"><div id="pequality"></div></div>
    </div>

    <div id="form_submit">
        <input type="button" value="<?php echo __('Cancel') ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Change') ?>" disabled="true" class="button_submit" />
    </div>
    <!-- end #form_submit -->
</div>

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('user/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var password_i18n = new Array();
password_i18n[1] = '".__('Too weak')."'; 
password_i18n[2] = '".__('Weak')."'; 
password_i18n[3] = '".__('Medium')."'; 
password_i18n[4] = '".__('Strong')."'; 
password_i18n[5] = '".__('Very strong')."'; 
");?>
