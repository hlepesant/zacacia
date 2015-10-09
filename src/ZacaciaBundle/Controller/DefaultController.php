<?php

namespace ZacaciaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
    * @Route("/", name = "zacacia_homepage")
    */
    public function indexAction()
    {
        return $this->render('ZacaciaBundle:Default:index.html.twig');
    }

    /**
    * Lists all Platform entities.
    *
    * @Route("/platform", name="platform")
    * @Route("/platform/{cn}", name="platform_edit")
    */
    public function platformAction($cn=null)
    {
        if ( is_null($cn) )
            return $this->render('ZacaciaBundle:Default:platform/index.html.twig');
        else
            return $this->render('ZacaciaBundle:Default:platform/edit.html.twig');
    }
    
    /**
    * Add Platform entity.
    *
    * @Route("/platform/new", name="platform_new")
    */
    public function platformnewAction()
    {
        return $this->render('ZacaciaBundle:Default:platform/new.html.twig');
    }
}
