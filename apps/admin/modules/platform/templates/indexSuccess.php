<?php slot('menu_top') ?>
<div class="z-menu">
<div class="z-menu-line">
    <strong><?php echo __('Platforms') ;?></strong>
</div>
<div class="z-menu-line">
<?php echo link_to(__('Logout'), 'security/logout', array('id' => 'logount-link')) ?>
</div>
</div>
<?php end_slot() ?>



<?php slot('menu_bottom') ?>
<input type="button" value="<?php echo __("Logout") ?>" id="logout" class="button_logout" />
<?php end_slot() ?>

<div class="ym-grid z-content-header">
  <div class="ym-g70 ym-gl z-content-header-title"><?php echo __("Platforms") ?></div>
  <div class="ym-g30 ym-gr">
    <form action="<?php echo url_for('platform/new') ?>" method="POST" id="platform_new" class="invisible">
    <?php echo $new->renderHiddenFields(); ?>
    <input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
    </form>
  </div>
</div>

<?php
$id = 0;
foreach ($platforms as $p) {
    include_partial('item', array('p' => $p, 'id' => $id, 'f' => $forms[$p->getDn()]));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
var show_url = '".url_for('@platform_show')."';
var new_url = '".url_for('@platform_new')."';
var logout_url = '".url_for('security/logout')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the platform")."';
var _js_msg_enable = '".__("Enable the platform")."';
var _js_msg_delete = '".__("Delete the platform")."';
") ?>
