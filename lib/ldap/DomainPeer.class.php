<?php

class DomainPeer extends BaseDomainPeer
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

    public function getDomains($dn)
    {
        $this->setBaseDn(sprintf("ou=Domains,%s", $dn));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaDomain');

        $domains = $this->doSelect($criteria, 'DomainObject');

        foreach ($domains as $domain) {
            $domain->set('email_count', $this->countEmailAddressOnDomain($domain->getCn()));
        }

        return $domains;
    }

    public function getDomain($dn)
    {
        $this->setBaseDn($dn);

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaDomain');

        $domain = $this->doSelectOne($criteria, 'BaseDomainObject');

#        foreach ($domains as $domain) {
#            $domain->set('email_count', $this->countEmailAddressOnDomain($domain->getCn()));
#        }

        return $domain;
    }

    public function countEmailAddressOnDomain($domain)
    {
        $this->setBaseDn(sfConfig::get('ldap_base_dn'));

        $criteria = new LDAPCriteria();
        $criteria->addOr('objectClass', 'zarafa-user');
        $criteria->addOr('objectClass', 'zarafa-group');
        $criteria->add('objectClass', 'top');
        $criteria->add('mail', sprintf('@%s', $domain), '=', 2);

        return $this->doCount($criteria);
    }

    public function doSearch($cn)
    {
        $this->setBaseDn(sfConfig::get('ldap_base_dn'));

        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'top');
        $criteria->add('objectClass', 'organizationalRole');
        $criteria->add('objectClass', 'zacaciaDomain');
        $criteria->add('cn', $cn);

        return $this->doCount($criteria);
    }
}
