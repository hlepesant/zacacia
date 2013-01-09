<?php

class BaseGroupObject extends LDAPObject
{
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
        $this->attributes['objectClass']            = Array('top', 'groupOfNames', 'zarafa-group', 'zacaciaUser');
        $this->attributes['cn']                     = null;
        $this->attributes['member']                 = Array();

        #$this->attributes['businessCategory']       = Array();
        #$this->attributes['description']            = Array();
        #$this->attributes['o']                      = Array();
        #$this->attributes['ou']                     = Array();
        #$this->attributes['owner']                  = Array();
        #$this->attributes['seeAlso']                = Array();

        $this->attributes['mail']                   = '';
        $this->attributes['zarafaAccount']          = 1;
        $this->attributes['zarafaAliases']          = Array();
        $this->attributes['zarafaHidden']           = '';
        $this->attributes['zarafaSecurityGroup']    = 0;

        $this->attributes['zacaciaStatus']          = 'enable';
        $this->attributes['zacaciaUnDeletable']     = 0;

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
  
    public function setMail($v)
    {
        $this->attributes['mail'] = $v;
   	    return $this;
    }

    public function getMail()
    {
        return $this->attributes['mail'];
    }
  
    public function setZarafaAliases($v)
    {
	    if ( is_null($v) ) {
            $this->attributes['zarafaAliases'] = Array();
	    }
	    elseif ( is_array($v) ) {
            $this->attributes['zarafaAliases'] = $v;
	    }
	    else {
           	$this->attributes['zarafaAliases'] = Array($v);
	    }
   	    return $this;
    }

    public function getZarafaAliases()
    {
        $aliases = $this->attributes['zarafaAliases'];
	    if ( is_array( $aliases ) ) {
	    	return $aliases;
	    }
	    return Array($aliases);
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
  
/*  
    public function set($v)
    {
        $this->attributes[''] = $v;
   	    return $this;
    }

    public function get()
    {
        return $this->attributes[''];
    }
*/  
 
    public function getZacaciaUnDeletable()
    {
        return (int)$this->attributes['zacaciaUnDeletable'];
    }

    public function setZarafaHidden($v)
    {
        if ( $v ) {
            $this->attributes['zarafaHidden'] = 1;
        } else {
            $this->attributes['zarafaHidden'] = array();
        }
        return $this;
    }

    public function getZarafaHidden()
    {
        return $this->attributes['zarafaHidden'];
    }

    public function setZarafaSecurityGroup($v)
    {
        if ( $v ) {
            $this->attributes['zarafaSecurityGroup'] = 1;
        } else {
            $this->attributes['zarafaSecurityGroup'] = array();
        }
        return $this;
    }

    public function getZarafaSecurityGroup()
    {
        return $this->attributes['zarafaSecurityGroup'];
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

    public function setZacaciaUnDeletable($v)
    {
        if ( $v ) {
            $this->attributes['zacaciaUnDeletable'] = 1;
        } else {
            $this->attributes['zacaciaUnDeletable'] = array();
        }
    	return $this;
    }
}
