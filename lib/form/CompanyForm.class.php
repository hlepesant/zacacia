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
            'zarafaCompanyServer' => new sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
#            'zarafaQuotaCompanyWarningRecipients' => new sfWidgetFormInput(),
            'zarafaQuotaOverride' => new sfWidgetFormInputCheckbox(array(), array('onClick' => 'setCompanyWarningQuota()')),
#            'zarafaQuotaUserWarningRecipients' => new sfWidgetFormInput(),
#            'zarafaQuotaWarn' => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
            'zarafaQuotaWarn' => new sfWidgetFormSelect(array(
                'choices' => sfConfig::get('options_company_quota_warn'),
                'default' => sfConfig::get('global_company_quota_warn'),
                ), array('disabled' => 'true')),
            'zarafaSystemAdmin' => new  sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
            'zarafaUserDefaultQuotaOverride' => new sfWidgetFormInputCheckbox(array(), array('onClick' => 'setUserHardQuota()')),
            'zarafaUserDefaultQuotaHard' => new sfWidgetFormSelect(array(
                'choices' => sfConfig::get('options_user_quota_hard'),
                'default' => sfConfig::get('server_user_quota_default'),
                ), array('disabled' => 'true')),
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
#            'zarafaUserDefaultQuotaSoft' => 'User default soft quota size in MB', // integer
#            'zarafaUserDefaultQuotaWarn' => 'User default warning quota size in MB', // integer
#            'zarafaViewPrivilege' => 'Companies with view privileges over selected company', // dn(s)
        ));
        
        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'cn' => new sfValidatorString(),
            'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
#            'zarafaAccount' => new sfValidatorString(),
#            'zarafaHidden' => new sfValidatorString(),
#            'zarafaAdminPrivilege' => new sfValidatorString(),
            'zarafaCompanyServer' => new sfValidatorString(),
#            'zarafaQuotaCompanyWarningRecipients' => new sfValidatorString(),
            'zarafaQuotaOverride' => new sfValidatorBoolean(),
#            'zarafaQuotaUserWarningRecipients' => new sfValidatorString(),
            'zarafaQuotaWarn' => new sfValidatorInteger(),
            'zarafaSystemAdmin' => new sfValidatorString(),
            'zarafaUserDefaultQuotaOverride' => new sfValidatorBoolean(),
            'zarafaUserDefaultQuotaHard' => new sfValidatorInteger(),
#            'zarafaUserDefaultQuotaSoft' => new sfValidatorInteger(),
#            'zarafaUserDefaultQuotaWarn' => new sfValidatorInteger(),
#            'zarafaViewPrivilege' => new sfValidatorString(),
        ));
    }
}

