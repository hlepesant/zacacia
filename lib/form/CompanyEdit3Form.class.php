<?php
class CompanyEdit3Form extends ZacaciaForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');
        $public_folder_option = array( 0 => 'no', 1 => 'yes');

        $this->setWidgets(array(
            'zarafaUserDefaultQuotaOverride'    => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1), array('onClick' => 'showUserQuotaFields()')),
            'zarafaUserDefaultQuotaHard'        => new  sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
            'zarafaUserDefaultQuotaSoft'        => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
            'zarafaUserDefaultQuotaWarn'        => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
        ));

        $this->setValidators(array(
            'zarafaUserDefaultQuotaOverride'    => new sfValidatorBoolean(array('required' => false)),
            'zarafaUserDefaultQuotaHard'        => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaSoft'        => new sfValidatorInteger(array('required' => false)),
            'zarafaUserDefaultQuotaWarn'        => new sfValidatorInteger(array('required' => false)),
        ));
        
        $this->widgetSchema->setLabels(array(
            'zarafaUserDefaultQuotaOverride'    => 'Override User default quota for children', // integer
            'zarafaUserDefaultQuotaHard'        => 'User default hard quota size in MB', // integer
            'zarafaUserDefaultQuotaSoft'        => 'User default soft quota size in MB', // integer
            'zarafaUserDefaultQuotaWarn'        => 'User default warning quota size in MB', // integer
        ));

#        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
#                new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, 0),
#                new sfValidatorAnd(array(
#                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaOverride', sfValidatorSchemaCompare::EQUAL, 1),
#                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 100),
#                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaHard', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaSoft'),
#                    new sfValidatorSchemaCompare('zarafaUserDefaultQuotaSoft', sfValidatorSchemaCompare::GREATER_THAN, 'zarafaUserDefaultQuotaWarn'),
#                )),
#         )));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
 }
