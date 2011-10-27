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
      'status'                => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
  
      'zarafaAccount'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaQuotaHard'       => new sfWidgetFormSelect(array('choices' => self::$quotas, 'default' => 0)),
      'zarafaFilePath'        => new sfWidgetFormInputHidden(array('default' => '/var/run/zarafa')),
      'zarafaHttpPort'        => new sfWidgetFormInput(array(), array('type' => 'number')),
      'zarafaSslPort'         => new sfWidgetFormInput(array(), array('type' => 'number')),
      'zarafaContainsPublic'  => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
      'multitenant'           => new sfWidgetFormInputCheckbox(array('value_attribute_value' => '1')),
    ));
  
    $this->widgetSchema->setLabels(array(
      'ip'                    => 'IP Address',
      'status'                => 'Enable',
  
      'zarafaAccount'         => 'Zarafa Properties',
      'zarafaQuotaHard'       => 'Hard Quota Level',
#      'zarafaQuotaHard'       => 'default Hard Quota Level',
#      'zarafaQuotaSoft'       => 'default Soft Quota Level',
#      'zarafaQuotaWarn'       => 'default Warn Quota Level',
      'zarafaHttpPort'        => 'HTTP Port',
      'zarafaSslPort'         => 'SSL Port',
      'zarafaContainsPublic'  => 'Contains Public Store',
      'multitenant'           => 'Multi tenant',
    ));
  
    $this->setValidators(array(
      'platformDn'            => new sfValidatorString(),
      'serverDn'              => new sfValidatorString(),
      'ip'                    => new sfValidatorIpAddress(),
      'status'                => new sfValidatorBoolean(),
  
      'zarafaAccount'         => new sfValidatorBoolean(),
      'zarafaQuotaHard'       => new sfValidatorInteger(),
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

