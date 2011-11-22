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

<?php echo javascript_tag("
var _js_msg_01 = \"".__("Disable the domain")."\";
var _js_msg_02 = \"".__("Enable the domain")."\";
var _js_msg_03 = \"".__("Delete the domain")."\";
var _js_module = \"".$this->getModuleName()."\";
var _js_url = '".url_for(false)."';
") ?>
