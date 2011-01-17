    <div id="enum" class="td">
        <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
        <?php echo $f->renderHiddenFields() ?>
            <div id="enum" class="<?php echo (($id & 1) ? 'dark' : 'light'); ?>">
                <div id="enum" class="<?php echo $p->getMiniStatus() ?>"><?php echo $p->getCn() ?></div>
                <div id="enum" class="navigation">
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
            </div>
        </form>
    </div>
<!-- next line bellow -->
