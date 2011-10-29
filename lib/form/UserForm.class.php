<?php
class UserForm extends ZacaciaForm
{
  protected static $quotas = array();

  public function configure()
  {
    self::$quotas = sfConfig::get('options_user_quota_hard');

    $this->setWidgets(array(
      'platformDn'          => new sfWidgetFormInputHidden(),
      'companyDn'           => new sfWidgetFormInputHidden(),
#     'status'              => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
# ObjectClasse: inetOrgPerson
      'givenName'           => new sfWidgetFormInput(),
      'sn'                  => new sfWidgetFormInput(),
      'cn'                  => new sfWidgetFormInputHidden(),
      'displayName'         => new sfWidgetFormInput(),
      'mail'                => new sfWidgetFormInput(),
      'domain'              => new sfWidgetFormSelect(array('choices' => array())),
# ObjectClasse: posixAccount
      'userPassword'        => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
      'confirmPassword'     => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
      'uid'                 => new sfWidgetFormInput(),
# ObjectClasse: zarafa-user
      'zarafaAccount'       => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaAdmin'         => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaHidden'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      'zarafaQuotaOverride' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
      /*
      'zarafaQuotaWarn'     => new sfWidgetFormInput(array(), 
      array(
        'type' => 'number', 'size' => '5', 'min' => 25,
        'max' => 2048, 'maxlength' => '4', 'data-message' => 'Enter a value between 25 and 2048'
      )),
      */
      /*
      'zarafaQuotaSoft'     => new sfWidgetFormInput(array(),
      array(
        'type' => 'number', 'size' => '5', 'min' => 25,
        'max' => 2048, 'maxlength' => '4', 'data-message' => 'Enter a value between 25 and 2048'
      )),
      */
      'zarafaQuotaHard'     => new sfWidgetFormSelect(array('choices' => self::$quotas)),
      /*
      'zarafaQuotaHard'     => new sfWidgetFormInput(array(),
      array(
        'type' => 'number', 'size' => '5', 'min' => 25,
        'max' => 2048, 'maxlength' => '4', 'data-message' => 'Enter a value between 25 and 2048'
      )),
      */
#     'zarafaUserServer' => new sfWidgetFormSelect(array('choices' => array())),
    ));
        
    $this->widgetSchema->setLabels(array(
#     'status'              => 'Enable',
      'givenName'           => 'Lastname',
      'sn'                  => 'Firstname',
      'displayName'         => 'Display Name',
      'userPassword'        => 'Password',
      'uid'                 => 'Username',
      'mail'                => 'Email',
      
      'zarafaAccount'       => 'Zarafa Account',
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
#     'status'              => new sfValidatorBoolean(),
      'givenName'           => new sfValidatorString(),
      'sn'                  => new sfValidatorString(),
      'cn'                  => new sfValidatorString(),
      'displayName'         => new sfValidatorString(),
      'userPassword'        => new sfValidatorString(),
      'confirmPassword'     => new sfValidatorString(),
      'uid'                 => new sfValidatorString(),
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

