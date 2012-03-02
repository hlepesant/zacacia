<?php
class platformSelectForm extends zacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'selectedPlatform' => new sfWidgetFormSelect(array(
                'choices' => array('none' => 'Select the platform'), 
                'default' => 'none'
        ))));

        $this->widgetSchema->setLabels(array(
            'selectedPlatform' => 'Plateform',
        ));
    
        $this->setValidators(array(
            'selectedPlatform' => new sfValidatorString(),
        ));

        #$this->widgetSchema->setNameFormat('nav[%%s]');
        $this->widgetSchema->setFormFormatterName('grid');
    }
}

