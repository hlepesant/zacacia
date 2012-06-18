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
        #$criteria->add('objectClass', Array('top', 'organizationalRole', 'zarafa-server', 'ipHost', 'zacaciaServer'));

        return $this->doSelect($criteria);
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

    public function getNewGidNumber()
    {
        $gidNumber = sfConfig::get('gid_min');

        $l = clone $this;
        $l->setBaseDn(sfConfig::get('ldap_base_dn'));

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-company');
        $c->add('objectClass', 'zacaciaCompany');
        $c->add('cn', '*');
      
        if ( $companies = $l->doSelect($c) ) {
            $gids = array();
            foreach( $companies as $company ) {
                $gids[] = $company->getGidNumber();
            }
            rsort($gids);
            $gidNumber = $gids[0] + 1;
        }

        return $gidNumber;
    }
*/
}
