<?php
class PlatformEditForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'cn'            => new sfWidgetFormInput( array(), array('readonly' => 'readonly','class' => 'form-control')),
            'multitenant'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes), array('class' => 'form-control')),
            'multiserver'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes), array('class' => 'form-control')),
            'status'        => new sfWidgetFormChoice(array('choices' => self::$option_status), array('class' => 'form-control')),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn'            => 'Name',
            'multitenant'   => 'Multi tenant',
            'multiserver'   => 'Multi server',
            'status'        => 'Enable',
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

