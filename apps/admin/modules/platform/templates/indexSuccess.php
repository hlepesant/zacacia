<?php slot('menu_top') ?>
<strong><?php echo __('Platforms') ;?></strong>
<?php echo image_tag('famfam/door_in.png', array('title' => __('Logout'), 'id' => 'logout', 'class' => 'tt')); ?>
<?php end_slot() ?>


<?php slot('menu_content') ?>
<?php echo form_tag('@platform_show', array('id' => 'navForm')) ?>
<?php echo $navigation->renderHiddenFields() ?>
<?php echo $navigation ?>
</form>
<?php /* include_partial('security/navigation', array('navigation' => $navigation)) */ ?>
<?php end_slot() ?>


<?php slot('menu_bottom') ?>
<input type="button" value="<?php echo __("Logout") ?>" id="logout" class="button_logout" />
<?php end_slot() ?>


<div id="collection">
    <div id="collection_menu">
        <div class="right">
            <?php /* echo image_tag('famfam/add.png', array('title' => __('New'), 'id' => 'gotonew')); */ ?>
            <input type="button" value="<?php echo __("New") ?>" id="gotonew" class="button_new" />
        </div>
    </div>
    <!-- end #collection_menu -->

    <div id="statistics">
    </div>
    <!-- end #statistics -->

</div>
<!-- end #collection -->
<?php /*
<form action="<?php echo url_for('platform/new') ?>" method="POST" id="platform_new" class="invisible">
echo $new->renderHiddenFields()
</form>
*/
?>

<?php echo javascript_tag("
var show_url = '".url_for('@platform_show')."';
var new_url = '".url_for('@platform_new')."';
var logout_url = '".url_for('security/logout')."';
") ?>
