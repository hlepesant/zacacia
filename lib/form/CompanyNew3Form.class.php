<?php
class CompanyNew3Form extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'zarafaUserDefaultQuotaOverride' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
/*
            'zarafaUserDefaultQuotaHard' => new  sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '4')),
            'zarafaUserDefaultQuotaSoft' => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '4')),
            'zarafaUserDefaultQuotaWarn' => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '4')),
*/
            'zarafaUserDefaultQuotaHard'       => new sfWidgetFormInput( array(), array(
                    'type' => 'number',
                    'size' => '5',
                    'min' => 25,
                    'max' => 2048,
                    'maxlength' => '4', 
                    'data-message' => 'Enter a value between 25 and 2048',
                )),
            'zarafaUserDefaultQuotaSoft'       => new sfWidgetFormInput( array(), array(
                    'type' => 'number',
                    'size' => '5',
                    'min' => 25,
                    'max' => 2048,
                    'maxlength' => '4', 
                    'data-message' => 'Enter a value between 25 and 2048',
                )),
            'zarafaUserDefaultQuotaWarn'       => new sfWidgetFormInput( array(), array(
                    'type' => 'number',
                    'size' => '5',
                    'min' => 25,
                    'max' => 2048,
                    'maxlength' => '4', 
                    'data-message' => 'Enter a value between 25 and 2048',
                )),

#            'zarafaViewPrivilege' => new sfWidgetFormInput(),
        ));

        $this->setValidators(array(
            'zarafaUserDefaultQuotaOverride' => new sfValidatorBoolean(),
            'zarafaUserDefaultQuotaHard' => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaSoft' => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaWarn' => new sfValidatorInteger(array('required' => false)),
#            'zarafaViewPrivilege' => new sfValidatorString(),
        ));

        $this->widgetSchema->setLabels(array(
            'zarafaUserDefaultQuotaOverride' => 'Override User default quota for children', // integer
            'zarafaUserDefaultQuotaHard' => 'User default hard quota size in MB', // integer
            'zarafaUserDefaultQuotaSoft' => 'User default soft quota size in MB', // integer
            'zarafaUserDefaultQuotaWarn' => 'User default warning quota size in MB', // integer
#            'zarafaViewPrivilege' => 'Companies with view privileges over selected company', // dn(s)
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
                new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, '_undefined_'),
                new sfValidatorAnd(array(
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, 1),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 100),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaSoft'),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaSoft', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaWarn'),
                )),
        )));

#        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array()));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}
