<?php

/**
 * organization actions.
 *
 * @package    Zacacia
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
        $data = $request->getParameter('zdata');
        
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);
        
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-company');
        $c->add('objectClass', 'zacaciaCompany');
        
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
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
          $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
          $this->redirect('@platform');
        }

        $this->form = new CompanyForm();

        $this->form->getWidget('platformDn')->setDefault($platformDn);
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {
            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

                $l = new CompanyPeer();
                $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));

                $company = new CompanyObject();
                $company->setDn(sprintf("cn=%s,ou=Organizations,%s", $this->form->getValue('cn'), $platformDn));
                $company->setCn($this->form->getValue('cn'));
                $company->setZacaciaStatus($this->form->getValue('status'));
                $company->setGidNumber($l->getNewGidNumber());

                if ( $this->form->getValue('zarafaQuotaOverride') ) {
                    $company->setZarafaQuotaOverride(1);
                    $company->setZarafaQuotaWarn($this->form->getValue('zarafaQuotaWarn'));
                }

                if ( $this->form->getValue('zarafaUserDefaultQuotaOverride') ) {
                    $company->setZarafaUserDefaultQuotaOverride(1);
                    $company->setZarafaUserDefaultQuotaHard($this->form->getValue('zarafaUserDefaultQuotaHard'));
                    $company->setZarafaUserDefaultQuotaSoft($this->form->getValue('zarafaUserDefaultQuotaSoft'));
                    $company->setZarafaUserDefaultQuotaWarn($this->form->getValue('zarafaUserDefaultQuotaWarn'));
                }

                if ( $l->doAdd($company) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, '@company', Array('platformDn' => $platformDn));
                    exit;
                }
            }
        }
        
        $this->form->getWidget('status')->setDefault('true');
/*
        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Companies,%s", $platformDn));
        $this->form->getWidget('zarafaCompanyServer')->setOption('choices', $l->getServerOptionList($platformDn));
*/
        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        }

        $l = new CompanyPeer();
        $l->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
        
        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($companyDn);

        $this->company = $l->retrieveByDn($criteria);

        #print_r( $this->company ); exit;
        
        $this->form = new CompanyEditForm();
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {
            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {
                $this->company->setZacaciaStatus($this->form->getValue('status'));

                if ($this->form->getValue('zarafaQuotaOverride')) {
                    $this->company->setZarafaQuotaOverride(1);
                    $this->company->setZarafaQuotaWarn($this->form->getValue('zarafaQuotaWarn'));
                } else {
                    $this->company->setZarafaQuotaOverride(array());
                    $this->company->setZarafaQuotaWarn(array());
                }

                if ($this->form->getValue('zarafaUserDefaultQuotaOverride')) {
                    $this->company->setZarafaUserDefaultQuotaOverride(1);
                    $this->company->setZarafaUserDefaultQuotaHard($this->form->getValue('zarafaUserDefaultQuotaHard'));
                    $this->company->setZarafaUserDefaultQuotaSoft($this->form->getValue('zarafaUserDefaultQuotaSoft'));
                    $this->company->setZarafaUserDefaultQuotaWarn($this->form->getValue('zarafaUserDefaultQuotaWarn'));
                } else {
                    $this->company->setZarafaUserDefaultQuotaOverride(array());
                    $this->company->setZarafaUserDefaultQuotaHard(array());
                    $this->company->setZarafaUserDefaultQuotaSoft(array());
                    $this->company->setZarafaUserDefaultQuotaWarn(array());
                }

                if ( $l->doSave($this->company) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, '@company', Array('platformDn' => $platformDn));
                    exit;
                }
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);
        
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);
        $this->form->getWidget('status')->setDefault($this->company->getZacaciaStatus());

        $this->zarafa_settings_display = 'none';
        $this->zarafa_company_settings_display = 'none';
        $this->zarafa_users_settings_display = 'none';

        if ( $this->company->getZarafaAccount() ) {
            $this->zarafa_settings_display = 'block';
            $this->form->getWidget('zarafaAccount')->setDefault('true');

            if ( $this->company->getZarafaQuotaOverride() ) {
                $this->zarafa_company_settings_display = 'block';
                $this->form->getWidget('zarafaQuotaOverride')->setDefault(1);
                $this->form->getWidget('zarafaQuotaWarn')->setDefault($this->company->getZarafaQuotaWarn());
            }

            if ( $this->company->getZarafaUserDefaultQuotaOverride() ) {
                $this->zarafa_users_settings_display = 'block';
                $this->form->getWidget('zarafaUserDefaultQuotaOverride')->setDefault(1);
                $this->form->getWidget('zarafaUserDefaultQuotaHard')->setDefault($this->company->getZarafaUserDefaultQuotaHard());
                /* $this->form->getWidget('zarafaUserDefaultQuotaSoft')->setDefault($this->company->getZarafaUserDefaultQuotaSoft()); */
                /* $this->form->getWidget('zarafaUserDefaultQuotaWarn')->setDefault($this->company->getZarafaUserDefaultQuotaWarn()); */
            }
        }
        
        $this->cancel = new CompanyNavigationForm();
        unset($this->cancel['companyDn'], $this->cancel['destination']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
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

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($companyDn);

        $l = new CompanyPeer();
        $company = $l->retrieveByDn($criteria);

        if ( 'enable' === $company->getZacaciaStatus()) {
            $company->setZacaciaStatus(false);
        } else {
            $company->setZacaciaStatus(true);
        }

        $l->doSave($company);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
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

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($companyDn);

        $l = new CompanyPeer();
        $company = $l->retrieveByDn($criteria);

        if ( 'disable' === $company->getZacaciaStatus()) {
            $l->doDelete($company, true);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@company', Array('platformDn' => $platformDn));
        exit;
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
        $c->add('objectClass', 'zacaciaCompany');
        $c->add('cn', $request->getParameter('name'));

        $this->count = $l->doCount($c);

        return sfView::SUCCESS;
    }
  
}
