<?php
class UserAliasesForm extends ZacaciaForm
{
  public function configure()
  {
    $this->setWidgets(array(
      'platformDn'          => new sfWidgetFormInputHidden(),
      'companyDn'           => new sfWidgetFormInputHidden(),
      'userDn'              => new sfWidgetFormInputHidden(),
      'zarafaAliases'       => new sfWidgetFormInputText(array('multiple' => 'true')),
    ));
        
    $this->widgetSchema->setLabels(array(
      'zarafaAliases[]'      => ' ',
    ));

    $this->setValidators(array(
      'platformDn'          => new sfValidatorString(),
      'companyDn'           => new sfValidatorString(),
      'userDn'              => new sfValidatorString(),
      'zarafaAliases'       => new sfValidatorEmail(),
    ));
    
    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
    $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
  }
}

