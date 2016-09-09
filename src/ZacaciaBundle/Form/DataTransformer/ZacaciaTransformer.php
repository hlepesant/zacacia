<?php

namespace ZacaciaBundle\Form\DataTransformer;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\Server;

class ZacaciaTransformer extends Platform {

    public function transPlatform($ldapObject)
    {
        $platform = new Platform();
        $platform->setCn($ldapObject->getCn());
        $platform->setZacaciastatus($ldapObject->getZacaciastatus());
        return $platform;
    } 

    public function transServer($ldapObject)
    {
        $server = new Server();
        $server->setCn($ldapObject->getCn());
        $server->setZacaciastatus($ldapObject->getZacaciastatus());
        $server->setIpHostNumber($ldapObject->getIpHostNumber());
        $server->setZarafaAccount($ldapObject->getZarafaAccount());
        $server->setZarafaFilePath($ldapObject->getZarafaFilePath());
        $server->setZarafaHttpPort($ldapObject->getZarafaHttpPort());
        $server->setZarafaSslPort($ldapObject->getZarafaSslPort());
        # $server->set($ldapObject->get());
        return $server;
    } 
} 
