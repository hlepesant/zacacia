<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g80 ym-gl">
    <div class="z-status-<?php echo $s->getZacaciaStatus() ?>"><?php echo $s->getCn() ?></div>
</div>

<div class="ym-g20 ym-gr">

<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
    echo $f->renderHiddenFields();

/* -- Edit -- */
            echo link_to_function(
                image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
                "jumpTo('".sprintf('%03d', $id)."', '".addslashes($s->getCn())."', 'edit', null)");

/* -- Status -- */
            echo link_to_function(
                image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
                "jumpTo('".sprintf('%03d', $id)."', '".addslashes($s->getCn())."', 'status', '".$s->getZacaciaStatus()."')");

/* -- Delete -- */
            #if ( !$s->getZacaciaUnDeletable() && 'disable' === $s->getZacaciaStatus() && 0 === $s->get('company_count') ) {
            if ( !$s->getZacaciaUnDeletable() && 'disable' === $s->getZacaciaStatus() ) {
                echo link_to_function(
                    image_tag('famfam/cross.png'),
                    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($s->getCn())."', 'delete', null)");
            } else {
                echo image_tag('famfam/blank.png');
            }
?>
</div>
</form>
</div>
<!-- next -->
