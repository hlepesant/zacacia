<?php

class CompanyPeer extends BaseCompanyPeer
{
    protected
        $ldap = null;

    public function __construct()
    {
        $this->ldap = parent::__construct();
        return $this;
    }

    public function getPlatform($dn)
    {
        $this->setBaseDn($dn);
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->setSortFilter('cn');

        return $this->doSelectOne($criteria);
    }

    public function getCompanies($dn)
    {
        $this->setBaseDn(sprintf("ou=Organizations,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-company');
        $criteria->add('objectClass', 'zacaciaCompany');

        return $this->doSelect($criteria, 'extended');
    }

    public function countDomains($dn)
    {
        $this->setBaseDn(sprintf("ou=Domains,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaDomain');

        return $this->doCount($criteria);
    }

    public function countUsers($dn)
    {
        $this->setBaseDn(sprintf("ou=Users,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');

        return $this->doCount($criteria);
    }

    public function countGroups($dn)
    {
        $this->setBaseDn(sprintf("ou=Groups,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-group');
        $criteria->add('objectClass', 'zacaciaGroup');

        return $this->doCount($criteria);
    }

    public function countForwards($dn)
    {
        $this->setBaseDn(sprintf("ou=Forwards,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'zacaciaForward');

        return $this->doCount($criteria);
    }

    public function countContacts($dn)
    {
        $this->setBaseDn(sprintf("ou=Contacts,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'zarafa-contact');
        $criteria->add('objectClass', 'zacaciaContact');

        return $this->doCount($criteria);
    }

    public function countAddressLists($dn)
    {
        $this->setBaseDn(sprintf("ou=AddressLists,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'zarafa-addresslist');
        #$criteria->add('objectClass', 'zacaciaAddressList');

        return $this->doCount($criteria);
    }

    public function getNewGidNumber()
    {
        $gidNumber = sfConfig::get('gid_min');

        $this->setBaseDn(sfConfig::get('ldap_base_dn'));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-company');
        $criteria->add('objectClass', 'zacaciaCompany');
        $criteria->add('cn', '*');
      
        if ( $companies = $this->doSelect($criteria) ) {
            $gids = array();
            foreach( $companies as $company ) {
                $gids[] = $company->getGidNumber();
            }
            rsort($gids);
            $gidNumber = $gids[0] + 1;
        }

        return $gidNumber;
    }

/*
    public function getServerOptionList($platformDn)
    {
        $this->setBaseDn(sprintf("ou=Servers,%s", $platformDn));

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-server');
        $c->add('objectClass', 'ipHost');
        $c->add('objectClass', 'zacaciaServer');
        
        $servers = $this->doSelect($c);

        #$options = array();
        $options = array(sfConfig::get('undefined') => 'none');

        foreach( $servers as $server ) {
            $options[ $server->getDn() ] = $server->getCn();
        }
        return $options;
    }

    public function getUserOptionList($platformDn)
    {
        $this->setBaseDn(sprintf(sfConfig::get('ldap_base_dn')));

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        
        $users = $this->doSelect($c);

        #$options = array();
        $options = array(sfConfig::get('undefined') => 'none');

        foreach( $users as $user ) {
            $options[ $user->getDn() ] = $user->getCn();
        }
        return $options;
    }
*/
}
