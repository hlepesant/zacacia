<?php

/**
 * platform actions.
 *
 * @package    MinivISP
 * @subpackage platform
 * @author     Hugues Lepesant
 */
class platformActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request)
    {
        $c = new LDAPCriteria();
        $c->add('objectClass', 'miniPlatform');
        
        $l = new PlatformPeer();
        $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')));
        
        $this->platforms = $l->doSelect($c);
        
        $id=0;
        $this->forms = array();
        foreach ($this->platforms as $p)
        {
            $form = new platformNavigationForm();
            $form->getWidget('platformDn')->setDefault($p->getDn());
            
            $criteria_company = new LDAPCriteria();
            $criteria_company->setBaseDn(sprintf("ou=Organizations,%s", $p->getDn()));
            $criteria_company->add('objectClass', 'miniCompany');
            $criteria_company->add('cn', '*');
            $count_company = $l->doCount($criteria_company);
            
            switch( sfConfig::get('navigation_look') )
            {
                case 'dropdown':
                    $choices = $form->getWidget('destination')->getOption('choices');
                    $choices['status'] = $this->getContext()->getI18N()->__('Disable', Array(), 'messages');
                    
                    if ( $p->getMiniStatus() == 'disable' && $count_company  == 0 )
                    {
                        $choices['status'] = $this->getContext()->getI18N()->__('Enable', Array(), 'messages');
                        $choices['delete'] = $this->getContext()->getI18N()->__('Delete', Array(), 'messages');
                    }
                    
                    if ( $p->getMiniUnDeletable() === 'TRUE' )
                    {
                        unset($choices['delete'], $choices['status']);
                    }
                    $choices['company'] = '&rarr;&nbsp;'.$this->getContext()->getI18N()->__('Company', Array(), 'messages');
                    
                    $form->getWidget('destination')->setOption('choices', $choices);
                break;
                
                case 'link':
                default:
                    $p->set('company_count', $count_company);
                break;
            }
            
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));
            
            $this->forms[$p->getDn()] = $form;
            $id++;
        }
        
        $this->new = new PlatformNavigationForm();
        unset($this->new['platformDn'], $this->new['destination']);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new PlatformForm();
        
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid())
            {
                $l = new PlatformPeer();
                $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')));
                
                $p = new PlatformObject();
                $p->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $l->getBaseDn()));
                $p->setCn($this->form->getValue('cn'));
                $p->setMiniStatus($this->form->getValue('status'));
                $p->setMiniUnDeletable($this->form->getValue('undeletable'));
            
                if ( $l->doAdd($p) )
                {
                  sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                  echo fake_post($this, 'platform/index', Array());
                  exit;
                }
            }
            else 
            {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }
        $this->cancel = new PlatformNavigationForm();
        unset($this->cancel['platformDn'], $this->cancel['destination']);
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('minidata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        
        if ( empty($platformDn) )
        {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@homepage');
        }
        
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniPlatform');
        
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $p = $l->retrieveByDn($c);
        
        $this->form = new PlatformEditForm();
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid())
            {
                $p->setMiniStatus($this->form->getValue('status'));
                $p->setMiniUnDeletable($this->form->getValue('undeletable'));
                
                if ( $l->doSave($p) )
                {
                  sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                  echo fake_post($this, 'platform/index', Array());
                  exit;
                }
            }
            else 
            {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));

            }
        }
        
        $this->cn = $p->getCn();
        
        $this->form->getWidget('platformDn')->setDefault($p->getDn());
        $this->form->getWidget('undeletable')->setDefault($p->getMiniundeletable());
        $this->form->getWidget('status')->setDefault($p->getMinistatus());
        
        $this->cancel = new PlatformNavigationForm();
        unset($this->cancel['platformDn'], $this->cancel['destination']);
    }

    public function executeStatus(sfWebRequest $request)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn($request->getParameter('platformDn'));
        
        $l = new PlatformPeer();
        $p = $l->retrieveByDn($c);
        
        if ( 'enable' === $p->getMiniStatus())
        {
            $p->setMiniStatus('disable');
        }
        else
        {
            $p->setMiniStatus('enable');
        }
        
        $l->doSave($p);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'platform/index', Array());
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn($request->getParameter('platformDn'));
        
        $l = new PlatformPeer();
        $p = $l->retrieveByDn($c);
        
        if ( 'disable' === $p->getMiniStatus())
        {
            $l->doDelete($p, true);
        }
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'platform/index', Array());
        exit;
    }

/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;
        
        $l = new PlatformPeer();
        $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')));

        $c = new LDAPCriteria();
        
        $c->setBaseDn( $l->getBaseDn() );
        $c->add('objectClass', 'miniPlatform');
        $c->add('cn', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
}
