    <div id="line">
        <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
        <?php echo $f->renderHiddenFields() ?>
            <div id="line" class="<?php echo (($id & 1) ? 'light' : 'dark'); ?>">
                <div id="line" class="<?php echo $d->getMiniStatus() ?>"><?php echo $d->getCn() ?></div>
                <div id="line" class="navigation">
 <?php 
switch( sfConfig::get('navigation_look') )
{
    case 'dropdown':
        echo $f['destination']->render( Array(
            'id' => sprintf('destination_%03d', $id),
            'onChange' => "JavaScript: jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."')"
        ));
    break;

    case 'link':
    default:
        if ( 'disable' === $d->getMiniStatus() && 0 === $d->get('user_count') ) {
            echo link_to_function(image_tag('icons/cross.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."', 'delete')");
        }
        echo link_to_function(image_tag('icons/page_white_edit.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."', 'edit')");
        echo link_to_function(image_tag('icons/arrow_rotate_clockwise.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($d->getCn()))."', 'status')");
    break;
}
?>
                </div>
            </div>
        </form>
    </div>
<!-- next line bellow -->
