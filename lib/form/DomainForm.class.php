<?php
class DomainForm extends MinivISPForm
{
  public function configure()
  {
    $status = array('enable' => 'enable', 'disable' => 'disable');
    $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');

    $this->setWidgets(array(
      'platformDn' => new sfWidgetFormInputHidden(),
      'companyDn' => new sfWidgetFormInputHidden(),
      'cn' => new sfWidgetFormInput(),
      'status' => new sfWidgetFormSelect( array('choices' => $status) ),
      'undeletable' => new sfWidgetFormSelect( array('choices' => $undeletable) ),
    ));

    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
    $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );

    $this->widgetSchema->setLabels(array(
      'cn' => 'Name',
      'status' => 'Status',
      'undeletable' => 'Undeletable',
    ));

    $this->setValidators(array(
      'platformDn' => new sfValidatorString(),
      'companyDn' => new sfValidatorString(),
      'cn' => new sfValidatorString(),
      'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
      'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
    ));
  }
}

