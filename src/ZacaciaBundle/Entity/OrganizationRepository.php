<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;
use LdapTools\Query\LdapQueryBuilder;


//class OrganizationRepository
class OrganizationRepository extends LdapObjectRepository
{
    public function getAllOrganizations()
    {
        $organizations = $this->buildLdapQuery()
            ->orderBy('ou')
            ->getLdapQuery()
            ->getResult();

        return $organizations;
    }

    public function getOrganizationByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getOrganizationByName($name)
    {
        $organizations = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $organizations;
    }

    public function getOrganizationByIpAddress($ip)
    {
        $organizations = $this->buildLdapQuery()
            ->Where(['ipHostNumber' => $ip])        
            ->getLdapQuery()
            ->getResult();

        return $organizations;
    }
}
