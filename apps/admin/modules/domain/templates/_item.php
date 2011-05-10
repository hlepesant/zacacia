<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>

    <div class="_name_<?php echo $d->getZacaciaStatus() ?>"><?php echo $d->getCn() ?></div>
    <!-- end #line._name_ -->

    <div class="_actions">
<?php
/* Status */
echo link_to_function(
    image_tag('famfam/arrow_rotate_clockwise.png', array('title' => __('Status'))), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."', 'status', '".$d->getZacaciaStatus()."')");

/* Delete */
if ( $d->getZacaciaUnDeletable() && 'disable' === $d->getZacaciaStatus() && 0 === $d->get('user_count') ) {
    echo link_to_function(
        image_tag('famfam/cross.png', array('title' => __('Delete'))), 
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."', 'delete', null)");
} else {
    echo image_tag('famfam/blank.png');
}
?>
    </div>
    <!-- end #line._actions -->

    </form>
</div>
<!-- end #line -->
