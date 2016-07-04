<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Platform extends ZacaciaObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $cn;
    
    protected $zacaciaStatus;
    protected $entryUUID;
    protected $objectclass = [ 'top', 'organizationalRole', 'zacaciaPlatform'];

    protected $companycount = 0;
    protected $servercount = 0;
/*
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

    function setZacaciastatus($status)
    {
        $this->zacaciaStatus = parent::arrayToString($status);
        return $this;
    }

    function getZacaciastatus()
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

    function setCompanyCount($nb)
    {
        $this->companyCount = $nb;
        return $this;
    }

    function getCompanyCount()
    {
        return $this->companyCount;
    }

    function setServerCount($nb)
    {
        $this->serverCount = $nb;
        return $this;
    }

    function getServerCount()
    {
        return $this->serverCount;
    }
*/
}
