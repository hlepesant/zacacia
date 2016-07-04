<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

class PlatformPeer
{
    protected $config;
    protected $ldapmanager;

    public function __construct()
    {
        $this->config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $this->ldapmanager = new LdapManager($this->config);

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

    public function createPlatform($platform)
    {
        $dn = sprintf("cn=%s,ou=Platforms,%s", $platform->getCn(), self::getBaseDn());

        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('platform')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'   => $platform->getObjectclass(),
                'cn'            => $platform->getCn(),
                'zacaciaStatus' => $platform->getZacaciaStatus()
            ])
            ->execute();

        self::createSubTree($dn);

        return;
    }

    public function updatePlaform($platform)
    {
        $this->ldapmanager->persist($platform);
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

    public function deletePlatform($uuid, $recursive=false)
    {

        $platform = $this->ldapmanager->getRepository('platform')->getPlatformByUUID($uuid);

        if ( $recursive )
            self::deleteSubtree($platform->getDn());

        if ( $platform )
            $this->ldapmanager->delete($platform);

        return;
    }

    private function deleteSubtree($dn)
    {
        $query = $this->ldapmanager->buildLdapQuery();
        $results = $query->select('entryUUID')
            ->where(['objectClass' => 'top'])
            ->setBaseDn($dn)
            ->setScopeSubTree()
            ->getLdapQuery()
            ->execute();

        $arrayOfDn = array();
        $i=0;

        foreach( $results as $result  ) {
            if ( $result->getDn() != $dn ) {
                $arrayOfDn[$i]['uuid'] = $result->getEntryUUID();
                $arrayOfDn[$i]['dn'] = $result->getDn();
                $i++;
            }
        }

        rsort($arrayOfDn);

        foreach( $arrayOfDn as $item  ) {
            $query = $this->ldapmanager->buildLdapQuery();
            $object = $query->select('entryUUID')
                ->Where(['entryUUID' => $item['uuid']])
                ->setBaseDn($dn)
                ->setScopeSubTree()
                ->getLdapQuery()
                ->getOneOrNullResult();
            $this->ldapmanager->delete($object);
        }
        return true;
    }
}
