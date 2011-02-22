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

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('minidata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
          $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
          $this->redirect('@platform');
        }

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Companies,%s", $platformDn));

        $this->form = new CompanyFormStep1();

        $this->form->getWidget('platformDn')->setDefault($platformDn);
    
        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid())
            {
                $this->getUser()->setAttribute('company_data', $this->form->getValues());
                $this->redirect('company/step2');
            }
        }

        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));

        $this->setTemplate( 'step1' );
    }

    public function executeStep2(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];

        $this->form = new CompanyFormStep2();

        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid())
            {
                $data = array_merge($company_data, $this->form->getValues());
                $this->getUser()->setAttribute('company_data', $data );
                $this->redirect('company/step3');
            }
        }

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Companies,%s", $platformDn));

        $this->form->getWidget('zarafaCompanyServer')->setOption('choices', $l->getServerOptionList($platformDn));

#        $zarafa_admins = $l->getUserOptionList($platformDn);
#        $this->form->getWidget('zarafaSystemAdmin')->setOption('choices', $zarafa_admins );
#        $this->form->getWidget('zarafaQuotaCompanyWarningRecipients')->setOption('choices', $zarafa_admins);
       
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($company_data['platformDn']);
       
        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');

        $this->setTemplate( 'step2' );
    }

    public function executeStep3(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));

        $this->form = new CompanyFormStep3();

        if ($request->isMethod('post') && $request->getParameter('minidata'))
        {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid())
            {
                $data = array_merge($company_data, $this->form->getValues());

                $company = new CompanyObject();
                $company->setDn(sprintf("cn=%s,%s", $data['cn'], $l->getBaseDn()));
                $company->setCn($data['cn']);
                $company->setMiniStatus($data['status']);
                $company->setMiniUnDeletable($data['undeletable']);

                if ( !empty($data['zarafaQuotaOverride']) ) 
                {
                    $company->setZarafaQuotaOverride(1);
                    $company->setZarafaQuotaWarn( $data['zarafaQuotaWarn'] );
                }

                if ( !empty($data['zarafaUserDefaultQuotaOverride']) ) 
                {
                    $company->setZarafaUserDefaultQuotaOverride(1);
                    $company->setZarafaUserDefaultQuotaHard( $data['zarafaUserDefaultQuotaHard'] );
                    $company->setZarafaUserDefaultQuotaSoft( $data['zarafaUserDefaultQuotaSoft'] );
                    $company->setZarafaUserDefaultQuotaWarn( $data['zarafaUserDefaultQuotaWarn'] );
                }

                if ( $l->doAdd($company) )
                {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                    echo fake_post($this, 'company/index', Array('platformDn' => $platformDn));
                    exit;
                }
            }
        }

        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
       
        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');

        $this->setTemplate( 'step3' );
    }



/* WebServices */
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
        $c->add('objectClass', 'miniCompany');
        $c->add('cn', $request->getParameter('name'));
        
        $this->count = $l->doCount($c);
        
        return sfView::SUCCESS;
    }
  
}
