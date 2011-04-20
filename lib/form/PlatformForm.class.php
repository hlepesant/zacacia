<?php
class PlatformForm extends MinivISPForm
{
    public function configure()
    {
        $status = array(
            'enable'    => parent::__('enable'),
            'disable'   => parent::__('disable')
        );
    
        $this->setWidgets(array(
            'cn'          => new sfWidgetFormInput(array(), array('pattern' => '[a-zA-Z ]{5,}', 'maxlength' => 30, 'required' => 'required')),
            'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'multiserver' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'status'      => new sfWidgetFormSelect(array('choices' => $status)),
            'undeletable' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));
    
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    
        $this->widgetSchema->setLabels(array(
            'cn'          => 'Name',
            'multitenant' => 'Multi tenant',
            'multiserver' => 'Multi server',
            'status'      => 'Status',
            'undeletable' => 'Undeletable',
        ));
    
        $this->setValidators(array(
            'cn'          => new sfValidatorString(),
            'multitenant' => new sfValidatorBoolean(),
            'multiserver' => new sfValidatorBoolean(),
            'status'      => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorBoolean(),
        ));
    }
}

