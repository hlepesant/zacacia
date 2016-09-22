<?php

namespace ZacaciaBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class User extends ZacaciaObject
{
    protected $cn;
    /**
    * @Assert\NotBlank()
    */
    protected $sn;
    /**
    * @Assert\NotBlank()
    */
    protected $givenname;
    /**
    * @Assert\NotBlank()
    */
    protected $displayname;
    /**
    * @Assert\NotBlank()
    */
    protected $uid;
    /**
    * @Assert\NotBlank()
    */
    protected $email;
    protected $mail;
    protected $domain;
    protected $userpassword;
    protected $zarafaquotaoverride;
    protected $zarafaquotasoft;
    protected $zarafaquotawarn;
    protected $zarafaquotahard;
    
    protected $zacaciaStatus;
    protected $zarafaAccount;
    protected $zarafaHidden;
    protected $entryUUID;
    protected $gidNumber = 10001;
    protected $uidNumber = 10001;
    protected $objectclass = ['top', 'posixAccount', 'inetOrgPerson', 'zarafa-user', 'zacaciaUser'];
    protected $homeDirectory = '/dev/null';
    protected $loginShell = '/bin/false';
    protected $platformid;
    protected $organizationid;
    protected $userid;

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

    function setSn($sn)
    {
        $this->sn = parent::arrayToString($sn);
        return $this;
    }

    function getSn()
    {
        return $this->sn;
    }

    function setGivenname($givenname)
    {
        $this->givenname = parent::arrayToString($givenname);
        return $this;
    }

    function getGivenname()
    {
        return $this->givenname;
    }

    function setDisplayname($displayname)
    {
        $this->displayname = parent::arrayToString($displayname);
        return $this;
    }

    function getDisplayname()
    {
        return $this->displayname;
    }

    function setUid($uid)
    {
        $this->uid = parent::arrayToString($uid);
        return $this;
    }

    function getUid()
    {
        return $this->uid;
    }

    function setUserPassword($password)
    {
        $this->password = self::hash_password(parent::arrayToString($password));
        return $this;
    }

    function getUserPassword()
    {
        return $this->password;
    }

    function setMail($email)
    {
        $this->mail = parent::arrayToString($email);
        return $this;
    }

    function getMail()
    {
        return $this->mail;
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

    function setDomain($domain)
    {
        $this->domain = parent::arrayToString($domain);
        return $this;
    }

    function getDomain()
    {
        return $this->domain;
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

    function getZarafaQuotaOverride()
    {
        return $this->zarafaquotaoverride;
    }

    function setZarafaQuotaOverride($zarafaquotaoverride)
    {
        $this->zarafaquotaoverride = parent::arrayToString($zarafaquotaoverride);
        return $this;        
    }

    function getZarafaQuotaSoft()
    {
        return $this->zarafaquotasoft;
    }

    function setZarafaQuotaSoft($zarafaquotasoft)
    {
        $this->zarafaquotasoft = parent::arrayToString($zarafaquotasoft);
        return $this;        
    }

    function getZarafaQuotaWarn()
    {
        return $this->zarafaquotawarn;
    }

    function setZarafaQuotaWarn($zarafaquotawarn)
    {
        $this->zarafaquotawarn = parent::arrayToString($zarafaquotawarn);
        return $this;        
    }

    function getZarafaQuotaHard()
    {
        return $this->zarafaquotahard;
    }

    function setZarafaQuotaHard($zarafaquotahard)
    {
        $this->zarafaquotahard = parent::arrayToString($zarafaquotahard);
        return $this;        
    }

    function setUidNumber($uidNumber)
    {
        $this->uid = parent::arrayToString($uidNumber);
        return $this;
    }

    function getUidNumber()
    {
        return $this->uidNumber;
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

    function setHomeDirectory($homeDirectory)
    {
        $this->homeDirectory = parent::arrayToString($homeDirectory);
        return $this;
    }

    function getHomeDirectory()
    {
        return $this->homeDirectory;
    }

    function setLoginShell($loginShell)
    {
        $this->loginShell = parent::arrayToString($loginShell);
        return $this;
    }

    function getLoginShell()
    {
        return $this->loginShell;
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

    function getUserId()
    {
        return $this->userid;
    }

    function setUserId($uuid)
    {
        $this->userid = parent::arrayToString($uuid);
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

    private function hash_password($password) // SSHA with random 4-character salt
    {
        $salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',4)),0,4);
        return '{SSHA}' . base64_encode(sha1( $password.$salt, TRUE ). $salt);
    }
}
