<?php
class ServerForm extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        $public_folder_option = array( 0 => 'no', 1 => 'yes');

        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'cn' => new sfWidgetFormInput(),
            'ip' => new sfWidgetFormInput(), //array(), array('pattern' => '([0-9]{1,3}\.){3}[0-9]{1,3}')),
            'zarafaHttpPort' => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
            'zarafaSslPort' => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
            'zarafaContainsPublic' => new sfWidgetFormSelect( array('choices' => $public_folder_option) ),
            'multitenant' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
            'status' => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );

        $this->widgetSchema->setLabels(array(
            'cn' => 'Name',
            'ip' => 'IP Address',
            'zarafaHttpPort' => 'Port for the http connection',
            'zarafaSslPort' => 'Port for the ssl connection',
            'zarafaContainsPublic' => 'Contains Public Store',
            'multitenant' => 'Multi tenant',
            'status' => 'Status',
            'undeletable' => 'Undeletable',
        ));

        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'cn' => new sfValidatorString(),
            'ip' => new sfValidatorIpAddress(),
            'zarafaHttpPort' => new sfValidatorInteger(),
            'zarafaSslPort' => new sfValidatorInteger(),
            'zarafaContainsPublic' => new sfValidatorChoice(array('choices' => array_keys($public_folder_option))),
            'multitenant' => new sfValidatorBoolean(),
            'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorBoolean(),
        ));
    }
}

