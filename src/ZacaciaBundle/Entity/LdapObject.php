<?php

namespace ZacaciaBundle\Entity;



class LdapObject
{
    protected $dn;
    protected $attributes;

    public function __construct()
    {
        $this->attributes = array();
        return $this;
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
        $filled_attributes = array();

        foreach ( $this->attributes as $key => $value ) {
            if (is_array($value) or $value != '') {
                $filled_attributes[$key] = $value;
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
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        } else {
            return null;
        }
    }
/*
    public function deHydrate()
    {
        $methods = get_class_methods($this);
        print_r($methods);
        exit;
    }
*/
    public function Hydrate($key_value)
    {
        foreach( $key_value as $key => $value) {

            $this_method = sprintf('set%s', ucfirst(strtolower($key)));

            if (method_exists($this, $this_method)) {
                $this->$this_method($value);
            } else {
                printf('function not found : %s', $this_method);
                exit;
            }

        }
        return $this;
    }

    protected function arrayToString($val)
    {
        if ( ! is_array($val)) return $val;
        if (count($val) == 0 ) return $val[0];
        return implode($val);
    }
/*
    public function has($attribute, $value)
    {
        $has = false;
        if (isset($this->attributes[$attribute])) {
            if (count($this->attributes[$attribute]) == 1) {
                $has = $this->attributes[$attribute] == $value;
            } else {
                $has = in_array($value, $this->attributes[$attribute]);
            }
        }
        return $has;
    }

    public function __constructFrom($ldap_fields)
    {
        foreach ($ldap_fields as $attribute => $value) {
            if (is_array($value) && count($value) == 1) {
                $this->attributes[$attribute] = $value[0];
            } else {
                $this->attributes[$attribute] = $value;
            }
        }
        return $this;
    }
  
    public function copyFrom($ldap_object, $exclude_attrs)
    {
        $this->attributes = $ldap_object->attributes;
        
        if (!empty($exclude_attrs)) {
            foreach ($exclude_attrs as $exclude_attr) {
                unset($this->attributes[$exclude_attr]);
            }
        }
        
        return $this;
    }

    private function isValidEmail($mail)
    {
        return true;
        return !empty($mail) && preg_match('/^[a-f0-9\.\-]\@{32}$/', $mail);
    }
    */
}
