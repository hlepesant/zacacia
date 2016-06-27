<?php

namespace ZacaciaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class CustomerController extends Controller
{
    /**
     * @Route("/customer/{platform}", name="_customer", requirements={
		"platform": "([a-z0-9]{8})(\-[a-z0-9]{4}){3}(\-[a-z0-9]{12})"
     })
     * @Method({"GET","HEAD"})
     */
    public function indexAction()
    {
        return $this->render('ZacaciaBundle:Customer:index.html.twig', array(
            // ...
        ));
    }

}
