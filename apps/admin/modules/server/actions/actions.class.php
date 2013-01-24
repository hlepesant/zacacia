<?php

/**
 * server actions.
 *
 * @package    Zacacia
 * @subpackage server
 * @author     Hugues Lepesant
 */
class serverActions extends sfActions
{
/**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    public function executeIndex(sfWebRequest $request)
    {
        $ldapPeer = new ServerPeer();
        $platformDn = $ldapPeer->doPlatformDn($request->getParameter('platform'));
        $this->forward404Unless( $this->platform = $ldapPeer->getPlatform($platformDn) );


        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->servers = $ldapPeer->getServers($platformDn);

#        $id=0;
#        $this->forms = array();
#        foreach ($this->servers as $server) {
#            $form = new ServerNavigationForm();
#            $form->getWidget('platformDn')->setDefault($platformDn);
#            $form->getWidget('serverDn')->setDefault($server->getDn());
#
#            $server->set('user_count', $ldapPeer->countUser($this->platform, $server));
#
#            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
#            $form->getWidget('serverDn')->setIdFormat(sprintf('%%s_%03d', $id));
#
#            $this->forms[$server->getDn()] = $form;
#            $id++;
#        }

#        $this->new = new ServerNavigationForm();
#        unset($this->new['serverDn']);
#        $this->new->getWidget('platformDn')->setDefault($platformDn);
    }

    public function executeNew(sfWebRequest $request)
    {
        $ldapPeer = new ServerPeer();
        $platformDn = $ldapPeer->doPlatformDn($request->getParameter('platform'));
        $this->forward404Unless( $this->platform = $ldapPeer->getPlatform($platformDn) );

        $this->platform = $ldapPeer->getPlatform($platformDn);

        $ldapPeer->setBaseDn(sprintf("ou=Servers,%s", $platformDn));

        $this->form = new ServerForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));

                if ($this->form->isValid()) {

                    $server = new ServerObject();
                    $server->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $ldapPeer->getBaseDn()));
                    $server->setCn($this->form->getValue('cn'));
                    $server->setIpHostNumber($this->form->getValue('ip'));
                    $server->setZacaciaStatus($this->form->getValue('status'));

                    /* zarafa properties */
                    if ( $this->form->getValue('zarafaAccount') == 1 ) {
                            
                        $server->setZarafaAccount(1);

                        $server->setZarafaQuotaHard($this->form->getValue('zarafaQuotaHard'));
                        $server->setZarafaHttpPort($this->form->getValue('zarafaHttpPort'));
                        $server->setZarafaSslPort($this->form->getValue('zarafaSslPort'));

                        if ( $this->form->getValue('zarafaContainsPublic') ) {
                            $server->setZarafaContainsPublic(1);
                        }

                        if ( $this->form->getValue('multitenant') ) {
                            $server->setZacaciaMultiTenant(1);
                        }
                    }

