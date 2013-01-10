<?php

class GroupPeer extends BaseGroupPeer
{

    public function getPlatform($dn)
    {
        $this->setBaseDn($dn);
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaPlatform');

        return $this->doSelectOne($criteria, 'BasePlatformObject');
    }

    public function getCompany($dn)
    {
        $this->setBaseDn($dn);

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-company');
        $criteria->add('objectClass', 'zacaciaCompany');

        return $this->doSelectOne($criteria, 'BaseCompanyObject');
    }

    public function getGroups($dn)
    {
        $this->setBaseDn(sprintf("ou=Groups,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'groupOfNames');
        $criteria->add('objectClass', 'zarafa-group');
        $criteria->add('objectClass', 'zacaciaGroup');

        return $this->doSelect($criteria, 'GroupObject');
    }

    public function getGroup($dn)
    {
        $this->setBaseDn($dn);

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'groupOfNames');
        $criteria->add('objectClass', 'zarafa-group');
        $criteria->add('objectClass', 'zacaciaGroup');

        return $this->doSelectOne($criteria, 'GroupObject');
    }

    public function getDomainsAsOption($dn)
    {
        $this->setBaseDn(sprintf("ou=Domains,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaDomain');
        
        $domains = $this->doSelect($criteria, 'domainObject');
        $options = array();
        foreach ( $domains as $domain ) {
            $options[ $domain->getCn() ] = sprintf("@%s", $domain->getCn() );
        }

        return $options;
    }

    public function getUsersAsOption($dn)
    {
        $this->setBaseDn(sprintf("ou=Users,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        
        $users = $this->doSelect($criteria, 'userObject');
        $options = array();
        foreach ( $users as $user ) {
            $options[ $user->getDn() ] = sprintf("%s", $user->getCn() );
        }

        return $options;
    }

    public function doCheckCn($companyDn, $groupCn)
    {
        $this->setBaseDn(sprintf("ou=Groups,%s", $companyDn));
        
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'groupOfNames');
        $criteria->add('objectClass', 'zarafa-group');
        $criteria->add('objectClass', 'zacaciaGroup');
        $criteria->add('cn', $groupCn);
        
        return $this->doCount($criteria);
    }

    public function doCheckEmailAddress($email)
    {
        print("check in user too !!!"); exit;
        $this->setBaseDn( sfConfig::get('ldap_base_dn') );

        $criteria = new LDAPCriteria();
        $criteria->addOr('mail', $email);
        $criteria->addOr('mailAlternateAddress', $email);
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        
        return $this->doCount($criteria);
    }

    public function doCheckEmailAddressForUpdate($dn, $email)
    {
        print("check in user too !!!"); exit;
        $this->setBaseDn( sfConfig::get('ldap_base_dn') );

        $criteria = new LDAPCriteria();
        $criteria->addNot('entryDN', $dn);
        $criteria->add('mail', $email);
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        
        return $this->doCount($criteria);
    }

}
