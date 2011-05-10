<?php

/*
 * http://doc.zarafa.com/6.40/Administrator_Manual/en-US/html/_multi_tenancy_configurations.html
 * 6.2.5. Quota levels
 */

class BaseCompanyObject extends LDAPObject
{
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    public function applyDefaultValues()
    {
#       if (!is_array($this->attributes)) $this->attributes = array();
        $this->attributes['objectClass'] = Array('top', 'organizationalRole', 'zarafa-company', 'zacaciaCompany');
        $this->attributes['cn'] = null;
        $this->attributes['zacaciaStatus'] = 'enable';
        $this->attributes['zacaciaUnDeletable'] = 0;
        /* Zarafa Specific Attributs */
        $this->attributes['zarafaAccount'] = 1;                         // Entry is a part of zarafa
        $this->attributes['zarafaAdminPrivilege'] = '';                 // Users from different companies which are administrator over selected company
        $this->attributes['zarafaCompanyServer'] = '';                  // Home server for the user
        $this->attributes['zarafaHidden'] = 1;                          // This object should be hidden from address book
        $this->attributes['zarafaQuotaCompanyWarningRecipients'] = '';  // Users who will recieve a notification email when a company exceeds its quota
        $this->attributes['zarafaQuotaOverride'] = 0;                   // Override child quota
        $this->attributes['zarafaQuotaUserWarningRecipients'] = '';     // Users who will recieve a notification email when a user exceeds his quota
        $this->attributes['zarafaQuotaWarn'] = '';                      // Warning quota size in MB
        $this->attributes['zarafaSystemAdmin'] = '';                    // The user who is the system administrator for this company
        $this->attributes['zarafaUserDefaultQuotaHard'] = '';           // User default hard quota size in MB
        $this->attributes['zarafaUserDefaultQuotaOverride'] = 0;        // Override User default quota for children
        $this->attributes['zarafaUserDefaultQuotaSoft'] = '';           // User default soft quota size in MB
        $this->attributes['zarafaUserDefaultQuotaWarn'] = '';           // User default warning quota size in MB
        $this->attributes['zarafaViewPrivilege'] = '';                  // Companies with view privileges over selected company

        return $this;
    }

    public function setCn($v)
    {
        $this->attributes['cn'] = $v;
   	    return $this;
    }

    public function getCn()
    {
        return $this->attributes['cn'];
    }

    public function setZacaciaStatus($v)
    {
#        $this->attributes['zacaciaStatus'] = $v;
        if ( $v ) {
            $this->attributes['zacaciaStatus'] = 'enable';
        } else {
            $this->attributes['zacaciaStatus'] = 'disable';
        }
        return $this;
    }

    public function getZacaciaStatus()
    {
        return $this->attributes['zacaciaStatus'];
    }

    public function setZacaciaUnDeletable($v)
    {
        if ( $v ) {
            $this->attributes['zacaciaUnDeletable'] = 1;
        } else {
            $this->attributes['zacaciaUnDeletable'] = array();
        }
    	return $this;
    }
 
    public function getZacaciaUnDeletable()
    {
        return (int)$this->attributes['zacaciaUnDeletable'];
    }

    public function setZarafaAccount($v)
    {
        if ( $v ) {
            $this->attributes['zarafaAccount'] = 1;
        } else {
            $this->attributes['zarafaAccount'] = array();
        }
        return $this;
    }

    public function getZarafaAccount()
    {
        return $this->attributes['zarafaAccount'];
    }

    public function setZarafaHidden($v)
    {
        if ( $v ) {
            $this->attributes['zarafaHidden'] = 1;
        } else {
            $this->attributes['zarafaHidden'] = array();
        }
        return $this;
    }

    public function getZarafaHidden()
    {
        return $this->attributes['zarafaHidden'];
    }

    public function setZarafaAdminPrivilege($v)
    {
        if ( $v ) {
            $this->attributes['zarafaAdminPrivilege'] = 1;
        } else {
            $this->attributes['zarafaAdminPrivilege'] = array();
        }
        return $this;
    }

    public function getZarafaAdminPrivilege()
    {
        return $this->attributes['zarafaAdminPrivilege'];
    }

    public function setZarafaCompanyServer($v)
    {
        $this->attributes['zarafaCompanyServer'] = $v;
   	    return $this;
    }

    public function getZarafaCompanyServer()
    {
        return $this->attributes['zarafaCompanyServer'];
    }

    public function setZarafaQuotaCompanyWarningRecipients($v)
    {
        $this->attributes['zarafaQuotaCompanyWarningRecipients'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaCompanyWarningRecipients()
    {
        return $this->attributes['zarafaQuotaCompanyWarningRecipients'];
    }

    public function setZarafaQuotaOverride($v)
    {
        if ( $v ) {
            $this->attributes['zarafaQuotaOverride'] = 1;
        } else {
            $this->attributes['zarafaQuotaOverride'] = array();
        }
   	    return $this;
    }

    public function getZarafaQuotaOverride()
    {
        return $this->attributes['zarafaQuotaOverride'];
    }

    public function setZarafaQuotaUserWarningRecipients($v)
    {
        $this->attributes['zarafaQuotaUserWarningRecipients'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaUserWarningRecipients()
    {
        return $this->attributes['zarafaQuotaUserWarningRecipients'];
    }

    public function setZarafaQuotaWarn($v)
    {
        $this->attributes['zarafaQuotaWarn'] = $v;
   	    return $this;
    }

    public function getZarafaQuotaWarn()
    {
        return $this->attributes['zarafaQuotaWarn'];
    }

    public function setZarafaSystemAdmin($v)
    {
        $this->attributes['zarafaSystemAdmin'] = $v;
   	    return $this;
    }

    public function getZarafaSystemAdmin()
    {
        return $this->attributes['zarafaSystemAdmin'];
    }

    public function setZarafaUserDefaultQuotaHard($v)
    {
        $this->attributes['zarafaUserDefaultQuotaHard'] = $v;
   	    return $this;
    }

    public function getZarafaUserDefaultQuotaHard()
    {
        return $this->attributes['zarafaUserDefaultQuotaHard'];
    }

    public function setZarafaUserDefaultQuotaOverride($v)
    {
        if ( $v ) {
            $this->attributes['zarafaUserDefaultQuotaOverride'] = 1;
        } else {
            $this->attributes['zarafaUserDefaultQuotaOverride'] = array();
        }
   	    return $this;
    }

    public function getZarafaUserDefaultQuotaOverride()
    {
        return $this->attributes['zarafaUserDefaultQuotaOverride'];
    }

    public function setZarafaUserDefaultQuotaSoft($v)
    {
        $this->attributes['zarafaUserDefaultQuotaSoft'] = $v;
   	    return $this;
    }

    public function getZarafaUserDefaultQuotaSoft()
    {
        return $this->attributes['zarafaUserDefaultQuotaSoft'];
    }

    public function setZarafaUserDefaultQuotaWarn($v)
    {
        $this->attributes['zarafaUserDefaultQuotaWarn'] = $v;
   	    return $this;
    }

    public function getZarafaUserDefaultQuotaWarn()
    {
        return $this->attributes['zarafaUserDefaultQuotaWarn'];
    }

    public function setZarafaViewPrivilege($v)
    {
        $this->attributes['zarafaViewPrivilege'] = $v;
   	    return $this;
    }

    public function getZarafaViewPrivilege()
    {
        return $this->attributes['zarafaViewPrivilege'];
    }
}
