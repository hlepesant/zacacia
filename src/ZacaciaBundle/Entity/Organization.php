<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Organization extends ZacaciaObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $cn;
    protected $zacaciaStatus;
    protected $entryUUID;
    protected $objectclass = [ 'top', 'organizationalRole', 'zacaciaCompany', 'zarafa-company'];
    protected $zarafaAccount;

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
}
