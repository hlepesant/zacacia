<?php
class DomainForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'cn'            => new sfWidgetFormInput(),
            'status'        => new sfWidgetFormChoice(array('choices' => self::$option_status)),
        ));
    
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
            'status'        => 'Enable',
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'cn'            => new sfValidatorString(),
            'status'        => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

