<?php
class DomainForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'cn'            => new sfWidgetFormInput(),
            'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1', 'default' => '1')),
        ));
    
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
            'status'        => 'Enable',
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'cn'            => new sfValidatorString(),
            'status'        => new sfValidatorBoolean(),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

