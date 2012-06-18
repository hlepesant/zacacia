<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g80 ym-gl">
    <div class="z-status-<?php echo $c->getZacaciaStatus() ?>"><?php echo $c->getCn() ?></div>
</div>

<div class="ym-g20 ym-gr z-action">

<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
    echo $f->renderHiddenFields();

/* -- Edit -- */
    echo link_to_function(
        image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($c->getCn())."', 'edit', null)");

/* -- Status -- */
    echo link_to_function(
        image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($c->getCn())."', 'status', '".$c->getZacaciaStatus()."')");

/* -- Delete -- */
    #if ( !$c->getZacaciaUnDeletable() && 'disable' === $c->getZacaciaStatus() && 0 === $c->get('company_count') ) {
    if ( !$c->getZacaciaUnDeletable() && 'disable' === $c->getZacaciaStatus() ) {
        echo link_to_function(
            image_tag('famfam/cross.png'),
            "jumpTo('".sprintf('%03d', $id)."', '".addslashes($c->getCn())."', 'delete', null)");
    } else {
        echo image_tag('famfam/blank.png');
    }

/* -- Separateur -- */
    echo image_tag('famfam/blank.png');

/* -- Domains -- */
    echo link_to_function(
        image_tag('famfam/world.png'), 
        "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'domain')");

/* -- Users / Groups / Forward / Contact -- */
    if ( $c->getNumberOfDomains() ) {
        echo link_to_function(image_tag('famfam/user.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'user', null)");
        echo link_to_function(image_tag('famfam/group.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'group', null)");
        echo link_to_function(image_tag('famfam/email_go.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'forward', null)");
        echo link_to_function(image_tag('famfam/vcard.png'), "jumpTo('".sprintf('%03s', $id)."', '".sprintf(addslashes($c->getCn()))."', 'contact', null)");
    }
?>
</div>
</form>
</div>
<!-- next -->
