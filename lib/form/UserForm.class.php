<?php
class UserForm extends ZacaciaForm
{
    protected static $quotas = array();

    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');

        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'companyDn'             => new sfWidgetFormInputHidden(),
            'status'                => new sfWidgetFormChoice(array('choices' => self::$option_status)),
# ObjectClasse: inetOrgPerson
            'givenName'             => new sfWidgetFormInput(),
            'sn'                    => new sfWidgetFormInput(),
            'cn'                    => new sfWidgetFormInputHidden(),
            'displayName'           => new sfWidgetFormInput(),
            'mail'                  => new sfWidgetFormInput(),
            'domain'                => new sfWidgetFormSelect(array('choices' => array())),
            'emailAddress'          => new sfWidgetFormInputHidden(),
# ObjectClasse: posixAccount
            'userPassword'          => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
            'confirmPassword'       => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
            'uid'                   => new sfWidgetFormInput(),
# ObjectClasse: zarafa-user
            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaAdmin'           => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaHidden'          => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaQuotaOverride'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaQuotaHard'       => new sfWidgetFormInput(),
            'zarafaQuotaWarn'       => new sfWidgetFormInput(),
            'zarafaQuotaSoft'       => new sfWidgetFormInput(),
/*
            'zarafaUserServer' => new sfWidgetFormSelect(array('choices' => array())),
*/
        ));
        
        $this->widgetSchema->setLabels(array(
            'status'                => 'Enable',
            'givenName'             => 'Lastname',
            'sn'                    => 'Firstname',
            'displayName'           => 'Display Name',
            'userPassword'          => 'Password',
            'confirmPassword'       => 'Confirm',
            'uid'                   => 'Username',
            'mail'                  => 'Email',
            
            'zarafaAccount'         => 'Zarafa Account',
            'zarafaAdmin'           => 'Zarafa Admin',
            'zarafaHidden'          => 'Hidden',
            'zarafaQuotaOverride'   => 'Override Quotas',
            // 'zarafaQuotaHard'       => 'Hard Quota',
            // 'zarafaQuotaWarn'       => 'Warning Quota',
            // 'zarafaQuotaSoft'       => 'Soft Quota',
            'zarafaQuotaHard'       => 'Hard',
            'zarafaQuotaWarn'       => 'Warning',
            'zarafaQuotaSoft'       => 'Soft',
/*
            'zarafaUserServer'      => new sfWidgetFormSelect(array('choices' => array())),
*/
        ));

        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'companyDn'             => new sfValidatorString(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
            'givenName'             => new sfValidatorString(),
            'sn'                    => new sfValidatorString(),
            'cn'                    => new sfValidatorString(),
            'displayName'           => new sfValidatorString(),
            'userPassword'          => new sfValidatorString(),
            'confirmPassword'       => new sfValidatorString(),
            'uid'                   => new sfValidatorString(),
            'mail'                  => new sfValidatorString(),
            'domain'                => new sfValidatorString(),
            'emailAddress'          => new sfValidatorEmail(),
            
            'zarafaAccount'         => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'zarafaAdmin'           => new sfValidatorBoolean(),
            'zarafaHidden'          => new sfValidatorBoolean(),
            'zarafaQuotaOverride'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'zarafaQuotaHard'       => new sfValidatorInteger(array('required' => false)),
            'zarafaQuotaWarn'       => new sfValidatorInteger(array('required' => false)),
            'zarafaQuotaSoft'       => new sfValidatorInteger(array('required' => false)),
/*
            'zarafaUserServer'      => new sfWidgetFormSelect(array('choices' => array())),
*/
        ));
    
        $this->validatorSchema->setPostValidator(
            new sfValidatorSchemaCompare('userPassword', sfValidatorSchemaCompare::EQUAL, 'confirmPassword')
        );
    
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

