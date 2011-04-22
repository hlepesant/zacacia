<?php
class UserNavigationForm extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'userDn'        => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'userDn'        => new sfValidatorString(),
        ));
    }
}

