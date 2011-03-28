<div id="collection_line_<?php echo (($id & 1) ? 'odd' : 'even'); ?>">
    <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php echo $f->renderHiddenFields() ?>
    <div class="_name" class="<?php echo $p->getMiniStatus() ?>"><?php echo $p->getCn() ?></div>
    <div class="_actions" class="navigation">
 <?php
switch( sfConfig::get('navigation_look') )
{
    case 'dropdown':
        echo $f['destination']->render( Array(
            'id' => sprintf('destination_%03d', $id),
            'onChange' => "JavaScript: jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."')"
        ));
    break;

    case 'link':
    default:
        if ( 'disable' === $p->getMiniStatus() && 0 === $p->get('company_count') ) {
            echo link_to_function(image_tag('icons/cross.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."', 'delete')");
        }
        echo link_to_function(image_tag('icons/page_white_edit.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."', 'edit')");
        echo link_to_function(image_tag('icons/arrow_rotate_clockwise.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."', 'status')");
        echo link_to_function(image_tag('icons/server.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."', 'server')");
        echo link_to_function(image_tag('icons/building.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($p->getCn()))."', 'company')");
    break;
}
?>
    </div>
    <!-- end #line -->

    </form>
</div>
<!-- end #line -->
