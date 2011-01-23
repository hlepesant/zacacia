<?php

class ServerPeer extends BaseServerPeer
{
    private $awk = '/usr/bin/awk';
    private $ping = '/bin/ping';
    private $grep = '/bin/grep';

    public function getPingTime($host)
    {
        $time_response = shell_exec("%s -c 1 %s | %s icmp_seq | %s -F \= '{print $4}'", self::$ping, $host, self::$grep, self::$awk);
        return trim( $time_response );
    }

}
