<?php

class CompanyObject extends BaseCompanyObject
{
    public function setNumberOfDomains($v)
    {
        $this->attributes['numberOfDomains'] = (int)$v;
   	    return $this;
    }

    public function getNumberOfDomains()
    {
        return $this->attributes['numberOfDomains'];
    }
    
    public function setNumberOfUsers($v)
    {
    
        $this->attributes['numberOfUsers'] = $v;
   	    return $this;
    }

    public function getNumberOfUsers()
    {
        return $this->attributes['numberOfUsers'];
    }
    
    public function setNumberOfGroups($v)
    {
        $this->attributes['numberOfGroups'] = $v;
   	    return $this;
    }

    public function getNumberOfGroups()
    {
        return $this->attributes['numberOfGroups'];
    }
    
    public function setNumberOfForwards($v)
    {
        $this->attributes['numberOfForwards'] = $v;
   	    return $this;
    }

    public function getNumberOfForwards()
    {
        return $this->attributes['numberOfForwards'];
    }
    
    public function setNumberOfContacts($v)
    {
        $this->attributes['numberOfContacts'] = $v;
   	    return $this;
    }

    public function getNumberOfContacts()
    {
        return $this->attributes['numberOfContacts'];
    }
    
    public function setNumberOfAddressLists($v)
    {
        $this->attributes['numberOfAddressLists'] = $v;
   	    return $this;
    }

    public function getNumberOfAddressLists()
    {
        return $this->attributes['numberOfAddressLists'];
    }
}
