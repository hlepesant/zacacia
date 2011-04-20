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
        $this->attributes['objectClass']        = Array('top', 'organizationalRole', 'miniPlatform');
        $this->attributes['cn']                 = null;
        $this->attributes['miniStatus']         = 'enable';
        $this->attributes['miniUnDeletable']    = 0;
        $this->attributes['miniMultiServer']    = 0;
        $this->attributes['miniMultiTenant']    = 0;
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

    public function setMiniUnDeletable($v)
    {
        if ( $v ) {
            $this->attributes['miniUnDeletable'] = 1;
        } else {
            $this->attributes['miniUnDeletable'] = array();
        }
    	return $this;
    }
 
    public function getMiniUnDeletable()
    {
        return (int)$this->attributes['miniUnDeletable'];
    }

    public function setMiniMultiServer($v)
    {
        if ( $v ) {
            $this->attributes['miniMultiServer'] = 1;
        } else {
            $this->attributes['miniMultiServer'] = array();
        }
    	return $this;
    }
 
    public function getMiniMultiServer()
    {
        return (int)$this->attributes['miniMultiServer'];
    }

    public function setMiniMultiTenant($v)
    {
        if ( $v ) {
            $this->attributes['miniMultiTenant'] = 1;
        } else {
            $this->attributes['miniMultiTenant'] = array();
        }
    	return $this;
    }
 
    public function getMiniMultiTenant()
    {
        return (int)$this->attributes['miniMultiTenant'];
    }
}
