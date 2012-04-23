<?php slot('menu_top') ?>
<?php echo __('Home') ;?> &raquo; 
<strong><?php echo __('Platforms') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout', 'class' => 'tt')); ?>
<?php end_slot() ?>


<?php slot('menu_content') ?>
<?php echo form_tag('@platform_show', array('id' => 'navForm')) ?>
<?php echo $navigation->renderHiddenFields() ?>
<?php echo $navigation ?>
</form>
<?php end_slot() ?>


<?php slot('menu_bottom') ?>
<?php echo link_to( __('Logout'), 'security/logout'); ?>
<?php end_slot() ?>


<div id="collection">
    <div id="collection_menu">
        <div class="_right">
            <?php echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew')); ?>
        </div>
    </div>
    <!-- end #collection_menu -->

    <div id="collection_description">
        <div class="_name"><?php echo __("Name") ?></div>
        <div class="_action"><?php echo __("Actions") ?></div>
    </div>
    <!-- end #collection_description -->

    <div id="statistics">
<?php
/*
$id = 0;
foreach ($platforms as $p) {
    include_partial('item', array('p' => $p, 'id' => $id, 'f' => $forms[$p->getDn()]));
    $id++;
}
*/
?>
    </div>
    <!-- end #collection_enumerate -->

</div>
<!-- end #collection -->

<form action="<?php echo url_for('platform/new') ?>" method="POST" id="platform_new" class="invisible">
<?php /* echo $new->renderHiddenFields() */ ?>
</form>

<?php echo javascript_tag("
var create_url = '".url_for('@platform_new')."';
var show_url = '".url_for('@platform_show')."';
") ?>
