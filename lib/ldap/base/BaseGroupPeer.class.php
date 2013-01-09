<?php

class BaseGroupPeer extends LDAPPeer
{
    protected $base_dn;
    public static $exclude_attrs = array();

    public function setBaseDn($v)
    {
    	$this->base_dn = $v;
    	return $this;
    }

    public function getBaseDn()
    {
    	return $this->base_dn;
    }

    public function configureCriteria(LDAPCriteria $ldap_criteria)
    {
        if ( $ldap_criteria->getBaseDn() == null ) $ldap_criteria->setBaseDn($this->getBaseDn());
        
        return $ldap_criteria;
    }

    public function retrieveBy($attribute, $value)
    {
        $ldap_criteria = new LDAPCriteria();
        $ldap_criteria->add($attribute, $value);
        $ldap_criteria = self::configureCriteria($ldap_criteria);
        return self::doSelectOne($ldap_criteria);
    }

    public function retrieveByDn(LDAPCriteria $ldap_criteria)
    {
        $ldap_criteria->setSearchScope(LDAPCriteria::BASE);
        $ldap_criteria->add('objectClass', 'top');
        $ldap_criteria->add('objectClass', 'groupOfNames');
        $ldap_criteria->add('objectClass', 'zarafa-group');
        $ldap_criteria->add('objectClass', 'zacaciaGroup');

        $ldap_criteria = self::configureCriteria($ldap_criteria);
        
        return $this->doSelectOne($ldap_criteria);
    }
}
