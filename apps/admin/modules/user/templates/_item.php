<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>

    <div class="_name_<?php echo $c->getZacaciaStatus() ?>"><?php echo $c->getCn() ?></div>
    <!-- end #line._name_ -->

    <div class="_actions">
<?php
/* Edit */
echo link_to_function(
    image_tag('famfam/page_white_edit.png', array('title' => __('Edit'))), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'edit', null)");

/* Status */
echo link_to_function(
    image_tag('famfam/arrow_rotate_clockwise.png', array('title' => __('Status'))), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'status', '".$c->getZacaciaStatus()."')");

/* Delete */
// if ( !$c->getZacaciaUnDeletable() && 'disable' === $c->getZacaciaStatus() && 0 === $c->get('user_count') ) {
if ( $c->getZacaciaUnDeletable() && 'disable' === $c->getZacaciaStatus() ) {
    echo link_to_function(
        image_tag('famfam/cross.png', array('title' => __('Delete'))), 
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'delete', null)");
} else {
    echo image_tag('famfam/blank.png');
}
/*
if ( 'disable' === $c->getZacaciaStatus() && $c->get('undeletable') )
{
    echo link_to_function(image_tag('icons/cross.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'delete', null)");
}
*/

echo link_to_function(
    image_tag('famfam/world.png'), 
    "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'domain')");

if ( $c->getNumberOfDomains() ) {
    echo link_to_function(image_tag('famfam/user.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'user', null)");
    echo link_to_function(image_tag('famfam/group.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'group', null)");
    echo link_to_function(image_tag('famfam/email_go.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'forward', null)");
    echo link_to_function(image_tag('famfam/vcard.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'contact', null)");
}

/*
echo link_to_function(image_tag('icons/page_white_edit.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'edit')");
echo link_to_function(image_tag('icons/arrow_rotate_clockwise.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'status')");
*/
?>
    </div>
    <!-- end #line._actions -->

    </form>
</div>
<!-- end #line -->
