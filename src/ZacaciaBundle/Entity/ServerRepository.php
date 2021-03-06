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

    public function getServerByName($name)
    {
        $servers = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $servers;
    }

    public function getServerByIpAddress($ip)
    {
        $servers = $this->buildLdapQuery()
            ->Where(['ipHostNumber' => $ip])        
            ->getLdapQuery()
            ->getResult();

        return $servers;
    }
}
