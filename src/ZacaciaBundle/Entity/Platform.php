<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Platform extends LdapObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $cn;
    
    protected $zacaciaStatus;
    protected $objectclass = [ 'top', 'organizationalRole', 'zacaciaPlatform'];

    protected $companycount = 0;
    protected $servercount = 0;

    public function __construct()
    {
        parent::__construct();
        return $this;
    }

    function getObjectclass()
    {
        return $this->objectclass;
    }

    function setCn($cn)
    {
        $this->cn = parent::arrayToString($cn);
        $this->attributes['cn'] = $this->getCn();
        return $this;
    }

    function getCn()
    {
        return $this->cn;
    }

    function setZacaciastatus($status)
    {
        $this->zacaciaStatus = parent::arrayToString($status);
        $this->attributes['zacaciaStatus'] = $this->getZacaciastatus();
        return $this;
    }

    function getZacaciastatus()
    {
        return $this->zacaciaStatus;
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
}