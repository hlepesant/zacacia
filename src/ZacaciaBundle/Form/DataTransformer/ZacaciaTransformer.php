<?php

namespace ZacaciaBundle\Form\DataTransformer;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\Server;
use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\Domain;

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
        return $server;
    } 

    public function transOrganization($ldapObject)
    {
        $organization = new Organization();
        $organization->setCn($ldapObject->getCn());
        $organization->setZacaciastatus($ldapObject->getZacaciastatus());
        $organization->setZarafaHidden($ldapObject->getZarafaHidden());
        $organization->setZarafaAccount($ldapObject->getZarafaAccount());
        return $organization;
    } 

    public function transDomain($ldapObject)
    {
        $domain = new Domain();
        $domain->setCn($ldapObject->getCn());
        $domain->setZacaciastatus($ldapObject->getZacaciastatus());
        return $domain;
    } 
} 
