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

//use ZacaciaBundle\Entity\Platform;
use ZacaciaBundle\Entity\PlatformPeer;
use ZacaciaBundle\Entity\ServerPeer;

/**
 * @Route("/api")
 */

class ApiController extends Controller
{
    /**
     * @Route("/check/platform/{name}", name="_check_platform", requirements={
		"name": "[a-zA-Z0-9\s\_\-]+"
     })
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
		"name": "[a-zA-Z0-9\s\_\-\.]+"
     })
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
		"ip": "[0-9.]+"
     })
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
}
