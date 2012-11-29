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
        $ldapPeer = new PlatformPeer();
        $this->platforms = $ldapPeer->getPlatforms();

        $id=0;
        $this->forms = array();
        foreach ($this->platforms as $platform) {

            $form = new PlatformNavigationForm();
            $form->getWidget('platformDn')->setDefault($platform->getDn());
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $this->forms[$platform->getDn()] = $form;
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

                $ldapPeer = new PlatformPeer();
                $ldapPeer->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')));

                $platform = new PlatformObject();
                $platform->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $ldapPeer->getBaseDn()));
                $platform->setCn($this->form->getValue('cn'));

                if ( $this->form->getValue('multitenant') ) {
                    $platform->setZacaciaMultiTenant($this->form->getValue('multitenant'));
                }

                if ( $this->form->getValue('multiserver') ) {
                    $platform->setZacaciaMultiServer($this->form->getValue('multiserver'));
                }

                $platform->setZacaciaStatus($this->form->getValue('status'));

                if ( $ldapPeer->doAdd($platform) ) {
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

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);

        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@homepage');
        }

        $ldapPeer = new PlatformPeer();
        $this->platform = $ldapPeer->getPlatform($platformDn);

        $this->form = new PlatformEditForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $this->platform->setZacaciaMultiTenant($this->form->getValue('multitenant'));
                $this->platform->setZacaciaMultiServer($this->form->getValue('multiserver'));
                $this->platform->setZacaciaUnDeletable($this->form->getValue('undeletable'));
                $this->platform->setZacaciaStatus($this->form->getValue('status'));

                if ( $ldapPeer->doSave($this->platform) ) {

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
        $ldapPeer = new PlatformPeer();
        $platform = $ldapPeer->getPlatform($request->getParameter('platformDn'));

        if ( 'enable' === $platform->getZacaciaStatus()) {
            $platform->setZacaciaStatus('disable');
        } else {
            $platform->setZacaciaStatus('enable');
        }

        $ldapPeer->doSave($platform);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, 'platform/index', Array());
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $ldapPeer = new PlatformPeer();
        $platform = $ldapPeer->getPlatform($request->getParameter('platformDn'));

        if ( 'disable' === $platform->getZacaciaStatus()) {
            $ldapPeer->doDelete($platform, true);
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
        $this->exist = 0;

        $ldapPeer = new PlatformPeer();
        $this->exist = $ldapPeer->doSearch($request->getParameter('name'));

        return sfView::SUCCESS;
    }
}
