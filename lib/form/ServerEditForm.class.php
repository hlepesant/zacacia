<?php
class ServerEditForm extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'serverDn'              => new sfWidgetFormInputHidden(),
            'ip'                    => new sfWidgetFormInput(),
            'status'                => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),

#            'zarafaAccount'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'zarafaAccount'         => new sfWidgetFormInputHidden(array('default' => '1')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
            'zarafaSslPort'         => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
            'zarafaContainsPublic'  => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'multitenant'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));

        $this->widgetSchema->setLabels(array(
            'ip'                    => 'IP Address',
            'status'                => 'Status',
            'undeletable'           => 'Undeletable',

#            'zarafaAccount'         => 'Entry is a part of Zarafa',
            'zarafaAccount'         => 'Zarafa Properties',
            'zarafaHttpPort'        => 'Port for the http connection',
            'zarafaSslPort'         => 'Port for the ssl connection',
            'zarafaContainsPublic'  => 'Contains Public Store',
            'multitenant'           => 'Multi tenant',
        ));

        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'serverDn'              => new sfValidatorString(),
            'ip'                    => new sfValidatorIpAddress(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable'           => new sfValidatorBoolean(),

            'zarafaAccount'         => new sfValidatorBoolean(),
            'zarafaHttpPort'        => new sfValidatorInteger(), //array('required' => false)),
            'zarafaSslPort'         => new sfValidatorInteger(), //array('required' => false)),
            'zarafaContainsPublic'  => new sfValidatorBoolean(),
            'multitenant'           => new sfValidatorBoolean(),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

