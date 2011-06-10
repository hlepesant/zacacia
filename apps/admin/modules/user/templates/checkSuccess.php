<?php
if ( $count ) {
    $arr = array(
        'img' => '/images/famfam/cross.png',
        'disabled' => true,
    );
}
else {
    $arr = array(
        'img' => '/images/famfam/tick.png',
        'disabled' => false,
    );
}

echo json_encode($arr);
