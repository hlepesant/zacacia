<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

class OrganizationPeer
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

    public function createOrganization($organization)
    {
        $dn = sprintf("cn=%s,ou=Organizations,%s", $organization->getCn(), self::getBaseDn());

/*
        $organization->setDn($dn);
        var_dump($organization);
        $this->ldapmanager->persist($organization);
        return;
*/
        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('organization')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'   => $organization->getObjectclass(),
                'cn'            => $organization->getCn(),
                'ou'            => $organization->getCn(),
                'zacaciaStatus' => $organization->getZacaciaStatus(),
                'zarafaAccount' => $organization->getZarafaAccount(),
                'zarafaHidden'  => $organization->getZarafaHidden(),
            ])
            ->execute();
        return;
    }

    public function updateOrganization($organization)
    {
        $this->ldapmanager->persist($organization);
        return;
    }

    public function deleteOrganization($uuid)
    {
        $organization = $this->ldapmanager->getRepository('organization')->getOrganizationByUUID($uuid);

        if ( $organization )
            $this->ldapmanager->delete($organization);

        return;
    }
}
