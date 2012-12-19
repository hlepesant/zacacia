<?php

class UserPeer extends BaseUserPeer
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

    public function getUsers($dn)
    {
        $this->setBaseDn(sprintf("ou=Users,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');

        return $this->doSelect($criteria, 'UserObject');
    }

    public function getUser($dn)
    {
        $this->setBaseDn($dn);

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');

        return $this->doSelectOne($criteria, 'UserObject');
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

    public function getNewUidNumber()
    {
        $uidNumber = sfConfig::get('uid_min');

        // $l = clone $this;
        $this->setBaseDn(sfConfig::get('ldap_base_dn'));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        $criteria->add('cn', '*');
        $criteria->setAttributes(array('uidNumber'));
       
        if ( $users = $this->doSelect($criteria, 'BaseUserObject') ) {
            $uids = array();
            foreach( $users as $user ) {
                $uids[] = $user->getUidNumber();
            }
            rsort($uids);
            $uidNumber = $uids[0] + 1;
        }

        return $uidNumber;
    }

    public function doCheckCn($companyDn, $userCn)
    {
        $this->setBaseDn(sprintf("ou=Users,%s", $companyDn));
        
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        $criteria->add('cn', $userCn);
        
        return $this->doCount($criteria);
    }

    public function doCheckUid($uid)
    {
        $this->setBaseDn( sfConfig::get('ldap_base_dn') );
        
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');
        $criteria->add('uid', $uid);
        
        return $this->doCount($criteria);
    }

    public function doCheckEmailAddress($email)
    {
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
