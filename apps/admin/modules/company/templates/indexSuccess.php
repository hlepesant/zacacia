<?php slot('menu_top') ?>
<div class="z-menu">
    <div class="z-menu-line">
        <strong><?php echo __('Platform') ;?></strong> :
        <?php echo $platform->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Companies') ;?></strong>
    </div>
    <div class="ym-grid z-menu-line">
        <div class="ym-g40 ym-gl z-logout">
            <?php echo link_to(image_tag('famfam/door_out.png'), array(), array('id' => 'logout-link', 'confirm' => __('Quit Zacacia ?'))); ?>
        </div>
        <div class="ym-g40 ym-gr z-back">
            <?php echo image_tag('famfam/arrow_up.png', array('id' => 'back-link')); ?>
        </div>
    </div>
</div>
<?php end_slot() ?>

<div class="ym-grid z-content-header">
  <div class="ym-g70 ym-gl z-content-header-title"><?php echo __("All Companies") ?></div>
  <div class="ym-g30 ym-gr">
    <form action="<?php echo url_for('company/new') ?>" method="POST" id="company_new" class="invisible">
    <?php echo $new->renderHiddenFields(); ?>
    <input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
    </form>
  </div>
</div>

<?php
$id = 0;
foreach ($companies as $c) {
    include_partial('item', array('c' => $c, 'id' => $id, 'f' => $forms[$c->getDn()]));
    $id++;
}
?>
<!-- end #collection -->

<?php echo javascript_tag("
var new_url = '".url_for('@company_new')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the company")."';
var _js_msg_enable = '".__("Enable the company")."';
var _js_msg_delete = '".__("Delete the company")."';
") ?>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>
