<?php

class LDAPObject
{
  protected $dn;
  protected $attributes;

  public function __construct()
  {
    $this->attributes = array();
  }

  public function setDn($v)
  {
    $this->dn = $v;
    return $this;
  }

  public function getDn()
  {
    return $this->dn;
  }

  public function getAttributes()
  {
    #return $this->attributes;
    
    $filled_attributes = array();

    foreach ( $this->attributes as $key => $value )
    {
        if ( is_array($value) or $value != '' )
        {
            $filled_attributes[ $key ] = $value;
        }
    }

    return $filled_attributes;
  }

  public function set($attribute, $value)
  {
    $this->attributes[$attribute] = $value;
    return $this;
  }

  public function get($attribute)
  {
    if (isset($this->attributes[$attribute]))
    {
      return $this->attributes[$attribute];
    }
    else
    {
      return null;
    }
  }

  public function has($attribute, $value)
  {
    $has = false;
    if (isset($this->attributes[$attribute]))
    {
      if (count($this->attributes[$attribute]) == 1)
      {
        $has = $this->attributes[$attribute] == $value;
      }
      else
      {
        $has = in_array($value, $this->attributes[$attribute]);
      }
    }
    return $has;
  }

  public function __constructFrom($ldap_fields)
  {
    foreach ($ldap_fields as $attribute => $value)
    {
      if (is_array($value) && count($value) == 1)
      {
        $this->attributes[$attribute] = $value[0];
      }
      else
      {
        $this->attributes[$attribute] = $value;
      }
    }
    return $this;
  }
  
  public function copyFrom($ldap_object, $exclude_attrs)
  {
    $this->attributes = $ldap_object->attributes;

    if (!empty($exclude_attrs))
    {
      foreach ($exclude_attrs as $exclude_attr)
      {
        unset($this->attributes[$exclude_attr]);
      }
    }

    return $this;
  }
}
