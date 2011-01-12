<?php

class PlatformObject extends LDAPObject
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
#    if (!is_array($this->attributes)) $this->attributes = array();
    $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'miniPlatform');
    $this->attributes['cn'] = null;
    $this->attributes['miniStatus'] = 'enable';
    $this->attributes['miniUnDeletable'] = 'FALSE';
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
