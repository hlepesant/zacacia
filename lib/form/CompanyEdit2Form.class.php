<?php
class CompanyEdit2Form extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'zarafaQuotaOverride' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1), array('onClick' => 'showCompanyQuotaFields()')),
            'zarafaQuotaWarn' => new sfWidgetFormInput(array(), array('class' => 'small-80', 'maxlength' => '8', 'disabled' => 'true')),
        ));

        $this->setValidators(array(
            'zarafaQuotaOverride' => new sfValidatorBoolean(array('required' => false)),
            'zarafaQuotaWarn' => new sfValidatorInteger(array('required' => false)),
        ));
        
        $this->widgetSchema->setLabels(array(
            'zarafaQuotaOverride' => 'Override child quota', // integer
            'zarafaQuotaWarn' => 'Warning quota size in MB', // integer 
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
            new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, 0),
            new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::GREATER_THAN, 1),
        )));


        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
 }
