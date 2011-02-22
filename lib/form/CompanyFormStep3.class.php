<?php
class CompanyFormStep3 extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'zarafaUserDefaultQuotaOverride' => new sfWidgetFormInputCheckbox(array(), array('onClick' => 'showUserQuotaFields()')),
            'zarafaUserDefaultQuotaHard' => new  sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
            'zarafaUserDefaultQuotaSoft' => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
            'zarafaUserDefaultQuotaWarn' => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
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

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );


        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
                new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, '_undefined_'),
                new sfValidatorAnd(array(
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, 'on'),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 100),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaSoft'),
                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaSoft', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaWarn'),
                )),
         )));





        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
        )));
    }
}
