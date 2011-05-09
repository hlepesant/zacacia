<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $platform->getCn();?></u>&nbsp;&rarr;&nbsp;
            <u><?php echo $company->getCn();?></u>&nbsp;&rarr;&nbsp;
            <?php echo __('New Domain') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('domain/new') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>

    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['status']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel"  />
        <input type="submit" value="<?php echo __('Create') ?>" disabled="true" id="button_submit"/>
    </div>
    <!-- end #form_submit -->
</form>
</div>

<form action="<?php echo url_for('@domain') ?>" method="POST" id="form_cancel">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var json_check_url = '". url_for('domain/check/')."';
");?>

<?php /* echo observe_field('minidata_cn', array(
  'update' => 'checkName',
  'url' => url_for('domain/check/'),
  'method' => 'get',
  'with' => "'&name='+$('minidata_cn').value",
  'frequency' => '1',
  'script' => 1
)) */
?>
