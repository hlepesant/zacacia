<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g80 ym-gl">
    <div class="z-status-<?php echo $user->getZacaciaStatus() ?>"><?php echo $user->getCn() ?></div>
</div>

<div class="ym-g20 ym-gr z-action">

<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
    echo $form->renderHiddenFields();

/* -- Edit -- */
    echo link_to_function(
        image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($user->getCn())."', 'edit', null)");

/* -- Status -- */
    echo link_to_function(
        image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($user->getCn())."', 'status', '".$user->getZacaciaStatus()."')");

/* -- Delete -- */
    if ( !$user->getZacaciaUnDeletable() && 'disable' === $user->getZacaciaStatus() ) {
        echo link_to_function(
            image_tag('famfam/cross.png'),
            "jumpTo('".sprintf('%03d', $id)."', '".addslashes($user->getCn())."', 'delete', null)");
    } else {
        echo image_tag('famfam/blank.png');
    }

/* -- Separateur -- */
    echo image_tag('famfam/blank.png');

/*-- Password --*/
    echo link_to_function(
        image_tag('famfam/key.png'),
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($user->getCn()))."', 'password', null)");

/* -- Aliases -- */
    echo link_to_function(
        image_tag('famfam/email.png'), 
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($user->getCn()))."', 'aliases', null)");

/* -- Send As --*/
    echo link_to_function(
        image_tag('famfam/user_gray.png'),
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($user->getCn()))."', 'sendas', null)");
?>
</div>
</form>
</div>
<!-- next -->
