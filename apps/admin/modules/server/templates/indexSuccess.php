<?php /*

<?php slot('topnav') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo;
<strong><?php echo __('Servers') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout', 'class' => 'tt')); ?>
<?php end_slot() ?>

<div id="collection">

    <div id="collection_menu">
        <div class="_left">
<?php echo image_tag('back.jpg', array('title' => __('Back'), 'id' => 'goback', 'class' => 'tt')); ?>
        </div>
        <div class="_right">
<?php if ( $platform->getZacaciaMultiServer() || ( count($servers) == 0 ) ) : ?>
<?php echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew', 'class' => 'tt')); ?>
<?php else: ?>
<?php echo image_tag('add_bw.png', array('title' => __('Single Server Platform'), 'id' => 'not_allowed', 'class' => 'tt')); ?>
<?php endif; ?>
        </div>
    </div>
    <!-- end #collection_menu -->

    <div id="collection_description">
        <div class="_name"><?php echo __("Name") ?></div>
        <div class="_action"><?php echo __("Action") ?></div>
    </div>
    <!-- end #collection_description -->

    <div id="collection_enumerate">
<?php
$id = 0;
foreach ($servers as $s) {
    include_partial('item', array('s' => $s, 'id' => $id, 'f' => $forms[$s->getDn()]));
    $id++;
}
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('server/new') ?>" method="POST" id="server_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="platform_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = '".__("Disable the host")."';
var _js_msg_02 = '".__("Enable the host")."';
var _js_msg_03 = '".__("Delete the host")."';
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
") ?>
*/
?>
<?php /* slot('menu_top') ?>
<strong><?php echo __('Platforms') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout')); ?>
<?php end_slot() */ ?>

<?php /* slot('menu_content') ?>
<?php echo form_tag('@platform_show', array('id' => 'navForm')) ?>
<?php echo $navigation->renderHiddenFields() ?>
<?php echo $navigation ?>
</form>
<?php end_slot() */ ?>


<?php slot('menu_bottom') ?>
<input type="button" value="<?php echo __("Logout") ?>" id="logout" class="button_logout" />
<?php end_slot() ?>

<div class="ym-grid z-content-header">
  <div class="ym-g70 ym-gl z-content-header-title"><?php echo __("Servers") ?></div>
  <div class="ym-g30 ym-gr">
    <form action="<?php echo url_for('server/new') ?>" method="POST" id="server_new" class="invisible">
    <?php echo $new->renderHiddenFields(); ?>
    <input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
    </form>
  </div>
</div>

<?php
$id = 0;
foreach ($servers as $s) {
    include_partial('item', array('s' => $s, 'id' => $id, 'f' => $forms[$s->getDn()]));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
var new_url = '".url_for('@server_new')."';
var logout_url = '".url_for('security/logout')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the server")."';
var _js_msg_enable = '".__("Enable the server")."';
var _js_msg_delete = '".__("Delete the server")."';
") ?>
