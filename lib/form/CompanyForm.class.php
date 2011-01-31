<?php
class CompanyForm extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');
        $public_folder_option = array( 0 => 'no', 1 => 'yes');
        
        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'cn' => new sfWidgetFormInput(),
            'status' => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable' => new sfWidgetFormSelect( array('choices' => $undeletable) ),
        
#            'zarafaAccount' => new sfWidgetFormInput(),
#            'zarafaHidden' => new sfWidgetFormInput(),
#            'zarafaAdminPrivilege' => new sfWidgetFormInput(),
            'zarafaCompanyServer' => new sfWidgetFormSelect( array('choices' => array())),
#            'zarafaQuotaCompanyWarningRecipients' => new sfWidgetFormInput(),
            'zarafaQuotaOverride' => new sfWidgetFormInputCheckbox(),
#            'zarafaQuotaUserWarningRecipients' => new sfWidgetFormInput(),
            'zarafaQuotaWarn' => new sfWidgetFormInput(),
            'zarafaSystemAdmin' => new sfWidgetFormInput(),
            'zarafaUserDefaultQuotaOverride' => new sfWidgetFormInputCheckbox(),
            'zarafaUserDefaultQuotaHard' => new sfWidgetFormSelect( array('choices' => sfConfig::get('hardQuotas')) ),
            /* 'zarafaUserDefaultQuotaSoft' => new sfWidgetFormInput(), */
            /* 'zarafaUserDefaultQuotaWarn' => new sfWidgetFormInput(), */
#            'zarafaViewPrivilege' => new sfWidgetFormInput(),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
        
        $this->widgetSchema->setLabels(array(
            'cn' => 'Name',
            'status' => 'Status',
            'undeletable' => 'Undeletable',
        
#            'zarafaAccount' => 'entry is a part of zarafa', // integer
#            'zarafaHidden' => 'This object should be hidden from address book', // integer
#            'zarafaAdminPrivilege' => 'Users from different companies which are administrator over selected company', // dn(s)
            'zarafaCompanyServer' => 'Home server for the user', // dn
#            'zarafaQuotaCompanyWarningRecipients' => 'Users who will recieve a notification email when a company exceeds its quota', // dn(s)
            'zarafaQuotaOverride' => 'Override child quota', // integer
#            'zarafaQuotaUserWarningRecipients' => 'Users who will recieve a notification email when a user exceeds his quota', // dn(s)
            'zarafaQuotaWarn' => 'Warning quota size in MB', // integer 
            'zarafaSystemAdmin' => 'The user who is the system administrator for this company', // dn
            'zarafaUserDefaultQuotaOverride' => 'Override User default quota for children', // integer
            'zarafaUserDefaultQuotaHard' => 'User default hard quota size in MB', // integer
            'zarafaUserDefaultQuotaSoft' => 'User default soft quota size in MB', // integer
            'zarafaUserDefaultQuotaWarn' => 'User default warning quota size in MB', // integer
#            'zarafaViewPrivilege' => 'Companies with view privileges over selected company', // dn(s)
        ));
        
        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'ip' => new sfValidatorIpAddress(),
            'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
        
#            'zarafaAccount' => new sfValidatorString(),
#            'zarafaHidden' => new sfValidatorString(),
#            'zarafaAdminPrivilege' => new sfValidatorString(),
            'zarafaCompanyServer' => new sfValidatorString(),
#            'zarafaQuotaCompanyWarningRecipients' => new sfValidatorString(),
            'zarafaQuotaOverride' => new sfValidatorString(),
#            'zarafaQuotaUserWarningRecipients' => new sfValidatorString(),
            'zarafaQuotaWarn' => new sfValidatorString(),
            'zarafaSystemAdmin' => new sfValidatorString(),
            'zarafaUserDefaultQuotaHard' => new sfValidatorString(),
            'zarafaUserDefaultQuotaOverride' => new sfValidatorString(),
            'zarafaUserDefaultQuotaSoft' => new sfValidatorString(),
            'zarafaUserDefaultQuotaWarn' => new sfValidatorString(),
#            'zarafaViewPrivilege' => new sfValidatorString(),
        ));
    }
}

