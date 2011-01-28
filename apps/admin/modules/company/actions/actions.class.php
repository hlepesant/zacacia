<?php

/**
 * organization actions.
 *
 * @package    MinivISP
 * @subpackage company
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyActions extends sfActions
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
        
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-company');
        $c->add('objectClass', 'miniCompany');
        
        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
        
        $this->companies = $l->doSelect($c, 'extended');
        
        $id=0;
        $this->forms = array();
        foreach ($this->companies as $comp)
        {
            $form = new serverNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('serverDn')->setDefault($comp->getDn());
            
            $criteria_user = new LDAPCriteria();
            $criteria_user->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
            $criteria_user->add('objectClass', 'zarafa-user');
            $criteria_user->add('zarafaUserServer', $comp->getCn());
            $count_user = $l->doCount($criteria_user);
            
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
                    
                    if ( $s->getMiniUnDeletable() === 'TRUE' )
                    {
                        unset($choices['delete'], $choices['status']);
                    }
                    $choices['company'] = '&rarr;&nbsp;'.$this->getContext()->getI18N()->__('Company', Array(), 'messages');
                    
                    $form->getWidget('destination')->setOption('choices', $choices);
                break;
                
                case 'link':
                default:
                    $comp->set('user_count', $count_user);
                break;
            }
        
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('serverDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$comp->getDn()] = $form;
            $id++;
        }
        
        $this->new = new CompanyNavigationForm();
        unset($this->new['companyDn'], $this->new['destination']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
    }
}
