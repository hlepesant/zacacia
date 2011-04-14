<?php
class PlatformForm extends MinivISPForm
{
  public function configure()
  {
    $status = array('enable' => 'enable', 'disable' => 'disable');
    $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');

    $this->setWidgets(array(
      'cn' => new sfWidgetFormInput(array(), array('pattern' => '[a-zA-Z ]{5,}', 'maxlength' => 30, 'required' => 'required')),
      'status' => new sfWidgetFormSelect(array('choices' => $status)),
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
      'cn' => new sfValidatorString(),
      'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
      'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
    ));
  }
}

