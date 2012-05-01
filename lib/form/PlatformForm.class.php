<?php
class PlatformForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'cn'          => new sfWidgetFormInput(array(), array('pattern' => '[a-zA-Z ]{5,}', 'maxlength' => 30, 'required' => 'required', 'class' => 'text')),
            #'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'multitenant' => new sfWidgetFormChoice(array('choices' => array('no', 'yes'))),
            #'multiserver' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
            'multiserver' => new sfWidgetFormChoice(array('choices' => array('no', 'yes'))),
            #'status'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
            'status'      => new sfWidgetFormChoice(array('choices' => array('enable', 'disable'))),
        ));
    
        $this->widgetSchema->setLabels(array(
            'cn'          => 'Name',
            'multitenant' => 'Multi tenant',
            'multiserver' => 'Multi server',
            'status'      => 'Status',
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

