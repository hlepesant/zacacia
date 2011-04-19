<?php

/**
 * server actions.
 *
 * @package    MinivISP
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
        $c->add('objectClass', 'zarafa-server');
        $c->add('objectClass', 'ipHost');
        $c->add('objectClass', 'miniServer');

        $l = new ServerPeer();
        $l->setBaseDn(sprintf("ou=Servers,%s", $platformDn));

        $this->servers = $l->doSelect($c, 'base');

        $id=0;
        $this->forms = array();
        foreach ($this->servers as $s) {

            $form = new ServerNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('serverDn')->setDefault($s->getDn());

            $criteria_user = new LDAPCriteria();
            $criteria_user->setBaseDn(sprintf("ou=Organizations,%s", $platformDn));
            $criteria_user->add('objectClass', 'zarafa-user');
            $criteria_user->add('zarafaUserServer', $s->getCn());
            $count_user = $l->doCount($criteria_user);
            $s->set('user_count', $count_user);

            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('serverDn')->setIdFormat(sprintf('%%s_%03d', $id));

            $this->forms[$s->getDn()] = $form;
            $id++;
        }

        $this->new = new ServerNavigationForm();
        unset($this->new['serverDn']);
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

        $this->form = new ServerForm();
        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('zarafaHttpPort')->setDefault(sfConfig::get('zarafaHttpPort'));
        $this->form->getWidget('zarafaSslPort')->setDefault(sfConfig::get('zarafaSslPort'));

        if ($request->isMethod('post') && $request->getParameter('minidata')) {

            $this->form->bind($request->getParameter('minidata'));

                if ($this->form->isValid()) {

                    $l = new ServerPeer();
                    $l->setBaseDn(sprintf("ou=Servers,%s", $platformDn));

                    $server = new ServerObject();
                    $server->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $l->getBaseDn()));
                    $server->setCn($this->form->getValue('cn'));
                    $server->setIpHostNumber($this->form->getValue('ip'));

                    $server->setMiniMultiTenant(array());
                    if ( $this->form->getValue('multitenant') ) {
                        $server->setMiniMultiTenant(1);
                    }

                    $server->setMiniUnDeletable(array());
                    if ( $this->form->getValue('undeletable') ) {
                        $server->setMiniUnDeletable(1);
                    }
                    $server->setMiniStatus($this->form->getValue('status'));

                    if ( $l->doAdd($s) ) {
                        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                        echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
                        exit;
                    }
                } else {
                    $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
                }
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $this->cancel = new ServerNavigationForm();
        unset($this->cancel['serverDn']);
        $this->cancel->getWidget('platformDn')->setDefault($this->platform->getDn());
    }

    public function executeEdit(sfWebRequest $request)
    {
        $data = $request->getParameter('minidata');
        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $serverDn = $request->getParameter('serverDn', $data['serverDn']);
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing server's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
        }

        $l = new ServerPeer();
        $l->setBaseDn(sprintf("ou=Servers,%s", $platformDn));
        $c = new LDAPCriteria();
        $c->setBaseDn($serverDn);
        $this->server = $l->retrieveByDn($c);

        $this->form = new ServerEditForm();

        if ($request->isMethod('post') && $request->getParameter('minidata')) {
            $this->form->bind($request->getParameter('minidata'));

            if ($this->form->isValid()) {

                $this->server->setIpHostNumber($this->form->getValue('ip'));
                $this->server->setZarafaHttpPort($this->form->getValue('zarafaHttpPort'));
                $this->server->setZarafaSslPort($this->form->getValue('zarafaSslPort'));

                $this->server->setMiniMultiTenant(array());
                if ( $this->form->getValue('multitenant') ) {
                    $this->server->setMiniMultiTenant(1);
                }

                $this->server->setMiniUnDeletable(array());
                if ( $this->form->getValue('undeletable') ) {
                    $this->server->setMiniUnDeletable(1);
                }

                $this->server->setMiniStatus($this->form->getValue('status'));

                if ( $l->doSave($this->server) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                    echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
                    exit;
                }
            } else {
                $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
            }
        }

        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('serverDn')->setDefault($serverDn);
        $this->form->getWidget('ip')->setDefault($this->server->getIpHostNumber());
        $this->form->getWidget('zarafaHttpPort')->setDefault($this->server->getZarafaHttpPort());
        $this->form->getWidget('zarafaSslPort')->setDefault($this->server->getZarafaSslPort());
        $this->form->getWidget('status')->setDefault($this->server->getMiniStatus());
        if ( $this->server->getMiniUndeletable() ) {
            $this->form->getWidget('undeletable')->setDefault('true');
        }
        if ( $this->server->getMiniMultiTenant() ) {
            $this->form->getWidget('multitenant')->setDefault('true');
        }

        $c = new LDAPCriteria();
        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'miniPlatform');
        $l = new PlatformPeer();
        $l->setBaseDn($platformDn);
        $this->platform = $l->retrieveByDn($c);

        $this->cancel = new ServerNavigationForm();
        unset($this->cancel['serverDn']);
        $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $serverDn = $request->getParameter('serverDn');
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
        }

        $c = new LDAPCriteria();
        $c->setBaseDn($serverDn);

        $l = new ServerPeer();
        $s = $l->retrieveByDn($c);

        if ( 'enable' === $s->getMiniStatus()) {
            $s->setMiniStatus('disable');
        } else {
            $s->setMiniStatus('enable');
        }

        $l->doSave($s);

        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            $this->redirect('@platform');
        }

        $serverDn = $request->getParameter('serverDn');
        if ( empty($serverDn) ) {
            $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
            echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
        }

        $c = new LDAPCriteria();
        $c->setBaseDn($serverDn);

        $l = new ServerPeer();
        $s = $l->retrieveByDn($c);

        if ( 'disable' === $s->getMiniStatus()) {
            $l->doDelete($s, false);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
        echo fake_post($this, 'server/index', Array('platformDn' => $platformDn));
        exit;
    }

/* WebServices */
    public function executeCheck(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->count = 0;

        $pattern = sfConfig::get('hostname_pattern');

        if ( ! preg_match($pattern, $request->getParameter('name') ) ) {
            $this->count = 1;
            return sfView::SUCCESS;
        }

        $l = new DomainPeer();
        $c = new LDAPCriteria();

        $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')) );

        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-server');
        $c->add('objectClass', 'ipHost');
        $c->add('objectClass', 'miniServer');
        $c->add('cn', $request->getParameter('name'));

        $this->count = $l->doCount($c);

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

        if ( $ip = dns_get_record ($request->getParameter('name'), DNS_A) ) {
            $this->ip = $ip[0]['ip'];
        }

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

        $l = new ServerPeer();
        $c = new LDAPCriteria();

        $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_base_dn')) );

        $c->add('objectClass', 'top');
        $c->add('objectClass', 'organizationalRole');
        $c->add('objectClass', 'zarafa-server');
        $c->add('objectClass', 'ipHost');
        $c->add('objectClass', 'miniServer');
        $c->add('ipHostNumber', $request->getParameter('ip'));

        $this->count = $l->doCount($c);

        return sfView::SUCCESS;
    }
}
