<?php

class ServerPeer extends BaseServerPeer
{

    private function createLDAPObject($ldap_entry, $ldap_object = 'base')
    {
        if ( 'base' == $ldap_object )
        {
            $ldap_object = parent::createLDAPObject($ldap_entry);
            return $ldap_object;
        }

        print('aki'); exit;

        $attributes = $this->extractAttributes($ldap_entry);
        $values = $this->extractValues($ldap_entry, $attributes);
        $dn = ldap_get_dn($this->getLinkId(), $ldap_entry);
        $ldap_object = new ServerObject();
        $ldap_object->setDn($dn);
        $ldap_object->__constructFrom($values);
        return( $ldap_object );
    }
}
