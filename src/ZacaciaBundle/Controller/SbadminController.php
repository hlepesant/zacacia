<?php

namespace ZacaciaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SbadminController extends Controller
{
    /**
    * @Route("/template")
    */
    public function indexAction()
    {
        return $this->render('ZacaciaBundle:Sbadmin:index.html.twig');
    }
}
