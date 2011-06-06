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
          
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        
        $l = new UserPeer();
        $l->setBaseDn(sprintf("ou=Users,%s", $companyDn));
        
        $this->users = $l->doSelect($c, 'extended');
        
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
    
        $this->form = new UserForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

                $l = new UserPeer();
                $l->setBaseDn(sprintf("ou=Users,%s", $companyDn));

                $user = new UserObject();
                $user->setDn(sprintf("cn=%s %s,%s", $this->form->getValue('sn'), $this->form->getValue('givenName'), $l->getBaseDn()));
                $user->setGivenName($this->form->getValue('givenName'));
                $user->setSn($this->form->getValue('sn'));

                $fi = strToLower($this->form->getValue('sn'));
                $la = strToLower($this->form->getValue('givenName'));

                $user->setUid(sprintf('%s%s', $fi[0], $la));
                $user->setUidNumber($l->getNewUidNumber());
                $user->setGidNumber(100001);

/*
                if ( $this->form->getValue('status') ) {
                    $user->setZacaciaStatus('enable');
                } else {
                    $user->setZacaciaStatus('disable');
                }

                $user->setZacaciaStatus($this->form->getValue('status'));

                if ( $this->form->getValue('undeletable') ) {
                    $user->setZacaciaUnDeletable(1);
                }

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
*/
                var_dump( $user ); exit;

                if ( $l->doAdd($user) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'user/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }

                }
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
        $this->company = $l2->retrieveByDn($c2);
        
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

/* WebServices */
    public function executeCheckUid(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        if ( ! $request->hasParameter('companyDn') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('uid') ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new UserPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sprintf("ou=Users,%s", $request->getParameter('companyDn')) );
        print( $c->getBaseDn() ); exit;
        
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'zacaciaUser');
        $c->add('uid', $request->getParameter('uid'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
}
