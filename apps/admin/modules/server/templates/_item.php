    <tr>
        <td><?php echo $server->getZacaciaStatus()    ?></td>
        <td><?php echo $server->getCn()               ?></td>
        <td><?php 
/* -- Edit -- */
echo link_to( image_tag('famfam/page_white_edit.png', array('title' => 'Edit')), 
    '@server_edit?platform='.$platform->getCn().'&server='.$server->getCn() );

/* -- Status -- */
echo link_to( image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Change Status')), 
    '@server_status?platform='.$platform->getCn().'&server='.$server->getCn() );

/* -- Delete -- */
if ( !$server->getZacaciaUnDeletable() && 'disable' === $server->getZacaciaStatus() ) {
    echo link_to( image_tag('famfam/arrow_rotate_clockwise.png', array('title' => 'Change Status')), 
        '@server_delete?platform='.$platform->getCn().'&server='.$server->getCn(),
        array('confirm' => 'Are you sure ?')
        );
} else {
    echo image_tag('famfam/blank.png');
}
?>
        </td>
    </tr>
