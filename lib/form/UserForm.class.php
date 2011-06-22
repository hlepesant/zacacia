<?php
class UserForm extends ZacaciaForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'companyDn' => new sfWidgetFormInputHidden(),
            #'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
            #'undeletable'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),

# ObjectClasse: inetOrgPerson
            'givenName' => new sfWidgetFormInput(),
            'sn' => new sfWidgetFormInput(),
            'cn' => new sfWidgetFormInputHidden(),
            'displayName' => new sfWidgetFormInput(),
# ObjectClasse: posixAccount
            'userPassword' => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
            'confirmPassword' => new sfWidgetFormInputPassword(array(), array('autocomplete' => 'off')),
            'uid' => new sfWidgetFormInput(),
# ObjectClasse: zarafa-user
#            'zarafaAccount'         => new sfWidgetFormInputHidden(array('default' => 1)),
#            'zarafaAdmin'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
#            'zarafaHidden' => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
#            'zarafaQuotaOverride'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),
#            'zarafaQuotaWarn'       => new sfWidgetFormInput(array(), array(
#                    'type' => 'number',
#                    'size' => '5',
#                    'min' => 25,
#                    'max' => 2048,
#                    'maxlength' => '4', 
#                    'data-message' => 'Enter a value between 25 and 2048',)),
#            'zarafaQuotaSoft'       => new sfWidgetFormInput(array(), array(
#                    'type' => 'number',
#                    'size' => '5',
#                    'min' => 25,
#                    'max' => 2048,
#                    'maxlength' => '4', 
#                    'data-message' => 'Enter a value between 25 and 2048',)),
#            'zarafaQuotaHard'       => new sfWidgetFormInput(array(), array(
#                    'type' => 'number',
#                    'size' => '5',
#                    'min' => 25,
#                    'max' => 2048,
#                    'maxlength' => '4', 
#                    'data-message' => 'Enter a value between 25 and 2048',)),
#            'zarafaUserServer' => new sfWidgetFormSelect(array('choices' => array())),

        ));
        
        $this->widgetSchema->setLabels(array(
            #'status'        => 'Enable',
            #'undeletable'   => 'Undeletable',
            'givenName'     => 'Lastname',
            'sn'            => 'Firstname',
            'displayName'   => 'Display Name',
            'userPassword'  => 'Password',
            'uid'           => 'Username',
        ));

        $this->setValidators(array(
            'platformDn'        => new sfValidatorString(),
            'companyDn'         => new sfValidatorString(),
            #'status'            => new sfValidatorBoolean(),
            #'undeletable'       => new sfValidatorBoolean(),
            'givenName'         => new sfValidatorString(),
            'sn'                => new sfValidatorString(),
            'cn'                => new sfValidatorString(),
            'displayName'       => new sfValidatorString(),
            'userPassword'      => new sfValidatorString(),
            'confirmPassword'   => new sfValidatorString(),
            'uid'               => new sfValidatorString(),
        ));

        $this->validatorSchema->setPostValidator(
            new sfValidatorSchemaCompare('userPassword', sfValidatorSchemaCompare::EQUAL, 'confirmPassword')
        );
        
        $this->widgetSchema->setNameFormat(sprintf('%s[%%s]', sfConfig::get('widgetNameFormat')));
        $this->widgetSchema->setFormFormatterName( sfConfig::get('widgetFormaterName') );
    }

/* WebServices */
/*
    public function executeCheck(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;
        
        $pattern = sfConfig::get('company_pattern');
        if ( ! preg_match($pattern, $request->getParameter('name') ) )
        {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new CompanyPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')) );
        
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-company');
        $c->add('objectClass', 'zacaciaCompany');
        $c->add('cn', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
*/
}

