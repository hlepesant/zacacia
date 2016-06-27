<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ServerController extends Controller
{
    /**
     * @Route("/server/{platform}", name="_server", requirements={
		"platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     })
     */
    public function indexAction()
    {
        return $this->render('ZacaciaBundle:Server:index.html.twig', array(
            // ...
        ));
    }

}
