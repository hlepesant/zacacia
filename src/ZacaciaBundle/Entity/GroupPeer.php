<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;
use LdapTools\Query\Operator\bOr;
use LdapTools\Query\Operator\Wildcard;

class GroupPeer
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
        $group_config = $this->config->getDomainConfiguration($default_domain);
        return $group_config->getBaseDn();
    }

    public function createGroup($group)
    {
        $dn = sprintf("cn=%s,ou=Groups,%s", $group->getCn(), self::getBaseDn());

        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('group')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'       => $group->getObjectclass(),
                'cn'                => $group->getCn(),
                'mail'              => $group->getEmail(),
                'zacaciaStatus'     => $group->getZacaciaStatus(),
                'zarafaHidden'      => $group->getZarafaHidden(),
                'zarafaAccount'     => $group->getZarafaAccount(),
                'member'            => $group->getMember(),
            ])
            ->execute();
        return;
    }

    public function updateGroup($group)
    {
        $this->ldapmanager->persist($group);
        return;
    }

    public function deleteGroup($uuid)
    {
        $group = $this->ldapmanager->getRepository('group')->getGroupByUUID($uuid);

        if ( $group )
            $this->ldapmanager->delete($group);

        return;
    }
}
