<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>
    <div class="_name_<?php echo $p->getZacaciaStatus() ?>"><?php echo $p->getCn() ?></div>
    <!-- end #line._name_ -->
    <div class="_actions">
<?php
/* -- Edit -- */
echo link_to_function(
    image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'edit', null)");

/* -- Status -- */
echo link_to_function(
    image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'status', '".$p->getZacaciaStatus()."')");

/* -- Delete -- */
#if ( !$p->getZacaciaUnDeletable() && 'disable' === $p->getZacaciaStatus() && 0 === $p->get('company_count') ) {
if ( !$p->getZacaciaUnDeletable() && 'disable' === $p->getZacaciaStatus() ) {
    echo link_to_function(
        image_tag('famfam/cross.png'),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'delete', null)");
} else {
    echo image_tag('famfam/blank.png');
}

/* -- Separateur -- */
echo image_tag('famfam/blank.png');

/* -- Server -- */
echo link_to_function(
    image_tag('famfam/server.png', array('title' => 'Server')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'server', null)");

/* -- Company -- */
echo link_to_function(
    image_tag('famfam/building.png', array('title' => 'Company')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'company', null)");
?>
    </div>
    <!-- end #line._actions -->

    </form>
</div>
<!-- end #line -->
