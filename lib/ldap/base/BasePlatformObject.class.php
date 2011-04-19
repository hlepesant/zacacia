<?php

class BasePlatformObject extends LDAPObject
{
  /* protected $alreadyInSave = false; */
  /* protected $alreadyInValidation = false; */
  
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
#       if (!is_array($this->attributes)) $this->attributes = array();
        $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'miniPlatform');
        $this->attributes['cn'] = null;
        $this->attributes['miniStatus'] = 'enable';
        $this->attributes['miniUnDeletable'] = 0;
        $this->attributes['miniMultiServer'] = 0;
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
  
    public function setMiniStatus($v)
    {
        $this->attributes['miniStatus'] = $v;
    	return $this;
    }

    public function getMiniStatus()
    {
        return $this->attributes['miniStatus'];
    }

    public function setMiniUndeletable($v)
    {
        $this->attributes['miniUnDeletable'] = $v;
    	return $this;
    }
 
    public function getMiniUndeletable()
    {
        return $this->attributes['miniUnDeletable'];
    }

    public function setMiniMultiServer($v)
    {
        $this->attributes['miniMultiServer'] = $v;
    	return $this;
    }
 
    public function getMiniMultiServer()
    {
        return $this->attributes['miniMultiServer'];
    }
}
