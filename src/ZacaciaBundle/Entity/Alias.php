<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Alias extends ZacaciaObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $email;
    /**
    * @Assert\NotBlank()
    */
    protected $domain;
    /**
    * @Assert\NotBlank()
    */
    protected $platformid;
    /**
    * @Assert\NotBlank()
    */
    protected $organizationid;
    /**
    * @Assert\NotBlank()
    */
    protected $userid;


    function setEmail($email)
    {
        $this->email = parent::arrayToString($email);
        return $this;
    }

    function getEmail()
    {
        return $this->email;
    }

    function setDomain($domain)
    {
        $this->domain = parent::arrayToString($domain);
        return $this;
    }

    function getDomain()
    {
        return $this->domain;
    }

    function getPlatformId()
    {
        return $this->platformid;
    }

    function setPlatformId($id)
    {
        $this->platformid = parent::arrayToString($id);
        return $this;        
    }

    function getOrganizationId()
    {
        return $this->organizationid;
    }

    function setOrganizationId($id)
    {
        $this->organizationid = parent::arrayToString($id);
        return $this;        
    }

    function getUserId()
    {
        return $this->userid;
    }

    function setUserId($uuid)
    {
        $this->userid = parent::arrayToString($uuid);
        return $this;        
    }
}
