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

#        $id=0;
#        $this->forms = array();
#        foreach ($this->platforms as $platform) {
#            $form = new PlatformNavigationForm();
#            $form->getWidget('platformDn')->setDefault($platform->getDn());
#            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
#            $this->forms[$platform->getDn()] = $form;
#            $id++;
#        }

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

                $this->redirectIf(
                    $ldapPeer->doAdd($platform),
                    $this->getController()->genUrl('@platforms')
                );
            }
        }
        $this->cancel = new PlatformNavigationForm();
        unset($this->cancel['platformDn']);
    }

    public function executeEdit(sfWebRequest $request)
    {
        $ldapPeer = new PlatformPeer();
        $platformDn = $ldapPeer->doDn($request->getParameter('platform'));

        $this->forward404Unless( $this->platform = $ldapPeer->getPlatform($platformDn) );

        $this->form = new PlatformEditForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $this->platform->setZacaciaMultiTenant($this->form->getValue('multitenant'));
                $this->platform->setZacaciaMultiServer($this->form->getValue('multiserver'));
                #$this->platform->setZacaciaUnDeletable($this->form->getValue('undeletable'));
                $this->platform->setZacaciaStatus($this->form->getValue('status'));

                $this->redirectIf(
                    $ldapPeer->doSave($this->platform),
                    $this->getController()->genUrl('@platforms')
                );
            }
        }

        $this->form->getWidget('multiserver')->setDefault($this->platform->getZacaciaMultiServer());
        $this->form->getWidget('multitenant')->setDefault($this->platform->getZacaciaMultiTenant());
        #$this->form->getWidget('undeletable')->setDefault($this->platform->getZacaciaUndeletable());

        $this->form->getWidget('status')->setDefault($this->platform->getZacaciaStatus());

        $this->cancel = new PlatformNavigationForm();
    }

    public function executeStatus(sfWebRequest $request)
    {
        $ldapPeer = new PlatformPeer();
        $platformDn = $ldapPeer->doDn($request->getParameter('platform'));

        $this->forward404Unless( $platform = $ldapPeer->getPlatform($platformDn) );

        if ( $request->getParameter('status') == 0 ) {
            $platform->setZacaciaStatus('disable');
        } else {
            $platform->setZacaciaStatus('enable');
        }

        $this->redirectIf(
            $ldapPeer->doSave($platform),
            $this->getController()->genUrl('@platforms')
        );
    }

    public function executeDelete(sfWebRequest $request)
    {
        $ldapPeer = new PlatformPeer();
        $platformDn = $ldapPeer->doDn($request->getParameter('platform'));

        $this->forward404Unless( $platform = $ldapPeer->getPlatform($platformDn) );

        if ( 'disable' === $platform->getZacaciaStatus()) {
            $ldapPeer->doDelete($platform, true);
        }

        $this->redirect($this->getController()->genUrl('@platforms'));
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
