<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>
    <div class="_name" class="<?php echo $p->getMiniStatus() ?>"><?php echo $p->getCn() ?></div>
    <div class="_actions">
<?php
if ( 'disable' === $p->getMiniStatus() && 0 === $p->get('company_count') ) {
    echo link_to_function(image_tag('famfam/cross.png'), "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'delete', null)");
}
echo link_to_function(image_tag('famfam/page_white_edit.png', array('title' => 'Edit')), "jumpTo('".sprintf('%03d', $id)."', '".addslashes($p->getCn())."', 'edit', null)");
echo link_to_function(image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')), "jumpTo('".sprintf('%03s', $id)."', '".addslashes($p->getCn())."', 'status')");
echo link_to_function(image_tag('famfam/server.png', array('title' => 'Server')), "jumpTo('".sprintf('%03s', $id)."', '".addslashes($p->getCn())."', 'server', null)");
echo link_to_function(image_tag('famfam/building.png', array('title' => 'Company')), "jumpTo('".sprintf('%03s', $id)."', '".addslashes($p->getCn())."', 'company', null)");
?>
    </div>
    <!-- end #line -->

    </form>
</div>
<!-- end #line -->