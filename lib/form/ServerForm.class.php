<?php
class ServerForm extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'cn'                    => new sfWidgetFormInput(),
            'ip'                    => new sfWidgetFormInput(),
            'status'                => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1', 'default' => '1')),
            'undeletable'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),

            'zarafaAccount'         => new sfWidgetFormInputHidden(array('default' => '1')),
            'zarafaFilePath'        => new sfWidgetFormInputHidden(array('default' => '/var/run/zarafa')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('type' => 'number')),
            'zarafaSslPort'         => new sfWidgetFormInput(array(), array('type' => 'number')),
            'zarafaContainsPublic'  =>  new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1', 'default' => '1')),
            'multitenant'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));

        $this->widgetSchema->setLabels(array(
            'cn'                    => 'Name',
            'ip'                    => 'IP Address',
            'status'                => 'Enable',
            'undeletable'           => 'Undeletable',

            'zarafaAccount'         => 'Zarafa Properties',
            'zarafaHttpPort'        => 'HTTP Port',
            'zarafaSslPort'         => 'SSL Port',
            'zarafaContainsPublic'  => 'Contains Public Store',
            'multitenant'           => 'Multi tenant',
        ));

        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'cn'                    => new sfValidatorString(),
            'ip'                    => new sfValidatorIpAddress(),
            'status'                => new sfValidatorBoolean(),
            'undeletable'           => new sfValidatorBoolean(),

            'zarafaAccount'         => new sfValidatorBoolean(),
            'zarafaFilePath'        => new sfValidatorString(),
            'zarafaHttpPort'        => new sfValidatorInteger(), //array('required' => false)),
            'zarafaSslPort'         => new sfValidatorInteger(), //array('required' => false)),
            'zarafaContainsPublic'  => new sfValidatorBoolean(),
            'multitenant'           => new sfValidatorBoolean(),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

