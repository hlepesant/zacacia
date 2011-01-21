<?php

/**
 * server actions.
 *
 * @package    MinivISP
 * @subpackage server
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
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
    $c = new LDAPCriteria();
    $c->add('objectClass', 'top');
    $c->add('objectClass', 'organizationalRole');
    $c->add('objectClass', 'zarafa-server');
    $c->add('objectClass', 'ipHost');
    $c->add('objectClass', 'miniServer');

    $l = new ServerPeer();
    $l->setBaseDn(sprintf("ou=Servers,%s", $request->getParameter('platformDn')));

    $this->servers = $l->doSelect($c);

    $id=0;
    $this->forms = array();
    foreach ($this->servers as $s)
    {
      $form = new serverNavigationForm();
      $form->getWidget('serverDn')->setDefault($s->getDn());

      $criteria_user = new LDAPCriteria();
      $criteria_user->setBaseDn(sprintf("ou=Organizations,%s", $request->getParameter('platformDn')));
      $criteria_user->add('objectClass', 'zarafa-user');
      $criteria_user->add('zarafaUserServer', $s->getCn());
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

          if ( $p->getMiniUnDeletable() === 'TRUE' )
          {
            unset($choices['delete'], $choices['status']);
          }
          $choices['company'] = '&rarr;&nbsp;'.$this->getContext()->getI18N()->__('Company', Array(), 'messages');

          $form->getWidget('destination')->setOption('choices', $choices);
        break;

        case 'link':
        default:
          $s->set('user_count', $count_user);
        break;
      }

      $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
      $form->getWidget('serverDn')->setIdFormat(sprintf('%%s_%03d', $id));
      $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));

      $this->forms[$s->getDn()] = $form;
      $id++;
    }

    $this->new = new ServerNavigationForm();
    unset($this->new['serverDn'], $this->new['destination']);
    $this->new->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
  }

  public function executeNew(sfWebRequest $request)
  {
    $data = $request->getParameter('minidata');
    $platformDn = $request->getParameter('platformDn', $data['platformDn']);

    $this->form = new ServerForm();
    $this->form->getWidget('platformDn')->setDefault($platformDn);
    $this->form->getWidget('zarafaHttpPort')->setDefault(sfConfig::get('zarafaHttpPort'));
    $this->form->getWidget('zarafaSslPort')->setDefault(sfConfig::get('zarafaSslPort'));

    if ($request->isMethod('post') && $request->getParameter('minidata'))
    {
      $this->form->bind($request->getParameter('minidata'));

        if ($this->form->isValid())
        {
            $server = new ServerPeer();
            $server->setBaseDn(sprintf("ou=Servers,%s", $platformDn));
            
            $server_object = new ServerObject();
            $server_object->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $server->getBaseDn()));
            $server_object->setCn($this->form->getValue('cn'));
            $server_object->setIpHostNumber($this->form->getValue('ip'));
            $server_object->setMiniStatus($this->form->getValue('status'));
            $server_object->setMiniUnDeletable($this->form->getValue('undeletable'));

            if ( $server->doAdd($server_object) )
            {
                sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
                echo fake_post($this, '@server', Array('platformDn' => $platformDn));
                exit;
            }
        }
        else 
            $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
    }

    $this->cancel = new ServerNavigationForm();
    unset($this->cancel['serverDn'], $this->cancel['destination']);
    $this->cancel->getWidget('platformDn')->setDefault($request->getParameter('platformDn'));
  }

/* WebServices */
  public function executeCheck(sfWebRequest $request)
  {
    $this->setTemplate('check');
    $this->setLayout(false);
    $this->count = 0;

    #$ValidIpAddressRegex = "^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$";
    $pattern = sfConfig::get('hostname_pattern');

    if ( ! preg_match($pattern, $request->getParameter('name') ) )
    {
        $this->count = 1;
        return sfView::SUCCESS;
    }
/*
#    $split = explode('.', $request->getParameter('name'), 5);
#    if ( 1 == count($split) )
#    {
#        $this->count = 1;
#        return sfView::SUCCESS;
#    }
*/

    $s = new ServerPeer();
    $c = new LDAPCriteria();

    $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')) );

    $c->add('objectClass', 'top');
    $c->add('objectClass', 'organizationalRole');
    $c->add('objectClass', 'zarafa-server');
    $c->add('objectClass', 'ipHost');
    $c->add('objectClass', 'miniServer');
    $c->add('cn', $request->getParameter('name'));

    $this->count = $s->doCount($c);

    return sfView::SUCCESS;
  }
  
  public function executeResolvehost(sfWebRequest $request)
  {
    #$this->setTemplate('check');
    $this->setLayout(false);
    $this->ip = 0;

    $pattern = sfConfig::get('hostname_pattern');

    if ( ! preg_match($pattern, $request->getParameter('name') ) )
    {
        $this->ip = 0;
        return sfView::SUCCESS;
    }

    if ( $ip = dns_get_record ($request->getParameter('name'), DNS_A) )
        $this->ip = $ip[0]['ip'];

    return sfView::SUCCESS;
  }
  
  public function executeCheckip(sfWebRequest $request)
  {
    $this->setTemplate('check');
    $this->setLayout(false);
    $this->count = 0;

    $pattern = "/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/";

    if ( ! preg_match($pattern, $request->getParameter('ip') ) )
    {
        $this->count = 1;
        return sfView::SUCCESS;
    }
/*
#    $split = explode('.', $request->getParameter('ip'), 4);
#    if ( 4 != count($split) )
#    {
#        $this->count = 1;
#        return sfView::SUCCESS;
#    }
*/

    $s = new ServerPeer();
    $c = new LDAPCriteria();

    $c->setBaseDn( sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')) );

    $c->add('objectClass', 'top');
    $c->add('objectClass', 'organizationalRole');
    $c->add('objectClass', 'zarafa-server');
    $c->add('objectClass', 'ipHost');
    $c->add('objectClass', 'miniServer');
    $c->add('ipHostNumber', $request->getParameter('ip'));

    $this->count = $s->doCount($c);

    return sfView::SUCCESS;
  }
}
