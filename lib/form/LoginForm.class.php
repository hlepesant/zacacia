<?php
class LoginForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'username'  => new sfWidgetFormInput(array(), array(
                'class' => 'input-block-level',
                'placeholder' => 'Username',
            )),
            'password'  => new sfWidgetFormInputPassword(array(), array(
                'class' => 'input-block-level',
                'placeholder' => 'Password',
            )),
        ));
    
        $this->widgetSchema->setLabels(array(
            'username'  => ' ',
            'password'  => ' ',
        ));
    
        $this->setValidators(array(
            'username'  => new sfValidatorString(),
            'password'  => new sfValidatorString(),
        ));

        $this->widgetSchema->setNameFormat('login[%s]');
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

