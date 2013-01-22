<?php
class GroupNavigationForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'groupDn'       => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'groupDn'       => new sfValidatorString(),
        ));
    }
}
