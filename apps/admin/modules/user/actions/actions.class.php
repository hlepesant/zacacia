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
    }

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@companies', Array('holdingDn' => $holdingDn));
            exit;
        }
        
        $ldapPeer = new UserPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);

        $this->form = new UserForm();

        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

//                print_r( $_POST );

                $ldapPeer->setBaseDn(sprintf("ou=Users,%s", $companyDn));

                $userAccount = new UserObject();
                $userAccount->setCn(sprintf("%s %s", $this->form->getValue('sn'), $this->form->getValue('givenName')));
                $userAccount->setDn(sprintf("cn=%s,%s", $userAccount->getCn(), $ldapPeer->getBaseDn()));
                $userAccount->setGivenName($this->form->getValue('givenName'));
                $userAccount->setSn($this->form->getValue('sn'));
                $userAccount->setDisplayName($this->form->getValue('displayName'));

/*
                $fi = strToLower($this->form->getValue('sn'));
                $la = strToLower($this->form->getValue('givenName'));
                $user->setUid(sprintf('%s%s', $fi[0], $la));
*/
                $userAccount->setUid($this->form->getValue('uid'));
                $userAccount->setUserPassword($this->form->getValue('userPassword'));
                $userAccount->setUidNumber($ldapPeer->getNewUidNumber());
                $userAccount->setGidNumber($this->company->getGidNumber());

                $userAccount->setZarafaAccount($this->form->getValue('zarafaAccount'));
                $userAccount->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));

                if ( $this->form->getValue('zarafaQuotaOverride') == 1 ) {
                    $userAccount->setZarafaQuotaOverride(1);
                    $userAccount->setZarafaQuotaHard($this->form->getValue('zarafaQuotaHard'));
                    $userAccount->setZarafaQuotaSoft($this->form->getValue('zarafaQuotaSoft'));
                    $userAccount->setZarafaQuotaWarn($this->form->getValue('zarafaQuotaWarn'));
                }

//                var_dump( $user ); exit;

                if ( $ldapPeer->doAdd($userAccount) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

        $this->form->getWidget('domain')->setOption('choices', $ldapPeer->getDomainsAsOption($companyDn));

        $this->cancel = new UserNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
        $this->cancel->getWidget('companyDn')->setDefault($companyDn);
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@companies', Array('holdingDn' => $holdingDn));
            exit;
        }

        $userDn = $request->getParameter('userDn', $data['userDn']);
        if ( empty($userDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@users', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
            exit;
        }

        $ldapPeer = new UserPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        $this->userAccount = $ldapPeer->getUser($userDn);

        $this->form = new UserEditForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('userDn')->setDefault($userDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

#            print_r( $this->form->getValues() ); exit;

                $this->userAccount->setGivenName($this->form->getValue('givenName'));
                $this->userAccount->setSn($this->form->getValue('sn'));
                $this->userAccount->setDisplayName($this->form->getValue('displayName'));
                $this->userAccount->setZarafaAccount($this->form->getValue('zarafaAccount'));

                $this->userAccount->setZarafaAdmin($this->form->getValue('zarafaAdmin'));

                if ( $this->form->getValue('zarafaQuotaOverride') == 1 ) {
                    $this->userAccount->setZarafaQuotaOverride(1);
                    $this->userAccount->setZarafaQuotaHard($this->form->getValue('zarafaQuotaHard'));
                    $this->userAccount->setZarafaQuotaSoft($this->form->getValue('zarafaQuotaSoft'));
                    $this->userAccount->setZarafaQuotaWarn($this->form->getValue('zarafaQuotaWarn'));
                } else {
                    $this->userAccount->setZarafaQuotaOverride(0);
                    $this->userAccount->setZarafaQuotaHard(null);
                    $this->userAccount->setZarafaQuotaSoft(null);
                    $this->userAccount->setZarafaQuotaWarn(null);
                }

                $this->userAccount->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));

