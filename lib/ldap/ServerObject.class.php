<?php

class ServerObject extends BaseServerObject
{
/*
    public function setPingTime()
    {
        $time_response = false;
    
        if ( 'enable' == $this->getZacaciaStatus() )
        {
            $time_response = shell_exec(sprintf("%s -c 1 %s -W 1 -n -s 16 | %s icmp_seq | %s -F \= '{print $4}'",
                sfConfig::get('ping'),
                $this->getIpHostNumber(),
                sfConfig::get('grep'),
                sfConfig::get('awk')));
        }
        else
        {
            $time_response = null;
        }

        $this->attributes['ping'] = $time_response;
   	    return $this;
    }
*/
/*
    public function getPingTime()
    {
        return $this->attributes['ping'];
    }
*/
}
