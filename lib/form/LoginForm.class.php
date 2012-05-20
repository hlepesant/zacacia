<?php
class LoginForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'username'  => new sfWidgetFormInput(),
            'password'  => new sfWidgetFormInputPassword(),
        ));
    
        $this->widgetSchema->setLabels(array(
            'username'  => 'Username',
            'password'  => 'Password',
        ));
    
        $this->setValidators(array(
            'username'  => new sfValidatorString(),
            'password'  => new sfValidatorString(),
        ));

        // $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

