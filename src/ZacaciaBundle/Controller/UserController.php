<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\HttpFoundation\Request;

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
use ZacaciaBundle\Form\UserType;

use ZacaciaBundle\Form\DataTransformer\ZacaciaTransformer;

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
        $user->setPlatform( $platform->getEntryUUID() );
        $user->setOrganization( $organization->getEntryUUID() );

        $form = $this->createForm(UserType::class, $user, array(
#            'action' => $this->generateUrl('_user_new', array(
#                'platformid' => $platform->getEntryUUID(),
#                'organizationid' => $organization->getEntryUUID(),
#            )),
#            'method' => 'POST',
            'domain_choices' => $domain_repository->getAllDomainsAsChoice(),
         ));


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $userPeer = new UserPeer($organization->getDn());

                $user->setCn($user->getDisplayname());
                $user->setEmail(sprintf('%s@%s', $user->getEmail(), $user->getDomain()));

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
