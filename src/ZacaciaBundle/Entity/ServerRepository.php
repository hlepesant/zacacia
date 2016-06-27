<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class ServerRepository
class ServerRepository extends LdapObjectRepository
{
    public function getAllServers()
    {
        $platforms = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }

    public function getServerByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }
}
