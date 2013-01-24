<div class="ym-grid z-line z-<?php echo (($id & 1) ? 'odd' : 'even'); ?>">

<div class="ym-g40 ym-gl">
    <div class="z-status-<?php echo $platform->getZacaciaStatus() ?>"><?php echo $platform->getCn() ?></div>
</div>

<div class="ym-g30 ym-gl z-notice">
<?php 
echo $platform->get('company_count');
echo __(' compan');
echo($platform->get('company_count') > 1 ? 'ies' : 'y');
echo ", ";
echo $platform->get('server_count');
echo __(' server');
echo($platform->get('server_count') > 1 ? 's' : '');
?>
</div>

<div class="ym-g30 ym-gr z-action">
<?php 
/* -- Edit -- */
echo link_to( image_tag('famfam/page_white_edit.png', array('title' => 'Edit')), '@platform_edit?platform='.$platform->getCn() );

/* -- Status -- */
echo link_to( image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')), '@platform_status?platform='.$platform->getCn() );

/* -- Delete -- */
if ( !$platform->getZacaciaUnDeletable() && 
    'disable' === $platform->getZacaciaStatus() && 
    0 === $platform->get('company_count') && 
    0 === $platform->get('server_count')) 
{
    echo link_to(
        image_tag('famfam/cross.png', array('title' => 'Delete')),
        '@platform_delete?platform='.$platform->getCn(),
        array('confirm' => 'Are you sure ?')
    );
} else {
    echo image_tag('famfam/blank.png');
}

/* -- Separateur -- */
#echo image_tag('famfam/blank.png');
/* -- Server -- */
echo link_to( image_tag('famfam/server.png', array('title' => 'Server')), '@servers?platform='.$platform->getCn() );
/* -- Company -- */
echo link_to( image_tag('famfam/building.png', array('title' => 'Company')), '@companies?platform='.$platform->getCn() );
?>
</div>
</div>
<!-- next -->
