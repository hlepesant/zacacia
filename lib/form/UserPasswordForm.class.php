<?php
class UserPasswordForm extends ZacaciaForm
{
  protected static $quotas = array();

  public function configure()
  {
    self::$quotas = sfConfig::get('options_user_quota_hard');

    $this->setWidgets(array(
      'platformDn'          => new sfWidgetFormInputHidden(),
      'companyDn'           => new sfWidgetFormInputHidden(),
      'userDn'              => new sfWidgetFormInputHidden(),
      'userPassword'        => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
      'confirmPassword'     => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
    ));
        
    $this->widgetSchema->setLabels(array(
      'userPassword'        => 'Password',
    ));

    $this->setValidators(array(
      'platformDn'          => new sfValidatorString(),
      'companyDn'           => new sfValidatorString(),
      'userDn'              => new sfValidatorString(),
      'userPassword'        => new sfValidatorString(),
      'confirmPassword'     => new sfValidatorString(),
    ));
    
    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
    $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare('userPassword', sfValidatorSchemaCompare::EQUAL, 'confirmPassword')
    );
  }
}

