<?php slot('menu_top') ?>
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
            <?php echo link_to(__('Logout'), 'security/logout', array('id' => 'logout-link')) ?>
        </div>
        <div class="ym-g40 ym-gr z-back">
            <?php echo link_to(__('Back'), '@companies', array('id' => 'back-link')) ?>
        </div>
    </div>
</div>
<?php end_slot() ?>

<div class="ym-grid z-content-header">
  <div class="ym-g70 ym-gl z-content-header-title"><?php echo __("Domains") ?></div>
  <div class="ym-g30 ym-gr">
    <form action="<?php echo url_for('domain/new') ?>" method="POST" id="domain_new" class="invisible">
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
<!-- end #collection -->

<?php echo javascript_tag("
var new_url = '".url_for('@domain_new')."';
var logout_url = '".url_for('security/logout')."';

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the domain")."';
var _js_msg_enable = '".__("Enable the domain")."';
var _js_msg_delete = '".__("Delete the domain")."';
") ?>

<form action="<?php echo url_for('@companies') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>



<?php /*
<?php slot('topnav') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo;
<strong><?php echo $company->getCn() ?></strong> &raquo;
<strong><?php echo __('Domains') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout', 'class' => 'tt')); ?>
<?php end_slot() ?>

<div id="collection">

    <div id="collection_menu">
        <div class="_left">
<?php echo image_tag('back.jpg', array('title' => __('Back'), 'id' => 'goback', 'class' => 'tt')); ?>
        </div>
        <div class="_right">
<?php echo image_tag('famfam/add.png', array('title' => __('Create a new domain'), 'id' => 'gotonew', 'class' => 'tt')); ?>
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
foreach ($domains as $d) {
    include_partial('item', array('d' => $d, 'id' => $id, 'f' => $forms[$d->getDn()]));
    $id++;
}
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('domain/new') ?>" method="POST" id="domain_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@company') ?>" method="POST" id="company_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

*/
?>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the domain")."\";
var _js_msg_02 = \"".__("Enable the domain")."\";
var _js_msg_03 = \"".__("Delete the domain")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
