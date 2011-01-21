<?php
if ( $ip ) {
echo javascript_tag("
$('minidata_ip').value = '".$ip."';
");
}
