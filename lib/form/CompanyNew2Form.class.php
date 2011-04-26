<?php
class CompanyNew2Form extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'zarafaAccount'         => new sfWidgetFormInputHidden(array('default' => '1')),
            'zarafaCompanyServer'   => new sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
            'zarafaQuotaOverride'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'zarafaQuotaWarn'       => new sfWidgetFormInput(
                array(), 
                array(
                    'type' => 'number',
                    'size' => '5',
                    'min' => 25,
                    'max' => 2048,
                    'maxlength' => '4', 
                    'data-message' => 'Enter a value between 25 and 2048',
                    'disabled' => 'disabled'
                )),
#            'zarafaQuotaWarn'       => new sfWidgetFormInput(array(), array('maxlength' => '8', 'disabled' => 'disabled')),
#            'zarafaHidden'         => new sfWidgetFormInputCheckbox(),
#            'zarafaAdminPrivilege' => new sfWidgetFormInput(),
#            'zarafaSystemAdmin'    => new sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
#            'zarafaQuotaCompanyWarningRecipients'  => new sfWidgetFormSelectMany( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
#            'zarafaQuotaUserWarningRecipients'     => new sfWidgetFormSelect( array('choices' => array(), 'default' => 'none'), array('class' => 'large') ),
        ));
        
        $this->widgetSchema->setLabels(array(
            'zarafaAccount'         => 'Entry is a part of Zarafa',
            'zarafaCompanyServer'   => 'Home server for the company', // dn
            'zarafaQuotaOverride'   => 'Override child quota', // integer
            'zarafaQuotaWarn'       => 'Warning quota size in MB', // integer 
#            'zarafaHidden'         => 'This object should be hidden from address book', // integer
#            'zarafaAdminPrivilege' => 'Users from different companies which are administrator over selected company', // dn(s)
#            'zarafaSystemAdmin'    => 'The user who is the system administrator for this company', // dn
#            'zarafaQuotaCompanyWarningRecipients'  => 'Users who will recieve a notification email when a company exceeds its quota', // dn(s)
#            'zarafaQuotaUserWarningRecipients'     => 'Users who will recieve a notification email when a user exceeds his quota', // dn(s)
        ));

        $this->setValidators(array(
            'zarafaAccount'         => new sfValidatorBoolean(),
            'zarafaCompanyServer'   => new sfValidatorString(array('required' => false)),
            'zarafaQuotaOverride'   => new sfValidatorBoolean(),
            'zarafaQuotaWarn'       => new sfValidatorInteger(array('required' => false)),
#            'zarafaHidden'         => new sfValidatorString(),
#            'zarafaAdminPrivilege' => new sfValidatorString(),
#            'zarafaSystemAdmin'    => new sfValidatorString(),
#            'zarafaQuotaCompanyWarningRecipients'  => new sfValidatorString(),
#            'zarafaQuotaUserWarningRecipients'     => new sfValidatorString(),
        ));

        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
            new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, 1),
            new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::GREATER_THAN, 1),
        )));
/*
        $this->validatorSchema->setPostValidator(new sfValidatorOr(array(
                new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, '_undefined_'),
                new sfValidatorAnd(array(
                    new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, 'on'),
                    new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::GREATER_THAN, 1),
                )),
         )));
*/

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

