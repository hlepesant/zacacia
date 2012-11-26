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
        $this->attributes['zarafaQuotaWarn']        = 0;
        $this->attributes['zarafaQuotaSoft']        = 0;
        $this->attributes['zarafaQuotaHard']        = 0;
        $this->attributes['zarafaSendAsPrivilege']  = '';
        $this->attributes['zarafaUserServer']       = '';
        $this->attributes['zarafaHidden']           = '';
        $this->attributes['mail']                   = '';

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
      if ( $this->isValidMd5($v) ) {
        $p = sprintf("{MD5}%s", base64_encode(pack('H*',$v)));
      } else {
        $p = sprintf("{MD5}%s", base64_encode(pack('H*',md5($v))));
      }

      $this->attributes['userPassword'] = $p;

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
  
    public function setZarafaQuotaOverride($v)
    {
        $this->attributes['zarafaQuotaOverride'] = (int)$v;
   	    return $this;
    }

    public function getZarafaQuotaOverride()
    {
        return $this->attributes['zarafaQuotaOverride'];
    }
  
    public function setZarafaQuotaHard($v)
    {
        $this->attributes['zarafaQuotaHard'] = (int)$v;
   	    return $this;
    }

    public function getZarafaQuotaHard()
    {
        return $this->attributes['zarafaQuotaHard'];
    }
  
    public function setZarafaQuotaSoft($v)
    {
        $this->attributes['zarafaQuotaSoft'] = (int)$v;
   	    return $this;
    }

    public function getZarafaQuotaSoft()
    {
        return $this->attributes['zarafaQuotaSoft'];
    }
  
    public function setZarafaQuotaWarn($v)
    {
        $this->attributes['zarafaQuotaWarn'] = (int)$v;
   	    return $this;
    }

    public function getZarafaQuotaWarn()
    {
        return $this->attributes['zarafaQuotaWarn'];
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
 
    public function getZacaciaUnDeletable()
    {
        return (int)$this->attributes['zacaciaUnDeletable'];
    }

    public function setEmailAddress($v)
    {
        if ( $v ) {
            $this->attributes['mail'] = $v;
        } else {
            $this->attributes['mail'] = array();
        }
    	return $this;
    }
 
    public function getEmailAddress()
    {
        return (int)$this->attributes['mail'];
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

    private function isValidMd5($md5)
    {
        return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    private function isValidEmail($mail)
    {
        return true;
        return !empty($mail) && preg_match('/^[a-f0-9\.\-]\@{32}$/', $mail);
    }
}
