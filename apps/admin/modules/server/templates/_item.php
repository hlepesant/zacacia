<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>

    <div class="_name_<?php echo $s->getMiniStatus() ?>"><?php echo $s->getCn() ?></div>
    <!-- end #line._name_ -->

    <div class="_ipaddress"><?php echo $s->getIpHostNumber() ?></div>
    <!-- end #line.ipaddress -->

    <div class="_actions">
<?php
/* Edit */
echo link_to_function(image_tag('famfam/page_white_edit.png', array('title' => 'Edit')), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'edit')");
/* Status */
$_msg = 'Disable';
if ( 'disable' == $s->getMiniStatus() ) {
    $_msg = 'Enable';
}
echo link_to_function(image_tag('famfam/arrow_rotate_clockwise.png', array('title' => $_msg)), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'status', '".$_msg."')");
/* Delete */
if ( 'disable' == $s->getMiniStatus() && 0 == $s->get('user_count') ) {
    echo link_to_function(image_tag('famfam/cross.png', array('title' => 'Delete')), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'delete', 'Delete')");
}
else {
    echo image_tag('famfam/blank.png');
}
?>
    </div>
    <!-- end #line._actions -->

    </form>
</div>
<!-- end #line -->
