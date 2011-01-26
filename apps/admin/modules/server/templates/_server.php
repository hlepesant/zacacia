    <div id="line">
        <form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
        <?php echo $f->renderHiddenFields() ?>
            <div id="line" class="<?php echo (($id & 1) ? 'light' : 'dark'); ?>">
                <div id="line" class="ping">
<?php
if (is_null( $s->getPingTime()))
{
    echo image_tag('icons/bullet_yellow.png');
}
else
{
    if ($s->getPingTime())
    {
        echo image_tag('icons/bullet_green.png');
    }
    else
    {
        echo image_tag('icons/bullet_red.png');
    }
}
?>
<?php /* echo $s->getPingTime(); */ ?>
                </div>
                <div id="line" class="<?php echo $s->getMiniStatus() ?>"><?php echo $s->getCn() ?></div>
                <div id="line" class="ipaddress"><?php echo $s->getIpHostNumber() ?></div>
                <div id="line" class="navigation">
 <?php 
switch( sfConfig::get('navigation_look') )
{
    case 'dropdown':
        echo $f['destination']->render( Array(
            'id' => sprintf('destination_%03d', $id),
            'onChange' => "JavaScript: jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."')"
        ));
    break;

    case 'link':
    default:
        if ( 'disable' === $s->getMiniStatus() && 0 === $s->get('user_count') ) {
            echo link_to_function(image_tag('icons/cross.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'delete')");
        }
        echo link_to_function(image_tag('icons/page_white_edit.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'edit')");
        echo link_to_function(image_tag('icons/arrow_rotate_clockwise.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($s->getCn()))."', 'status')");
    break;
}
?>
                </div>
            </div>
        </form>
    </div>
<!-- next line bellow -->
