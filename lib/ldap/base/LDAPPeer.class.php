<?php

class LDAPPeer
{
    private $conn;
    private $host;
    private $bind_user;
    private $bind_pwd;
    private $use_ssl;
    private $bind_dn;

    public static $exclude_attrs = array();

    public function __construct()
    {
        $this->buildDefaultLdapParameters();
        $this->doConnection();
    }

    public function doConnection($bind_user = null, $bind_password = null)
    {
        if ( null === $bind_user ) {
            $bind_user = $this->getBindUser();
        }

        if ( null === $bind_password ) {
            $bind_password = $this->getBindPwd();
        }
        $conn = ldap_connect($this->getFullHost());

        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);

        if (!ldap_bind($conn, $bind_user, $bind_password)) {
            throw new Exception(ldap_error($conn));
        }

        $this->setLinkId($conn);
        return true;
    }

    public function buildDefaultLdapParameters()
    {
        $this->setHost(sfConfig::get('ldap_host'));
        $this->setUseSsl(sfConfig::get('ldap_use_ssl'));
        $this->setBindUser(sfConfig::get('ldap_root_dn'));
        $this->setBindPwd(sfConfig::get('ldap_root_pw'));
        $this->setBindDn(sfConfig::get('ldap_bind_dn'));
    }

    protected function configureCriteria(LDAPCriteria $ldap_criteria)
    {
        if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn($this->getBaseDn());
        
        return $ldap_criteria;
    }

    public function setHost($v)
    {
        $this->host = $v;
        return $this;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setBindUser($v)
    {
        $this->bind_user = $v;
        return $this;
    }

    public function getBindUser()
    {
        return $this->bind_user;
    }

    public function setBindPwd($v)
    {
        $this->bind_pwd = $v;
        return $this;
    }

    public function getBindPwd()
    {
        return $this->bind_pwd;
    }

    public function setUseSsl($v)
    {
        $this->use_ssl = $v;
        return $this;
    }

    public function getUseSsl()
    {
        return $this->use_ssl;
    }

    public function setBindDn($v)
    {
        $this->bind_dn = $v;
        return $this;
    }

    public function getBindDn()
    {
        return $this->bind_dn;
    }

    private function getFullHost()
    {
        return (sprintf("ldap%s://%s", $this->getUseSsl()? "s":"", $this->getHost()));
    }

    public function setLinkId($v)
    {
        $this->conn = $v;
        return $this;
    }

    public function getLinkId()
    {
        return $this->conn;
    }

    protected function extractAttributes($ldap_entry)
    {
        $attributes = array();

        if ($ldap_entry !== false) {
            $attrs = ldap_get_attributes($this->getLinkId(), $ldap_entry);

            foreach (array_keys($attrs) as $attribute) {
                if (!is_int($attribute) && $attribute != "count") {
                    $attributes[] = $attribute;
                }
            }
        }
        return $attributes;
    }

    protected function extractValues($ldap_entry, $attributes)
    {
        $values = array();
        foreach ($attributes as $attribute) {
            $vals = ldap_get_values($this->getLinkId(), $ldap_entry, $attribute);
            unset($vals["count"]);
            $values[$attribute] = $vals;
        }
        return $values;
    }
/*
    private function createLDAPObject($ldap_entry)
    {
        $attributes = $this->extractAttributes($ldap_entry);
        $values = $this->extractValues($ldap_entry, $attributes);
        $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);

        $ldap_object = new LDAPObject();
        $ldap_object->setDn($dn);
        $ldap_object->__constructFrom($values);
        return( $ldap_object );
    }
*/
    protected function createLDAPObject($ldap_entry, $objectClassName)
    {
        $attributes = $this->extractAttributes($ldap_entry);
        $values = $this->extractValues($ldap_entry, $attributes);
        $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);
        
        $ldap_object = new $objectClassName();
        $ldap_object->setDn($dn);
        $ldap_object->__constructFrom($values);
        return( $ldap_object );
    }

    protected function select(LDAPCriteria $ldap_criteria)
    {
        if ($function = $ldap_criteria->getFunction()) {
            if ( $log = sfContext::getInstance()->getLogger() ) {
                $log->info("{BaseLDAPPeer::select} getLinkId = ".$this->getLinkId() );
                $log->info("{BaseLDAPPeer::select} getBaseDn = ".$ldap_criteria->getBaseDn() );
                $log->info("{BaseLDAPPeer::select} getFilter = ".$ldap_criteria->getFilter() );
                $log->info("{BaseLDAPPeer::select} getAttributes = ".implode(",", $ldap_criteria->getAttributes()) );
                $log->info("{BaseLDAPPeer::select} getAttrsonly = ".$ldap_criteria->getAttrsonly() );
                $log->info("{BaseLDAPPeer::select} getSizelimit = ".$ldap_criteria->getSizelimit() );
                $log->info("{BaseLDAPPeer::select} getTimelimit = ".$ldap_criteria->getTimelimit() );
                $log->info("{BaseLDAPPeer::select} getDeref = ".$ldap_criteria->getDeref() );
            }

            $results = $function($this->getLinkId(),
                                 $ldap_criteria->getBaseDn(),
                                 $ldap_criteria->getFilter(),
                                 $ldap_criteria->getAttributes(),
                                 $ldap_criteria->getAttrsonly(),
                                 $ldap_criteria->getSizelimit(),
                                 $ldap_criteria->getTimelimit(),
                                 $ldap_criteria->getDeref());

            if (!$results) {
                throw new Exception(ldap_error($this->getLinkId()));
            }

            if (!is_null($ldap_criteria->getSortfilter())) {
                ldap_sort($this->getLinkId(), $results, $ldap_criteria->getSortfilter());
            }
            return $results;
        } else {
          throw new Exception("Fatal error: method not implemented.");
        }
    }

    public function doSelect(LDAPCriteria $ldap_criteria, $objectClassName)
    {
        $_objects = array();

        $ldap_criteria = self::configureCriteria($ldap_criteria);
        $results = $this->select($ldap_criteria);

        $ldap_entry = ldap_first_entry($this->getLinkId(), $results);

        if ($ldap_entry !== false) {
            $_objects[] = $this->createLDAPObject($ldap_entry, $objectClassName);

            while ($ldap_entry = ldap_next_entry($this->getLinkId(), $ldap_entry))
            {
                $_objects[] = $this->createLDAPObject($ldap_entry, $objectClassName);
            }
        }
        return( $_objects );
    }

    public function doSelectOne(LDAPCriteria $ldap_criteria, $objectClassName = 'BaseCompanyObject')
    {
        $ldap_criteria = self::configureCriteria($ldap_criteria);
        $results = $this->select($ldap_criteria);

        $ldap_entry = ldap_first_entry($this->getLinkid(), $results);

        $object = false;

        if ($ldap_entry !== false) {
            $object = $this->createLDAPObject($ldap_entry, $objectClassName);
        }

        return $object;

    }

    public function doCount(LDAPCriteria $ldap_criteria)
    {
        $ldap_criteria = self::configureCriteria($ldap_criteria);
        $results = $this->select($ldap_criteria);
        return ldap_count_entries($this->getLinkId(), $results);
    }

    public function doAdd(LDAPObject $ldap_object)
    {
        if (ldap_add($this->getLinkId(), $ldap_object->getDn(), $ldap_object->getAttributes())) {
            return true;
        }

        throw new Exception("Fatal: ".ldap_error($this->getLinkId()));
    }

    public function doSave(LDAPObject $ldap_object)
    {
        if ( @ldap_modify($this->getLinkId(), $ldap_object->getDn(), $ldap_object->getAttributes())) {
            return true;
        }

        throw new Exception("Fatal: ".ldap_error($this->getLinkId()));
    }

    public function doRename(LDAPObject $ldap_object, $newDn)
    {
        if ( @ldap_rename($this->getLinkId(), $ldap_object->getDn(), $newDn, $this->getBaseDn(), true)) {
            return true;
        }

        throw new Exception("Fatal: ".ldap_error($this->getLinkId()));
    }

    public function doDelete(LDAPObject $ldap_object, $recursive=false)
    {
        if ( $log = sfContext::getInstance()->getLogger() ) {
            $log->info("{BaseLDAPPeer::doDelete} deleting = ".$ldap_object->getDn() );
        }

        if ($recursive == false) {
            return (ldap_delete($this->getLinkId(), $ldap_object->getDn()));
        } else {
            //searching for sub entries
            $sr=ldap_list($this->getLinkId(),$ldap_object->getDn(),"ObjectClass=*",array(""));
            $info = ldap_get_entries($this->getLinkId(), $sr);

            for($i=0;$i<$info['count'];$i++) {
                //deleting recursively sub entries
                $sub_object = new LDAPObject();
                $sub_object->setDn($info[$i]['dn']);

                $result = $this->doDelete($sub_object,$recursive);
                if(!$result){
                    print( ldap_error( $this->getLinkdId() ) );
                }
            }
            return (ldap_delete($this->getLinkId(), $ldap_object->getDn()));
        }
    }
}
