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

<form action="<?php echo url_for('@platform') ?>" method="POST" id="platform_back" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = '".__("Disable the host")."';
var _js_msg_02 = '".__("Enable the host")."';
var _js_msg_03 = '".__("Delete the host")."';
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
") ?>
