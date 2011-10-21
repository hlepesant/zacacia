<?php
class PlatformEditForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'  => new sfWidgetFormInputHidden(),
            'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
#            'multiserver' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'status'      => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'undeletable' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));
        
        $this->widgetSchema->setLabels(array(
            'multitenant' => 'Multi tenant',
#            'multiserver' => 'Multi server',
            'status'      => 'Enable',
            'undeletable' => 'Undeletable',
        ));
        
        $this->setValidators(array(
            'platformDn'  => new sfValidatorString(),
            'multitenant' => new sfValidatorBoolean(),
#            'multiserver' => new sfValidatorBoolean(),
            'status'      => new sfValidatorBoolean(),
            'undeletable' => new sfValidatorBoolean(),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

