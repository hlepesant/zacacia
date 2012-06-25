<?php

class UserPeer extends BaseUserPeer
{

    public function getPlatform($dn)
    {
        $this->setBaseDn($dn);
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaPlatform');

        return $this->doSelectOne($criteria, 'BasePlatformObject');
    }

    public function getCompany($dn)
    {
        $this->setBaseDn($dn);

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zarafa-company');
        $criteria->add('objectClass', 'zacaciaCompany');

        return $this->doSelectOne($criteria, 'BaseCompanyObject');
    }

    public function getUsers($dn)
    {
        $this->setBaseDn(sprintf("ou=Users,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'inetOrgPerson');
        $criteria->add('objectClass', 'posixAccount');
        $criteria->add('objectClass', 'zarafa-user');
        $criteria->add('objectClass', 'zacaciaUser');

        return $this->doSelect($criteria, 'UserObject');
    }

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
       
        if ( $users = $l->doSelect($c, 'BaseUserObject') ) {
            $uids = array();
            foreach( $users as $user ) {
                $uids[] = $user->getUidNumber();
            }
            rsort($uids);
            $uidNumber = $uids[0] + 1;
        }

        return $uidNumber;
    }

}
