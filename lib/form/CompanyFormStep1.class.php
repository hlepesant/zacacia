<?php
class CompanyFormStep1 extends MinivISPForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');
        $public_folder_option = array( 0 => 'no', 1 => 'yes');

        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'cn' => new sfWidgetFormInput(),
            'status' => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable' => new sfWidgetFormSelect( array('choices' => $undeletable) ),
        ));

        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'cn' => new sfValidatorString(),
            'status' => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable' => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn' => 'Name',
            'status' => 'Status',
            'undeletable' => 'Undeletable',
        ));
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

