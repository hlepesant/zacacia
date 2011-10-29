<?php

class BaseCompanyPeer extends LDAPPeer
{
    protected $base_dn;
    public static $exclude_attrs = array();

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
#       $ldap_criteria->setHost(self::HOST);
#       $ldap_criteria->setUsername(self::USERNAME);
#       $ldap_criteria->setPassword(self::PASSWORD);
#       $ldap_criteria->setUseSsl(self::USE_SSL);
#       if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn(self::BASE_DN);
        if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn($this->getBaseDn());
        
        return $ldap_criteria;
    }
/*
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
*/
    private function createLDAPObject($ldap_entry, $ldap_object = 'base')
    {
        $attributes = $this->extractAttributes($ldap_entry);
        $values = $this->extractValues($ldap_entry, $attributes);
        $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);

        switch ($ldap_object)
        {
            case 'extended':
                $ldap_object = new CompanyObject();
            break;

            case 'base':
            default:
                $ldap_object = new BaseCompanyObject();
            break;
        }

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
        
        if ($ldap_entry !== false) {
            $objects[] = $this->createLDAPObject($ldap_entry, $ldap_object);
            while ($ldap_entry = ldap_next_entry($this->getLinkId(), $ldap_entry)) {
                $objects[] = $this->createLDAPObject($ldap_entry, $ldap_object);
            }
        }
        
        return $objects;
    }

    public function doAdd(LDAPObject $ldap_object)
    {
        if ( ! parent::doAdd($ldap_object) ) {
          return false;
        }
        
        return $this->doSubTree($ldap_object);
    }


    public function doSubTree(LDAPObject $ldap_object)
    {
        $subtree = true;

        # AddressLists
        $ldap_object_ou_1 = new LdapObject();
        $ldap_object_ou_1->setDn(sprintf("ou=AddressLists,%s", $ldap_object->getDn())); 
        $ldap_object_ou_1->set('ou', 'AddressLists'); 
        $ldap_object_ou_1->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_1 ) )
        {
            $subtree = false;
        }

        # Contacts
        $ldap_object_ou_2 = new LdapObject();
        $ldap_object_ou_2->setDn(sprintf("ou=Contacts,%s", $ldap_object->getDn())); 
        $ldap_object_ou_2->set('ou', 'Contacts'); 
        $ldap_object_ou_2->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_2) )
        {
            $subtree = false;
        }

        # Domains
        $ldap_object_ou_3 = new LdapObject();
        $ldap_object_ou_3->setDn(sprintf("ou=Domains,%s", $ldap_object->getDn())); 
        $ldap_object_ou_3->set('ou', 'Domains'); 
        $ldap_object_ou_3->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_3) )
        {
            $subtree = false;
        }

        # Forwards
        $ldap_object_ou_4 = new LdapObject();
        $ldap_object_ou_4->setDn(sprintf("ou=Forwards,%s", $ldap_object->getDn())); 
        $ldap_object_ou_4->set('ou', 'Forwards'); 
        $ldap_object_ou_4->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_4) )
        {
            $subtree = false;
        }

        # Groups
        $ldap_object_ou_5 = new LdapObject();
        $ldap_object_ou_5->setDn(sprintf("ou=Groups,%s", $ldap_object->getDn())); 
        $ldap_object_ou_5->set('ou', 'Groups'); 
        $ldap_object_ou_5->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_5) )
        {
            $subtree = false;
        }

        # Users
        $ldap_object_ou_6 = new LdapObject();
        $ldap_object_ou_6->setDn(sprintf("ou=Users,%s", $ldap_object->getDn())); 
        $ldap_object_ou_6->set('ou', 'Users'); 
        $ldap_object_ou_6->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_6) )
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

        $ldap_object_sg_1 = new LdapObject();
        $ldap_object_sg_1->setDn(sprintf("cn=AddressListAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_1->set('cn', 'AddressListAdmin'); 
        $ldap_object_sg_1->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_1) )
        {
            $subtree = false;
        }

        $ldap_object_sg_2 = new LdapObject();
        $ldap_object_sg_2->setDn(sprintf("cn=ContactAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_2->set('cn', 'ContactAdmin'); 
        $ldap_object_sg_2->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_2) )
        {
            $subtree = false;
        }

        $ldap_object_sg_3 = new LdapObject();
        $ldap_object_sg_3->setDn(sprintf("cn=DomainAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_3->set('cn', 'DomainAdmin'); 
        $ldap_object_sg_3->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_3) )
        {
            $subtree = false;
        }

        $ldap_object_sg_4 = new LdapObject();
        $ldap_object_sg_4->setDn(sprintf("cn=ForwardAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_4->set('cn', 'ForwardAdmin'); 
        $ldap_object_sg_4->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_4) )
        {
            $subtree = false;
        }

        $ldap_object_sg_5 = new LdapObject();
        $ldap_object_sg_5->setDn(sprintf("cn=GroupAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_5->set('cn', 'GroupAdmin'); 
        $ldap_object_sg_5->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_5) )
        {
            $subtree = false;
        }

        $ldap_object_sg_6 = new LdapObject();
        $ldap_object_sg_6->setDn(sprintf("cn=UserAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_6->set('cn', 'UserAdmin'); 
        $ldap_object_sg_6->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_6) )
        {
            $subtree = false;
        }

        return $subtree;
    }

    public function doSelectOne(LDAPCriteria $ldap_criteria, $ldap_object = 'base')
    {
        $ldap_criteria = self::configureCriteria($ldap_criteria);
        $results = $this->select($ldap_criteria);
        $first_entry = ldap_first_entry($this->getLinkid(), $results);
        return $this->createLDAPObject($first_entry, $ldap_object);
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

    public function retrieveByDn(LDAPCriteria $ldap_criteria, $ldap_object = 'base')
    {
        $ldap_criteria->setSearchScope(LDAPCriteria::BASE);
        $ldap_criteria->add('objectClass', 'top');
        $ldap_criteria->add('objectClass', 'organizationalRole');
        $ldap_criteria->add('objectClass', 'zarafa-company');
        $ldap_criteria->add('objectClass', 'zacaciaCompany');
        $ldap_criteria = self::configureCriteria($ldap_criteria);
        
        return $this->doSelectOne($ldap_criteria, $ldap_object);
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