#                var_dump( $this->userAccount ); exit;

                if ( $ldapPeer->doSave($this->userAccount) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

        $this->form->getWidget('domain')->setOption('choices', $ldapPeer->getDomainsAsOption($companyDn));

        $this->form->getWidget('sn')->setDefault($this->userAccount->getSn());
        $this->form->getWidget('givenName')->setDefault($this->userAccount->getGivenName());
        $this->form->getWidget('displayName')->setDefault($this->userAccount->getDisplayName());
        $this->form->getWidget('zarafaAccount')->setDefault($this->userAccount->getZarafaAccount());

        $this->showZarafaSetting = 'none';
        $this->showZarafaQuotaSetting = 'none';

        if ( $this->userAccount->getZarafaAccount() == 1) {
            $this->showZarafaSetting = 'visible';
            $this->form->getWidget('zarafaAccount')->setDefault(1);

            $this->form->getWidget('zarafaAdmin')->setDefault($this->userAccount->getZarafaAdmin());
            $this->form->getWidget('zarafaHidden')->setDefault($this->userAccount->getZarafaHidden());

            $this->form->getWidget('emailAddress')->setDefault($this->userAccount->getMail());
            list($mail, $domain) = preg_split('/@/', $this->userAccount->getMail(), 2);
            $this->form->getWidget('mail')->setDefault($mail);
            $this->form->getWidget('domain')->setDefault($domain);

            if ( $this->userAccount->getZarafaQuotaOverride() == 1) {
                $this->showZarafaQuotaSetting = 'visible';
                $this->form->getWidget('zarafaQuotaOverride')->setDefault(1);
                $this->form->getWidget('zarafaQuotaHard')->setDefault($this->userAccount->getZarafaQuotaHard());
                $this->form->getWidget('zarafaQuotaSoft')->setDefault($this->userAccount->getZarafaQuotaSoft());
                $this->form->getWidget('zarafaQuotaWarn')->setDefault($this->userAccount->getZarafaQuotaWarn());
            }
        }

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
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
            exit;
        }

        $userDn = $request->getParameter('userDn', $data['userDn']);
        if ( empty($userDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
            exit;
        }

        $ldapPeer = new UserPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        $this->userInfo = $ldapPeer->getUser($userDn);

        $this->form = new UserPasswordForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('userDn')->setDefault($userDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $this->userInfo->setUserPassword($this->form->getValue('userPassword'));

                if ( $ldapPeer->doSave($this->userInfo) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

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
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }

        $userDn = $request->getParameter('userDn');
        if ( empty($userDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing user's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@users', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($userDn);

        $l = new UserPeer();
        $user = $l->retrieveByDn($criteria);

        if ( 'enable' === $user->getZacaciaStatus()) {
            $user->setZacaciaStatus('disable');
        } else {
            $user->setZacaciaStatus('enable');
        }

        $l->doSave($user);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@users', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }

        $userDn = $request->getParameter('userDn');
        if ( empty($userDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing user's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@users', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($userDn);

        $l = new UserPeer();
        $user = $l->retrieveByDn($criteria);

        if ( 'disable' === $user->getZacaciaStatus()) {
            $l->doDelete($user, true);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@users', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

/* WebServices */
    public function executeCheckcn(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->exist = 0;

        if ( ! $request->hasParameter('companyDn') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('name') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new UserPeer();
        $this->exist = $ldapPeer->doCheckCn($request->getParameter('companyDn'), $request->getParameter('name'));

        return sfView::SUCCESS;
    }

    public function executeCheckuid(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->exist = 0;

        if ( ! $request->hasParameter('name') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new UserPeer();
        $this->exist = $ldapPeer->doCheckUid($request->getParameter('name'));

        return sfView::SUCCESS;
    }

    public function executeCheckemail(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->exist = 0;

        if ( ! $request->hasParameter('email') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new UserPeer();
        $this->exist = $ldapPeer->doCheckEmailAddress($request->getParameter('email'));

        return sfView::SUCCESS;
    }

    public function executeCheckemailforupdate(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->exist = 0;

        if ( ! $request->hasParameter('email') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('dn') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new UserPeer();
        $this->exist = $ldapPeer->doCheckEmailAddressForUpdate($request->getParameter('dn'), $request->getParameter('email'));

        return sfView::SUCCESS;
    }
}
