<?php

class BasePlatformPeer extends BaseLDAPeer
{
  protected $base_dn;
  public static $exclude_attrs = array();

  public function __construct()
  {
    parent::__construct();
    $this->setBaseDn('ou=Platforms,ou=MinivISP,dc=dedibox,dc=fr');
  }

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

    $ldap_object = new PlatformObject();
    $ldap_object->setDn($dn);
    $ldap_object->__constructFrom($values);
    return( $ldap_object );
  }

  public function doSelect(LDAPCriteria $ldap_criteria)
  {
    $ldap_criteria = self::configureCriteria($ldap_criteria);
    $results = $this->select($ldap_criteria);
    $ldap_entry = ldap_first_entry($this->getLinkId(), $results);
    
    $objects = array();

    if ($ldap_entry !== false)
    {
      $objects[] = $this->createLDAPObject($ldap_entry);
      while ($ldap_entry = ldap_next_entry($this->getLinkId(), $ldap_entry))
      {
        $objects[] = $this->createLDAPObject($ldap_entry);
      }
    }
    
    return $objects;
  }

  public function doAdd(LDAPObject $ldap_object)
  {
    if ( ! parent::doAdd($ldap_object) )
    {
      return false;
    }

    return $this->doSubTree($ldap_object);
  }

  public function doSubTree(LDAPObject $ldap_object)
  {
    $subtree = true;
   
# Organizations
    $ldap_object_ou_org = new LdapObject();
    $ldap_object_ou_org->setDn(sprintf("ou=Organizations,%s", $ldap_object->getDn())); 
    $ldap_object_ou_org->set('ou', 'Organizations'); 
    $ldap_object_ou_org->set('objectclass', (array('top','organizationalUnit'))); 

    if ( ! parent::doAdd($ldap_object_ou_org) )
    {
      $subtree = false;
    }
    
# Servers
    $ldap_object_ou_srv = new LdapObject();
    $ldap_object_ou_srv->setDn(sprintf("ou=Servers,%s", $ldap_object->getDn())); 
    $ldap_object_ou_srv->set('ou', 'Servers'); 
    $ldap_object_ou_srv->set('objectclass', (array('top','organizationalUnit'))); 

    if ( ! parent::doAdd($ldap_object_ou_srv) )
    {
      $subtree = false;
    }

# SecurityGroups
    $ldap_object_ou_sg = new LdapObject();
    $ldap_object_ou_sg->setDn(sprintf("ou=SecurityGroups,%s", $ldap_object->getDn())); 
    $ldap_object_ou_sg->set('ou', 'SecurityGroups'); 
    $ldap_object_ou_sg->set('objectclass', (array('top','organizationalUnit'))); 

    if ( ! parent::doAdd($ldap_object_ou_sg) )
    {
      $subtree = false;
    }

    $ldap_object_sg_orgadmin = new LdapObject();
    $ldap_object_sg_orgadmin->setDn(sprintf("cn=OrganizationAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
    $ldap_object_sg_orgadmin->set('cn', 'OrganizationAdmin'); 
    $ldap_object_sg_orgadmin->set('objectclass', (array('top','miniSecurityGroup'))); 

    if ( ! parent::doAdd($ldap_object_sg_orgadmin) )
    {
      $subtree = false;
    }
 
    $ldap_object_sg_srvadmin = new LdapObject();
    $ldap_object_sg_srvadmin->setDn(sprintf("cn=ServerAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
    $ldap_object_sg_srvadmin->set('cn', 'ServerAdmin'); 
    $ldap_object_sg_srvadmin->set('objectclass', (array('top','miniSecurityGroup'))); 

    if ( ! parent::doAdd($ldap_object_sg_srvadmin) )
    {
      $subtree = false;
    }

    return $subtree;
  }

  public function doSelectOne(LDAPCriteria $ldap_criteria)
  {
    $results = $this->select($ldap_criteria);
    $first_entry = ldap_first_entry($this->getLinkid(), $results);
    return $this->createLDAPObject($first_entry);
  }

  public function retrieveBy($attribute, $value)
  {
    $ldap_criteria = new LDAPCriteria();
    $ldap_criteria->add($attribute, $value);
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
    $ldap_criteria->add('objectClass', 'miniPlatform');

    return $this->doSelectOne($ldap_criteria);
  }

  public function doSave(LDAPObject $ldap_object)
  {
    if ( ! parent::doSave($ldap_object) )
    {
      return false;
    }
    return true;
  }

  public function doDelete(LDAPObject $ldap_object, $recursive=false)
  {
    if ( ! parent::doDelete($ldap_object, $recursive) )
    {
      return false;
    }
    return true;
  }

}
