<?php
class CompanyForm extends MinivISPForm
{
    protected $step;
    protected $status;
    protected $undeletable;
    protected $public_folder_option;

    public function __construct($step)
    {
        $this->setCurrentStep($step);
        $this->setChoicesOptions();
        return parent::__construct();
    }

    private function setCurrentStep($v)
    {
        $this->step = $v;
        return $this;
    }

    private function getCurrentStep()
    {
        return $this->step;
    }

    private function setChoicesOptions()
    {
        $this->status = array('enable' => 'enable', 'disable' => 'disable');
        $this->undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');
        $this->public_folder_option = array( 0 => 'no', 1 => 'yes');
        return $this;
    }

    public function configure()
    {
        switch( $this->getCurrentStep() )
        {
            case 1:
                $widgets = $this->setWidgetsStep1();
                $validators = $this->setValidatorsStep1();
            break;

            case 2:
                $widgets = $this->setWidgetsStep2();
                $validators = $this->setValidatorsStep2();
            break;

            case 3;
                $widgets = $this->setWidgetsStep3();
                $validators = $this->setValidatorsStep3();
            break;
        }
        $this->setWidgets($widgets);
        $this->setValidators($validators);

        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
        
        $this->widgetSchema->setLabels(array(
            'cn' => 'Name',
            'status' => 'Status',
            'undeletable' => 'Undeletable',
            'zarafaAccount' => 'entry is a part of zarafa', // integer
            'zarafaHidden' => 'This object should be hidden from address book', // integer
            'zarafaAdminPrivilege' => 'Users from different companies which are administrator over selected company', // dn(s)
            'zarafaCompanyServer' => 'Home server for the user', // dn
            'zarafaQuotaCompanyWarningRecipients' => 'Users who will recieve a notification email when a company exceeds its quota', // dn(s)
            'zarafaQuotaOverride' => 'Override child quota', // integer
            'zarafaQuotaUserWarningRecipients' => 'Users who will recieve a notification email when a user exceeds his quota', // dn(s)
            'zarafaQuotaWarn' => 'Warning quota size in MB', // integer 
            'zarafaSystemAdmin' => 'The user who is the system administrator for this company', // dn
            'zarafaUserDefaultQuotaOverride' => 'Override User default quota for children', // integer
            'zarafaUserDefaultQuotaHard' => 'User default hard quota size in MB', // integer
            'zarafaUserDefaultQuotaSoft' => 'User default soft quota size in MB', // integer
            'zarafaUserDefaultQuotaWarn' => 'User default warning quota size in MB', // integer
            'zarafaViewPrivilege' => 'Companies with view privileges over selected company', // dn(s)
        ));
    }

