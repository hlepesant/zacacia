<?php
class CompanyForm extends ZacaciaForm
{
    protected static $quotas = array();

    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');
        
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'cn'                    => new sfWidgetFormInput(),
            'status'                => new sfWidgetFormChoice(array('choices' => self::$option_status)),
            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
#           'zarafaCompanyServer'   => new sfWidgetFormSelect(array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
            'zarafaQuotaOverride'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaQuotaWarn'       => new sfWidgetFormInput(array(), array(
                'type' => 'number',
                'size' => '5',
                'min' => 25,
                'max' => 2048,
                'maxlength' => '4', 
                'data-message' => 'Enter a value between 25 and 2048',
            )),

            'zarafaUserDefaultQuotaOverride'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaUserDefaultQuotaHard'     => new sfWidgetFormInput(),
            'zarafaUserDefaultQuotaSoft'     => new sfWidgetFormInput(),
            'zarafaUserDefaultQuotaWarn'     => new sfWidgetFormInput(),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
            'status'        => 'Enable',
            'zarafaAccount'         => 'Zarafa Account',
#           'zarafaCompanyServer'   => 'Home server for the company', // dn
            'zarafaQuotaOverride'   => 'Override System Wide Quota', // integer
            'zarafaQuotaWarn'       => 'Company Warning Quota', // integer 

            'zarafaUserDefaultQuotaOverride'    => 'Override User Default Quota',
            'zarafaUserDefaultQuotaHard'        => 'User Hard Quota',
            'zarafaUserDefaultQuotaSoft'        => 'User Soft Quota',
            'zarafaUserDefaultQuotaWarn'        => 'User Warning Quota',
        ));

        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'cn'            => new sfValidatorString(),
            'status'        => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
            'zarafaAccount'         => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
#           'zarafaCompanyServer'   => new sfValidatorString(array('required' => false)),
            'zarafaQuotaOverride'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'zarafaQuotaWarn'       => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaOverride'    => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'zarafaUserDefaultQuotaHard'        => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaSoft'        => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaWarn'        => new sfValidatorInteger(array('required' => false)),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

