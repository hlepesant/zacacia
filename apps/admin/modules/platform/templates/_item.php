


<tr>
<td><?php echo $platform->getZacaciaStatus() ?></td>
<td><?php echo $platform->getCn() ?></td>
<td><?php echo $platform->get('company_count'); ?></td>
<td><?php echo($platform->get('company_count') > 1 ? 'ies' : 'y'); ?></td>
<td><?php echo $platform->get('server_count'); ?></td>
<td><?php echo($platform->get('server_count') > 1 ? 's' : ''); ?></td>

<td><?php 
/* -- Edit -- */
echo link_to( image_tag('famfam/page_white_edit.png', array('title' => 'Edit')), '@platform_edit?platform='.$platform->getCn() ); ?></td>

<td><?php
/* -- Status -- */
echo link_to( image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Status')), '@platform_status?platform='.$platform->getCn() ); ?></td>

<td><?php
/* -- Delete -- */
if ( !$platform->getZacaciaUnDeletable() && 
    'disable' === $platform->getZacaciaStatus() && 
    0 === $platform->get('company_count') && 
    0 === $platform->get('server_count')) {
        echo link_to(
            image_tag('famfam/cross.png', array('title' => 'Delete')),
            '@platform_delete?platform='.$platform->getCn(),
            array('confirm' => 'Are you sure ?')
        );
} else {
    echo image_tag('famfam/blank.png');
} ?></td>

<?php
/* -- Separateur -- */
#echo image_tag('famfam/blank.png');
?>

<td><?php
/* -- Server -- */
echo link_to( image_tag('famfam/server.png', array('title' => 'Server')), '@servers?platform='.$platform->getCn() ); ?></td>
<td><?php
/* -- Company -- */
echo link_to( image_tag('famfam/building.png', array('title' => 'Company')), '@companies?platform='.$platform->getCn() ); ?></td>

</tr>
