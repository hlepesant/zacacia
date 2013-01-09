<?php
class GroupForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn'            => new sfWidgetFormInputText(),
            'companyDn'             => new sfWidgetFormInputHidden(),
            'status'                => new sfWidgetFormChoice(array('choices' => self::$option_status)),
# ObjectClasse: groupOfNames
            'cn'                    => new sfWidgetFormInputHidden(),
            'member'                => new sfWidgetFormChoice(array('choices' => array())),
# ObjectClasse: zarafa-group
            'mail'                  => new sfWidgetFormInput(),
            'domain'                => new sfWidgetFormSelect(array('choices' => array())),
            'emailAddress'          => new sfWidgetFormInputHidden(),

            'zarafaAccount'         => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaAliases'         => new sfWidgetFormInput(),
            'zarafaHidden'          => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
            'zarafaSecurityGroup'   => new sfWidgetFormChoice(array('choices' => self::$option_noyes)),
        ));
        
        $this->widgetSchema->setLabels(array(
            'cn'                    => 'Name',
            'member'                => 'Members',
            'status'                => 'Enable',
            'mail'                  => 'Email',
            'zarafaAccount'         => 'Zarafa Account',
            'zarafaliases'          => 'Aliases',
            'zarafaHidden'          => 'Hidden',
            'zarafaSecurityGroup'   => 'Security Group',
        ));

        $this->setValidators(array(
            'platformDn'            => new sfValidatorString(),
            'companyDn'             => new sfValidatorString(),
            'status'                => new sfValidatorChoice(array('choices' => array_keys(self::$option_status))),
            'cn'                    => new sfValidatorString(),
            'member'                => new sfValidatorString(),
            'mail'                  => new sfValidatorString(),
            'domain'                => new sfValidatorString(),
            'emailAddress'          => new sfValidatorEmail(),
            'zarafaAccount'         => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
            'zarafaAliases'         => new sfValidatorString(),
            'zarafaHidden'          => new sfValidatorBoolean(),
            'zarafaSecurityGroup'   => new sfValidatorChoice(array('choices' => array_keys(self::$option_noyes))),
        ));
    
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }
}

