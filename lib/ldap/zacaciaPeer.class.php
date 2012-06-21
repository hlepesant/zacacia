<?php

class zacaciaPeer extends LDAPPeer
{
/*
    protected
        $ldap = null;

    public function __construct()
    {
        $this->ldap = parent::__construct();
        return $this;
    }
*/

    public function createLDAPObject($ldap_entry, $objectType='PlatformObject')
    {
        $attributes = $this->extractAttributes($ldap_entry);
        $values = $this->extractValues($ldap_entry, $attributes);
        $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);
        
        $ldap_object = new $objectType();
        $ldap_object->setDn($dn);
        $ldap_object->__constructFrom($values);
        return( $ldap_object );
    }

    
}
