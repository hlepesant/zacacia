<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Server extends LdapObject
{
    /**
    * @Assert\NotBlank()
    */
    protected $cn;
    
    protected $zacaciaStatus;
    protected $entryUUID;
    protected $objectclass = [ 'top', 'organizationalRole', 'zacaciaServer', 'zarafa-server', 'ipHost'];

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
}
