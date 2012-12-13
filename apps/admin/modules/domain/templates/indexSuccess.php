<?php /* slot('menu_top') ?>
<div class="z-menu">
    <div class="z-menu-line">
        <strong><?php echo __('Platform') ;?></strong> :
        <?php echo $platform->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Company') ;?></strong> :
        <?php echo $company->getCn() ?>
    </div>
    <div class="z-menu-line">
        <strong><?php echo __('Domains') ;?></strong>
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
<?php end_slot() */ ?>

<div class="ym-grid z-content-header">
    <div class="ym-g70 ym-gl z-content-header-title" id="back-link">
    <?php echo __('Platform') ;?> : <?php echo $platform->getCn() ?> &rarr;
    <?php echo __('Company') ;?> : <?php echo $company->getCn() ?> &rarr;
    <?php echo __("Domains") ?>
    </div>
    <div class="ym-g30 ym-gr">
    	<form action="<?php echo url_for('domain/new') ?>" method="POST" id="domain_new">
    	<?php echo $new->renderHiddenFields(); ?>
    	<input type="submit" value="<?php echo __("New") ?>" class="ym-button z-button-new" />
    	</form>
    </div>
</div>

<?php
$id = 0;
foreach ($domains as $d) {
    include_partial('item', array('d' => $d, 'id' => $id, 'f' => $forms[$d->getDn()]));
    $id++;
}
?>

<?php echo javascript_tag("
var _js_msg_disable = '".__("Disable the domain")."';
var _js_msg_enable = '".__("Enable the domain")."';
var _js_msg_delete = '".__("Delete the domain")."';
") ?>

<form action="<?php echo url_for('@companies') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the domain")."\";
var _js_msg_02 = \"".__("Enable the domain")."\";
var _js_msg_03 = \"".__("Delete the domain")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
