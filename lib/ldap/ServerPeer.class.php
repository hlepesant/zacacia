<?php

class ServerPeer extends BaseServerPeer
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

    public function getServers($dn)
    {
        $this->setBaseDn(sprintf("ou=Servers,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-server');
        $criteria->add('objectClass', 'ipHost');
        $criteria->add('objectClass', 'zacaciaServer');
        #$criteria->add('objectClass', Array('top', 'organizationalRole', 'zarafa-server', 'ipHost', 'zacaciaServer'));

        return $this->doSelect($criteria);
    }

    public function countUser($platform, $server)
    {
        $this->setBaseDn(sprintf("ou=Organizations,%s", $platform->getDn()));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('zacaciaUserServer', $server->getCn());

        return $this->doCount($criteria);
    }

}
