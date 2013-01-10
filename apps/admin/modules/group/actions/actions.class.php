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
        
            $this->forms[$user->getDn()] = $form;
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
    
        if ($request->isMethod('post') && $request->getParameter('zdata')) {

            $this->form->bind($request->getParameter('zdata'));
            
            if ($this->form->isValid()) {

                print_r( $_POST );

                $ldapPeer->setBaseDn(sprintf("ou=Groups,%s", $companyDn));

                $groupOfNames = new groupObject();
                $groupOfNames->setCn(sprintf("%s", $this->form->getValue('cn')));
                $groupOfNames->setDn(sprintf("cn=%s,%s", $userAccount->getCn(), $ldapPeer->getBaseDn()));
                $groupOfNames->setGivenName($this->form->getValue('givenName'));
                $groupOfNames->setSn($this->form->getValue('sn'));
                $groupOfNames->setDisplayName($this->form->getValue('displayName'));

                $groupOfNames->setUid($this->form->getValue('uid'));
                $groupOfNames->setUserPassword($this->form->getValue('userPassword'));
                $groupOfNames->setUidNumber($ldapPeer->getNewUidNumber());
                $groupOfNames->setGidNumber($this->company->getGidNumber());

                $groupOfNames->setZarafaAccount($this->form->getValue('zarafaAccount'));
                $groupOfNames->setEmailAddress( sprintf("%s@%s", $this->form->getValue('mail'), $this->form->getValue('domain')));

                var_dump( $groupOfNames ); exit;

                if ( $ldapPeer->doAdd($groupOfNames) ) {
                    sfContext::getInstance()->getConfiguration()->loadHelpers('fakePost');
                    echo fake_post($this, 'group/index', Array('platformDn' => $platformDn, 'companyDn' => $companyDn));
                    exit;
                }
            }
        }

        $this->form->getWidget('domain')->setOption('choices', $ldapPeer->getDomainsAsOption($companyDn));
        $this->form->getWidget('member')->setOption('choices', $ldapPeer->getUsersAsOption($companyDn));

        $this->cancel = new UserNavigationForm();
        unset($this->cancel['userDn']);
        $this->cancel->getWidget('platformDn')->setDefault($platformDn);
        $this->cancel->getWidget('companyDn')->setDefault($companyDn);
    }
}
