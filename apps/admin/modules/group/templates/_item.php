<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g60 ym-gl">
<div class="z-status-<?php echo $group->getZacaciaStatus() ?>"><?php echo $group->getCn() ?></div>
</div>

<div class="ym-g40 ym-gr z-action">

<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
    echo $form->renderHiddenFields();

/* -- Edit -- */
    echo link_to_function(
        image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($group->getCn())."', 'edit', null)");

/* -- Status -- */
    echo link_to_function(
        image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($group->getCn())."', 'status', '".$group->getZacaciaStatus()."')");

/* -- Delete -- */
    if ( !$group->getZacaciaUnDeletable() && 'disable' === $group->getZacaciaStatus() ) {
        echo link_to_function(
            image_tag('famfam/cross.png'),
            "jumpTo('".sprintf('%03d', $id)."', '".addslashes($group->getCn())."', 'delete', null)");
    } else {
        echo image_tag('famfam/blank.png');
    }
?>
</div>
</form>
</div>
<!-- next -->
