<?php
class PlatformNavigationForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
#            'platformDn' => new sfWidgetFormInputHidden(),
        ));
    
        $this->setValidators(array(
#            'platformDn' => new sfValidatorString(),
        ));
    }
}

