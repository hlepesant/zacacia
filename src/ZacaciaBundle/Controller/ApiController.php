<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use LdapTools\Configuration;
use LdapTools\LdapManager;
use LdapTools\Query\LdapQueryBuilder;

use ZacaciaBundle\Entity\PlatformPeer;
use ZacaciaBundle\Entity\ServerPeer;
use ZacaciaBundle\Entity\OrganizationPeer;
use ZacaciaBundle\Entity\DomainPeer;
use ZacaciaBundle\Entity\UserPeer;

/**
 * @Route("/api")
 */

class ApiController extends Controller
{
    /**
     * @Route("/check/platform/{name}", name="_check_platform", requirements={
		 *   "name": "[a-zA-Z0-9\s\_\-]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkplatformAction(Request $request, $name)
    {
        $ldapPeer = new PlatformPeer();
        $platforms = $ldapPeer->getLdapManager()->getRepository('platform')->getPlatformByName($name);

        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($platforms)
    	));

    	return $response;
    }

    /**
     * @Route("/check/server/{name}", name="_check_server", requirements={
		 *   "name": "[a-zA-Z0-9\s\_\-\.]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkserverAction(Request $request, $name)
    {
        $platformPeer = new PlatformPeer();

        $base_dn = $platformPeer->getConfig()->getDomainConfiguration(
            $platformPeer->getConfig()->getDefaultDomain()
        )->getBaseDn();

        $serverPeer =  new ServerPeer($base_dn);
        $servers = $serverPeer->getLdapManager()->getRepository('server')->getServerByName($name);

        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($servers)
    	));

    	return $response;
    }

    /**
     * @Route("/check/serverip/{ip}", name="_check_serverip", requirements={
		 *   "ip": "[0-9.]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkserveripAction(Request $request, $ip)
    {
        $platformPeer = new PlatformPeer();

        $base_dn = $platformPeer->getConfig()->getDomainConfiguration(
            $platformPeer->getConfig()->getDefaultDomain()
        )->getBaseDn();

        $serverPeer =  new ServerPeer($base_dn);
        $servers = $serverPeer->getLdapManager()->getRepository('server')->getServerByIpAddress($ip);

        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($servers)
    	));

    	return $response;
    }

    /**
     * @Route("/check/organization/{platform}/{name}", name="_check_organization", requirements={
		 *   "platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *   "name": "[a-zA-Z0-9\s\_\-\+]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkorganizationAction(Request $request, $platform, $name)
    {
        $platformPeer = new PlatformPeer();

        $base_dn = $platformPeer->getConfig()->getDomainConfiguration(
            $platformPeer->getConfig()->getDefaultDomain()
        )->getBaseDn();

        $organizationPeer =  new OrganizationPeer($base_dn);
        $organizations = $organizationPeer->getLdapManager()->getRepository('organization')->getOrganizationByName($name);

        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($organizations)
    	));

    	return $response;
    }

    /**
     * @Route("/check/domain/{name}", name="_check_domain", requirements={
		 *     "name": "[a-zA-Z0-9\-\.]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkdomainAction(Request $request, $name)
    {
        $platformPeer = new PlatformPeer();

        $base_dn = $platformPeer->getConfig()->getDomainConfiguration(
            $platformPeer->getConfig()->getDefaultDomain()
        )->getBaseDn();

        $domainPeer =  new DomainPeer($base_dn);
        $domains = $domainPeer->getLdapManager()->getRepository('domain')->getDomainByName($name);

        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($domains)
    	));

    	return $response;
    }

    /**
     * @Route("/check/username/{platformid}/{organizationid}/{name}", name="_check_username", requirements={
		 *   "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *   "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *   "name": "[a-zA-Z0-9\-\.]+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkusernameAction(Request $request, $platformid, $organizationid, $name)
    {
        $platformPeer = new PlatformPeer();
        $platform_repository = $platformPeer->getLdapManager()->getRepository('platform');
        $platform = $platform_repository->getPlatformByUUID($platformid);

        $organizationPeer =  new OrganizationPeer($platform->getDn());
        $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
        $organization = $organization_repository->getOrganizationByUUID($organizationid);

        $base_dn = sprintf('ou=Users,%s', $organization->getDn());

        $userPeer =  new UserPeer($base_dn);
        $users = $userPeer->getLdapManager()->getRepository('user')->getUserByUsername($name);


        $response = new JsonResponse();

        $response->setData(array(
        	'data' => count($users)
    	));

    	return $response;
    }

    /**
     * @Route("/check/displayname/{platformid}/{organizationid}/{name}", name="_check_displayname", requirements={
		 *   "platformid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *   "organizationid": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})",
		 *   "name": ".+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkdisplaynameAction(Request $request, $platformid, $organizationid, $name)
    {
      $platformPeer = new PlatformPeer();
      $platform_repository = $platformPeer->getLdapManager()->getRepository('platform');
      $platform = $platform_repository->getPlatformByUUID($platformid);

      $organizationPeer =  new OrganizationPeer($platform->getDn());
      $organization_repository = $organizationPeer->getLdapManager()->getRepository('organization');
      $organization = $organization_repository->getOrganizationByUUID($organizationid);

      $base_dn = sprintf('ou=Users,%s', $organization->getDn());
      
      #$name = $request->attributes->get('name');

      $userPeer =  new UserPeer($base_dn);
      $users = $userPeer->getLdapManager()->getRepository('user')->getUserByDisplayname($name);


      $response = new JsonResponse();

      $response->setData(array(
      	'data' => count($users)
    	));

    	return $response;
    }

    /**
     * @Route("/check/useremail/{email}", name="_check_useremail", requirements={
		 *   "email": ".+"
     * })
     * @Method({"GET","HEAD"})
     */
    public function checkuseremailAction(Request $request, $email)
    {
        $config = (new Configuration())->load(__DIR__."/../Resources/config/zacacia.yml");
        $ldapmanager = new LdapManager($config);
        $default_domain = $config->getDefaultDomain();
        $domain_config = $config->getDomainConfiguration($default_domain);
        $base_dn = $domain_config->getBaseDn();

        $userPeer = new UserPeer($base_dn);

        $emails = $userPeer->getLdapManager()->getRepository('user')->getUserByEmail($email);
        
        $response = new JsonResponse();
        
        $response->setData(array(
        	'data' => count($emails)
          ));
        
          return $response;
    }
}
