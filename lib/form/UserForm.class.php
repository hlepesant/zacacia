<?php
class UserNew1Form extends ZacaciaForm
{
    public function configure()
    {
        $displayRender = array('fl' => 'First Last', 'lf' => 'Last First');

        $this->setWidgets(array(
            'platformDn' => new sfWidgetFormInputHidden(),
            'companyDn' => new sfWidgetFormInputHidden(),
            'status'        => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1, 'default' => 1)),
            'undeletable'   => new sfWidgetFormInputCheckbox(array('value_attribute_value' => 1)),

#            'cn' => new sfWidgetFormInput(),
            'displayRender' => new sfWidgetFormSelect(array('choices' => $displayRender), array('onChange' => 'updateDisplayName()')),
            'displayName' => new sfWidgetFormInput(),
            'givenName' => new sfWidgetFormInput(array(), array('onChange' => 'updateUsername()')),
            'sn' => new sfWidgetFormInput(array(), array('onChange' => 'updateUsername()')),
            'userPassword' => new sfWidgetFormInputPassword(),
            'confirmPassword' => new sfWidgetFormInputPassword(),
            'uid' => new sfWidgetFormInput(),
        ));
        
        $this->widgetSchema->setLabels(array(
            'status'        => 'Enable',
            'undeletable'   => 'Undeletable',
#            'cn' => 'Name',
            'displayName' => 'Display Name',
            'displayRender' => 'Display Name',
            'givenName' => 'Given Name',
            'sn' => 'Surname',
            'userPassword' => 'Password',
            'uid' => 'Username',
        ));

        $this->setValidators(array(
            'platformDn' => new sfValidatorString(),
            'companyDn' => new sfValidatorString(),
            'status'        => new sfValidatorBoolean(),
            'undeletable'   => new sfValidatorBoolean(),

#            'cn' => new sfValidatorString(),
            'displayName' => new sfValidatorString(),
            'displayRender' => new sfValidatorChoice(array('choices' => array_keys($displayRender))),
            'givenName' => new sfValidatorString(),
            'sn' => new sfValidatorString(),
            'userPassword' => new sfValidatorString(),
            'confirmPassword' => new sfValidatorString(),
            'uid' => new sfValidatorString(),
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

