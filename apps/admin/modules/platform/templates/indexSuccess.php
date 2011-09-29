<?php slot('topnav') ?>
<?php echo __('Platforms') ;?>
<?php end_slot() ?>


<div id="navigation">
    <div id="navigation_header">
        <div class="_link">
            <?php echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew')); ?>
        </div>
        <!-- end #navigation_header._link -->
    </div>
    <!-- end #navigation_header -->
</div>
<!-- end #navigation -->

<div id="collection">

    <div id="collection_description">
            <div class="_name"><?php echo __("Name") ?></div>
            <div class="_action"><?php echo __("Actions") ?></div>
    </div>
    <!-- end #collection_description -->

    <div id="collection_enumerate">
<?php
$id = 0;
foreach ($platforms as $p) {
    include_partial('item', array('p' => $p, 'id' => $id, 'f' => $forms[$p->getDn()]));
    $id++;
}
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('platform/new') ?>" method="POST" id="platform_new" class="invisible">
<?php echo $new->renderHiddenFields() ?>
</form>

<?php echo javascript_tag("
var _js_msg_01 = '".__("Disable the platform")."';
var _js_msg_02 = '".__("Enable the platform")."';
var _js_msg_03 = '".__("Delete the platform")."';
var _js_module = '".$this->getModuleName()."';
var _js_url = '".url_for(false)."';
") ?>
