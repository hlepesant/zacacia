<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g80 ym-gl">
    <div class="z-status-<?php echo $d->getZacaciaStatus() ?>"><?php echo $d->getCn() ?></div>
</div>

<div class="ym-g20 ym-gr z-action">

<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
    echo $f->renderHiddenFields();

/* -- Status -- */
            echo link_to_function(
                image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
                "jumpTo('".sprintf('%03d', $id)."', '".addslashes($d->getCn())."', 'status', '".$d->getZacaciaStatus()."')");

/* -- Delete -- */
            if ( !$d->getZacaciaUnDeletable() && 'disable' === $d->getZacaciaStatus() && 0 === $d->get('email_count') ) {
                echo link_to_function(
                    image_tag('famfam/cross.png'),
                    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($d->getCn())."', 'delete', null)");
            } else {
                echo image_tag('famfam/blank.png');
            }
?>
</div>
</form>
</div>
<!-- next -->
