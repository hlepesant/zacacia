<div id="line">
        <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
        <?php echo $f->renderHiddenFields() ?>
            <div id="line" class="<?php echo (($id & 1) ? 'light' : 'dark'); ?>">
                <div id="line" class="<?php echo $c->getMiniStatus() ?>"><?php echo $c->getCn() ?></div>
                <div id="line" class="navigation">
 <?php 
switch( sfConfig::get('navigation_look') )
{
    case 'dropdown':
        echo $f['destination']->render( Array(
            'id' => sprintf('destination_%03d', $id),
            'onChange' => "JavaScript: jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."')"
        ));
    break;

    case 'link':
    default:
        if ( 'disable' === $c->getMiniStatus() && 0 === $c->get('user_count') ) {
            echo link_to_function(image_tag('icons/cross.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'delete')");
        }
        echo link_to_function(image_tag('icons/user.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'user')");
        echo link_to_function(image_tag('icons/group.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'group')");
        echo link_to_function(image_tag('icons/email_go.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'forward')");
        echo link_to_function(image_tag('icons/vcard.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'contact')");
        echo link_to_function(image_tag('icons/world.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'domain')");
        echo link_to_function(image_tag('icons/page_white_edit.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'edit')");
        echo link_to_function(image_tag('icons/arrow_rotate_clockwise.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'status')");
    break;
}
?>
                </div>
            </div>
        </form>
    </div>
<!-- next line bellow -->
