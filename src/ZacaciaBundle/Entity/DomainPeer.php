<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

class DomainPeer
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

    public function createDomain($domain)
    {
        $dn = sprintf("cn=%s,ou=Domains,%s", $domain->getCn(), self::getBaseDn());
/*
        $domain->setDn($dn);
        var_dump($domain);
        $this->ldapmanager->persist($domain);
        return;
*/
        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('domain')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'   => $domain->getObjectclass(),
                'cn'            => $domain->getCn(),
                'zacaciaStatus' => $domain->getZacaciaStatus(),
            ])
            ->execute();
        return;
    }

    public function updateDomain($domain)
    {
        $this->ldapmanager->persist($domain);
        return;
    }

    public function deleteDomain($uuid)
    {
        $domain = $this->ldapmanager->getRepository('domain')->getDomainByUUID($uuid);

        if ( $domain )
            $this->ldapmanager->delete($domain);

        return;
    }
}
