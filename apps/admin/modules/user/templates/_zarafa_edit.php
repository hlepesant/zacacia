<div id="section_zarafa">

    <div id="form_sub_section">
        <h1><?php echo __('Zarafa Settings') ?>
        <span class="_field"><?php echo $form['zarafaAccount']->render() ?></span>
        </h1>
    </div>
    <!-- end #form_section -->

    <div id="zarafa_settings" style="display: <?php echo ($zuser->getZarafaAccount() ? 'block' : 'none' ) ?>;">
        <?php echo $form['zarafaAdmin']->renderRow() ?>
        <?php echo $form['zarafaHidden']->renderRow() ?>
        <?php echo $form['zarafaQuotaOverride']->renderRow() ?>
        <div id="quota_setting" style="display:none;">
        <?php echo $form['zarafaQuotaHard']->renderRow() ?>
        </div>
    </div>
    
    <div id="form_submit">
        <input type="button" value="<?php echo __('Previous') ?>" id="back_section_userinfo" class="button_previous" />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" class="button_submit" />
    </div>
    <!-- end #form_submit -->
</div>

