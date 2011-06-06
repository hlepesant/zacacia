<?php

class UserPeer extends BaseUserPeer
{
    public function getNewUidNumber()
    {
        $uidNumber = sfConfig::get('uid_min');

        $l = clone $this;
        $l->setBaseDn(sfConfig::get('ldap_base_dn'));

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $c->add('cn', '*');
        $c->setAttributes(array('uidNumber'));
       
        if ( $users = $l->doSelect($c) ) {
            print_r($users); exit;
        }

        return $uidNumber;
    }

}
