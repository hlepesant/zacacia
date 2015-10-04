<?php

namespace ZacaciaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
    * @Route("/", name = "zacacia_homepage")
    */
    public function indexAction()
    {
        return $this->render('ZacaciaBundle:Default:index.html.twig');
    }
}
