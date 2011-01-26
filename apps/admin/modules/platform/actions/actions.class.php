<?php

/**
 * platform actions.
 *
 * @package    MinivISP
 * @subpackage platform
 * @author     Hugues Lepesant
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
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
    $c = new LDAPCriteria();
    $c->add('objectClass', 'miniPlatform');

    $l = new PlatformPeer();
    $l->setBaseDn(sprintf("ou=Platforms,%s", sfConfig::get('ldap_bind_dn')));

    $this->platforms = $l->doSelect($c);

    $id=0;
    $this->forms = array();
    foreach ($this->platforms as $p)
    {
      $form = new platformNavigationForm();
      $form->getWidget('platformDn')->setDefault($p->getDn());

      $criteria_company = new LDAPCriteria();
      $criteria_company->setBaseDn(sprintf("ou=Organizations,%s", $p->getDn()));
      $criteria_company->add('objectClass', 'miniCompany');
      $criteria_company->add('cn', '*');
      $count_company = $l->doCount($criteria_company);

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
          $p->set('company_count', $count_company);
        break;
      }

      $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
      $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));

      $this->forms[$p->getDn()] = $form;
      $id++;
    }

    $this->new = new PlatformNavigationForm();
    unset($this->new['platformDn'], $this->new['destination']);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new PlatformForm();

    if ($request->isMethod('post') && $request->getParameter('minidata'))
    {
      $this->form->bind($request->getParameter('minidata'));

      if ($this->form->isValid())
      {
        $platform = new PlatformPeer();

        $platform_object = new PlatformObject();
        $platform_object->setDn(sprintf("cn=%s,%s", $this->form->getValue('cn'), $platform->getBaseDn()));
        $platform_object->setCn($this->form->getValue('cn'));
        $platform_object->setMiniStatus($this->form->getValue('status'));
        $platform_object->setMiniUnDeletable($this->form->getValue('undeletable'));

        if ( $platform->doAdd($platform_object) )
        {
          sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
          echo fake_post($this, '@homepage', Array());
          exit;
        }
     }
      else 
        $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
    }

    $this->cancel = new PlatformNavigationForm();
    unset($this->cancel['platformDn'], $this->cancel['destination']);
  }

  public function executeEdit(sfWebRequest $request)
  {
    $data = $request->getParameter('minidata');
    $platformDn = $request->getParameter('platformDn', $data['platformDn']);

    if ( empty($platformDn) ) {
      $this->getUser()->setFlash('miniJsAlert', "Missing platform's DN.");
      $this->redirect('@homepage');
    }

    $c = new LDAPCriteria();
    $c->add('objectClass', 'top');
    $c->add('objectClass', 'organizationalRole');
    $c->add('objectClass', 'miniPlatform');

    $p = new PlatformPeer();
    $p->setBaseDn($platformDn);
    $platform = $p->retrieveByDn($c);

    $this->form = new PlatformEditForm();
    if ($request->isMethod('post') && $request->getParameter('minidata'))
    {
      $this->form->bind($request->getParameter('minidata'));

      if ($this->form->isValid())
      {
        $platform->setMiniStatus($this->form->getValue('status'));
        $platform->setMiniUnDeletable($this->form->getValue('undeletable'));

        if ( $p->doSave($platform) )
        {
          sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
          echo fake_post($this, '@homepage', Array());
          exit;
        }
     }
      else 
        $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
    }
    
    $this->cn = $platform->getCn();

    $this->form->getWidget('platformDn')->setDefault($platform->getDn());
    $this->form->getWidget('undeletable')->setDefault($platform->getMiniundeletable());
    $this->form->getWidget('status')->setDefault($platform->getMinistatus());

    $this->cancel = new PlatformNavigationForm();
    unset($this->cancel['platformDn'], $this->cancel['destination']);
  }

  public function executeStatus(sfWebRequest $request)
  {
    $c = new LDAPCriteria();
    $c->setBaseDn($request->getParameter('platformDn'));

    $ldap = new PlatformPeer();
    $platform = $ldap->retrieveByDn($c);

    if ( 'enable' === $platform->getMiniStatus())
    {
      $platform->setMiniStatus('disable');
    }
    else
    {
      $platform->setMiniStatus('enable');
    }

    $ldap->doSave($platform);

    sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
    echo fake_post($this, '@homepage', Array());
    exit;
  }

  public function executeDelete(sfWebRequest $request)
  {
    $c = new LDAPCriteria();
    $c->setBaseDn($request->getParameter('platformDn'));

    $p = new PlatformPeer();
    $platform = $p->retrieveByDn($c);

    if ( 'disable' === $platform->getMiniStatus())
    {
      $p->doDelete($platform, true);
    }

    sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
    echo fake_post($this, '@homepage', Array());
    exit;
  }
/*
  public function executeUpdate(sfWebRequest $request)
  {
    $c = new LDAPCriteria();
    $c->setBaseDn($request->getParameter('platformDn'));

    $p = PlatformPeer::retrieveByDn($c);

    $this->form = new PlatformForm();

    if ($request->isMethod('post') && $request->getParameter('minidata'))
    {
      $this->form->bind($request->getParameter('minidata'));

      if ($this->form->isValid())
      {
        $p = new PlatformPeer();
        $c = new LDAPCriteria();
        var_dump( $p );
        var_dump( $c );
        exit;

        $ldap_entry = Array();
        $ldap_entry['cn'] = $this->form->getValue('cn');
        $ldap_entry['miniStatus'] = $this->form->getValue('status');
        $ldap_entry['miniUnDeletable'] = 'TRUE';// $this->form->getValue('undeletable');

        $ldap_dn = sprintf("cn=%s,%%s", $this->form->getValue('cn')); 
        $ldap_dn = PlatformPeer::doAdd($c, $ldap_dn, $ldap_entry);

        $platform_tree = true;
        if ( $ldap_dn )
        {
          $platform_tree = PlatformPeer::doTree($c, $ldap_dn);
        }

        if ( $platform_tree )
        {
          sfContext::getInstance()->getConfiguration()->loadHelpers('miniFakePost');
          echo fake_post($this, '@homepage', Array());
          exit;
        }
      }
      else 
        $this->getUser()->setFlash('veeJsAlert', $this->getContext()->getI18N()->__('Missing parameters', Array(), 'messages'));
    }

    $this->cancel = new PlatformNavigationForm();
    unset($this->cancel['platformDn'], $this->cancel['destination']);
  }
*/

/* WebServices */
  public function executeCheck(sfWebRequest $request)
  {
    $this->setTemplate('check');
    $this->setLayout(false);
    $this->count = 0;

    $p = new PlatformPeer();
    $c = new LDAPCriteria();

    $c->setBaseDn( $p->getBaseDn() );
    $c->add('objectClass', 'miniPlatform');
    $c->add('cn', $request->getParameter('name'));

    $this->count = $p->doCount($c);

    return sfView::SUCCESS;
  }
}