    private function setWidgetsStep1()
    {
        $w = array();
        // step 1
        $w['step'] = new sfWidgetFormInputHidden();
        $w['platformDn'] = new sfWidgetFormInputHidden();
        $w['cn'] = new sfWidgetFormInput();
        $w['status'] = new sfWidgetFormSelect( array('choices' => $this->status) );
        $w['undeletable'] = new sfWidgetFormSelect( array('choices' => $this->undeletable) );
        // for step 2
        $w['zarafaAccount'] = new sfWidgetFormInputHidden();
        $w['zarafaHidden'] = new sfWidgetFormInputHidden();
        $w['zarafaAdminPrivilege'] = new sfWidgetFormInputHidden();
        $w['zarafaCompanyServer'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaCompanyWarningRecipients'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaOverride'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaUserWarningRecipients'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaSystemAdmin'] = new sfWidgetFormInputHidden();
        // for step 3
        $w['zarafaUserDefaultQuotaOverride'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaHard'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaSoft'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaViewPrivilege'] = new sfWidgetFormInputHidden();

        return $w;
    }

    private function setWidgetsStep2()
    {
        $w = array();
        // from step 1
        $w['step'] = new sfWidgetFormInputHidden();
        $w['platformDn'] = new sfWidgetFormInputHidden();
        $w['cn'] = new sfWidgetFormInputHidden();
        $w['status'] = new sfWidgetFormInputHidden();
        $w['undeletable'] =  new sfWidgetFormInputHidden();
        // step 2
        $w['zarafaAccount'] = new sfWidgetFormInput();
        $w['zarafaHidden'] = new sfWidgetFormInput();
        $w['zarafaAdminPrivilege'] = new sfWidgetFormInput();
        $w['zarafaCompanyServer'] = new sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') );
        $w['zarafaQuotaCompanyWarningRecipients'] = new sfWidgetFormInput();
        $w['zarafaQuotaOverride'] = new sfWidgetFormInputCheckbox(array(), array('onClick' => 'setCompanyWarningQuota()'));
        $w['zarafaQuotaUserWarningRecipients'] = new sfWidgetFormInput();
        $w['zarafaQuotaWarn'] = new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6'));
        $w['zarafaQuotaWarn'] = new sfWidgetFormSelect(array(
                'choices' => sfConfig::get('options_company_quota_warn'),
                'default' => sfConfig::get('global_company_quota_warn'),
                ), array('disabled' => 'true'));
        $w['zarafaSystemAdmin'] = new  sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') );
        // for step 3
        $w['zarafaUserDefaultQuotaOverride'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaHard'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaSoft'] = new sfWidgetFormInputHidden();
        $w['zarafaUserDefaultQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaViewPrivilege'] = new sfWidgetFormInputHidden();

        return $w;
    }

    private function setWidgetsStep3()
    {
        $w = array();
        // from step 1
        $w['step'] = new sfWidgetFormInputHidden();
        $w['platformDn'] = new sfWidgetFormInputHidden();
        $w['cn'] = new sfWidgetFormInputHidden();
        $w['status'] = new sfWidgetFormInputHidden();
        $w['undeletable'] =  new sfWidgetFormInputHidden();
        // from step 2
        $w['zarafaAccount'] = new sfWidgetFormInputHidden();
        $w['zarafaHidden'] = new sfWidgetFormInputHidden();
        $w['zarafaAdminPrivilege'] = new sfWidgetFormInputHidden();
        $w['zarafaCompanyServer'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaCompanyWarningRecipients'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaOverride'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaUserWarningRecipients'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaQuotaWarn'] = new sfWidgetFormInputHidden();
        $w['zarafaSystemAdmin'] = new sfWidgetFormInputHidden();
        // step 3
        $w['zarafaUserDefaultQuotaOverride'] = new sfWidgetFormInputCheckbox(array(), array('onClick' => 'setUserHardQuota()'));
        $w['zarafaUserDefaultQuotaHard'] = new sfWidgetFormSelect(
            array(
                'choices' => sfConfig::get('options_user_quota_hard'),
                'default' => sfConfig::get('server_user_quota_default'),
            ),
            array('disabled' => 'true')
        );
        $w['zarafaUserDefaultQuotaSoft'] = new sfWidgetFormInput();
        $w['zarafaUserDefaultQuotaWarn'] = new sfWidgetFormInput();
        $w['zarafaViewPrivilege'] = new sfWidgetFormInput();

        return $w;
    }

    private function setValidatorsStep1()
    {
        $v = array();
        // step 1
        $v['step'] = new sfValidatorInteger(array('min' => 1, 'max' => 3));
        $v['platformDn'] = new sfValidatorString();
        $v['cn'] = new sfValidatorString();
        $v['status'] = new sfValidatorChoice(array('choices' => array_keys($this->status)));
        $v['undeletable'] = new sfValidatorChoice(array('choices' => array_keys($this->undeletable)));
        // for step 2
        $v['zarafaAccount'] = new sfValidatorString(array('required' => false));
        $v['zarafaHidden'] = new sfValidatorString(array('required' => false));
        $v['zarafaAdminPrivilege'] = new sfValidatorString(array('required' => false));
        $v['zarafaCompanyServer'] = new sfValidatorString(array('required' => false));
        $v['zarafaQuotaCompanyWarningRecipients'] = new sfValidatorString(array('required' => false));
        $v['zarafaQuotaOverride'] = new sfValidatorBoolean(array('required' => false));
        $v['zarafaQuotaUserWarningRecipients'] = new sfValidatorString(array('required' => false));
        $v['zarafaQuotaWarn'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaSystemAdmin'] = new sfValidatorString(array('required' => false));
        // for step 3
        $v['zarafaUserDefaultQuotaOverride'] = new sfValidatorBoolean(array('required' => false));
        $v['zarafaUserDefaultQuotaHard'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaUserDefaultQuotaSoft'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaUserDefaultQuotaWarn'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaViewPrivilege'] = new sfValidatorString(array('required' => false));

        return $v;
    }

    private function setValidatorsStep2()
    {
        // step 1
        $v['step'] = new sfValidatorInteger(array('min' => 1, 'max' => 3));
        $v['platformDn'] = new sfValidatorString();
        $v['cn'] = new sfValidatorString();
        $v['status'] = new sfValidatorChoice(array('choices' => array_keys($this->status)));
        $v['undeletable'] = new sfValidatorChoice(array('choices' => array_keys($this->undeletable)));
        // for step 2
        $v['zarafaAccount'] = new sfValidatorString();
        $v['zarafaHidden'] = new sfValidatorString();
        $v['zarafaAdminPrivilege'] = new sfValidatorString();
        $v['zarafaCompanyServer'] = new sfValidatorString();
        $v['zarafaQuotaCompanyWarningRecipients'] = new sfValidatorString();
        $v['zarafaQuotaOverride'] = new sfValidatorBoolean();
        $v['zarafaQuotaUserWarningRecipients'] = new sfValidatorString();
        $v['zarafaQuotaWarn'] = new sfValidatorInteger();
        $v['zarafaSystemAdmin'] = new sfValidatorString();
        // for step 3
        $v['zarafaUserDefaultQuotaOverride'] = new sfValidatorBoolean(array('required' => false));
        $v['zarafaUserDefaultQuotaHard'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaUserDefaultQuotaSoft'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaUserDefaultQuotaWarn'] = new sfValidatorInteger(array('required' => false));
        $v['zarafaViewPrivilege'] = new sfValidatorString(array('required' => false));

        return $v;
    }

    private function setValidatorsStep3()
    {
        // step 1
        $v['step'] = new sfValidatorInteger(array('min' => 1, 'max' => 3));
        $v['platformDn'] = new sfValidatorString();
        $v['cn'] = new sfValidatorString();
        $v['status'] = new sfValidatorChoice(array('choices' => array_keys($this->status)));
        $v['undeletable'] = new sfValidatorChoice(array('choices' => array_keys($this->undeletable)));
        // for step 2
        $v['zarafaAccount'] = new sfValidatorString();
        $v['zarafaHidden'] = new sfValidatorString();
        $v['zarafaAdminPrivilege'] = new sfValidatorString();
        $v['zarafaCompanyServer'] = new sfValidatorString();
        $v['zarafaQuotaCompanyWarningRecipients'] = new sfValidatorString();
        $v['zarafaQuotaOverride'] = new sfValidatorBoolean();
        $v['zarafaQuotaUserWarningRecipients'] = new sfValidatorString();
        $v['zarafaQuotaWarn'] = new sfValidatorInteger();
        $v['zarafaSystemAdmin'] = new sfValidatorString();
        // for step 3
        $v['zarafaUserDefaultQuotaOverride'] = new sfValidatorBoolean();
        $v['zarafaUserDefaultQuotaHard'] = new sfValidatorInteger();
        $v['zarafaUserDefaultQuotaSoft'] = new sfValidatorInteger();
        $v['zarafaUserDefaultQuotaWarn'] = new sfValidatorInteger();
        $v['zarafaViewPrivilege'] = new sfValidatorString();

        return $v;
    }
}

