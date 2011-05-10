<?php

class CompanyPeer extends BaseCompanyPeer
{
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
        foreach( $servers as $server )
        {
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
        foreach( $users as $user )
        {
            $options[ $user->getDn() ] = $user->getCn();
        }
        return $options;
    }
}
