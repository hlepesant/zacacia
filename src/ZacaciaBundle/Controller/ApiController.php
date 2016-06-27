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

}
