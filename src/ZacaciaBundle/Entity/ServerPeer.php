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

        self::createSubTree($dn);

        return;
    }

    public function updatePlaform($server)
    {
        $this->ldapmanager->persist($server);
        return;
    }

    private function createSubTree($dn)
    {
        $ldapObject = $this->ldapmanager->createLdapObject();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Organizations'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Servers'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'SecurityGroups'])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=OrganizationAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'OrganizationAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=ServerAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'ServerAdmin'
            ])
            ->execute();

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
