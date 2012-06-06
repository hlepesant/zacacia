<?php

/**
 * platform actions.
 *
 * @package    Zacacia
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
    /*
        $criteria = new LDAPCriteria();
        $criteria->add('objectClass', 'zacaciaPlatform');
        $criteria->setSortFilter('cn');
        $l = new PlatformPeer();
        $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));
        $this->platforms = $l->doSelect($criteria);
        */

        $ldapPeer = new PlatformPeer();
        # $platforms = $ldapPeer->getPlatformsAsOption();
        $this->platforms = $ldapPeer->getPlatforms();
/*
        $this->navigation = new NavigationSelectForm();
        $choices = array_merge($this->navigation->getWidget('selectedPlatform')->getChoices(), $platforms);
        $this->navigation->getWidget('selectedPlatform')->setOption('choices', $choices);
*/

        if ($request->isMethod('post') && $request->getParameter('nav')) {
            $this->navigation->bind($request->getParameter('nav'));
            if ($this->navigation->isValid()) {
        
                print_r( $_POST );

            }
        }

        $id=0;
        $this->forms = array();
        foreach ($this->platforms as $p) {

            $form = new PlatformNavigationForm();
            $form->getWidget('platformDn')->setDefault($p->getDn());

            $p->set('company_count', $ldapPeer->countCompany($p->getDn()));

            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));

            $this->forms[$p->getDn()] = $form;
            $id++;
        }

        $this->new = new PlatformNavigationForm();
        unset($this->new['platformDn']);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->form = new PlatformForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $l = new PlatformPeer();
                $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));

                $platform = new PlatformObject();
                $platform->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $l->getBaseDn()));
                $platform->setCn($this->form->getValue('cn'));

                if ( $this->form->getValue('multitenant') )
                    $platform->setZacaciaMultiTenant($this->form->getValue('multitenant'));

                if ( $this->form->getValue('multiserver') )
                    $platform->setZacaciaMultiServer($this->form->getValue('multiserver'));

                $platform->setZacaciaStatus($this->form->getValue('status'));

                #var_dump( $platform ); exit;

                if ( $l->doAdd($platform) ) {
                  sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                  echo fake_post($this, 'platform/index', Array());
                  exit;
                }
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }
        $this->cancel = new PlatformNavigationForm();
        unset($this->cancel['platformDn']);
    }

    public function executeShow(sfWebRequest $request)
    {
        $platformDn = base64_decode($request->getParameter('selectedPlatform'));

        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $ldapPeer = new PlatformPeer();
        $this->platform = $ldapPeer->getPlatform($platformDn);
        print( $this->platform->getCn() );

        exit;
    }

    public function executeEdit(sfWebRequest $request)
    {
        print_r( $_GET );
        exit;
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);

        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@homepage');
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zacaciaPlatform');

        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $this->form = new PlatformEditForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $this->platform->setZacaciaMultiTenant($this->form->getValue('multitenant'));
                $this->platform->setZacaciaMultiServer($this->form->getValue('multiserver'));
                $this->platform->setZacaciaUnDeletable($this->form->getValue('undeletable'));
                $this->platform->setZacaciaStatus($this->form->getValue('status'));
/*
                if ( $this->form->getValue('status') ) {
                    $this->platform->setZacaciaStatus('enable');
                } else {
                    $this->platform->setZacaciaStatus('disable');
                }
*/
                if ( $l->doSave($this->platform) ) {

                  sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                  echo fake_post($this, 'platform/index', Array());
                  exit;
                }
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }

        $this->form->getWidget('platformDn')->setDefault($this->platform->getDn());

        if ( $this->platform->getZacaciaMultiServer() ) {
            $this->form->getWidget('multiserver')->setDefault('true');
        }

        if ( $this->platform->getZacaciaMultiTenant() ) {
            $this->form->getWidget('multitenant')->setDefault('true');
        }

        if ( $this->platform->getZacaciaUndeletable() ) {
            $this->form->getWidget('undeletable')->setDefault('true');
        }

        $this->form->getWidget('status')->setDefault($this->platform->getZacaciaStatus());

        $this->cancel = new PlatformNavigationForm();
        unset($this->cancel['platformDn']);
    }

    public function executeStatus(sfWebRequest $request)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn($request->getParameter('platformDn'));

        $l = new PlatformPeer();
        $p = $l->retrieveByDn($c);

        if ( 'enable' === $p->getZacaciaStatus()) {
            $p->setZacaciaStatus(false);
        } else {
            $p->setZacaciaStatus(true);
        }

        $l->doSave($p);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, 'platform/index', Array());
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $c = new LDAPCriteria();
        $c->setBaseDn($request->getParameter('platformDn'));

        $l = new PlatformPeer();
        $p = $l->retrieveByDn($c);

        if ( 'disable' === $p->getZacaciaStatus()) {
            $l->doDelete($p, true);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
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
        $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));

        $c = new LDAPCriteria();

        $c->setBaseDn( $l->getBaseDn() );
        $c->add('objectClass', 'zacaciaPlatform');
        $c->add('cn', $request->getParameter('name'));

        $this->count = $l->doCount($c);

        return sfView::SUCCESS;
    }
}
