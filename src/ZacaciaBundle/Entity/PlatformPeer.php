<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;
//use LdapTools\Object\LdapObjectRepository;


//class PlatformPeer
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

    public function createPlaform($platform)
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
/*
        $platform = $this->ldapmanager->buildLdapQuery()->fromPlatform()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
*/
        self::deleteSubtree($platform->getDn());

        exit;

        if ( $platform )
            $this->ldapmanager->delete($platform);

        return;
 
        if ($recursive == false) {
            return (ldap_delete($this->getLinkId(), $ldap_object->getDn()));
        } else {
            //searching for sub entries
            $sr=ldap_list($this->getLinkId(),$ldap_object->getDn(),"ObjectClass=*",array(""));
            $info = ldap_get_entries($this->getLinkId(), $sr);

            for($i=0;$i<$info['count'];$i++) {
                //deleting recursively sub entries
                $sub_object = new LDAPObject();
                $sub_object->setDn($info[$i]['dn']);

                $result = $this->doDelete($sub_object,$recursive);
                if(!$result){
                    print( ldap_error( $this->getLinkdId() ) );
                }
            }
            return (ldap_delete($this->getLinkId(), $ldap_object->getDn()));
        }
    }

    private function deleteSubtree($dn)
    {
//        print $dn;

        $result = $query->select('dn')
            ->where( $query->filter()->present('objectClass'))
            ->setBaseDn($dn)
            ->setScopeBase()
            ->getLdapQuery()
            ->execute();

        print_r($result);
        exit;

        $filter = $this->ldapmanager->buildLdapQuery()->select('dn')
            ->Where(['objectClass' => 'top'])
            ->toLdapFilter();
//            ->getLdapQuery()
//            ->getResult();

        echo "LDAP Filter: ".$filter.PHP_EOL;
        exit;
    }
}