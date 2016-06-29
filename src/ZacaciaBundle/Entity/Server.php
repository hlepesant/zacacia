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
    protected $ipHostNumber;
    protected $zarafaAccount;
    protected $zarafaFilePath;
    protected $zarafaHttpPort;
    protected $zarafaSslPort;

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

    function getIpHostNumber()
    {
        return $this->ipHostNumber;
    }

    function setIpHostNumber($ipHostNumber)
    {
        $this->ipHostNumber = parent::arrayToString($ipHostNumber);
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

    function getZarafaFilePath()
    {
        return $this->zarafaFilePath;
    }

    function setZarafaFilePath($zarafaFilePath)
    {
        $this->zarafaFilePath = parent::arrayToString($zarafaFilePath);
        return $this;        
    }

    function getZarafaHttpPort()
    {
        return $this->zarafaHttpPort;
    }

    function setZarafaHttpPort($zarafaHttpPort)
    {
        $this->zarafaHttpPort = parent::arrayToString($zarafaHttpPort);
        return $this;        
    }

    function getZarafaSslPort()
    {
        return $this->zarafaSslPort;
    }

    function setZarafaSslPort($zarafaSslPort)
    {
        $this->zarafaSslPort = parent::arrayToString($zarafaSslPort);
        return $this;        
    }
}
