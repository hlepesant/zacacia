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
        $c->add('objectClass', 'inetOrgPerson');
        $c->add('objectClass', 'posixAccount');
        $c->add('objectClass', 'zarafa-user');
        $c->add('objectClass', 'miniUser');
        
        $l = new UserPeer();
        $l->setBaseDn(sprintf("ou=Users,%s", $companyDn));
        
        $this->users = $l->doSelect($c, 'extended');
        
        $id=0;
        $this->forms = array();
        foreach ($this->users as $user)
        {
            $form = new UserNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('userDn')->setDefault($user->getDn());
            
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
                break;
            }
        
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('userDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$user->getDn()] = $form;
            $id++;
        }
        
        $this->new = new UserNavigationForm();
        unset($this->new['userDn'], $this->new['destination']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
        $this->new->getWidget('companyDn')->setDefault($platformDn);

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
    
        $this->form = new UserNew1Form();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
    
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
                if ($this->form->isValid())
                {
                    $this->getUser()->setAttribute('company_data', $this->form->getValues());
                    $this->redirect('user/new2');
                }
        }
        
        $this->cancel = new DomainNavigationForm();
        unset($this->cancel['domainDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
        $this->cancel->getWidget('companyDn')->setDefault($request->getParameter('companyDn'));

        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');
        $this->setTemplate( 'new1' );
    }

/* WebServices */
    public function executeCheckUid(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        if ( ! $request->hasParameter('companyDn') )
        {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('uid') )
        {
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
        $c->add('objectClass', 'miniUser');
        $c->add('uid', $request->getParameter('uid'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
}
