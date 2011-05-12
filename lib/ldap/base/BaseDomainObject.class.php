<?php

class BaseDomainObject extends LDAPObject
{
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
        $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'zacaciaDomain');
        $this->attributes['cn'] = null;
        $this->attributes['zacaciaStatus'] = 'enable';
        $this->attributes['zacaciaUnDeletable'] = 0;

        return $this;
    }
  
    public function setCn($v)
    {
        $this->attributes['cn'] = $v;
   	    return $this;
    }

    public function getCn()
    {
        return $this->attributes['cn'];
    }

    public function setZacaciaStatus($v)
    {
        if ( $v ) {
            $this->attributes['zacaciaStatus'] = 'enable';
        } else {
            $this->attributes['zacaciaStatus'] = 'disable';
        }
        return $this;
    }

    public function getZacaciaStatus()
    {
        return $this->attributes['zacaciaStatus'];
    }

    public function setZacaciaUnDeletable($v)
    {
        if ( $v ) {
            $this->attributes['zacaciaUnDeletable'] = 1;
        } else {
            $this->attributes['zacaciaUnDeletable'] = array();
        }
    	return $this;
    }
 
    public function getZacaciaUnDeletable()
    {
        return (int)$this->attributes['zacaciaUnDeletable'];
    }
}
