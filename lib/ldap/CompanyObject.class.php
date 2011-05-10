<?php

class CompanyObject extends BaseCompanyObject
{
    public function setNumberOfDomains($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=Domains,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zacaciaDomain');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfDomains'] = $count;
   	    return $this;
    }

    public function getNumberOfDomains()
    {
        return $this->attributes['numberOfDomains'];
    }
    
    public function setNumberOfUsers($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=Users,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfUsers'] = $count;
   	    return $this;
    }

    public function getNumberOfUsers()
    {
        return $this->attributes['numberOfUsers'];
    }
    
    public function setNumberOfGroups($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=Groups,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zarafa-group');
        $c->add('objectClass', 'zacaciaGroup');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfGroups'] = $count;
   	    return $this;
    }

    public function getNumberOfGroups()
    {
        return $this->attributes['numberOfGroups'];
    }
    
    public function setNumberOfForwards($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=Forwards,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zacaciaForward');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfForwards'] = $count;
   	    return $this;
    }

    public function getNumberOfForwards()
    {
        return $this->attributes['numberOfForwards'];
    }
    
    public function setNumberOfContacts($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=Contacts,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zarafa-contact');
        $c->add('objectClass', 'zacaciaContact');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfContacts'] = $count;
   	    return $this;
    }

    public function getNumberOfContacts()
    {
        return $this->attributes['numberOfContacts'];
    }
    
    public function setNumberOfAddressLists($l)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn(sprintf("ou=AddressLists,%s", $this->getDn()));
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'zarafa-addresslist');
        $c->add('objectClass', 'zacaciaForward');
        $c->add('cn', '*');
        $count = $l->doCount($c);
    
        $this->attributes['numberOfAddressLists'] = $count;
   	    return $this;
    }

    public function getNumberOfAddressLists()
    {
        return $this->attributes['numberOfAddressLists'];
    }
}
