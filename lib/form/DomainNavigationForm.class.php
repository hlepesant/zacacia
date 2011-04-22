<?php
class DomainNavigationForm extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'companyDn'     => new sfWidgetFormInputHidden(),
            'domainDn'      => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'companyDn'     => new sfValidatorString(),
            'domainDn'      => new sfValidatorString(),
        ));
    }
}

