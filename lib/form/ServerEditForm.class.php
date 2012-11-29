<?php
class ServerEditForm extends ZacaciaForm
{
    protected static $quotas = array();
    
    public function configure()
    {
        self::$quotas = sfConfig::get('options_user_quota_hard');
        
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputHidden(),
            'serverDn'              => new sfWidgetFormInputHidden(),
            'ip'                    => new sfWidgetFormInput(),
            'status'                => new sfWidgetFormChoice(array('choices' => self::$option_status)),
            
            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),

            'zarafaQuotaHard'       => new sfWidgetFormInput(array(), array('type' => 'number')),
            'zarafaFilePath'        => new sfWidgetFormInputHidden(array('default' => '/var/run/zarafa')),
            'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('type' => 'number')),
            'zarafaSslPort'         => new sfWidgetFormInput(array(), array('type' => 'number')),
            'zarafaContainsPublic'  => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'multitenant'           => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
        ));
        
        $this->widgetSchema->setLabels(array(
            'ip'                    => 'IP Address',
            'status'                => 'Enable',
            
            'zarafaAccount'         => 'Zarafa Properties',
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
            'serverDn'              => new sfValidatorString(),
            'ip'                    => new sfValidatorIpAddress(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
            
            'zarafaAccount'         => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),

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

