<?php

namespace ZacaciaBundle\Entity;

use LdapTools\Object\LdapObjectRepository;


//class UserRepository
class UserRepository extends LdapObjectRepository
{
    public function getAllUsers()
    {
        $platforms = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        return $platforms;
    }

    public function getUserByUUID($uuid)
    {
        return $this->buildLdapQuery()
            ->Where(['entryUUID' => $uuid])
            ->getLdapQuery()
            ->getOneOrNullResult();
    }

    public function getUserByName($name)
    {
        $domains = $this->buildLdapQuery()
            ->Where(['cn' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $domains;
    }

    public function getUserByUsername($name)
    {
        $domains = $this->buildLdapQuery()
            ->Where(['uid' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $domains;
    }

    public function getUserByDisplayname($name)
    {
        $domains = $this->buildLdapQuery()
            ->Where(['displayname' => $name])        
            ->getLdapQuery()
            ->getResult();

        return $domains;
    }

    public function getUserByEmail($email)
    {
        $users = $this->buildLdapQuery()
            ->Where(['mail' => $email])        
            ->getLdapQuery()
            ->getResult();

        return $users;
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

    public function getAllUsersAsChoice()
    {
        $results = $this->buildLdapQuery()
            ->orderBy('cn')
            ->getLdapQuery()
            ->getResult();

        $userss = array();

        foreach( $results as $result ) {
          $userss[$result->getDisplayName()] = sprintf('%s', $result->getDn());
        } 

        return $userss;
    }
}
