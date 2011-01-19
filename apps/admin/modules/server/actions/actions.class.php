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
    $c->add('objectClass', 'miniServer');

    $l = new ServerPeer();
    $l->setBaseDn(sprintf("ou=Servers,%s", $request->getParameter('platformDn')));

    $this->servers = $l->doSelect($c);

    $id=0;
    $this->forms = array();
    foreach ($this->servers as $p)
    {
      $form = new serverNavigationForm();
      $form->getWidget('serverDn')->setDefault($p->getDn());

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
      $form->getWidget('serverDn')->setIdFormat(sprintf('%%s_%03d', $id));
      $form->getWidget('destination')->setIdFormat(sprintf('%%s_%03d', $id));

      $this->forms[$p->getDn()] = $form;
      $id++;
    }

    $this->new = new ServerNavigationForm();
    unset($this->new['serverDn'], $this->new['destination']);
  }
}
