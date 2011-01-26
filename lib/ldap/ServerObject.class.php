<?php

class ServerObject extends BaseServerObject
{
    private $awk = '/usr/bin/awk';
    private $ping = '/bin/ping';
    private $grep = '/bin/grep';
    
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
        $this->attributes['ping'] = null;
        parent::applyDefaultValues();
        return $this;
    }

    public function setPingTime()
    {
        $time_response = shell_exec(sprintf("%s -c 1 %s -W 1 -n -s 16 | %s icmp_seq | %s -F \= '{print $4}'", $this->ping, $this->getIpHostNumber(), $this->grep, $this->awk));
        $this->attributes['ping'] = $time_response;
   	    return $this;
    }

    public function getPingTime()
    {
        return $this->attributes['ping'];
    }
}
