<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class PlatformRepository
class PlatformRepository extends LdapObjectRepository
{
    public function getAllPlatforms()
    {
        $platforms = $this->buildLdapQuery()
            ->Where(['zacaciaStatus' => 'enable'])
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
}