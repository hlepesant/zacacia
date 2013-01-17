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
foreach ($platforms as $platform) {
    #include_partial('item', array('platform' => $platform, 'id' => $id, 'f' => $forms[$platform->getDn()]));
    include_partial('item', array('platform' => $platform, 'id' => $id));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
var _js_msg_disable = '".__("Disable the platform")."';
var _js_msg_enable = '".__("Enable the platform")."';
var _js_msg_delete = '".__("Delete the platform")."';
") ?>

