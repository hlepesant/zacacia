<?php
class PlatformEditForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'multitenant'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'multiserver'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'status'        => new sfWidgetFormChoice(array('choices' => self::$option_status)),
        ));
        
        $this->widgetSchema->setLabels(array(
            'multitenant'   => 'Multi tenant',
            'multiserver'   => 'Multi server',
            'status'        => 'Enable',
        ));
        
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'multitenant'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'multiserver'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'status'        => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

