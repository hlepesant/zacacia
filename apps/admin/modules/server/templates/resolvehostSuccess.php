<?php
if ( $ip ) {
    $arr = array(
        'ip' => $ip
    );
}
else {
    $arr = array(
        'ip' => ''
    );
}

echo json_encode($arr);
