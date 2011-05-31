<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>

    <div class="_name_<?php /* echo $u->getZacaciaStatus() */ ?>"><?php /* echo $u->getCn() */ ?></div>
    <!-- end #line._name_ -->

    <div class="_actions">
<?php
/* Edit */
echo link_to_function(
    image_tag('famfam/page_white_edit.png', array('title' => __('Edit'))), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'edit', null)");

/* Status */
echo link_to_function(
    image_tag('famfam/arrow_rotate_clockwise.png', array('title' => __('Status'))), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'status', '".$u->getZacaciaStatus()."')");

/* Delete */
if ( $u->getZacaciaUnDeletable() && 'disable' === $u->getZacaciaStatus() ) {
    echo link_to_function(
        image_tag('famfam/cross.png', array('title' => __('Delete'))), 
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'delete', null)");
} else {
    echo image_tag('famfam/blank.png');
}

echo link_to_function(
    image_tag('famfam/world.png'), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'domain')");

if ( $c->getNumberOfDomains() ) {
    echo link_to_function(image_tag('famfam/aliases.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'user', null)");
    echo link_to_function(image_tag('famfam/sednas.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($u->getCn()))."', 'user', null)");
}
?>
    </div>
    <!-- end #line._actions -->

    </form>
</div>
<!-- end #line -->
