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
            $this->redirect('@platforms');
        }
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
              sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
              echo fake_post($this, '@companies', Array('holdingDn' => $holdingDn));
              exit;
        }

        $ldapPeer = new DomainPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        $this->domains = $ldapPeer->getDomains($companyDn);

        $id=0;
        $this->forms = array();
        foreach ($this->domains as $domain)
        {
            $form = new DomainNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('domainDn')->setDefault($domain->getDn());
        
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
          $this->redirect('@platforms');
        }
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
              sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
              echo fake_post($this, '@companies', Array('holdingDn' => $holdingDn));
              exit;
        }
        
        $ldapPeer = new DomainPeer();
    
        $this->form = new DomainForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {
            $this->form->bind($request->getParameter('zdata'));
            
                if ($this->form->isValid()) {
                    $ldapPeer->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
                    
                    $domain = new DomainObject();
                    $domain->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $ldapPeer->getBaseDn()));
                    $domain->setCn($this->form->getValue('cn'));
                    $domain->setZacaciaStatus($this->form->getValue('status'));

                    if ( $ldapPeer->doAdd($domain) ) {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                        echo fake_post($this, '@domains', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                        exit;
                    }
                } else {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        
        $this->cancel = new DomainNavigationForm();
        unset($this->cancel['domainDn']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
        $this->cancel->getWidget('companyDn')->setDefault($companyDn);
    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }
        
        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@domains', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $ldapPeer = new DomainPeer();
        $domain = $ldapPeer->getDomain($domainDn);

        if ( 'enable' === $domain->getZacaciaStatus()) {
            $domain->setZacaciaStatus(false);
        } else {
            $domain->setZacaciaStatus(true);
        }

        $ldapPeer->doSave($domain);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@domains', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@domains', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }
        
        
        $ldapPeer = new DomainPeer();
        $domain = $ldapPeer->getDomain($domainDn);

        if ( 'disable' === $domain->getZacaciaStatus()) {
            $ldapPeer->doDelete($domain, false);
        }
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@domains', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
        $this->setLayout(false);
        
        $pattern = sfConfig::get('domain_pattern');
        
        if ( ! preg_match($pattern, $request->getParameter('name') ) ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new DomainPeer();
        $this->exist = $ldapPeer->doSearch($request->getParameter('name'));
        
        return sfView::SUCCESS;
    }
}
