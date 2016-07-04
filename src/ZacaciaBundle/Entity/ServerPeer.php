<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

class ServerPeer
{
    protected $config;
    protected $ldapmanager;

    public function __construct($platform_base_dn)
    {
        $this->config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $this->ldapmanager = new LdapManager($this->config);

        $this->config->getDomainConfiguration($this->config->getDefaultDomain())->setBaseDn($platform_base_dn);

        return true;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getLdapManager()
    {
        return $this->ldapmanager;
    }

    public function getBaseDn()
    {
        $default_domain = $this->config->getDefaultDomain();
        $domain_config = $this->config->getDomainConfiguration($default_domain);
        return $domain_config->getBaseDn()          ;
    }

    public function createServer($server)
    {
        $dn = sprintf("cn=%s,ou=Servers,%s", $server->getCn(), self::getBaseDn());
/*
        $server->setDn($dn);
        var_dump($server);
        $this->ldapmanager->persist($server);
        return;
*/
        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('server')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'   => $server->getObjectclass(),
                'cn'            => $server->getCn(),
                'zacaciaStatus' => $server->getZacaciaStatus(),
                'ipHostNumber'  => $server->getipHostNumber(),
                'zarafaAccount' => $server->getZarafaAccount(),
                'zarafaFilePath'=> $server->getZarafaFilePath(),
                'zarafaHttpPort'=> $server->getZarafaHttpPort(),
                'zarafaSslPort' => $server->getZarafaSslPort(),
            ])
            ->execute();
        return;
    }

    public function updateServer($server)
    {
        $this->ldapmanager->persist($server);
        return;
    }

    public function deleteServer($uuid)
    {
        $server = $this->ldapmanager->getRepository('server')->getServerByUUID($uuid);

        if ( $server )
            $this->ldapmanager->delete($server);

        return;
    }
}
