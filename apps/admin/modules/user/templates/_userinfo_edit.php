<div id="section_userinfo">

    <div id="form_header">
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
    <?php /* echo $form['status']->renderRow() */ ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __('Cancel') ?>" class="button_cancel" />
        <input type="submit" value="<?php echo __('Next') ?>" disabled="true" id="goto_section_zarafa" class="button_submit" />
    </div>
    <!-- end #form_submit -->
</div>
