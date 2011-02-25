<?php
class UserNavigationForm extends MinivISPForm
{
  public function configure()
  {
    $miniAction = array(
      'none'    => '',
      'edit'    => parent::__('Edit'),
      'status'  => parent::__('Enable'),
      'alias'  => parent::__('Aliases'),
    );

    $this->setWidgets(array(
      'platformDn' => new sfWidgetFormInputHidden(),
      'companyDn' => new sfWidgetFormInputHidden(),
      'userDn' => new sfWidgetFormInputHidden(),
      'destination' => new sfWidgetFormSelect(array('choices' => $miniAction)),
    ));

    $this->setValidators(array(
      'platformDn' => new sfValidatorString(),
      'companyDn' => new sfValidatorString(),
      'userDn' => new sfValidatorString(),
      'destination' => new sfValidatorChoice(array('choices' => array_keys($miniAction))),
    ));
  }
}

