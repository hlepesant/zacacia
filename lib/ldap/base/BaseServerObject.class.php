<?php

class BaseServerObject extends LDAPObject
{
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
#       if (!is_array($this->attributes)) $this->attributes = array();
        $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'zarafa-server', 'ipHost', 'miniServer');
        $this->attributes['cn'] = null;
        $this->attributes['ipHostNumber'] = null;
        $this->attributes['miniStatus'] = 'enable';
        $this->attributes['miniUnDeletable'] = 'FALSE';
        $this->attributes['zarafaAccount'] = 1;
        $this->attributes['zarafaContainsPublic'] = 0;
        $this->attributes['zarafaFilePath'] = '/var/run/zarafa';
        $this->attributes['zarafaHidden'] = 1;
        $this->attributes['zarafaHttpPort'] = 236;
        $this->attributes['zarafaSslPort'] = 237;

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
  
    public function setIpHostNumber($v)
    {
        $this->attributes['ipHostNumber'] = $v;
   	    return $this;
    }

    public function getIpHostNumber()
    {
        return $this->attributes['ipHostNumber'];
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

    public function setZarafaAccount($v)
    {
        $this->attributes['zarafaAccount'] = $v;
  	    return $this;
    }

    public function getZarafaAccount()
    {
        return $this->attributes['zarafaAccount'];
    }

    public function setZarafaContainsPublic($v)
    {
        $this->attributes['zarafaContainsPublic'] = $v;
  	    return $this;
    }

    public function getZarafaContainsPublic()
    {
        return $this->attributes['zarafaContainsPublic'];
    }

    public function setZarafaFilePath($v)
    {
        $this->attributes['zarafaFilePath'] = $v;
  	    return $this;
    }

    public function getZarafaFilePath()
    {
        return $this->attributes['zarafaFilePath'];
    }

    public function setZarafaHidden($v)
    {
        $this->attributes['zarafaHidden'] = $v;
  	    return $this;
    }

    public function getZarafaHidden()
    {
        return $this->attributes['zarafaHidden'];
    }

    public function setZarafaHttpPort($v)
    {
        $this->attributes['zarafaHttpPort'] = $v;
  	    return $this;
    }

    public function getZarafaHttpPort()
    {
        return $this->attributes['zarafaHttpPort'];
    }

    public function setZarafaSslPort($v)
    {
        $this->attributes['zarafaSslPort'] = $v;
  	    return $this;
    }

    public function getZarafaSslPort()
    {
        return $this->attributes['zarafaSslPort'];
    }
}
