<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title">
        <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
        <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
        <?php echo __('User') ?> : <?php echo $userAccount->getCn() ?> &rarr;
        <?php echo __('Aliases') ?>
    </div>
</div>



<form action="<?php echo url_for('user/aliases') ?>" method="POST" id="form_aliases" class="ym-form ym-columnar">
<?php echo $form->renderHiddenFields() ?>

<div id="zarafaAliases" class="ym-fbox-check">

<div class="ym-grid">
    <div class="ym-g75 ym-gl za-line za-selectAll"><?php echo $form['zarafaAliases']->renderLabel() ?></div>
    <div class="ym-g20 ym-gl za-liner za-selectAll"><?php echo $form['selectAll']->render() ?></div>
    <?php echo $form['zarafaAliases']->render() ?>
</div>

<div class="ym-grid">
    <div class="ym-g33 ym-gl">
        <div id="maillabel" class="ym-fbox-text">
        <?php echo $form['mail']->renderLabel() ?>
        </div>
    </div>
    <div class="ym-g33 ym-gl">
        <div id="mail" class="ym-fbox-text z-text">
        <?php echo $form['mail']->render() ?>
        </div>
    </div>
    <div class="ym-g33 ym-gl">
        <div id="domain" class="ym-fbox-select z-select">
        <?php echo $form['domain']->render() ?>
        </div>
    </div>
</div>


<div class="ym-fbox-button">
<input type="button" value="<?php echo __("Cancel") ?>" class="button-cancel" />
<input type="submit" value="<?php echo __("Validate") ?>" class="button-submit" />
</div>

</form>

<form action="<?php echo url_for('@users') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>
