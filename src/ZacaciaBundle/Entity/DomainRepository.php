<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class DomainRepository
class DomainRepository extends LdapObjectRepository
{
    public function getAllDomains()
    {
        $domains = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $domains;
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

    public function getAllDomainsAsChoice()
    {
        $results = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        $domains = array();

        foreach( $results as $result ) {
          $domains[sprintf('@%s', $result->getCn())] = $result->getCn();
        } 

        return $domains;
    }
}
