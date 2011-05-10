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
        $this->attributes['zacaciaStatus'] = $v;
        return $this;
    }

    public function getZacaciaStatus()
    {
        return $this->attributes['zacaciaStatus'];
    }

    public function setZacaciaUndeletable($v)
    {
        $this->attributes['zacaciaUnDeletable'] = $v;
        return $this;
    }
 
    public function getZacaciaUndeletable()
    {
        return $this->attributes['zacaciaUnDeletable'];
    }
}
