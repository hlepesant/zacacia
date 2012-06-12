<?php slot('menu_top') ?>
<div class="z-menu">
<div class="z-menu-line">
    <strong><?php echo __('Platforms') ;?></strong>
</div>
<div class="z-menu-line">
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout')); ?>
</div>
</div>
<?php end_slot() ?>

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
