<?php

class CompanyPeer extends BaseCompanyPeer
{
    public function getOptionForSelect($platformDn)
    {
        $this->setBaseDn(sprintf("ou=Servers,%s", $platformDn));

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-server');
        $c->add('objectClass', 'ipHost');
        $c->add('objectClass', 'miniServer');
        
        $servers = $this->doSelect($c);

        $options = array();
        foreach( $servers as $server )
        {
            $options[ $server->getDn() ] = $server->getCn();
        }
        return $options;
    }
}
