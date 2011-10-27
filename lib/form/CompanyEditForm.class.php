<?php
class CompanyEditForm extends ZacaciaForm
{
    protected static $quotas = array();

    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');

        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
#            'cn'            => new sfWidgetFormInput(),
            'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
#
            'zarafaAccount'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
#            'zarafaCompanyServer'   => new sfWidgetFormSelect(array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
            'zarafaQuotaOverride'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'zarafaQuotaWarn'       => new sfWidgetFormInput(array(), array(
                    'type' => 'number',
                    'size' => '5',
                    'min' => 25,
                    'max' => 2048,
                    'maxlength' => '4', 
                    'data-message' => 'Enter a value between 25 and 2048',
                )),
#
            'zarafaUserDefaultQuotaOverride' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'zarafaUserDefaultQuotaHard'     => new sfWidgetFormSelect(array('choices' => self::$quotas)),
        ));
        
        $this->widgetSchema->setLabels(array(
#            'cn'            => 'Name',
            'status'        => 'Enable',
#
            'zarafaAccount'         => 'Zarafa Properties',
#            'zarafaCompanyServer'   => 'Home server for the company', // dn
            'zarafaQuotaOverride'   => 'Override System Wide Quota', // integer
            'zarafaQuotaWarn'       => ' - Company Warning Quota', // integer 
#
            'zarafaUserDefaultQuotaOverride' => 'Override User Default Quota',
            'zarafaUserDefaultQuotaHard' => ' - User Hard Quota',
            'zarafaUserDefaultQuotaSoft' => ' - User Soft Quota',
            'zarafaUserDefaultQuotaWarn' => ' - User Warning Quota',
        ));

        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
#            'cn'            => new sfValidatorString(),
            'status'        => new sfValidatorBoolean(),
#
            'zarafaAccount'         => new sfValidatorBoolean(),
#            'zarafaCompanyServer'   => new sfValidatorString(array('required' => false)),
            'zarafaQuotaOverride'   => new sfValidatorBoolean(),
            'zarafaQuotaWarn'       => new sfValidatorInteger(array('required' => false)),
#
            'zarafaUserDefaultQuotaOverride' => new sfValidatorBoolean(),
            'zarafaUserDefaultQuotaHard' => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaSoft' => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaWarn' => new sfValidatorInteger(array('required' => false)),
        ));
/*
        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
            new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, 1),
            new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::GREATER_THAN, 1),
        )));
*/
/*
        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
                new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, '_undefined_'),
                new sfValidatorAnd(array(
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, 1),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 100),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaSoft'),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaSoft', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaWarn'),
                )),
        )));
*/
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

