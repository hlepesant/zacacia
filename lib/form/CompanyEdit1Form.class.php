<?php
class CompanyEdit1Form extends ZacaciaForm
{
    public function configure()
    {
        $status = array('enable' => 'enable', 'disable' => 'disable');
        $undeletable = array('FALSE' => 'no', 'TRUE' => 'yes');

        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'status'        => new sfWidgetFormSelect( array('choices' => $status) ),
            'undeletable'   => new sfWidgetFormSelect( array('choices' => $undeletable) ),
        ));

        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'status'        => new sfValidatorChoice(array('choices' => array_keys($status))),
            'undeletable'   => new sfValidatorChoice(array('choices' => array_keys($undeletable))),
        ));
        
        $this->widgetSchema->setLabels(array(
            'status'        => 'Status',
            'undeletable'   => 'Undeletable',
        ));

        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}
