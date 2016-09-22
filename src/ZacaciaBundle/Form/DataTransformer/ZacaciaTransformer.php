<?php

namespace ZacaciaBundle\Form\DataTransformer;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\Server;
use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\Domain;
use ZacaciaBundle\Entity\User;

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

    public function transUser($ldapObject, $platform, $organization)
    {
        $user = new User();
        $user->setUserId($ldapObject->getEntryUUID());
        $user->setPlatformId($platform->getEntryUUID());
        $user->setOrganizationId($organization->getEntryUUID());

        $user->setCn($ldapObject->getCn());
        $user->setZacaciaStatus($ldapObject->getZacaciaStatus());
        $user->setCn($ldapObject->getCn());
        $user->setDn($ldapObject->getDn());
        $user->setDisplayName($ldapObject->getDisplayName());
        $user->setMail($ldapObject->getMail());
        $user->setSn($ldapObject->getSn());
        $user->setGivenName($ldapObject->getGivenName());
        $user->setUid($ldapObject->getUid());
        $user->setEmail($this::getEmailUserPart($ldapObject->getMail()));
        $user->setDomain($this::getEmailDomainPart($ldapObject->getMail()));
        $user->setZarafaAccount($ldapObject->getZarafaAccount());
        $user->setZarafaHidden($ldapObject->getZarafaHidden());
        $user->setZarafaQuotaOverride($ldapObject->getZarafaQuotaOverride());
        if ( $user->getZarafaQuotaOverride() ) {
            $user->setZarafaQuotaSoft($ldapObject->getZarafaQuotaSoft());
            $user->setZarafaQuotaWarn($ldapObject->getZarafaQuotaWarn());
            $user->setZarafaQuotaHard($ldapObject->getZarafaQuotaHard());
        } else {
            $user->setZarafaQuotaSoft(0);
            $user->setZarafaQuotaWarn(0);
            $user->setZarafaQuotaHard(0);
        }
        #$user->set($ldapObject->get());
        return $user;
    } 

    private function getEmailUserPart($email)
    {
        list($email, $domain) = preg_split('/\@/', $email, 2, PREG_SPLIT_NO_EMPTY);
        return $email;
    }

    private function getEmailDomainPart($email)
    {
        list($email, $domain) = preg_split('/\@/', $email, 2, PREG_SPLIT_NO_EMPTY);
        return $domain;
    }
} 
