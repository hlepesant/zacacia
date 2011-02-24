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
        $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'miniDomain');
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
  
    public function setMinistatus($v)
    {
        $this->attributes['miniStatus'] = $v;
        return $this;
    }

    public function getMinistatus()
    {
        return $this->attributes['miniStatus'];
    }

    public function setMiniundeletable($v)
    {
        $this->attributes['miniUnDeletable'] = $v;
        return $this;
    }
 
    public function getMiniundeletable()
    {
        return $this->attributes['miniUnDeletable'];
    }
}
