<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Group extends ZacaciaObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $cn;

    protected $email;
    protected $member;
    
    protected $zacaciaStatus;
    protected $zacaciaUnDeletable;
    protected $zarafaAliases;
    protected $zarafaAccount;
    protected $zarafaHidden;
    protected $zarafaSecurityGroup;
    protected $zarafaSendAsPrivilege;

    protected $entryUUID;
    protected $objectclass = ['top', 'groupOfNames', 'zarafa-group', 'zacaciaGroup'];
    protected $gidNumber = 10001;

    protected $platformid;
    protected $organizationid;
    protected $groupid;

    function getObjectclass()
    {
        return $this->objectclass;
    }

    function setCn($cn)
    {
        $this->cn = parent::arrayToString($cn);
        return $this;
    }

    function getCn()
    {
        return $this->cn;
    }

    function setEmail($email)
    {
        $this->email = parent::arrayToString($email);
        return $this;
    }

    function getEmail()
    {
        return $this->email;
    }

    function getZarafaAccount()
    {
        return $this->zarafaAccount;
    }

    function setZarafaAccount($zarafaAccount)
    {
        $this->zarafaAccount = parent::arrayToString($zarafaAccount);
        return $this;        
    }

    function getZarafaHidden()
    {
        return $this->zarafaHidden;
    }

    function setZarafaHidden($zarafaHidden)
    {
        $this->zarafaHidden = parent::arrayToString($zarafaHidden);
        return $this;        
    }

    function setGidNumber($gidNumber)
    {
        $this->gidNumber = parent::arrayToString($gidNumber);
        return $this;
    }

    function getGidNumber()
    {
        return $this->gidNumber;
    }

    function setZacaciaStatus($status)
    {
        $this->zacaciaStatus = parent::arrayToString($status);
        return $this;
    }

    function getZacaciaStatus()
    {
        return $this->zacaciaStatus;
    }

    function getEntryUUID()
    {
        return $this->entryUUID;
    }

    function setEntryUUID($uuid)
    {
        $this->entryUUID = parent::arrayToString($uuid);
        return $this;        
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
}