                    if ( $ldapPeer->doAdd($server) ) {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                        echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
                        exit;
                    }
                } else {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }

        $this->platform = $ldapPeer->getPlatform($platformDn);

        $this->form->getWidget('zarafaHttpPort')->setDefault(sfConfig::get('zarafaHttpPort'));
        $this->form->getWidget('zarafaSslPort')->setDefault(sfConfig::get('zarafaSslPort'));
        #$this->form->getWidget('multitenant')->setDefault($this->platform->getZacaciaMultiTenant());

        $this->cancel = new ServerNavigationForm();
        unset($this->cancel['serverDn']);
        $this->cancel->getWidget('platformDn')->setDefault($this->platform->getDn());
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $serverDn = $request->getParameter('serverDn', $data['serverDn']);
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing server's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
        }

        $ldapPeer = new ServerPeer();
        $this->server = $ldapPeer->getServer($serverDn);

        $this->form = new ServerEditForm();

        if ($request->isMethod('post') && $request->getParameter('zdata')) {
            $this->form->bind($request->getParameter('zdata'));

            if ($this->form->isValid()) {

                $this->server->setIpHostNumber($this->form->getValue('ip'));
                $this->server->setZacaciaStatus($this->form->getValue('status'));

                /* zarafa properties */
                if ( $this->form->getValue('zarafaAccount') == 1 ) {
                    $this->server->setZarafaAccount(1);
                    $this->server->setZacaciaMultiTenant($this->form->getValue('multitenant'));
                    $this->server->setZarafaHttpPort($this->form->getValue('zarafaHttpPort'));
                    $this->server->setZarafaSslPort($this->form->getValue('zarafaSslPort'));
                    $this->server->setZarafaContainsPublic($this->form->getValue('zarafaContainsPublic'));
                    $this->server->setZarafaQuotaHard($this->form->getValue('zarafaQuotaHard'));
                } else {
                    $this->server->setZarafaAccount(0);
                    $this->server->setZacaciaMultiTenant(0);
                    $this->server->setZarafaHttpPort(array());
                    $this->server->setZarafaSslPort(array());
                    $this->server->setZarafaContainsPublic(array());
                    $this->server->setZarafaQuotaHard(0);
                }

                #var_dump( $this->server ); exit;

                if ( $ldapPeer->doSave($this->server) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, '@server', Array('platformDn' => $platformDn));
                    exit;
                }
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }

        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('serverDn')->setDefault($serverDn);
        $this->form->getWidget('ip')->setDefault($this->server->getIpHostNumber());
        $this->form->getWidget('status')->setDefault($this->server->getZacaciaStatus());

        $this->zarafa_settings_display = 'none';

        if ( $this->server->getZarafaAccount() ) {
            $this->zarafa_settings_display = 'block';
        }

        $this->form->getWidget('zarafaAccount')->setDefault($this->server->getZarafaAccount());
        $this->form->getWidget('zarafaHttpPort')->setDefault($this->server->getZarafaHttpPort());
        $this->form->getWidget('zarafaSslPort')->setDefault($this->server->getZarafaSslPort());
        $this->form->getWidget('zarafaContainsPublic')->setDefault($this->server->getZarafaContainsPublic());
        $this->form->getWidget('multitenant')->setDefault($this->server->getZacaciaMultiTenant());
        $this->form->getWidget('zarafaQuotaHard')->setDefault($this->server->getZarafaQuotaHard());

        $this->platform = $ldapPeer->getPlatform($platformDn);

        $this->cancel = new ServerNavigationForm();
        unset($this->cancel['serverDn']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $serverDn = $request->getParameter('serverDn');
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
        }
        
        $ldapPeer = new ServerPeer();
        $server = $ldapPeer->getServer($serverDn);

        if ( 'enable' === $server->getZacaciaStatus()) {
            $server->setZacaciaStatus('disable');
        } else {
            $server->setZacaciaStatus('enable');
        }

        $ldapPeer->doSave($server);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $serverDn = $request->getParameter('serverDn');
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
        }
        
        $ldapPeer = new ServerPeer();
        $server = $ldapPeer->getServer($serverDn);

        if ( 'disable' === $server->getZacaciaStatus()) {
            $ldapPeer->doDelete($server, false);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@servers', Array('platformDn' => $platformDn));
        exit;
    }

/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
#        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        $pattern = sfConfig::get('hostname_pattern');

        if ( ! preg_match($pattern, $request->getParameter('name') ) ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new ServerPeer();
        $this->exist = $ldapPeer->doSearch($request->getParameter('name'));

        return sfView::SUCCESS;
    }

    public function executeResolvehost(sfWebRequest $request)
    {
        #$this->setTemplate('check');
        $this->setLayout(false);
        $this->ip = 0;

        $pattern = sfConfig::get('hostname_pattern');

        if ( ! preg_match($pattern, $request->getParameter('name') ) ) {
            $this->ip = 0;
            return sfView::SUCCESS;
        }

#        if ( checkdnsrr( $request->getParameter('name'), 'A') ) {
            if ( $ip = dns_get_record($request->getParameter('name'), DNS_A) ) {
                $this->ip = $ip[0]['ip'];
            }
#        }

        return sfView::SUCCESS;
    }

    public function executeCheckip(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        $pattern = "/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/";

        if ( ! preg_match($pattern, $request->getParameter('ip') ) ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

#        $l = new ServerPeer();
#        $c = new LDAPCriteria();
#
#        $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')) );
#
#        $c->add('objectClass', 'top');
#        $c->add('objectClass', 'organizationalRole');
#        $c->add('objectClass', 'zarafa-server');
#        $c->add('objectClass', 'ipHost');
#        $c->add('objectClass', 'zacaciaServer');
#        $c->add('ipHostNumber', $request->getParameter('ip'));
#
#        $this->count = $l->doCount($c);

        return sfView::SUCCESS;
    }
}
