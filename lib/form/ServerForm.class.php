<?php
class ServerForm extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
#        $public_folder_option = array( 0 => 'no', 1 => 'yes');

        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'cn'                    => new sfWidgetFormInput(),
            'ip'                    => new sfWidgetFormInput(),
            'status'                => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),

#            'zarafaAccount'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'zarafaAccount'         => new sfWidgetFormInputHidden(array('default' => '1')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')), //, 'disabled' => 'disabled')),
            'zarafaSslPort'         => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')), //, 'disabled' => 'disabled')),
            'zarafaContainsPublic'  =>  new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')), //, array('disabled' => 'disabled')),
            'multitenant'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')), //, array('disabled' => 'disabled')),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );

        $this->widgetSchema->setLabels(array(
            'cn'                    => 'Name',
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
            'cn'                    => new sfValidatorString(),
            'ip'                    => new sfValidatorIpAddress(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable'           => new sfValidatorBoolean(),

            'zarafaAccount'         => new sfValidatorBoolean(),
            'zarafaHttpPort'        => new sfValidatorInteger(), //array('required' => false)),
            'zarafaSslPort'         => new sfValidatorInteger(), //array('required' => false)),
            'zarafaContainsPublic'  => new sfValidatorBoolean(),
            'multitenant'           => new sfValidatorBoolean(),
        ));
    }
}

