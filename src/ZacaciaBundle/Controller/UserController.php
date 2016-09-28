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

use ZacaciaBundle\Entity\Alias;
use ZacaciaBundle\Entity\AliasPeer;

use ZacaciaBundle\Form\UserType;
use ZacaciaBundle\Form\ChangePwdType;
use ZacaciaBundle\Form\AliasType;

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
        $user->setPlatformId($platform->getEntryUUID());
        $user->setOrganizationId($organization->getEntryUUID());

        $form = $this->createForm(UserType::class, $user, array(
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
        $userLdap = $user_repository->getUserByUUID($userid);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');

        $tranformer = new ZacaciaTransformer();
        $user = $tranformer->transUser($userLdap, $platform, $organization);

        $form = $this->createForm(UserType::class, $user, array(
            'domain_choices' => $domain_repository->getAllDomainsAsChoice(),
         ));

        $form->remove('displayname');
        $form->remove('uid');
        $form->remove('userpassword');
        $form->remove('confpass');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{

                $userLdap->setSn($user->getSn());
                $userLdap->setGivenName($user->getGivenName());
                $userLdap->setMail(sprintf('%s@%s', $user->getEmail(), $user->getDomain()));

                $userLdap->setZarafaHidden($user->getZarafaHidden());
                $userLdap->setZarafaAccount($user->getZarafaAccount());
                $userLdap->setZacaciastatus($user->getZacaciastatus());

                $userPeer->updateUser($userLdap);

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
     * @Route("/user/{platformid}/{organizationid}/{userid}/alias/{action}/{alias}", name="_user_alias", 
     * defaults={ "action" = "list", "alias" = "none" },
     * requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "userid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function aliasAction(Request $request, $platformid, $organizationid, $userid, $action, $alias)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $userPeer = new AliasPeer($organization->getDn());
        $user_repository = $userPeer->getLdapManager()->getRepository('user');
        $userLdap = $user_repository->getUserByUUID($userid);

        $aliases = array();

        if ( $userLdap->has('zarafaAliases') ) {
            if ( ! is_array($userLdap->getZarafaAliases() ) ) {
                $aliases[] = $userLdap->getZarafaAliases();
            } else {
                $aliases = $userLdap->getZarafaAliases();
            }
        }

        switch($action) {
            case "remove":
                if( in_array($alias, $aliases) ) {
                    $key = array_search($alias, $aliases);
                    array_splice($aliases, $key, 1);
                    $aliases = array_unique($aliases);
                    $userLdap->setZarafaAliases($aliases);
                    $userPeer->updateAliases($userLdap);

                    return $this->redirectToRoute('_user_alias', array(
                      'platformid' => $platform->getEntryUUID(),
                      'organizationid' => $organization->getEntryUUID(),
                      'userid' => $userLdap->getEntryUUID(),
                      'action' => 'list'
                    ));
                }
            break;
        }

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');

        $tranformer = new ZacaciaTransformer();
        $user = $tranformer->transUser($userLdap, $platform, $organization);
        $user->setEmail('');

        $form = $this->createForm(AliasType::class, $user, array(
            'domain_choices' => $domain_repository->getAllDomainsAsChoice(),
         ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{
                $aliases[] = sprintf('%s@%s', $user->getEmail(), $user->getDomain());
                $aliases = array_unique($aliases);
                $userLdap->setZarafaAliases($aliases);
                $userPeer->updateAliases($userLdap);

                return $this->redirectToRoute('_user_alias', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                  'userid' => $userLdap->getEntryUUID(),
                  'action' => 'list'
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to add alias to user!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:User:alias.html.twig', array(
            'platform' => $platform,
            'organization' => $organization,
            'user' => $userLdap,
            'form' => $form->createView(),
            'aliases' => $aliases
        ));
    }

    /**
     * @Route("/user/{platformid}/{organizationid}/{userid}/password", name="_user_password", requirements={
     *     "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
     *     "userid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     * })
     */
    public function passwordAction(Request $request, $platformid, $organizationid, $userid)
    {
        $platform_repository = (new PlatformPeer())->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer = new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $userPeer = new UserPeer($organization->getDn());
        $user_repository = $userPeer->getLdapManager()->getRepository('user');
        $userLdap = $user_repository->getUserByUUID($userid);

        $domainPeer =  new DomainPeer($organization->getDn());
        $domain_repository = $domainPeer->getLdapManager()->getRepository('domain');

        $tranformer = new ZacaciaTransformer();
        $user = $tranformer->transUser($userLdap, $platform, $organization);
        # print_r( $user ); exit;

        $form = $this->createForm(ChangePwdType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            try{

                $userLdap->setuserPassword($user->getPassword());

                $userPeer->updateUser($userLdap);

                return $this->redirectToRoute('_user', array(
                  'platformid' => $platform->getEntryUUID(),
                  'organizationid' => $organization->getEntryUUID(),
                ));
            
            } catch (LdapConnectionException $e) {
                echo "Failed to update user!".PHP_EOL;
                echo $e->getMessage().PHP_EOL;
            }
        }

        return $this->render('ZacaciaBundle:User:password.html.twig', array(
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
            $userPeer = new UserPeer($organization->getDn());
            $userPeer->deleteUser($userid, true);
            
        } catch (LdapConnectionException $e) {
          echo "Failed to delete user!".PHP_EOL;
          echo $e->getMessage().PHP_EOL;
        }

        return $this->redirectToRoute('_user', array(
          'platformid' => $platform->getEntryUUID(),
          'organizationid' => $organization->getEntryUUID(),
        ));
    }
}
