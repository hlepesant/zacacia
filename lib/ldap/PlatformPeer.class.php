<?php

class PlatformPeer extends BasePlatformPeer
{
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
        $ldap_object_sg_orgadmin->set('objectclass', (array('top','miniSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_orgadmin) ) {
            $subtree = false;
        }

        $ldap_object_sg_srvadmin = new LdapObject();
        $ldap_object_sg_srvadmin->setDn(sprintf("cn=ServerAdmin,ou=SecurityGroups,%s", $ldap_object->getDn())); 
        $ldap_object_sg_srvadmin->set('cn', 'ServerAdmin'); 
        $ldap_object_sg_srvadmin->set('objectclass', (array('top','miniSecurityGroup'))); 
        
        if ( ! parent::doAdd($ldap_object_sg_srvadmin) ) {
            $subtree = false;
        }

        return $subtree;
    }
}
