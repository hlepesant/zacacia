<?php
class CompanyNew1Form extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');

        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'cn'            => new sfWidgetFormInput(),
#            'status'        => new sfWidgetFormSelect( array('choices' => $status) ),
            'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'undeletable'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
#            'status'        => 'Status',
            'status'        => 'Enable',
            'undeletable'   => 'Undeletable',
        ));

        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'cn'            => new sfValidatorString(),
#            'status'        => new sfValidatorChoice(array('choices' => array_keys($status))),
            'status'        => new sfValidatorBoolean(),
            'undeletable'   => new sfValidatorBoolean(),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

