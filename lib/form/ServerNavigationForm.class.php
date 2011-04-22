<?php
class ServerNavigationForm extends MinivISPForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'    => new sfWidgetFormInputHidden(),
            'serverDn'      => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
            'platformDn'    => new sfValidatorString(),
            'serverDn'      => new sfValidatorString(),
        ));
    }
}

