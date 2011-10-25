<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo; 
<strong><?php echo $company->getCn() ?></strong> &raquo; 
<strong><?php echo __('Users') ;?></strong>
<?php end_slot() ?>


<div id="form_box">
<form action="<?php echo url_for('user/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_header">
        <h1><?php echo __('Create a user') ?></h1>
    </div>

    <div id="form_sub_section">
        <h1><?php echo __('User Info') ?></h1>
    </div>

    <?php echo $form['sn']->renderRow() ?>
    <div id="form_item">
        <div class="_name"><?php echo $form['givenName']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['givenName']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->
    <div id="form_item">
        <div class="_name"><?php echo $form['displayName']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['displayName']->render() ?></div>
        <div class="_ajaxSwitch" id="imgSwitch">
            <?php echo image_tag('famfam/arrow_refresh.png', array('title' => __('Switch'), 'id' => 'switch')) ?>
        </div>
    </div>
    <!-- end #form_item -->
    <div id="form_item">
        <div class="_name"><?php echo $form['uid']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['uid']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkUid_msg"></div></div>
    </div>
    <!-- end #form_item -->
    <div id="form_item">
        <div class="_name"><?php echo $form['userPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['userPassword']->render() ?></div>
        <div class="_ajaxCheck"><div id="pmeter"></div></div>
    </div>
    <!-- end #form_item -->
    <div id="form_item">
        <div class="_name"><?php echo $form['confirmPassword']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['confirmPassword']->render() ?></div>
        <div class="_ajaxCheck"><div id="pequality"></div></div>
    </div>
    <!-- end #form_item -->
    <?php /* echo $form['status']->renderRow() */ ?>
    <?php /* echo $form['undeletable']->renderRow() */ ?>
    <div id="form_submit">
        <input type="button" value="<?php echo __('Cancel') ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Next') ?>" disabled="true" id="goto_section_zarafa" class="button_submit" />
    </div>
    <!-- end #form_submit -->
  </div>

  <div id="section_zarafa">
    <div id="form_sub_section">
        <div class="_title"><?php echo $form['zarafaAccount']->renderLabel() ?></div>
    </div>
    <!-- end #form_section -->
    <?php echo $form['zarafaAdmin']->renderRow() ?>
    <?php echo $form['zarafaHidden']->renderRow() ?>
    <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
    <?php /* echo $form['zarafaQuotaWarn']->renderRow() */ ?>
    <?php /* echo $form['zarafaQuotaSoft']->renderRow() */ ?>
    <?php echo $form['zarafaQuotaHard']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __('Back') ?>" id="back_section_user" class="button_cancel" />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
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
var json_checkcn_url = '".url_for('user/checkcn/')."';
var json_checkuid_url = '".url_for('user/checkuid/')."';
var password_i18n = new Array();
password_i18n[1] = '".__('Too weak')."'; 
password_i18n[2] = '".__('Weak')."'; 
password_i18n[3] = '".__('Medium')."'; 
password_i18n[4] = '".__('Strong')."'; 
password_i18n[5] = '".__('Very strong')."'; 
");?>
