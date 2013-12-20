<?php
class ServerForm extends ZacaciaForm
{
    protected static $quotas = array();

    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');
        
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'cn'                    => new sfWidgetFormInput(array(), array('class' => 'form-control')),
            'ip'                    => new sfWidgetFormInput(array(), array('class' => 'form-control')),
            'status'                => new sfWidgetFormChoice(array('choices' => self::$option_status), array('class' => 'form-control')),
            
            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes), array('class' => 'form-control')),

            'zarafaQuotaHard'       => new sfWidgetFormInput(array(), array('type' => 'number', 'class' => 'form-control')),
            'zarafaFilePath'        => new sfWidgetFormInputHidden(array('default' => '/var/run/zarafa'), array('class' => 'form-control')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('type' => 'number', 'class' => 'form-control')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('type' => 'number', 'class' => 'form-control')),
            'zarafaSslPort'         => new sfWidgetFormInput(array(), array('type' => 'number', 'class' => 'form-control')),
            'zarafaContainsPublic'  => new sfWidgetFormChoice(array('choices' => self::$option_noyes), array('class' => 'form-control')),
            'multitenant'           => new sfWidgetFormChoice(array('choices' => self::$option_noyes), array('class' => 'form-control')),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn'                    => 'Name',
            'ip'                    => 'IP Address',
            'status'                => 'Enable',
            
            'zarafaAccount'         => 'Zarafa Host',
            'zarafaQuotaHard'       => 'Hard Quota Level',
#           zarafaQuotaHard'       => 'default Hard Quota Level',
#           zarafaQuotaSoft'       => 'default Soft Quota Level',
#           zarafaQuotaWarn'       => 'default Warn Quota Level',
            'zarafaHttpPort'        => 'HTTP Port',
            'zarafaSslPort'         => 'SSL Port',
            'zarafaContainsPublic'  => 'Contains Public Store',
            'multitenant'           => 'Multi tenant',
        ));
        
        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'cn'                    => new sfValidatorString(),
            'ip'                    => new sfValidatorIpAddress(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
            
            'zarafaAccount'         => new  sfValidatorInteger(),
            'zarafaQuotaHard'       => new sfValidatorInteger(),
            'zarafaFilePath'        => new sfValidatorString(),
            'zarafaHttpPort'        => new sfValidatorInteger(), //array('required' => false)),
            'zarafaSslPort'         => new sfValidatorInteger(), //array('required' => false)),
            'zarafaContainsPublic'  => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'multitenant'           => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}
