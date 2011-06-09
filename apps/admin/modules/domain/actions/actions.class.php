<?php

/**
 * domain actions.
 *
 * @package    Zacacia
 * @subpackage domain
 * @author     Hugues Lepesant
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class domainActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
          
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
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
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaCompany');
        $l = new CompanyPeer();
        $l->setBaseDn($companyDn);
        $this->company = $l->retrieveByDn($c);
          
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaDomain');
        
        $l = new DomainPeer();
        $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
        
        $this->domains = $l->doSelect($c, 'extended');
        
        $id=0;
        $this->forms = array();
        foreach ($this->domains as $domain)
        {
            $form = new DomainNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('domainDn')->setDefault($domain->getDn());
            
            $criteria_user = new LDAPCriteria();
            $criteria_user->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
            $criteria_user->add('objectClass', 'zarafa-user');
            $criteria_user->add('zarafaUserServer', $domain->getCn());
            $count_user = $l->doCount($criteria_user);
            
            $domain->set('user_count', $count_user);
        
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('domainDn')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$domain->getDn()] = $form;
            $id++;
        }
        
        $this->new = new DomainNavigationForm();
        unset($this->new['domainDn']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
        $this->new->getWidget('companyDn')->setDefault($companyDn);
    }

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
          $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
          $this->redirect('@platform');
        }
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
              sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
              echo fake_post($this, '@domain', Array('holdingDn' => $holdingDn, 'companyDn' => $companyDn));
              exit;
        }
    
        $this->form = new DomainForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {
            $this->form->bind($request->getParameter('zdata'));
            
                if ($this->form->isValid()) {
                    $l = new DomainPeer();
                    $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
                    
                    $domain = new DomainObject();
                    $domain->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $l->getBaseDn()));
                    $domain->setCn($this->form->getValue('cn'));
                    $domain->setZacaciaStatus($this->form->getValue('status'));
                    if ( $this->form->getValue('undeletable') ) {
                        $domain->setZacaciaUnDeletable(1);
                    }

                    if ( $l->doAdd($domain) ) {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                        echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                        exit;
                    }
                } else {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
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
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaCompany');
        $l = new CompanyPeer();
        $l->setBaseDn($companyDn);
        $this->company = $l->retrieveByDn($c);
        
        $this->cancel = new DomainNavigationForm();
        unset($this->cancel['domainDn']);
        $this->cancel->getWidget('platformDn')->setDefault($this->platform->getDn());
        $this->cancel->getWidget('companyDn')->setDefault($this->company->getDn());
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
            exit;
        }
          
        $domainDn = $request->getParameter('domainDn', $data['domainDn']);
        if ( empty($domainDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@company', Array('holdingDn' => $holdingDn, 'companyDn' => $companyDn));
            exit;
        }

        $l = new DomainPeer();
        $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
        
        $c = new LDAPCriteria();
        $c->setBaseDn($domainDn);

        $this->domain = $l->retrieveByDn($c);

        $this->form = new DomainEditForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
                if ($this->form->isValid()) {
                    #$this->domain->setZacaciaStatus($this->form->getValue('status'));
                    #$this->domain->setZacaciaUnDeletable($this->form->getValue('undeletable'));


                    $this->domain->setZacaciaUnDeletable($this->form->getValue('undeletable'));
                    if ( $this->form->getValue('undeletable') ) {
                        $this->domain->setZacaciaUnDeletable(1);
                    } else {
                        $this->domain->setZacaciaUnDeletable(0);
                    }

                    $this->domain->setZacaciaStatus($this->form->getValue('status'));

                    #var_dump( $this->domain ); exit;

                    if ( $l->doSave($this->domain) ) {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                        echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                        exit;
                    }
                } else {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }

        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('domainDn')->setDefault($domainDn);
        if ( $this->domain->getZacaciaUndeletable() ) {
            $this->form->getWidget('undeletable')->setDefault('true');
        }

        if ( $this->domain->getZacaciaStatus() == 'enable' ) {
            $this->form->getWidget('status')->setDefault('true');
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

        $this->cancel = new DomainNavigationForm();
        unset($this->cancel['domainDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));
    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }
        
        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }
        
        $c = new LDAPCriteria();
        $c->setBaseDn($domainDn);
        
        $l = new DomainPeer();
        $d = $l->retrieveByDn($c);
        
        if ( 'enable' === $d->getZacaciaStatus()) {
            $d->setZacaciaStatus(false);
        } else {
            $d->setZacaciaStatus(true);
        }

        $l->doSave($d);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }
        
        
        $c = new LDAPCriteria();
        $c->setBaseDn($domainDn);
        
        $l = new DomainPeer();
        $d = $l->retrieveByDn($c);

        if ( 'disable' === $d->getZacaciaStatus())
        {
            $l->doDelete($d, false);
        }
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@domain', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;
        
        $pattern = sfConfig::get('domain_pattern');
        
        if ( ! preg_match($pattern, $request->getParameter('name') ) )
        {
            $this->count = 1;
            return sfView::SUCCESS;
        }
        $l = new ServerPeer();
        $c = new LDAPCriteria();
        
        $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')) );
        
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniDomain');
        $c->add('cn', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
}
