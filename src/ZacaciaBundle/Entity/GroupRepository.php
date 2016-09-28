<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class UserRepository
class GroupRepository extends LdapObjectRepository
{
    public function getAllGroups()
    {
        $platforms = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }

    public function getGroupByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getGroupByName($name)
    {
        $domains = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $domains;
    }

    public function getGroupByEmail($email)
    {
        $users = $this->buildLdapQuery()
            ->Where(['mail' => $email])        
            ->getLdapQuery()
            ->getResult();

        return $users;
    }

    public function getGroupByEmailOrAlias($email)
    {
        $users = $this->buildLdapQuery()
            ->OrWhere(['mail' => $email])        
            ->OrWhere(['zarafaAliases' => $email])        
            ->getLdapQuery()
            ->getResult();

        return $users;
    }
}
