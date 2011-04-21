<?php
class CompanyNavigationForm extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'companyDn' => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'companyDn' => new sfValidatorString(),
        ));
    }
}

