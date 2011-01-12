<?php
class PlatformNavigationForm extends MinivISPForm
{
  public function configure()
  {
    $miniAction = array(
      'none'    => '',
      'edit'    => parent::__('Edit'),
      'status'  => parent::__('Enable'),
    );

    $this->setWidgets(array(
      'platformDn' => new sfWidgetFormInputHidden(),
      'destination' => new sfWidgetFormSelect(array('choices' => $miniAction)),
    ));

    $this->setValidators(array(
      'platformDn' => new sfValidatorString(),
      'destination' => new sfValidatorChoice(array('choices' => array_keys($miniAction))),
    ));
  }
}

