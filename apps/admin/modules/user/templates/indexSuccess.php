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
var show_url = '".url_for('@company_show')."';
var new_url = '".url_for('@company_new')."';
/*
var logout_url = '".url_for('security/logout')."';
*/

var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';

var _js_msg_disable = '".__("Disable the company")."';
var _js_msg_enable = '".__("Enable the company")."';
var _js_msg_delete = '".__("Delete the company")."';
") ?>

<form action="<?php echo url_for('@platforms') ?>" method="POST" id="back_form" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>


<?php /*
<?php slot('topnav') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo;
<strong><?php echo $company->getCn() ?></strong> &raquo;
<strong><?php echo __('Users') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout', 'class' => 'tt')); ?>
<?php end_slot() ?>

<div id="collection">

    <div id="collection_menu">
        <div class="_left">
<?php echo image_tag('back.jpg', array('title' => __('Back'), 'id' => 'goback', 'class' => 'tt')); ?>
        </div>
        <div class="_right">
<?php if ( $platform->getZacaciaMultiTenant() || ( count($companies) == 0 ) ) : ?>
<?php echo image_tag('famfam/add.png', array('title' => __('Create a new user'), 'id' => 'gotonew', 'class' => 'tt')); ?>
<?php else: ?>
<?php echo image_tag('add_bw.png', array('title' => __('Not allowed. User Licence reached'), 'class' => 'tt')); ?>
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
foreach ($users as $u):
    include_partial('item', array('u' => $u, 'id' => $id, 'f' => $forms[$u->getDn()]));
    $id++;
endforeach;
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('user/new') ?>" method="POST" id="user_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<form action="<?php echo url_for('@company') ?>" method="POST" id="company_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the user")."\";
var _js_msg_02 = \"".__("Enable the user")."\";
var _js_msg_03 = \"".__("Delete the user")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
*/
?>
