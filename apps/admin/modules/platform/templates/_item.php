<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g40 ym-gl">
    <div class="z-status-<?php echo $platform->getZacaciaStatus() ?>"><?php echo $platform->getCn() ?></div>
</div>

<div class="ym-g30 ym-gl z-notice">
<?php 
echo $platform->get('company_count');
echo __(' company');
echo($platform->get('company_count') > 1 ? 's' : '');
echo ", ";
echo $platform->get('server_count');
echo __(' server');
echo($platform->get('server_count') > 1 ? 's' : '');
?>
</div>

<div class="ym-g30 ym-gr z-action">
<form action="#" method="POST" id="<?php printf('navigation_form_%03d', $id) ?>">
<?php 
echo $f->renderHiddenFields();

/* -- Edit -- */
echo link_to_function(
    image_tag('famfam/page_white_edit.png', array('title' => 'Edit')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($platform->getCn())."', 'edit', null)");

/* -- Status -- */
echo link_to_function(
    image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($platform->getCn())."', 'status', '".$platform->getZacaciaStatus()."')");

/* -- Delete -- */
#if ( !$platform->getZacaciaUnDeletable() && 'disable' === $platform->getZacaciaStatus() ) {
if ( !$platform->getZacaciaUnDeletable() && 
    'disable' === $platform->getZacaciaStatus() && 
    0 === $platform->get('company_count') && 
    0 === $platform->get('server_count')) 
{
    echo link_to_function(
        image_tag('famfam/cross.png'),
        "jumpTo('".sprintf('%03d', $id)."', '".addslashes($platform->getCn())."', 'delete', null)");
} else {
    echo image_tag('famfam/blank.png');
}

/* -- Separateur -- */
#echo image_tag('famfam/blank.png');

/* -- Server -- */
echo link_to_function(
    image_tag('famfam/server.png', array('title' => 'Server')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($platform->getCn())."', 'server', null)");

/* -- Company -- */
echo link_to_function(
    image_tag('famfam/building.png', array('title' => 'Company')),
    "jumpTo('".sprintf('%03d', $id)."', '".addslashes($platform->getCn())."', 'company', null)");
?>
</form>
</div>
</div>
<!-- next -->
