
<div id="navigation">
    <div id="navigation_header">
        <div class="_title">
            <u><?php echo $p->getCn();?></u>&nbsp;&rarr;&nbsp;<?php echo __('Edit Server') ;?>
        </div>
        <!-- end #navigation_header._title -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="form_box">
<form action="<?php echo url_for('server/edit') ?>" method="POST">
<?php echo $form->renderHiddenFields() ?>


    <div id="form_item">
        <div class="_name"><?php echo $form['cn']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['cn']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkName_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <div id="form_item">
        <div class="_name"><?php echo $form['ip']->renderLabel() ?></div>
        <div class="_field"><?php echo $form['ip']->render() ?></div>
        <div class="_ajaxCheck"><div id="checkIpAddress_msg"></div></div>
    </div>
    <!-- end #form_item -->

    <?php echo $form['zarafaHttpPort']->renderRow() ?>
    <?php echo $form['zarafaSslPort']->renderRow() ?>
    <?php echo $form['zarafaContainsPublic']->renderRow() ?>
    <?php echo $form['undeletable']->renderRow() ?>
    <?php echo $form['status']->renderRow() ?>

    <div id="form_submit">
        <input type="button" value="<?php echo __("Cancel") ?>" id="button_cancel"  />
        <input type="submit" value="<?php echo __('Update') ?>" disabled="true" id="button_submit"/>
    </div>
    <!-- end #form_submit -->

</form>
</div>

<form action="<?php echo url_for('server/index') ?>" method="POST" id="server_cancel" class="invisible">
<?php echo $cancel->renderHiddenFields() ?>
</form>

<?php echo observe_field('minidata_ip', array(
  'update' => 'checkIpAddress',
  'url' => url_for('server/checkip/'),
  'method' => 'get',
  'with' => "'&ip='+getIpAddress()",
  'frequency' => '1',
  'script' => 1
))
?>

<?php echo javascript_tag("
function getIpAddress()
{
  return document.getElementById('minidata_ip').value;
}
") ?>
