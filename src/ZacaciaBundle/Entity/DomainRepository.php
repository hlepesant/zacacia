<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class DomainRepository
class DomainRepository extends LdapObjectRepository
{
    public function getAllDomains()
    {
        $platforms = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }

    public function getDomainByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getDomainByName($name)
    {
        $domains = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $domains;
    }
}
