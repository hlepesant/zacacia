<?php
class DomainEditForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'domainDn'      => new sfWidgetFormInputHidden(),
            'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));
    
        $this->widgetSchema->setLabels(array(
            'status'        => 'Enable',
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'domainDn'      => new sfValidatorString(),
            'status'        => new sfValidatorBoolean(),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

