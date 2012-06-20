<?php
if ( $count ) {
    $arr = array(
        'disabled' => true,
    );
}
else {
    $arr = array(
        'disabled' => false,
    );
}

echo json_encode($arr);
