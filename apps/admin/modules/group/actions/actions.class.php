<?php

/**
 * group actions.
 *
 * @package    zacacia
 * @subpackage group
 * @author     Hugues Lepesant
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class groupActions extends sfActions
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
          
        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
              sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
              echo fake_post($this, '@company', Array('holdingDn' => $holdingDn));
              exit;
        }
        
        $ldapPeer = new GroupPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);
        $this->groups = $ldapPeer->getGroups($companyDn);
        
        $id=0;
        $this->forms = array();
        foreach ($this->groups as $group) {

            $form = new GroupNavigationForm();
            $form->getWidget('platformDn')->setDefault($platformDn);
            $form->getWidget('companyDn')->setDefault($companyDn);
            $form->getWidget('groupDn')->setDefault($group->getDn());
            
            $form->getWidget('platformDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('companyDn')->setIdFormat(sprintf('%%s_%03d', $id));
            $form->getWidget('groupDn')->setIdFormat(sprintf('%%s_%03d', $id));
        
            $this->forms[$group->getDn()] = $form;
            $id++;
        }
        
        $this->new = new GroupNavigationForm();
        unset($this->new['groupDn']);
        $this->new->getWidget('platformDn')->setDefault($platformDn);
        $this->new->getWidget('companyDn')->setDefault($companyDn);
    }

    public function executeNew(sfWebRequest $request)
    {
        $data = $request->getParameter('zdata');

        $platformDn = $request->getParameter('platformDn', $data['platformDn']);
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn', $data['companyDn']);
        if ( empty($companyDn) ) {
            sfContext::getInstance()->getConfiguration()->loadHelpers('veePeeFakePost');
            echo fake_post($this, '@companies', Array('holdingDn' => $holdingDn));
            exit;
        }
        
        $ldapPeer = new GroupPeer();

        $this->platform = $ldapPeer->getPlatform($platformDn);
        $this->company = $ldapPeer->getCompany($companyDn);

        $this->form = new GroupForm();

        $this->form->getWidget('platformDn')->setDefault($platformDn);
        $this->form->getWidget('companyDn')->setDefault($companyDn);

        $domains = $ldapPeer->getDomainsAsOption($companyDn);
        $this->form->getWidget('domain')->setOption('choices', $domains );

        $users = $ldapPeer->getUsersAsOption($companyDn);
        $this->form->getWidget('member')->setOption('choices', $users);

        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->getValidator('domain')->setOption('choices', array_keys($domains));
            $this->form->getValidator('member')->setOption('choices', array_keys($users));

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

                $ldapPeer->setBaseDn(sprintf("ou=Groups,%s", $companyDn));

                $groupOfNames = new groupObject();
                $groupOfNames->setCn(sprintf("%s", $this->form->getValue('cn')));
                $groupOfNames->setDn(sprintf("cn=%s,%s", $groupOfNames->getCn(), $ldapPeer->getBaseDn()));
                $groupOfNames->setMember($this->form->getValue('member'));

                $groupOfNames->setZarafaAccount($this->form->getValue('zarafaAccount'));
                if ( $this->form->getValue('zarafaAccount') ) {
                    $groupOfNames->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));
                }

#                var_dump( $groupOfNames ); exit;

                if ( $ldapPeer->doAdd($groupOfNames) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'group/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

        $this->cancel = new GroupNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
        $this->cancel->getWidget('companyDn')->setDefault($companyDn);
    }

    public function executeStatus(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }

        $groupDn = $request->getParameter('groupDn');
        if ( empty($groupDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing group's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@groups', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($groupDn);

        $l = new GroupPeer();
        $group = $l->retrieveByDn($criteria);

        if ( 'enable' === $group->getZacaciaStatus()) {
            $group->setZacaciaStatus('disable');
        } else {
            $group->setZacaciaStatus('enable');
        }

        $l->doSave($group);

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@groups', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $platformDn = $request->getParameter('platformDn');
        if ( empty($platformDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing platform's DN.");
            $this->redirect('@platforms');
        }

        $companyDn = $request->getParameter('companyDn');
        if ( empty($companyDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing company's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@companies', Array('platformDn' => $platformDn));
        }

        $groupDn = $request->getParameter('groupDn');
        if ( empty($groupDn) ) {
            $this->getUser()->setFlash('zJsAlert', "Missing user's DN.");
            sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
            echo fake_post($this, '@groups', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        }

        $criteria = new LDAPCriteria();
        $criteria->setBaseDn($groupDn);

        $l = new GroupPeer();
        $group = $l->retrieveByDn($criteria);

        if ( 'disable' === $group->getZacaciaStatus()) {
            $l->doDelete($group, true);
        }

        sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
        echo fake_post($this, '@groups', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
        exit;
    }

/* WebServices */
    public function executeCheckcn(sfWebRequest $request)
    {
        $this->setTemplate('check');
        $this->setLayout(false);
        $this->exist = 0;

        if ( ! $request->hasParameter('companyDn') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        if ( ! $request->hasParameter('name') ) {
            $this->exist = 1;
            return sfView::SUCCESS;
        }

        $ldapPeer = new GroupPeer();
        $this->exist = $ldapPeer->doCheckCn($request->getParameter('companyDn'), $request->getParameter('name'));

        return sfView::SUCCESS;
    }
}
