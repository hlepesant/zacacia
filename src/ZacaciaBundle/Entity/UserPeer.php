<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;
use LdapTools\Query\Operator\bOr;
use LdapTools\Query\Operator\Wildcard;

class UserPeer
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

    public function createUser($user)
    {
        $dn = sprintf("cn=%s,ou=Users,%s", $user->getCn(), self::getBaseDn());

        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('user')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'           => $user->getObjectclass(),
                'cn'                    => $user->getCn(),
                'displayName'           => $user->getDisplayName(),
                'mail'                  => $user->getEmail(),
                'gidNumber'             => $user->getGidNumber(),
                'givenName'             => $user->getGivenName(),
                'homeDirectory'         => $user->getHomeDirectory(),
                'loginShell'            => $user->getLoginShell(),
                'userpassword'          => $user->getUserPassword(),
                'sn'                    => $user->getSn(),
                'uidNumber'             => $user->getUidNumber(),
                'uid'                   => $user->getUid(),
                'zacaciaStatus'         => $user->getZacaciaStatus(),
                'zarafaAccount'         => $user->getZarafaAccount(),
                'zarafaQuotaOverride'   => $user->getZarafaQuotaOverride(),
                'zarafaQuotaSoft'       => $user->getZarafaQuotaSoft(),
                'zarafaQuotaWarn'       => $user->getZarafaQuotaWarn(),
                'zarafaQuotaHard'       => $user->getZarafaQuotaHard(),
            ])
            ->execute();
        return;
    }

    public function updateUser($user)
    {
        $this->ldapmanager->persist($user);
        return;
    }

    public function deleteUser($uuid)
    {
        $user = $this->ldapmanager->getRepository('user')->getUserByUUID($uuid);

        if ( $user )
            $this->ldapmanager->delete($user);

        return;
    }
}
