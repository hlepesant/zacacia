<?php
if ( $exist ) {
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
