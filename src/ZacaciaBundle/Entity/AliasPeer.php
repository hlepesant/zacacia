<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;
#use LdapTools\Query\Operator\bOr;
#use LdapTools\Query\Operator\Wildcard;

class AliasPeer
{
    protected $config;
    protected $ldapmanager;

    public function __construct($organisation_base_dn)
    {
        $this->config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $this->ldapmanager = new LdapManager($this->config);

        $this->config->getDomainConfiguration($this->config->getDefaultDomain())->setBaseDn($organisation_base_dn);

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
        $user_config = $this->config->getDomainConfiguration($default_domain);
        return $user_config->getBaseDn();
    }

    public function updateAliases($user)
    {
        $this->ldapmanager->persist($user);
        return;
    }
}
