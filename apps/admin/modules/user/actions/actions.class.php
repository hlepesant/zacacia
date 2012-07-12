<?php

/**
 * user actions.
 *
 * @package    MinivISP
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
    /*
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
          
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
              sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
              echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
              exit;
        }
        
        $ldapPeer = new UserPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        $this->users = $ldapPeer->getUsers($companyDn);

        
        $id=0;
        $this->forms = array();
        foreach ($this->users as $user) {

            $form = new UserNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('userDn')->setDefault($user->getDn());
            
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('userDn')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$user->getDn()] = $form;
            $id++;
        }
        
        $this->new = new UserNavigationForm();
        unset($this->new['userDn']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
        $this->new->getWidget('companyDn')->setDefault($companyDn);

/* zacaciaPlatform */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

/* zacaciaCompany */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaCompany');
        $l = new CompanyPeer();
        $l->setBaseDn($companyDn);
        $this->company = $l->retrieveByDn($c);
    }

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
            exit;
        }

/* zacaciaPlatform */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

/* zacaciaCompany */
        $c2 = new LDAPCriteria();
        $c2->add('objectClass', 'top');
        $c2->add('objectClass', 'organizationalRole');
        $c2->add('objectClass', 'zacaciaCompany');
        $l2 = new CompanyPeer();
        $l2->setBaseDn($companyDn);
        $this->company = $l2->retrieveByDn($c2, 'extended');
    
        $this->form = new UserForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

                #print_r( $this->form->getValues()); exit;

                $l = new UserPeer();
                $l->setBaseDn(sprintf("ou=Users,%s", $companyDn));

                $user = new UserObject();
                $user->setDn(sprintf("cn=%s %s,%s", $this->form->getValue('sn'), $this->form->getValue('givenName'), $l->getBaseDn()));
                $user->setGivenName($this->form->getValue('givenName'));
                $user->setSn($this->form->getValue('sn'));
                $user->setDisplayName($this->form->getValue('displayName'));

                $fi = strToLower($this->form->getValue('sn'));
                $la = strToLower($this->form->getValue('givenName'));

                $user->setUid(sprintf('%s%s', $fi[0], $la));
                $user->setUserPassword($this->form->getValue('userPassword'));
                $user->setUidNumber($l->getNewUidNumber());
                $user->setGidNumber($this->company->getGidNumber());

                $user->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));

/*
                if ( $this->form->getValue('zarafaQuotaOverride') ) {
                    $user->setZarafaQuotaOverride(1);
                    $user->setZarafaQuotaWarn($this->form->getValue('zarafaQuotaWarn'));
                }

                if ( $this->form->getValue('zarafaUserDefaultQuotaOverride') ) {
                    $user->setZarafaUserDefaultQuotaOverride(1);
                    $user->setZarafaUserDefaultQuotaHard($this->form->getValue('zarafaUserDefaultQuotaHard'));
                    $user->setZarafaUserDefaultQuotaSoft($this->form->getValue('zarafaUserDefaultQuotaSoft'));
                    $user->setZarafaUserDefaultQuotaWarn($this->form->getValue('zarafaUserDefaultQuotaWarn'));
                }
                var_dump( $user ); exit;
*/

                if ( $l->doAdd($user) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

/* zacaciaDomain */          
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaDomain');
        
        $l = new DomainPeer();
        $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
        
        $domains = $l->doSelect($c);
        $domainWidgetChoice = array();
        foreach ( $domains as $domain ) {
            $domainWidgetChoice[ $domain->getCn() ] = $domain->getCn();
        }
        $this->form->getWidget('domain')->setOption('choices', $domainWidgetChoice);
/*        $this->form->getWidget('domain')->setDefault(); */

/* zacaciaCompany */

        
        $this->cancel = new UserNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));

    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        }

        $userDn = $request->getParameter('userDn');
        if ( empty($userDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing user's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@user', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($userDn);

        $l = new UserPeer();
        $user = $l->retrieveByDn($criteria);

        if ( 'enable' === $user->getZacaciaStatus()) {
            $user->setZacaciaStatus(false);
        } else {
            $user->setZacaciaStatus(true);
        }

        $l->doSave($user);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@user', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        }

        $userDn = $request->getParameter('userDn');
        if ( empty($userDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing user's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@user', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($userDn);

        $l = new UserPeer();
        $user = $l->retrieveByDn($criteria);

        if ( 'disable' === $user->getZacaciaStatus()) {
            $l->doDelete($user, true);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@user', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
            exit;
        }

        $userDn = $request->getParameter('userDn', $data['userDn']);
        if ( empty($userDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn, 'companyDn' => $companyDn));
            exit;
        }

/* zacaciaPlatform */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

/* zacaciaCompany */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaCompany');
        $l = new CompanyPeer();
        $l->setBaseDn($companyDn);
        $this->company = $l->retrieveByDn($c);

/* zacaciaUser */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $l = new UserPeer();
        $l->setBaseDn($userDn);
        $this->zuser = $l->retrieveByDn($c);

#        print_r( $this->zuser ); exit;

        $this->form = new UserEditForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('userDn')->setDefault($userDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

#            print_r( $_POST['zdata'] ); exit;
#            print_r( $this->form->getValues() ); exit;
            
            if ($this->form->isValid()) {

                $this->zuser->setGivenName($this->form->getValue('givenName'));
                $this->zuser->setSn($this->form->getValue('sn'));
                $this->zuser->setDisplayName($this->form->getValue('displayName'));
                $this->zuser->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));

#                var_dump( $this->zuser ); exit;

                if ( $l->doSave($this->zuser) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

/* zacaciaDomain */          
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaDomain');
        
        $l = new DomainPeer();
        $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
        
        $domains = $l->doSelect($c);
        $domainWidgetChoice = array();
        foreach ( $domains as $domain ) {
            $domainWidgetChoice[ $domain->getCn() ] = $domain->getCn();
        }
        $this->form->getWidget('domain')->setOption('choices', $domainWidgetChoice);
        list($mail, $domain) = preg_split('/@/', $this->zuser->getMail(), 2);
        $this->form->getWidget('domain')->setDefault($domain);

        $this->form->getWidget('sn')->setDefault($this->zuser->getSn());
        $this->form->getWidget('givenName')->setDefault($this->zuser->getGivenName());
        $this->form->getWidget('displayName')->setDefault($this->zuser->getDisplayName());
        $this->form->getWidget('zarafaAccount')->setDefault($this->zuser->getZarafaAccount());
        $this->form->getWidget('zarafaAdmin')->setDefault($this->zuser->getZarafaAdmin());
        $this->form->getWidget('zarafaHidden')->setDefault($this->zuser->getZarafaHidden());
        $this->form->getWidget('mail')->setDefault($mail);
        $this->form->getWidget('domain')->setDefault($domain);
        
        $this->cancel = new UserNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));

    }

    public function executePassword(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
            exit;
        }

        $userDn = $request->getParameter('userDn', $data['userDn']);
        if ( empty($userDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn, 'companyDn' => $companyDn));
            exit;
        }

