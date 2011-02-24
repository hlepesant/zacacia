<?php

/**
 * domain actions.
 *
 * @package    MinivISP
 * @subpackage domain
 * @author     Your name here
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
        $data = $request->getParameter('minidata');
          
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
          
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniDomain');
        
        $l = new DomainPeer();
        $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
        
        $this->domains = $l->doSelect($c, 'extended');
        
        $id=0;
        $this->forms = array();
        foreach ($this->domains as $domain)
        {
            $form = new domainNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('domainDn')->setDefault($domain->getDn());
            
            $criteria_user = new LDAPCriteria();
            $criteria_user->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
            $criteria_user->add('objectClass', 'zarafa-user');
            $criteria_user->add('zarafaUserServer', $domain->getCn());
            $count_user = $l->doCount($criteria_user);
            
            switch( sfConfig::get('navigation_look') )
            {
                case 'dropdown':
                    $choices = $form->getWidget('destination')->getOption('choices');
                    $choices['status'] = $this->getContext()->getI18N()->__('Disable', Array(), 'messages');
                    
                    if ( $p->getMiniStatus() == 'disable' && $count_user  == 0 )
                    {
                        $choices['status'] = $this->getContext()->getI18N()->__('Enable', Array(), 'messages');
                        $choices['delete'] = $this->getContext()->getI18N()->__('Delete', Array(), 'messages');
                    }
                    
                    if ( $s->getMiniUnDeletable() === 'TRUE' )
                    {
                        unset($choices['delete'], $choices['status']);
                    }
                    $choices['company'] = '&rarr;&nbsp;'.$this->getContext()->getI18N()->__('Company', Array(), 'messages');
                    
                    $form->getWidget('destination')->setOption('choices', $choices);
                break;
                
                case 'link':
                default:
                    $domain->set('user_count', $count_user);
                break;
            }
        
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('domainDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$domain->getDn()] = $form;
            $id++;
        }
        
        $this->new = new DomainNavigationForm();
        unset($this->new['domainDn'], $this->new['destination']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
        $this->new->getWidget('companyDn')->setDefault($companyDn);

        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');
    }

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('minidata');
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
    
        $this->form = new DomainForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
                if ($this->form->isValid())
                {
                    $l = new DomainPeer();
                    $l->setBaseDn(sprintf("ou=Domains,%s", $companyDn));
                    
                    $d = new DomainObject();
                    $d->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $l->getBaseDn()));
                    $d->setCn($this->form->getValue('cn'));
                    $d->setMiniStatus($this->form->getValue('status'));
                    $d->setMiniUnDeletable($this->form->getValue('undeletable'));

                    if ( $l->doAdd($d) )
                    {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                        echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                        exit;
                    }
                }
                else 
                {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }
        
        $this->cancel = new DomainNavigationForm();
        unset($this->cancel['domainDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('minidata');
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

        $d = $l->retrieveByDn($c);

        $this->form = new DomainEditForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('domainDn')->setDefault($domainDn);
    
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
                if ($this->form->isValid())
                {
                    $d->setMiniStatus($this->form->getValue('status'));
                    $d->setMiniUnDeletable($this->form->getValue('undeletable'));

                    if ( $l->doSave($d) )
                    {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                        echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                        exit;
                    }
                }
                else 
                {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }

        $this->cn = $d->getCn();
        
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
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'company/index', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }
        
        $c = new LDAPCriteria();
        $c->setBaseDn($domainDn);
        
        $l = new DomainPeer();
        $d = $l->retrieveByDn($c);
        
        if ( 'enable' === $d->getMiniStatus())
        {
            $d->setMiniStatus('disable');
        }
        else
        {
            $d->setMiniStatus('enable');
        }

        $l->doSave($d);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
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
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'company/index', Array('platformDn' => $platformDn));
        }
        
        $domainDn = $request->getParameter('domainDn');
        if ( empty($domainDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing domain's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }
        
        
        $c = new LDAPCriteria();
        $c->setBaseDn($domainDn);
        
        $l = new DomainPeer();
        $d = $l->retrieveByDn($c);

        if ( 'disable' === $d->getMiniStatus())
        {
            $l->doDelete($d, false);
        }
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'domain/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
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
