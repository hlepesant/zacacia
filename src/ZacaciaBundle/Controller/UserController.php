<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
#use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;

use ZacaciaBundle\Entity\Organization;
use ZacaciaBundle\Entity\OrganizationPeer;

use ZacaciaBundle\Entity\Domain;
use ZacaciaBundle\Entity\DomainPeer;

use ZacaciaBundle\Entity\User;
use ZacaciaBundle\Entity\UserPeer;

class UserController extends Controller
{
    /**
     * @Route("/user/{platformid}/{organizationid}", name="_user", requirements={
		 *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $userPeer =  new UserPeer($organization->getDn());
        $user_repository = $userPeer->getLdapManager()->getRepository('user');
        $users = $user_repository->getAllUsers();

        return $this->render('ZacaciaBundle:User:index.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'users' => $users,
        ));
    }

    /**
     * @Route("/user/{platformid}/{organizationid}/new", name="_user_new", requirements={
     *    "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *    "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     * })
     */
    public function newAction(Request $request, $platformid, $organizationid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');

        $user = new User();
        $user->setZacaciastatus("enable");

        $form = $this->createFormBuilder($user)
            ->add('sn', TextType::class, array('label' => 'Surname'))
            ->add('givenname', TextType::class, array('label' => 'Givenname'))
            ->add('displayname', TextType::class, array('label' => 'Display Name'))
            ->add('email', TextType::class, array('label' => 'Email'))
            ->add('domain', ChoiceType::class, array(
              'label' => 'Domain',
              #'placeholder' => 'Choose a domain',
              'placeholder' => false,
              'choices' => $domain_repository->getAllDomainsAsChoice()
            ))
            ->add('username', TextType::class, array('label' => 'Username'))
            ->add('password', PasswordType::class, array('label' => 'Password'))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('zarafaaccount', ChoiceType::class, array(
                'label' => 'Account', 
                'choices' => array(
                    'Yes' => "1",
                    'No' => "0",
            )))
            ->add('zarafahidden', ChoiceType::class, array(
                'label' => 'Hidden', 
                'choices' => array(
                    'No' => "0",
                    'Yes' => "1",
            )))
            ->add('zarafaquotaoverride', ChoiceType::class, array(
                'label' => 'Override Quota', 
                'choices' => array(
                    'No' => "0",
                    'Yes' => "1",
            )))
            ->add('zarafaquotasoft', TextType::class, array('label' => 'Soft Quota'))
            ->add('zarafaquotawarn', TextType::class, array('label' => 'Warn Quota'))
            ->add('zarafaquotahard', TextType::class, array('label' => 'Hard Quota'))

            ->add('platform', HiddenType::class, array('data' => $platform->getEntryUUID()))
            ->add('organization', HiddenType::class, array('data' => $organization->getEntryUUID()))

            ->add('save', SubmitType::class, array('label' => 'Create User'))
            ->add('cancel', ButtonType::class, array('label' => 'Cancel'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $userPeer =  new UserPeer($organization->getDn());
                $userPeer->createUser($user);

                return $this->redirectToRoute('_user', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add server!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:User:new.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{platformid}/{organizationid}/{userid}/edit", name="_user_edit", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "userid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function editAction(Request $request, $platformid, $organizationid, $userid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $userPeer = new UserPeer($organization->getDn());
        $user_repository = $userPeer->getLdapManager()->getRepository('user');
        $user = $user_repository->getUserByUUID($userid);

        $form = $this->createFormBuilder($user)
            ->setAction($this->generateUrl('_user_edit', array(
              'platformid' => $platform->getEntryUUID(),
              'organizationid' => $organization->getEntryUUID(),
              'userid' => $user->getEntryUUID(),
            )))
            ->add('cn', TextType::class, array('label' => 'Name', 'attr' => array('readonly' => 'readonly')))
            ->add('zacaciastatus', ChoiceType::class, array(
                'label' => 'Status',
                'choices' => array(
                    'Enable' => 'enable',
                    'Disable' => 'disable',
            )))
            ->add('save', SubmitType::class, array('label' => 'Update User'))
            ->add('cancel', ButtonType::class, array('label' => 'Cancel'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $userPeer->updateUser($user);

                return $this->redirectToRoute('_user', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update user!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:User:edit.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/user/{platformid}/{organizationid}/{userid}/delete", name="_user_delete", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "userid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function deleteAction(Request $request, $platformid, $organizationid, $userid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        try {
            $userPeer =  new UserPeer($organization->getDn());
            $userPeer->deleteOrganization($userid, true);
            
        } catch (LdapConnectionException $e) {
          echo "Failed to delete user!".PHP_EOL;
          echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_user', array(
          'platform' => $platform->getEntryUUID(),
          'organization' => $organization->getEntryUUID(),
        ));
    }
}
