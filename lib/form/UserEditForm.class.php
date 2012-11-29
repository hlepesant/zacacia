<?php
class UserEditForm extends ZacaciaForm
{
    protected static $quotas = array();

    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');
        
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'companyDn'             => new sfWidgetFormInputHidden(),
            'userDn'                => new sfWidgetFormInputHidden(),
            'givenName'             => new sfWidgetFormInput(),
            'sn'                    => new sfWidgetFormInput(),
            'displayName'           => new sfWidgetFormInput(),
            'mail'                  => new sfWidgetFormInput(),
            'domain'                => new sfWidgetFormSelect(array('choices' => array())),
            'emailAddress'          => new sfWidgetFormInputHidden(),
            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaAdmin'           => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaHidden'          => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaQuotaOverride'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaQuotaHard'       => new sfWidgetFormInput(),
            'zarafaQuotaWarn'       => new sfWidgetFormInput(),
            'zarafaQuotaSoft'       => new sfWidgetFormInput(),
           #'zarafaUserServer'      => new sfWidgetFormSelect(array('choices' => array())),
        ));
        
        $this->widgetSchema->setLabels(array(
            'givenName'             => 'Lastname',
            'sn'                    => 'Firstname',
            'displayName'           => 'Display Name',
            'mail'                  => 'Email',
            'zarafaAdmin'           => 'Zarafa Admin',
            'zarafaHidden'          => 'Hidden',
            'zarafaQuotaOverride'   => 'Override Quotas',
            'zarafaQuotaWarn'       => 'Warning Quota',
            'zarafaQuotaSoft'       => 'Soft Quota',
            'zarafaQuotaHard'       => 'Hard Quota',
            #'zarafaUserServer'     => new sfWidgetFormSelect(array('choices' => array())),
        ));

        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'companyDn'             => new sfValidatorString(),
            'userDn'                => new sfValidatorString(),
            'givenName'             => new sfValidatorString(),
            'sn'                    => new sfValidatorString(),
            'displayName'           => new sfValidatorString(),
            'mail'                  => new sfValidatorString(),
            'domain'                => new sfValidatorString(),
            'zarafaAccount'         => new sfValidatorBoolean(),
            'zarafaAdmin'           => new sfValidatorBoolean(),
            'zarafaHidden'          => new sfValidatorBoolean(),
            'zarafaQuotaOverride'   => new sfValidatorBoolean(),
            'zarafaQuotaHard'       => new sfValidatorInteger(array('required' => false)),
            'zarafaQuotaWarn'       => new sfValidatorInteger(array('required' => false)),
            'zarafaQuotaSoft'       => new sfValidatorInteger(array('required' => false)),
            #'zarafaUserServer'     => new sfWidgetFormSelect(array('choices' => array())),
            'emailAddress'          => new sfValidatorEmail(),
        ));
    
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );

/*
        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
           new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, true),
           new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::LESS_THAN, 'zarafaQuotaSoft'),
           new sfValidatorSchemaCompare('zarafaQuotaSoft', sfValidatorSchemaCompare::LESS_THAN, 'zarafaQuotaHard')
        )));
*/
    }
}
