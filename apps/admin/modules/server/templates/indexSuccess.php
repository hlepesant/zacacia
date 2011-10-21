<?php slot('topnav') ?>
<a href="#"><?php echo __('Home') ;?></a> &raquo; 
<strong><?php echo $platform->getCn() ?></strong> &raquo;
<strong><?php echo __('Servers') ;?></strong>

<?php
if ( $platform->getZacaciaMultiServer() || ( count($servers) == 0 ) ) : ?>
<?php echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew')); ?>
<?php else: ?>
<?php echo image_tag('add_bw.png', array('title' => __('Single Server Platform'), 'id' => 'not_allowed')); ?>
<?php endif; ?>
<?php end_slot() ?>


<div id="collection">

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
