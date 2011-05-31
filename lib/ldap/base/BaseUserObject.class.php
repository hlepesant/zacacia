<?php

class BaseUserObject extends LDAPObject
{
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
        $this->attributes['objectClass']            = Array('top', 'posixAccount', 'inetOrgPerson', 'zarafa-user', 'zacaciaUser');
        $this->attributes['cn']                     = null;
        $this->attributes['homeDirectory']          = '/dev/null';
        $this->attributes['loginShell']             = '/bin/false';
        $this->attributes['zacaciaStatus']          = 'enable';
        $this->attributes['zacaciaUnDeletable']     = 0;
        $this->attributes['zarafaAccount']          = 1;
        $this->attributes['zarafaAdmin']            = 0;
        $this->attributes['zarafaQuotaOverride']    = 0;
        $this->attributes['zarafaSendAsPrivilege']  = '';
        $this->attributes['zarafaUserServer']       = '';

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
  
    public function setDisplayName($v)
    {
        $this->attributes['displayName'] = $v;
   	    return $this;
    }

    public function getDisplayName()
    {
        return $this->attributes['displayName'];
    }
  
    public function setGidnumber($v)
    {
        $this->attributes['gidNumber'] = $v;
   	    return $this;
    }

    public function getGidnumber()
    {
        return $this->attributes['gidNumber'];
    }
  
    public function setGivenName($v)
    {
        $this->attributes['givenName'] = $v;
   	    return $this;
    }

    public function getGivenName()
    {
        return $this->attributes['givenName'];
    }
  
    public function setHomedirectory($v)
    {
        $this->attributes['homeDirectory'] = $v;
   	    return $this;
    }

    public function getHomedirectory()
    {
        return $this->attributes['homeDirectory'];
    }
  
    public function setLoginShell($v)
    {
        $this->attributes['loginShell'] = $v;
   	    return $this;
    }

    public function getLoginShell()
    {
        return $this->attributes['loginShell'];
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
  
    public function setMobile($v)
    {
        $this->attributes['mobile'] = $v;
   	    return $this;
    }

    public function getMobile()
    {
        return $this->attributes['mobile'];
    }
  
    public function setUserPassword($v)
    {
        $this->attributes['userPassword'] = $v;
   	    return $this;
    }

    public function getUserPassword()
    {
        return $this->attributes['userPassword'];
    }
  
    public function setPostalAddress($v)
    {
        $this->attributes['postalAddress'] = $v;
   	    return $this;
    }

    public function getPostalAddress()
    {
        return $this->attributes['postalAddress'];
    }
  
    public function setPostalCode($v)
    {
        $this->attributes['postalCode'] = $v;
   	    return $this;
    }

    public function getPostalCode()
    {
        return $this->attributes['postalCode'];
    }
  
    public function setSn($v)
    {
        $this->attributes['sn'] = $v;
   	    return $this;
    }

    public function getSn()
    {
        return $this->attributes['sn'];
    }
  
    public function setTelephoneNumber($v)
    {
        $this->attributes['telephoneNumber'] = $v;
   	    return $this;
    }

    public function getTelephoneNumber()
    {
        return $this->attributes['telephoneNumber'];
    }
  
    public function setUidNumber($v)
    {
        $this->attributes['uidNumber'] = $v;
   	    return $this;
    }

    public function getUidNumber()
    {
        return $this->attributes['uidNumber'];
    }
  
    public function setZarafaAliases($v)
    {
        $this->attributes['zarafaAliases'] = $v;
   	    return $this;
    }

    public function getZarafaAliases()
    {
        return $this->attributes['zarafaAliases'];
    }
  
    public function setZarafaAdmin($v)
    {
        $this->attributes['zarafaAdmin'] = $v;
   	    return $this;
    }

    public function getZarafaAdmin()
    {
        return $this->attributes['zarafaAdmin'];
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
  
    public function setUid($v)
    {
        $this->attributes['uid'] = $v;
   	    return $this;
    }

    public function getUid()
    {
        return $this->attributes['uid'];
    }
  
    public function setZarafaQuotaSoft($v)
    {
        $this->attributes['zarafaQuotaSoft'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaSoft()
    {
        return $this->attributes['zarafaQuotaSoft'];
    }
  
    public function setZarafaQuotaHard($v)
    {
        $this->attributes['zarafaQuotaHard'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaHard()
    {
        return $this->attributes['zarafaQuotaHard'];
    }
  
    public function setZarafaQuotaWarn($v)
    {
        $this->attributes['zarafaQuotaWarn'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaWarn()
    {
        return $this->attributes['zarafaQuotaWarn'];
    }
  
    public function setZarafaQuotaOverride($v)
    {
        $this->attributes['zarafaQuotaOverride'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaOverride()
    {
        return $this->attributes['zarafaQuotaOverride'];
    }
  
    public function setZarafaUserServer($v)
    {
        if ( $v ) {
            $this->attributes['zarafaUserServer'] = $v;
        } else {
            $this->attributes['zarafaUserServer'] = array();
        }
        return $this;
    }

    public function getZarafaUserServer()
    {
        return $this->attributes['zarafaUserServer'];
    }
  
    public function setZarafaSendAsPrivilege($v)
    {
        if ( $v ) {
            $this->attributes['zarafaSendAsPrivilege'] = $v;
        } else {
            $this->attributes['zarafaSendAsPrivilege'] = array();
        }
        return $this;
    }

    public function getZarafaSendAsPrivilege()
    {
        return $this->attributes['zarafaSendAsPrivilege'];
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
    public function setZacaciastatus($v)
    {
        $this->attributes['zacaciaStatus'] = $v;
        return $this;
    }

    public function getZacaciastatus()
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
 
    public function getZacaciaUndeletable()
    {
        return $this->attributes['zacaciaUnDeletable'];
    }
}
