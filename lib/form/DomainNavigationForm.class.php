<?php
class DomainNavigationForm extends MinivISPForm
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
      'companyDn' => new sfWidgetFormInputHidden(),
      'domainDn' => new sfWidgetFormInputHidden(),
      'destination' => new sfWidgetFormSelect(array('choices' => $miniAction)),
    ));

    $this->setValidators(array(
      'platformDn' => new sfValidatorString(),
      'companyDn' => new sfValidatorString(),
      'domainDn' => new sfValidatorString(),
      'destination' => new sfValidatorChoice(array('choices' => array_keys($miniAction))),
    ));
  }
}

