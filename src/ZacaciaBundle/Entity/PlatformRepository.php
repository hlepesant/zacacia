<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;

class PlatformRepository extends LdapObjectRepository
{
    public function getAllPlatforms()
    {
        $platforms = $this->buildLdapQuery()
            //->Where(['zacaciaStatus' => 'enable'])
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }

    public function getPlatformByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getPlatformByName($name)
    {
        $platforms = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }
}