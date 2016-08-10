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
        $default_user = $this->config->getDefaultUser();
        $user_config = $this->config->getUserConfiguration($default_user);
        return $user_config->getBaseDn();
    }

    public function createUser($user)
    {
        $dn = sprintf("cn=%s,ou=Users,%s", $user->getCn(), self::getBaseDn());
/*
        $user->setDn($dn);
        var_dump($user);
        $this->ldapmanager->persist($user);
        return;
*/
        $ldapObject = $this->ldapmanager->createLdapObject();
        $ldapObject->create('user')
            ->setDn($dn)
            ->in(self::getBaseDn())
            ->with([
                'objectClass'   => $user->getObjectclass(),
                'cn'            => $user->getCn(),
                'zacaciaStatus' => $user->getZacaciaStatus(),
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
/*
    public function countEmailForUser($name)
    {
        $this->config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $this->ldapmanager = new LdapManager($this->config);

        $base_dn = $this->config->getUserConfiguration($this->config->getDefaultUser())->getBaseDn();

        $query = $this->ldapmanager->buildLdapQuery();

        $results = $query->select('entryUUID')
            ->setBaseDn($base_dn)
            ->where(['objectClass' => 'top'])
            ->andWhere(['objectClass' => 'posixAccount'])
            ->andWhere(['objectClass' => 'inetOrgPerson'])
            ->andWhere(['objectClass' => 'zarafa-user'])
            ->andWhere(['objectClass' => 'zacaciaUser'])
            ->andWhere(new bOr(
              new Wildcard('mail', Wildcard::ENDS_WITH, $name),
              new Wildcard('zarafaAliases', Wildcard::ENDS_WITH, $name)
            ))
            ->setScopeSubTree()
            ->getLdapQuery()
            ->execute();

        return(count($results));
    }
 */
}
