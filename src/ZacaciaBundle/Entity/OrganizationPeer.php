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

        self::createSubTree($dn);

        return;
    }

    private function createSubTree($dn)
    {
        $ldapObject = $this->ldapmanager->createLdapObject();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'AddressLists'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Contacts'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Domains'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Forwards'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Groups'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'Users'])
            ->execute();

        $ldapObject->createOU()
            ->in($dn)
            ->with(['name' => 'SecurityGroups'])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=AddressListAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'AddressListAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=ContactAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'ContactAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=DomainAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'DomainAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=ForwardAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'ForwardAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=GroupAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'GroupAdmin'
            ])
            ->execute();

        $ldapObject->create('securitygroup')
            ->setDn(sprintf("cn=UserAdmin,ou=SecurityGroups,%s", $dn))
            ->in(sprintf("ou=SecurityGroups,%s", $dn))
            ->with([
                'objectClass'   => ['top', 'zacaciaSecurityGroup'],
                'cn'            => 'UserAdmin'
            ])
            ->execute();

        return;
    }

    public function updateOrganization($organization)
    {
        $this->ldapmanager->persist($organization);
        return;
    }

    public function deleteOrganization($uuid, $recursive=false)
    {
        $organization = $this->ldapmanager->getRepository('organization')->getOrganizationByUUID($uuid);

        if ( $recursive )
            self::deleteSubtree($organization->getDn());

        if ( $organization )
            $this->ldapmanager->delete($organization);

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
