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
        $c->add('objectClass', 'miniPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);
        
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
        foreach ($this->companies as $company) {
            $form = new CompanyNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($company->getDn());

            $company->setNumberOfDomains($l);
            $company->setNumberOfUsers($l);
            $company->setNumberOfGroups($l);
            $company->setNumberOfForwards($l);
            $company->setNumberOfContacts($l);
            $company->setNumberOfAddressLists($l);

            $undeletable = (
                $company->getNumberOfDomains() +
                $company->getNumberOfUsers() +
                $company->getNumberOfGroups() +
                $company->getNumberOfForwards() +
                $company->getNumberOfContacts() +
                $company->getNumberOfAddressLists()
            );

            $company->set('undeletable', $undeletable);

            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$company->getDn()] = $form;
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

        $this->form = new CompanyNew1Form();

        $this->form->getWidget('platformDn')->setDefault($platformDn);
    
        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $this->getUser()->setAttribute('company_data', $this->form->getValues());
                $this->redirect('company/new2');
            }
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));

        $this->setTemplate( 'new1' );
    }

    public function executeNew2(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];

        $this->form = new CompanyNew2Form();

        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $data = array_merge($company_data, $this->form->getValues());
                $this->getUser()->setAttribute('company_data', $data );
                $this->redirect('company/new3');
            }
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Companies,%s", $platformDn));

        $this->form->getWidget('zarafaCompanyServer')->setOption('choices', $l->getServerOptionList($platformDn));
#        $zarafa_admins = $l->getUserOptionList($platformDn);
#        $this->form->getWidget('zarafaSystemAdmin')->setOption('choices', $zarafa_admins );
#        $this->form->getWidget('zarafaQuotaCompanyWarningRecipients')->setOption('choices', $zarafa_admins);
       
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($company_data['platformDn']);
    }

    public function executeNew3(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));

        $this->form = new CompanyNew3Form();

        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $data = array_merge($company_data, $this->form->getValues());

                $company = new CompanyObject();
                $company->setDn(sprintf("cn=%s,%s", $data['cn'], $l->getBaseDn()));
                $company->setCn($data['cn']);
                $company->setMiniStatus($data['status']);
                $company->setMiniUnDeletable($data['undeletable']);

                if ( !empty($data['zarafaQuotaOverride']) ) {
                    $company->setZarafaQuotaOverride(1);
                    $company->setZarafaQuotaWarn( $data['zarafaQuotaWarn'] );
                }

                if ( !empty($data['zarafaUserDefaultQuotaOverride']) ) {
                    $company->setZarafaUserDefaultQuotaOverride(1);
                    $company->setZarafaUserDefaultQuotaHard( $data['zarafaUserDefaultQuotaHard'] );
                    $company->setZarafaUserDefaultQuotaSoft( $data['zarafaUserDefaultQuotaSoft'] );
                    $company->setZarafaUserDefaultQuotaWarn( $data['zarafaUserDefaultQuotaWarn'] );
                }

                if ( $l->doAdd($company) ) {
                    $this->getUser()->setAttribute('company_data', null);
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
            $this->getUser()->setFlash('miniJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'company/index', Array('platformDn' => $platformDn));
        }

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
        
        $c = new LDAPCriteria();
        $c->setBaseDn($companyDn);

        $company = $l->retrieveByDn($c);
        
        $this->form = new CompanyEdit1Form();
    
        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $this->getUser()->setAttribute('company_data', $this->form->getValues());
                $this->redirect('company/edit2');
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }
        
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('status')->setDefault($company->getMiniStatus());
        $this->form->getWidget('undeletable')->setDefault($company->getMiniUndeletable());

        $this->cn = $company->getCn();
        
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));

        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');
        $this->setTemplate( 'edit1' );
    }

    public function executeEdit2(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];
        $companyDn = $company_data['companyDn'];

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
        
        $c = new LDAPCriteria();
        $c->setBaseDn($companyDn);

        $company = $l->retrieveByDn($c);
        
        $this->form = new CompanyEdit2Form();
    
        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $data = array_merge($company_data, $this->form->getValues());
                $this->getUser()->setAttribute('company_data', $data );
                $this->redirect('company/edit3');
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }
        
        if ( 1 == $company->getZarafaQuotaOverride() ) {
            $this->form->getWidget('zarafaQuotaOverride')->setDefault(1);
            $this->form->getWidget('zarafaQuotaWarn')->setDefault($company->getZarafaQuotaWarn());
        }

        $this->cn = $company->getCn();
        
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);

        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');
    }

    public function executeEdit3(sfWebRequest $request)
    {
        $company_data = $this->getUser()->getAttribute('company_data');
        $platformDn = $company_data['platformDn'];
        $companyDn = $company_data['companyDn'];

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
        
        $c = new LDAPCriteria();
        $c->setBaseDn($companyDn);

        $company = $l->retrieveByDn($c);
        
        $this->form = new CompanyEdit3Form();
    
        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));
            
            if ($this->form->isValid()) {
                $data = array_merge($company_data, $this->form->getValues());

                $company->setMiniStatus($data['status']);
                $company->setMiniUnDeletable($data['undeletable']);

                if ( !empty($data['zarafaQuotaOverride']) ) {
                    $company->setZarafaQuotaOverride(1);
                    $company->setZarafaQuotaWarn( $data['zarafaQuotaWarn'] );
                } else {
                    $company->setZarafaQuotaOverride(array());
                    $company->setZarafaQuotaWarn(array());
                }

                if ( !empty($data['zarafaUserDefaultQuotaOverride']) ) {
                    $company->setZarafaUserDefaultQuotaOverride(1);
                    $company->setZarafaUserDefaultQuotaHard( $data['zarafaUserDefaultQuotaHard'] );
                    $company->setZarafaUserDefaultQuotaSoft( $data['zarafaUserDefaultQuotaSoft'] );
                    $company->setZarafaUserDefaultQuotaWarn( $data['zarafaUserDefaultQuotaWarn'] );
                } else {
                    $company->setZarafaUserDefaultQuotaOverride(array());
                    $company->setZarafaUserDefaultQuotaHard(array());
                    $company->setZarafaUserDefaultQuotaSoft(array());
                    $company->setZarafaUserDefaultQuotaWarn(array());
                }

                if ( $l->doSave($company) ) {
                    $this->getUser()->setAttribute('company_data', null);
                    sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                    echo fake_post($this, 'company/index', Array('platformDn' => $platformDn));
                    exit;
                }
            }
        }
        
        if ( 1 == $company->getZarafaUserDefaultQuotaOverride() ) {
            $this->form->getWidget('zarafaUserDefaultQuotaOverride')->setDefault(1);
            $this->form->getWidget('zarafaUserDefaultQuotaHard')->setDefault($company->getZarafaUserDefaultQuotaHard());
            $this->form->getWidget('zarafaUserDefaultQuotaSoft')->setDefault($company->getZarafaUserDefaultQuotaSoft());
            $this->form->getWidget('zarafaUserDefaultQuotaWarn')->setDefault($company->getZarafaUserDefaultQuotaWarn());
        }

        $this->cn = $company->getCn();
        
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);

        $this->getResponse()->addJavascript(sfConfig::get('sf_prototype_web_dir').'/js/prototype', 'last');
    }



/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;
        
        $pattern = sfConfig::get('company_pattern');
        if ( ! preg_match($pattern, $request->getParameter('name') ) ) {
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
