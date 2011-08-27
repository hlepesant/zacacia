<?php

/*
 * http://doc.zarafa.com/6.40/Administrator_Manual/en-US/html/_multi_server_setup.html
 * 6.3.2. Prepare / setup the LDAP server for multi-server setup
 */

class BaseServerObject extends LDAPObject
{
  public function __construct()
  {
    parent::__construct();
    $this->applyDefaultValues();
  }

  public function applyDefaultValues()
  {
    $this->attributes['objectClass']            = Array('top', 'organizationalRole', 'zarafa-server', 'ipHost', 'zacaciaServer');
    $this->attributes['cn']                     = null;
    $this->attributes['ipHostNumber']           = null;
    $this->attributes['zacaciaStatus']          = 'enable';
    $this->attributes['zacaciaUnDeletable']     = 0;
    $this->attributes['zacaciaMultiTenant']     = 0;                  // Multi tenant server
    /* Zarafa Specific Attributs */
    $this->attributes['zarafaAccount']          = 0;                  // Entry is a part of zarafa
    $this->attributes['zarafaContainsPublic']   = 0;                  // This server contains the public store
    $this->attributes['zarafaFilePath']         = '/var/run/zarafa';  // The unix socket or named pipe to the server
    $this->attributes['zarafaHidden']           = 0;                  // This object should be hidden from address book
    $this->attributes['zarafaHttpPort']         = 0;                  // Port for the http connection
    $this->attributes['zarafaSslPort']          = 0;                  // Port for the ssl connection

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

  public function setZarafaAccount($v)
  {
    if ( $v ) {
      $this->attributes['zarafaAccount'] = 1;
    } else {
      $this->attributes['zarafaAccount'] = array();
    }
    return $this;
  }

  public function getZarafaAccount()
  {
    return $this->attributes['zarafaAccount'];
  }

  public function setZarafaContainsPublic($v)
  {
    if ( $v ) {
      $this->attributes['zarafaContainsPublic'] = 1;
    } else {
      $this->attributes['zarafaContainsPublic'] = array();
    }
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
    if ( empty( $this->attributes['zarafaHttpPort'] ) )
      return sfConfig::get('zarafaHttpPort');

    return $this->attributes['zarafaHttpPort'];
  }

  public function setZarafaSslPort($v)
  {
      $this->attributes['zarafaSslPort'] = $v;
      return $this;
  }

  public function getZarafaSslPort()
  {
      if ( empty($this->attributes['zarafaSslPort']) )
        return sfConfig::get('zarafaSslPort');

      return $this->attributes['zarafaSslPort'];
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

  public function setZacaciaMultiTenant($v)
  {
      if ( $v ) {
          $this->attributes['zacaciaMultiTenant'] = 1;
      } else {
          $this->attributes['zacaciaMultiTenant'] = array();
      }
  	return $this;
  }
 
  public function getZacaciaMultiTenant()
  {
      return (int)$this->attributes['zacaciaMultiTenant'];
  }

  public function setZarafaQuotaHard($v)
  {
      $this->attributes['zarafaQuotaHard'] = $v;
      return $this;
  }

  public function getZarafaQuotaHard()
  {
      if ( empty( $this->attributes['zarafaQuotaHard'] ) )
        return 0;
      else
        return $this->attributes['zarafaQuotaHard'];
  }
}
