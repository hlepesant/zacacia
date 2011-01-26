<?php

class BaseServerPeer extends LDAPPeer
{
  protected $base_dn;
  public static $exclude_attrs = array();

#  public function __construct()
#  {
#    parent::__construct();
#  }

  public function setBaseDn($v)
  {
  	$this->base_dn = $v;
  	return $this;
  }

  public function getBaseDn()
  {
  	return $this->base_dn;
  }

  public function configureCriteria(LDAPCriteria $ldap_criteria)
  {
#    $ldap_criteria->setHost(self::HOST);
#    $ldap_criteria->setUsername(self::USERNAME);
#    $ldap_criteria->setPassword(self::PASSWORD);
#    $ldap_criteria->setUseSsl(self::USE_SSL);
#    if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn(self::BASE_DN);
    if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn($this->getBaseDn());

    return $ldap_criteria;
  }

  private function createLDAPObject($ldap_entry)
  {
    $attributes = $this->extractAttributes($ldap_entry);
    $values = $this->extractValues($ldap_entry, $attributes);
    $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);

    $ldap_object = new ServerObject();
    $ldap_object->setDn($dn);
    $ldap_object->__constructFrom($values);
    return( $ldap_object );
  }

  public function doSelect(LDAPCriteria $ldap_criteria, $ldap_object = 'base')
  {
    $ldap_criteria = self::configureCriteria($ldap_criteria);
    $results = $this->select($ldap_criteria);
    $ldap_entry = ldap_first_entry($this->getLinkId(), $results);
    
    $objects = array();

    if ($ldap_entry !== false)
    {
      $objects[] = $this->createLDAPObject($ldap_entry, $ldap_object);
      while ($ldap_entry = ldap_next_entry($this->getLinkId(), $ldap_entry))
      {
        $objects[] = $this->createLDAPObject($ldap_entry, $ldap_object);
      }
    }
    
    return $objects;
  }

#  public function doAdd(LDAPObject $ldap_object)
#  {
#    if ( ! parent::doAdd($ldap_object) )
#    {
#      return false;
#    }
#
#    return true;
#  }

  public function doSelectOne(LDAPCriteria $ldap_criteria)
  {
    $ldap_criteria = self::configureCriteria($ldap_criteria);
    $results = $this->select($ldap_criteria);
    $first_entry = ldap_first_entry($this->getLinkid(), $results);
    return $this->createLDAPObject($first_entry);
  }

  public function retrieveBy($attribute, $value)
  {
    $ldap_criteria = new LDAPCriteria();
    $ldap_criteria->add($attribute, $value);
    $ldap_criteria = self::configureCriteria($ldap_criteria);
    return self::doSelectOne($ldap_criteria);
  }

  public function doCount(LDAPCriteria $ldap_criteria)
  {
    $ldap_criteria = self::configureCriteria($ldap_criteria);
    return parent::doCount($ldap_criteria);
  }

  public function retrieveByDn(LDAPCriteria $ldap_criteria)
  {
    $ldap_criteria->setSearchScope(LDAPCriteria::BASE);
    $ldap_criteria->add('objectClass', 'top');
    $ldap_criteria->add('objectClass', 'organizationalRole');
    $ldap_criteria->add('objectClass', 'zarafa-server');
    $ldap_criteria->add('objectClass', 'ipHost');
    $ldap_criteria->add('objectClass', 'miniServer');
    $ldap_criteria = self::configureCriteria($ldap_criteria);

    return $this->doSelectOne($ldap_criteria);
  }

#  public function doSave(LDAPObject $ldap_object)
#  {
#    if ( ! parent::doSave($ldap_object) )
#    {
#      return false;
#    }
#    return true;
#  }

#  public function doDelete(LDAPObject $ldap_object, $recursive=false)
#  {
#    if ( ! parent::doDelete($ldap_object, $recursive) )
#    {
#      return false;
#    }
#    return true;
#  }
}
