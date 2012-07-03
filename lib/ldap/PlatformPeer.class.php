<?php

class PlatformPeer extends BasePlatformPeer
{
    protected
        $ldap = null;

    public function __construct()
    {
        $this->ldap = parent::__construct();
        return $this;
    }

    public function getPlatforms()
    {
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->setSortFilter('cn');

        $this->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));
        #return $this->doSelect($criteria, 'BasePlatformObject');

        $platforms = $this->doSelect($criteria, 'PlatformObject');

        foreach ($platforms as $platform) {
            $platform->set('company_count', $this->countCompanyOnPlatform($platform));
            $platform->set('server_count', $this->countServerOnPlatform($platform));
        }

        return $platforms;
    }

    public function countCompanyOnPlatform($platform)
    {
        $this->setBaseDn($platform->getDn());

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-company');
        $criteria->add('objectClass', 'zacaciaCompany');

        return $this->doCount($criteria);
    }

    public function countServerOnPlatform($platform)
    {
        $this->setBaseDn($platform->getDn());

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-server');
        $criteria->add('objectClass', 'ipHost');
        $criteria->add('objectClass', 'zacaciaServer');

        return $this->doCount($criteria);
    }

/*
    public function getPlatformsAsOption()
    {
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->setSortFilter('cn');

        $this->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));
        $result =  $this->doSelect($criteria);

        $p = array();
        foreach( $result as $platform ) {
            $p[ $platform->setDn64() ] = $platform->getCn();
        }
        return $p;
    }
*/

    public function getPlatform($dn)
    {
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->setSortFilter('cn');

        $this->setBaseDn($dn);
        return $this->doSelectOne($criteria, 'BasePlatformObject');
    }

    public function countCompany($dn)
    {
        $criteria = new LDAPCriteria();
        $criteria->setBaseDn(sprintf("ou=Organizations,%s", $dn));
        $criteria->add('objectClass', 'zacaciaCompany');
        $criteria->add('cn', '*');
        return $this->doCount($criteria);
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

        # Organizations
        $ldap_object_ou_org = new LdapObject();
        $ldap_object_ou_org->setDn(sprintf("ou=Organizations,%s", $ldap_object->getDn())); 
        $ldap_object_ou_org->set('ou', 'Organizations'); 
        $ldap_object_ou_org->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_org) ) {
            $subtree = false;
        }

        # Servers
        $ldap_object_ou_srv = new LdapObject();
        $ldap_object_ou_srv->setDn(sprintf("ou=Servers,%s", $ldap_object->getDn())); 
        $ldap_object_ou_srv->set('ou', 'Servers'); 
        $ldap_object_ou_srv->set('objectclass', (array('top','organizationalUnit'))); 

        if ( ! parent::doAdd($ldap_object_ou_srv) ) {
            $subtree = false;
        }

        # SecurityGroups
        $ldap_object_ou_sg = new LdapObject();
        $ldap_object_ou_sg->setDn(sprintf("ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_ou_sg->set('ou', 'SecurityGroups'); 
        $ldap_object_ou_sg->set('objectclass', (array('top','organizationalUnit'))); 
        
        if ( ! parent::doAdd($ldap_object_ou_sg) ) {
            $subtree = false;
        }

        $ldap_object_sg_orgadmin = new LdapObject();
        $ldap_object_sg_orgadmin->setDn(sprintf("cn=OrganizationAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_orgadmin->set('cn', 'OrganizationAdmin'); 
        $ldap_object_sg_orgadmin->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_orgadmin) ) {
            $subtree = false;
        }

        $ldap_object_sg_srvadmin = new LdapObject();
        $ldap_object_sg_srvadmin->setDn(sprintf("cn=ServerAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_srvadmin->set('cn', 'ServerAdmin'); 
        $ldap_object_sg_srvadmin->set('objectclass', (array('top','zacaciaSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_srvadmin) ) {
            $subtree = false;
        }

        return $subtree;
    }

    public function doSearch($cn)
    {
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->add('cn', $cn);

        $this->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));
        
        return $this->doCount($criteria);
    }

    
}
