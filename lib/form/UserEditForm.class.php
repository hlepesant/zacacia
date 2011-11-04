<?php
class UserEditForm extends ZacaciaForm
{
  protected static $quotas = array();

  public function configure()
  {
    self::$quotas = sfConfig::get('options_user_quota_hard');

    $this->setWidgets(array(
      'platformDn'          => new sfWidgetFormInputHidden(),
      'companyDn'           => new sfWidgetFormInputHidden(),
      'userDn'              => new sfWidgetFormInputHidden(),
#     'status'              => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
# ObjectClasse: inetOrgPerson
      'givenName'           => new sfWidgetFormInput(),
      'sn'                  => new sfWidgetFormInput(),
      'displayName'         => new sfWidgetFormInput(),
      'mail'                => new sfWidgetFormInput(),
      'domain'              => new sfWidgetFormSelect(array('choices' => array())),
## ObjectClasse: zarafa-user
      'zarafaAccount'       => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaAdmin'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaHidden'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaQuotaOverride' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaQuotaHard'     => new sfWidgetFormSelect(array('choices' => self::$quotas)),
#     'zarafaUserServer' => new sfWidgetFormSelect(array('choices' => array())),
    ));
        
    $this->widgetSchema->setLabels(array(
#     'status'              => 'Enable',
      'givenName'           => 'Lastname',
      'sn'                  => 'Firstname',
      'displayName'         => 'Display Name',
      'mail'                => 'Email',
      
#      'zarafaAccount'       => 'Zarafa Account',
      'zarafaAdmin'         => 'Zarafa Admin',
      'zarafaHidden'        => 'Hidden',
      'zarafaQuotaOverride' => 'Override Quotas',
#      'zarafaQuotaWarn'     => 'Warning Quota',
#      'zarafaQuotaSoft'     => 'Soft Quota',
      'zarafaQuotaHard'     => 'Hard Quota',
#     'zarafaUserServer' => new sfWidgetFormSelect(array('choices' => array())),
    ));

    $this->setValidators(array(
      'platformDn'          => new sfValidatorString(),
      'companyDn'           => new sfValidatorString(),
      'userDn'           => new sfValidatorString(),
#     'status'              => new sfValidatorBoolean(),
      'givenName'           => new sfValidatorString(),
      'sn'                  => new sfValidatorString(),
#      'cn'                  => new sfValidatorString(),
      'displayName'         => new sfValidatorString(),
#      'uid'                 => new sfValidatorString(),
      'mail'                => new sfValidatorString(),
      'domain'              => new sfValidatorString(),
      
      'zarafaAccount'       => new sfValidatorBoolean(),
      'zarafaAdmin'         => new sfValidatorBoolean(),
      'zarafaHidden'        => new sfValidatorBoolean(),
      'zarafaQuotaOverride' => new sfValidatorBoolean(),
#      'zarafaQuotaWarn'     => new sfValidatorInteger(),
#      'zarafaQuotaSoft'     => new sfValidatorInteger(),
      'zarafaQuotaHard'     => new sfValidatorInteger(),
#     'zarafaUserServer'    => new sfWidgetFormSelect(array('choices' => array())),
    ));
    
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare('userPassword', sfValidatorSchemaCompare::EQUAL, 'confirmPassword')
    );
    
    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
    $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    
#    $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
##      new sfValidatorSchemaCompare('zarafaQuotaOverride', sfValidatorSchemaCompare::EQUAL, true),
##      new sfValidatorSchemaCompare('zarafaQuotaWarn', sfValidatorSchemaCompare::LESS_THAN, 'zarafaQuotaSoft'),
##      new sfValidatorSchemaCompare('zarafaQuotaSoft', sfValidatorSchemaCompare::LESS_THAN, 'zarafaQuotaHard')
#    )));
  }
}

