<div id="section_zarafa">

    <div id="form_sub_section">
        <h1><?php echo $form['zarafaAccount']->renderLabel() ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->
    <div id="form_item">
        <div class="_name"><?php echo $form['mail']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['mail']->render() ?>@<?php echo $form['domain']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_mail"></div></div>
    </div>
    <!-- end #form_item -->
    <div id="zarafa_settings" style="display: none;">
        <?php echo $form['zarafaAdmin']->renderRow() ?>
        <?php echo $form['zarafaHidden']->renderRow() ?>
        <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
        <div id="quota_setting" style="display:none;">
        <?php /* echo $form['zarafaQuotaWarn']->renderRow() */ ?>
        <?php /* echo $form['zarafaQuotaSoft']->renderRow() */ ?>
        <?php echo $form['zarafaQuotaHard']->renderRow() ?>
        </div>
    </div>
    
    <div id="form_submit">
        <input type="button" value="<?php echo __('Previous') ?>" id="back_section_userinfo" class="button_previous" />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
    </div>
    <!-- end #form_submit -->
</div>

