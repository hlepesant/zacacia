<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class UserRepository
class AliasRepository extends LdapObjectRepository
{
    public function getAllAliases()
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getUserByEmailOrAlias($email)
    {
        $users = $this->buildLdapQuery()
            ->OrWhere(['mail' => $email])        
            ->OrWhere(['zarafaAliases' => $email])        
            ->getLdapQuery()
            ->getResult();

        return $users;
    }
}