/* zacaciaPlatform */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

/* zacaciaCompany */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaCompany');
        $l = new CompanyPeer();
        $l->setBaseDn($companyDn);
        $this->company = $l->retrieveByDn($c);

/* zacaciaUser */
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $l = new UserPeer();
        $l->setBaseDn($userDn);
        $this->zuser = $l->retrieveByDn($c);

        $this->form = new UserPasswordForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('userDn')->setDefault($userDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

#            print_r( $_POST['zdata'] ); exit;
#            print_r( $this->form->getValues() ); exit;
            
            if ($this->form->isValid()) {

                $this->zuser->setUserPassword($this->form->getValue('userPassword'));

#                var_dump( $this->zuser ); exit;

                if ( $l->doSave($this->zuser) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

#        $this->form->getWidget('sn')->setDefault($this->zuser->getSn());
#        $this->form->getWidget('givenName')->setDefault($this->zuser->getGivenName());
#        $this->form->getWidget('displayName')->setDefault($this->zuser->getDisplayName());
#        $this->form->getWidget('zarafaAccount')->setDefault($this->zuser->getZarafaAccount());
#        $this->form->getWidget('zarafaAdmin')->setDefault($this->zuser->getZarafaAdmin());
#        $this->form->getWidget('zarafaHidden')->setDefault($this->zuser->getZarafaHidden());
#        //$this->form->getWidget('status')->setDefault('true');
#        //$this->form->getWidget('firstname')->setDefault($this->zuser->get());
#        //$this->form->getWidget('firstname')->setDefault($this->zuser->get());
#        $this->form->getWidget('mail')->setDefault($mail);
#        $this->form->getWidget('domain')->setDefault($domain);
        
        $this->cancel = new UserNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));

    }

/* WebServices */
    public function executeCheckcn(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        if ( ! $request->hasParameter('companyDn') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('name') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new UserPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sprintf("ou=Users,%s", $request->getParameter('companyDn')) );
        
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $c->add('cn', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);

        return sfView::SUCCESS;
    }

    public function executeCheckuid(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        if ( ! $request->hasParameter('name') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new UserPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sfConfig::get('ldap_base_dn') );
        
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $c->add('uid', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }

    public function executeCheckemail(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        if ( ! $request->hasParameter('email') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new LdapPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sfConfig::get('ldap_base_dn') );
        
#        $c->add('objectClass', 'top');
#        $c->add('objectClass', 'inetOrgPerson');
#        $c->add('objectClass', 'posixAccount');
#        $c->add('objectClass', 'zarafa-user');
#        $c->add('objectClass', 'zacaciaUser');
        $c->addOr('mail', $request->getParameter('email'));
        $c->addOr('mailAlternateAddress', $request->getParameter('email'));
        $c->add('objectClass', 'top');
       
        if ( $l->doCount($c) == 0 ) {
            $this->count = 0;
        };
        
        return sfView::SUCCESS;
    }
}
