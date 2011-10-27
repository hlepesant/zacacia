<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo $company->getCn() ?></strong> &raquo; 
<strong><?php echo __('Users') ;?></strong>
<?php end_slot() ?>


<div id="form_box">
<form action="<?php echo url_for('user/edit') ?>" method="POST" id="userform">
<?php echo $form->renderHiddenFields() ?>

<?php include_partial('userinfo_edit', array('form' => $form)) ?>
<?php include_partial('zarafa_edit', array('form' => $form)) ?>

</form>
</div>
<!-- end #form_box -->

<form action="<?php echo url_for('user/index') ?>" method="POST" id="form_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php
echo javascript_tag("
var json_checkcn_url = '".url_for('user/checkcn/')."';
var json_checkuid_url = '".url_for('user/checkuid/')."';
var password_i18n = new Array();
password_i18n[1] = '".__('Too weak')."'; 
password_i18n[2] = '".__('Weak')."'; 
password_i18n[3] = '".__('Medium')."'; 
password_i18n[4] = '".__('Strong')."'; 
password_i18n[5] = '".__('Very strong')."'; 
");?>
