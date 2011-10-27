<?php
class PlatformForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'cn'          => new sfWidgetFormInput(array(), array('pattern' => '[a-zA-Z ]{5,}', 'maxlength' => 30, 'required' => 'required')),
            'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'multiserver' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'status'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
        ));
    
        $this->widgetSchema->setLabels(array(
            'cn'          => 'Name',
            'multitenant' => 'Multi tenant',
            'multiserver' => 'Multi server',
            'status'      => 'Enable',
        ));
    
        $this->setValidators(array(
            'cn'          => new sfValidatorString(),
            'multitenant' => new sfValidatorBoolean(),
            'multiserver' => new sfValidatorBoolean(),
            'status'      => new sfValidatorBoolean(),
        ));
    
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

