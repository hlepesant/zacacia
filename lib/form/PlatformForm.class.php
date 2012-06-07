<?php
class PlatformForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'cn'            => new sfWidgetFormInput(array(), array('pattern' => '[a-zA-Z ]{5,}', 'maxlength' => 30, 'required' => 'required', 'class' => 'text')),
            'multitenant'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'multiserver'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'status'        => new sfWidgetFormChoice(array('choices' => self::$option_status)),
        ));
    
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
            'multitenant'   => 'Multi tenant',
            'multiserver'   => 'Multi server',
            'status'        => 'Status',
        ));
    
        $this->setValidators(array(
            'cn'            => new sfValidatorString(),
            'multitenant'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'multiserver'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'status'        => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
        ));
    
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

