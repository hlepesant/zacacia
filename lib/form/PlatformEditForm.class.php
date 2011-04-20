<?php
class PlatformEditForm extends MinivISPForm
{
    public function configure()
    {
        $status = array(
            'enable'    => parent::__('enable'),
            'disable'   => parent::__('disable')
        );
        
        $this->setWidgets(array(
            'platformDn'  => new sfWidgetFormInputHidden(),
            'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'multiserver' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'status'      => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
        
        $this->widgetSchema->setLabels(array(
            'multitenant' => 'Multi tenant',
            'multiserver' => 'Multi server',
            'status'      => 'Status',
            'undeletable' => 'Undeletable',
        ));
        
        $this->setValidators(array(
            'platformDn'  => new sfValidatorString(),
            'multitenant' => new sfValidatorBoolean(),
            'multiserver' => new sfValidatorBoolean(),
            'status'      => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorBoolean(),
        ));
    }
}

