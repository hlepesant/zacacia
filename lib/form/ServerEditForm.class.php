<?php
class ServerEditForm extends MinivISPForm
{
  public function configure()
  {
    $status = array('enable' => 'enable', 'disable' => 'disable');
    $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');
    $public_folder_option = array( 0 => 'no', 1 => 'yes');

    $this->setWidgets(array(
      'platformDn' => new sfWidgetFormInputHidden(),
      'serverDn' => new sfWidgetFormInputHidden(),
#      'cn' => new sfWidgetFormInput(),
      'ip' => new sfWidgetFormInput(),
      'zarafaHttpPort' => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
      'zarafaSslPort' => new sfWidgetFormInput(array(), array('class' => 'small-60', 'maxlength' => '6')),
      'zarafaContainsPublic' => new sfWidgetFormSelect( array('choices' => $public_folder_option) ),
      'status' => new sfWidgetFormSelect( array('choices' => $status) ),
      'undeletable' => new sfWidgetFormSelect( array('choices' => $undeletable) ),
    ));

    $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
    $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );

    $this->widgetSchema->setLabels(array(
#      'cn' => 'Name',
      'ip' => 'IP Address',
      'zarafaHttpPort' => 'Port for the http connection',
      'zarafaSslPort' => 'Port for the ssl connection',
      'zarafaContainsPublic' => 'Contains Public Store',
      'status' => 'Status',
      'undeletable' => 'Undeletable',
    ));

    $this->setValidators(array(
      'platformDn' => new sfValidatorString(),
      'serverDn' => new sfValidatorString(),
#      'cn' => new sfValidatorString(),
      'ip' => new sfValidatorIpAddress(),
      'zarafaHttpPort' => new sfValidatorInteger(),
      'zarafaSslPort' => new sfValidatorInteger(),
      'zarafaContainsPublic' => new sfValidatorChoice(array('choices' => array_keys($public_folder_option))),
      'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
      'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
    ));
  }
}

